<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('is_logged_in')) {
            redirect('auth');
        }
        $this->load->model('Pengajuan_model');
    }

    public function index()
    {
        $tanggal_mulai = $this->input->get('tanggal_mulai');
        $tanggal_sampai = $this->input->get('tanggal_sampai');
        $keyword = $this->input->get('keyword');

        if ($tanggal_mulai && $tanggal_sampai) {
            $data['pengajuan'] = $this->Pengajuan_model->get_filtered_by_date($tanggal_mulai, $tanggal_sampai, $keyword);
        } elseif ($keyword) {
            $data['pengajuan'] = $this->Pengajuan_model->get_all($keyword);
        } else {
            $data['pengajuan'] = $this->Pengajuan_model->get_all();
        }

        $data['title'] = 'Pengajuan Aset';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('pengajuan/index', $data); // Pastikan view ini mengakses properti yang benar
        $this->load->view('templates/footer');
    }

    public function add()
    {
        $data['title'] = 'Tambah Pengajuan Aset';
        $data['action'] = base_url('pengajuan/insert');
        $data['cabang'] = $this->db->get('cabang')->result();

        // Ambil nomor_form terakhir
        $last = $this->db->select('nomor_form')->order_by('id', 'DESC')->get('input_pengajuan')->row();
        if ($last) {
            $last_num = (int) str_replace('FORM-', '', $last->nomor_form);
            $data['next_nomor_form'] = 'FORM-' . str_pad($last_num + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $data['next_nomor_form'] = 'FORM-0001';
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('pengajuan/form', $data);
        $this->load->view('templates/footer');
    }

    public function insert()
    {
        $data_input_pengajuan = [
            'id_cabang' => $this->input->post('id_cabang'),
            'nomor_form' => $this->input->post('nomor_form'),
            'tanggal_form' => $this->input->post('tanggal_form'),
            'kode_aset' => $this->input->post('kode_aset'),
            'nama_aset' => $this->input->post('nama_aset'),
            'quantity_aset' => $this->input->post('quantity_aset'),
            'estimasi_harga' => $this->input->post('estimasi_harga'),
            'keterangan' => $this->input->post('keterangan'),
        ];

        $this->Pengajuan_model->insert($data_input_pengajuan);
        $id_pengajuan = $this->db->insert_id();

        // Langsung masukkan ke daftar_pengajuan dengan status default
        $this->db->insert('daftar_pengajuan', [
            'id_pengajuan' => $id_pengajuan,
            'status' => 'Draft', // Status awal: Draft (belum disubmit)
            'status_kacab' => 'pending',
            'status_am' => 'pending',
            'status_ho' => 'pending',
            'tanggal_dibuat' => date('Y-m-d H:i:s')
        ]);
        $this->session->set_flashdata('success', 'Pengajuan aset berhasil ditambahkan.');
        redirect('pengajuan');
    }


    public function edit($id)
    {
        $data['title'] = 'Edit Pengajuan Aset';
        $data['action'] = base_url('pengajuan/update/' . $id);
        $data['pengajuan'] = $this->Pengajuan_model->get_by_id($id);
        $data['cabang'] = $this->db->get('cabang')->result();

        if (!$data['pengajuan']) {
            $this->session->set_flashdata('error', 'Data pengajuan tidak ditemukan.');
            redirect('pengajuan');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('pengajuan/form', $data);
        $this->load->view('templates/footer');
    }

    public function update($id)
    {
        $data_input_pengajuan = [
            'id_cabang' => $this->input->post('id_cabang'),
            'nomor_form' => $this->input->post('nomor_form'),
            'tanggal_form' => $this->input->post('tanggal_form'),
            'kode_aset' => $this->input->post('kode_aset'),
            'nama_aset' => $this->input->post('nama_aset'),
            'quantity_aset' => $this->input->post('quantity_aset'),
            'estimasi_harga' => $this->input->post('estimasi_harga'),
            'keterangan' => $this->input->post('keterangan')
        ];

        $this->Pengajuan_model->update($id, $data_input_pengajuan);
        $this->session->set_flashdata('success', 'Data pengajuan berhasil diperbarui.');
        redirect('pengajuan');
    }

    public function delete($id)
    {
        $pengajuan = $this->Pengajuan_model->get_by_id($id); // Ambil data lengkap

        // Jika data tidak ditemukan
        if (!$pengajuan) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan.');
            redirect('pengajuan');
        }

        // Periksa status pengajuan dari daftar_pengajuan
        // (Diasumsikan get_by_id sudah me-JOIN daftar_pengajuan dan memiliki 'overall_status')
        if ($pengajuan->overall_status !== 'Draft') {
            $this->session->set_flashdata('error', 'Pengajuan tidak dapat dihapus karena sudah disubmit atau diproses.');
            redirect('pengajuan');
        }

        // Jika masih Draft, lanjut hapus. Model sudah menangani penghapusan di kedua tabel.
        $this->Pengajuan_model->delete($id);
        $this->session->set_flashdata('success', 'Pengajuan berhasil dihapus.');
        redirect('pengajuan');
    }

    // Bagian dari Pengajuan Controller Anda

    public function submit($id)
    {
        // Ambil data status dari daftar_pengajuan
        $status_data = $this->db->get_where('daftar_pengajuan', ['id_pengajuan' => $id])->row();

        if ($status_data && $status_data->status === 'Draft') { // <-- KONDISI INI
            // Update status di daftar_pengajuan menjadi 'Submitted'
            $this->db->where('id_pengajuan', $id)->update('daftar_pengajuan', [
                'status' => 'Submitted',
                'tanggal_dibuat' => date('Y-m-d H:i:s') // Update tanggal submit
            ]);
            $this->session->set_flashdata('success', 'Pengajuan berhasil disubmit.');
            redirect('pengajuan'); // Redirect ke daftar pengajuan utama
        } else {
            $this->session->set_flashdata('error', 'Pengajuan tidak dapat disubmit (mungkin tidak ditemukan atau sudah disubmit).');
            redirect('pengajuan');
        }
    }

    public function update_approval($id)
    {
        $role = $this->session->userdata('role'); // Contoh: kacab, am, ho
        $status = $this->input->post('status'); // 'approved' atau 'rejected'

        // Pastikan peran valid
        $valid_roles = ['kacab', 'am', 'ho'];
        if (!in_array($role, $valid_roles)) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
            redirect('pengajuan');
        }

        // Panggil fungsi update_approval di model
        $this->Pengajuan_model->update_approval($id, $role, $status);

        // Logika untuk mengubah status 'utama' pengajuan (opsional, bisa juga di model)
        $current_statuses = $this->db->get_where('daftar_pengajuan', ['id_pengajuan' => $id])->row();
        if ($current_statuses) {
            if ($current_statuses->status_kacab === 'rejected' || $current_statuses->status_am === 'rejected' || $current_statuses->status_ho === 'rejected') {
                $this->db->where('id_pengajuan', $id)->update('daftar_pengajuan', ['status' => 'Rejected']);
            } elseif ($current_statuses->status_kacab === 'approved' && $current_statuses->status_am === 'approved' && $current_statuses->status_ho === 'approved') {
                $this->db->where('id_pengajuan', $id)->update('daftar_pengajuan', ['status' => 'Approved']);
            }
        }

        $this->session->set_flashdata('success', 'Status approval berhasil diperbarui.');
        redirect('pengajuan');
    }
}

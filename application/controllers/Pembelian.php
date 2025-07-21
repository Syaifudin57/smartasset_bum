<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $allowed_roles = ['admin', 'am', 'kacab', 'ho']; // sesuaikan dengan role di sistemmu
        if (!in_array($this->session->userdata('role'), $allowed_roles)) {
            show_error('Akses ditolak.'); // atau redirect ke dashboard
        }

        $this->load->model('Pembelian_model');
        $this->load->model('Pengajuan_model');
    }

    // 1. Menampilkan daftar pengajuan yang sudah disetujui semua level
    public function index()
    {
        $data['title'] = 'Form Pembelian';
        $data['pengajuan'] = $this->Pengajuan_model->get_approved_pengajuan();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pembelian/index', $data);
        $this->load->view('templates/footer');
    }

    // 2. Menampilkan form input pembelian
    public function form($id_pengajuan)
    {
        $data['pengajuan'] = $this->Pengajuan_model->get_by_id($id_pengajuan);
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('pembelian/form', $data);
        $this->load->view('templates/footer');
    }

    // 3. Menyimpan data pembelian
    public function simpan()
    {
        $id_pengajuan = $this->input->post('id_pengajuan');
        $bukti_nota = null;
        $foto_barang = null;

        $upload_path = './uploads/bukti_pembelian/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $this->load->library('upload');

        // Upload nota
        if (!empty($_FILES['nota']['name'])) {
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['file_name'] = time() . '_nota';
            $this->upload->initialize($config);
            if ($this->upload->do_upload('nota')) {
                $bukti_nota = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', 'Upload nota gagal: ' . $this->upload->display_errors());
                redirect('pembelian/form/' . $id_pengajuan);
            }
        }

        // Upload foto barang
        if (!empty($_FILES['foto_barang']['name'])) {
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name'] = time() . '_barang';
            $this->upload->initialize($config);
            if ($this->upload->do_upload('foto_barang')) {
                $foto_barang = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', 'Upload foto barang gagal: ' . $this->upload->display_errors());
                redirect('pembelian/form/' . $id_pengajuan);
            }
        }

        $data = [
            'id_pengajuan' => $id_pengajuan,
            'no_pembelian' => $this->input->post('no_pembelian'),
            'tanggal_pembelian' => $this->input->post('tanggal_pembelian'),
            'vendor' => $this->input->post('vendor'),
            'nilai_realisasi' => $this->input->post('nilai_realisasi'),
            'bukti_nota' => $bukti_nota,
            'foto_barang' => $foto_barang
        ];

        $this->Pembelian_model->insert($data);

        $this->session->set_flashdata('success', 'Data pembelian berhasil disimpan.');
        redirect('pembelian');
    }

    public function daftar()
    {
        $data['title'] = 'Daftar Pembelian';
        $data['pembelian'] = $this->Pembelian_model->get_all();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);

        $this->load->view('pembelian/daftar', $data);
        $this->load->view('templates/footer');
    }

    public function export_excel()
    {
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=pembelian_" . date('Y-m-d') . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['pembelian'] = $this->Pembelian_model->get_all_with_pengajuan(); // pastikan fungsi ini ada
        $this->load->view('pembelian/export_excel', $data);
    }


    public function export_pdf()
    {
        $this->load->library('pdf');
        $data['pembelian'] = $this->Pembelian_model->get_all_with_pengajuan();

        $html = $this->load->view('pembelian/export_pdf', $data, true);
        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->render();
        $this->pdf->stream("laporan_pembelian_" . date('Ymd') . ".pdf", array("Attachment" => false));
    }
}

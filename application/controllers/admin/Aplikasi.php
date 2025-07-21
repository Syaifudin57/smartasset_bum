<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Aplikasi extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_model');
        //$this->load->library('licensing');
        //$this->licensing->check_license();
        if (!$this->session->userdata('level')) {
            $this->session->set_flashdata('pesan', 'Anda harus masuk terlebih dahulu!');
            redirect('home');
        } elseif ($this->session->userdata('level') != 'Administrator') {
            redirect('home');
        }
    }


    public function index()
    {
        $data['title']      = 'Tentang Aplikasi';
        $data['subtitle']   = 'Atur aplikasi anda disini';


        $data['collapse']   = 'No';

        $data['aplikasi'] = $this->m_model->get_desc('tb_aplikasi')->row_array();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/aplikasi');
        $this->load->view('admin/templates/footer');
    }

    public function update($id)
    {
        $nama   = $this->input->post('nama');
        $email  = $this->input->post('email');
        $telp   = $this->input->post('telp');
        $alamat = $this->input->post('alamat');

        $where = ['id' => $id];
        $data  = [
            'nama'   => $nama,
            'email'  => $email,
            'telp'   => $telp,
            'alamat' => $alamat
        ];

        // Proses upload logo jika ada
        if (!empty($_FILES['logo']['name'])) {
            $config['upload_path']   = './assets/logo/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name']     = 'Logo-' . time();
            $config['max_size']      = 5120; // 5MB

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('logo')) {
                $uploadData = $this->upload->data();
                $data['logo'] = $uploadData['file_name']; // masukkan nama file ke DB
            } else {
                $this->session->set_flashdata('pesanError', 'Logo gagal diupload: ' . $this->upload->display_errors('', ''));
                redirect('admin/aplikasi');
                return;
            }
        }

        // Update ke database
        $this->m_model->update($where, $data, 'tb_aplikasi');
        $this->session->set_flashdata('pesan', 'Pengaturan aplikasi berhasil diperbarui.');
        redirect('admin/aplikasi');
    }



    public function delete_logo($id)
    {
        $where = array('id' => $id);
        $data = array('logo' => '');


        $this->m_model->update($where, $data, 'tb_aplikasi');
        $this->session->set_flashdata('pesan', 'Logo berhasil dihapus!');
        redirect('admin/aplikasi');
    }
}

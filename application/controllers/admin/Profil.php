<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Profil extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_model');
        // $this->load->library('licensing');
        // $this->licensing->check_license();
        if (!$this->session->userdata('level')) {
            $this->session->set_flashdata('pesan', 'Anda harus masuk terlebih dahulu!');
            redirect('home');
        }
    }


    public function index()
    {
        $data['title']      = 'Profil';
        $data['subtitle']   = 'Atur profil anda disini';


        $data['collapse']   = 'No';

        $this->db->limit('20');
        $this->db->where('idUser', $this->session->userdata('id'));
        $this->db->order_by('id', 'DESC');
        $data['log']        = $this->db->get('tb_log');

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/profil');
        $this->load->view('admin/templates/footer');
    }

    public function update($id)
    {
        $nama         = $this->input->post('nama');
        $jenisKelamin = $this->input->post('jenisKelamin');
        $telp         = $this->input->post('telp');
        $email        = $this->input->post('email');
        $alamat       = $this->input->post('alamat');
        $username     = $this->input->post('username');
        $password     = $this->input->post('password');
        $skin         = $this->input->post('skin');

        // Cek apakah ada file foto diupload
        $foto_baru = '';
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path']   = './assets/profil/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name']     = 'Profil-' . time();
            $config['max_size']      = 2048;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $foto_baru = $this->upload->data('file_name');
            }
        }

        // Cek username lama
        $username_lama = $this->db->get_where('tb_user', ['id' => $id])->row()->username;

        // Cek apakah username diganti
        if ($username !== $username_lama) {
            $cek = $this->db->get_where('tb_user', ['username' => $username]);
            if ($cek->num_rows() > 0) {
                $this->session->set_flashdata('pesanError', 'Username tidak tersedia!');
                redirect('admin/profil');
            }
        }

        // Susun data update
        $data = [
            'nama'         => $nama,
            'jenisKelamin' => $jenisKelamin,
            'alamat'       => $alamat,
            'telp'         => $telp,
            'email'        => $email,
            'username'     => $username,
            'skin'         => $skin,
        ];

        // Tambahkan password jika diisi
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
        }

        // Tambahkan foto jika diupload
        if (!empty($foto_baru)) {
            $data['foto'] = $foto_baru;
        }

        // Lakukan update
        $this->m_model->update(['id' => $id], $data, 'tb_user');

        // Refresh session userdata
        foreach ($data as $key => $value) {
            $this->session->set_userdata($key, $value);
        }

        $this->session->set_flashdata('pesan', 'Profil berhasil diubah!');
        redirect('admin/profil');
    }
}

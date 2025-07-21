<?php
// File: application/controllers/User.php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = 'Manajemen User';
        $data['users'] = $this->User_model->get_all();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function add()
    {
        // Pastikan ini ada sebelum load view
        $data = [
            'title' => 'Tambah User',
            'action' => site_url('user/simpan'), // ini penting agar $action tidak undefined
            'user' => (object)[
                'id_user' => '',
                'nama' => '',
                'username' => '',
                'password' => '',
                'role' => ''
            ],
            'button' => 'Simpan'
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('user/form', $data);
        $this->load->view('templates/footer');
    }


    public function edit($id)
    {
        $user = $this->User_model->getById($id);
        if (!$user) {
            show_404();
        }

        $data = [
            'title' => 'Edit User',
            'action' => site_url('user/update/' . $id),
            'user' => $user,
            'button' => 'Update'
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('user/form', $data);
        $this->load->view('templates/footer');
    }


    public function delete($id)
    {
        $this->User_model->delete($id);
        $this->session->set_flashdata('success', 'User berhasil dihapus.');
        redirect('user');
    }

    private function _rules($edit = false)
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        if (!$edit || ($edit && $this->input->post('password'))) {
            $this->form_validation->set_rules('password', 'Password', 'min_length[4]');
        }
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');
    }

    public function simpan()
    {
        $data = [
            'username' => $this->input->post('username'),
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'name' => $this->input->post('name'),
            'role' => $this->input->post('role'),
            'is_active' => 1
        ];
        $this->session->set_flashdata('success', 'Data user berhasil disimpan.');
        redirect('user');

        $this->User_model->insert($data);
        redirect('user');
    }

    public function update($id)
    {
        $data = [
            'username' => $this->input->post('username'),
            'name' => $this->input->post('name'),
            'role' => $this->input->post('role'),
            'is_active' => $this->input->post('is_active')
        ];

        // Optional: update password jika diisi
        if ($this->input->post('password')) {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        }

        $this->User_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data user berhasil diperbarui.');
        redirect('user');
    }
}

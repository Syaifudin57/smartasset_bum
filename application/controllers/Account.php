<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('is_logged_in')) {
            redirect('auth');
        }
        $this->load->model('User_model');
        $this->load->helper(['form', 'url']);
        $this->load->library('upload');
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');

        if (!$user_id) {
            redirect('auth');
        }

        $user = $this->User_model->get_by_id($user_id);

        if (!$user) {
            show_error('Data user tidak ditemukan di database.');
            return;
        }

        $data = [
            'title' => 'Pengaturan Akun',
            'user' => $user
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('account/index', $data);
        $this->load->view('templates/footer');
    }



    public function update()
    {
        $id_user = $this->session->userdata('user_id');
        $user = $this->User_model->get_user_by_id($id_user);

        $data = [
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email')
        ];

        // ✅ Update session nama agar header ikut berubah
        $this->session->set_userdata('nama', $data['name']);

        $password = $this->input->post('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Upload foto jika ada
        if (!empty($_FILES['photo']['name'])) {
            $config['upload_path']   = './assets/uploads/profile/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 2048;
            $config['file_name']     = 'profile_' . time();

            $this->upload->initialize($config);

            if ($this->upload->do_upload('photo')) {
                // Hapus foto lama
                if ($user->photo && file_exists('./assets/uploads/profile/' . $user->photo)) {
                    unlink('./assets/uploads/profile/' . $user->photo);
                }

                $upload_data = $this->upload->data();
                $data['photo'] = $upload_data['file_name'];

                // ✅ Update session foto agar header ikut berubah
                $this->session->set_userdata('foto', $upload_data['file_name']);
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('account');
                return;
            }
        }

        // Simpan perubahan
        $this->User_model->update_profile($id_user, $data);
        $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
        redirect('account');
    }
}

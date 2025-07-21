<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    protected $data = array(); // Untuk menyimpan data yang akan dikirim ke view

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pengajuan_model');
        $this->load->library('session'); // Pastikan session library dimuat

        // Dapatkan role pengguna yang sedang login
        $user_role = $this->session->userdata('role'); // Sesuaikan dengan nama session role Anda

        // Inisialisasi data notifikasi
        $this->data['pending_approvals_count'] = 0;
        $this->data['pending_approvals_list'] = [];

        // Ambil data pending approval berdasarkan role
        if ($user_role === 'kacab') { // Contoh role: kacab
            $this->data['pending_approvals_count'] = $this->Pengajuan_model->count_pending_kacab_approvals();
            $this->data['pending_approvals_list'] = $this->Pengajuan_model->get_pending_kacab_approvals();
        } elseif ($user_role === 'am') { // Contoh role: am (Area Manager)
            $this->data['pending_approvals_count'] = $this->Pengajuan_model->count_pending_am_approvals();
            $this->data['pending_approvals_list'] = $this->Pengajuan_model->get_pending_am_approvals();
        } elseif ($user_role === 'ho') { // Contoh role: ho (Head Office)
            $this->data['pending_approvals_count'] = $this->Pengajuan_model->count_pending_ho_approvals();
            $this->data['pending_approvals_list'] = $this->Pengajuan_model->get_pending_ho_approvals();
        }
        // Jika ada role lain yang perlu notifikasi, tambahkan di sini

        // Jika Anda memuat template (header/sidebar/footer) di setiap controller:
        // Pastikan Anda meneruskan $this->data ke view tersebut.
        // Contoh: $this->load->view('templates/header', $this->data);
    }
}

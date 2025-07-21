<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Daftarpengajuan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pengajuan_model');
        if (!$this->session->userdata('is_logged_in')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Daftar Pengajuan Aset';
        $data['pengajuan'] = $this->Pengajuan_model->get_all_submitted(); // harus ambil kolom `status`
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('daftar_pengajuan/index', $data);
        $this->load->view('templates/footer');
    }


    public function approve($role, $id)
    {
        $field = 'status_' . $role;
        if (!in_array($field, ['status_kacab', 'status_am', 'status_ho'])) show_404();

        $this->Pengajuan_model->update_status($id, $field, 'approved');
        $this->session->set_flashdata('success', 'Pengajuan disetujui oleh ' . strtoupper($role));
        redirect('daftarpengajuan');
    }

    public function reject($role, $id)
    {
        $field = 'status_' . $role;
        if (!in_array($field, ['status_kacab', 'status_am', 'status_ho'])) show_404();

        $this->Pengajuan_model->update_status($id, $field, 'rejected');
        $this->session->set_flashdata('success', 'Pengajuan ditolak oleh ' . strtoupper($role));
        redirect('daftarpengajuan');
    }
}

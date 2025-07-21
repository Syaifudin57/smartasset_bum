<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('is_logged_in')) {
            redirect('auth');
        }
        $this->load->model('Pembelian_model');
    }

    public function export_excel()
    {
        $data['result'] = $this->Pembelian_model->get_all();

        $nama_file = "laporan_pembelian_" . date('Ymd');
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=" . $nama_file . ".xls");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);

        $this->load->view('laporan/export_excel', $data);
    }
}

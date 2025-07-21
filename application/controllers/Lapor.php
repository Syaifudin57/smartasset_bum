<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lapor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('is_logged_in')) {
            redirect('auth');
        }
        $this->load->model('Laporan_model');
        $this->load->library('pdf'); // pastikan dompdf sudah disetup
    }

    public function index()
    {
        $data['title'] = 'Laporan Pengajuan';

        $mulai = $this->input->get('mulai');
        $sampai = $this->input->get('sampai');

        // Default ke 30 hari terakhir jika kosong
        if (!$mulai || !$sampai) {
            $sampai = date('Y-m-d');
            $mulai = date('Y-m-d', strtotime('-30 days'));
        }

        $data['mulai'] = $mulai;
        $data['sampai'] = $sampai;
        $data['pengajuan'] = $this->Laporan_model->get_filtered($mulai, $sampai);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('laporan/index', $data);
        $this->load->view('templates/footer');
    }

    public function export_excel()
    {
        $mulai = $this->input->get('mulai');
        $sampai = $this->input->get('sampai');

        $data['pengajuan'] = $this->Laporan_model->get_filtered($mulai, $sampai);
        $this->load->view('laporan/export_excel2', $data);
    }

    public function export_pdf()
    {
        $mulai = $this->input->get('mulai');
        $sampai = $this->input->get('sampai');

        $data['pengajuan'] = $this->Laporan_model->get_filtered($mulai, $sampai);
        $data['mulai'] = $mulai;
        $data['sampai'] = $sampai;

        $html = $this->load->view('laporan/export_pdf', $data, true);

        $this->pdf->load_html($html);
        $this->pdf->set_paper('A4', 'landscape');
        $this->pdf->render();
        $this->pdf->stream('laporan_pengajuan_' . date('Ymd') . '.pdf', ['Attachment' => true]);
    }
}

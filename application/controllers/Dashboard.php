<?php
// File: application/controllers/Dashboard.php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
    }

    // File: application/controllers/Dashboard.php

    public function index()
    {
        $data = [
            'title' => 'Dashboard Statistik',
            'total_pengajuan' => $this->Dashboard_model->get_total_pengajuan(),
            'total_verifikasi' => $this->Dashboard_model->get_total_verifikasi(),
            'total_selesai' => $this->Dashboard_model->get_total_selesai(),
            'bulanan' => $this->Dashboard_model->get_grafik_bulanan(),
            'tahunan' => $this->Dashboard_model->get_grafik_tahunan(),
            'notifikasi_verifikasi' => $this->Dashboard_model->get_notifikasi_verifikasi() // ini yang penting
        ];
        // Mendapatkan role pengguna dari session
        $user_role = $this->session->userdata('role'); // Pastikan 'role' disimpan di session saat login
        // Mendapatkan ID cabang pengguna dari session (jika relevan untuk filter notifikasi)
        // $user_id_cabang = $this->session->userdata('id_cabang'); // Asumsi ada di session

        // --- MULAI LOGIKA NOTIFIKASI UNTUK HEADER & SIDEBAR ---
        // Inisialisasi variabel notifikasi
        $data['notifikasi_verifikasi'] = 0; // Default: tidak ada notifikasi
        $data['pending_approvals_list'] = []; // Untuk daftar di dropdown notifikasi

        // Dapatkan jumlah notifikasi verifikasi berdasarkan role
        // Menggunakan fungsi yang disarankan di Pengajuan_model
        if ($user_role === 'kacab') {
            // Jika notifikasi Kacab hanya untuk cabangnya, uncomment baris bawah dan teruskan $user_id_cabang
            $data['notifikasi_verifikasi'] = $this->Pengajuan_model->count_pending_kacab_approvals(/* $user_id_cabang */);
            $data['pending_approvals_list'] = $this->Pengajuan_model->get_pending_kacab_approvals(/* $user_id_cabang */);
        } elseif ($user_role === 'am') {
            $data['notifikasi_verifikasi'] = $this->Pengajuan_model->count_pending_am_approvals();
            $data['pending_approvals_list'] = $this->Pengajuan_model->get_pending_am_approvals();
        } elseif ($user_role === 'ho') {
            $data['notifikasi_verifikasi'] = $this->Pengajuan_model->count_pending_ho_approvals();
            $data['pending_approvals_list'] = $this->Pengajuan_model->get_pending_ho_approvals();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
}

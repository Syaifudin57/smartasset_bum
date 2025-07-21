<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    public function get_total_pengajuan()
    {
        return $this->db->count_all('input_pengajuan');
    }

    public function get_grafik_bulanan()
    {
        return $this->db->query("SELECT DATE_FORMAT(tanggal_form, '%Y-%m') as bulan, COUNT(*) as jumlah FROM input_pengajuan GROUP BY bulan ORDER BY bulan")->result();
    }

    public function get_grafik_tahunan()
    {
        return $this->db->query("SELECT YEAR(tanggal_form) as tahun, 
                                SUM(CASE WHEN ip.id_cabang = 1 THEN 1 ELSE 0 END) as magelang,
                                SUM(CASE WHEN ip.id_cabang = 2 THEN 1 ELSE 0 END) as jogja,
                                SUM(CASE WHEN ip.id_cabang = 3 THEN 1 ELSE 0 END) as semarang
                                FROM input_pengajuan ip 
                                GROUP BY tahun ORDER BY tahun")
            ->result();
    }
    // Hitung total pengajuan selesai (semua approval = approved)
    public function get_total_selesai()
    {
        return $this->db
            ->where('status_kacab', 'approved')
            ->where('status_am', 'approved')
            ->where('status_ho', 'approved')
            ->from('daftar_pengajuan')
            ->count_all_results();
    }

    // Hitung total pengajuan yang masih dalam proses verifikasi
    public function get_total_proses_verifikasi()
    {
        return $this->db
            ->group_start()
            ->where('status_kacab !=', 'approved')
            ->or_where('status_am !=', 'approved')
            ->or_where('status_ho !=', 'approved')
            ->group_end()
            ->from('daftar_pengajuan')
            ->count_all_results();
    }

    public function get_notifikasi_verifikasi()
    {
        $role = strtolower($this->session->userdata('role'));

        if ($role === 'kacab') {
            $this->db->where('status_kacab', 'pending');
        } elseif ($role === 'am') {
            $this->db->where('status_kacab', 'approved');
            $this->db->where('status_am', 'pending');
        } elseif ($role === 'ho') {
            $this->db->where('status_am', 'approved');
            $this->db->where('status_ho', 'pending');
        } else {
            // Untuk role lain, tidak ada notifikasi
            return 0;
        }

        return $this->db->count_all_results('daftar_pengajuan');
    }



    public function get_total_verifikasi()
    {
        // Hitung total pengajuan yang masih perlu diverifikasi (status masih pending di salah satu level)
        $this->db->group_start()
            ->where('status_kacab', 'pending')
            ->or_where('status_am', 'pending')
            ->or_where('status_ho', 'pending')
            ->group_end();
        return $this->db->get('daftar_pengajuan')->num_rows();
    }

    public function get_total_verifikasi_by_role($role)
    {
        // Mapping role ke field status
        $role_map = [
            'kacab' => 'status_kacab',
            'am' => 'status_am',
            'ho' => 'status_ho',
            'admin' => null,
            'super_admin' => null
        ];

        if (isset($role_map[$role]) && $role_map[$role] !== null) {
            $this->db->where($role_map[$role], 'pending');
            return $this->db->get('daftar_pengajuan')->num_rows();
        } else {
            return 0; // admin/super_admin tidak perlu verifikasi
        }
    }

    public function get_pending_verifikasi_by_role($role)
    {
        $this->db->from('daftar_pengajuan');

        if ($role == 'kepala_cabang') {
            $this->db->where('status_kacab', 'pending');
        } elseif ($role == 'area_manager') {
            $this->db->where('status_am', 'pending');
        } elseif ($role == 'admin_pusat') {
            $this->db->where('status_ho', 'pending');
        } elseif ($role == 'super_admin') {
            // jika ingin super_admin melihat semua pending
            $this->db->group_start();
            $this->db->where('status_kacab', 'pending');
            $this->db->or_where('status_am', 'pending');
            $this->db->or_where('status_ho', 'pending');
            $this->db->group_end();
        } else {
            return 0;
        }

        return $this->db->count_all_results();
    }
}

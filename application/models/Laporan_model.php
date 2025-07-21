<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_filtered($mulai = null, $sampai = null)
    {
        $this->db->select('ip.id, ip.nomor_form, ip.nama_aset, ip.tanggal_form, ip.approval_kacab, ip.approval_am, ip.approval_ho');
        $this->db->from('input_pengajuan ip');

        if ($mulai && $sampai) {
            $this->db->where('DATE(ip.tanggal_form) >=', $mulai);
            $this->db->where('DATE(ip.tanggal_form) <=', $sampai);
        }

        return $this->db->get()->result();
    }
}

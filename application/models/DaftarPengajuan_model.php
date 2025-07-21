<?php
// application/models/DaftarPengajuan_model.php
defined('BASEPATH') or exit('No direct script access allowed');

class DaftarPengajuan_model extends CI_Model
{
    public function get_all()
    {
        return $this->db
            ->select('p.*, c.nama_cabang')
            ->from('input_pengajuan p')
            ->join('cabang c', 'c.id = p.id_cabang', 'left')
            ->where('p.status !=', 'draft')
            ->order_by('p.tanggal_form', 'DESC')
            ->get()->result();
    }

    public function approve($id, $role)
    {
        $this->db->where('id', $id);

        switch ($role) {
            case 'kacab':
                return $this->db->update('input_pengajuan', ['approval_kacab' => 'approved']);
            case 'am':
                return $this->db->update('input_pengajuan', ['approval_am' => 'approved']);
            case 'ho':
                return $this->db->update('input_pengajuan', ['approval_ho' => 'approved']);
        }
    }

    public function reject($id, $role)
    {
        $this->db->where('id', $id);

        switch ($role) {
            case 'kacab':
                return $this->db->update('input_pengajuan', ['approval_kacab' => 'rejected']);
            case 'am':
                return $this->db->update('input_pengajuan', ['approval_am' => 'rejected']);
            case 'ho':
                return $this->db->update('input_pengajuan', ['approval_ho' => 'rejected']);
        }
    }

    // Mendapatkan semua data pengajuan dengan status 'submitted'
    public function get_all_submitted()
    {
        $this->db->select('input_pengajuan.*, cabang.nama_cabang');
        $this->db->from('input_pengajuan');
        $this->db->join('cabang', 'cabang.id = input_pengajuan.id_cabang', 'left');
        $this->db->where('input_pengajuan.status', 'submitted');
        $this->db->order_by('input_pengajuan.tanggal_form', 'DESC');
        return $this->db->get()->result();
    }
}

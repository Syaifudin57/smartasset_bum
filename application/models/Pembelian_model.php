<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian_model extends CI_Model
{
    public function insert($data)
    {
        return $this->db->insert('input_pembelian', $data);
    }

    public function get_all()
    {
        $this->db->select('input_pembelian.*, input_pengajuan.nama_aset, input_pengajuan.nomor_form');
        $this->db->from('input_pembelian');
        $this->db->join('input_pengajuan', 'input_pengajuan.id = input_pembelian.id_pengajuan');
        $this->db->order_by('input_pembelian.created_at', 'DESC');
        return $this->db->get()->result();
    }


    public function get_by_pengajuan_id($id_pengajuan)
    {
        return $this->db->get_where('input_pembelian', ['id_pengajuan' => $id_pengajuan])->row();
    }

    public function get_all_with_pengajuan()
    {
        $this->db->select('input_pembelian.*, input_pengajuan.nomor_form, input_pengajuan.nama_aset');
        $this->db->from('input_pembelian');
        $this->db->join('input_pengajuan', 'input_pengajuan.id = input_pembelian.id_pengajuan');
        return $this->db->get()->result();
    }
}

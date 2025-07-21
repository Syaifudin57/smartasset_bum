<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cabang_model extends CI_Model
{
    public function get_all()
    {
        return $this->db->get('cabang')->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('cabang', ['id' => $id])->row();
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Ruangan extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        // $this->load->library('licensing');
        // $this->licensing->check_license();
        $this->load->model('m_model');
        if (!$this->session->userdata('level')) {
            $this->session->set_flashdata('pesan', 'Anda harus masuk terlebih dahulu!');
            redirect('home');
        }
    }


    public function index()
    {
        $data['title']      = 'Data Ruangan';
        $data['subtitle']   = 'Semua data ruangan akan muncul disini';


        $data['collapse']   = 'No';

        $data['ruangan']       = $this->m_model->get_desc('tb_ruangan');

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/ruangan');
        $this->load->view('admin/templates/footer');
    }


    public function delete($id)
    {
        $where = array('id' => $id);
        $this->m_model->delete($where, 'tb_ruangan');
        $this->session->set_flashdata('pesan', 'Data berhasil dihapus!');
        redirect('admin/ruangan');
    }


    public function insert()
    {
        date_default_timezone_set('Asia/Jakarta');


        $kode       = $_POST['kode'];
        $nama       = $_POST['nama'];
        $terdaftar  = date('Y-m-d H:i:s');


        $data = array(
            'kode'      => $kode,
            'nama'      => $nama,
            'terdaftar' => $terdaftar,
        );


        $this->m_model->insert($data, 'tb_ruangan');
        $this->session->set_flashdata('pesan', 'Data berhasil ditambahkan!');
        redirect('admin/ruangan');
    }


    public function update($id)
    {
        $kode       = $_POST['kode'];
        $nama       = $_POST['nama'];


        $data = array(
            'kode'      => $kode,
            'nama'      => $nama,
        );


        $where = array('id' => $id);


        $this->m_model->update($where, $data, 'tb_ruangan');
        $this->session->set_flashdata('pesan', 'Data berhasil diubah!');
        redirect('admin/ruangan');
    }

    public function detail($id)
    {
        $data['title']      = 'Detail Ruangan';
        $data['subtitle']   = 'Semua data ruangan akan muncul disini';


        $data['collapse']   = 'Yes';

        $this->db->where('id', $id);
        $data['ruangan']       = $this->m_model->get_desc('tb_ruangan');
        $this->db->where('idRuangan', $id);
        $data['booking']       = $this->m_model->get_desc('tb_booking');

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/detail');
        $this->load->view('admin/templates/footer');
    }
}

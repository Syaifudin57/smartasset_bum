<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Booking extends CI_Controller {
   public function __construct()
   {
       parent::__construct();
       // $this->load->library('licensing');
       // $this->licensing->check_license();
       $this->load->model('m_model');
       if(!$this->session->userdata('level')){
           $this->session->set_flashdata('pesan', 'Anda harus masuk terlebih dahulu!');
           redirect('home');
       }
   }


   public function index()
   {
       $data['title']      = 'Data Booking';
       $data['subtitle']   = 'Semua data booking akan muncul disini';


       $data['collapse']   = 'No';
  
       $data['ruangan']       = $this->m_model->get_desc('tb_ruangan');


       if ($this->session->userdata('level') == 'User') {
           $this->db->where('idUser', $this->session->userdata('id'));
       }


       $data['booking']       = $this->m_model->get_desc('tb_booking');
      
       $this->load->view('admin/templates/header', $data);
       $this->load->view('admin/templates/sidebar');
       $this->load->view('admin/booking');
       $this->load->view('admin/templates/footer');
   }


   public function delete($id)
   {
       $where = array('id' => $id);


       $this->m_model->delete($where, 'tb_booking');
       $this->session->set_flashdata('pesan', 'Data berhasil dihapus!');
       redirect('admin/booking');
   }


   public function insert()
   {
       date_default_timezone_set('Asia/Jakarta');


       $idUser     = $this->session->userdata('id');
       $idRuangan  = $_POST['idRuangan'];
       $tanggal    = $_POST['tanggal'];
       $dariJam    = $_POST['dariJam'];
       $sampaiJam  = $_POST['sampaiJam'];
       $agenda     = $_POST['agenda'];
       $status     = 'Menunggu';
       $terdaftar  = date('Y-m-d H:i:s');


       $data = array(
           'idUser'        => $idUser,
           'idRuangan'     => $idRuangan,
           'tanggal'       => $tanggal,
           'dariJam'       => $dariJam,
           'sampaiJam'     => $sampaiJam,
           'agenda'        => $agenda,
           'status'        => $status,
           'terdaftar'     => $terdaftar,
       );


       $this->m_model->insert($data,'tb_booking');
       $this->session->set_flashdata('pesan', 'Data berhasil ditambahkan!');
       redirect('admin/booking');
   }


   public function update($id)
   {
       $idRuangan  = $_POST['idRuangan'];
       $tanggal    = $_POST['tanggal'];
       $dariJam    = $_POST['dariJam'];
       $sampaiJam  = $_POST['sampaiJam'];
       $agenda     = $_POST['agenda'];


       $data = array(
           'idRuangan'     => $idRuangan,
           'tanggal'       => $tanggal,
           'dariJam'       => $dariJam,
           'sampaiJam'     => $sampaiJam,
           'agenda'        => $agenda,
       );


       $where = array('id' => $id );


       $this->m_model->update($where, $data,'tb_booking');
       $this->session->set_flashdata('pesan', 'Data berhasil diubah!');
       redirect('admin/booking');
   }


   public function respon($id)
   {
       $status = $_POST['status'];


       $data = array(
           'status'     => $status,
       );


       $where = array('id' => $id );


       $this->m_model->update($where, $data,'tb_booking');
       $this->session->set_flashdata('pesan', 'Berhasil respon data!');
       redirect('admin/booking');
   }
}


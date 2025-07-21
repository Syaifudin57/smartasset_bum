<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class User extends CI_Controller {


   public function __construct()
   {
       parent::__construct();
       // $this->load->library('licensing');
       // $this->licensing->check_license();
       $this->load->model('m_model');
       if(!$this->session->userdata('level')){
           $this->session->set_flashdata('pesan', 'Anda harus masuk terlebih dahulu!');
           redirect('home');
       } elseif($this->session->userdata('level') != 'Administrator') {
           redirect('home');
       }
   }


   public function index()
   {
       $data['title']      = 'Manajemen User';
       $data['subtitle']   = 'Semua user akan muncul disini';


       $data['collapse']   = 'No';
  
       $data['user']       = $this->m_model->get_desc('tb_user');
      
       $this->load->view('admin/templates/header', $data);
       $this->load->view('admin/templates/sidebar');
       $this->load->view('admin/user');
       $this->load->view('admin/templates/footer');
   }


   public function delete($id)
   {
       $where = array('id' => $id);


       $this->m_model->delete($where, 'tb_user');
       $this->session->set_flashdata('pesan', 'Account berhasil dihapus');
       redirect('admin/user');
   }


   public function insert()
   {
       date_default_timezone_set('Asia/Jakarta');


       $nama           = $_POST['nama'];
       $jenisKelamin   = $_POST['jenisKelamin'];
       $telp           = $_POST['telp'];
       $email          = $_POST['email'];
       $login          = $_POST['login'];
       $alamat         = $_POST['alamat'];
       $username       = $_POST['username'];
       $password       = $_POST['password'];
       $foto           = 'no-image.png';
       $skin           = 'blue';
       $level          = $_POST['level'];
       $terdaftar      = date('Y-m-d H:i:s');


       $where = array('username' => $username);
       $cekUsername    = $this->m_model->get_where($where, 'tb_user');
       if(empty($cekUsername->num_rows())) {
           $options = [
               'cost' => 10,
           ];
  
       $enkripPassword = password_hash($password, PASSWORD_BCRYPT, $options);
           $data = array(
               'nama'          => $nama,
               'jenisKelamin'  => $jenisKelamin,
               'telp'          => $telp,
               'email'         => $email,
               'login'         => $login,
               'alamat'        => $alamat,
               'username'      => $username,
               'password'      => $enkripPassword,
               'foto'          => $foto,
               'skin'          => $skin,
               'level'         => $level,
               'terdaftar'     => $terdaftar,
           );
  
           $this->m_model->insert($data, 'tb_user');
           $this->session->set_flashdata('pesan', 'Account berhasil dibuat!');
           redirect('admin/user');
       } else {
           $this->session->set_flashdata('pesanError', 'Username sudah ada!');
           redirect('admin/user');
       }
   }


   public function resetpassword($id)
   {
       $password   = $_POST['password'];
       $options = [
           'cost' => 10,
       ];


       $enkripPassword = password_hash($password, PASSWORD_BCRYPT, $options);
       $data = array(
           'password'  => $enkripPassword,
       );


       $where = array('id' => $id);


       $this->m_model->update($where, $data, 'tb_user');
       $this->session->set_flashdata('pesan', 'Reset password berhasil!');
       redirect('admin/user');
   }


   public function update($id)
   {
       $nama           = $_POST['nama'];
       $jenisKelamin   = $_POST['jenisKelamin'];
       $telp           = $_POST['telp'];
       $email          = $_POST['email'];
       $login          = $_POST['login'];
       $alamat         = $_POST['alamat'];


       $where = array('id' => $id);
       $data = array(
           'nama'          => $nama,
           'jenisKelamin'  => $jenisKelamin,
           'telp'          => $telp,
           'email'         => $email,
           'login'         => $login,
           'alamat'        => $alamat
       );
       $this->m_model->update($where, $data, 'tb_user');
       $this->session->set_flashdata('pesan', 'Account berhasil diubah!');
       redirect('admin/user');
   }
}


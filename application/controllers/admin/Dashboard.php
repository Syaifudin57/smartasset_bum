<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard extends CI_Controller {


   public function __construct()
   {
       parent::__construct();
       // $this->load->library('licensing');
       // $this->licensing->check_license();
       if(!$this->session->userdata('level')){
           $this->session->set_flashdata('pesan', 'Anda harus masuk terlebih dahulu!');
           redirect('home');
       }
   }


   public function index()
   {
       $data['title']      = 'Dashboard';
       $data['subtitle']   = 'Control Panel';


       $data['collapse']   = 'No';
      
       $this->load->view('admin/templates/header', $data);
       $this->load->view('admin/templates/sidebar');
       $this->load->view('admin/dashboard');
       $this->load->view('admin/templates/footer');
   }
}


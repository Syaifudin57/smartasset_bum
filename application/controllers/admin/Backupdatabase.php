<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Backupdatabase extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_model');
        // $this->load->library('licensing');
        // $this->licensing->check_license();
        if (!$this->session->userdata('level')) {
            $this->session->set_flashdata('pesan', 'Anda harus masuk terlebih dahulu!');
            redirect('home');
        } elseif ($this->session->userdata('level') != 'Administrator') {
            redirect('home');
        }
    }


    public function index()
    {
        $data['title']      = 'Backup Database';
        $data['subtitle']   = 'Halaman ini untuk backup database';


        $data['collapse']   = 'No';


        $data['backupdb']   = $this->m_model->get_desc('tb_backupdb');

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/backupdatabase');
        $this->load->view('admin/templates/footer');
    }

    public function backup_database()
    {
        $this->load->dbutil();

        $config = [
            'format'    => 'zip',
            'filename'  => 'sibook_backup.sql'
        ];

        $backup = $this->dbutil->backup($config);

        // Simpan nama file dengan format waktu
        $file_name = 'sibook-backup-' . date('Ymd-His') . '.zip';
        $save_path = './assets/database_backup/' . $file_name;

        $this->load->helper('file');
        write_file($save_path, $backup);

        // Simpan info ke database
        $data = array(
            'idUser'    => $this->session->userdata('id'),
            'database'  => $file_name,
            'terdaftar' => date('Y-m-d H:i:s')
        );

        $this->m_model->insert($data, 'tb_backupdb');

        // Tampilkan pesan berhasil dan kembali ke halaman
        $this->session->set_flashdata('pesan', 'Backup berhasil disimpan di server.');
        redirect('admin/backupdatabase');
    }
}

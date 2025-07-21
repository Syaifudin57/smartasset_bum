<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function cek_login() {
    $CI =& get_instance();
    if (!$CI->session->userdata('is_logged_in')) {
        redirect('auth');
    }
}

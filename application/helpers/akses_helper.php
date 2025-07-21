<?php

function cek_role($roleDiizinkan = [])
{
    $CI = &get_instance();
    $userRole = $CI->session->userdata('role');

    if (!in_array($userRole, $roleDiizinkan)) {
        show_error('Akses ditolak untuk role: ' . $userRole, 403, 'Forbidden');
    }
}

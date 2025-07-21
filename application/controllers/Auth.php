<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index()
    {
        $this->load->view('auth/login');
    }

    // File: application/controllers/Auth.php
    public function login()
    {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        $user = $this->User_model->check_login($username, $password);

        if ($user) {
            $this->session->set_userdata([
                'user_id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
                'is_logged_in' => true
            ]);
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Username atau password salah');
            redirect('auth');
        }
    }



    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
    public function add_admin()
    {
        // Admin default
        $data = [
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'name' => 'Administrator Utama',
            'role' => 'admin',
            'is_active' => 1
        ];

        // Cek jika belum ada user
        $exists = $this->db->get_where('users', ['username' => $data['username']])->row();

        if (!$exists) {
            $this->db->insert('users', $data);
            echo "User admin berhasil ditambahkan.<br>Username: admin<br>Password: admin123";
        } else {
            echo "User admin sudah ada.";
        }
    }

    public function register()
    {
        if ($this->input->post()) {
            $token = bin2hex(random_bytes(16)); // generate token verifikasi

            $data = [
                'username' => $this->input->post('username', true),
                'email' => $this->input->post('email', true),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'name' => $this->input->post('nama', true),
                'role' => $this->input->post('role', true),
                'is_active' => 0, // belum aktif sampai verifikasi
                'token' => $token
            ];

            $this->db->insert('users', $data);

            // KIRIM EMAIL
            $this->load->library('email');

            $config = [
                'protocol'  => 'smtp',
                'smtp_host' => 'smtp.gmail.com',
                'smtp_port' => 587,
                'smtp_user' => 'youremail@gmail.com', // Ganti dengan email kamu
                'smtp_pass' => 'yourpassword',        // Ganti dengan password email atau app password
                'mailtype'  => 'html',
                'charset'   => 'utf-8',
                'newline'   => "\r\n",
            ];
            $this->email->initialize($config);

            $this->email->from('youremail@gmail.com', 'SmartAsset BUM');
            $this->email->to($data['email']);
            $this->email->subject('Verifikasi Akun SmartAsset BUM');
            $this->email->message('Klik link berikut untuk mengaktifkan akun Anda:<br><br>
            <a href="' . base_url('auth/verify/' . $token) . '">Verifikasi Akun</a>');

            if ($this->email->send()) {
                $this->session->set_flashdata('success', 'Pendaftaran berhasil. Cek email Anda untuk verifikasi.');
            } else {
                $this->session->set_flashdata('error', 'Pendaftaran berhasil, tapi gagal mengirim email.');
            }

            redirect('auth');
        } else {
            $this->load->view('auth/register');
        }
    }



    public function forgot_password()
    {
        if ($this->input->post()) {
            $email = $this->input->post('email', true);
            $user = $this->db->get_where('users', ['email' => $email])->row();

            if ($user) {
                $token = bin2hex(random_bytes(32));
                $expired = date("Y-m-d H:i:s", strtotime('+1 hour'));

                // Simpan token
                $this->db->update('users', [
                    'reset_token' => $token,
                    'reset_expired' => $expired
                ], ['id' => $user->id]);

                // Kirim email reset
                $this->load->library('email');
                $config = [
                    'protocol'  => 'smtp',
                    'smtp_host' => 'smtp.gmail.com',
                    'smtp_port' => 587,
                    'smtp_user' => 'youremail@gmail.com', // Ganti
                    'smtp_pass' => 'yourpassword',         // Ganti
                    'mailtype'  => 'html',
                    'charset'   => 'utf-8',
                    'newline'   => "\r\n",
                ];
                $this->email->initialize($config);
                $this->email->from('youremail@gmail.com', 'SmartAsset BUM');
                $this->email->to($email);
                $this->email->subject('Reset Password');
                $this->email->message("
                Kami menerima permintaan reset password.<br><br>
                Klik link berikut untuk mereset password Anda:<br>
                <a href='" . base_url('auth/reset_password/' . $token) . "'>Reset Password</a><br><br>
                Link berlaku selama 1 jam.");

                if ($this->email->send()) {
                    $this->session->set_flashdata('success', 'Link reset telah dikirim ke email Anda.');
                } else {
                    $this->session->set_flashdata('error', 'Gagal mengirim email. Coba lagi.');
                }
                redirect('auth/forgot_password');
            } else {
                $this->session->set_flashdata('error', 'Email tidak ditemukan.');
            }
        }

        $this->load->view('auth/forgot_password');
    }


    public function verify($token)
    {
        $user = $this->db->get_where('users', ['token' => $token])->row();

        if ($user) {
            $this->db->update('users', ['is_active' => 1, 'token' => NULL], ['id' => $user->id]);
            $this->session->set_flashdata('success', 'Akun berhasil diverifikasi. Silakan login.');
        } else {
            $this->session->set_flashdata('error', 'Token tidak valid.');
        }

        redirect('auth');
    }

    public function reset_password($token)
    {
        $user = $this->db->get_where('users', ['reset_token' => $token])->row();

        if (!$user || strtotime($user->reset_expired) < time()) {
            $this->session->set_flashdata('error', 'Link reset tidak valid atau sudah kedaluwarsa.');
            redirect('auth');
            return;
        }

        if ($this->input->post()) {
            $new_pass = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $this->db->update('users', [
                'password' => $new_pass,
                'reset_token' => NULL,
                'reset_expired' => NULL
            ], ['id' => $user->id]);

            $this->session->set_flashdata('success', 'Password berhasil direset. Silakan login.');
            redirect('auth');
        } else {
            $data['token'] = $token;
            $this->load->view('auth/reset_password', $data);
        }
    }

    public function add_superadmin()
    {
        $data = [
            'username' => 'superadmin',
            'password' => password_hash('super123', PASSWORD_DEFAULT),
            'name' => 'Super Administrator',
            'role' => 'super_admin',
            'is_active' => 1,
            'email' => 'superadmin@smartasset.local'
        ];

        $exists = $this->db->get_where('users', ['username' => 'superadmin'])->row();
        if (!$exists) {
            $this->db->insert('users', $data);
            echo "Super admin berhasil ditambahkan.<br>Username: superadmin<br>Password: super123";
        } else {
            echo "User superadmin sudah ada.";
        }
    }

    public function reset_superadmin_password()
    {
        $new_password = password_hash('super123', PASSWORD_DEFAULT);

        $this->db->update('users', ['password' => $new_password], ['username' => 'superadmin']);

        echo "Password superadmin berhasil direset ke: super123";
    }
}

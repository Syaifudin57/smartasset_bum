<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function get_all()
    {
        return $this->db->get('users')->result();
    }

    public function getById($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert('users', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('users', ['id' => $id]);
    }

    public function get_user($username)
    {
        return $this->db->get_where('users', ['username' => $username])->row();
    }

    public function get_user_by_id($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    public function update_user($id, $data)
    {
        return $this->db->where('id', $id)->update('users', $data);
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row(); // pastikan return object
    }


    // application/models/User_model.php
    public function update_profile($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function check_login($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('is_active', 1); // tambahkan ini untuk memastikan hanya akun aktif
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            $user = $query->row();

            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        return false;
    }

    public function get_user_by_username($username)
    {
        return $this->db->get_where('users', ['username' => $username])->row();
    }
}

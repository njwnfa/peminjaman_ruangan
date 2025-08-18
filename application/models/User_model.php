<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function check_login($username, $password)
    {
        $this->db->where('username', $username);
        $user = $this->db->get('users')->row();

        if ($user) {
            if (password_verify($password, $user->password)) {
                return $user; // login sukses
            }
        }
        return false; // gagal login
    }
}

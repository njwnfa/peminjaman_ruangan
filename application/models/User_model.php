<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function check_login($email, $password) {
        $user = $this->get_by_email($email);

        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }

    public function insert($data) {
        return $this->db->insert('users', $data);
    }

    public function get_by_email($email) {
        return $this->db->get_where('users', ['email' => $email])->row();
    }
}

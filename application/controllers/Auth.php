<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property User_model $User_model
 * @property CI_Session $session
 * @property CI_Input $input
 */
class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
    }

    public function login() {
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->User_model->check_login($email, $password);

            if ($user) {
                $this->session->set_userdata([
                    'user_id'   => $user->id,
                    'nama'      => $user->nama,
                    'email'     => $user->email,
                    'role'      => $user->role,
                    'logged_in' => TRUE
                ]);

                if ($user->role == 'admin') {
                    redirect('admin/dashboard');
                } else {
                    redirect(base_url());
                }
            } else {
                $this->session->set_flashdata('error', 'Email atau Password salah!');
                redirect('auth/login');
            }
        } else {
            $this->load->view('auth/login');
        }
    }

    public function register() {
        if ($this->input->post()) {
            $data = [
                'nama'     => $this->input->post('nama'),
                'email'    => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'role'     => 'user'
            ];

            // cek email unik
            if ($this->User_model->get_by_email($data['email'])) {
                $this->session->set_flashdata('error', 'Email sudah terdaftar!');
                redirect('auth/register');
            } else {
                $this->User_model->insert($data);
                $this->session->set_flashdata('success', 'Pendaftaran berhasil, silakan login.');
                redirect('auth/login'); // ✅ lebih natural ke login
            }
        } else {
            $this->load->view('auth/register');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url());
    }
}

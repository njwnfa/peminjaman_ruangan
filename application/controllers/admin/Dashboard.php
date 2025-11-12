<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 */
class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        // cek role admin
        if ($this->session->userdata('role') != 'admin') {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['username'] = $this->session->userdata('username');
        $this->load->view('admin/dashboard', $data);
    }

}
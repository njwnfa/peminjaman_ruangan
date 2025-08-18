<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') != 'user') {
            redirect('auth/login');
        }
    }

    public function index() {
        echo "Halo User " . $this->session->userdata('username');
        echo " | <a href='".site_url('auth/logout')."'>Logout</a>";
    }
}

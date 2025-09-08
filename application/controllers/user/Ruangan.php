<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Ruangan_model $Ruangan_model
 * @property CI_Session $session
 * @property CI_Input $input
 */
class Ruangan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        // cek role user
        if ($this->session->userdata('role') != 'user') {
            show_error('Anda tidak memiliki akses ke halaman ini.', 403);
        }
    }

    public function index() {
        $data['active'] = 'ruangan'; // untuk highlight menu
        $this->load->view('ruangan/list_ruangan', $data);

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/footer');
    }
}

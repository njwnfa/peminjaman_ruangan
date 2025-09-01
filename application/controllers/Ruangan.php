<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property User_model $User_model
 * @property Ruangan_model $Ruangan_model
 * @property CI_Session $session
 * @property CI_Input $input
 */
class Ruangan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Ruangan_model');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function list_ruangan() {
        $data['ruangan'] = $this->Ruangan_model->getAll();
        $data['title'] = "Daftar Ruangan";
        $data['active'] = "ruangan";

        $this->load->view('layouts/header', $data);
        $this->load->view('ruangan/list_ruangan', $data);
        $this->load->view('layouts/footer');
    }

    public function ajukan($id) {
        // nanti buat form pengajuan di sini
        echo "Form ajukan ruangan dengan ID: ".$id;
    }
}

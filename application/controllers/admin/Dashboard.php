<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session
 * @property Dashboard_model
 */
class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Dashboard_model');

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
       

        $data['active'] = 'dashboard';

        // Panggil fungsi dari model untuk mengambil data total
        $data['total_user'] = $this->Dashboard_model->count_total_user();
        $data['total_ruangan'] = $this->Dashboard_model->count_total_ruangan();
        $data['total_peminjaman'] = $this->Dashboard_model->count_total_peminjaman();
        $data['total_rekap'] = $this->Dashboard_model->count_total_rekap(); 

         $this->load->view('admin/dashboard', $data);
    }

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property Peminjaman_model $Peminjaman_model
 */
class Rekap extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Security check
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak. Silakan login sebagai admin.');
            redirect('auth/login');
        }

        $this->load->model('Peminjaman_model');
    }

    /**
     * Menampilkan halaman rekap dengan filter bulan dan tahun
     */
    public function index() {
        $data['title'] = 'Rekap Peminjaman Selesai';
        $data['active'] = 'rekap'; // Untuk sidebar

        // Ambil filter dari POST/GET, jika tidak ada, gunakan bulan & tahun ini
        $data['filter_bulan'] = $this->input->post('bulan') ?? date('m');
        $data['filter_tahun'] = $this->input->post('tahun') ?? date('Y');

        // Panggil method baru di model untuk ambil data rekap
        $data['rekap'] = $this->Peminjaman_model->get_rekap_by_filter(
            $data['filter_bulan'],
            $data['filter_tahun']
        );
        
        // Kirim data tahun-tahun ke view untuk dropdown
        // (Misal: 5 tahun ke belakang)
        $data['list_tahun'] = range(date('Y'), date('Y') - 5);

        // Kita gunakan view utuh (bukan template header/footer)
        $this->load->view('admin/rekap/index', $data);
    }
}
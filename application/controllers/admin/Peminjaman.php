<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Peminjaman_model $Peminjaman_model
 * @property Ruangan_model $Ruangan_model
 * @property CI_Session $session
 * @property CI_Input $input
 */
class Peminjaman extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Peminjaman_model');
        $this->load->model('Ruangan_model');

        // hanya admin yang boleh akses
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }
    }

    // Halaman daftar peminjaman
    public function index() {
        $data['title'] = "Validasi Peminjaman";
        $data['active'] = "peminjaman";
        $data['peminjaman'] = $this->Peminjaman_model->getAllWithRuangan();

        $this->load->view('admin/manage-peminjaman/index', $data);
    }

    // Setujui peminjaman
    public function setujui($id) {
        if ($this->Peminjaman_model->updateStatus($id, 'disetujui')) {
            $this->session->set_flashdata('success', 'Peminjaman berhasil disetujui.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyetujui peminjaman.');
        }
        redirect('admin/peminjaman');
    }

    // Tolak peminjaman
    public function tolak($id) {
        if ($this->Peminjaman_model->updateStatus($id, 'ditolak')) {
            $this->session->set_flashdata('success', 'Peminjaman berhasil ditolak.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menolak peminjaman.');
        }
        redirect('admin/peminjaman');
    }
}

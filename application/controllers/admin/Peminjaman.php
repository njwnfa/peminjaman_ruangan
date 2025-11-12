<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property Peminjaman_model $Peminjaman_model
 * @property Ruangan_model $Ruangan_model
 */
class Peminjaman extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Security check: Pastikan hanya admin yang bisa akses
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak. Silakan login sebagai admin.');
            redirect('auth/login');
        }

        $this->load->model('Peminjaman_model');
        $this->load->model('Ruangan_model'); // Kita perlu ini untuk update status ruangan
        $this->load->library('form_validation');
    }

    /**
     * Menampilkan halaman utama manage peminjaman (data join)
     */
    public function index() {
        $data['title'] = 'Validasi Peminjaman Ruangan';
        $data['peminjaman'] = $this->Peminjaman_model->get_all_joined();
        
        // TAMBAHKAN BARIS INI
        $data['active'] = 'peminjaman'; 
        
        $this->load->view('admin/manage-peminjaman/index', $data);
    }

    /**
     * Aksi untuk Menyetujui Peminjaman
     */
    public function approve($id_peminjaman) {
        // 1. Dapatkan data peminjaman untuk tahu id_ruangan
        $peminjaman = $this->Peminjaman_model->get_by_id($id_peminjaman);

        if (!$peminjaman) {
            $this->session->set_flashdata('error', 'Data peminjaman tidak ditemukan.');
            redirect('admin/peminjaman');
        }

        // 2. Data untuk update tabel peminjaman
        $data_peminjaman = [
            'status' => 'disetujui'
        ];

        // 3. Data untuk update tabel ruangan
        $data_ruangan = [
            'status' => 'dipinjam' // Ubah status ruangan
        ];

        // 4. Lakukan update
        // Kita gunakan '&&' agar jika salah satu gagal, notif error muncul
        $update_peminjaman = $this->Peminjaman_model->update($id_peminjaman, $data_peminjaman);
        $update_ruangan = $this->Ruangan_model->update($peminjaman->id_ruangan, $data_ruangan);

        if ($update_peminjaman && $update_ruangan) {
            $this->session->set_flashdata('success', 'Peminjaman berhasil disetujui.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui status.');
        }

        redirect('admin/peminjaman');
    }

    /**
     * Aksi untuk Menolak Peminjaman
     */
    public function reject($id_peminjaman) {
        // Validasi input dari modal
        $this->form_validation->set_rules('catatan_admin', 'Alasan Penolakan', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            // Jika admin tidak mengisi alasan
            $this->session->set_flashdata('error', 'Gagal menolak. Alasan penolakan wajib diisi.');
        } else {
            // Jika validasi sukses
            $data_peminjaman = [
                'status' => 'ditolak',
                'catatan_admin' => $this->input->post('catatan_admin')
            ];

            // Update data peminjaman
            if ($this->Peminjaman_model->update($id_peminjaman, $data_peminjaman)) {
                $this->session->set_flashdata('success', 'Peminjaman telah ditolak.');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui status.');
            }
        }
        
        // Penting: Saat ditolak, status ruangan TIDAK berubah.
        redirect('admin/peminjaman');
    }
}
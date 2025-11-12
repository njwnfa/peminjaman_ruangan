<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk User (melihat daftar ruangan & mengajukan peminjaman)
 */
/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property Ruangan_model $Ruangan_model
 * @property Peminjaman_model $Peminjaman_model
 */
class Ruangan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Cek jika user sudah login dan role-nya 'user'
        if ($this->session->userdata('role') != 'user') {
            $this->session->set_flashdata('error', 'Silakan login sebagai user terlebih dahulu.');
            redirect('auth/login');
        }
        $this->load->model('Ruangan_model');
        $this->load->model('Peminjaman_model');
        // Load library form validation
        $this->load->library('form_validation');
    }

    /**
     * Tampilkan daftar ruangan
     */
    public function index() {
        $data['title'] = 'Daftar Ruangan';
        $data['ruangan'] = $this->Ruangan_model->getAll(); // Asumsi method getAll() ada di model
        
        $this->load->view('layouts/header', $data);
        $this->load->view('ruangan/list_ruangan', $data); // Ini adalah view yang kita edit sebelumnya
        $this->load->view('layouts/footer');
    }

    /**
     * ==== TAMBAHKAN METHOD INI ====
     * * Method untuk menyimpan data peminjaman baru dari form modal
     */
    public function store_peminjaman() {
        
        // 1. Atur Rules Validasi
        $this->form_validation->set_rules('id_ruangan', 'Ruangan', 'required|numeric');
        $this->form_validation->set_rules('keperluan', 'Keperluan', 'required|trim');
        $this->form_validation->set_rules('nama_dosen', 'Nama Dosen', 'required|trim');
        $this->form_validation->set_rules('tanggal_mulai_date', 'Tanggal Mulai', 'required');
        $this->form_validation->set_rules('jam_mulai_time', 'Jam Mulai', 'required');
        $this->form_validation->set_rules('tanggal_selesai_date', 'Tanggal Selesai', 'required');
        $this->form_validation->set_rules('jam_selesai_time', 'Jam Selesai', 'required');

        // 2. Jalankan Validasi
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal
            $this->session->set_flashdata('error', 'Data tidak lengkap. Gagal mengajukan peminjaman.');
            redirect('ruangan/index');
        } else {
            // Jika validasi sukses
            
            // 3. Gabungkan Tanggal dan Waktu
            $tgl_mulai = $this->input->post('tanggal_mulai_date') . ' ' . $this->input->post('jam_mulai_time') . ':00';
            $tgl_selesai = $this->input->post('tanggal_selesai_date') . ' ' . $this->input->post('jam_selesai_time') . ':00';
            $id_ruangan = $this->input->post('id_ruangan');
            
            // 4. Cek Ketersediaan Waktu (Jadwal Bentrok)
            // Kita panggil method dari Peminjaman_model
            if ($this->Peminjaman_model->is_waktu_tersedia($id_ruangan, $tgl_mulai, $tgl_selesai)) {
                
                // 5. Jika Tersedia, Siapkan Data untuk Disimpan
                $data = [
                    'id_user'       => $this->session->userdata('user_id'),
                    'id_ruangan'    => $id_ruangan,
                    'keperluan'     => $this->input->post('keperluan'),
                    'nama_dosen'    => $this->input->post('nama_dosen'),
                    'tanggal_mulai' => $tgl_mulai,
                    'tanggal_selesai' => $tgl_selesai,
                    'status'        => 'menunggu' // Status awal
                ];

                // 6. Simpan ke Database via Model
                if ($this->Peminjaman_model->save($data)) {
                    $this->session->set_flashdata('success', 'Pengajuan peminjaman berhasil dikirim. Mohon tunggu konfirmasi admin.');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menyimpan data ke database.');
                }

            } else {
                // Jika jadwal bentrok
                $this->session->set_flashdata('error', 'Gagal! Ruangan sudah dibooking pada rentang waktu tersebut.');
            }

            // 7. Redirect kembali ke halaman daftar ruangan
            redirect('ruangan/index');
        }
    }

}
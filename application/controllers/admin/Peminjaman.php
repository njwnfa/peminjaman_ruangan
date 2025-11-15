<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session 
 * @property CI_Input 
 * @property CI_Form_validation 
 * @property Peminjaman_model 
 * @property Ruangan_model 
 * @property CI_DB
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

        $peminjaman = $this->Peminjaman_model->get_by_id($id_peminjaman);

        if (!$peminjaman) {
            $this->session->set_flashdata('error', 'Data peminjaman tidak ditemukan.');
            redirect('admin/peminjaman');
        }

        // Ambil data user peminjam
        $user = $this->db->get_where('users', ['id' => $peminjaman->id_user])->row();

        $data_peminjaman = ['status' => 'disetujui'];
        $data_ruangan = ['status' => 'dipinjam'];

        $update_peminjaman = $this->Peminjaman_model->update($id_peminjaman, $data_peminjaman);
        $update_ruangan = $this->Ruangan_model->update($peminjaman->id_ruangan, $data_ruangan);

        if ($update_peminjaman && $update_ruangan) {

            if (!empty($user->telegram_chat_id)) {

                $mulai  = format_tanggal_indonesia($peminjaman->tanggal_mulai);
                $selesai = format_tanggal_indonesia($peminjaman->tanggal_selesai);

                $pesan = 
        "🎉 *Peminjaman Ruangan Disetujui!*

        📌 *Ruangan:* <b>{$peminjaman->nama_ruangan}</b>
        📅 *Waktu:* 
        - Mulai: <b>$mulai</b>
        - Selesai: <b>$selesai</b>

        Terima kasih telah menggunakan layanan Pilates.";

                send_telegram_message($user->telegram_chat_id, $pesan);
            }

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

        $this->form_validation->set_rules('catatan_admin', 'Alasan Penolakan', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Gagal menolak. Alasan wajib diisi.');
        } else {

            $peminjaman = $this->Peminjaman_model->get_by_id($id_peminjaman);
            $user = $this->db->get_where('users', ['id' => $peminjaman->id_user])->row();

            $data_peminjaman = [
                'status' => 'ditolak',
                'catatan_admin' => $this->input->post('catatan_admin')
            ];

            if ($this->Peminjaman_model->update($id_peminjaman, $data_peminjaman)) {

                if (!empty($user->telegram_chat_id)) {

                    $mulai  = format_tanggal_indonesia($peminjaman->tanggal_mulai);
                    $selesai = format_tanggal_indonesia($peminjaman->tanggal_selesai);

                    $alasan = $this->input->post('catatan_admin');

                    $pesan = 
            "❌ *Peminjaman Ruangan Ditolak*

            📌 *Ruangan:* <b>{$peminjaman->nama_ruangan}</b>
            📅 *Waktu:* 
            - Mulai: <b>$mulai</b>
            - Selesai: <b>$selesai</b>

            📝 *Alasan Penolakan:*  
            _" . $alasan . "_

            Silakan ajukan kembali bila diperlukan.";

                    send_telegram_message($user->telegram_chat_id, $pesan);
                }

                $this->session->set_flashdata('success', 'Peminjaman telah ditolak.');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui status.');
            }
        }

        redirect('admin/peminjaman');
    }

    public function finish($id_peminjaman) {
        // 1. Dapatkan data peminjaman untuk tahu id_ruangan
        $peminjaman = $this->Peminjaman_model->get_by_id($id_peminjaman);

        if (!$peminjaman || $peminjaman->status != 'disetujui') {
            $this->session->set_flashdata('error', 'Data peminjaman tidak valid atau status bukan disetujui.');
            redirect('admin/peminjaman');
        }

        // 2. Data untuk update tabel peminjaman
        $data_peminjaman = [
            'status' => 'selesai'
        ];

        // 3. Data untuk update tabel ruangan (KEMBALIKAN JADI TERSEDIA)
        $data_ruangan = [
            'status' => 'tersedia' 
        ];

        // 4. Lakukan update
        $update_peminjaman = $this->Peminjaman_model->update($id_peminjaman, $data_peminjaman);
        $update_ruangan = $this->Ruangan_model->update($peminjaman->id_ruangan, $data_ruangan);

        if ($update_peminjaman && $update_ruangan) {
            $this->session->set_flashdata('success', 'Peminjaman telah diselesaikan. Status ruangan dikembalikan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui status.');
        }

        redirect('admin/peminjaman');
    }
}
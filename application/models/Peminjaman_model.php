<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        log_message('debug', 'DEBUG >>> Peminjaman_model loaded');
    }

    // Insert data peminjaman
    public function insert($data) {
        return $this->db->insert('peminjaman', $data);
    }

    // Ambil peminjaman berdasarkan user
    public function getByUser($user_id) {
        return $this->db->get_where('peminjaman', ['user_id' => $user_id])->result();
    }

    // Ambil semua data peminjaman (tanpa join ruangan)
    public function getAll() {
        return $this->db->get('peminjaman')->result();
    }

    // 🔥 Ambil semua peminjaman + join tabel ruangan (untuk admin)
    public function getAllWithRuangan() {
        return $this->db->select('peminjaman.*, ruangan.nama_ruangan')
                        ->from('peminjaman')
                        ->join('ruangan', 'ruangan.id = peminjaman.ruangan_id', 'left')
                        ->order_by('peminjaman.id', 'DESC')
                        ->get()
                        ->result();
    }

    // Update status peminjaman
    public function updateStatus($id, $status) {
        return $this->db->where('id', $id)
                        ->update('peminjaman', ['status' => $status]);
    }

    // Ambil satu peminjaman by ID
    public function getById($id) {
        return $this->db->get_where('peminjaman', ['id' => $id])->row();
    }
}

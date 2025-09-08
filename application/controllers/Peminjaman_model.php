<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman_model extends CI_Model {

    protected $table = 'peminjaman';

    // Ambil semua data peminjaman + nama ruangan
    public function getAllWithRuangan() {
        return $this->db->select('p.*, r.nama_ruangan')
                        ->from($this->table . ' p')
                        ->join('ruangan r', 'r.id = p.ruangan_id', 'left')
                        ->order_by('p.id', 'DESC')
                        ->get()
                        ->result();
    }

    // Tambah data peminjaman
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    // Update status peminjaman (pending, disetujui, ditolak)
    public function updateStatus($id, $status) {
        return $this->db->where('id', $id)
                        ->update($this->table, ['status' => $status]);
    }

    // Ambil data berdasarkan ID
    public function getById($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }
}

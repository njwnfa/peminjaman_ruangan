<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB $db
 */
class Peminjaman_model extends CI_Model {

    private $_table = "peminjaman";

    /**
     * Menyimpan data peminjaman baru
     */
    public function save($data) {
        return $this->db->insert($this->_table, $data);
    }

    /**
     * Mengecek apakah waktu yang diminta tersedia (tidak bentrok)
     *
     * @param int $id_ruangan ID ruangan yang akan dicek
     * @param string $start_time Waktu mulai (format 'Y-m-d H:i:s')
     * @param string $end_time Waktu selesai (format 'Y-m-d H:i:s')
     * @return bool TRUE jika tersedia, FALSE jika bentrok
     */
    public function is_waktu_tersedia($id_ruangan, $start_time, $end_time) {
        
        $this->db->where('id_ruangan', $id_ruangan);
        
        // Kita hanya cek jadwal yang masih aktif (menunggu atau disetujui)
        // Jadwal yang 'ditolak' atau 'selesai' bisa ditimpa
        $this->db->where_in('status', ['menunggu', 'disetujui']);

        // Logika Pengecekan Overlap (Bentrok):
        // (StartA < EndB) AND (EndA > StartB)
        // (WaktuMulai_Lama < WaktuSelesai_Baru) AND (WaktuSelesai_Lama > WaktuMulai_Baru)
        
        $this->db->where('tanggal_mulai <', $end_time);
        $this->db->where('tanggal_selesai >', $start_time);

        $query = $this->db->get($this->_table);

        // Jika query menghasilkan 0 baris, berarti TIDAK ADA BENTROK (tersedia)
        return ($query->num_rows() == 0);
    }
    
    public function get_all_joined() {
        $this->db->select('peminjaman.*, users.nama as nama_peminjam, ruangan.nama_ruangan');
        $this->db->from($this->_table);
        $this->db->join('users', 'users.id = peminjaman.id_user');
        
        // INI ADALAH BARIS YANG DIPERBAIKI (Line 51)
        $this->db->join('ruangan', 'ruangan.id_ruangan = peminjaman.id_ruangan');
        
        // 1. Prioritaskan status 'menunggu' (diberi nilai 1)
        $this->db->order_by("CASE WHEN peminjaman.status = 'menunggu' THEN 1 ELSE 2 END", "ASC");
        
        // 2. Urutkan berdasarkan tanggal dibuat (yang terbaru dulu)
        $this->db->order_by('peminjaman.created_at', 'DESC');

        $query = $this->db->get();
        return $query->result();
    }

    /**
     * ==== TAMBAHKAN METHOD INI ====
     *
     * Mengambil satu data peminjaman berdasarkan ID
     */
    public function get_by_id($id) {
        $this->db->where('id_peminjaman', $id);
        return $this->db->get($this->_table)->row();
    }

    /**
     * ==== TAMBAHKAN METHOD INI ====
     *
     * Mengupdate data peminjaman
     */
    public function update($id, $data) {
        $this->db->where('id_peminjaman', $id);
        return $this->db->update($this->_table, $data);
    }
}
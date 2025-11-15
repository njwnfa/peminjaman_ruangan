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
     * Mengecek apakah seorang user memiliki peminjaman yang masih aktif 
     * (status 'menunggu' atau 'disetujui').
     * @param int $id_user ID pengguna yang sedang login
     * @return bool TRUE jika ada peminjaman aktif, FALSE jika tidak ada.
     */
    public function cek_peminjaman_aktif($id_user)
    {
        $this->db->where('id_user', $id_user);
        $this->db->where_in('status', ['menunggu', 'disetujui']);
        $query = $this->db->get($this->_table);
        return ($query->num_rows() > 0);
    }

    /**
     *
     * @param int 
     * @param string 
     * @param string 
     * @return bool
     */
    public function is_waktu_tersedia($id_ruangan, $start_time, $end_time) {
        
        $this->db->where('id_ruangan', $id_ruangan);
        
        // Cek bentrok hanya dengan status 'menunggu' atau 'disetujui'
        $this->db->where_in('status', ['menunggu', 'disetujui']);
        
        // Logika pengecekan tumpang tindih waktu
        $this->db->where('tanggal_mulai <', $end_time);
        $this->db->where('tanggal_selesai >', $start_time);

        $query = $this->db->get($this->_table);

        return ($query->num_rows() == 0);
    }
    
    // ... metode-metode lain seperti get_all_joined(), get_by_id(), update(), dll.
    // ... (metode-metode di bawah ini tidak diubah dan tetap sama)
    
    public function get_all_joined() {
        $this->db->select('peminjaman.*, users.nama as nama_peminjam, ruangan.nama_ruangan');
        $this->db->from($this->_table);
        $this->db->join('users', 'users.id = peminjaman.id_user');
        $this->db->join('ruangan', 'ruangan.id_ruangan = peminjaman.id_ruangan');
        
        $this->db->where_in('peminjaman.status', ['menunggu', 'disetujui']);

        $this->db->order_by("CASE WHEN peminjaman.status = 'menunggu' THEN 1 ELSE 2 END", "ASC");
        
        $this->db->order_by('peminjaman.created_at', 'DESC');

        $query = $this->db->get();
        return $query->result();
    }

    /**
     *
     * Mengambil satu data peminjaman berdasarkan ID
     */
    public function get_by_id($id) {
        $this->db->where('id_peminjaman', $id);
        return $this->db->get($this->_table)->row();
    }

    /**
     *
     * Mengupdate data peminjaman
     */
    public function update($id, $data) {
        $this->db->where('id_peminjaman', $id);
        return $this->db->update($this->_table, $data);
    }

    public function get_rekap_by_filter($bulan, $tahun) {
        $this->db->select('peminjaman.*, users.nama as nama_peminjam, ruangan.nama_ruangan');
        $this->db->from($this->_table);
        $this->db->join('users', 'users.id = peminjaman.id_user');
        $this->db->join('ruangan', 'ruangan.id_ruangan = peminjaman.id_ruangan');
        
        // Filter utama: SELESAI ATAU DITOLAK
        $this->db->where_in('peminjaman.status', ['selesai', 'ditolak']);
        
        // Filter Waktu (Berdasarkan KAPAN DIAJUKAN)
        $this->db->where('MONTH(peminjaman.created_at)', $bulan);
        $this->db->where('YEAR(peminjaman.created_at)', $tahun);
        
        $this->db->order_by('peminjaman.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result();
    }

}
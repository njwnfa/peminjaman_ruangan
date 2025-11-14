<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    // Fungsi untuk menghitung total user
    public function count_total_user() {
        return $this->db->count_all('users'); 
    }

    // Fungsi untuk menghitung total ruangan
    public function count_total_ruangan() {
        return $this->db->count_all('ruangan');
    }

    // Fungsi untuk menghitung total peminjaman
    public function count_total_peminjaman() {
        return $this->db->count_all('peminjaman');
    }

    // Fungsi untuk menghitung total rekap
    public function count_total_rekap() {
        $this->db->from('peminjaman');

        $status_list = ['ditolak', 'selesai']; 
        
        $this->db->where_in('status', $status_list);

        return $this->db->count_all_results();
    }
}
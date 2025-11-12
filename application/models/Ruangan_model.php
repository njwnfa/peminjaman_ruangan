<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruangan_model extends CI_Model {

    private $table = 'ruangan';

    public function getAll() {
        return $this->db->get($this->table)->result();
    }

    public function getById($id_ruangan) {
        return $this->db->get_where($this->table, ['id_ruangan' => $id_ruangan])->row();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        $this->db->where('id_ruangan', $id);
        return $this->db->update('ruangan', $data); // Ganti 'ruangan' jika nama tabel beda
    }

    public function delete($id_ruangan) {
        return $this->db->delete($this->table, ['id_ruangan' => $id_ruangan]);
    }

    public function getAvailable() {
        return $this->db->where('status', 'tersedia')->get($this->table)->result();
    }

}

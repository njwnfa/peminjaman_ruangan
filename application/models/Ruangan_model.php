<?php
class Ruangan_model extends CI_Model {
    public function getAll() {
        return $this->db->get('ruangan')->result();
    }
}

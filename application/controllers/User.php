<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Pastikan hanya admin yang bisa akses
        if ($this->session->userdata('role') != 'admin') {
            redirect('auth/login');
        }

        $this->load->model('User_model');
    }

    // === Menampilkan semua user ===
    public function index() {
        $data['title'] = 'Kelola Pengguna';
        $data['active'] = 'user'; // ini penting untuk menandai menu aktif
        $data['users'] = $this->db->get('users')->result(); // atau gunakan User_model kalau mau
        
        // $this->load->view('layouts/header', $data);
        $this->load->view('admin/manage-user/index', $data);
        // $this->load->view('layouts/footer');
    }

    // === Tambah User Baru ===
    public function add() {
        $data = [
            'nama'      => $this->input->post('nama', true),
            'email'     => $this->input->post('email', true),
            'password'  => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'telegram_chat_id' => $this->input->post('telegram_chat_id', true) ?: NULL,
            'role'      => $this->input->post('role', true),
            'created_at'=> date('Y-m-d H:i:s')
        ];

        $this->User_model->insert($data);
        $this->session->set_flashdata('success', 'User berhasil ditambahkan!');
        redirect('user');
    }

    // === Update User (edit) ===
    public function update($id) {
        $data = [
            'nama' => $this->input->post('nama', true),
            'email' => $this->input->post('email', true),
            'telegram_chat_id' => $this->input->post('telegram_chat_id', true) ?: NULL,
            'role' => $this->input->post('role', true)
        ];

        $password = $this->input->post('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $this->db->where('id', $id)->update('users', $data);
        $this->session->set_flashdata('success', 'User berhasil diperbarui!');
        redirect('user');
    }

    // === Hapus User ===
    public function delete($id) {
        $this->db->where('id', $id)->delete('users');
        $this->session->set_flashdata('success', 'User berhasil dihapus!');
        redirect('user');
    }

    // === Ubah Role User ===
    public function update_role($id) {
        $new_role = $this->input->post('role');
        $this->db->where('id', $id)->update('users', ['role' => $new_role]);
        $this->session->set_flashdata('success', 'Role user berhasil diperbarui!');
        redirect('user');
    }
}

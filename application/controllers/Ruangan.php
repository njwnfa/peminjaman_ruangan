<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Ruangan_model $Ruangan_model
 * @property CI_Session $session
 * @property CI_Input $input
 */
class Ruangan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Ruangan_model');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    // Halaman daftar ruangan
    public function list_ruangan() {
        $data['list_ruangan'] = $this->Ruangan_model->getAll(); // ubah ke list_ruangan
        $data['title']   = "Daftar Ruangan";
        $data['active']  = "ruangan";

        // $this->load->view('layouts/header', $data);
        $this->load->view('admin/manage-ruangan/index', $data);
        // $this->load->view('layouts/footer');
    }

    // Form tambah ruangan
    public function tambah() {
        $data['title']  = "Tambah Ruangan";
        $data['active'] = "ruangan";

        $this->load->view('layouts/header', $data);
        $this->load->view('admin/manage-ruangan/form', $data); // form tambah/edit
        $this->load->view('layouts/footer');
    }

    // Simpan ruangan baru
    public function store() {
        $config['upload_path']   = './assets/images/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;
        $this->load->library('upload', $config);

        $gambar = null;
        if ($this->upload->do_upload('gambar')) {
            $gambar = 'assets/images/'.$this->upload->data('file_name');
        }

        $data = [
            'nama_ruangan' => $this->input->post('nama_ruangan'),
            'kapasitas'    => $this->input->post('kapasitas'),
            'fasilitas'    => $this->input->post('fasilitas'),
            'gambar'       => $gambar,
            'status'       => $this->input->post('status') ?? 'tersedia'
        ];

        $this->Ruangan_model->insert($data);
        $this->session->set_flashdata('success', 'Ruangan berhasil ditambahkan.');
        redirect('ruangan/list_ruangan');
    }

    // Form edit ruangan
    public function edit($id) {
        $data['ruangan'] = $this->Ruangan_model->getById($id); // ini hanya 1 object
        $data['title']   = "Edit Ruangan";
        $data['active']  = "ruangan";

        if (!$data['ruangan']) {
            show_404();
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('admin/manage-ruangan/form', $data);
        $this->load->view('layouts/footer');
    }

    // Update data ruangan
    public function update($id) {
        $ruangan = $this->Ruangan_model->getById($id);
        if (!$ruangan) {
            show_404();
        }

        $config['upload_path']   = './assets/images/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;
        $this->load->library('upload', $config);

        $gambar = $ruangan->gambar;
        if ($this->upload->do_upload('gambar')) {
            $gambar = 'assets/images/'.$this->upload->data('file_name');
        }

        $data = [
            'nama_ruangan' => $this->input->post('nama_ruangan'),
            'kapasitas'    => $this->input->post('kapasitas'),
            'fasilitas'    => $this->input->post('fasilitas'),
            'gambar'       => $gambar,
            'status'       => $this->input->post('status')
        ];

        $this->Ruangan_model->update($id, $data);
        $this->session->set_flashdata('success', 'Ruangan berhasil diperbarui.');
        redirect('ruangan/list_ruangan');
    }

    // Hapus ruangan
    public function hapus($id) {
        $this->Ruangan_model->delete($id);
        $this->session->set_flashdata('success', 'Ruangan berhasil dihapus.');
        redirect('ruangan/list_ruangan');
    }

    // Form ajukan ruangan
    public function ajukan($id) {
        $ruangan = $this->Ruangan_model->getById($id);
        if (!$ruangan) {
            show_404();
        }
        // sementara hanya tampilkan pesan
        echo "Form ajukan ruangan dengan ID: ".$id;
    }
}

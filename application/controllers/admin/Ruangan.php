<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Session $session
 * @property Ruangan_model $Ruangan_model
 */
class Ruangan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') != 'admin') {
            redirect('auth/login');
        }
        $this->load->model('Ruangan_model');
    }

    public function index() {
        $data['title'] = 'Kelola Ruangan';
        $data['active'] = 'ruangan';
        $data['ruangan'] = $this->Ruangan_model->getAll();
        $this->load->view('admin/manage-ruangan/index', $data);
    }

    /** -------------------------------
     * TAMBAH RUANGAN BARU
     * ------------------------------ */
    public function add() {
        $nama = $this->input->post('nama_ruangan', true);
        $kapasitas = $this->input->post('kapasitas', true);
        $status = $this->input->post('status', true) ?? 'tersedia';

        // Pastikan folder upload ada
        $upload_path = './uploads/ruangan/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        // Upload gambar (opsional)
        $gambar = null;
        if (!empty($_FILES['gambar']['name'])) {
            $config['upload_path']   = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('gambar')) {
                $upload_data = $this->upload->data();
                $gambar = $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('admin/ruangan');
                return;
            }
        }

        $data = [
            'nama_ruangan' => $nama,
            'kapasitas'    => $kapasitas,
            'status'       => $status,
            'gambar'       => $gambar,
            'created_at'   => date('Y-m-d H:i:s')
        ];

        $this->Ruangan_model->insert($data);
        $this->session->set_flashdata('success', 'Ruangan berhasil ditambahkan!');
        redirect('admin/ruangan');
    }

    /** -------------------------------
     * UPDATE RUANGAN
     * ------------------------------ */
    public function update($id) {
        $ruangan = $this->Ruangan_model->getById($id);
        if (!$ruangan) {
            $this->session->set_flashdata('error', 'Ruangan tidak ditemukan.');
            redirect('admin/ruangan');
        }

        $nama = $this->input->post('nama_ruangan', true);
        $kapasitas = $this->input->post('kapasitas', true);
        $status = $this->input->post('status', true);

        // Upload gambar baru jika ada
        $gambar = $ruangan->gambar;
        if (!empty($_FILES['gambar']['name'])) {
            $config['upload_path'] = './uploads/ruangan/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('gambar')) {
                // Hapus gambar lama jika ada
                if ($gambar && file_exists('./uploads/ruangan/' . $gambar)) {
                    unlink('./uploads/ruangan/' . $gambar);
                }
                $upload_data = $this->upload->data();
                $gambar = $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('admin/ruangan');
                return;
            }
        }

        $data = [
            'nama_ruangan' => $nama,
            'kapasitas'    => $kapasitas,
            'status'       => $status,
            'gambar'       => $gambar,
            'updated_at'   => date('Y-m-d H:i:s')
        ];

        $this->Ruangan_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data ruangan berhasil diperbarui!');
        redirect('admin/ruangan');
    }

    /** -------------------------------
     * HAPUS RUANGAN
     * ------------------------------ */
    public function delete($id) {
        $ruangan = $this->Ruangan_model->getById($id);
        if (!$ruangan) {
            $this->session->set_flashdata('error', 'Ruangan tidak ditemukan.');
            redirect('admin/ruangan');
        }

        // Hapus gambar dari folder
        if ($ruangan->gambar && file_exists('./uploads/ruangan/' . $ruangan->gambar)) {
            unlink('./uploads/ruangan/' . $ruangan->gambar);
        }

        $this->Ruangan_model->delete($id);
        $this->session->set_flashdata('success', 'Ruangan berhasil dihapus!');
        redirect('admin/ruangan');
    }
}

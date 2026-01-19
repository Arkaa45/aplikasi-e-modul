<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laboran extends Laboran_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Matkum_model', 'Modul_model', 'Semester_model', 'Rps_model', 'Referensi_model'));
    }

    /**
     * Dashboard - Mata Praktikum List
     */
    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $my_matkum = $this->Matkum_model->get_by_laboran($user_id);

        $data = array(
            'title' => 'Dashboard Laboran',
            'page_title' => 'Mata Praktikum Saya',
            'my_matkum' => $my_matkum,
            'current_semester' => $this->Semester_model->get_latest()
        );

        $this->load_view('laboran/index', $data);
    }

    /**
     * Mata Praktikum Detail with Content
     */
    public function matkum($id)
    {
        $user_id = $this->session->userdata('user_id');

        // Verify laboran has access to this matkum
        if (!$this->Matkum_model->is_laboran_assigned($id, $user_id)) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke mata praktikum ini');
            redirect('laboran');
        }

        $matkum = $this->Matkum_model->get_with_content_counts($id);
        if (!$matkum) {
            $this->session->set_flashdata('error', 'Mata praktikum tidak ditemukan');
            redirect('laboran');
        }

        $data = array(
            'title' => $matkum->nama_matkul,
            'page_title' => $matkum->kode_matkul . ' - ' . $matkum->nama_matkul,
            'matkum' => $matkum,
            'rps_list' => $this->Rps_model->get_by_matkul($id),
            'referensi_list' => $this->Referensi_model->get_by_matkul($id),
            'modul_slots' => $this->Modul_model->get_slots_by_matkul($id, 16)
        );

        $this->load_view('laboran/matkum_detail', $data);
    }

    /**
     * Upload Content (RPS, Referensi, Modul)
     */
    public function upload($type, $matkum_id)
    {
        $user_id = $this->session->userdata('user_id');

        // Verify access
        if (!$this->Matkum_model->is_laboran_assigned($matkum_id, $user_id)) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses');
            redirect('laboran');
        }

        $matkum = $this->Matkum_model->get_by_id($matkum_id);
        if (!$matkum) {
            $this->session->set_flashdata('error', 'Mata praktikum tidak ditemukan');
            redirect('laboran');
        }

        if ($this->input->post()) {
            switch ($type) {
                case 'rps':
                    $this->upload_rps($matkum_id, $user_id);
                    break;
                case 'referensi':
                    $this->upload_referensi($matkum_id, $user_id);
                    break;
                case 'modul':
                    $this->upload_modul($matkum_id, $user_id);
                    break;
            }
            redirect('laboran/matkum/' . $matkum_id);
        }

        $data = array(
            'title' => 'Upload ' . ucfirst($type),
            'page_title' => 'Upload ' . ucfirst($type) . ' - ' . $matkum->nama_matkul,
            'matkum' => $matkum,
            'type' => $type
        );

        if ($type == 'modul') {
            $data['available_slots'] = array();
            for ($i = 1; $i <= 16; $i++) {
                if ($this->Modul_model->is_slot_available($matkum_id, $i)) {
                    $data['available_slots'][] = $i;
                }
            }
        }

        $this->load_view('laboran/upload_content', $data);
    }

    private function upload_rps($matkum_id, $user_id)
    {
        if (!empty($_FILES['file']['name'])) {
            $upload = $this->do_upload('file', 'rps');
            if ($upload['success']) {
                $data = array(
                    'id_matkul' => $matkum_id,
                    'judul' => $this->input->post('judul', TRUE),
                    'file_path' => $upload['file_name'],
                    'uploaded_by' => $user_id
                );
                $this->Rps_model->create($data);
                $this->log_activity('upload_rps', 'Uploaded RPS');
                $this->session->set_flashdata('success', 'RPS berhasil diupload');
            } else {
                $this->session->set_flashdata('error', $upload['error']);
            }
        }
    }

    private function upload_referensi($matkum_id, $user_id)
    {
        $tipe = $this->input->post('tipe');
        $data = array(
            'id_matkul' => $matkum_id,
            'judul' => $this->input->post('judul', TRUE),
            'deskripsi' => $this->input->post('deskripsi', TRUE),
            'tipe' => $tipe,
            'uploaded_by' => $user_id
        );

        if ($tipe == 'file' && !empty($_FILES['file']['name'])) {
            $upload = $this->do_upload('file', 'referensi');
            if ($upload['success']) {
                $data['file_path'] = $upload['file_name'];
            } else {
                $this->session->set_flashdata('error', $upload['error']);
                return;
            }
        } else if ($tipe == 'link') {
            $data['link_external'] = $this->input->post('link_external', TRUE);
        }

        $this->Referensi_model->create($data);
        $this->log_activity('upload_referensi', 'Uploaded Referensi');
        $this->session->set_flashdata('success', 'Referensi berhasil ditambahkan');
    }

    private function upload_modul($matkum_id, $user_id)
    {
        $slot = $this->input->post('slot_number');
        $tipe_file = $this->input->post('tipe_file');

        $data = array(
            'id_matkul' => $matkum_id,
            'slot_number' => $slot,
            'judul_modul' => $this->input->post('judul_modul', TRUE),
            'deskripsi' => $this->input->post('deskripsi', TRUE),
            'tipe_file' => $tipe_file,
            'uploaded_by' => $user_id,
            'is_visible' => $this->input->post('is_visible') ? 1 : 0
        );

        if ($tipe_file == 'link') {
            $data['link_external'] = $this->input->post('link_external', TRUE);
        } else if (!empty($_FILES['file_modul']['name'])) {
            $upload = $this->do_upload('file_modul', 'modul');
            if ($upload['success']) {
                $data['file_modul'] = $upload['file_name'];
            } else {
                $this->session->set_flashdata('error', $upload['error']);
                return;
            }
        }

        $this->Modul_model->create($data);
        $this->log_activity('upload_modul', 'Uploaded Modul slot ' . $slot);
        $this->session->set_flashdata('success', 'Modul berhasil diupload');
    }

    /**
     * Edit Modul
     */
    public function edit_modul($id)
    {
        $user_id = $this->session->userdata('user_id');
        $modul = $this->Modul_model->get_detail($id);

        if (!$modul) {
            $this->session->set_flashdata('error', 'Modul tidak ditemukan');
            redirect('laboran');
        }

        // Verify access
        if (!$this->Matkum_model->is_laboran_assigned($modul->id_matkul, $user_id)) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses');
            redirect('laboran');
        }

        if ($this->input->post()) {
            $modul_data = array(
                'judul_modul' => $this->input->post('judul_modul', TRUE),
                'deskripsi' => $this->input->post('deskripsi', TRUE),
                'tipe_file' => $this->input->post('tipe_file', TRUE),
                'link_external' => $this->input->post('link_external', TRUE),
                'is_visible' => $this->input->post('is_visible') ? 1 : 0
            );

            // Handle file upload if new file provided
            if (!empty($_FILES['file_modul']['name'])) {
                $upload = $this->do_upload('file_modul', 'modul');
                if ($upload['success']) {
                    // Delete old file
                    if ($modul->file_modul) {
                        $old_file = FCPATH . 'uploads/modul/' . $modul->file_modul;
                        if (file_exists($old_file)) {
                            unlink($old_file);
                        }
                    }
                    $modul_data['file_modul'] = $upload['file_name'];
                } else {
                    $this->session->set_flashdata('error', $upload['error']);
                    redirect('laboran/edit_modul/' . $id);
                }
            }

            $this->Modul_model->update($id, $modul_data);
            $this->log_activity('update_modul', 'Updated modul: ' . $modul_data['judul_modul']);
            $this->session->set_flashdata('success', 'Modul berhasil diperbarui');
            redirect('laboran/matkum/' . $modul->id_matkul);
        }

        $data = array(
            'title' => 'Edit Modul',
            'page_title' => 'Edit Modul',
            'modul' => $modul
        );

        $this->load_view('laboran/edit_modul', $data);
    }

    /**
     * Delete Content
     */
    public function delete($type, $id)
    {
        $user_id = $this->session->userdata('user_id');
        $matkum_id = null;

        switch ($type) {
            case 'rps':
                $item = $this->Rps_model->get_by_id($id);
                if ($item && $this->Matkum_model->is_laboran_assigned($item->id_matkul, $user_id)) {
                    $matkum_id = $item->id_matkul;
                    $this->Rps_model->delete($id);
                    $this->log_activity('delete_rps', 'Deleted RPS');
                    $this->session->set_flashdata('success', 'RPS berhasil dihapus');
                }
                break;
            case 'referensi':
                $item = $this->Referensi_model->get_by_id($id);
                if ($item && $this->Matkum_model->is_laboran_assigned($item->id_matkul, $user_id)) {
                    $matkum_id = $item->id_matkul;
                    $this->Referensi_model->delete($id);
                    $this->log_activity('delete_referensi', 'Deleted Referensi');
                    $this->session->set_flashdata('success', 'Referensi berhasil dihapus');
                }
                break;
            case 'modul':
                $item = $this->Modul_model->get_by_id($id);
                if ($item && $this->Matkum_model->is_laboran_assigned($item->id_matkul, $user_id)) {
                    $matkum_id = $item->id_matkul;
                    $this->Modul_model->delete($id);
                    $this->log_activity('delete_modul', 'Deleted Modul');
                    $this->session->set_flashdata('success', 'Modul berhasil dihapus');
                }
                break;
        }

        if ($matkum_id) {
            redirect('laboran/matkum/' . $matkum_id);
        } else {
            redirect('laboran');
        }
    }

    /**
     * Toggle modul visibility
     */
    public function toggle_modul($id)
    {
        $user_id = $this->session->userdata('user_id');
        $modul = $this->Modul_model->get_by_id($id);

        if ($modul && $this->Matkum_model->is_laboran_assigned($modul->id_matkul, $user_id)) {
            $this->Modul_model->toggle_visibility($id);
            $this->session->set_flashdata('success', 'Visibilitas modul berhasil diubah');
            redirect('laboran/matkum/' . $modul->id_matkul);
        }

        redirect('laboran');
    }

    /**
     * File upload helper
     */
    private function do_upload($field_name, $folder)
    {
        $config = array(
            'upload_path' => FCPATH . 'uploads/' . $folder . '/',
            'allowed_types' => 'pdf|doc|docx|ppt|pptx|xls|xlsx|mp4|webm|zip|rar',
            'max_size' => 51200,
            'encrypt_name' => TRUE
        );

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, TRUE);
        }

        $this->load->library('upload', $config);

        if ($this->upload->do_upload($field_name)) {
            $upload_data = $this->upload->data();
            return array('success' => true, 'file_name' => $upload_data['file_name']);
        } else {
            return array('success' => false, 'error' => $this->upload->display_errors('', ''));
        }
    }
}

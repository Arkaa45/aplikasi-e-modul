<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laboran extends Laboran_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Matkul_model', 'Pertemuan_model', 'Modul_model', 'Semester_model'));
    }

    /**
     * Modul Management
     */
    public function modul($action = 'index', $id = null)
    {
        switch ($action) {
            case 'edit':
                $this->modul_form($id);
                break;
            case 'delete':
                $this->modul_delete($id);
                break;
            case 'toggle':
                $this->modul_toggle($id);
                break;
            default:
                $this->modul_list();
        }
    }

    private function modul_list()
    {
        $user_id = $this->session->userdata('user_id');
        $matkul_filter = $this->input->get('matkul');

        $data = array(
            'title' => 'Kelola Modul',
            'page_title' => 'Kelola Modul',
            'moduls' => $this->Modul_model->get_by_uploader($user_id),
            'my_matkul' => $this->Matkul_model->get_by_laboran($user_id),
            'matkul_filter' => $matkul_filter
        );

        $this->load_view('laboran/modul/index', $data);
    }

    private function modul_form($id)
    {
        $user_id = $this->session->userdata('user_id');
        $modul = $this->Modul_model->get_detail($id);

        if (!$modul || $modul->uploaded_by != $user_id) {
            $this->session->set_flashdata('error', 'Modul tidak ditemukan atau bukan milik Anda');
            redirect('laboran/modul');
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
                $upload_result = $this->do_upload('file_modul');
                if ($upload_result['success']) {
                    // Delete old file
                    if ($modul->file_modul) {
                        $old_file = FCPATH . 'uploads/modul/' . $modul->file_modul;
                        if (file_exists($old_file)) {
                            unlink($old_file);
                        }
                    }
                    $modul_data['file_modul'] = $upload_result['file_name'];
                } else {
                    $this->session->set_flashdata('error', $upload_result['error']);
                    redirect('laboran/modul/edit/' . $id);
                }
            }

            $this->Modul_model->update($id, $modul_data);
            $this->log_activity('update_modul', 'Updated modul: ' . $modul_data['judul_modul']);
            $this->session->set_flashdata('success', 'Modul berhasil diperbarui');
            redirect('laboran/modul');
        }

        $data = array(
            'title' => 'Edit Modul',
            'page_title' => 'Edit Modul',
            'modul' => $modul
        );

        $this->load_view('laboran/modul/edit', $data);
    }

    private function modul_delete($id)
    {
        $user_id = $this->session->userdata('user_id');
        $modul = $this->Modul_model->get_by_id($id);

        if ($modul && $modul->uploaded_by == $user_id) {
            $this->Modul_model->delete($id);
            $this->log_activity('delete_modul', 'Deleted modul: ' . $modul->judul_modul);
            $this->session->set_flashdata('success', 'Modul berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Modul tidak ditemukan');
        }

        redirect('laboran/modul');
    }

    private function modul_toggle($id)
    {
        $user_id = $this->session->userdata('user_id');
        $modul = $this->Modul_model->get_by_id($id);

        if ($modul && $modul->uploaded_by == $user_id) {
            $this->Modul_model->toggle_visibility($id);
            $this->session->set_flashdata('success', 'Visibilitas modul berhasil diubah');
        }

        redirect('laboran/modul');
    }

    /**
     * Upload Modul
     */
    public function upload()
    {
        $user_id = $this->session->userdata('user_id');
        $my_matkul = $this->Matkul_model->get_by_laboran($user_id);
        $current_semester = $this->Semester_model->get_active();

        if ($this->input->post()) {
            $pertemuan_id = $this->input->post('pertemuan_id');
            $tipe_file = $this->input->post('tipe_file', TRUE);

            $modul_data = array(
                'id_pertemuan' => $pertemuan_id,
                'judul_modul' => $this->input->post('judul_modul', TRUE),
                'deskripsi' => $this->input->post('deskripsi', TRUE),
                'tipe_file' => $tipe_file,
                'uploaded_by' => $user_id,
                'is_visible' => $this->input->post('is_visible') ? 1 : 0
            );

            // Handle file upload
            if ($tipe_file == 'pdf' || $tipe_file == 'video' || $tipe_file == 'lainnya') {
                if (!empty($_FILES['file_modul']['name'])) {
                    $upload_result = $this->do_upload('file_modul');
                    if ($upload_result['success']) {
                        $modul_data['file_modul'] = $upload_result['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $upload_result['error']);
                        redirect('laboran/upload');
                    }
                }
            } else if ($tipe_file == 'link') {
                $modul_data['link_external'] = $this->input->post('link_external', TRUE);
            }

            $this->Modul_model->create($modul_data);
            $this->log_activity('upload_modul', 'Uploaded modul: ' . $modul_data['judul_modul']);
            $this->session->set_flashdata('success', 'Modul berhasil diupload');
            redirect('laboran/modul');
        }

        // Get pertemuan for all matkul
        $pertemuan_by_matkul = array();
        foreach ($my_matkul as $matkul) {
            if ($current_semester) {
                $pertemuan_by_matkul[$matkul->id] = $this->Pertemuan_model->get_by_matkul($matkul->id, $current_semester->id);
            }
        }

        $data = array(
            'title' => 'Upload Modul',
            'page_title' => 'Upload Modul Baru',
            'my_matkul' => $my_matkul,
            'pertemuan_by_matkul' => $pertemuan_by_matkul,
            'current_semester' => $current_semester
        );

        $this->load_view('laboran/modul/upload', $data);
    }

    /**
     * Pertemuan Management
     */
    public function pertemuan($action = 'index', $id = null)
    {
        switch ($action) {
            case 'create':
                $this->pertemuan_form();
                break;
            case 'edit':
                $this->pertemuan_form($id);
                break;
            case 'delete':
                $this->pertemuan_delete($id);
                break;
            default:
                $this->pertemuan_list();
        }
    }

    private function pertemuan_list()
    {
        $user_id = $this->session->userdata('user_id');
        $matkul_id = $this->input->get('matkul');
        $my_matkul = $this->Matkul_model->get_by_laboran($user_id);
        $current_semester = $this->Semester_model->get_active();

        $pertemuan = array();
        if ($matkul_id && $current_semester) {
            $pertemuan = $this->Pertemuan_model->get_by_matkul($matkul_id, $current_semester->id);
        }

        $data = array(
            'title' => 'Kelola Pertemuan',
            'page_title' => 'Kelola Pertemuan',
            'my_matkul' => $my_matkul,
            'pertemuan' => $pertemuan,
            'matkul_id' => $matkul_id,
            'current_semester' => $current_semester
        );

        $this->load_view('laboran/pertemuan/index', $data);
    }

    private function pertemuan_form($id = null)
    {
        $user_id = $this->session->userdata('user_id');
        $my_matkul = $this->Matkul_model->get_by_laboran($user_id);
        $current_semester = $this->Semester_model->get_active();

        if ($this->input->post()) {
            $pertemuan_data = array(
                'id_matkul' => $this->input->post('id_matkul'),
                'id_semester' => $current_semester->id,
                'pertemuan_ke' => $this->input->post('pertemuan_ke'),
                'judul' => $this->input->post('judul', TRUE),
                'deskripsi' => $this->input->post('deskripsi', TRUE),
                'tanggal' => $this->input->post('tanggal')
            );

            if ($id) {
                $this->Pertemuan_model->update($id, $pertemuan_data);
                $this->log_activity('update_pertemuan', 'Updated pertemuan');
                $this->session->set_flashdata('success', 'Pertemuan berhasil diperbarui');
            } else {
                $this->Pertemuan_model->create($pertemuan_data);
                $this->log_activity('create_pertemuan', 'Created pertemuan');
                $this->session->set_flashdata('success', 'Pertemuan berhasil ditambahkan');
            }

            redirect('laboran/pertemuan?matkul=' . $pertemuan_data['id_matkul']);
        }

        $pertemuan_data = $id ? $this->Pertemuan_model->get_by_id($id) : null;

        $data = array(
            'title' => $id ? 'Edit Pertemuan' : 'Tambah Pertemuan',
            'page_title' => $id ? 'Edit Pertemuan' : 'Tambah Pertemuan',
            'my_matkul' => $my_matkul,
            'pertemuan_data' => $pertemuan_data,
            'current_semester' => $current_semester,
            'edit_mode' => $id ? true : false
        );

        $this->load_view('laboran/pertemuan/form', $data);
    }

    private function pertemuan_delete($id)
    {
        $pertemuan = $this->Pertemuan_model->get_by_id($id);
        if ($pertemuan) {
            $this->Pertemuan_model->delete($id);
            $this->log_activity('delete_pertemuan', 'Deleted pertemuan');
            $this->session->set_flashdata('success', 'Pertemuan berhasil dihapus');
            redirect('laboran/pertemuan?matkul=' . $pertemuan->id_matkul);
        }
        redirect('laboran/pertemuan');
    }

    /**
     * File upload helper
     */
    private function do_upload($field_name)
    {
        $config = array(
            'upload_path' => FCPATH . 'uploads/modul/',
            'allowed_types' => 'pdf|doc|docx|ppt|pptx|mp4|webm|zip|rar',
            'max_size' => 51200, // 50MB
            'encrypt_name' => TRUE
        );

        $this->load->library('upload', $config);

        if ($this->upload->do_upload($field_name)) {
            $upload_data = $this->upload->data();
            return array(
                'success' => true,
                'file_name' => $upload_data['file_name']
            );
        } else {
            return array(
                'success' => false,
                'error' => $this->upload->display_errors('', '')
            );
        }
    }

    /**
     * AJAX: Get pertemuan by matkul
     */
    public function get_pertemuan_ajax($matkul_id)
    {
        $current_semester = $this->Semester_model->get_active();
        $pertemuan = array();

        if ($current_semester) {
            $pertemuan = $this->Pertemuan_model->get_by_matkul($matkul_id, $current_semester->id);
        }

        header('Content-Type: application/json');
        echo json_encode($pertemuan);
    }
}

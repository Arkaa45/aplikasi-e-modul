<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laboran extends Laboran_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Matkum_model', 'Pertemuan_model', 'Modul_model', 'Semester_model'));
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
            case 'view':
                $this->modul_view($id);
                break;
            case 'toggle':
                $this->modul_toggle($id);
                break;
            default:
                // If action is index but id is present (e.g. modul/index/change), pass id
                if ($action == 'index' && !empty($id)) {
                    $this->modul_list($id);
                } else {
                    $this->modul_list($action); // pass action as potential matkum_id
                }
        }
    }

    private function modul_list($matkum_id = null)
    {
        $user_id = $this->session->userdata('user_id');
        $my_matkum = $this->Matkum_model->get_by_laboran($user_id);
        $current_semester = $this->Semester_model->get_active();

        // Check for 'change' action to reset selection
        if ($matkum_id === 'change') {
            $this->session->unset_userdata('modul_list_matkum_id');
            redirect('laboran/modul');
        }

        // If numeric argument passed, treat as matkum_id
        if (is_numeric($matkum_id)) {
            $this->session->set_userdata('modul_list_matkum_id', $matkum_id);
        }

        $selected_matkum_id = $this->session->userdata('modul_list_matkum_id');

        // If no matkum selected, show selection page
        if (!$selected_matkum_id) {
            $data = array(
                'title' => 'Pilih Mata Praktikum',
                'page_title' => 'Pilih Mata Praktikum',
                'my_matkum' => $my_matkum,
                'current_semester' => $current_semester,
                'target_url' => 'laboran/modul'
            );
            $this->load_view('laboran/modul/select_matkul', $data);
            return;
        }

        // Get selected matkum info
        $selected_matkum = $this->Matkum_model->get_by_id($selected_matkum_id);
        if (!$selected_matkum) {
            $this->session->unset_userdata('modul_list_matkum_id');
            redirect('laboran/modul');
        }

        $data = array(
            'title' => 'Kelola Modul',
            'page_title' => 'Kelola Modul - ' . $selected_matkum->nama_matkul,
            'moduls' => $this->Modul_model->get_by_matkul_uploader($selected_matkum_id, $user_id),
            'selected_matkum' => $selected_matkum,
            'current_semester' => $current_semester
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

    private function modul_view($id)
    {
        $user_id = $this->session->userdata('user_id');
        $modul = $this->Modul_model->get_detail($id);

        if (!$modul || $modul->uploaded_by != $user_id) {
            $this->session->set_flashdata('error', 'Modul tidak ditemukan atau bukan milik Anda');
            redirect('laboran/modul');
        }

        $data = array(
            'title' => 'Detail Modul',
            'page_title' => 'Detail Modul',
            'modul' => $modul
        );

        $this->load_view('laboran/modul/view', $data);
    }

    /**
     * Upload Modul
     */
    public function upload($matkum_id = null)
    {
        $user_id = $this->session->userdata('user_id');
        $my_matkum = $this->Matkum_model->get_by_laboran($user_id);
        $current_semester = $this->Semester_model->get_active();

        if (empty($my_matkum)) {
            $this->load_view('laboran/modul/empty_state', [
                'title' => 'Upload Modul',
                'message' => 'Anda belum ditugaskan ke mata praktikum manapun.'
            ]);
            return;
        }

        // Check if matkum is selected or passed in URL
        if (!$matkum_id) {
            // Check session
            $matkum_id = $this->session->userdata('upload_matkum_id');
        }

        // If still no matkum_id, show selection
        if (!$matkum_id) {
            $data = array(
                'title' => 'Upload Modul - Pilih Mata Praktikum',
                'page_title' => 'Upload Modul',
                'my_matkum' => $my_matkum,
                'current_semester' => $current_semester,
                'target_url' => 'laboran/upload'
            );
            $this->load_view('laboran/modul/select_matkul', $data);
            return;
        }

        // Save selection to session
        $this->session->set_userdata('upload_matkum_id', $matkum_id);

        $selected_matkum = $this->Matkum_model->get_by_id($matkum_id);

        // Validate access
        $has_access = false;
        foreach ($my_matkum as $mk) {
            if ($mk->id == $matkum_id) {
                $has_access = true;
                break;
            }
        }

        if (!$has_access) {
            $this->session->unset_userdata('upload_matkum_id');
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke mata praktikum ini.');
            redirect('laboran/upload');
        }

        if ($this->input->post()) {
            $judul_modul = $this->input->post('judul_modul', TRUE);

            // Auto create pertemuan
            $pertemuan_id = $this->Pertemuan_model->create_auto($matkum_id, $current_semester->id, $judul_modul);

            $tipe_file = $this->input->post('tipe_file', TRUE);

            $modul_data = array(
                'id_pertemuan' => $pertemuan_id,
                'judul_modul' => $judul_modul,
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
                        // Rollback pertemuan creation if upload fails
                        $this->Pertemuan_model->delete($pertemuan_id);

                        $this->session->set_flashdata('error', $upload_result['error']);
                        redirect('laboran/upload');
                    }
                }
            } else if ($tipe_file == 'link') {
                $modul_data['link_external'] = $this->input->post('link_external', TRUE);
            }

            $this->Modul_model->create($modul_data);
            $this->log_activity('upload_modul', 'Uploaded modul and created pertemuan: ' . $modul_data['judul_modul']);
            $this->session->set_flashdata('success', 'Modul berhasil diupload dan Pertemuan baru berhasil dibuat! Tambahkan modul lainnya atau klik Selesai.');
            redirect('laboran/upload'); // Redirect back to continue adding
        }

        $data = array(
            'title' => 'Upload Modul',
            'page_title' => 'Upload Modul - ' . $selected_matkum->nama_matkul,
            'selected_matkum' => $selected_matkum,
            'current_semester' => $current_semester
        );

        $this->load_view('laboran/modul/upload_form', $data);
    }

    /**
     * Clear selected matkul and go to modul list
     */
    public function finish_upload()
    {
        $this->session->unset_userdata('selected_matkul_id');
        redirect('laboran/modul');
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


}

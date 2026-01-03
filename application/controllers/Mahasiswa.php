<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends Mahasiswa_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Matkul_model', 'Pertemuan_model', 'Modul_model', 'Semester_model'));
    }

    /**
     * Semester Selection
     */
    public function semester()
    {
        $user_id = $this->session->userdata('user_id');
        $accessible_semesters = $this->Semester_model->get_accessible();

        $data = array(
            'title' => 'Pilih Semester',
            'page_title' => 'Pilih Semester',
            'semesters' => $accessible_semesters
        );

        $this->load_view('mahasiswa/semester', $data);
    }

    /**
     * Mata Kuliah List for a Semester
     */
    public function matkul($semester_id = null)
    {
        $user_id = $this->session->userdata('user_id');

        // Use active semester if not specified
        if (!$semester_id) {
            $active_semester = $this->Semester_model->get_active();
            if ($active_semester) {
                $semester_id = $active_semester->id;
            }
        }

        // Check if semester is accessible
        if (!$this->Semester_model->is_accessible($semester_id)) {
            $this->session->set_flashdata('error', 'Semester tidak dapat diakses');
            redirect('mahasiswa/semester');
        }

        $semester = $this->Semester_model->get_by_id($semester_id);
        $my_matkul = $this->Matkul_model->get_by_mahasiswa($user_id, $semester_id);

        $data = array(
            'title' => 'Mata Kuliah Praktikum',
            'page_title' => 'Mata Kuliah Praktikum',
            'semester' => $semester,
            'matkuls' => $my_matkul
        );

        $this->load_view('mahasiswa/matkul', $data);
    }

    /**
     * Pertemuan List for a Mata Kuliah
     */
    public function pertemuan($matkul_id)
    {
        $user_id = $this->session->userdata('user_id');

        // Get current or active semester
        $semester_id = $this->input->get('semester');
        if (!$semester_id) {
            $active_semester = $this->Semester_model->get_active();
            $semester_id = $active_semester ? $active_semester->id : null;
        }

        // Check semester accessibility
        if (!$this->Semester_model->is_accessible($semester_id)) {
            $this->session->set_flashdata('error', 'Semester tidak dapat diakses');
            redirect('mahasiswa/semester');
        }

        $matkul = $this->Matkul_model->get_by_id($matkul_id);
        $semester = $this->Semester_model->get_by_id($semester_id);
        $pertemuan = $this->Pertemuan_model->get_by_matkul($matkul_id, $semester_id);

        // Get modul count for each pertemuan
        foreach ($pertemuan as &$p) {
            $p->modul_count = count($this->Modul_model->get_by_pertemuan($p->id, true));
        }

        $data = array(
            'title' => 'Pertemuan - ' . $matkul->nama_matkul,
            'page_title' => $matkul->nama_matkul,
            'matkul' => $matkul,
            'semester' => $semester,
            'pertemuan' => $pertemuan
        );

        $this->load_view('mahasiswa/pertemuan', $data);
    }

    /**
     * Modul List for a Pertemuan
     */
    public function modul($pertemuan_id)
    {
        $pertemuan = $this->Pertemuan_model->get_detail($pertemuan_id);

        if (!$pertemuan) {
            $this->session->set_flashdata('error', 'Pertemuan tidak ditemukan');
            redirect('dashboard');
        }

        // Check semester accessibility
        if (!$this->Semester_model->is_accessible($pertemuan->id_semester)) {
            $this->session->set_flashdata('error', 'Modul tidak dapat diakses');
            redirect('mahasiswa/semester');
        }

        $moduls = $this->Modul_model->get_by_pertemuan($pertemuan_id, true);

        $data = array(
            'title' => 'Modul - Pertemuan ' . $pertemuan->pertemuan_ke,
            'page_title' => 'Pertemuan ' . $pertemuan->pertemuan_ke . ': ' . $pertemuan->judul,
            'pertemuan' => $pertemuan,
            'moduls' => $moduls
        );

        $this->load_view('mahasiswa/modul', $data);
    }

    /**
     * Download Modul
     */
    public function download($modul_id)
    {
        $modul = $this->Modul_model->get_detail($modul_id);

        if (!$modul || !$modul->is_visible) {
            $this->session->set_flashdata('error', 'Modul tidak ditemukan');
            redirect('dashboard');
        }

        // Check semester accessibility
        $pertemuan = $this->Pertemuan_model->get_by_id($modul->id_pertemuan);
        if (!$this->Semester_model->is_accessible($pertemuan->id_semester)) {
            $this->session->set_flashdata('error', 'Modul tidak dapat diakses');
            redirect('mahasiswa/semester');
        }

        // Increment download count
        $this->Modul_model->increment_download($modul_id);

        // Log activity
        $this->log_activity('download_modul', 'Downloaded: ' . $modul->judul_modul);

        // Handle different file types
        if ($modul->tipe_file == 'link') {
            redirect($modul->link_external);
        } else {
            $file_path = FCPATH . 'uploads/modul/' . $modul->file_modul;

            if (file_exists($file_path)) {
                $this->load->helper('download');
                force_download($file_path, NULL);
            } else {
                $this->session->set_flashdata('error', 'File tidak ditemukan');
                redirect('mahasiswa/modul/' . $modul->id_pertemuan);
            }
        }
    }

    /**
     * View Modul (PDF Viewer)
     */
    public function view($modul_id)
    {
        $modul = $this->Modul_model->get_detail($modul_id);

        if (!$modul || !$modul->is_visible) {
            $this->session->set_flashdata('error', 'Modul tidak ditemukan');
            redirect('dashboard');
        }

        // Check semester accessibility
        $pertemuan = $this->Pertemuan_model->get_by_id($modul->id_pertemuan);
        if (!$this->Semester_model->is_accessible($pertemuan->id_semester)) {
            $this->session->set_flashdata('error', 'Modul tidak dapat diakses');
            redirect('mahasiswa/semester');
        }

        // Increment download count (as view)
        $this->Modul_model->increment_download($modul_id);

        // Handle different file types
        if ($modul->tipe_file == 'link') {
            redirect($modul->link_external);
        } else if ($modul->tipe_file == 'pdf') {
            $file_path = FCPATH . 'uploads/modul/' . $modul->file_modul;

            if (file_exists($file_path)) {
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename="' . $modul->judul_modul . '.pdf"');
                readfile($file_path);
            } else {
                $this->session->set_flashdata('error', 'File tidak ditemukan');
                redirect('mahasiswa/modul/' . $modul->id_pertemuan);
            }
        } else {
            // For other file types, force download
            redirect('mahasiswa/download/' . $modul_id);
        }
    }
}

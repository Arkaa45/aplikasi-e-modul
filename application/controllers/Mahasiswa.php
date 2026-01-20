<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends Mahasiswa_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Matkum_model', 'Modul_model', 'Semester_model', 'Rps_model', 'Referensi_model'));
    }

    /**
     * Dashboard - List Mata Praktikum Saya
     */
    public function index()
    {
        $user_id = $this->session->userdata('user_id');

        // Get matkum assigned to this mahasiswa
        $my_matkums = $this->Matkum_model->get_by_mahasiswa($user_id);

        $data = array(
            'title' => 'Dashboard Mahasiswa',
            'page_title' => 'Mata Praktikum Saya',
            'matkums' => $my_matkums
        );

        $this->load_view('mahasiswa/index', $data);
    }

    /**
     * Mata Praktikum Detail - View Content
     */
    public function matkum($id)
    {
        $user_id = $this->session->userdata('user_id');

        // Verify mahasiswa has access to this matkum
        if (!$this->Matkum_model->is_mahasiswa_assigned($id, $user_id)) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke mata praktikum ini');
            redirect('mahasiswa');
        }

        $matkum = $this->Matkum_model->get_with_content_counts($id);
        if (!$matkum) {
            $this->session->set_flashdata('error', 'Mata praktikum tidak ditemukan');
            redirect('mahasiswa');
        }

        $data = array(
            'title' => $matkum->nama_matkul,
            'page_title' => $matkum->kode_matkul . ' - ' . $matkum->nama_matkul,
            'matkum' => $matkum,
            'rps_list' => $this->Rps_model->get_by_matkul($id),
            'referensi_list' => $this->Referensi_model->get_by_matkul($id),
            'modul_slots' => $this->Modul_model->get_slots_by_matkul($id, 16)
        );

        $this->load_view('mahasiswa/matkum', $data);
    }

    /**
     * Download/View Content
     */
    public function download($type, $id)
    {
        $file_path = null;
        $file_name = null;

        switch ($type) {
            case 'rps':
                $item = $this->Rps_model->get_by_id($id);
                if ($item) {
                    $file_path = FCPATH . 'uploads/rps/' . $item->file_path;
                    $file_name = $item->judul . '.pdf';
                }
                break;
            case 'referensi':
                $item = $this->Referensi_model->get_by_id($id);
                if ($item) {
                    if ($item->tipe == 'link') {
                        redirect($item->link_external);
                    }
                    $file_path = FCPATH . 'uploads/referensi/' . $item->file_path;
                    $file_name = $item->judul;
                }
                break;
            case 'modul':
                $item = $this->Modul_model->get_by_id($id);
                if ($item) {
                    if ($item->tipe_file == 'link') {
                        redirect($item->link_external);
                    }
                    $this->Modul_model->increment_download($id);
                    $file_path = FCPATH . 'uploads/modul/' . $item->file_modul;
                    $file_name = $item->judul_modul;
                }
                break;
        }

        if ($file_path && file_exists($file_path)) {
            $this->load->helper('download');
            force_download($file_path, NULL);
        } else {
            $this->session->set_flashdata('error', 'File tidak ditemukan');
            redirect('mahasiswa');
        }
    }

    /**
     * View PDF inline
     */
    public function view($type, $id)
    {
        $file_path = null;
        $file_name = null;

        switch ($type) {
            case 'rps':
                $item = $this->Rps_model->get_by_id($id);
                if ($item) {
                    $file_path = FCPATH . 'uploads/rps/' . $item->file_path;
                    $file_name = $item->judul;
                }
                break;
            case 'referensi':
                $item = $this->Referensi_model->get_by_id($id);
                if ($item && $item->tipe == 'file') {
                    $file_path = FCPATH . 'uploads/referensi/' . $item->file_path;
                    $file_name = $item->judul;
                }
                break;
            case 'modul':
                $item = $this->Modul_model->get_by_id($id);
                if ($item && $item->tipe_file == 'pdf') {
                    $this->Modul_model->increment_download($id);
                    $file_path = FCPATH . 'uploads/modul/' . $item->file_modul;
                    $file_name = $item->judul_modul;
                }
                break;
        }

        if ($file_path && file_exists($file_path)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . $file_name . '.pdf"');
            readfile($file_path);
        } else {
            $this->session->set_flashdata('error', 'File tidak ditemukan');
            redirect('mahasiswa');
        }
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_login();
        $this->load->model(array('User_model', 'Semester_model', 'Matkum_model', 'Modul_model'));
    }

    /**
     * Main dashboard - redirects based on role
     */
    public function index()
    {
        $role = $this->session->userdata('role');

        switch ($role) {
            case 'admin':
                $this->admin_dashboard();
                break;
            case 'laboran':
                $this->laboran_dashboard();
                break;
            case 'mahasiswa':
                $this->mahasiswa_dashboard();
                break;
            default:
                redirect('auth/logout');
        }
    }

    /**
     * Admin Dashboard
     */
    private function admin_dashboard()
    {
        $current_semester = $this->Semester_model->get_latest();

        $data = array(
            'title' => 'Dashboard Admin',
            'page_title' => 'Dashboard',
            'total_users' => $this->User_model->count_by_role(),
            'total_mahasiswa' => $this->User_model->count_by_role('mahasiswa'),
            'total_laboran' => $this->User_model->count_by_role('laboran'),
            'total_matkum' => $this->Matkum_model->count_all(),
            'total_modul' => $this->Modul_model->count_all(),
            'current_semester' => $current_semester,
            'semester_matkum_count' => $current_semester ? $this->Semester_model->count_matkum($current_semester->id) : 0,
            'semester_mahasiswa_count' => $current_semester ? $this->Semester_model->count_mahasiswa($current_semester->id) : 0,
            'recent_moduls' => $this->Modul_model->get_recent(5)
        );

        $this->load_view('dashboard/admin', $data);
    }

    /**
     * Laboran Dashboard
     */
    private function laboran_dashboard()
    {
        $user_id = $this->session->userdata('user_id');

        $data = array(
            'title' => 'Dashboard Laboran',
            'page_title' => 'Dashboard',
            'my_matkum' => $this->Matkum_model->get_by_laboran($user_id),
            'my_moduls' => $this->Modul_model->get_by_uploader($user_id, 10),
            'current_semester' => $this->Semester_model->get_latest()
        );

        $this->load_view('dashboard/laboran', $data);
    }

    /**
     * Mahasiswa Dashboard
     */
    private function mahasiswa_dashboard()
    {
        $user_id = $this->session->userdata('user_id');
        $my_semesters = $this->Semester_model->get_by_mahasiswa($user_id);
        $current_semester = $this->Semester_model->get_latest();

        // Get matkum from current semester if enrolled
        $my_matkum = array();
        if ($current_semester && $this->Semester_model->is_mahasiswa_enrolled($current_semester->id, $user_id)) {
            $my_matkum = $this->Semester_model->get_matkum($current_semester->id);
        }

        $data = array(
            'title' => 'Dashboard Mahasiswa',
            'page_title' => 'Dashboard',
            'my_matkum' => $my_matkum,
            'current_semester' => $current_semester,
            'my_semesters' => $my_semesters
        );

        $this->load_view('dashboard/mahasiswa', $data);
    }
}

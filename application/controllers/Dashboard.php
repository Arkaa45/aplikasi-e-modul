<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_login();
        $this->load->model(array('User_model', 'Semester_model', 'Matkul_model', 'Modul_model'));
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
        $data = array(
            'title' => 'Dashboard Admin',
            'page_title' => 'Dashboard',
            'total_users' => $this->User_model->count_by_role(),
            'total_mahasiswa' => $this->User_model->count_by_role('mahasiswa'),
            'total_laboran' => $this->User_model->count_by_role('laboran'),
            'total_matkul' => $this->Matkul_model->count_all(),
            'total_modul' => $this->Modul_model->count_all(),
            'current_semester' => $this->Semester_model->get_active(),
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
            'my_matkul' => $this->Matkul_model->get_by_laboran($user_id),
            'my_moduls' => $this->Modul_model->get_by_uploader($user_id, 10),
            'current_semester' => $this->Semester_model->get_active()
        );

        $this->load_view('dashboard/laboran', $data);
    }

    /**
     * Mahasiswa Dashboard
     */
    private function mahasiswa_dashboard()
    {
        $user_id = $this->session->userdata('user_id');
        $current_semester = $this->Semester_model->get_active();

        $data = array(
            'title' => 'Dashboard Mahasiswa',
            'page_title' => 'Dashboard',
            'my_matkul' => $current_semester ? $this->Matkul_model->get_by_mahasiswa($user_id, $current_semester->id) : array(),
            'current_semester' => $current_semester,
            'accessible_semesters' => $this->Semester_model->get_accessible()
        );

        $this->load_view('dashboard/mahasiswa', $data);
    }
}

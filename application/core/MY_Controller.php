<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Controller - Base Controller
 * Handles authentication and role-based access control
 */
class MY_Controller extends CI_Controller
{

    protected $user_data = null;
    protected $allowed_roles = array();

    public function __construct()
    {
        parent::__construct();

        // Load user data if logged in
        if ($this->session->userdata('user_id')) {
            $this->user_data = array(
                'id' => $this->session->userdata('user_id'),
                'nama' => $this->session->userdata('nama'),
                'email' => $this->session->userdata('email'),
                'role' => $this->session->userdata('role'),
                'foto' => $this->session->userdata('foto')
            );
        }
    }

    /**
     * Check if user is logged in
     */
    protected function require_login()
    {
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu');
            redirect('auth');
        }
    }

    /**
     * Check if user has required role
     */
    protected function require_role($roles = array())
    {
        $this->require_login();

        if (!is_array($roles)) {
            $roles = array($roles);
        }

        $user_role = $this->session->userdata('role');

        if (!in_array($user_role, $roles)) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman tersebut');
            redirect('dashboard');
        }
    }

    /**
     * Load view with template
     */
    protected function load_view($view, $data = array())
    {
        $data['user'] = $this->user_data;
        $data['current_page'] = $this->router->fetch_class();
        $data['current_method'] = $this->router->fetch_method();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view($view, $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Log user activity
     */
    protected function log_activity($action, $description = '')
    {
        if ($this->session->userdata('user_id')) {
            $this->db->insert('activity_log', array(
                'id_user' => $this->session->userdata('user_id'),
                'action' => $action,
                'description' => $description,
                'ip_address' => $this->input->ip_address(),
                'user_agent' => $this->input->user_agent()
            ));
        }
    }

    /**
     * Get current semester
     */
    protected function get_current_semester()
    {
        return $this->db->get_where('semester', array('is_active' => 1))->row();
    }

    /**
     * Check if semester is accessible for mahasiswa
     */
    protected function is_semester_accessible($semester_id)
    {
        $semester = $this->db->get_where('semester', array('id' => $semester_id))->row();

        if (!$semester) {
            return false;
        }

        // Current date
        $today = date('Y-m-d');

        // Mahasiswa can access current and past semesters only
        if ($semester->tanggal_mulai <= $today) {
            return true;
        }

        return false;
    }
}

/**
 * Admin_Controller - For Admin/Kepala Lab only
 */
class Admin_Controller extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_role(array('admin'));
    }
}

/**
 * Laboran_Controller - For Laboran/Asisten Dosen only
 */
class Laboran_Controller extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_role(array('laboran', 'admin'));
    }
}

/**
 * Mahasiswa_Controller - For Mahasiswa only
 */
class Mahasiswa_Controller extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_role(array('mahasiswa'));
    }
}

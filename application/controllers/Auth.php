<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    /**
     * Login page
     */
    public function index()
    {
        // Redirect if already logged in
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }

        $data = array(
            'title' => 'Login - E-Modul Praktikum'
        );

        $this->load->view('auth/login', $data);
    }

    /**
     * Process login
     */
    public function login()
    {
        // Validate input
        $email = $this->input->post('email', TRUE);
        $password = $this->input->post('password');

        if (empty($email) || empty($password)) {
            $this->session->set_flashdata('error', 'Email dan password wajib diisi');
            redirect('auth');
        }

        // Verify credentials
        $user = $this->User_model->verify_login($email, $password);

        if ($user) {
            // Set session data
            $session_data = array(
                'user_id' => $user->id,
                'nama' => $user->nama,
                'email' => $user->email,
                'role' => $user->role,
                'foto' => $user->foto,
                'logged_in' => TRUE
            );
            $this->session->set_userdata($session_data);

            // Log activity
            $this->db->insert('activity_log', array(
                'id_user' => $user->id,
                'action' => 'login',
                'description' => 'User logged in',
                'ip_address' => $this->input->ip_address(),
                'user_agent' => $this->input->user_agent()
            ));

            $this->session->set_flashdata('success', 'Selamat datang, ' . $user->nama . '!');
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Email atau password salah, atau akun tidak aktif');
            redirect('auth');
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        // Log activity before destroying session
        if ($this->session->userdata('user_id')) {
            $this->db->insert('activity_log', array(
                'id_user' => $this->session->userdata('user_id'),
                'action' => 'logout',
                'description' => 'User logged out',
                'ip_address' => $this->input->ip_address(),
                'user_agent' => $this->input->user_agent()
            ));
        }

        $this->session->sess_destroy();
        redirect('auth');
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('User_model', 'Semester_model', 'Matkum_model', 'Modul_model'));
    }

    /**
     * Users Management
     */
    public function users($action = 'index', $id = null)
    {
        switch ($action) {
            case 'create':
                $this->user_form();
                break;
            case 'edit':
                $this->user_form($id);
                break;
            case 'delete':
                $this->user_delete($id);
                break;
            case 'toggle':
                $this->user_toggle($id);
                break;
            default:
                $this->user_list();
        }
    }

    private function user_list()
    {
        $role_filter = $this->input->get('role');

        $data = array(
            'title' => 'Kelola User',
            'page_title' => 'Kelola User',
            'users' => $this->User_model->get_all($role_filter),
            'role_filter' => $role_filter
        );

        $this->load_view('admin/users/index', $data);
    }

    private function user_form($id = null)
    {
        if ($this->input->post()) {
            $user_data = array(
                'nama' => $this->input->post('nama', TRUE),
                'email' => $this->input->post('email', TRUE),
                'role' => $this->input->post('role', TRUE),
                'nim_nip' => $this->input->post('nim_nip', TRUE),
                'prodi' => $this->input->post('prodi', TRUE),
                'angkatan' => $this->input->post('angkatan', TRUE),
                'is_active' => $this->input->post('is_active') ? 1 : 0
            );

            if ($this->input->post('password')) {
                $user_data['password'] = $this->input->post('password');
            }

            if ($id) {
                $this->User_model->update($id, $user_data);
                $this->log_activity('update_user', 'Updated user: ' . $user_data['nama']);
                $this->session->set_flashdata('success', 'User berhasil diperbarui');
            } else {
                $user_data['password'] = $this->input->post('password');
                $this->User_model->create($user_data);
                $this->log_activity('create_user', 'Created user: ' . $user_data['nama']);
                $this->session->set_flashdata('success', 'User berhasil ditambahkan');
            }

            redirect('admin/users');
        }

        $data = array(
            'title' => $id ? 'Edit User' : 'Tambah User',
            'page_title' => $id ? 'Edit User' : 'Tambah User',
            'user_data' => $id ? $this->User_model->get_by_id($id) : null,
            'edit_mode' => $id ? true : false
        );

        $this->load_view('admin/users/form', $data);
    }

    private function user_delete($id)
    {
        $user = $this->User_model->get_by_id($id);
        if ($user) {
            $this->User_model->delete($id);
            $this->log_activity('delete_user', 'Deleted user: ' . $user->nama);
            $this->session->set_flashdata('success', 'User berhasil dihapus');
        }
        redirect('admin/users');
    }

    private function user_toggle($id)
    {
        $user = $this->User_model->get_by_id($id);
        if ($user) {
            $this->User_model->update($id, array('is_active' => !$user->is_active));
            $this->session->set_flashdata('success', 'Status user berhasil diubah');
        }
        redirect('admin/users');
    }

    /**
     * Semester Management
     */
    public function semester($action = 'index', $id = null)
    {
        switch ($action) {
            case 'create':
                $this->semester_form();
                break;
            case 'edit':
                $this->semester_form($id);
                break;
            case 'delete':
                $this->semester_delete($id);
                break;
            case 'activate':
                $this->semester_activate($id);
                break;
            case 'courses':
                $this->semester_courses($id);
                break;
            default:
                $this->semester_list();
        }
    }

    private function semester_list()
    {
        $data = array(
            'title' => 'Kelola Semester',
            'page_title' => 'Kelola Semester',
            'semesters' => $this->Semester_model->get_all()
        );

        $this->load_view('admin/semester/index', $data);
    }

    private function semester_form($id = null)
    {
        if ($this->input->post()) {
            $semester_data = array(
                'nama_semester' => $this->input->post('nama_semester', TRUE),
                'tahun_ajaran' => $this->input->post('tahun_ajaran', TRUE),
                'tanggal_mulai' => $this->input->post('tanggal_mulai'),
                'tanggal_selesai' => $this->input->post('tanggal_selesai')
            );

            if ($id) {
                $this->Semester_model->update($id, $semester_data);
                $this->log_activity('update_semester', 'Updated semester');
                $this->session->set_flashdata('success', 'Semester berhasil diperbarui');
                redirect('admin/semester');
            } else {
                $new_id = $this->Semester_model->create($semester_data);
                $this->log_activity('create_semester', 'Created new semester');
                $this->session->set_flashdata('success', 'Semester berhasil ditambahkan. Silakan tambahkan mata kuliah praktikum.');
                redirect('admin/semester/courses/' . $new_id);
            }
        }

        $data = array(
            'title' => $id ? 'Edit Semester' : 'Tambah Semester',
            'page_title' => $id ? 'Edit Semester' : 'Tambah Semester',
            'semester_data' => $id ? $this->Semester_model->get_by_id($id) : null,
            'edit_mode' => $id ? true : false
        );

        $this->load_view('admin/semester/form', $data);
    }

    private function semester_delete($id)
    {
        $this->Semester_model->delete($id);
        $this->log_activity('delete_semester', 'Deleted semester');
        $this->session->set_flashdata('success', 'Semester berhasil dihapus');
        redirect('admin/semester');
    }

    private function semester_activate($id)
    {
        $this->Semester_model->set_active($id);
        $this->log_activity('activate_semester', 'Activated semester ID: ' . $id);
        $this->session->set_flashdata('success', 'Semester berhasil diaktifkan');
        redirect('admin/semester');
    }

    private function semester_courses($id)
    {
        $semester = $this->Semester_model->get_by_id($id);
        if (!$semester) {
            $this->session->set_flashdata('error', 'Semester tidak ditemukan');
            redirect('admin/semester');
        }

        // Handle form submission to add mata praktikum
        if ($this->input->post()) {
            $matkum_data = array(
                'kode_matkul' => $this->input->post('kode_matkul', TRUE),
                'nama_matkul' => $this->input->post('nama_matkul', TRUE),
                'sks' => $this->input->post('sks', TRUE),
                'deskripsi' => $this->input->post('deskripsi', TRUE),
                'is_active' => 1
            );

            $this->Matkum_model->create($matkum_data);
            $this->log_activity('create_matkum', 'Created mata praktikum: ' . $matkum_data['nama_matkul']);
            $this->session->set_flashdata('success', 'Mata praktikum berhasil ditambahkan. Tambahkan lagi atau selesai.');
            redirect('admin/semester/courses/' . $id);
        }

        $data = array(
            'title' => 'Tambah Mata Praktikum untuk Semester',
            'page_title' => 'Mata Praktikum - ' . $semester->nama_semester . ' ' . $semester->tahun_ajaran,
            'semester' => $semester,
            'matkums' => $this->Matkum_model->get_all()
        );

        $this->load_view('admin/semester/courses', $data);
    }

    /**
     * Mata Praktikum Management
     */
    public function matkum($action = 'index', $id = null)
    {
        switch ($action) {
            case 'create':
                $this->matkum_form();
                break;
            case 'edit':
                $this->matkum_form($id);
                break;
            case 'delete':
                $this->matkum_delete($id);
                break;
            default:
                $this->matkum_list();
        }
    }

    private function matkum_list()
    {
        $semester_id = $this->input->get('semester');
        $selected_semester = null;
        $matkums = array();

        if ($semester_id) {
            $selected_semester = $this->Semester_model->get_by_id($semester_id);
            $matkums = $this->Matkum_model->get_all();
        }

        // Handle form submission for adding new matkum
        if ($this->input->post()) {
            $matkum_data = array(
                'kode_matkul' => $this->input->post('kode_matkul', TRUE),
                'nama_matkul' => $this->input->post('nama_matkul', TRUE),
                'sks' => $this->input->post('sks', TRUE),
                'deskripsi' => $this->input->post('deskripsi', TRUE),
                'is_active' => 1
            );

            $this->Matkum_model->create($matkum_data);
            $this->log_activity('create_matkum', 'Created mata praktikum: ' . $matkum_data['nama_matkul']);
            $this->session->set_flashdata('success', 'Mata praktikum berhasil ditambahkan');
            redirect('admin/matkum?semester=' . $this->input->post('semester_id'));
        }

        $data = array(
            'title' => 'Kelola Mata Praktikum',
            'page_title' => 'Kelola Mata Praktikum',
            'semesters' => $this->Semester_model->get_all(),
            'semester_id' => $semester_id,
            'selected_semester' => $selected_semester,
            'matkums' => $matkums
        );

        $this->load_view('admin/matkum/index', $data);
    }

    private function matkum_form($id = null)
    {
        if ($this->input->post()) {
            $matkum_data = array(
                'kode_matkul' => $this->input->post('kode_matkul', TRUE),
                'nama_matkul' => $this->input->post('nama_matkul', TRUE),
                'sks' => $this->input->post('sks', TRUE),
                'deskripsi' => $this->input->post('deskripsi', TRUE),
                'is_active' => $this->input->post('is_active') ? 1 : 0
            );

            if ($id) {
                $this->Matkum_model->update($id, $matkum_data);
                $this->log_activity('update_matkum', 'Updated mata praktikum: ' . $matkum_data['nama_matkul']);
                $this->session->set_flashdata('success', 'Mata praktikum berhasil diperbarui');
            } else {
                $this->Matkum_model->create($matkum_data);
                $this->log_activity('create_matkum', 'Created mata praktikum: ' . $matkum_data['nama_matkul']);
                $this->session->set_flashdata('success', 'Mata praktikum berhasil ditambahkan');
            }

            redirect('admin/matkum');
        }

        $data = array(
            'title' => $id ? 'Edit Mata Praktikum' : 'Tambah Mata Praktikum',
            'page_title' => $id ? 'Edit Mata Praktikum' : 'Tambah Mata Praktikum',
            'matkum_data' => $id ? $this->Matkum_model->get_by_id($id) : null,
            'edit_mode' => $id ? true : false
        );

        $this->load_view('admin/matkum/form', $data);
    }

    private function matkum_delete($id)
    {
        $matkum = $this->Matkum_model->get_by_id($id);
        if ($matkum) {
            $this->Matkum_model->delete($id);
            $this->log_activity('delete_matkum', 'Deleted mata praktikum: ' . $matkum->nama_matkul);
            $this->session->set_flashdata('success', 'Mata praktikum berhasil dihapus');
        }
        redirect('admin/matkum');
    }

    /**
     * Assign Laboran to Mata Praktikum
     */
    public function assign_laboran($matkum_id = null)
    {
        if (!$matkum_id) {
            $this->session->set_flashdata('error', 'Mata praktikum tidak ditemukan');
            redirect('admin/matkum');
        }

        $matkum = $this->Matkum_model->get_by_id($matkum_id);
        if (!$matkum) {
            $this->session->set_flashdata('error', 'Mata praktikum tidak ditemukan');
            redirect('admin/matkum');
        }

        // Handle form submission
        if ($this->input->post()) {
            $laboran_id = $this->input->post('laboran_id');
            $action = $this->input->post('action');

            if ($action == 'assign') {
                // Check if already assigned
                if (!$this->Matkum_model->is_laboran_assigned($matkum_id, $laboran_id)) {
                    $this->Matkum_model->assign_laboran($matkum_id, $laboran_id);
                    $this->log_activity('assign_laboran', 'Assigned laboran to: ' . $matkum->nama_matkul);
                    $this->session->set_flashdata('success', 'Laboran berhasil ditugaskan');
                }
            } else if ($action == 'remove') {
                $this->Matkum_model->remove_laboran($matkum_id, $laboran_id);
                $this->log_activity('remove_laboran', 'Removed laboran from: ' . $matkum->nama_matkul);
                $this->session->set_flashdata('success', 'Laboran berhasil dihapus dari mata praktikum');
            }

            redirect('admin/assign_laboran/' . $matkum_id);
        }

        // Get all laborans and assigned laborans
        $all_laborans = $this->User_model->get_all('laboran', 1); // Active laborans only
        $assigned_laborans = $this->Matkum_model->get_laborans_by_matkul($matkum_id);
        $assigned_ids = array_map(function ($l) {
            return $l->id;
        }, $assigned_laborans);

        $data = array(
            'title' => 'Assign Laboran',
            'page_title' => 'Assign Laboran - ' . $matkum->nama_matkul,
            'matkum' => $matkum,
            'all_laborans' => $all_laborans,
            'assigned_laborans' => $assigned_laborans,
            'assigned_ids' => $assigned_ids
        );

        $this->load_view('admin/matkum/assign_laboran', $data);
    }

    /**
     * Activity Log
     */
    public function activity()
    {
        $this->db->select('activity_log.*, users.nama as user_nama, users.role as user_role');
        $this->db->from('activity_log');
        $this->db->join('users', 'users.id = activity_log.id_user');
        $this->db->order_by('activity_log.created_at', 'DESC');
        $this->db->limit(100);
        $logs = $this->db->get()->result();

        $data = array(
            'title' => 'Log Aktivitas',
            'page_title' => 'Log Aktivitas',
            'logs' => $logs
        );

        $this->load_view('admin/activity', $data);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('User_model', 'Semester_model', 'Matkul_model', 'Modul_model'));
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
            } else {
                $this->Semester_model->create($semester_data);
                $this->log_activity('create_semester', 'Created new semester');
                $this->session->set_flashdata('success', 'Semester berhasil ditambahkan');
            }

            redirect('admin/semester');
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

    /**
     * Mata Kuliah Management
     */
    public function matkul($action = 'index', $id = null)
    {
        switch ($action) {
            case 'create':
                $this->matkul_form();
                break;
            case 'edit':
                $this->matkul_form($id);
                break;
            case 'delete':
                $this->matkul_delete($id);
                break;
            default:
                $this->matkul_list();
        }
    }

    private function matkul_list()
    {
        $data = array(
            'title' => 'Kelola Mata Kuliah',
            'page_title' => 'Kelola Mata Kuliah',
            'matkuls' => $this->Matkul_model->get_all()
        );

        $this->load_view('admin/matkul/index', $data);
    }

    private function matkul_form($id = null)
    {
        if ($this->input->post()) {
            $matkul_data = array(
                'kode_matkul' => $this->input->post('kode_matkul', TRUE),
                'nama_matkul' => $this->input->post('nama_matkul', TRUE),
                'sks' => $this->input->post('sks', TRUE),
                'deskripsi' => $this->input->post('deskripsi', TRUE),
                'is_active' => $this->input->post('is_active') ? 1 : 0
            );

            if ($id) {
                $this->Matkul_model->update($id, $matkul_data);
                $this->log_activity('update_matkul', 'Updated mata kuliah: ' . $matkul_data['nama_matkul']);
                $this->session->set_flashdata('success', 'Mata kuliah berhasil diperbarui');
            } else {
                $this->Matkul_model->create($matkul_data);
                $this->log_activity('create_matkul', 'Created mata kuliah: ' . $matkul_data['nama_matkul']);
                $this->session->set_flashdata('success', 'Mata kuliah berhasil ditambahkan');
            }

            redirect('admin/matkul');
        }

        $data = array(
            'title' => $id ? 'Edit Mata Kuliah' : 'Tambah Mata Kuliah',
            'page_title' => $id ? 'Edit Mata Kuliah' : 'Tambah Mata Kuliah',
            'matkul_data' => $id ? $this->Matkul_model->get_by_id($id) : null,
            'edit_mode' => $id ? true : false
        );

        $this->load_view('admin/matkul/form', $data);
    }

    private function matkul_delete($id)
    {
        $matkul = $this->Matkul_model->get_by_id($id);
        if ($matkul) {
            $this->Matkul_model->delete($id);
            $this->log_activity('delete_matkul', 'Deleted mata kuliah: ' . $matkul->nama_matkul);
            $this->session->set_flashdata('success', 'Mata kuliah berhasil dihapus');
        }
        redirect('admin/matkul');
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

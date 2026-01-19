<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('User_model', 'Semester_model', 'Matkum_model', 'Modul_model', 'Rps_model', 'Referensi_model'));
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
            case 'detail':
                $this->semester_detail($id);
                break;
            case 'assign_matkum':
                $this->semester_assign_matkum($id);
                break;
            case 'mahasiswa':
                $this->semester_mahasiswa($id);
                break;
            case 'import_mahasiswa':
                $this->semester_import_mahasiswa($id);
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
            'semesters' => $this->Semester_model->get_all_with_counts()
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
                $id = $this->Semester_model->create($semester_data);
                $this->log_activity('create_semester', 'Created new semester');
                $this->session->set_flashdata('success', 'Semester berhasil ditambahkan');
            }
            redirect('admin/semester/detail/' . $id);
        }

        $data = array(
            'title' => $id ? 'Edit Semester' : 'Tambah Semester',
            'page_title' => $id ? 'Edit Semester' : 'Tambah Semester',
            'semester_data' => $id ? $this->Semester_model->get_by_id($id) : null,
            'edit_mode' => $id ? true : false
        );

        $this->load_view('admin/semester/form', $data);
    }

    private function semester_detail($id)
    {
        $semester = $this->Semester_model->get_with_counts($id);
        if (!$semester) {
            $this->session->set_flashdata('error', 'Semester tidak ditemukan');
            redirect('admin/semester');
        }

        $data = array(
            'title' => 'Detail Semester',
            'page_title' => $semester->nama_semester . ' ' . $semester->tahun_ajaran,
            'semester' => $semester,
            'matkums' => $this->Semester_model->get_matkum($id),
            'mahasiswas' => $this->Semester_model->get_mahasiswa($id)
        );

        $this->load_view('admin/semester/detail', $data);
    }

    private function semester_assign_matkum($id)
    {
        $semester = $this->Semester_model->get_by_id($id);
        if (!$semester) {
            $this->session->set_flashdata('error', 'Semester tidak ditemukan');
            redirect('admin/semester');
        }

        if ($this->input->post()) {
            $action = $this->input->post('action');
            $matkul_id = $this->input->post('matkul_id');

            if ($action == 'assign') {
                $this->Matkum_model->assign_to_semester($matkul_id, $id);
                $this->session->set_flashdata('success', 'Mata praktikum berhasil ditambahkan');
            } else if ($action == 'remove') {
                $this->Matkum_model->remove_from_semester($matkul_id, $id);
                $this->session->set_flashdata('success', 'Mata praktikum berhasil dihapus');
            }
            redirect('admin/semester/assign_matkum/' . $id);
        }

        // Get all matkum and mark which are assigned
        $all_matkum = $this->Matkum_model->get_all(1);
        $assigned_matkum = $this->Semester_model->get_matkum($id);
        $assigned_ids = array_map(function ($m) {
            return $m->id; }, $assigned_matkum);

        $data = array(
            'title' => 'Assign Mata Praktikum',
            'page_title' => 'Assign Mata Praktikum - ' . $semester->nama_semester . ' ' . $semester->tahun_ajaran,
            'semester' => $semester,
            'all_matkum' => $all_matkum,
            'assigned_ids' => $assigned_ids
        );

        $this->load_view('admin/semester/assign_matkum', $data);
    }

    private function semester_mahasiswa($id)
    {
        $semester = $this->Semester_model->get_by_id($id);
        if (!$semester) {
            $this->session->set_flashdata('error', 'Semester tidak ditemukan');
            redirect('admin/semester');
        }

        if ($this->input->post()) {
            $action = $this->input->post('action');
            $user_id = $this->input->post('user_id');

            if ($action == 'remove') {
                $this->Semester_model->remove_mahasiswa($id, $user_id);
                $this->session->set_flashdata('success', 'Mahasiswa berhasil dihapus dari semester');
            }
            redirect('admin/semester/mahasiswa/' . $id);
        }

        $data = array(
            'title' => 'Mahasiswa Semester',
            'page_title' => 'Mahasiswa - ' . $semester->nama_semester . ' ' . $semester->tahun_ajaran,
            'semester' => $semester,
            'mahasiswas' => $this->Semester_model->get_mahasiswa($id)
        );

        $this->load_view('admin/semester/mahasiswa', $data);
    }

    private function semester_import_mahasiswa($id)
    {
        $semester = $this->Semester_model->get_by_id($id);
        if (!$semester) {
            $this->session->set_flashdata('error', 'Semester tidak ditemukan');
            redirect('admin/semester');
        }

        if ($this->input->post() && !empty($_FILES['csv_file']['name'])) {
            $file = $_FILES['csv_file']['tmp_name'];

            if (($handle = fopen($file, "r")) !== FALSE) {
                $header = fgetcsv($handle); // Skip header row
                $imported = 0;
                $skipped = 0;
                $default_password = 'password123';

                while (($row = fgetcsv($handle)) !== FALSE) {
                    if (count($row) >= 5) {
                        $nama = trim($row[0]);
                        $email = trim($row[1]);
                        $nim = trim($row[2]);
                        $prodi = trim($row[3]);
                        $angkatan = trim($row[4]);

                        // Check if user exists
                        $existing = $this->User_model->get_by_email($email);

                        if ($existing) {
                            // Just assign to semester
                            if ($existing->role == 'mahasiswa') {
                                $this->Semester_model->assign_mahasiswa($id, $existing->id);
                                $imported++;
                            } else {
                                $skipped++;
                            }
                        } else {
                            // Create new user
                            $user_data = array(
                                'nama' => $nama,
                                'email' => $email,
                                'password' => $default_password,
                                'role' => 'mahasiswa',
                                'nim_nip' => $nim,
                                'prodi' => $prodi,
                                'angkatan' => $angkatan,
                                'is_active' => 1
                            );
                            $user_id = $this->User_model->create($user_data);
                            $this->Semester_model->assign_mahasiswa($id, $user_id);
                            $imported++;
                        }
                    }
                }
                fclose($handle);

                $this->log_activity('import_mahasiswa', "Imported $imported mahasiswa to semester");
                $this->session->set_flashdata('success', "Berhasil import $imported mahasiswa. $skipped dilewati.");
            } else {
                $this->session->set_flashdata('error', 'Gagal membaca file CSV');
            }
            redirect('admin/semester/mahasiswa/' . $id);
        }

        $data = array(
            'title' => 'Import Mahasiswa',
            'page_title' => 'Import Mahasiswa - ' . $semester->nama_semester . ' ' . $semester->tahun_ajaran,
            'semester' => $semester
        );

        $this->load_view('admin/semester/import_mahasiswa', $data);
    }

    private function semester_delete($id)
    {
        $this->Semester_model->delete($id);
        $this->log_activity('delete_semester', 'Deleted semester');
        $this->session->set_flashdata('success', 'Semester berhasil dihapus');
        redirect('admin/semester');
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
            case 'detail':
                $this->matkum_detail($id);
                break;
            default:
                $this->matkum_list();
        }
    }

    private function matkum_list()
    {
        $data = array(
            'title' => 'Kelola Mata Praktikum',
            'page_title' => 'Kelola Mata Praktikum',
            'matkums' => $this->Matkum_model->get_all()
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
                $id = $this->Matkum_model->create($matkum_data);
                $this->log_activity('create_matkum', 'Created mata praktikum: ' . $matkum_data['nama_matkul']);
                $this->session->set_flashdata('success', 'Mata praktikum berhasil ditambahkan');
            }

            redirect('admin/matkum/detail/' . $id);
        }

        $data = array(
            'title' => $id ? 'Edit Mata Praktikum' : 'Tambah Mata Praktikum',
            'page_title' => $id ? 'Edit Mata Praktikum' : 'Tambah Mata Praktikum',
            'matkum_data' => $id ? $this->Matkum_model->get_by_id($id) : null,
            'edit_mode' => $id ? true : false
        );

        $this->load_view('admin/matkum/form', $data);
    }

    private function matkum_detail($id)
    {
        $matkum = $this->Matkum_model->get_with_content_counts($id);
        if (!$matkum) {
            $this->session->set_flashdata('error', 'Mata praktikum tidak ditemukan');
            redirect('admin/matkum');
        }

        $data = array(
            'title' => $matkum->nama_matkul,
            'page_title' => $matkum->kode_matkul . ' - ' . $matkum->nama_matkul,
            'matkum' => $matkum,
            'rps_list' => $this->Rps_model->get_by_matkul($id),
            'referensi_list' => $this->Referensi_model->get_by_matkul($id),
            'modul_slots' => $this->Modul_model->get_slots_by_matkul($id, 16),
            'laborans' => $this->Matkum_model->get_laborans_by_matkul($id)
        );

        $this->load_view('admin/matkum/detail', $data);
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

        if ($this->input->post()) {
            $laboran_id = $this->input->post('laboran_id');
            $action = $this->input->post('action');

            if ($action == 'assign') {
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

        $all_laborans = $this->User_model->get_all('laboran', 1);
        $assigned_laborans = $this->Matkum_model->get_laborans_by_matkul($matkum_id);
        $assigned_ids = array_map(function ($l) {
            return $l->id; }, $assigned_laborans);

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
     * Content Upload (RPS, Referensi, Modul)
     */
    public function upload_content($type, $matkum_id)
    {
        $matkum = $this->Matkum_model->get_by_id($matkum_id);
        if (!$matkum) {
            $this->session->set_flashdata('error', 'Mata praktikum tidak ditemukan');
            redirect('admin/matkum');
        }

        if ($this->input->post()) {
            $user_id = $this->session->userdata('user_id');

            switch ($type) {
                case 'rps':
                    $this->upload_rps($matkum_id, $user_id);
                    break;
                case 'referensi':
                    $this->upload_referensi($matkum_id, $user_id);
                    break;
                case 'modul':
                    $this->upload_modul($matkum_id, $user_id);
                    break;
            }
            redirect('admin/matkum/detail/' . $matkum_id);
        }

        $data = array(
            'title' => 'Upload ' . ucfirst($type),
            'page_title' => 'Upload ' . ucfirst($type) . ' - ' . $matkum->nama_matkul,
            'matkum' => $matkum,
            'type' => $type
        );

        if ($type == 'modul') {
            $data['available_slots'] = array();
            for ($i = 1; $i <= 16; $i++) {
                if ($this->Modul_model->is_slot_available($matkum_id, $i)) {
                    $data['available_slots'][] = $i;
                }
            }
        }

        $this->load_view('admin/matkum/upload_content', $data);
    }

    private function upload_rps($matkum_id, $user_id)
    {
        if (!empty($_FILES['file']['name'])) {
            $upload = $this->do_upload('file', 'rps');
            if ($upload['success']) {
                $data = array(
                    'id_matkul' => $matkum_id,
                    'judul' => $this->input->post('judul', TRUE),
                    'file_path' => $upload['file_name'],
                    'uploaded_by' => $user_id
                );
                $this->Rps_model->create($data);
                $this->log_activity('upload_rps', 'Uploaded RPS');
                $this->session->set_flashdata('success', 'RPS berhasil diupload');
            } else {
                $this->session->set_flashdata('error', $upload['error']);
            }
        }
    }

    private function upload_referensi($matkum_id, $user_id)
    {
        $tipe = $this->input->post('tipe');
        $data = array(
            'id_matkul' => $matkum_id,
            'judul' => $this->input->post('judul', TRUE),
            'deskripsi' => $this->input->post('deskripsi', TRUE),
            'tipe' => $tipe,
            'uploaded_by' => $user_id
        );

        if ($tipe == 'file' && !empty($_FILES['file']['name'])) {
            $upload = $this->do_upload('file', 'referensi');
            if ($upload['success']) {
                $data['file_path'] = $upload['file_name'];
            } else {
                $this->session->set_flashdata('error', $upload['error']);
                return;
            }
        } else if ($tipe == 'link') {
            $data['link_external'] = $this->input->post('link_external', TRUE);
        }

        $this->Referensi_model->create($data);
        $this->log_activity('upload_referensi', 'Uploaded Referensi');
        $this->session->set_flashdata('success', 'Referensi berhasil ditambahkan');
    }

    private function upload_modul($matkum_id, $user_id)
    {
        $slot = $this->input->post('slot_number');
        $tipe_file = $this->input->post('tipe_file');

        $data = array(
            'id_matkul' => $matkum_id,
            'slot_number' => $slot,
            'judul_modul' => $this->input->post('judul_modul', TRUE),
            'deskripsi' => $this->input->post('deskripsi', TRUE),
            'tipe_file' => $tipe_file,
            'uploaded_by' => $user_id,
            'is_visible' => $this->input->post('is_visible') ? 1 : 0
        );

        if ($tipe_file == 'link') {
            $data['link_external'] = $this->input->post('link_external', TRUE);
        } else if (!empty($_FILES['file_modul']['name'])) {
            $upload = $this->do_upload('file_modul', 'modul');
            if ($upload['success']) {
                $data['file_modul'] = $upload['file_name'];
            } else {
                $this->session->set_flashdata('error', $upload['error']);
                return;
            }
        }

        $this->Modul_model->create($data);
        $this->log_activity('upload_modul', 'Uploaded Modul slot ' . $slot);
        $this->session->set_flashdata('success', 'Modul berhasil diupload');
    }

    /**
     * Delete Content
     */
    public function delete_content($type, $id)
    {
        $matkum_id = null;

        switch ($type) {
            case 'rps':
                $item = $this->Rps_model->get_by_id($id);
                if ($item) {
                    $matkum_id = $item->id_matkul;
                    $this->Rps_model->delete($id);
                    $this->log_activity('delete_rps', 'Deleted RPS');
                }
                break;
            case 'referensi':
                $item = $this->Referensi_model->get_by_id($id);
                if ($item) {
                    $matkum_id = $item->id_matkul;
                    $this->Referensi_model->delete($id);
                    $this->log_activity('delete_referensi', 'Deleted Referensi');
                }
                break;
            case 'modul':
                $item = $this->Modul_model->get_by_id($id);
                if ($item) {
                    $matkum_id = $item->id_matkul;
                    $this->Modul_model->delete($id);
                    $this->log_activity('delete_modul', 'Deleted Modul');
                }
                break;
        }

        $this->session->set_flashdata('success', ucfirst($type) . ' berhasil dihapus');

        if ($matkum_id) {
            redirect('admin/matkum/detail/' . $matkum_id);
        } else {
            redirect('admin/matkum');
        }
    }

    /**
     * File upload helper
     */
    private function do_upload($field_name, $folder)
    {
        $config = array(
            'upload_path' => FCPATH . 'uploads/' . $folder . '/',
            'allowed_types' => 'pdf|doc|docx|ppt|pptx|xls|xlsx|mp4|webm|zip|rar',
            'max_size' => 51200,
            'encrypt_name' => TRUE
        );

        // Create folder if not exists
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, TRUE);
        }

        $this->load->library('upload', $config);

        if ($this->upload->do_upload($field_name)) {
            $upload_data = $this->upload->data();
            return array('success' => true, 'file_name' => $upload_data['file_name']);
        } else {
            return array('success' => false, 'error' => $this->upload->display_errors('', ''));
        }
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

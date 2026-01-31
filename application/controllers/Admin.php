<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('User_model', 'Matkum_model', 'Modul_model', 'Rps_model', 'Referensi_model'));
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
            case 'import':
                $this->user_import();
                break;
            case 'download_template':
                $this->download_csv_template();
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
     * Import users from CSV
     */
    private function user_import()
    {
        if ($this->input->post()) {
            $import_type = $this->input->post('import_type');
            $content = '';

            // Get content based on import type
            if ($import_type === 'paste') {
                // Paste data method
                $content = $this->input->post('csv_data');
                if (empty(trim($content))) {
                    $this->session->set_flashdata('error', 'Silakan masukkan data CSV');
                    redirect('admin/users/import');
                }
            } else {
                // File upload method
                if (empty($_FILES['csv_file']['name'])) {
                    $this->session->set_flashdata('error', 'Silakan pilih file CSV');
                    redirect('admin/users/import');
                }

                $file = $_FILES['csv_file'];

                // Validate file extension
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                if ($ext !== 'csv') {
                    $this->session->set_flashdata('error', 'File harus berformat CSV');
                    redirect('admin/users/import');
                }

                // Read file content
                $content = file_get_contents($file['tmp_name']);
            }

            // Remove UTF-8 BOM if present
            $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);

            // Normalize line endings
            $content = str_replace("\r\n", "\n", $content);
            $content = str_replace("\r", "\n", $content);

            // Detect delimiter (comma or semicolon)
            $first_line = strtok($content, "\n");
            $delimiter = (substr_count($first_line, ';') > substr_count($first_line, ',')) ? ';' : ',';

            // Parse CSV from string
            $lines = explode("\n", $content);
            if (count($lines) < 2) {
                $this->session->set_flashdata('error', 'File CSV kosong atau hanya berisi header');
                redirect('admin/users/import');
            }

            // Read header
            $header = str_getcsv($lines[0], $delimiter);
            if (!$header || count($header) < 3) {
                $this->session->set_flashdata('error', 'Header CSV tidak valid. Pastikan ada kolom: nama, email, nim_nip');
                redirect('admin/users/import');
            }

            // Normalize header (trim and lowercase)
            $header = array_map(function ($col) {
                return strtolower(trim($col));
            }, $header);

            // Validate required columns
            $required_columns = ['nama', 'email', 'nim_nip'];
            $missing_columns = array_diff($required_columns, $header);
            if (!empty($missing_columns)) {
                $this->session->set_flashdata('error', 'Kolom yang diperlukan tidak ditemukan: ' . implode(', ', $missing_columns));
                redirect('admin/users/import');
            }

            // Get column indexes
            $col_indexes = array_flip($header);

            // Process rows
            $success_count = 0;
            $error_count = 0;
            $errors = [];
            $row_num = 1; // Header is row 1
            $total_rows = 0;

            for ($i = 1; $i < count($lines); $i++) {
                $line = trim($lines[$i]);

                // Skip empty lines
                if (empty($line)) {
                    continue;
                }

                $total_rows++;
                $row_num = $i + 1;
                $row = str_getcsv($line, $delimiter);

                // Get values
                $nama = isset($col_indexes['nama']) && isset($row[$col_indexes['nama']])
                    ? trim($row[$col_indexes['nama']]) : '';
                $email = isset($col_indexes['email']) && isset($row[$col_indexes['email']])
                    ? trim($row[$col_indexes['email']]) : '';
                $nim_nip = isset($col_indexes['nim_nip']) && isset($row[$col_indexes['nim_nip']])
                    ? trim($row[$col_indexes['nim_nip']]) : '';
                $prodi = isset($col_indexes['prodi']) && isset($row[$col_indexes['prodi']])
                    ? trim($row[$col_indexes['prodi']]) : '';
                $angkatan = isset($col_indexes['angkatan']) && isset($row[$col_indexes['angkatan']])
                    ? trim($row[$col_indexes['angkatan']]) : '';

                // Validate required fields
                if (empty($nama)) {
                    $errors[] = "Baris $row_num: Nama tidak boleh kosong";
                    $error_count++;
                    continue;
                }
                if (empty($email)) {
                    $errors[] = "Baris $row_num: Email tidak boleh kosong";
                    $error_count++;
                    continue;
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Baris $row_num: Format email tidak valid ($email)";
                    $error_count++;
                    continue;
                }
                if (empty($nim_nip)) {
                    $errors[] = "Baris $row_num: NIM/NIP tidak boleh kosong";
                    $error_count++;
                    continue;
                }

                // Check for duplicate email
                if ($this->User_model->get_by_email($email)) {
                    $errors[] = "Baris $row_num: Email sudah terdaftar ($email)";
                    $error_count++;
                    continue;
                }

                // Check for duplicate NIM/NIP
                if ($this->User_model->get_by_nim_nip($nim_nip)) {
                    $errors[] = "Baris $row_num: NIM/NIP sudah terdaftar ($nim_nip)";
                    $error_count++;
                    continue;
                }

                // Create user data
                $user_data = array(
                    'nama' => $nama,
                    'email' => $email,
                    'password' => $nim_nip, // Password = NIM/NIP
                    'role' => 'mahasiswa',
                    'nim_nip' => $nim_nip,
                    'prodi' => $prodi,
                    'angkatan' => $angkatan ? $angkatan : null,
                    'is_active' => 1
                );

                // Insert user
                if ($this->User_model->create($user_data)) {
                    $success_count++;
                } else {
                    $errors[] = "Baris $row_num: Gagal menyimpan data ($nama)";
                    $error_count++;
                }
            }

            // Set flash messages
            if ($success_count > 0) {
                $this->session->set_flashdata('success', "$success_count user mahasiswa berhasil ditambahkan");
                $this->log_activity('import_users', "Imported $success_count mahasiswa from CSV");
            }
            if ($error_count > 0) {
                $this->session->set_flashdata('import_errors', $errors);
                $this->session->set_flashdata('error', "$error_count data gagal diimport");
            }
            if ($success_count == 0 && $error_count == 0) {
                if ($total_rows == 0) {
                    $this->session->set_flashdata('error', 'Tidak ada data yang ditemukan dalam file CSV. Pastikan format sudah benar.');
                } else {
                    $this->session->set_flashdata('error', 'Tidak ada data yang berhasil diproses. Periksa format CSV Anda.');
                }
            }

            redirect('admin/users/import');
        }

        $data = array(
            'title' => 'Import User Mahasiswa',
            'page_title' => 'Import User Mahasiswa dari CSV'
        );

        $this->load_view('admin/users/import', $data);
    }

    /**
     * Download CSV template for user import
     */
    private function download_csv_template()
    {
        $filename = 'template_import_mahasiswa.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // Add BOM for UTF-8
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Header row
        fputcsv($output, ['nama', 'email', 'nim_nip', 'prodi', 'angkatan']);

        // Example rows
        fputcsv($output, ['Ahmad Fauzi', 'ahmad@student.ac.id', '2023001001', 'Teknik Informatika', '2023']);
        fputcsv($output, ['Siti Aminah', 'siti@student.ac.id', '2023001002', 'Sistem Informasi', '2023']);

        fclose($output);
        exit;
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
        // Get all matkum
        $matkums = $this->Matkum_model->get_all();

        // Add laboran count for each matkum
        foreach ($matkums as $matkum) {
            $laborans = $this->Matkum_model->get_laborans_by_matkul($matkum->id);
            $matkum->laboran_count = count($laborans);
            $matkum->laborans = $laborans;
        }

        $data = array(
            'title' => 'Kelola Mata Praktikum',
            'page_title' => 'Kelola Mata Praktikum',
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
            'laborans' => $this->Matkum_model->get_laborans_by_matkul($id),
            'mahasiswas' => $this->Matkum_model->get_mahasiswa_by_matkul($id)
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
     * Assign Mahasiswa to Mata Praktikum
     */
    public function assign_mahasiswa($matkum_id = null)
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
            $mahasiswa_id = $this->input->post('mahasiswa_id');
            $action = $this->input->post('action');

            if ($action == 'assign') {
                if (!$this->Matkum_model->is_mahasiswa_assigned($matkum_id, $mahasiswa_id)) {
                    $this->Matkum_model->assign_mahasiswa($matkum_id, $mahasiswa_id);
                    $this->log_activity('assign_mahasiswa', 'Assigned mahasiswa to: ' . $matkum->nama_matkul);
                    $this->session->set_flashdata('success', 'Mahasiswa berhasil ditambahkan');
                }
            } else if ($action == 'remove') {
                $this->Matkum_model->remove_mahasiswa($matkum_id, $mahasiswa_id);
                $this->log_activity('remove_mahasiswa', 'Removed mahasiswa from: ' . $matkum->nama_matkul);
                $this->session->set_flashdata('success', 'Mahasiswa berhasil dihapus dari mata praktikum');
            }

            redirect('admin/assign_mahasiswa/' . $matkum_id);
        }

        $all_mahasiswa = $this->User_model->get_all('mahasiswa', 1);
        $assigned_mahasiswa = $this->Matkum_model->get_mahasiswa_by_matkul($matkum_id);
        $angkatan_list = $this->User_model->get_distinct_angkatan();
        $assigned_ids = array_map(function ($m) {
            return $m->id;
        }, $assigned_mahasiswa);

        $data = array(
            'title' => 'Assign Mahasiswa',
            'page_title' => 'Assign Mahasiswa - ' . $matkum->nama_matkul,
            'matkum' => $matkum,
            'all_mahasiswa' => $all_mahasiswa,
            'assigned_mahasiswa' => $assigned_mahasiswa,
            'assigned_ids' => $assigned_ids,
            'angkatan_list' => $angkatan_list
        );

        $this->load_view('admin/matkum/assign_mahasiswa', $data);
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
     * Edit Modul
     */
    public function edit_modul($id)
    {
        $modul = $this->Modul_model->get_detail($id);

        if (!$modul) {
            $this->session->set_flashdata('error', 'Modul tidak ditemukan');
            redirect('admin/matkum');
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
                $upload = $this->do_upload('file_modul', 'modul');
                if ($upload['success']) {
                    // Delete old file
                    if ($modul->file_modul) {
                        $old_file = FCPATH . 'uploads/modul/' . $modul->file_modul;
                        if (file_exists($old_file)) {
                            unlink($old_file);
                        }
                    }
                    $modul_data['file_modul'] = $upload['file_name'];
                } else {
                    $this->session->set_flashdata('error', $upload['error']);
                    redirect('admin/edit_modul/' . $id);
                }
            }

            $this->Modul_model->update($id, $modul_data);
            $this->log_activity('update_modul', 'Updated modul: ' . $modul_data['judul_modul']);
            $this->session->set_flashdata('success', 'Modul berhasil diperbarui');
            redirect('admin/matkum/detail/' . $modul->id_matkul);
        }

        $data = array(
            'title' => 'Edit Modul',
            'page_title' => 'Edit Modul',
            'modul' => $modul
        );

        $this->load_view('admin/matkum/edit_modul', $data);
    }

    /**
     * Edit RPS
     */
    public function edit_rps($id)
    {
        $rps = $this->Rps_model->get_by_id($id);

        if (!$rps) {
            $this->session->set_flashdata('error', 'RPS tidak ditemukan');
            redirect('admin/matkum');
        }

        if ($this->input->post()) {
            $rps_data = array(
                'judul' => $this->input->post('judul', TRUE)
            );

            // Handle file upload if new file provided
            if (!empty($_FILES['file']['name'])) {
                $upload = $this->do_upload('file', 'rps');
                if ($upload['success']) {
                    // Delete old file
                    if ($rps->file_path) {
                        $old_file = FCPATH . 'uploads/rps/' . $rps->file_path;
                        if (file_exists($old_file)) {
                            unlink($old_file);
                        }
                    }
                    $rps_data['file_path'] = $upload['file_name'];
                } else {
                    $this->session->set_flashdata('error', $upload['error']);
                    redirect('admin/edit_rps/' . $id);
                }
            }

            $this->Rps_model->update($id, $rps_data);
            $this->log_activity('update_rps', 'Updated RPS: ' . $rps_data['judul']);
            $this->session->set_flashdata('success', 'RPS berhasil diperbarui');
            redirect('admin/matkum/detail/' . $rps->id_matkul);
        }

        $matkum = $this->Matkum_model->get_by_id($rps->id_matkul);

        $data = array(
            'title' => 'Edit RPS',
            'page_title' => 'Edit RPS',
            'rps' => $rps,
            'matkum' => $matkum
        );

        $this->load_view('admin/matkum/edit_rps', $data);
    }

    /**
     * Edit Referensi
     */
    public function edit_referensi($id)
    {
        $referensi = $this->Referensi_model->get_by_id($id);

        if (!$referensi) {
            $this->session->set_flashdata('error', 'Referensi tidak ditemukan');
            redirect('admin/matkum');
        }

        if ($this->input->post()) {
            $tipe = $this->input->post('tipe');
            $referensi_data = array(
                'judul' => $this->input->post('judul', TRUE),
                'deskripsi' => $this->input->post('deskripsi', TRUE),
                'tipe' => $tipe
            );

            if ($tipe == 'file') {
                // Handle file upload if new file provided
                if (!empty($_FILES['file']['name'])) {
                    $upload = $this->do_upload('file', 'referensi');
                    if ($upload['success']) {
                        // Delete old file if exists
                        if ($referensi->file_path) {
                            $old_file = FCPATH . 'uploads/referensi/' . $referensi->file_path;
                            if (file_exists($old_file)) {
                                unlink($old_file);
                            }
                        }
                        $referensi_data['file_path'] = $upload['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $upload['error']);
                        redirect('admin/edit_referensi/' . $id);
                    }
                }
                $referensi_data['link_external'] = null;
            } else {
                // Link type
                $referensi_data['link_external'] = $this->input->post('link_external', TRUE);
                // Delete old file if switching from file to link
                if ($referensi->file_path) {
                    $old_file = FCPATH . 'uploads/referensi/' . $referensi->file_path;
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                }
                $referensi_data['file_path'] = null;
            }

            $this->Referensi_model->update($id, $referensi_data);
            $this->log_activity('update_referensi', 'Updated Referensi: ' . $referensi_data['judul']);
            $this->session->set_flashdata('success', 'Referensi berhasil diperbarui');
            redirect('admin/matkum/detail/' . $referensi->id_matkul);
        }

        $matkum = $this->Matkum_model->get_by_id($referensi->id_matkul);

        $data = array(
            'title' => 'Edit Referensi',
            'page_title' => 'Edit Referensi',
            'referensi' => $referensi,
            'matkum' => $matkum
        );

        $this->load_view('admin/matkum/edit_referensi', $data);
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

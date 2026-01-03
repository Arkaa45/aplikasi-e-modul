<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modul_model extends CI_Model
{

    private $table = 'modul';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all moduls for a pertemuan
     */
    public function get_by_pertemuan($pertemuan_id, $visible_only = false)
    {
        if ($visible_only) {
            $this->db->where('is_visible', 1);
        }
        $this->db->where('id_pertemuan', $pertemuan_id);
        $this->db->order_by('created_at', 'ASC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Get modul by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    /**
     * Get modul with full details
     */
    public function get_detail($id)
    {
        $this->db->select('modul.*, pertemuan.pertemuan_ke, pertemuan.judul as pertemuan_judul,
                          mata_kuliah.nama_matkul, mata_kuliah.kode_matkul,
                          semester.nama_semester, semester.tahun_ajaran,
                          users.nama as uploader_nama');
        $this->db->from($this->table);
        $this->db->join('pertemuan', 'pertemuan.id = modul.id_pertemuan');
        $this->db->join('mata_kuliah', 'mata_kuliah.id = pertemuan.id_matkul');
        $this->db->join('semester', 'semester.id = pertemuan.id_semester');
        $this->db->join('users', 'users.id = modul.uploaded_by');
        $this->db->where('modul.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Create new modul
     */
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update modul
     */
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete modul
     */
    public function delete($id)
    {
        // Get file info first
        $modul = $this->get_by_id($id);
        if ($modul && $modul->file_modul) {
            $file_path = FCPATH . 'uploads/modul/' . $modul->file_modul;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Increment download count
     */
    public function increment_download($id)
    {
        $this->db->set('download_count', 'download_count + 1', FALSE);
        $this->db->where('id', $id);
        return $this->db->update($this->table);
    }

    /**
     * Toggle visibility
     */
    public function toggle_visibility($id)
    {
        $modul = $this->get_by_id($id);
        if ($modul) {
            $this->db->where('id', $id);
            return $this->db->update($this->table, array('is_visible' => !$modul->is_visible));
        }
        return false;
    }

    /**
     * Get recent moduls
     */
    public function get_recent($limit = 10)
    {
        $this->db->select('modul.*, pertemuan.pertemuan_ke, mata_kuliah.nama_matkul, 
                          semester.nama_semester, semester.tahun_ajaran');
        $this->db->from($this->table);
        $this->db->join('pertemuan', 'pertemuan.id = modul.id_pertemuan');
        $this->db->join('mata_kuliah', 'mata_kuliah.id = pertemuan.id_matkul');
        $this->db->join('semester', 'semester.id = pertemuan.id_semester');
        $this->db->where('modul.is_visible', 1);
        $this->db->order_by('modul.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    /**
     * Get moduls by uploader
     */
    public function get_by_uploader($user_id, $limit = null)
    {
        $this->db->select('modul.*, pertemuan.pertemuan_ke, mata_kuliah.nama_matkul');
        $this->db->from($this->table);
        $this->db->join('pertemuan', 'pertemuan.id = modul.id_pertemuan');
        $this->db->join('mata_kuliah', 'mata_kuliah.id = pertemuan.id_matkul');
        $this->db->where('modul.uploaded_by', $user_id);
        $this->db->order_by('modul.created_at', 'DESC');
        if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get()->result();
    }

    /**
     * Count total moduls
     */
    public function count_all()
    {
        return $this->db->count_all_results($this->table);
    }

    /**
     * Count moduls by semester
     */
    public function count_by_semester($semester_id)
    {
        $this->db->from($this->table);
        $this->db->join('pertemuan', 'pertemuan.id = modul.id_pertemuan');
        $this->db->where('pertemuan.id_semester', $semester_id);
        return $this->db->count_all_results();
    }
}

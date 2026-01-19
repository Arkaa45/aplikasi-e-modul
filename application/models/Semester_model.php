<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Semester_model extends CI_Model
{

    private $table = 'semester';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all semesters
     */
    public function get_all()
    {
        $this->db->order_by('tahun_ajaran', 'DESC');
        $this->db->order_by('nama_semester', 'DESC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Get semester by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    /**
     * Get latest semester (based on start date)
     */
    public function get_latest()
    {
        $this->db->order_by('tanggal_mulai', 'DESC');
        $this->db->limit(1);
        return $this->db->get($this->table)->row();
    }

    /**
     * Create new semester
     */
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update semester
     */
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete semester
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Get accessible semesters for mahasiswa (current and past)
     */
    public function get_accessible()
    {
        $today = date('Y-m-d');
        $this->db->where('tanggal_mulai <=', $today);
        $this->db->order_by('tahun_ajaran', 'DESC');
        $this->db->order_by('nama_semester', 'DESC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Check if semester is accessible
     */
    public function is_accessible($id)
    {
        $today = date('Y-m-d');
        $this->db->where('id', $id);
        $this->db->where('tanggal_mulai <=', $today);
        return $this->db->count_all_results($this->table) > 0;
    }

    /**
     * Get semester display name
     */
    public function get_display_name($semester)
    {
        return $semester->nama_semester . ' ' . $semester->tahun_ajaran;
    }

    // =====================================================
    // MAHASISWA ASSIGNMENT METHODS
    // =====================================================

    /**
     * Get mahasiswa in semester
     */
    public function get_mahasiswa($semester_id)
    {
        $this->db->select('users.*');
        $this->db->from('users');
        $this->db->join('semester_mahasiswa', 'semester_mahasiswa.id_user = users.id');
        $this->db->where('semester_mahasiswa.id_semester', $semester_id);
        $this->db->where('users.role', 'mahasiswa');
        $this->db->order_by('users.nama', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Count mahasiswa in semester
     */
    public function count_mahasiswa($semester_id)
    {
        $this->db->where('id_semester', $semester_id);
        return $this->db->count_all_results('semester_mahasiswa');
    }

    /**
     * Assign mahasiswa to semester
     */
    public function assign_mahasiswa($semester_id, $user_id)
    {
        // Check if already assigned
        $this->db->where('id_semester', $semester_id);
        $this->db->where('id_user', $user_id);
        if ($this->db->count_all_results('semester_mahasiswa') > 0) {
            return true; // Already assigned
        }

        $data = array(
            'id_semester' => $semester_id,
            'id_user' => $user_id
        );
        return $this->db->insert('semester_mahasiswa', $data);
    }

    /**
     * Remove mahasiswa from semester
     */
    public function remove_mahasiswa($semester_id, $user_id)
    {
        $this->db->where('id_semester', $semester_id);
        $this->db->where('id_user', $user_id);
        return $this->db->delete('semester_mahasiswa');
    }

    /**
     * Check if mahasiswa is in semester
     */
    public function is_mahasiswa_enrolled($semester_id, $user_id)
    {
        $this->db->where('id_semester', $semester_id);
        $this->db->where('id_user', $user_id);
        return $this->db->count_all_results('semester_mahasiswa') > 0;
    }

    /**
     * Get semesters for mahasiswa
     */
    public function get_by_mahasiswa($user_id)
    {
        $this->db->select('semester.*');
        $this->db->from($this->table);
        $this->db->join('semester_mahasiswa', 'semester_mahasiswa.id_semester = semester.id');
        $this->db->where('semester_mahasiswa.id_user', $user_id);
        $this->db->order_by('semester.tahun_ajaran', 'DESC');
        $this->db->order_by('semester.nama_semester', 'DESC');
        return $this->db->get()->result();
    }

    // =====================================================
    // MATKUM ASSIGNMENT METHODS
    // =====================================================

    /**
     * Get matkum in semester
     */
    public function get_matkum($semester_id)
    {
        $this->db->select('mata_kuliah.*');
        $this->db->from('mata_kuliah');
        $this->db->join('semester_matkum', 'semester_matkum.id_matkul = mata_kuliah.id');
        $this->db->where('semester_matkum.id_semester', $semester_id);
        $this->db->order_by('mata_kuliah.kode_matkul', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Count matkum in semester
     */
    public function count_matkum($semester_id)
    {
        $this->db->where('id_semester', $semester_id);
        return $this->db->count_all_results('semester_matkum');
    }

    /**
     * Get semester with counts
     */
    public function get_with_counts($semester_id)
    {
        $semester = $this->get_by_id($semester_id);
        if ($semester) {
            $semester->matkum_count = $this->count_matkum($semester_id);
            $semester->mahasiswa_count = $this->count_mahasiswa($semester_id);
        }
        return $semester;
    }

    /**
     * Get all semesters with counts
     */
    public function get_all_with_counts()
    {
        $semesters = $this->get_all();
        foreach ($semesters as $semester) {
            $semester->matkum_count = $this->count_matkum($semester->id);
            $semester->mahasiswa_count = $this->count_mahasiswa($semester->id);
        }
        return $semesters;
    }
}

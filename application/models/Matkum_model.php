<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matkum_model extends CI_Model
{

    private $table = 'mata_kuliah';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all mata kuliah
     */
    public function get_all($is_active = null)
    {
        if ($is_active !== null) {
            $this->db->where('is_active', $is_active);
        }
        $this->db->order_by('kode_matkul', 'ASC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Get mata kuliah by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    /**
     * Get mata kuliah by kode
     */
    public function get_by_kode($kode)
    {
        return $this->db->get_where($this->table, array('kode_matkul' => $kode))->row();
    }

    /**
     * Create new mata kuliah
     */
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update mata kuliah
     */
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete mata kuliah
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Get mata kuliah for laboran
     */
    public function get_by_laboran($user_id)
    {
        $this->db->select('mata_kuliah.*');
        $this->db->from($this->table);
        $this->db->join('laboran_matkul', 'laboran_matkul.id_matkul = mata_kuliah.id');
        $this->db->where('laboran_matkul.id_user', $user_id);
        $this->db->where('mata_kuliah.is_active', 1);
        $this->db->order_by('mata_kuliah.kode_matkul', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Get mata kuliah for a semester
     */
    public function get_by_semester($semester_id)
    {
        $this->db->select('mata_kuliah.*');
        $this->db->from($this->table);
        $this->db->join('semester_matkum', 'semester_matkum.id_matkul = mata_kuliah.id');
        $this->db->where('semester_matkum.id_semester', $semester_id);
        $this->db->where('mata_kuliah.is_active', 1);
        $this->db->order_by('mata_kuliah.kode_matkul', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Assign matkum to semester
     */
    public function assign_to_semester($matkul_id, $semester_id)
    {
        // Check if already assigned
        $this->db->where('id_matkul', $matkul_id);
        $this->db->where('id_semester', $semester_id);
        if ($this->db->count_all_results('semester_matkum') > 0) {
            return true; // Already assigned
        }

        $data = array(
            'id_matkul' => $matkul_id,
            'id_semester' => $semester_id
        );
        return $this->db->insert('semester_matkum', $data);
    }

    /**
     * Remove matkum from semester
     */
    public function remove_from_semester($matkul_id, $semester_id)
    {
        $this->db->where('id_matkul', $matkul_id);
        $this->db->where('id_semester', $semester_id);
        return $this->db->delete('semester_matkum');
    }

    /**
     * Check if matkum is in semester
     */
    public function is_in_semester($matkul_id, $semester_id)
    {
        $this->db->where('id_matkul', $matkul_id);
        $this->db->where('id_semester', $semester_id);
        return $this->db->count_all_results('semester_matkum') > 0;
    }

    /**
     * Count total mata kuliah
     */
    public function count_all()
    {
        return $this->db->count_all_results($this->table);
    }

    /**
     * Assign laboran to mata kuliah
     */
    public function assign_laboran($matkul_id, $user_id)
    {
        $data = array(
            'id_matkul' => $matkul_id,
            'id_user' => $user_id
        );
        return $this->db->insert('laboran_matkul', $data);
    }

    /**
     * Remove laboran from mata kuliah
     */
    public function remove_laboran($matkul_id, $user_id)
    {
        $this->db->where('id_matkul', $matkul_id);
        $this->db->where('id_user', $user_id);
        return $this->db->delete('laboran_matkul');
    }

    /**
     * Get all laborans assigned to a mata kuliah
     */
    public function get_laborans_by_matkul($matkul_id)
    {
        $this->db->select('users.*');
        $this->db->from('users');
        $this->db->join('laboran_matkul', 'laboran_matkul.id_user = users.id');
        $this->db->where('laboran_matkul.id_matkul', $matkul_id);
        $this->db->order_by('users.nama', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Check if laboran is assigned to matkul
     */
    public function is_laboran_assigned($matkul_id, $user_id)
    {
        $this->db->where('id_matkul', $matkul_id);
        $this->db->where('id_user', $user_id);
        return $this->db->count_all_results('laboran_matkul') > 0;
    }

    /**
     * Get matkum with content counts
     */
    public function get_with_content_counts($matkul_id)
    {
        $matkum = $this->get_by_id($matkul_id);
        if ($matkum) {
            // Count RPS
            $this->db->where('id_matkul', $matkul_id);
            $matkum->rps_count = $this->db->count_all_results('matkum_rps');

            // Count Referensi
            $this->db->where('id_matkul', $matkul_id);
            $matkum->referensi_count = $this->db->count_all_results('matkum_referensi');

            // Count Modul
            $this->db->where('id_matkul', $matkul_id);
            $matkum->modul_count = $this->db->count_all_results('modul');
        }
        return $matkum;
    }
}

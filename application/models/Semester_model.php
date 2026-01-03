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
    public function get_all($is_active = null)
    {
        if ($is_active !== null) {
            $this->db->where('is_active', $is_active);
        }
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
     * Get active semester
     */
    public function get_active()
    {
        return $this->db->get_where($this->table, array('is_active' => 1))->row();
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
     * Set active semester (deactivate all others)
     */
    public function set_active($id)
    {
        // Deactivate all semesters
        $this->db->update($this->table, array('is_active' => 0));

        // Activate selected semester
        $this->db->where('id', $id);
        return $this->db->update($this->table, array('is_active' => 1));
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
}

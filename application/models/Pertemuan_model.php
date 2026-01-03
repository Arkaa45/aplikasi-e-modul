<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pertemuan_model extends CI_Model
{

    private $table = 'pertemuan';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all pertemuan for a mata kuliah in a semester
     */
    public function get_by_matkul($matkul_id, $semester_id = null)
    {
        $this->db->where('id_matkul', $matkul_id);
        if ($semester_id) {
            $this->db->where('id_semester', $semester_id);
        }
        $this->db->where('is_active', 1);
        $this->db->order_by('pertemuan_ke', 'ASC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Get pertemuan by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    /**
     * Get pertemuan with mata kuliah and semester info
     */
    public function get_detail($id)
    {
        $this->db->select('pertemuan.*, mata_kuliah.nama_matkul, mata_kuliah.kode_matkul, 
                          semester.nama_semester, semester.tahun_ajaran');
        $this->db->from($this->table);
        $this->db->join('mata_kuliah', 'mata_kuliah.id = pertemuan.id_matkul');
        $this->db->join('semester', 'semester.id = pertemuan.id_semester');
        $this->db->where('pertemuan.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Create new pertemuan
     */
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update pertemuan
     */
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete pertemuan
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Count pertemuan by matkul and semester
     */
    public function count_by_matkul($matkul_id, $semester_id = null)
    {
        $this->db->where('id_matkul', $matkul_id);
        if ($semester_id) {
            $this->db->where('id_semester', $semester_id);
        }
        return $this->db->count_all_results($this->table);
    }

    /**
     * Get next pertemuan number
     */
    public function get_next_number($matkul_id, $semester_id)
    {
        $this->db->select_max('pertemuan_ke');
        $this->db->where('id_matkul', $matkul_id);
        $this->db->where('id_semester', $semester_id);
        $result = $this->db->get($this->table)->row();
        return ($result->pertemuan_ke ?? 0) + 1;
    }
}

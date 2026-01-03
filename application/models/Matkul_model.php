<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matkul_model extends CI_Model
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
     * Get mata kuliah for mahasiswa in a semester
     */
    public function get_by_mahasiswa($user_id, $semester_id = null)
    {
        $this->db->select('mata_kuliah.*, user_matkul.id_semester');
        $this->db->from($this->table);
        $this->db->join('user_matkul', 'user_matkul.id_matkul = mata_kuliah.id');
        $this->db->where('user_matkul.id_user', $user_id);
        if ($semester_id) {
            $this->db->where('user_matkul.id_semester', $semester_id);
        }
        $this->db->where('mata_kuliah.is_active', 1);
        $this->db->order_by('mata_kuliah.kode_matkul', 'ASC');
        return $this->db->get()->result();
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
     * Enroll mahasiswa to mata kuliah
     */
    public function enroll_mahasiswa($matkul_id, $user_id, $semester_id)
    {
        $data = array(
            'id_matkul' => $matkul_id,
            'id_user' => $user_id,
            'id_semester' => $semester_id
        );
        return $this->db->insert('user_matkul', $data);
    }

    /**
     * Unenroll mahasiswa from mata kuliah
     */
    public function unenroll_mahasiswa($matkul_id, $user_id, $semester_id)
    {
        $this->db->where('id_matkul', $matkul_id);
        $this->db->where('id_user', $user_id);
        $this->db->where('id_semester', $semester_id);
        return $this->db->delete('user_matkul');
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rps_model extends CI_Model
{

    private $table = 'matkum_rps';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all RPS for a matkum
     */
    public function get_by_matkul($matkul_id)
    {
        $this->db->select('matkum_rps.*, users.nama as uploader_nama');
        $this->db->from($this->table);
        $this->db->join('users', 'users.id = matkum_rps.uploaded_by');
        $this->db->where('id_matkul', $matkul_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Get RPS by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    /**
     * Create new RPS
     */
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update RPS
     */
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete RPS
     */
    public function delete($id)
    {
        $rps = $this->get_by_id($id);
        if ($rps && $rps->file_path) {
            $file_path = FCPATH . 'uploads/rps/' . $rps->file_path;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Count RPS by matkul
     */
    public function count_by_matkul($matkul_id)
    {
        return $this->db->where('id_matkul', $matkul_id)->count_all_results($this->table);
    }
}

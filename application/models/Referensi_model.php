<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Referensi_model extends CI_Model
{

    private $table = 'matkum_referensi';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all referensi for a matkum
     */
    public function get_by_matkul($matkul_id)
    {
        $this->db->select('matkum_referensi.*, users.nama as uploader_nama');
        $this->db->from($this->table);
        $this->db->join('users', 'users.id = matkum_referensi.uploaded_by');
        $this->db->where('id_matkul', $matkul_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Get referensi by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    /**
     * Create new referensi
     */
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update referensi
     */
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete referensi
     */
    public function delete($id)
    {
        $ref = $this->get_by_id($id);
        if ($ref && $ref->file_path) {
            $file_path = FCPATH . 'uploads/referensi/' . $ref->file_path;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Count referensi by matkul
     */
    public function count_by_matkul($matkul_id)
    {
        return $this->db->where('id_matkul', $matkul_id)->count_all_results($this->table);
    }
}

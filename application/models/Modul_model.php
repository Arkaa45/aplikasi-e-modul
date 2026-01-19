<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modul_model extends CI_Model
{

    private $table = 'modul';
    private $max_slots = 16;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all moduls for a matkum
     */
    public function get_by_matkul($matkul_id, $visible_only = false)
    {
        $this->db->select('modul.*, users.nama as uploader_nama');
        $this->db->from($this->table);
        $this->db->join('users', 'users.id = modul.uploaded_by', 'left');
        $this->db->where('id_matkul', $matkul_id);
        if ($visible_only) {
            $this->db->where('is_visible', 1);
        }
        $this->db->order_by('slot_number', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Get modul slots with empty placeholders (for UI)
     */
    public function get_slots_by_matkul($matkul_id, $num_slots = 16)
    {
        $moduls = $this->get_by_matkul($matkul_id);
        $slots = array();

        // Create slot map
        $modul_map = array();
        foreach ($moduls as $modul) {
            $modul_map[$modul->slot_number] = $modul;
        }

        // Build slots array with placeholders
        for ($i = 1; $i <= $num_slots; $i++) {
            if (isset($modul_map[$i])) {
                $slots[$i] = $modul_map[$i];
            } else {
                $slots[$i] = null; // Empty slot
            }
        }

        return $slots;
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
        $this->db->select('modul.*, mata_kuliah.nama_matkul, mata_kuliah.kode_matkul, users.nama as uploader_nama');
        $this->db->from($this->table);
        $this->db->join('mata_kuliah', 'mata_kuliah.id = modul.id_matkul');
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
     * Check if slot is available
     */
    public function is_slot_available($matkul_id, $slot_number)
    {
        $this->db->where('id_matkul', $matkul_id);
        $this->db->where('slot_number', $slot_number);
        return $this->db->count_all_results($this->table) == 0;
    }

    /**
     * Get next available slot
     */
    public function get_next_available_slot($matkul_id)
    {
        for ($i = 1; $i <= $this->max_slots; $i++) {
            if ($this->is_slot_available($matkul_id, $i)) {
                return $i;
            }
        }
        return null; // All slots full
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
        $this->db->select('modul.*, mata_kuliah.nama_matkul');
        $this->db->from($this->table);
        $this->db->join('mata_kuliah', 'mata_kuliah.id = modul.id_matkul');
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
        $this->db->select('modul.*, mata_kuliah.nama_matkul');
        $this->db->from($this->table);
        $this->db->join('mata_kuliah', 'mata_kuliah.id = modul.id_matkul');
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
     * Count moduls by matkul
     */
    public function count_by_matkul($matkul_id)
    {
        return $this->db->where('id_matkul', $matkul_id)->count_all_results($this->table);
    }
}

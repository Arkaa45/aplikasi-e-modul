<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{

    private $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all users with optional filter
     */
    public function get_all($role = null, $is_active = null)
    {
        if ($role) {
            $this->db->where('role', $role);
        }
        if ($is_active !== null) {
            $this->db->where('is_active', $is_active);
        }
        $this->db->order_by('nama', 'ASC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Get user by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    /**
     * Get user by email
     */
    public function get_by_email($email)
    {
        return $this->db->get_where($this->table, array('email' => $email))->row();
    }

    /**
     * Create new user
     */
    public function create($data)
    {
        // Hash password
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update user
     */
    public function update($id, $data)
    {
        // Hash password if provided
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }

        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete user
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Verify login credentials
     */
    public function verify_login($email, $password)
    {
        $user = $this->get_by_email($email);

        if ($user && password_verify($password, $user->password)) {
            if ($user->is_active) {
                return $user;
            }
        }

        return false;
    }

    /**
     * Count users by role
     */
    public function count_by_role($role = null)
    {
        if ($role) {
            $this->db->where('role', $role);
        }
        return $this->db->count_all_results($this->table);
    }

    /**
     * Get mahasiswa by angkatan
     */
    public function get_mahasiswa_by_angkatan($angkatan)
    {
        $this->db->where('role', 'mahasiswa');
        $this->db->where('angkatan', $angkatan);
        $this->db->order_by('nama', 'ASC');
        return $this->db->get($this->table)->result();
    }
}

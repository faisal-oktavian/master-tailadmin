<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    protected $table = 'users';

    public function all()
    {
         return $this->db
            ->select('users.id, users.idrole, users.nama, users.email, users.created, users.updated, role.title AS role_title, role.name AS role_name')
            ->from($this->table)
            ->join('role', 'role.idrole = users.idrole', 'left')
            ->where('role.name !=', 'superadmin')
            ->where('role.status', 1)
            ->where('users.status', 1)
            ->order_by('users.id', 'DESC')
            ->get()->result_array();
    }

    public function find($id)
    {
        return $this->db->get_where($this->table, array('id' => (int) $id, 'status' => 1), 1)->row_array();
    }

    public function get_by_email($email)
    {
        return $this->db->get_where($this->table, array('email' => $email, 'status' => 1), 1)->row_array();
    }

    public function insert($data)
    {
        $data['created'] = date('Y-m-d H:i:s');
        $data['createdby'] = $this->session->userdata('user_nama');
        $data['updated'] = date('Y-m-d H:i:s');
        $data['updatedby'] = $this->session->userdata('user_nama');
        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $data['updated'] = date('Y-m-d H:i:s');
        $data['updatedby'] = $this->session->userdata('user_nama');
        return $this->db->where('id', (int) $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        $data['updated'] = date('Y-m-d H:i:s');
        $data['updatedby'] = $this->session->userdata('user_nama');
        $data['status'] = 0;
        return $this->db->where('id', (int) $id)->update($this->table, $data);
    }

    /** Jumlah user ber-role administrator (untuk melindungi admin terakhir). */
    public function count_administrators()
    {
        return (int) $this->db
            ->from($this->table)
            ->join('role', 'role.idrole = users.idrole')
            ->where_in('role.name', array('administrator', 'superadmin'))
            ->where('role.status', 1)
            ->where('users.status', 1)
            ->count_all_results();
    }

    public function is_administrator($user_id)
    {
        return (bool) $this->db
            ->from($this->table)
            ->join('role', 'role.idrole = users.idrole')
            ->where('users.id', (int) $user_id)
            ->where('users.status', 1)
            ->where_in('role.name', array('administrator', 'superadmin') )
            ->count_all_results();
    }
}

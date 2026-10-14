<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends CI_Model
{
    protected $table = 'supplier';

    public function all()
    {
        return $this->db->order_by('id', 'DESC')->get($this->table)->result_array();
    }

    public function find($id)
    {
        return $this->db->get_where($this->table, array('id' => (int) $id), 1)->row_array();
    }

    public function insert($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', (int) $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', (int) $id)->delete($this->table);
    }

    public function stats()
    {
        $row = $this->db->select('COUNT(*) AS total, COALESCE(SUM(aktif = 1), 0) AS aktif', FALSE)
            ->get($this->table)->row_array();
        return array('total' => (int) $row['total'], 'aktif' => (int) $row['aktif']);
    }
}

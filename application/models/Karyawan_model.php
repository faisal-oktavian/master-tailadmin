<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan_model extends CI_Model
{
    protected $table = 'karyawan';

    public function all()
    {
        $this->db->order_by('id', 'DESC');
        $karyawan = $this->db->get($this->table);
        // echo "<pre>"; print_r($this->db->last_query());die;

        $data_kary = $karyawan->result_array();

        return $data_kary;
    }

    public function find($id)
    {
        $this->db->where('id', (int) $id);
        $this->db->limit(1);
        $karyawan = $this->db->get($this->table);
        // echo "<pre>"; print_r($this->db->last_query());die;

        $data_kary = $karyawan->row_array();

        return $data_kary;
    }

    public function insert($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $kary = $this->db->insert($this->table, $data);
        $idkaryawan = $this->db->insert_id();

        return $idkaryawan;
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->where('id', (int) $id);
        $update_kary = $this->db->update($this->table, $data);
        
        return $update_kary;
    }

    public function delete($id)
    {
        
        $this->db->where('id', (int) $id);
        $update_kary = $this->db->delete($this->table);
        
        return $update_kary;

        return $this->db->where('id', (int) $id)->delete($this->table);
    }

    public function stats()
    {
        $row = $this->db->select('COUNT(*) AS total, COALESCE(SUM(aktif = 1), 0) AS aktif', FALSE)
            ->get($this->table)->row_array();
        return array('total' => (int) $row['total'], 'aktif' => (int) $row['aktif']);
    }

    public function recent($limit = 5)
    {
        return $this->db->order_by('id', 'DESC')->limit((int) $limit)->get($this->table)->result_array();
    }

    /** Jumlah karyawan bergabung per bulan (Jan..Des) pada tahun tertentu. */
    public function joined_per_month($year)
    {
        $rows = $this->db
            ->select('MONTH(tgl_bergabung) AS bulan, COUNT(*) AS total', FALSE)
            ->where('YEAR(tgl_bergabung)', (int) $year, FALSE)
            ->group_by('MONTH(tgl_bergabung)', FALSE)
            ->get($this->table)->result_array();

        $out = array_fill(1, 12, 0);
        foreach ($rows as $r) {
            $out[(int) $r['bulan']] = (int) $r['total'];
        }
        return array_values($out);
    }
}

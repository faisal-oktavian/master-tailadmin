<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan_model extends CI_Model
{
    protected $table = 'karyawan';

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

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model CRUD Master User (tabel `users`).
 * Dipisah dari User_model (yang dipakai Auth untuk login).
 */
class Master_user_model extends CI_Model
{
    protected $table = 'users';

    /** Daftar untuk tabel: TANPA kolom password. */
    public function all()
    {
        return $this->db
            ->select('users.id, users.idrole, users.nama, users.email, users.created_at, role.title AS role_title, role.name AS role_name')
            ->from($this->table)
            ->join('role', 'role.idrole = users.idrole', 'left')
            ->order_by('users.id', 'DESC')
            ->get()->result_array();
    }

    /** Satu baris lengkap (termasuk hash password; jangan dikirim ke browser). */
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
        return $this->db->where('id', (int) $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        // user_access ikut terhapus otomatis (FK ON DELETE CASCADE)
        return $this->db->where('id', (int) $id)->delete($this->table);
    }

    /** Jumlah user ber-role administrator (untuk melindungi admin terakhir). */
    public function count_administrators()
    {
        return (int) $this->db
            ->from($this->table)
            ->join('role', 'role.idrole = users.idrole')
            ->where('role.name', 'administrator')
            ->where('role.status', 1)
            ->count_all_results();
    }

    public function is_administrator($user_id)
    {
        return (bool) $this->db
            ->from($this->table)
            ->join('role', 'role.idrole = users.idrole')
            ->where('users.id', (int) $user_id)
            ->where('role.name', 'administrator')
            ->count_all_results();
    }
}

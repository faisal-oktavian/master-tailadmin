<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model
{
    const MENUS = array('dashboard', 'karyawan', 'supplier', 'user', 'user_role');

    private function has_full_access_role($role_name)
    {
        return in_array(strtolower((string) $role_name), array('administrator', 'superadmin'), TRUE);
    }

    private function all_menu_permissions()
    {
        return array_fill_keys(self::MENUS, TRUE);
    }

    public function get_user_permissions($user_id)
    {
        $user = $this->db
            ->select('role.name AS role_name')
            ->from('users')
            ->join('role', 'role.idrole = users.idrole')
            ->where('users.id', $user_id)
            ->where('role.status', 1)
            ->where('users.status', 1)
            ->get()
            ->row_array();

        if (!$user) {
            return array();
        }
        if ($this->has_full_access_role($user['role_name'])) {
            return $this->all_menu_permissions();
        }

        $rows = $this->db
            ->select('menu_name, access')
            ->where('user_id', $user_id)
            ->where('status', 1)
            ->get('user_access')
            ->result_array();

        $permissions = array();
        foreach ($rows as $row) {
            $permissions[$row['menu_name']] = (int) $row['access'] === 1;
        }

        return $permissions;
    }

    public function has_user_access($user_id, $menu_name)
    {
        $user = $this->db
            ->select('role.name AS role_name')
            ->from('users')
            ->join('role', 'role.idrole = users.idrole')
            ->where('users.id', $user_id)
            ->where('role.status', 1)
            ->where('users.status', 1)
            ->get()
            ->row_array();

        if (!$user) {
            return false;
        }
        if ($this->has_full_access_role($user['role_name'])) {
            return true;
        }

        return !empty($this->get_user_permissions($user_id)[$menu_name]);
    }

    public function save_user_permissions($user_id, $permissions, $allowed_menus)
    {
        $user_role = $this->get_user_role($user_id);
        if ($user_role && $this->has_full_access_role($user_role['name'])) {
            return true;
        }

        $this->db->trans_start();
        foreach ($allowed_menus as $menu_name) {
            $existing = $this->db
                ->select('iduser_access')
                ->where('user_id', $user_id)
                ->where('menu_name', $menu_name)
                ->get('user_access')
                ->row_array();

            $data = array(
                'user_id' => $user_id,
                'menu_name' => $menu_name,
                'access' => isset($permissions[$menu_name]) && !is_array($permissions[$menu_name]) && (string) $permissions[$menu_name] === '1' ? 1 : 0,
                'status' => 1,
                'updated' => date('Y-m-d H:i:s'),
            );

            if ($existing) {
                $this->db->where('iduser_access', $existing['iduser_access'])->update('user_access', $data);
            } else {
                $data['created'] = date('Y-m-d H:i:s');
                $this->db->insert('user_access', $data);
            }
        }
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function get_user_role($user_id)
    {
        return $this->db
            ->select('role.idrole, role.name, role.title')
            ->from('users')
            ->join('role', 'role.idrole = users.idrole')
            ->where('users.id', $user_id)
            ->where('role.status', 1)
            ->where('users.status', 1)
            ->get()
            ->row_array();
    }

    public function get_permissions($role_id)
    {
        $role = $this->get_role($role_id);
        if (!$role) {
            return array();
        }
        if ($this->has_full_access_role($role['name'])) {
            return $this->all_menu_permissions();
        }

        $rows = $this->db
            ->select('menu_name, access')
            ->where('idrole', $role_id)
            ->where('status', 1)
            ->get('user_role')
            ->result_array();

        $permissions = array();
        foreach ($rows as $row) {
            $permissions[$row['menu_name']] = (int) $row['access'] === 1;
        }

        return $permissions;
    }

    public function has_access($role_id, $menu_name)
    {
        $role = $this->db
            ->select('name')
            ->where('idrole', $role_id)
            ->where('status', 1)
            ->get('role')
            ->row_array();

        if (!$role) {
            return false;
        }
        if ($this->has_full_access_role($role['name'])) {
            return true;
        }

        return !empty($this->get_permissions($role_id)[$menu_name]);
    }

    public function get_roles()
    {
        return $this->db
            ->where('status', 1)
            ->where('name !=', 'superadmin')
            ->order_by('title', 'ASC')
            ->get('role')
            ->result_array();
    }

    public function get_role($role_id)
    {
        return $this->db->get_where('role', array('idrole' => $role_id, 'status' => 1), 1)->row_array();
    }

    public function get_role_by_name($name)
    {
        return $this->db->get_where('role', array('name' => $name, 'status' => 1), 1)->row_array();
    }

    public function role_name_exists($name)
    {
        return $this->db->where('name', $name)->count_all_results('role') > 0;
    }

    public function get_users_with_roles()
    {
        return $this->db
            ->select('users.id, users.nama, users.email, users.idrole, role.title AS role_title, role.name AS role_name')
            ->from('users')
            ->join('role', 'role.idrole = users.idrole', 'left')
            ->where('role.name !=', 'superadmin')
            ->where('users.status', 1)
            ->where('role.status', 1)
            ->order_by('users.nama', 'ASC')
            ->get()
            ->result_array();
    }

    public function save_permissions($role_id, $permissions, $allowed_menus)
    {
        $role = $this->get_role($role_id);
        if ($role && $this->has_full_access_role($role['name'])) {
            return true;
        }

        $this->db->trans_start();
        foreach ($allowed_menus as $menu_name) {
            $this->save_permission($role_id, $menu_name, !empty($permissions[$menu_name]) ? 1 : 0);
        }
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    private function save_permission($role_id, $menu_name, $access)
    {
        $existing = $this->db
            ->select('iduser_role')
            ->where('idrole', $role_id)
            ->where('menu_name', $menu_name)
            ->get('user_role')
            ->row_array();

        $data = array(
            'idrole' => $role_id,
            'menu_name' => $menu_name,
            'access' => $access,
            'status' => 1,
            'updated' => date('Y-m-d H:i:s'),
        );

        if ($existing) {
            $this->db->where('iduser_role', $existing['iduser_role'])->update('user_role', $data);
            return;
        }

        $data['created'] = date('Y-m-d H:i:s');
        $this->db->insert('user_role', $data);
    }

    public function create_role($name, $title, $description)
    {
        return $this->db->insert('role', array(
            'name' => $name,
            'title' => $title,
            'description' => $description,
            'status' => 1,
            'created' => date('Y-m-d H:i:s'),
            'updated' => date('Y-m-d H:i:s'),
        ));
    }

    public function assign_users($assignments)
    {
        $this->db->trans_start();
        foreach ($assignments as $user_id => $role_id) {
            $this->db->where('id', (int) $user_id)->update('users', array('idrole' => (int) $role_id));
        }
        $this->db->trans_complete();

        return $this->db->trans_status();
    }
}
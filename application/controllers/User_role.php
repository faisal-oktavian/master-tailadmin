<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_role extends Admin_Controller
{
    private $modules = array(
        'dashboard' => 'Dashboard',
        'karyawan'  => 'Master Karyawan',
        'supplier'  => 'Master Supplier',
        'user'      => 'User',
        'user_role' => 'Hak Akses',
    );

    public function index()
    {
        $this->require_access('user_role');

        $users = $this->Role_model->get_users_with_roles();
        $selected_id = (int) $this->input->get('user_id');
        $selected_user = null;

        foreach ($users as $user) {
            if ((int) $user['id'] === $selected_id) {
                $selected_user = $user;
                break;
            }
        }
        if (!$selected_user && !empty($users)) {
            $selected_user = $users[0];
        }

        $data = array(
            'users' => $users,
            'selected_user' => $selected_user,
            'permissions' => $selected_user ? $this->Role_model->get_user_permissions($selected_user['id']) : array(),
            'modules' => $this->modules,
            'notice' => $this->session->flashdata('role_notice'),
        );

        $page_config = array(
            'title' => 'Hak Akses',
            'page' => 'user_role',
            'breadcrumb' => array('Administrasi', 'Hak Akses'),
            'breadcrumb_links' => array('user_role'),
        );

        $this->render('user_role/index', $data, $page_config);
    }

    public function save_permissions()
    {
        $this->require_access('user_role');
        if ($this->input->method() !== 'post') {
            redirect('user_role');
        }

        $user_id = (int) $this->input->post('user_id');
        $user = $this->Role_model->get_user_role($user_id);
        if (!$user) {
            return $this->role_redirect('User tidak ditemukan.');
        }
        if (in_array(strtolower($user['name']), array('administrator', 'superadmin'), TRUE)) {
            return $this->role_redirect('Akun Administrator selalu memiliki akses penuh.');
        }

        $permissions = $this->input->post('permissions');
        $permissions = is_array($permissions) ? $permissions : array();
        if (!$this->Role_model->save_user_permissions($user_id, $permissions, array_keys($this->modules))) {
            return $this->role_redirect('Izin gagal disimpan.', $user_id);
        }

        return $this->role_redirect('Hak akses user berhasil disimpan.', $user_id);
    }

    private function role_redirect($message, $user_id = 0)
    {
        $this->session->set_flashdata('role_notice', $message);
        redirect('user_role' . ($user_id ? '?user_id=' . (int) $user_id : ''));
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Master User - CRUD memakai popup modal (AJAX + SweetAlert), pola sama dengan Karyawan.
 */
class User extends Admin_Controller
{
    /** Menu yang akses awalnya disalin dari role saat user baru dibuat. */
    const MENUS = array('dashboard', 'karyawan', 'supplier', 'user', 'user_role');

    public function __construct()
    {
        parent::__construct();
        $this->require_access('user');
        $this->load->model('User_model');
    }

    // ------------------------------------------------------------ list
    public function index()
    {
        $data = array(
            'rows'  => $this->User_model->all(),
            'roles' => $this->Role_model->get_roles(),
        );
        // echo "<pre>"; print_R($data); die;

        $page_config = array(
            'title'      => 'User',
            'page'       => 'user',
            'breadcrumb' => array('Administrasi', 'User'),
            'breadcrumb_links' => array('user'),
        );

        $this->render('user/index', $data, $page_config);
    }

    // ------------------------------------------------------------ refresh tabel (AJAX)
    public function table()
    {
        $data = array(
            'rows'    => $this->User_model->all(),
            // 'my_id'   => (int) $this->auth_user['id'],
        );

        $html = $this->load->view('user/_rows', $data, TRUE);

        $this->output->set_content_type('text/html')->set_output($html);
    }

    // ------------------------------------------------------------ detail (untuk modal edit)
    public function get($id = 0)
    {
        $row = $this->User_model->find($id);
        if (!$row) {
            $return = array(
                'status' => false, 
                'message' => 'Data tidak ditemukan.'
            );

            return $this->json($return, 404);
        }

        unset($row['password']); // hash tidak boleh sampai ke browser
        
        $return = array(
            'status' => true, 
            'data' => $row
        );
        
        return $this->json($return);
    }

    // ------------------------------------------------------------ create
    public function store()
    {
        if ($this->input->method() !== 'post') {
            $return = array(
                'status' => false, 
                'message' => 'Metode tidak diizinkan.'
            );

            return $this->json($return, 405);
        }

        $this->apply_rules(0);
        if (!$this->form_validation->run()) {
            return $this->validation_failed();
        }

        $data = $this->collect();
        $data['password'] = password_hash((string) $this->input->post('password'), PASSWORD_DEFAULT);

        $new_id = $this->User_model->insert($data);

        // Akses menu awal user baru = izin role-nya (bisa diubah di menu Hak Akses)
        $this->Role_model->save_user_permissions(
            $new_id,
            $this->Role_model->get_permissions($data['idrole']),
            self::MENUS
        );

        $return = array(
            'status' => true, 
            'message' => 'Data user berhasil ditambahkan.'
        );
        
        return $this->json($return);
    }

    // ------------------------------------------------------------ update
    public function update($id = 0)
    {
        if ($this->input->method() !== 'post') {
            $return = array(
                'status' => false,
                'message' => 'Metode tidak diizinkan.'
            );

            return $this->json($return, 405);
        }

        $row = $this->User_model->find($id);
        if (!$row) {
            $return = array(
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            );

            return $this->json($return, 404);
        }

        $this->apply_rules((int) $id);
        if (!$this->form_validation->run()) {
            return $this->validation_failed();
        }

        $data = $this->collect();

        // Jangan sampai administrator terakhir kehilangan role-nya
        if ((int) $data['idrole'] !== (int) $row['idrole']
            && $this->User_model->is_administrator($id)
            && $this->User_model->count_administrators() <= 1) {

            $return = array(
                'idrole' => 'Role administrator terakhir tidak boleh diubah.'
            );

            return $this->validation_failed($return);
        }

        $new_password = (string) $this->input->post('password');
        if ($new_password !== '') {
            $data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
        }

        $this->User_model->update($id, $data);

        // Sinkronkan nama di sesi bila user mengubah akunnya sendiri
        if ((int) $id === (int) $this->auth_user['id']) {
            $this->session->set_userdata(array(
                'user_nama'  => $data['nama'],
                'user_email' => $data['email'],
            ));
        }

        $return = array(
            'status' => true,
            'message' => 'Data user berhasil diperbarui.'
        );

        return $this->json($return);
    }

    // ------------------------------------------------------------ delete
    public function delete($id = 0)
    {
        if ($this->input->method() !== 'post') {
            $return = array(
                'status' => false,
                'message' => 'Metode tidak diizinkan.'
            );

            return $this->json($return, 405);
        }

        $row = $this->User_model->find($id);
        if (!$row) {
            $return = array(
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            );

            return $this->json($return, 404);
        }

        if ((int) $id === (int) $this->auth_user['id']) {
            $return = array(
                'status' => false,
                'message' => 'Anda tidak dapat menghapus akun yang sedang digunakan.'
            );

            return $this->json($return, 422);
        }
        if ($this->User_model->is_administrator($id) && $this->User_model->count_administrators() <= 1) {
            $return = array(
                'status' => false,
                'message' => 'Administrator tidak dapat dihapus.'
            );

            return $this->json($return, 422);
        }

        $this->User_model->delete($id);
        $return = array(
            'status' => true,
            'message' => 'Data user berhasil dihapus.'
        );

        return $this->json($return);
    }

    // ============================================================ helpers
    private function apply_rules($id)
    {
        $unique_email = $id ? 'edit_unique[users.email.' . $id . ']' : 'is_unique[users.email]';
        $pass_rule    = $id ? 'min_length[6]' : 'required|min_length[6]';
        $role_ids     = array_map(function ($r) { return (int) $r['idrole']; }, $this->Role_model->get_roles());

        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[100]|' . $unique_email);
        $this->form_validation->set_rules('password', 'Password', $pass_rule);
        $this->form_validation->set_rules('idrole', 'Role', 'trim|required|in_list[' . implode(',', $role_ids) . ']');
    }

    private function collect()
    {
        return array(
            'idrole' => (int) $this->input->post('idrole'),
            'nama'   => $this->input->post('nama', TRUE),
            'email'  => $this->input->post('email', TRUE),
        );
    }

    private function validation_failed($extra = array())
    {
        $errors = array_merge($this->form_validation->error_array(), $extra);

        $return = array(
            'status'  => false,
            'message' => 'Periksa kembali isian Anda.',
            'errors'  => $errors,
        );
        
        return $this->json($return, 422);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Master Karyawan - CRUD memakai popup modal (AJAX + SweetAlert).
 */
class Karyawan extends Admin_Controller
{
    const DEPARTEMEN = array('IT', 'HRD', 'Keuangan', 'Marketing', 'Operasional');
    const SKILLS     = array('PHP', 'JavaScript', 'Python', 'SQL', 'Desain', 'Akuntansi', 'Manajemen');
    const BAHASA     = array('Indonesia', 'Inggris', 'Mandarin', 'Jepang', 'Arab');

    public function __construct()
    {
        parent::__construct();
        $this->require_access('karyawan');
        $this->load->model('Karyawan_model');
    }

    // ------------------------------------------------------------ list
    public function index()
    {
        $data = array(
            'rows'        => $this->Karyawan_model->all(),
            'departemen'  => self::DEPARTEMEN,
            'skills'      => self::SKILLS,
            'bahasa'      => self::BAHASA,
        );

        $page_config = array(
            'title'      => 'Master Karyawan',
            'page'       => 'karyawan',
            'breadcrumb' => array('Master Data', 'Master Karyawan'),
            'breadcrumb_links' => array('karyawan'),
        );
        
        $this->render('karyawan/index', $data, $page_config);
    }

    // ------------------------------------------------------------ refresh tabel (AJAX)
    public function table()
    {
        $data = array(
            'rows' => $this->Karyawan_model->all(),
        );

        $html = $this->load->view('karyawan/_rows', $data, TRUE);

        $this->output->set_content_type('text/html')->set_output($html);
    }

    // ------------------------------------------------------------ detail (untuk modal edit)
    public function get($id = 0)
    {
        $row = $this->Karyawan_model->find($id);

        if (!$row) {
            $return = array(
                'status' => false, 
                'message' => 'Data tidak ditemukan.'
            );

            return $this->json($return, 404);
        }

        unset($row['password']);
        $row['skills']        = $row['skills'] === '' ? array() : explode(',', $row['skills']);
        $row['bahasa']        = $row['bahasa'] === '' ? array() : explode(',', $row['bahasa']);
        $row['jam_masuk']     = substr($row['jam_masuk'], 0, 5);
        $row['tgl_bergabung'] = str_replace(' ', 'T', substr($row['tgl_bergabung'], 0, 16));
        $row['foto_url']      = $row['foto'] ? base_url('uploads/karyawan/' . $row['foto']) : '';
        $row['gaji']           = (int) $row['gaji'];

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

        $upload = $this->handle_upload();
        if ($upload['error']) {
            $return = array(
                'foto' => $upload['error']
            );
            
            return $this->validation_failed($return);
        }

        $data = $this->collect();
        $data['password'] = password_hash((string) $this->input->post('password'), PASSWORD_DEFAULT);
        $data['foto']     = $upload['file'];

        $this->Karyawan_model->insert($data);

        $return = array(
            'status' => true, 
            'message' => 'Data karyawan berhasil ditambahkan.'
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

        $row = $this->Karyawan_model->find($id);
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

        $upload = $this->handle_upload();
        if ($upload['error']) {
            $return = array(
                'foto' => $upload['error']
            );

            return $this->validation_failed($return);
        }

        $data = $this->collect();
        $new_password = (string) $this->input->post('password');
        if ($new_password !== '') {
            $data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
        }
        if ($upload['file']) {
            $data['foto'] = $upload['file'];
            $this->delete_file($row['foto']);
        }

        $this->Karyawan_model->update($id, $data);

        $return = array(
            'status' => true,
            'message' => 'Data karyawan berhasil diperbarui.'
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

        $row = $this->Karyawan_model->find($id);
        if (!$row) {
            $return = array(
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            );

            return $this->json($return, 404);
        }

        $this->Karyawan_model->delete($id);
        $this->delete_file($row['foto']);
        
        $return = array(
            'status' => true,
            'message' => 'Data karyawan berhasil dihapus.'
        );

        return $this->json($return);
    }

    // ============================================================ helpers
    private function apply_rules($id)
    {
        $unique_kode  = $id ? 'edit_unique[karyawan.kode.' . $id . ']'  : 'is_unique[karyawan.kode]';
        $unique_email = $id ? 'edit_unique[karyawan.email.' . $id . ']' : 'is_unique[karyawan.email]';
        $pass_rule    = $id ? 'min_length[6]' : 'required|min_length[6]';
        
        $this->form_validation->set_rules('kode', 'Kode', 'trim|required|max_length[20]|' . $unique_kode);
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[100]|' . $unique_email);
        $this->form_validation->set_rules('password', 'Password', $pass_rule);
        $this->form_validation->set_rules('telepon', 'Telepon', 'trim|required|regex_match[/^[0-9+\-\s()]{6,20}$/]');
        $this->form_validation->set_rules('website', 'Website', 'trim|max_length[150]|url_opsional');
        $this->form_validation->set_rules('gaji', 'Gaji', 'trim|required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal lahir', 'trim|required|regex_match[/^\d{4}-\d{2}-\d{2}$/]');
        $this->form_validation->set_rules('jam_masuk', 'Jam masuk', 'trim|required|regex_match[/^\d{2}:\d{2}$/]');
        $this->form_validation->set_rules('tgl_bergabung', 'Tanggal bergabung', 'trim|required|regex_match[/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/]');
        $this->form_validation->set_rules('warna', 'Warna label', 'trim|required|regex_match[/^#[0-9a-fA-F]{6}$/]');
        $this->form_validation->set_rules('level_skill', 'Level skill', 'trim|required|integer|greater_than_equal_to[1]|less_than_equal_to[10]');
        $this->form_validation->set_rules('departemen', 'Departemen', 'trim|required|in_list[' . implode(',', self::DEPARTEMEN) . ']');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis kelamin', 'trim|required|in_list[L,P]');
        $this->form_validation->set_rules('skills[]', 'Skill', 'required');
        $this->form_validation->set_rules('bahasa[]', 'Bahasa', 'trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required|max_length[500]');
        $this->form_validation->set_rules('setuju', 'Persetujuan', 'required', array('required' => 'Anda harus menyetujui kebijakan perusahaan.'));
    }

    private function collect()
    {
        $skills = array_values(array_intersect((array) $this->input->post('skills'), self::SKILLS));
        $bahasa = array_values(array_intersect((array) $this->input->post('bahasa'), self::BAHASA));

        return array(
            'kode'          => $this->input->post('kode', TRUE),
            'nama'          => $this->input->post('nama', TRUE),
            'email'         => $this->input->post('email', TRUE),
            'telepon'       => $this->input->post('telepon', TRUE),
            'website'       => $this->input->post('website', TRUE),
            'gaji'          => (int) $this->input->post('gaji'),
            'tgl_lahir'     => $this->input->post('tgl_lahir'),
            'jam_masuk'     => $this->input->post('jam_masuk') . ':00',
            'tgl_bergabung' => str_replace('T', ' ', $this->input->post('tgl_bergabung')) . ':00',
            'warna'         => strtolower($this->input->post('warna')),
            'level_skill'   => (int) $this->input->post('level_skill'),
            'departemen'    => $this->input->post('departemen'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'skills'        => implode(',', $skills),
            'bahasa'        => implode(',', $bahasa),
            'aktif'         => $this->input->post('aktif') ? 1 : 0,
            'alamat'        => $this->input->post('alamat', TRUE),
        );
    }

    private function handle_upload()
    {
        $result = array('file' => null, 'error' => null);

        if (empty($_FILES['foto']['name'])) {
            return $result;
        }

        $dir = FCPATH . 'uploads/karyawan/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, TRUE);
        }

        $this->load->library('upload', array(
            'upload_path'   => $dir,
            'allowed_types' => 'jpg|jpeg|png',
            'max_size'      => 2048,
            'encrypt_name'  => TRUE,
        ));

        if (!$this->upload->do_upload('foto')) {
            $result['error'] = strip_tags($this->upload->display_errors('', ''));
            return $result;
        }

        $result['file'] = $this->upload->data('file_name');
        return $result;
    }

    private function delete_file($name)
    {
        if ($name) {
            $path = FCPATH . 'uploads/karyawan/' . basename($name);
            if (is_file($path)) {
                @unlink($path);
            }
        }
    }

    private function validation_failed($extra = array())
    {
        $errors = array_merge($this->form_validation->error_array(), $extra);
        return $this->json(array(
            'status'  => false,
            'message' => 'Periksa kembali isian Anda.',
            'errors'  => $errors,
        ), 422);
    }
}

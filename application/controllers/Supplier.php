<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Master Supplier - CRUD dengan halaman terpisah (list, tambah, edit).
 */
class Supplier extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_access('supplier');
        $this->load->model('Supplier_model');
    }

    public function index()
    {
        $data = array(
            'rows' => $this->Supplier_model->all()
        );

        $page_config = array(
            'title'      => 'Master Supplier',
            'page'       => 'supplier',
            'breadcrumb' => array('Master Data', 'Master Supplier'),
            'breadcrumb_links' => array('supplier'),
            'page_data'  => array(
                'success' => $this->session->flashdata('success'),
                'error'   => $this->session->flashdata('error'),
            ),
        );

        $this->render('supplier/index', $data, $page_config);
    }

    public function create()
    {
        $this->form_page(null);
    }

    public function store()
    {
        if ($this->input->method() !== 'post') {
            redirect('supplier');
        }

        $this->apply_rules(0);
        if (!$this->form_validation->run()) {
            return $this->form_page(null, TRUE);
        }

        $this->Supplier_model->insert($this->collect());
        $this->session->set_flashdata('success', 'Data supplier berhasil ditambahkan.');
        redirect('supplier');
    }

    public function edit($id = 0)
    {
        $row = $this->Supplier_model->find($id);
        if (!$row) {
            $this->session->set_flashdata('error', 'Data supplier tidak ditemukan.');
            redirect('supplier');
        }
        $this->form_page($row);
    }

    public function update($id = 0)
    {
        if ($this->input->method() !== 'post') {
            redirect('supplier');
        }

        $row = $this->Supplier_model->find($id);
        if (!$row) {
            $this->session->set_flashdata('error', 'Data supplier tidak ditemukan.');
            redirect('supplier');
        }

        $this->apply_rules((int) $id);
        if (!$this->form_validation->run()) {
            return $this->form_page($row, TRUE);
        }

        $this->Supplier_model->update($id, $this->collect());
        $this->session->set_flashdata('success', 'Data supplier berhasil diperbarui.');
        redirect('supplier');
    }

    public function delete($id = 0)
    {
        if ($this->input->method() !== 'post') {
            return $this->json(array('status' => false, 'message' => 'Metode tidak diizinkan.'), 405);
        }

        if (!$this->Supplier_model->find($id)) {
            return $this->json(array('status' => false, 'message' => 'Data tidak ditemukan.'), 404);
        }

        $this->Supplier_model->delete($id);
        $this->session->set_flashdata('success', 'Data supplier berhasil dihapus.');
        return $this->json(array('status' => true, 'message' => 'Data supplier berhasil dihapus.'));
    }

    // ------------------------------------------------------------ helpers
    private function form_page($row, $has_error = FALSE)
    {
        $is_edit = $row !== null;

        $data = array(
            'row'     => $row,
            'is_edit' => $is_edit,
            'action'  => $is_edit ? site_url('supplier/update/' . $row['id']) : site_url('supplier/store'),
        );

        $page_config = array(
            'title'      => $is_edit ? 'Edit Supplier' : 'Tambah Supplier',
            'page'       => 'supplier',
            'breadcrumb' => array('Master Data', 'Master Supplier', $is_edit ? 'Edit' : 'Tambah'),
            'breadcrumb_links' => array('supplier', 'supplier'),
            'page_data'  => $has_error ? array(
                'swalError'      => 'Periksa kembali isian Anda.',
                'supplierErrors' => $this->form_validation->error_array(),
            ) : array(),
        );

        $this->render('supplier/form', $data, $page_config);
    }

    private function apply_rules($id)
    {
        $unique_kode = $id ? 'edit_unique[supplier.kode.' . $id . ']' : 'is_unique[supplier.kode]';

        $this->form_validation->set_rules('kode', 'Kode', 'trim|required|max_length[20]|' . $unique_kode);
        $this->form_validation->set_rules('nama', 'Nama supplier', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[100]');
        $this->form_validation->set_rules('telepon', 'Telepon', 'trim|required|regex_match[/^[0-9+\-\s()]{6,20}$/]');
        $this->form_validation->set_rules('kota', 'Kota', 'trim|required|max_length[60]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required|max_length[500]');
        $this->form_validation->set_rules('aktif', 'Status', 'trim|required|in_list[0,1]');
    }

    private function collect()
    {
        return array(
            'kode'    => $this->input->post('kode', TRUE),
            'nama'    => $this->input->post('nama', TRUE),
            'email'   => $this->input->post('email', TRUE),
            'telepon' => $this->input->post('telepon', TRUE),
            'kota'    => $this->input->post('kota', TRUE),
            'alamat'  => $this->input->post('alamat', TRUE),
            'aktif'   => (int) $this->input->post('aktif'),
        );
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base controller untuk semua halaman.
 */
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->output->set_header('X-Frame-Options: SAMEORIGIN');
        $this->output->set_header('X-Content-Type-Options: nosniff');
    }

    protected function json($data, $status = 200)
    {
        $this->output
            ->set_status_header($status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data));
    }
}

/**
 * Controller untuk halaman yang wajib login.
 */
class Admin_Controller extends MY_Controller
{
    protected $auth_user = array();

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('user_id')) {
            if ($this->input->is_ajax_request()) {
                $this->json(array('status' => false, 'message' => 'Sesi berakhir, silakan login kembali.'), 401);
                $this->output->_display();
                exit;
            }
            redirect('login');
        }

        $this->auth_user = array(
            'id'    => $this->session->userdata('user_id'),
            'nama'  => $this->session->userdata('user_nama'),
            'email' => $this->session->userdata('user_email'),
        );

        $this->set_validation_messages();
    }

    /**
     * Render halaman di dalam layout TailAdmin.
     *
     * @param string $content   nama view konten, mis. 'karyawan/index'
     * @param array  $data      data untuk view
     * @param array  $opts      title, page, breadcrumb, breadcrumb_links, main_class, page_data
     */
    protected function render($content, $data = array(), $opts = array())
    {
        $opts = array_merge(array(
            'title'            => 'Dashboard',
            'page'             => 'dashboard',
            'breadcrumb'       => array(),
            'breadcrumb_links' => array(),
            'main_class'       => 'p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6',
            'page_data'        => array(),
        ), $opts);

        $view = array_merge($data, $opts);
        $view['content']   = $content;
        $view['auth_user'] = $this->auth_user;

        // $content dimuat di dalam layout, jadi data harus tersedia bagi semua view
        $this->load->vars($view);

        // URL yang sama bisa menghasilkan halaman penuh atau hanya isi (lihat di bawah),
        // jadi cache browser harus membedakannya.
        $this->output->set_header('Vary: X-Partial');

        // Pindah menu tanpa memuat ulang halaman (static/js/menu-nav.js mengirim header
        // "X-Partial: 1"): kirim hanya breadcrumb + isi halaman, tanpa sidebar, header, dan aset.
        // Data pendukung (judul, menu aktif, class pembungkus, data grafik) dikirim lewat header.
        if ($this->input->get_request_header('X-Partial') === '1') {
            $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
            $this->output->set_header('X-Page-Key: ' . $opts['page']);
            $this->output->set_header('X-Page-Title: ' . rawurlencode($opts['title'] . ' | Master Backend'));
            $this->output->set_header('X-Main-Class: ' . rawurlencode($opts['main_class']));
            $this->output->set_header('X-Page-Data: ' . rawurlencode(json_encode($opts['page_data'])));
            $this->load->view('layouts/page', $view);
            return;
        }

        $this->load->view('layouts/main', $view);
    }

    protected function set_validation_messages()
    {
        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('valid_email', '{field} harus berupa email yang valid.');
        $this->form_validation->set_message('is_unique', '{field} sudah digunakan.');
        $this->form_validation->set_message('edit_unique', '{field} sudah digunakan.');
        $this->form_validation->set_message('max_length', '{field} maksimal {param} karakter.');
        $this->form_validation->set_message('min_length', '{field} minimal {param} karakter.');
        $this->form_validation->set_message('numeric', '{field} harus berupa angka.');
        $this->form_validation->set_message('integer', '{field} harus berupa bilangan bulat.');
        $this->form_validation->set_message('in_list', '{field} tidak valid.');
        $this->form_validation->set_message('regex_match', 'Format {field} tidak valid.');
        $this->form_validation->set_message('url_opsional', 'Format {field} tidak valid (gunakan http:// atau https://).');
        $this->form_validation->set_message('greater_than_equal_to', '{field} minimal {param}.');
        $this->form_validation->set_message('less_than_equal_to', '{field} maksimal {param}.');
    }
}

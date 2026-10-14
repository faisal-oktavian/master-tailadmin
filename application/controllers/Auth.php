<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index()
    {
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }
        $this->load->view('auth/login', array('old_email' => $this->session->flashdata('old_email')));
    }

    public function process()
    {
        if ($this->input->method() !== 'post') {
            redirect('login');
        }

        $email    = trim((string) $this->input->post('email', TRUE));
        $password = (string) $this->input->post('password');

        $user = $this->User_model->get_by_email($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->session->set_flashdata('login_error', 'Email atau password salah.');
            $this->session->set_flashdata('old_email', $email);
            redirect('login');
        }

        $this->session->sess_regenerate(TRUE);
        $this->session->set_userdata(array(
            'user_id'    => $user['id'],
            'user_nama'  => $user['nama'],
            'user_email' => $user['email'],
        ));

        redirect('dashboard');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}

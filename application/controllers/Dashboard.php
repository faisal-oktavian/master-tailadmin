<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Karyawan_model', 'Supplier_model'));
    }

    public function index()
    {
        $k = $this->Karyawan_model->stats();
        $s = $this->Supplier_model->stats();

        $stat = array(
            'karyawan_total' => $k['total'],
            'karyawan_aktif' => $k['aktif'],
            'supplier_total' => $s['total'],
            'supplier_aktif' => $s['aktif'],
        );

        $year = (int) date('Y');

        $this->render('dashboard/index', array(
            'stat'   => $stat,
            'recent' => $this->Karyawan_model->recent(5),
        ), array(
            'title'      => 'Dashboard',
            'page'       => 'dashboard',
            'main_class' => 'mx-auto max-w-(--breakpoint-2xl) p-4 pb-20 md:p-6 md:pb-6',
            'page_data'  => array(
                'dashboard' => array(
                    'year'         => $year,
                    'joined'       => $this->Karyawan_model->joined_per_month($year),
                    'activePercent'=> $stat['karyawan_total'] > 0
                        ? round($stat['karyawan_aktif'] / $stat['karyawan_total'] * 100, 2)
                        : 0,
                ),
            ),
        ));
    }
}

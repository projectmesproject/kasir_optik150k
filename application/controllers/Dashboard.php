<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('M_customer');
        $this->load->model('M_user');
        $this->load->model('M_barang');
        $this->load->model('M_Cara_Bayar');
    }


    function index()
    {
        $data['title'] = "Dashboard";
        $cara_bayar = $this->M_Cara_Bayar->list();
        $barang = $this->M_barang->getBarang();
        $customer = $this->M_customer->tampil_customer()->result_array();
        $user = $this->M_user->tampil_user()->result_array();
        $data['count_user']  = count($user);
        $data['count_customer']  = count($customer);
        $data['count_barang']  = count($barang);
        $data['count_cara_bayar']  = count($cara_bayar);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('template/footer', $data);
    }
}

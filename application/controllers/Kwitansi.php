<?php
class Kwitansi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('m_kwitansi');
    }

    function index()
    {

        $data['title'] = 'Kwitansi';
        $data['data'] = $this->m_kwitansi->tampil_kwitansi()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('kwitansi/index', $data);
        $this->load->view('template/footer', $data);
    }

    function tambah_kwitansi()
    {
        $this->m_kwitansi->tambah_kwitansi();
        $this->session->set_flashdata('msg', 'Data berhasil ditambahkan');
        redirect('kwitansi');
    }

    function cetak_kwitansi($kwitansi, $versi)
    {
        // $x['data'] = $this->m_kwitansi->cetak_faktur2($nofak);
        $x['data'] = $kwitansi;
        $x['versi'] = $versi;
        $this->load->view('kwitansi/cetak_faktur', $x);
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Suplier extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

    //$this->load->model('m_kategori');
    $this->load->model('m_suplier');
    ///$this->load->library('barcode');
  }

  public function index()
  {
    $data['title'] = 'Suplier';
    $data['data'] = $this->m_suplier->tampil_suplier();
    $this->load->view('template/header', $data);
    $this->load->view('template/sidebar', $data);
    $this->load->view('template/topbar', $data);
    $this->load->view('suplier/index', $data);
    $this->load->view('template/footer', $data);
  }

  public function tambah_suplier()
  {
    $this->m_suplier->tambah_suplier();
    $this->session->set_flashdata('msg', 'Berhasil');
    redirect('suplier');
  }

  public function edit_suplier()
  {
    $data = array(

      "suplier_nama" => $_POST['sup_nama'],
      "suplier_alamat" => $_POST['sup_alamat'],
      "suplier_notelp" => $_POST['sup_tlp']
    );

    $this->db->where('suplier_id', $_POST['sup_id']);
    $this->db->update('tbl_suplier', $data);
    $this->session->set_flashdata('msg', 'Berhasil');
    redirect('suplier');
  }

  public function hapus_suplier()
  {
    $id = $this->input->post('sup_id');
    $this->m_suplier->hapus_suplier($id);
    $this->session->set_flashdata('msg', 'Berhasil');
    redirect('suplier');
  }
  public function listSupplier_pembelian()
  {
    $start = $this->input->post('start');
    $end = $this->input->post('end');
    $res = $this->m_supplier->listSupplier_pembelian($start, $end);
    echo json_encode($res);
  }
}

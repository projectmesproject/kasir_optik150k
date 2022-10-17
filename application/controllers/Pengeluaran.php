<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengeluaran extends CI_Controller {

    function __construct(){
		parent::__construct();
         $this->load->model('M_pengeluaran');  
    }
    
    function index(){
        $data['title']="Data Pengeluaran Toko"; 
        
        $this->load->model('M_karyawan');
        $data['karyawan'] = $this->M_karyawan->tampil_karyawan();

        $data['data'] = $this->M_pengeluaran->tampilData();
        $data['jenis_pengeluaran'] = ['Listrik','Uang Makan','Gaji Karyawan','Lain-Lain'];

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('template/topbar',$data);
        $this->load->view('pengeluaran/index',$data);
        $this->load->view('template/footer',$data);
    }

    function tambah_data(){
      $this->M_pengeluaran->tambahData();
      $this->session->set_flashdata('msg','Data berhasil ditambahkan');
      redirect('pengeluaran');
    }

    function edit_data(){
      $this->M_pengeluaran->editData();
      $this->session->set_flashdata('msg','Data berhasil diubah');
      redirect('pengeluaran');
    }

    function hapus_data(){
      $id=$this->input->post('id');
      $this->M_pengeluaran->hapusData($id);
      $this->session->set_flashdata('msg','Data berhasil dihapus');
      redirect('pengeluaran');
    }

}
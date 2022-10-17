<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman_barang extends CI_Controller {

    function __construct(){
        parent::__construct();
        
        $this->load->model('M_peminjaman_barang');
        $this->load->model('M_karyawan');
        $this->load->model('M_barang');
    }
    
    function index(){
        $data['title']='Peminjaman Barang';

        $data['data'] = $this->M_peminjaman_barang->tampil_data();

        $data['karyawan'] = $this->M_karyawan->tampil_karyawan();
        $data['barang'] = $this->M_barang->tampil_barang();
 
        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('template/topbar',$data);
        $this->load->view('peminjaman_barang/index',$data);
        $this->load->view('template/footer',$data);
    }

    function tambah_data(){
        $this->M_peminjaman_barang->tambahData();
		$this->session->set_flashdata('msg','Data berhasil ditambahkan');
		redirect('peminjaman_barang');
    }

    function hapus_data(){
        $id=$this->input->post('id');
        $this->M_peminjaman_barang->hapusData($id);
        $this->session->set_flashdata('msg','Data berhasil dihapus');
        redirect('peminjaman_barang');	
    }
    
    function editData(){
		$this->M_peminjaman_barang->editData();
		$this->session->set_flashdata('msg','Data berhasil diubah');
		redirect('peminjaman_barang');	
	}

}
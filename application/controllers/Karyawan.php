<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller {


    function __construct(){
		parent::__construct();
		
		$this->load->model('m_karyawan');
		///$this->load->library('barcode');
	}

    public function index()
    {
        $data['title']='Karyawan';
        $data['data']=$this->m_karyawan->tampil_karyawan();
        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('template/topbar',$data);
        $this->load->view('karyawan/index',$data);
        $this->load->view('template/footer',$data);
    }

	public function tambah_karyawan()
	{
		$this->m_karyawan->tambah_karyawan();
		$this->session->set_flashdata('msg','Berhasil');
		redirect('karyawan');
	}

	public function edit_karyawan()
	{
		$data=array(
			
            "nama" => $_POST['nama'],
            "tempat_lahir" => $_POST['tempat'], 
            "tanggal_lahir" => $_POST['tgl'],
            "alamat" => $_POST['alamat'],
            "tanggal_masuk" => $_POST['tgl_masuk'],
            

		);

		$this->db->where('id',$_POST['id']);
		$this->db->update('karyawan',$data);
		$this->session->set_flashdata('msg',"Berhasil");
		redirect('karyawan');
	}

	public function hapus_karyawan()
	{
		$id=$this->input->post('id');
		$this->m_karyawan->hapus_karyawan($id);
		$this->session->set_flashdata('msg',"Berhasil");
		redirect('karyawan');
	}

}
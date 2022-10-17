<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {


    function __construct(){
		parent::__construct();
		
		$this->load->model('m_kategori');
		///$this->load->library('barcode');
	}

    public function index()
    {
        $data['title']='Kategori Barang';
        $data['data']=$this->m_kategori->tampil_kategori();
        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('template/topbar',$data);
        $this->load->view('kategori/index',$data);
        $this->load->view('template/footer',$data);
    }

	public function tambah_kategori()
	{
		$this->m_kategori->tambah_kategori();
		$this->session->set_flashdata('msg','Berhasil');
		redirect('kategori');
	}

	public function edit_kategori()
	{
		$data=array(
			
			"kategori_nama" => $_POST['kategori']
		);

		$this->db->where('kategori_id',$_POST['kategori_id']);
		$this->db->update('tbl_kategori',$data);
		$this->session->set_flashdata('msg',"Berhasil");
		redirect('kategori');
	}

	public function hapus_kategori()
	{
		$id=$this->input->post('kategori_id');
		$this->m_kategori->hapus_kategori($id);
		$this->session->set_flashdata('msg',"Berhasil");
		redirect('kategori');
	}

}
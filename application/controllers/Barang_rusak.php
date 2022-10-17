<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_rusak extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 * 
	 * 
	 */

	function __construct(){
		parent::__construct();
		
		$this->load->model('m_kategori');
        $this->load->model('m_barang');
        $this->load->model('m_barang_rusak');
		///$this->load->library('barcode');
	}

	public function index()
	{
		/*if($this->session->userdata('akses')=='1'){


		}else{
			echo "Halaman tidak ditemukan";
		} */

		$data['title']="Barang Rusak";
		$data['data']=$this->m_barang_rusak->tampil_barang();
		
		$data['kat']=$this->m_barang->tampil_barang();
		$this->load->view('template/header',$data);
		$this->load->view('template/sidebar',$data);
		$this->load->view('template/topbar',$data);
		$this->load->view('barang_rusak/index',$data);
		$this->load->view('template/footer',$data);
	}


		function tambah_barang()
		{
			$this->m_barang_rusak->tambah_barang();
			$this->session->set_flashdata('msg','Berhasil');
			redirect('barang_rusak');
	
		}

		public function edit_barang()
		{

			$this->m_barang_rusak->edit_barang();
			$this->session->set_flashdata('msg','Berhasil');
			redirect('barang_rusak');
			
		}


	function hapus_barang()
	{
			$id=$this->input->post('id');
			$this->m_barang_rusak->hapus_barang($id);
			$this->session->set_flashdata('msg','Berhasil');
			redirect('barang_rusak');
		
	}


}

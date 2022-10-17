<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {


	function __construct(){
		parent::__construct();
		
	}

	public function index()
	{
	
	
	}

	public function getDataBarang(){
		$this->db->select('barang_nama as label, CONCAT(barang_harjul, "#", barang_id, "#", barang_satuan, "#", barang_stok) as value');
		$this->db->from('tbl_barang');
		$this->db->like('barang_nama', $this->input->post("search"));
		$dt = $this->db->get()->result_array();
		
		  foreach($dt as $v ){
				$response[] = array("value"=>$v['value'],"label"=>$v['label']);
			}



		echo json_encode($response);
	}


	public function getDataCustomer(){
		$this->db->select('barang_nama as label, CONCAT(barang_harjul, "#", barang_id, "#", barang_satuan, "#", barang_stok) as value');
		$this->db->from('tbl_barang');
		$this->db->like('barang_nama', $this->input->post("search"));
		$dt = $this->db->get()->result_array();
		
		  foreach($dt as $v ){
				$response[] = array("value"=>$v['value'],"label"=>$v['label']);
			}



		echo json_encode($response);
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History_pembelian extends CI_Controller {

    function __construct(){
        parent::__construct();
        

        if($this->session->userdata('level') != TRUE){
          redirect(base_url());
        }
    }

    function index(){
        $data['title']="Data History Pembelian";

        $data['data'] = $this->db->query("select * from tbl_beli")->result_array();

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('template/topbar',$data);
        $this->load->view('history_pembelian/index',$data);
        $this->load->view('template/footer',$data);
    }

    function in_detail($id){
        $data['title']="Detail Pembelian";

        $data['data'] = $this->db->query("select a.beli_tanggal, a.beli_nofak, b.suplier_nama from tbl_beli a left join tbl_suplier b
                                             on a.beli_suplier_id=b.suplier_id")->row_array();

        $data['barang'] = $this->db->query("select a.d_beli_harga, a.d_beli_jumlah, a.d_beli_total, b.barang_nama from tbl_detail_beli a 
                                                    left join tbl_barang b on a.d_beli_barang_id=b.barang_id where a.d_beli_nofak='$id'")->result_array();

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('template/topbar',$data);
        $this->load->view('history_pembelian/detail_pembelian',$data);
        $this->load->view('template/footer',$data);
    }


}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jual_dp extends CI_Controller {

    function __construct(){
        parent::__construct();
        
        $this->load->model('M_dp');

        if($this->session->userdata('level') != TRUE){
          redirect(base_url());
        }
    }

    function index(){
        $data['title']="Data DP";

        $data['data'] = $this->db->query("select * from tbl_jual_dp where is_status=0 order by jual_nofak desc")->result_array();

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('template/topbar',$data);
        $this->load->view('jual_dp/index',$data);
        $this->load->view('template/footer',$data);
    }

    function in_detail($id){
        $data['title']="Detail Penjualan";

        $jual = $this->db->query("select * from tbl_jual_dp where jual_nofak='$id'")->row_array();
        $no_hp = $jual['no_hp'];
        $data['jual'] = $this->db->query("select * from tbl_jual_dp where jual_nofak='$id'")->row_array();
        

        $data['customer'] = $this->db->query("select * from tbl_customer where no_hp='$no_hp'")->row_array();
        $data['dt_jual'] = $this->db->query("select * from tbl_detail_jual_dp where d_jual_nofak='$id' order by d_jual_id desc")->result_array();

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('template/topbar',$data);
        $this->load->view('jual_dp/detail_penjualan',$data);
        $this->load->view('template/footer',$data);
    }

    function bayar(){
        $nofak = $this->input->post('nofak',TRUE);
        $uang = $this->input->post('bayar',TRUE);

        $jual = $this->db->query("select * from tbl_jual_dp where jual_nofak='$nofak'")->row_array();
        $no_hp = $jual['no_hp'];
        $data['jual'] = $this->db->query("select * from tbl_jual_dp where jual_nofak='$nofak'")->row_array();

        $data['customer'] = $this->db->query("select * from tbl_customer where no_hp='$no_hp'")->row_array();
        $data['dt_jual'] = $this->db->query("select * from tbl_detail_jual_dp where d_jual_nofak='$nofak' order by d_jual_id desc")->result_array();

        $u = abs($jual['jual_kembalian']);

        // ambil jual_detail
        $jt = $this->db->query("select * from tbl_detail_jual_dp where d_jual_nofak='$nofak'")->result_array();

        if($uang<$u){

            $this->session->set_flashdata('msg2','Data gagal ditambahkan! uang anda kurang');

            $data['title']="Detail Penjualan";
            
            $this->load->view('template/header',$data);
            $this->load->view('template/sidebar',$data);
            $this->load->view('template/topbar',$data);
            $this->load->view('jual_dp/detail_penjualan',$data);
            $this->load->view('template/footer',$data);
        }
        else{
            $this->load->model('M_penjualan');

            $t_nofak = $nofak=$this->M_penjualan->get_nofak();
            $t_jt = $jual['jual_tanggal'];
            $t_jtot = $jual['jual_total'];
            $t_jud = $jual['jual_user_id'];
            $t_jk = 'Lunas';
            $t_d = $jual['diskon'];

            $this->M_dp->simpan_penjualan($t_nofak,$t_jt,$t_jtot, $t_jud, $t_jk,$t_d,$no_hp);

            $no1 = 0;
            $no2 = 0;

            foreach($jt as $a){

                $t_id = $a['d_jual_id'];
                $t1 = $a['jual_nofak'];
                $t2 = $a['d_jual_barang_id'];
                $t3 = $a['d_jual_barang_nama'];
                $t4 = $a['d_jual_barang_satuan'];
                $t5 = $a['d_jual_barang_harpok'];
                $t6 = $a['d_jual_barang_harjul'];
                $t7 = $a['d_jual_qty'];
                $t8 = $a['d_jual_diskon'];
                $t9 = $a['d_jual_total'];
                $t10 = $a['d_jual_barang_kat_id'];

                $data = [
                    "d_jual_nofak" => $t_nofak,
                    "d_jual_barang_id" => $t2,
                    "d_jual_barang_kat_id" => $t10,
                    "d_jual_barang_nama" => $t3,
                    "d_jual_barang_satuan" => $t4,
                    "d_jual_barang_harpok" => $t5,
                    "d_jual_barang_harjul" => $t6,
                    "d_jual_qty" => $t7,
                    "d_jual_diskon" => $t8,
                    "d_jual_total" => $t9
                ];

                $this->db->insert('tbl_detail_jual',$data);
            }

            $l = $jual['jual_nofak'];
            $this->db->query("update tbl_jual_dp set is_status=1 where jual_nofak='$l'");

            $saldo = $uang-$u;
            $this->db->query("update saldo set saldo=saldo+'$uang' where id=1");
            $this->db->query("update saldo set saldo=saldo-'$saldo' where id=1");

            $this->session->set_flashdata('msg','Data berhasil ditambahkan');
            redirect('history_penjualan');
        }
    }

}
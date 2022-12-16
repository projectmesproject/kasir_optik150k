<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Cabang extends CI_Controller
{


    function __construct()
    {
        parent::__construct();

        $this->load->model('m_cabang');
    }

    public function index()
    {
        $data['title'] = "Master Data Cabang";
        $data['data'] = $this->m_cabang->tampil_cabang();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('cabang/index', $data);
        $this->load->view('template/footer', $data);
    }


    public function tambah_cabang(){
        $this->m_cabang->tambah_cabang();
		$this->session->set_flashdata('msg_cbg','Data Cabang berhasil ditambah');
        redirect("cabang");
    }

    public function edit_cabang(){
        $this->m_cabang->edit_cabang();
		$this->session->set_flashdata('msg_cbg','Data Cabang berhasil diubah');
        redirect("cabang");
    }


    public function hapus_cabang($id)
    {
        $cabang = $this->m_cabang->hapus_cabang1($id);
        $res = new stdClass();
        if ($cabang == 0) {
            $res->status = 400;
            $res->message = "Cabang Tidak dapat dihapus karena masih ada transaksi";
        } else {

            $res->status = 200;
            $res->message = "Berhasil Hapus Cabang";
            $this->db->delete('tbl_cabang', ['id_Cabang' => $id]);
        }

        echo json_encode($res);
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_customer extends CI_Model
{
    function tampilData()
    {
        // return $this->db->query("select * from tbl_customer order by id DESC")->result_array();
        return $this->db->select('id,kd_customer,nama,no_hp,alamat')->from('tbl_customer')->order_by('id', 'DESC')->get()->result_array();
    }

    function tampil_customer()
    {
        return $this->db->get('tbl_customer');
    }

    function tambah_data()
    {
        $data = array(
            "kd_customer" => $this->input->post('kd_customer'),
            "nama" => $this->input->post('nama'),
            "no_hp" => $this->input->post('no_hp'),
            "alamat" => $this->input->post('alamat')
        );

        $this->db->insert('tbl_customer', $data);
    }

    ///baruu
    function search_customer($noHp)
    {
        $this->db->like('no_hp', $noHp, 'both');
        $this->db->order_by('no_hp', 'ASC');
        $this->db->limit(10);
        return $this->db->get('tbl_customer')->result();
    }

    public function get_customer($noHp)
    {
        $hsl = $this->db->query("SELECT * FROM tbl_customer where no_hp='$noHp'");
        return $hsl;
    }
    public function getId($id)
    {
        return  $this->db->select('*')->from('tbl_customer')->where('id', $id)->get()->row();
    }

    public function getKodeCustomer()
    {
        $q = $this->db->query("select MAX(RIGHT(kd_customer,6)) as kd_cus from tbl_customer");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->kd_cus) + 1;
                $kd = sprintf("%06s", $tmp);
            }
        } else {
            $kd = "000001";
        }
        return "C-" . $kd;
    }

    public function hapus_customer($id)
    {
        $this->db->delete('tbl_customer', ['id' => $id]);
    }

    public function listCustomer($start, $end)
    {
        $this->db->select('*');
        $this->db->from('tbl_jual');
        $this->db->where('DATE(jual_tanggal) >=', date('Y-m-d', strtotime($start)));
        $this->db->where('DATE(jual_tanggal) <=', date('Y-m-d', strtotime($end)));
        $this->db->join('tbl_detail_jual', 'tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak');
        $this->db->join('tbl_barang', 'tbl_detail_jual.d_jual_barang_id=tbl_barang.barang_id');
        $this->db->join('tbl_customer', 'tbl_jual.no_hp=tbl_customer.no_hp');
        $this->db->group_by('tbl_customer.no_hp');
        // ->join('tbl_kategori', 'tbl_detail_jual.d_jual_barang_kat_id=tbl_kategori.kategori_id')
        $res = $this->db->get()->result();
        return $res;
    }
    public function listCustomer_dp($start, $end)
    {
        $this->db->select('*');
        $this->db->from('tbl_jual');
        $this->db->where('status', "DP");
        $this->db->where('DATE(jual_tanggal) >=', date('Y-m-d', strtotime($start)));
        $this->db->where('DATE(jual_tanggal) <=', date('Y-m-d', strtotime($end)));
        $this->db->join('tbl_detail_jual', 'tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak');
        $this->db->join('tbl_barang', 'tbl_detail_jual.d_jual_barang_id=tbl_barang.barang_id');
        $this->db->join('tbl_customer', 'tbl_jual.no_hp=tbl_customer.no_hp');
        $this->db->group_by('tbl_customer.no_hp');
        $res = $this->db->get()->result();
        return $res;
    }
    public function dariNama($id)
    {
        return $this->db->select('*')->from('tbl_customer')->where('no_hp', $id)->get()->row();
    }
    public function listCustomer_barang($start, $end, $no_hp)
    {
        $this->db->select('*');
        $this->db->from('tbl_jual');
        $this->db->where('DATE(jual_tanggal) >=', date('Y-m-d', strtotime($start)));
        $this->db->where('DATE(jual_tanggal) <=', date('Y-m-d', strtotime($end)));
        $this->db->where('tbl_jual.no_hp', $no_hp);
        $this->db->join('tbl_detail_jual', 'tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak');
        $this->db->join('tbl_barang', 'tbl_detail_jual.d_jual_barang_id=tbl_barang.barang_id');
        $this->db->join('tbl_customer', 'tbl_jual.no_hp=tbl_customer.no_hp');
        $this->db->group_by('tbl_barang.barang_id');
        // ->join('tbl_kategori', 'tbl_detail_jual.d_jual_barang_kat_id=tbl_kategori.kategori_id')
        $res = $this->db->get()->result();
        return $res;
    }
}

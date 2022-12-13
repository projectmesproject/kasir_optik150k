<?php
class M_customer extends CI_Model
{

    function tampilData()
    {
        return $this->db->query("select * from tbl_customer order by id DESC")->result_array();
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
        $this->db->where('jual_tanggal >=', date('Y-m-d', strtotime($start)));
        $this->db->where('jual_tanggal <=', date('Y-m-d', strtotime($end)));
        $this->db->join('tbl_customer', 'tbl_jual.no_hp=tbl_customer.no_hp');
        $this->db->group_by('tbl_customer.no_hp');
        // ->join('tbl_kategori', 'tbl_detail_jual.d_jual_barang_kat_id=tbl_kategori.kategori_id')
        $res = $this->db->get()->result();
        return $res;
    }
    public function dariNama($id)
    {
        return $this->db->select('*')->from('tbl_customer')->where('no_hp', $id)->get()->row();
    }
}

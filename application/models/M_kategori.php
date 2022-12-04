<?php
class M_kategori extends CI_Model
{
    public function tampil_kategori()
    {
        return $this->db->get('tbl_kategori');
    }

    public function tambah_kategori()
    {
        $data = array(

            "kategori_nama" => $this->input->post('kategori')

        );

        $this->db->insert('tbl_kategori', $data);
    }

    public function hapus_kategori($id)
    {
        $this->db->delete('tbl_kategori', ['kategori_id' => $id]);
    }
    public function getKategori()
    {
        $this->db->select('*')->from('tbl_kategori');
        $query = $this->db->get();
        $return = $query->result();
        return $return;
    }
    public function listKategori($start, $end)
    {
        $res = $this->db->select('*')->from('tbl_jual')->where('jual_tanggal <=', $start)->where('jual_tanggal >=', $end)
            ->join('tbl_detail_jual', 'tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak')
            ->join('tbl_kategori', 'tbl_detail_jual.d_jual_barang_kat_id=tbl_kategori.kategori_id')
            ->get()->result_array();
        return $res;
    }
}

<?php
class M_suplier extends CI_Model
{

    public function tampil_suplier()
    {
        return $this->db->get('tbl_suplier');
    }

    public function tambah_suplier()
    {
        $data = array(

            "suplier_nama" => $this->input->post('sup_nama'),
            "suplier_alamat" => $this->input->post('sup_alamat'),
            "suplier_notelp" => $this->input->post('sup_tlp')
        );

        $this->db->insert('tbl_suplier', $data);
    }

    public function hapus_suplier($id)
    {
        $this->db->delete('tbl_suplier', ['suplier_id' => $id]);
    }
}

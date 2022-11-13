<?php
class M_kwitansi extends CI_Model
{
   public function tampil_kwitansi()
   {
       return $this->db->get('tbl_kwitansi');
   }

   public function tambah_kwitansi()
   {
       $data=array(
           
        "kode_kwitansi" => "Tes",
        "nominal" => $this->input->post('nominal'),
        "harga_jual" => $this->input->post('harga'),
        "karyawan" => $this->input->post('karyawan'),
        "date_created" => date('Y-m-d H:i:s'),
           
       );

       $this->db->insert('tbl_kwitansi',$data);

   }

   public function hapus_kwitansi($id)
   {
        $this->db->delete('kwitansi',['id_kwitansi' => $id]);
   }

}

    
<?php
class M_karyawan extends CI_Model
{
   public function tampil_karyawan()
   {
       return $this->db->get('karyawan');
   }

   public function tambah_karyawan()
   {
       $data=array(
           
        "nama" => $this->input->post('nama'),
        "tempat_lahir" => $this->input->post('tempat'),
        "tanggal_lahir" => $this->input->post('tgl'),
        "alamat" => $this->input->post('alamat'),
        "tanggal_masuk" => $this->input->post('tgl_masuk'),
           
       );

       $this->db->insert('karyawan',$data);

   }

   public function hapus_karyawan($id)
   {
        $this->db->delete('karyawan',['id' => $id]);
   }

}

    
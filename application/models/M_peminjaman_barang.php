<?php
class M_peminjaman_barang extends CI_Model
{

   function tampil_data(){
       return $this->db->query("select a.id, a.tanggal, a.jumlah, a.id_barang,id_karyawan, a.keterangan, a.tanggal_kembali, b.barang_nama, c.nama from peminjaman_barang a
                                    left join tbl_barang b on a.id_barang=b.barang_id 
                                    left join karyawan c on a.id_karyawan=c.id order by a.id desc")->result_array();
   }


   function tambahData(){
    $id = $this->input->post('barang',TRUE);
    $jmlh = $this->input->post('jumlah',TRUE);

       $data = [
           "id_karyawan" => $this->input->post('karyawan',TRUE),
           "id_barang" => $this->input->post('barang',TRUE),
           "tanggal" => $this->input->post('tanggal',TRUE),
           "jumlah" => $this->input->post('jumlah',TRUE),
           "keterangan" => $this->input->post('keterangan',TRUE),
       ];

       $this->db->insert('peminjaman_barang',$data);
       $this->db->query("update tbl_barang set barang_stok=barang_stok-'$jmlh' where barang_id='$id'");
   }
   
   function hapusData($id){
        $tampung = $this->db->query("select * from peminjaman_barang where id='$id'")->row_array();
        $angka = $tampung['jumlah'];
        $id_barang=$tampung['id_barang'];

        $this->db->delete('peminjaman_barang',['id' => $id]);
        $this->db->query("update tbl_barang set barang_stok=barang_stok+'$angka' where barang_id='$id_barang'");
   }

   function editData(){

    $id_barang_pinjam =$this->input->post('id',TRUE);
    $jml = $this->input->post('jumlah',TRUE);
    $id_barang=$this->input->post('barang');

        $data = [
            "id_karyawan" => $this->input->post('karyawan',TRUE),
            "id_barang" => $this->input->post('barang',TRUE),
            "tanggal" => $this->input->post('tanggal',TRUE),
            "jumlah" => $this->input->post('jumlah',TRUE),
            "keterangan" => $this->input->post('keterangan',TRUE),
        ];

        $tampung = $this->db->query("select * from peminjaman_barang where id='$id_barang_pinjam'")->row_array();

        $this->db->where('id', $_POST['id']);
        $this->db->update('peminjaman_barang',$data);

        
        $t = $tampung['jumlah'];
        
        if($t>$jml){
            $angka = $t-$jml;
            $this->db->query("update tbl_barang set barang_stok=barang_stok+'$angka'where barang_id='$id_barang'");
        }
        else if($t<$jml){
            $angka = $jml - $t;
            $this->db->query("update tbl_barang set barang_stok=barang_stok-'$angka' where barang_id='$id_barang'");
        }
    }

}

    
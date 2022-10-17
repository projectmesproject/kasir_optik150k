<?php
class M_dp extends CI_Model{

    function simpan_penjualan($t_nofak, $t_jt, $t_jtot, $t_jud, $t_jk, $t_d,$nope){
        $data = [
            "jual_nofak" => $t_nofak,
            "jual_tanggal" => $t_jt,
            "jual_total" => $t_jtot,
            "jual_jml_uang" => $t_jtot,
            "jual_kembalian" => 0,
            "jual_user_id" => $t_jud,
            "jual_keterangan" => $t_jk,
            "diskon" => $t_d,
            "no_hp" => $nope
        ];

        $this->db->insert('tbl_jual',$data);
    }

    function cetak_faktur($nofak){
		$hsl=$this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal,jual_total,jual_jml_uang,jual_kembalian,jual_keterangan,diskon,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE jual_nofak='$nofak'");
		return $hsl;
	}
}
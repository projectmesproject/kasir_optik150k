<?php
class M_penjualan extends CI_Model
{


	function simpan_penjualan($nofak, $total, $jml_uang,$kurang, $kembalian, $bayar,$bayar2, $diskon, $nohp,$status)
	{
		$idadmin = $this->session->userdata('idadmin');
		$this->db->query("INSERT INTO tbl_jual (jual_nofak,jual_total,jual_jml_uang,jual_kurang_uang,jual_kembalian,jual_user_id,jual_keterangan,jual_keterangan2,diskon,no_hp,status) VALUES ('$nofak','$total','$jml_uang','$kurang','$kembalian','$idadmin','$bayar','$bayar2','$diskon','$nohp','$status')");
		foreach ($this->cart->contents() as $item) {
			$data = array(
				'd_jual_nofak' 			=>	$nofak,
				'd_jual_barang_id'		=>	$item['id'],
				'd_jual_barang_kat_id'  =>  $item['id_kat_barang'],
				'd_jual_barang_nama'	=>	$item['name'],
				'd_jual_barang_satuan'	=>	$item['satuan'],
				'd_jual_barang_harpok'	=>	$item['harpok'],
				'd_jual_barang_harjul'	=>	$item['amount'],
				'd_jual_qty'			=>	$item['qty'],
				'd_jual_diskon'			=>	$item['disc'],
				'd_jual_total'			=>	$item['subtotal']
			);
			$this->db->insert('tbl_detail_jual', $data);
			$this->db->query("update tbl_barang set barang_stok=barang_stok-'$item[qty]' where barang_id='$item[id]'");
			$this->db->query("update saldo set saldo=saldo+'$jml_uang' where id=1");
			$this->db->query("update saldo set saldo=saldo-'$kembalian' where id=1");
		}
		return true;
	}


	function simpan_penjualan1($nofak, $total, $jml_uang, $kembalian, $diskon, $nohp, $dp)
	{
		$idadmin = $this->session->userdata('idadmin');
		$this->db->query("INSERT INTO tbl_jual_dp (jual_nofak,jual_total,jual_jml_uang,jual_kembalian,jual_user_id,jual_keterangan,diskon,no_hp,uang_muka,is_status) VALUES ('$nofak','$total','$jml_uang','$kembalian','$idadmin','buah','$diskon','$nohp','$dp',0)");
		foreach ($this->cart->contents() as $item) {
			$data = array(
				'd_jual_nofak' 			=>	$nofak,
				'd_jual_barang_id'		=>	$item['id'],
				'd_jual_barang_kat_id'  =>  $item['id_kat_barang'],
				'd_jual_barang_nama'	=>	$item['name'],
				'd_jual_barang_satuan'	=>	$item['satuan'],
				'd_jual_barang_harpok'	=>	$item['harpok'],
				'd_jual_barang_harjul'	=>	$item['amount'],
				'd_jual_qty'			=>	$item['qty'],
				'd_jual_diskon'			=>	$item['disc'],
				'd_jual_total'			=>	$item['subtotal']
			);
			$this->db->insert('tbl_detail_jual_dp', $data);
			$this->db->query("update tbl_barang set barang_stok=barang_stok-'$item[qty]' where barang_id='$item[id]'");
		}
		return true;
	}

	function get_nofak()
	{
		$now = date('Y-m-d');
		$q = $this->db->query("SELECT jual_nofak FROM tbl_jual WHERE DATE(jual_tanggal) ='$now'");
		$kd = "";
		$kd = $q->num_rows();
		$kd+=1;
		$kd= sprintf("%06d",$kd);
		// if ($q->num_rows() > 0) {
		// 	foreach ($q->result() as $k) {
		// 		$tmp = ((int)$k->kd_max) + 1;
		// 		$kd = sprintf("%06s", $tmp);
		// 	}
		// } else {
		// 	$kd = "000001";
		// }
		return date("dmY") . "" . $kd;
	}

	function get_nofak1()
	{
		$q = $this->db->query("SELECT MAX(RIGHT(jual_nofak,6)) AS kd_max FROM tbl_jual_dp ");
		$kd = "";
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $k) {
				$tmp = ((int)$k->kd_max) + 1;
				$kd = sprintf("%06s", $tmp);
			}
		} else {
			$kd = "000001";
		}
		return "DP-" . $kd;
	}


	function cetak_faktur()
	{
		$nofak = $this->session->userdata('nofak');
		$hsl = $this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal,jual_total,jual_jml_uang,jual_kembalian,jual_keterangan,diskon,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,no_hp FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE jual_nofak='$nofak'");
		//die($this->db->last_query());
		return $hsl;
	}

	function cetak_faktur2($nofak)
	{
		$hsl = $this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal,jual_total,jual_jml_uang,jual_kembalian,jual_keterangan,diskon,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,no_hp FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE jual_nofak='$nofak'");
		return $hsl;
	}

	function cetak_faktur_dp()
	{
		$nofak = $this->session->userdata('nofak');
		$hsl = $this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal,jual_total,jual_jml_uang,jual_kembalian,jual_keterangan,diskon,uang_muka,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,no_hp FROM tbl_jual_dp JOIN tbl_detail_jual_dp ON jual_nofak=d_jual_nofak WHERE jual_nofak='$nofak'");
		return $hsl;
	}
}

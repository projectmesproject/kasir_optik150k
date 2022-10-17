<?php
class M_laporan extends CI_Model
{
	
	function get_stok_barang(){
		$hsl=$this->db->query("SELECT kategori_id,kategori_nama,barang_nama,barang_stok FROM tbl_kategori JOIN tbl_barang ON kategori_id=barang_kategori_id GROUP BY kategori_id,barang_nama");
		return $hsl;
	}

	function get_data_barang(){
		$hsl=$this->db->query("SELECT kategori_id,barang_id,kategori_nama,barang_nama,barang_satuan,barang_harjul,barang_stok FROM tbl_kategori JOIN tbl_barang ON kategori_id=barang_kategori_id GROUP BY kategori_id,barang_nama");
		return $hsl;
	}

	function get_lap_hutang_karyawan(){
		return $this->db->query("SELECT a.id AS id_karyawan, a.nama AS nama_karyawan , b.nominal, b.jumlah_bayar, b.keterangan, b.status, b.tanggal FROM karyawan a LEFT JOIN hutang_karyawan b ON a.id=b.id_karyawan WHERE b.status='BelumLunas'");
	}

	function get_data_penjualan(){
		$hsl=$this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,jual_total,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak ORDER BY jual_nofak DESC");
		return $hsl;
	}

	function get_total_penjualan(){
		$hsl=$this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,jual_total,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,sum(d_jual_total) as total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak ORDER BY jual_nofak DESC");
		return $hsl;
	}

	// Laporan penjualan per periode
	function get_data_jual_periode($tanggal1,$tanggal2){
		$hsl=$this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(jual_tanggal) between '$tanggal1' AND '$tanggal2' ORDER BY jual_nofak DESC");
		return $hsl;
	}

	function get_data__total_jual_periode($tanggal1,$tanggal2){
		$hsl=$this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,SUM(d_jual_total) as total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(jual_tanggal) between '$tanggal1' AND '$tanggal2' ORDER BY jual_nofak DESC");
		return $hsl;
	}
	// 

	//  Laporan penjualan per barang
	function get_data_jual_barang($barang){
		return $this->db->query("SELECT a.d_jual_nofak, a.d_jual_barang_id , a.d_jual_barang_nama, a.d_jual_barang_satuan, a.d_jual_barang_harjul, a.d_jual_qty, a.d_jual_diskon, a.d_jual_total,
									b.jual_tanggal,b.jual_nofak FROM tbl_detail_jual a LEFT JOIN tbl_jual b on a.d_jual_nofak = b.jual_nofak WHERE a.d_jual_barang_id='$barang' ORDER BY b.jual_nofak DESC");
	}
	// 

	//  Laporan penjualan per kategori barang
	function get_data_jual_kat_barang($kat_barang){
		return $this->db->query("SELECT a.d_jual_nofak, a.d_jual_barang_id , a.d_jual_barang_nama, a.d_jual_barang_satuan, a.d_jual_barang_harjul, a.d_jual_qty, a.d_jual_diskon, a.d_jual_total,
									b.jual_tanggal,b.jual_nofak FROM tbl_detail_jual a LEFT JOIN tbl_jual b on a.d_jual_nofak = b.jual_nofak WHERE a.d_jual_barang_kat_id='$kat_barang' ORDER BY b.jual_nofak DESC");
	}

	// 

	//=========Laporan Laba rugi============
	function get_lap_laba_rugi($tanggal1,$tanggal2){
		$hsl=$this->db->query("SELECT DATE_FORMAT(jual_tanggal,'%d %M %Y') as jual_tanggal,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,(d_jual_barang_harjul-d_jual_barang_harpok) AS keunt,d_jual_qty,d_jual_diskon,((d_jual_barang_harjul-d_jual_barang_harpok)*d_jual_qty)-(d_jual_qty*d_jual_diskon) AS untung_bersih FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(jual_tanggal) between '$tanggal1' AND '$tanggal2'");
		return $hsl;
	}

	function get_total_lap_laba_rugi($tanggal1,$tanggal2){
		$hsl=$this->db->query("SELECT DATE_FORMAT(jual_tanggal,'%d %M %Y') AS bulan,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,(d_jual_barang_harjul-d_jual_barang_harpok) AS keunt,d_jual_qty,d_jual_diskon,SUM(((d_jual_barang_harjul-d_jual_barang_harpok)*d_jual_qty)-(d_jual_qty*d_jual_diskon)) AS total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(jual_tanggal) between '$tanggal1' AND '$tanggal2'");
		return $hsl;
	}

	function get_laporan_pengeluaran($tanggal1, $tanggal2){
		return $this->db->query("select a.jenis_pengeluaran, a.nominal, a.tanggal, a.keterangan, b.nama from pengeluaran a left join karyawan b
									on a.penerima=b.id where tanggal between '$tanggal1' AND '$tanggal2' order by a.id desc")->result_array();
	}
}
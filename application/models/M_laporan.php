<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_laporan extends CI_Model
{
	private $tb_jual = "tbl_jual";

	function get_stok_barang()
	{
		$hsl = $this->db->query("SELECT kategori_id,kategori_nama,barang_nama,barang_stok FROM tbl_kategori JOIN tbl_barang ON kategori_id=barang_kategori_id GROUP BY kategori_id,barang_nama");
		return $hsl;
	}
	// task ahmad
	function get_data_barang()
	{

		$hsl = $this->db->query("SELECT kategori_id,barang_id,kategori_nama,barang_nama,barang_satuan,barang_harjul,barang_stok FROM tbl_kategori JOIN tbl_barang ON kategori_id=barang_kategori_id GROUP BY kategori_id,barang_nama");
		return $hsl;
	}
	function get_data_barang_by($input_kategori, $input_barang)
	{
		$this->db->select('*');
		$this->db->from('tbl_kategori');
		if (!$input_kategori) {
			$this->db->where('kategori_nama', $input_kategori);
		}
		if (!$input_barang) {
			$this->db->where('barang_nama', $input_barang);
		}
		$this->db->join('tbl_barang', 'tbl_barang.barang_kategori_id=tbl_kategori.kategori_id');
		// $this->db->group_by('kategori_id,barang_nama');
		$res = $this->db->get()->result_array();
		return $res;
	}

	function total_penjualan($start, $end)
	{
		$res =	$this->db->select('*,sum(jual_total) as total_semua')->from($this->tb_jual)->where('DATE(jual_tanggal) >=', $start)->where('DATE(jual_tanggal) <=', $end)->get()->result();
		return $res;
	}
	function penjualan_by_metode($start, $end)
	{
		$res =	$this->db->select('*,sum(jual_total) as total_semua, jual_keterangan')->from($this->tb_jual)
			->group_by('jual_keterangan')->where('DATE(jual_tanggal) >=', $start)->where('DATE(jual_tanggal) <=', $end)->get()->result();
		return $res;
	}

	// task ahmad
	function get_lap_hutang_karyawan()
	{
		return $this->db->query("SELECT a.id AS id_karyawan, a.nama AS nama_karyawan , b.nominal, b.jumlah_bayar, b.keterangan, b.status, b.tanggal FROM karyawan a LEFT JOIN hutang_karyawan b ON a.id=b.id_karyawan WHERE b.status='BelumLunas'");
	}

	function get_data_penjualan()
	{
		$hsl = $this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,jual_total,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak ORDER BY jual_nofak DESC");
		return $hsl;
	}

	function get_total_penjualan()
	{
		$hsl = $this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,jual_total,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,sum(d_jual_total) as total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak ORDER BY jual_nofak DESC");
		return $hsl;
	}

	// Laporan penjualan per periode
	function get_data_jual_periode($tanggal1, $tanggal2, $nama_customer, $nama_barang)
	{
		if ($nama_customer == "" && $nama_barang == "") {
			$hsl = $this->db->query("SELECT jual_nofak,tbl_jual.no_hp, DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_customer.nama FROM tbl_jual JOIN tbl_detail_jual ON tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak JOIN tbl_customer ON tbl_jual.no_hp=tbl_customer.no_hp WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' ORDER BY jual_nofak DESC");
		} elseif ($nama_customer == "") {
			$hsl = $this->db->query("SELECT jual_nofak,tbl_jual.no_hp, DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_customer.nama FROM tbl_jual JOIN tbl_detail_jual ON tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak JOIN tbl_customer ON tbl_jual.no_hp=tbl_customer.no_hp WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_detail_jual.d_jual_barang_id='$nama_barang' ORDER BY jual_nofak DESC");
		} elseif ($nama_barang == "") {
			$hsl = $this->db->query("SELECT jual_nofak,tbl_jual.no_hp, DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_customer.nama FROM tbl_jual JOIN tbl_detail_jual ON tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak JOIN tbl_customer ON tbl_jual.no_hp=tbl_customer.no_hp WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_jual.no_hp='$nama_customer' ORDER BY jual_nofak DESC");
		} else {
			$hsl = $this->db->query("SELECT jual_nofak,tbl_jual.no_hp, DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_customer.nama FROM tbl_jual JOIN tbl_detail_jual ON tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak JOIN tbl_customer ON tbl_jual.no_hp=tbl_customer.no_hp WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_customer.no_hp='$nama_customer' AND tbl_detail_jual.d_jual_barang_id='$nama_barang' ORDER BY jual_nofak DESC");
		}
		return $hsl;
	}
	function laporan_penjualan_kasir_all($tanggal1, $tanggal2)
	{
	}
	function laporan_penjualan_kasir_customer($tanggal1, $tanggal2, $nama_customer)
	{
		if ($nama_customer == "") {
			$hsl = $this->db->query("SELECT jual_nofak,tbl_jual.no_hp, DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_customer.nama FROM tbl_jual JOIN tbl_detail_jual ON tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak JOIN tbl_customer ON tbl_jual.no_hp=tbl_customer.no_hp WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' ORDER BY jual_nofak DESC");
		} else {
			$hsl = $this->db->query("SELECT jual_nofak,tbl_jual.no_hp, DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_customer.nama FROM tbl_jual JOIN tbl_detail_jual ON tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak JOIN tbl_customer ON tbl_jual.no_hp=tbl_customer.no_hp WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_customer.no_hp='$nama_customer' ORDER BY jual_nofak DESC");
		}

		return $hsl;
	}
	function laporan_penjualan_kasir_barang($tanggal1, $tanggal2, $nama_barang)
	{
		if ($nama_barang == "") {
			$hsl = $this->db->query("SELECT jual_nofak,tbl_jual.no_hp, DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_customer.nama FROM tbl_jual JOIN tbl_detail_jual ON tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak JOIN tbl_customer ON tbl_jual.no_hp=tbl_customer.no_hp WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' ORDER BY jual_nofak DESC");
		} else {
			$hsl = $this->db->query("SELECT jual_nofak,tbl_jual.no_hp, DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_customer.nama FROM tbl_jual JOIN tbl_detail_jual ON tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak JOIN tbl_customer ON tbl_jual.no_hp=tbl_customer.no_hp WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_detail_jual.d_jual_barang_id='$nama_barang' ORDER BY jual_nofak DESC");
		}

		return $hsl;
	}
	function laporan_penjualan_kasir_cara_bayar($tanggal1, $tanggal2, $cara_bayar = "")
	{
		if ($cara_bayar == "") {
			$hsl = $this->db->query("SELECT jual_nofak,tbl_jual.no_hp, DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_customer.nama,tbl_jual.jual_keterangan,tbl_jual.jual_keterangan2 FROM tbl_jual JOIN tbl_detail_jual ON tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak JOIN tbl_customer ON tbl_jual.no_hp=tbl_customer.no_hp WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' ORDER BY jual_nofak DESC");
		} else {
			$hsl = $this->db->query("SELECT jual_nofak,tbl_jual.no_hp, DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_customer.nama,tbl_jual.jual_keterangan,tbl_jual.jual_keterangan2  FROM tbl_jual JOIN tbl_detail_jual ON tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak JOIN tbl_customer ON tbl_jual.no_hp=tbl_customer.no_hp WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_jual.jual_keterangan='$cara_bayar' OR tbl_jual.jual_keterangan2='$cara_bayar' ORDER BY jual_nofak DESC");
		}

		return $hsl;
	}
	function get_penjualan_dp($tanggal1, $tanggal2, $nama_customer, $nama_barang)
	{
		if ($nama_customer == "" && $nama_barang == "") {
			$hsl = $this->db->query("SELECT jual_nofak,tbl_jual.no_hp, DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_customer.nama FROM tbl_jual JOIN tbl_detail_jual ON tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak JOIN tbl_customer ON tbl_jual.no_hp=tbl_customer.no_hp WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_jual.status='DP' ORDER BY jual_nofak DESC");
		} elseif ($nama_customer == "") {
			$hsl = $this->db->query("SELECT jual_nofak,tbl_jual.no_hp, DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_customer.nama FROM tbl_jual JOIN tbl_detail_jual ON tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak JOIN tbl_customer ON tbl_jual.no_hp=tbl_customer.no_hp WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_detail_jual.d_jual_barang_id='$nama_barang' AND tbl_jual.status='DP' ORDER BY jual_nofak DESC");
		} elseif ($nama_barang == "") {
			$hsl = $this->db->query("SELECT jual_nofak,tbl_jual.no_hp, DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_customer.nama FROM tbl_jual JOIN tbl_detail_jual ON tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak JOIN tbl_customer ON tbl_jual.no_hp=tbl_customer.no_hp WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_jual.no_hp='$nama_customer' AND tbl_jual.status='DP' ORDER BY jual_nofak DESC");
		} else {
			$hsl = $this->db->query("SELECT jual_nofak,tbl_jual.no_hp, DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_customer.nama FROM tbl_jual JOIN tbl_detail_jual ON tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak JOIN tbl_customer ON tbl_jual.no_hp=tbl_customer.no_hp WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_customer.no_hp='$nama_customer' AND tbl_detail_jual.d_jual_barang_id='$nama_barang' AND tbl_jual.status='DP' ORDER BY jual_nofak DESC");
		}
		return $hsl;
	}
	function get_penjualan_cabang($tanggal1, $tanggal2, $cabang, $nama_barang)
	{
		if ($cabang == "" && $nama_barang == "") {
			$hsl = $this->db->query("SELECT jual_nofak,cabang,DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_jual.cabang!='' ORDER BY jual_nofak DESC");
		} elseif ($cabang == "") {
			$hsl = $this->db->query("SELECT jual_nofak,cabang,DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_jual.cabang!='' AND tbl_detail_jual.d_jual_barang_id='$nama_barang' ORDER BY jual_nofak DESC");
		} elseif ($nama_barang == "") {
			$hsl = $this->db->query("SELECT jual_nofak,cabang,DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_jual.cabang!='' AND tbl_jual.cabang='$cabang' ORDER BY jual_nofak DESC");
		} else {
			$hsl = $this->db->query("SELECT jual_nofak,cabang,DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_jual.cabang!='' AND tbl_jual.cabang='$cabang' AND tbl_detail_jual.d_jual_barang_id='$nama_barang'  ORDER BY jual_nofak DESC");
		}
		return $hsl;
	}
	function get_cabang()
	{
		$this->db->select('*');
		$this->db->from('tbl_jual');
		$this->db->where('cabang !=', '');
		$this->db->group_by('tbl_jual.cabang');
		$res = $this->db->get()->result();
		return $res;
	}
	function listPenjualan_cabang($tanggal1, $tanggal2)
	{
		$this->db->select('*');
		$this->db->from('tbl_jual');
		$this->db->where('jual_tanggal >=', date('Y-m-d', strtotime($tanggal1)));
		$this->db->where('jual_tanggal <=', date('Y-m-d', strtotime($tanggal2)));
		$this->db->join('tbl_detail_jual', 'tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak');
		$this->db->join('tbl_barang', 'tbl_detail_jual.d_jual_barang_id=tbl_barang.barang_id');
		$this->db->group_by('tbl_jual.cabang');
		$res = $this->db->get()->result();
		return $res;
	}
	function listPenjualan_cabangBarang($cabang)
	{
		$this->db->select('*');
		$this->db->from('tbl_jual');
		$this->db->where('cabang', $cabang);
		$this->db->join('tbl_detail_jual', 'tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak');
		$this->db->join('tbl_barang', 'tbl_detail_jual.d_jual_barang_id=tbl_barang.barang_id');
		$this->db->group_by('tbl_jual.cabang');
		$res = $this->db->get()->result();
		return $res;
	}

	function get_pembelian($tanggal1, $tanggal2, $supplier, $nama_barang)
	{
		$this->db->select('*');
		$this->db->from('tbl_beli');
		$this->db->where('beli_tanggal >=', date('Y-m-d', strtotime($tanggal1)));
		$this->db->where('beli_tanggal <=', date('Y-m-d', strtotime($tanggal2)));
		$this->db->join('tbl_detail_beli', 'tbl_beli.beli_nofak=tbl_detail_beli.d_beli_nofak');
		$this->db->join('tbl_barang', 'tbl_detail_beli.d_beli_barang_id=tbl_barang.barang_id');
		$this->db->join('tbl_suplier', 'tbl_beli.beli_suplier_id=tbl_suplier.suplier_id');
		if ($supplier) {
			$this->db->where('tbl_beli.beli_suplier_id', $supplier);
		}
		if ($nama_barang) {
			$this->db->where('tbl_detail_beli.d_beli_barang_id', $nama_barang);
		}
		$res = $this->db->get()->result();
		return $res;
	}
	function listSupplier_pembelian($tanggal1, $tanggal2)
	{
		$this->db->select('*');
		$this->db->from('tbl_beli');
		$this->db->where('beli_tanggal >=', date('Y-m-d', strtotime($tanggal1)));
		$this->db->where('beli_tanggal <=', date('Y-m-d', strtotime($tanggal2)));
		$this->db->join('tbl_suplier', 'tbl_beli.beli_suplier_id=tbl_suplier.suplier_id');
		$this->db->join('tbl_detail_beli', 'tbl_beli.beli_nofak=tbl_detail_beli.d_beli_nofak');
		$this->db->join('tbl_barang', 'tbl_detail_beli.d_beli_barang_id=tbl_barang.barang_id');
		$this->db->group_by('tbl_beli.beli_suplier_id');
		$res = $this->db->get()->result();
		return $res;
	}
	function listSupplier_pembelianBarang($supplier)
	{
		$this->db->select('*');
		$this->db->from('tbl_beli');
		$this->db->where('beli_suplier_id', $supplier);
		$this->db->join('tbl_suplier', 'tbl_beli.beli_suplier_id=tbl_suplier.suplier_id');
		$this->db->join('tbl_detail_beli', 'tbl_beli.beli_nofak=tbl_detail_beli.d_beli_nofak');
		$this->db->join('tbl_barang', 'tbl_detail_beli.d_beli_barang_id=tbl_barang.barang_id');
		$this->db->group_by('tbl_barang.barang_id');
		$res = $this->db->get()->result();
		return $res;
	}
	function get_pembelian_total($tanggal1, $tanggal2, $supplier, $nama_barang)
	{
		if ($supplier == "" && $nama_barang == "") {
			$hsl = $this->db->query("SELECT beli_nofak,DATE_FORMAT(beli_tanggal,'%d %M %Y') AS beli_tanggal,d_beli_id, d_beli_nofak, d_beli_barang_id, d_beli_harga, d_beli_jumlah, SUM(d_beli_total) as total FROM tbl_beli JOIN tbl_detail_beli ON beli_nofak=d_beli_nofak WHERE DATE(tbl_beli.beli_tanggal) between '$tanggal1' AND '$tanggal2' ORDER BY beli_nofak DESC");
		} elseif ($nama_barang == "") {
			$hsl = $this->db->query("SELECT beli_nofak,DATE_FORMAT(beli_tanggal,'%d %M %Y') AS beli_tanggal,d_beli_id, d_beli_nofak, d_beli_barang_id, d_beli_harga, d_beli_jumlah, SUM(d_beli_total) as total FROM tbl_beli JOIN tbl_detail_beli ON beli_nofak=d_beli_nofak WHERE DATE(tbl_beli.beli_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_beli.beli_suplier_id='$supplier' ORDER BY beli_nofak DESC");
		} elseif ($supplier == "") {
			$hsl = $this->db->query("SELECT beli_nofak,DATE_FORMAT(beli_tanggal,'%d %M %Y') AS beli_tanggal,d_beli_id, d_beli_nofak, d_beli_barang_id, d_beli_harga, d_beli_jumlah, SUM(d_beli_total) as total FROM tbl_beli JOIN tbl_detail_beli ON beli_nofak=d_beli_nofak WHERE DATE(tbl_beli.beli_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_detail_beli.d_beli_barang_id='$nama_barang' ORDER BY beli_nofak DESC");
		} else {
			$hsl = $this->db->query("SELECT beli_nofak,DATE_FORMAT(beli_tanggal,'%d %M %Y') AS beli_tanggal,d_beli_id, d_beli_nofak, d_beli_barang_id, d_beli_harga, d_beli_jumlah, SUM(d_beli_total) as total FROM tbl_beli JOIN tbl_detail_beli ON beli_nofak=d_beli_nofak WHERE DATE(tbl_beli.beli_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_beli.beli_suplier_id='$supplier' AND tbl_detail_beli.d_beli_barang_id='$nama_barang' ORDER BY beli_nofak DESC");
		}
		return $hsl;
	}
	function get_penjualan_kwitansi($tanggal1, $tanggal2)
	{
		$this->db->select('*');
		$this->db->from('tbl_kwitansi');
		$this->db->where('date_created >=', date('Y-m-d', strtotime($tanggal1)));
		$this->db->where('date_created <=', date('Y-m-d', strtotime($tanggal2)));
		$res = $this->db->get()->result();
		return $res;
	}
	function get_penjualan_kwitansi_total($tanggal1, $tanggal2)
	{
		$this->db->select('*');
		$this->db->select_sum('harga_jual');
		$this->db->from('tbl_kwitansi');
		$this->db->where('date_created >=', date('Y-m-d', strtotime($tanggal1)));
		$this->db->where('date_created <=', date('Y-m-d', strtotime($tanggal2)));
		$res = $this->db->get()->row_array(); // Produces: SELECT SUM(age) as age FROM members
		return $res;
	}

	function get_total_penjualan_cabang($tanggal1, $tanggal2, $cabang, $nama_barang)
	{
		if ($cabang == "") {
			$hsl = $this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,SUM(d_jual_total) as total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_jual.cabang!='' AND tbl_detail_jual.d_jual_barang_id='$nama_barang' ORDER BY jual_nofak DESC");
		} elseif ($nama_barang == "") {
			$hsl = $this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,SUM(d_jual_total) as total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_jual.cabang!='' AND tbl_jual.cabang='$cabang' ORDER BY jual_nofak DESC");
		} elseif ($cabang == "" && $nama_barang == "") {
			$hsl = $this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,SUM(d_jual_total) as total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_jual.cabang!='' ORDER BY jual_nofak DESC");
		} else {
			$hsl = $this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,SUM(d_jual_total) as total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_jual.cabang!='' AND tbl_jual.cabang='$cabang' AND tbl_detail_jual.d_jual_barang_id='$nama_barang' ORDER BY jual_nofak DESC");
		}
		return $hsl;
	}
	function get_data__total_jual_periode($tanggal1, $tanggal2, $nama_customer, $nama_barang)
	{
		if ($nama_customer == "" &&  $nama_barang == "") {
			$hsl = $this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,SUM(d_jual_total) as total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(jual_tanggal) between '$tanggal1' AND '$tanggal2' ORDER BY jual_nofak DESC");
		} elseif ($nama_customer == "") {
			$hsl = $this->db->query("SELECT jual_nofak,tbl_jual.no_hp, DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,tbl_customer.nama,SUM(d_jual_total) as total FROM tbl_jual JOIN tbl_detail_jual ON tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak JOIN tbl_customer ON tbl_jual.no_hp=tbl_customer.no_hp WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_detail_jual.d_jual_barang_nama='$nama_barang' ORDER BY jual_nofak DESC");
		} elseif ($nama_barang == "") {
			$hsl = $this->db->query("SELECT jual_nofak,tbl_jual.no_hp, DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon, SUM(d_jual_total) as total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_jual.no_hp='$nama_customer' ORDER BY jual_nofak DESC");
		} else {
			$hsl = $this->db->query("SELECT jual_nofak,tbl_jual.no_hp, DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,tbl_customer.nama, SUM(d_jual_total) as total FROM tbl_jual JOIN tbl_detail_jual ON tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak JOIN tbl_customer ON tbl_jual.no_hp=tbl_customer.no_hp WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_jual.no_hp='$nama_customer' AND tbl_detail_jual.d_jual_barang_nama='$nama_barang' ORDER BY jual_nofak DESC");
		}
		return $hsl;
	}
	function get_total_penjualan_dp($tanggal1, $tanggal2, $nama_customer, $nama_barang)
	{
		if ($nama_customer == "" &&  $nama_barang == "") {
			$hsl = $this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,SUM(d_jual_total) as total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_jual.status='DP' ORDER BY jual_nofak DESC");
		} elseif ($nama_customer == "") {
			$hsl = $this->db->query("SELECT jual_nofak,tbl_jual.no_hp, DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,SUM(d_jual_total) as total FROM tbl_jual JOIN tbl_detail_jual ON tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak JOIN tbl_customer ON tbl_jual.no_hp=tbl_customer.no_hp WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_detail_jual.d_jual_barang_nama='$nama_barang' AND tbl_jual.status='DP' ORDER BY jual_nofak DESC");
		} elseif ($nama_barang == "") {
			$hsl = $this->db->query("SELECT jual_nofak,tbl_jual.no_hp, DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon, SUM(d_jual_total) as total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_jual.no_hp='$nama_customer' AND tbl_jual.status='DP' ORDER BY jual_nofak DESC");
		} else {
			$hsl = $this->db->query("SELECT jual_nofak,tbl_jual.no_hp, DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,SUM(d_jual_total) as total FROM tbl_jual JOIN tbl_detail_jual ON tbl_jual.jual_nofak=tbl_detail_jual.d_jual_nofak JOIN tbl_customer ON tbl_jual.no_hp=tbl_customer.no_hp WHERE DATE(tbl_jual.jual_tanggal) between '$tanggal1' AND '$tanggal2' AND tbl_jual.no_hp='$nama_customer' AND tbl_detail_jual.d_jual_barang_nama='$nama_barang' AND tbl_jual.status='DP' ORDER BY jual_nofak DESC");
		}
		return $hsl;
	}
	// 

	//  Laporan penjualan per barang
	function get_data_jual_barang($barang)
	{
		return $this->db->query("SELECT a.d_jual_nofak, a.d_jual_barang_id , a.d_jual_barang_nama, a.d_jual_barang_satuan, a.d_jual_barang_harjul, a.d_jual_qty, a.d_jual_diskon, a.d_jual_total,
									b.jual_tanggal,b.jual_nofak FROM tbl_detail_jual a LEFT JOIN tbl_jual b on a.d_jual_nofak = b.jual_nofak WHERE a.d_jual_barang_id='$barang' ORDER BY b.jual_nofak DESC");
	}
	// 

	//  Laporan penjualan per kategori barang
	function get_data_jual_kat_barang($kat_barang)
	{
		return $this->db->query("SELECT a.d_jual_nofak, a.d_jual_barang_id , a.d_jual_barang_nama, a.d_jual_barang_satuan, a.d_jual_barang_harjul, a.d_jual_qty, a.d_jual_diskon, a.d_jual_total,
									b.jual_tanggal,b.jual_nofak FROM tbl_detail_jual a LEFT JOIN tbl_jual b on a.d_jual_nofak = b.jual_nofak WHERE a.d_jual_barang_kat_id='$kat_barang' ORDER BY b.jual_nofak DESC");
	}

	// 

	//=========Laporan Laba rugi============
	function get_lap_laba_rugi($tanggal1, $tanggal2)
	{
		$hsl = $this->db->query("SELECT DATE_FORMAT(jual_tanggal,'%d %M %Y') as jual_tanggal,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,(d_jual_barang_harjul-d_jual_barang_harpok) AS keunt,d_jual_qty,d_jual_diskon,((d_jual_barang_harjul-d_jual_barang_harpok)*d_jual_qty)-(d_jual_qty*d_jual_diskon) AS untung_bersih FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(jual_tanggal) between '$tanggal1' AND '$tanggal2'");
		return $hsl;
	}

	function get_total_lap_laba_rugi($tanggal1, $tanggal2)
	{
		$hsl = $this->db->query("SELECT DATE_FORMAT(jual_tanggal,'%d %M %Y') AS bulan,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,(d_jual_barang_harjul-d_jual_barang_harpok) AS keunt,d_jual_qty,d_jual_diskon,SUM(((d_jual_barang_harjul-d_jual_barang_harpok)*d_jual_qty)-(d_jual_qty*d_jual_diskon)) AS total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(jual_tanggal) between '$tanggal1' AND '$tanggal2'");
		return $hsl;
	}

	function get_laporan_pengeluaran($tanggal1, $tanggal2)
	{
		return $this->db->query("select a.jenis_pengeluaran, a.nominal, a.tanggal, a.keterangan, b.nama from pengeluaran a left join karyawan b
									on a.penerima=b.id where tanggal between '$tanggal1' AND '$tanggal2' order by a.id desc")->result_array();
	}
}

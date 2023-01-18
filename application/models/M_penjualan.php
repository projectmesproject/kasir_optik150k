<?php
class M_penjualan extends CI_Model
{


	function simpan_penjualan($nofak, $total, $jml_uang, $jml_uang2, $kurang, $kembalian, $bayar, $bayar2, $diskon, $nohp, $status)
	{
		$idadmin = $this->session->userdata('idadmin');
		$this->db->query("INSERT INTO tbl_jual (jual_nofak,jual_total,jual_jml_uang,jual_jml_uang2,jual_kurang_uang,jual_kembalian,jual_user_id,jual_keterangan,jual_keterangan2,diskon,no_hp,status) VALUES ('$nofak','$total','$jml_uang','$jml_uang2','$kurang','$kembalian','$idadmin','$bayar','$bayar2','$diskon','$nohp','$status')");
		$data_resume = [
			'resume_nofak' => $nofak,
			'method_types' => $bayar,
			'amount' => $jml_uang,
			'created_at' => date('Y-m-d H:i:s')
		];
		$data_resume2 = [
			'resume_nofak' => $nofak,
			'method_types' => $bayar2,
			'amount' => $jml_uang2,
			'created_at' => date('Y-m-d H:i:s')
		];
		$this->db->insert('tbl_resume', $data_resume);
		$this->db->insert('tbl_resume', $data_resume2);
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
	function simpan_penjualan_cabang($nofak, $total, $jml_uang, $jml_uang2, $kurang, $kembalian, $bayar, $bayar2, $diskon, $cabang, $status)
	{

		$select = $this->db->query("SELECT jual_nofak FROM tbl_jual WHERE jual_nofak='$nofak'")->result();
		$count = count($select);
		$count++;
		$count = sprintf("%04d", $count);
		$today = date("dmY");
		$bulan = date("m");
		$surat_jalan = "DOCSJ$today/$bulan/$count";
		$this->db->query("INSERT INTO tbl_jual (jual_nofak,jual_total,jual_jml_uang,jual_jml_uang2,jual_kurang_uang,jual_kembalian,jual_keterangan,jual_keterangan2,diskon,cabang,surat_jalan,status) VALUES ('$nofak','$total','$jml_uang','$jml_uang2','$kurang','$kembalian','$bayar','$bayar2','$diskon','$cabang','$surat_jalan','$status')");
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

	function edit_penjualan_cabang($nofak, $kobar, $qty)
	{

		$select = $this->db->query("SELECT jual_total FROM tbl_jual WHERE jual_nofak='$nofak'")->row();
		$select_barang = $this->db->query("SELECT d_jual_nofak,d_jual_qty FROM tbl_detail_jual WHERE d_jual_nofak='$nofak' AND d_jual_barang_id='$kobar'")->result_array();
		$count = count($select_barang);
		$produk = $this->m_barang->get_barang1($kobar)->result_array();

		$produk = $produk[0];
		$jual_total = $select->jual_total;
		if ($count == 0) {
			
			$total = $qty * $produk["barang_harjul"];
			$data = array(
				'd_jual_nofak' 			=>	$nofak,
				'd_jual_barang_id'		=>	$produk['barang_id'],
				'd_jual_barang_kat_id'  =>  $produk['barang_kategori_id'],
				'd_jual_barang_nama'	=>	$produk['barang_nama'],
				'd_jual_barang_satuan'	=>	$produk['barang_satuan'],
				'd_jual_barang_harpok'	=>	$produk['barang_harpok'],
				'd_jual_barang_harjul'	=>	$produk['barang_harjul'],
				'd_jual_qty'			=>	$qty,
				'd_jual_total'			=>	$total
			);

			// Add Items detail jual
			$this->db->insert('tbl_detail_jual', $data);


			// Update total harga
			$grand_total = $jual_total + $total;
			$this->db->query("UPDATE tbl_jual SET jual_total='$grand_total' WHERE jual_nofak='$nofak'");

			// Kurangi Stok Sesuai Qty
			$this->db->query("update tbl_barang set barang_stok=barang_stok-'$qty' where barang_id='$kobar'");
		} else {
			
			$this->db->query("update tbl_barang set barang_stok=barang_stok-'$qty' where barang_id='$kobar'");
			$qty++;
			// Pengurangan Stok Barang
			//
			// 1. Get qty barang jual sebelumnya
			// $qty_jual = $select_barang[0]->d_jual_qty;

			// 2. Add qty ke stok barang = stok + 4
			// $this->db->query("update tbl_barang set barang_stok=barang_stok+'$qty_jual' where barang_id='$kobar'");

			// 3. Pengurangan stok berdasarkan qty saat ini = stok - 2

			$total = $qty * $produk["barang_harjul"];


			// Update total harga
			$grand_total = $jual_total + $total;
			$this->db->query("UPDATE tbl_jual SET jual_total='$grand_total' WHERE jual_nofak='$nofak'");

			$this->db->query("UPDATE tbl_detail_jual SET d_jual_qty='$qty',d_jual_total='$total' WHERE d_jual_nofak='$nofak' AND d_jual_barang_id='$kobar'");
		}

		
		// $this->db->query("update saldo set saldo=saldo+'$jml_uang' where id=1");
		// $this->db->query("update saldo set saldo=saldo-'$kembalian' where id=1");

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
		$kd += 1;
		$kd = sprintf("%06d", $kd);
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
		$hsl = $this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal,jual_total,jual_jml_uang,jual_jml_uang2,jual_kurang_uang,jual_kembalian,jual_keterangan,jual_keterangan2,diskon,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,no_hp FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE jual_nofak='$nofak'");
		//die($this->db->last_query());
		return $hsl;
	}
	function cetak_faktur_cabang()
	{
		$nofak = $this->session->userdata('nofak');
		$hsl = $this->db->query("SELECT jual_nofak,surat_jalan,DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal,jual_total,jual_jml_uang,jual_jml_uang2,jual_kurang_uang,jual_kembalian,jual_keterangan,jual_keterangan2,diskon,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,cabang,status FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE jual_nofak='$nofak'");
		//die($this->db->last_query());
		return $hsl;
	}

	function cetak_faktur2($nofak)
	{
		$hsl = $this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal,jual_total,jual_jml_uang,jual_jml_uang2,jual_kurang_uang,jual_kembalian,jual_keterangan,jual_keterangan2,diskon,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,no_hp FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE jual_nofak='$nofak'");
		return $hsl;
	}

	function cetak_faktur_dp()
	{
		$nofak = $this->session->userdata('nofak');
		$hsl = $this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal,jual_total,jual_jml_uang,jual_kembalian,jual_keterangan,diskon,uang_muka,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,no_hp FROM tbl_jual_dp JOIN tbl_detail_jual_dp ON jual_nofak=d_jual_nofak WHERE jual_nofak='$nofak'");
		return $hsl;
	}
	function detail_penjualan($id)
	{
		$data = $this->db->select('*')->from('tbl_detail_jual')->where('d_jual_nofak', $id)->get()->result_array();
		return $data;
	}
	function update_status($id, $data)
	{
		$this->db->where('jual_nofak', $id);
		$res = $this->db->update('tbl_jual', $data);
		return $res;
	}
	function update_status_resume($id)
	{
		$this->db->where('resume_nofak', $id);
		$res = $this->db->delete('tbl_resume');
		return $res;
	}
	function cari_barang($nomor_faktur, $nabar)
	{
		$this->db->where('d_jual_nofak', $nomor_faktur);
		$this->db->where('d_jual_barang_nama', $nabar);
		return $this->db->get('tbl_detail_jual')->result_array();
	}
	function cari_barang1($nomor_faktur, $nabar)
	{
		$this->db->where('d_jual_nofak', $nomor_faktur);
		$this->db->where('d_jual_barang_id', $nabar);
		return $this->db->get('tbl_detail_jual')->result_array();
	}
	function update_detail($nomor_faktur, $nabar, $data)
	{
		$this->db->where('d_jual_nofak', $nomor_faktur);
		$this->db->where('d_jual_barang_nama', $nabar);
		$res = $this->db->update('tbl_detail_jual', $data);
		return $res;
	}
	function update_stok_barang($id, $qty_baru)
	{
		$check = $this->db->select('*')->from('tbl_barang')->where('barang_id', $id)->get()->row();
		$newQty = $check->barang_stok - $qty_baru;
		$this->db->where('barang_id', $id);
		$data = ['barang_stok' => $newQty];
		$res = $this->db->update('tbl_barang', $data);
		return $res;
	}

	function get_penjualan_cabang()
	{
		return  $this->db->query("select * from tbl_jual where cabang !=null or cabang != '' and no_hp ='' or no_hp=null order by jual_tanggal desc")->result_array();
	}
	function get_history_penjualan()
	{
		$this->db->select('A.*, B.nama AS namaplg,C.count(d_jual_nofak) as jum')->from('tbl_jual as A');
		$this->db->join('tbl_customer B', 'A.no_hp=B.no_hp', 'LEFT');
		$this->db->where('A.cabang=', '');
		$this->db->where('A.no_hp!=', '');
		$this->db->order_by('A.jual_tanggal', 'DESC');
		$res =	$this->db->get()->result();
		return $res;
	}
	function get_penjualan_paket($id)
	{
		$this->db->select('A.*,B.*');
		$this->db->from('tbl_jual A');
		$this->db->where('A.jual_nofak', $id);
		$this->db->join('tbl_detail_jual B', 'B.d_jual_nofak = A.jual_nofak');
		$res = $this->db->get()->result_array();
		return $res;
	}
}

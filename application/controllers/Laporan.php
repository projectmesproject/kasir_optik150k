<?php
class Laporan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('m_kategori');
		$this->load->model('m_barang');
		$this->load->model('m_suplier');
		$this->load->model('m_pengeluaran');
		$this->load->model('m_pembelian');
		$this->load->model('m_penjualan');
		$this->load->model('m_laporan');
		$this->load->model('m_karyawan');
		$this->load->model('m_customer');
		$this->load->model('m_cabang');
		$this->load->model('m_cara_bayar');
	}

	function index()
	{

		$data['title'] = 'Laporan';
		$data['data'] = $this->m_barang->tampil_barang();
		$data['listBarang'] = $this->m_barang->listBarang();
		$data['kat'] = $this->m_kategori->tampil_kategori();
		$data['karyawan'] = $this->m_karyawan->tampil_karyawan();
		$data['customer'] = $this->m_customer->tampil_customer();
		$data['cabang'] = $this->m_cabang->tampil_cabang()->result();
		$data['supplier'] = $this->m_suplier->tampil_suplier();
		$data['cara_bayar'] = $this->m_cara_bayar->list();

		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('template/topbar', $data);
		$this->load->view('laporan/index', $data);
		$this->load->view('template/footer', $data);
	}
	function listPenjualan_cabang()
	{
		$start = $this->input->post('tgl1');
		$end = $this->input->post('tgl2');
		$res = 	$this->m_laporan->listPenjualan_cabang($start, $end);
		echo json_encode($res);
	}
	function listPenjualan_cabangBarang()
	{
		$cabang = $this->input->post('cabang');
		$res = 	$this->m_laporan->listPenjualan_cabangBarang($cabang);
		echo json_encode($res);
	}
	function listSupplier_pembelian()
	{
		$start = $this->input->post('tgl1');
		$end = $this->input->post('tgl2');
		$res = 	$this->m_laporan->listSupplier_pembelian($start, $end);
		echo json_encode($res);
	}
	function listSupplier_pembelianBarang()
	{
		$supplier = $this->input->post('supplier');
		$res = 	$this->m_laporan->listSupplier_pembelianBarang($supplier);
		echo json_encode($res);
	}
	function lap_stok_barang()
	{
		$data['title'] = 'Laporan';
		$data['data'] = $this->m_barang->tampil_barang();
		$data['kat'] = $this->m_kategori->tampil_kategori();
		$data['karyawan'] = $this->m_karyawan->tampil_karyawan();
		$x['data'] = $this->m_laporan->get_stok_barang();
		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('template/topbar', $data);
		$this->load->view('laporan/stok_barang/index', $x);
		$this->load->view('template/footer', $data);
	}

	function lap_stok_barang_cetak()
	{
		$x['data'] = $this->m_laporan->get_stok_barang();
		$this->load->view('laporan/stok_barang/cetak', $x);
	}

	function laporan_data_barang()
	{
		$list = $this->m_barang->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $field->barang_nama;
			$row[] = $field->barang_satuan;
			$row[] = $field->barang_harjul;
			$row[] = $field->barang_stok;
			$row[] = $field->kategori_nama;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_barang->count_all(),
			"recordsFiltered" => $this->m_barang->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	function lap_data_barang()
	{
		$data['title'] = 'Laporan';
		$data['data'] = $this->m_barang->tampil_barang();
		$data['kat'] = $this->m_kategori->tampil_kategori();
		$data['karyawan'] = $this->m_karyawan->tampil_karyawan();
		$x['data'] = $this->m_laporan->get_data_barang();
		$x['selectBarang'] = $this->m_barang->getBarang();
		$x['selectKategori'] = $this->m_kategori->getKategori();
		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('template/topbar', $data);
		$this->load->view('laporan/data_barang/index', $x);
		$this->load->view('template/footer', $data);
	}

	function lap_data_barang_cetak()
	{
		$input_kategori = $this->input->post('kategori_nama');
		$input_barang = $this->input->post('barang_nama');
		$x['data'] = $this->m_laporan->get_data_barang();
		$this->load->view('laporan/v_lap_barang', $x);
	}
	function filter_barang_by_kategori()
	{
		$kategori_nama = $this->input->post('kategori_nama');
		$data['kategori'] = $kategori_nama;
		$data['selectKategori'] = $this->m_barang->get_byKategori($kategori_nama);
		$data['listBarang'] = $this->m_barang->get_list_barang($kategori_nama);
		$this->load->view('laporan/cetak_barang_byKategori', $data);
	}
	function lap_data_barang_kategori()
	{
		$input_kategori = $this->input->post('kategori_nama');
		$input_barang = $this->input->post('barang_nama');
		$x['data'] = $this->m_laporan->get_data_barang_by($input_kategori, $input_barang);
		$this->load->view('laporan/data_barang/cetak', $x);
	}

	function exportExcel()
	{
		// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excel
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=Data_Barang.xls");

		$data['data'] = $this->m_laporan->get_data_barang()->result_array();

		$this->load->view('laporan/export_excel', $data);
	}

	function lap_data_penjualan()
	{
		$data['title'] = 'Laporan';
		$data['data'] = $this->m_barang->tampil_barang();
		$data['kat'] = $this->m_kategori->tampil_kategori();
		$data['karyawan'] = $this->m_karyawan->tampil_karyawan();
		$x['data'] = $this->m_laporan->get_data_penjualan();
		$x['jml'] = $this->m_laporan->get_total_penjualan();
		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('template/topbar', $data);
		$this->load->view('laporan/penjualan/index', $x);
		$this->load->view('template/footer', $data);
	}

	function lap_data_penjualan_cetak()
	{
		$x['data'] = $this->m_laporan->get_data_penjualan();
		$x['jml'] = $this->m_laporan->get_total_penjualan();
		$this->load->view('laporan/penjualan/cetak', $x);
	}

	function lap_penjualan_periode()
	{
		$tanggal1 = $this->input->post('tgl1');
		$tanggal2 = $this->input->post('tgl2');

		$x['tanggal1'] = $this->input->post('tgl1');
		$x['tanggal2'] = $this->input->post('tgl2');

		$x['jml'] = $this->m_laporan->get_data__total_jual_periode($tanggal1, $tanggal2);
		$x['data'] = $this->m_laporan->get_data_jual_periode($tanggal1, $tanggal2);

		$data['title'] = 'Laporan';
		$data['data'] = $this->m_barang->tampil_barang();
		$data['kat'] = $this->m_kategori->tampil_kategori();
		$data['karyawan'] = $this->m_karyawan->tampil_karyawan();
		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('template/topbar', $data);
		$this->load->view('laporan/penjualan_per_periode/index', $x);
		$this->load->view('template/footer', $data);
	}

	function _group_by($array, $keys = array())
	{
		$return = array();
		$name = array();
		foreach ($array as $val) {

			// echo $nama . " = " . $val[$keys]. "<br/>";
			if (!in_array($val[$keys], $name)) {
				array_push($name, $val[$keys]);
				array_push($return, $val[$keys]);
			}
		}

		return $return;
	}

	function remove_parent_array($array)
	{
		$it = new RecursiveIteratorIterator(new RecursiveArrayIterator($array));
		$list = iterator_to_array($it, false);
		return $list;
	}

	function lap_penjualan_periode_cetak()
	{

		$tanggal1 = $this->input->post('tgl1');
		$tanggal2 = $this->input->post('tgl2');
		$nama_customer = $this->input->post('nama_customer');
		$kategori_barang = $this->input->post('kategori_barang');
		$nama_barang = $this->input->post('nama_barang');
		$cara_bayar = $this->input->post('cara_bayar');

		// Tampilkan
		if ($this->input->post('percustomer') != false) {
			$percustomer = 1;
		} else {
			$percustomer = 0;
		}
		if ($this->input->post('perkatbarang') != false) {
			$perkatbarang = 1;
		} else {
			$perkatbarang = 0;
		}
		if ($this->input->post('perbarang') != false) {
			$perbarang = 1;
		} else {
			$perbarang = 0;
		}
		if ($this->input->post('percarabayar') != false) {
			$percarabayar = 1;
		} else {
			$percarabayar = 0;
		}

		$x['percustomer'] = $percustomer;
		$x['perkatbarang'] = $perkatbarang;
		$x['perbarang'] = $perbarang;
		$x['percarabayar'] = $percarabayar;

		// end

		$x['tanggal1'] = $this->input->post('tgl1');
		$x['tanggal2'] = $this->input->post('tgl2');

		// Customer Section

		$data = $this->m_laporan->laporan_penjualan_kasir_customer($tanggal1, $tanggal2, $nama_customer)->result_array();

		$customer_arr = array();
		$group_cust = $this->_group_by($data, 'no_hp');
		$group_nama = $this->_group_by($data, 'nama');

		foreach ($group_cust as $idx => $cust) {
			$customer = new stdClass();
			$customer->nama = $group_nama[$idx];
			$customer->no_hp = $cust;
			$customer->items  = $this->m_laporan->laporan_penjualan_kasir_customer($tanggal1, $tanggal2, $cust)->result_array();
			array_push($customer_arr, $customer);
		}

		$x['data'] = $customer_arr;

		// End Section Customer

		// Cara Bayar Section

		$data1 = $this->m_laporan->laporan_penjualan_kasir_cara_bayar($tanggal1, $tanggal2, $cara_bayar)->result_array();


		$cara_bayar_arr = array();
		$group_cara_bayar_arr = array();

		// $group_cara_bayar2 = $this->m_laporan->group_by_table('tbl_jual', 'jual_keterangan2', "jual_keterangan");
		// $group_cara_bayar1 = $this->m_laporan->group_by_table('tbl_jual', 'jual_keterangan', "jual_keterangan");
		$group_cara_bayar2 = $this->_group_by($data1, 'jual_keterangan2');
		$group_cara_bayar1 = $this->_group_by($data1, 'jual_keterangan');
		$group_cara_bayar_arr = array_merge($group_cara_bayar1, $group_cara_bayar2);
		// $group_cara_bayar_arr =  $this->remove_parent_array(array_unique($group_cara_bayar_arr, SORT_REGULAR));

		foreach ($group_cara_bayar_arr as $idx => $byr) {
			$cara_bayar_std = new stdClass();
			$cara_bayar_std->bayar = $byr;
			$cara_bayar_std->items  = $this->m_laporan->laporan_penjualan_kasir_cara_bayar($tanggal1, $tanggal2, $byr)->result_array();
			array_push($cara_bayar_arr, $cara_bayar_std);
		}

		$x['data1'] = $cara_bayar_arr;


		// End Section Cara Bayar

		// Section Kategori Barang

		$data = $this->m_laporan->laporan_penjualan_kasir_kategori_barang($tanggal1, $tanggal2, $kategori_barang)->result_array();

		$katbar_arr = array();
		$group_kat_bar = $this->_group_by($data, 'd_jual_barang_kat_id');

		foreach ($group_kat_bar as $idx => $kat_bar) {
			$kat_brg = new stdClass();
			$kat_brg->kategori = $kat_bar == 0 ? "unknown" : $this->m_kategori->getKategoriById($kat_bar)->kategori_nama;
			$kat_brg->items  = $this->m_laporan->laporan_penjualan_kasir_kategori_barang($tanggal1, $tanggal2, $kat_bar)->result_array();
			array_push($katbar_arr, $kat_brg);
		}

		$x['data2'] = $katbar_arr;

		// End Section Kategori Barang

		// Section Kategori Barang

		$data3 = $this->m_laporan->laporan_penjualan_kasir_barang($tanggal1, $tanggal2, $nama_barang)->result_array();

		$brg_arr = array();
		$group_bar = $this->_group_by($data3, 'd_jual_barang_nama');

		foreach ($group_bar as $idx => $brg) {
			$brg_item = new stdClass();
			$brg_item->barang = $brg;
			$brg_item->items  = $this->m_laporan->laporan_penjualan_kasir_kategori_barang($tanggal1, $tanggal2, $brg)->result_array();
			array_push($brg_arr, $brg_item);
		}

		$x['data3'] = $brg_arr;

		// End Section Barang

		$x['nama'] = $nama_customer;
		$x['nama_customer'] = $this->m_customer->dariNama($nama_customer);

		// $x['jml'] = $this->m_laporan->get_data__total_jual_periode($tanggal1, $tanggal2, $nama_customer, $nama_barang);
		// $x['data'] = $this->m_laporan->get_data_jual_periode($tanggal1, $tanggal2, $nama_customer, $nama_barang);
		$this->load->view('laporan/penjualan_per_periode/cetak', $x);
	}
	function laporan_penjualan_kasir_dp()
	{
		$tanggal1 = $this->input->post('tgl1');
		$tanggal2 = $this->input->post('tgl2');
		$nama_customer = $this->input->post('nama_customer');
		$nama_barang = $this->input->post('nama_barang');
		$kategori_barang = $this->input->post('kategori_barang');

		$x['tanggal1'] = $this->input->post('tgl1');
		$x['tanggal2'] = $this->input->post('tgl2');



		// Tampilkan
		if ($this->input->post('percustomer') != false) {
			$percustomer = 1;
		} else {
			$percustomer = 0;
		}
		if ($this->input->post('perkatbarang') != false) {
			$perkatbarang = 1;
		} else {
			$perkatbarang = 0;
		}
		if ($this->input->post('perbarang') != false) {
			$perbarang = 1;
		} else {
			$perbarang = 0;
		}
		

		$x['percustomer'] = $percustomer;
		$x['perkatbarang'] = $perkatbarang;
		$x['perbarang'] = $perbarang;

		// end

		$x['tanggal1'] = $this->input->post('tgl1');
		$x['tanggal2'] = $this->input->post('tgl2');

		// Customer Section

		$data = $this->m_laporan->get_penjualan_dp($tanggal1, $tanggal2, $nama_customer,$nama_barang)->result_array();

		$customer_arr = array();
		$group_cust = $this->_group_by($data, 'no_hp');
		$group_nama = $this->_group_by($data, 'nama');

		foreach ($group_cust as $idx => $cust) {
			$customer = new stdClass();
			$customer->nama = $group_nama[$idx];
			$customer->no_hp = $cust;
			$customer->items  = $this->m_laporan->get_penjualan_dp($tanggal1, $tanggal2, $nama_customer,$nama_barang)->result_array();
			array_push($customer_arr, $customer);
		}

		$x['data'] = $customer_arr;

		// End Section Customer

		

		// Section Kategori Barang

		$data = $this->m_laporan->get_penjualan_dp($tanggal1, $tanggal2, $nama_customer,$nama_barang,$kategori_barang)->result_array();

		$katbar_arr = array();
		$group_kat_bar = $this->_group_by($data, 'd_jual_barang_kat_id');

		foreach ($group_kat_bar as $idx => $kat_bar) {
			$kat_brg = new stdClass();
			$kat_brg->kategori = $kat_bar == 0 ? "unknown" : $this->m_kategori->getKategoriById($kat_bar)->kategori_nama;
			$kat_brg->items  = $this->m_laporan->get_penjualan_dp($tanggal1, $tanggal2, $nama_customer,$nama_barang,$kat_bar)->result_array();
			array_push($katbar_arr, $kat_brg);
		}

		$x['data2'] = $katbar_arr;

		// End Section Kategori Barang

		// Section Kategori Barang

		$data3 = $this->m_laporan->get_penjualan_dp($tanggal1, $tanggal2, $nama_customer,$nama_barang)->result_array();

		$brg_arr = array();
		$group_bar = $this->_group_by($data3, 'd_jual_barang_nama');

		foreach ($group_bar as $idx => $brg) {
			$brg_item = new stdClass();
			$brg_item->barang = $brg;
			$brg_item->items  = $this->m_laporan->get_penjualan_dp($tanggal1, $tanggal2, $nama_customer,$brg)->result_array();
			array_push($brg_arr, $brg_item);
		}

		$x['data3'] = $brg_arr;

		// End Section Barang


		$x['nama'] = $nama_customer;
		$x['nama_customer'] = $this->m_customer->dariNama($nama_customer);



		$x['jml'] = $this->m_laporan->get_total_penjualan_dp($tanggal1, $tanggal2, $nama_customer, $nama_barang);
		// $x['data'] = $this->m_laporan->get_penjualan_dp($tanggal1, $tanggal2, $nama_customer, $nama_barang);
		$this->load->view('laporan/penjualan_kasir_dp/cetak', $x);
	}
	function penjualan_cabang()
	{
		$tanggal1 = $this->input->post('tgl1');
		$tanggal2 = $this->input->post('tgl2');
		$cabang = $this->input->post('cabang');
		$nama_barang = $this->input->post('nama_barang');
		$kat_barang = $this->input->post('kat_barang');

		$x['tanggal1'] = $this->input->post('tgl1');
		$x['tanggal2'] = $this->input->post('tgl2');
		$x['cabang'] = $this->input->post('cabang');
		$x['barang'] = $nama_barang;

		// Tampilkan
		if ($this->input->post('percabang') != false) {
			$percabang = 1;
		} else {
			$percabang = 0;
		}
		if ($this->input->post('perkatbarang') != false) {
			$perkatbarang = 1;
		} else {
			$perkatbarang = 0;
		}
		if ($this->input->post('perbarang') != false) {
			$perbarang = 1;
		} else {
			$perbarang = 0;
		}
		

		$x['percabang'] = $percabang;
		$x['perkatbarang'] = $perkatbarang;
		$x['perbarang'] = $perbarang;



		// Penjualan Cabang
		$data1 =  $this->m_laporan->get_penjualan_cabang($tanggal1, $tanggal2, $cabang, $nama_barang)->result_array();
		
		$cabang_arr = array();
		$group_cabang = $this->_group_by($data1, 'cabang');

		foreach ($group_cabang as $idx => $cbg) {
			$cbg_item = new stdClass();
			$cbg_item->cabang = $cbg;
			$cbg_item->items  = $this->m_laporan->get_penjualan_cabang($tanggal1, $tanggal2, $cbg, $nama_barang)->result_array();
			array_push($cabang_arr, $cbg_item);
		}

		$x["data1"] = $cabang_arr;

		// Penjualan Barang
		$data2 =  $this->m_laporan->get_penjualan_cabang($tanggal1, $tanggal2, $cabang, $nama_barang)->result_array();
		$barang_arr = array();
		$group_barang = $this->_group_by($data2, 'd_jual_barang_nama');
		foreach ($group_barang as $idx => $brg) {
			$cbg = new stdClass();
			$cbg->barang = $brg;
			$cbg->items  = $this->m_laporan->get_penjualan_cabang($tanggal1, $tanggal2, $cabang, $brg)->result_array();
			array_push($barang_arr, $cbg);
		}

		$x["data2"] = $barang_arr;


		// Penjualan Kategori
		$data3 =  $this->m_laporan->get_penjualan_cabang($tanggal1, $tanggal2, $cabang, $nama_barang,$kat_barang)->result_array();
		$katbar_arr = array();
		$group_kat_barang = $this->_group_by($data2, 'd_jual_barang_kat_id');
		foreach ($group_kat_barang as $idx => $kat_brg) {
			$katbar = new stdClass();
			$katbar->kategori =  $kat_brg == 0 ? "unknown" : $this->m_kategori->getKategoriById($kat_brg)->kategori_nama;
			$katbar->items  = $this->m_laporan->get_penjualan_cabang($tanggal1, $tanggal2,  $cabang, $nama_barang,$kat_brg)->result_array();
			array_push($katbar_arr, $katbar);
		}

		$x["data3"] = $katbar_arr;

		

		
		$x['jml'] = $this->m_laporan->get_total_penjualan_cabang($tanggal1, $tanggal2, $cabang, $nama_barang);
		$this->load->view('laporan/penjualan_cabang/cetak', $x);
	}
	function laporan_pembelian()
	{
		$tanggal1 = $this->input->post('tgl1');
		$tanggal2 = $this->input->post('tgl2');
		$supplier = $this->input->post('supplier');
		$nama_barang = $this->input->post('nama_barang');
		$x['tanggal1'] = $this->input->post('tgl1');
		$x['tanggal2'] = $this->input->post('tgl2');
		$x['sup'] = $supplier;
		$x['supplier'] = $this->m_suplier->rowSupplier($supplier);
		$x['jml'] = $this->m_laporan->get_pembelian_total($tanggal1, $tanggal2, $supplier, $nama_barang);
		$x['data'] = $this->m_laporan->get_pembelian($tanggal1, $tanggal2, $supplier, $nama_barang);
		$this->load->view('laporan/pembelian/cetak', $x);
	}
	function penjualan_kwitansi()
	{
		$tanggal1 = $this->input->post('tgl1');
		$tanggal2 = $this->input->post('tgl2');
		$x['tanggal1'] = $this->input->post('tgl1');
		$x['tanggal2'] = $this->input->post('tgl2');
		$x['total'] = $this->m_laporan->get_penjualan_kwitansi_total($tanggal1, $tanggal2);
		$x['data'] = $this->m_laporan->get_penjualan_kwitansi($tanggal1, $tanggal2);
		$this->load->view('laporan/penjualan_kwitansi/cetak', $x);
	}

	function lap_penjualan_barang()
	{

		$barang = $this->input->post('barang', TRUE);
		$x['barang'] = $this->input->post('barang', TRUE);
		$x['data'] = $this->m_laporan->get_data_jual_barang($barang);
		$data['title'] = 'Laporan';
		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('template/topbar', $data);
		$this->load->view('laporan/penjualan_per_barang/index', $x);
		$this->load->view('template/footer', $data);
	}

	function lap_penjualan_barang_cetak()
	{

		$barang = $this->input->post('barang', TRUE);
		$x['barang'] = $this->input->post('barang', TRUE);

		$x['data'] = $this->m_laporan->get_data_jual_barang($barang);
		$this->load->view('laporan/penjualan_per_barang/cetak', $x);
	}

	function lap_penjualan_kat_barang()
	{
		$kat_barang = $this->input->post('kat_barang', TRUE);
		$x['kat_barang'] = $this->input->post('kat_barang', TRUE);

		$x['data'] = $this->m_laporan->get_data_jual_kat_barang($kat_barang);
		$data['title'] = 'Laporan';
		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('template/topbar', $data);
		$this->load->view('laporan/penjualan_per_kategori/index', $x);
		$this->load->view('template/footer', $data);
	}
	function lap_penjualan_kat_barang_cetak()
	{
		$kat_barang = $this->input->post('kat_barang', TRUE);
		$x['kat_barang'] = $this->input->post('kat_barang', TRUE);

		$x['data'] = $this->m_laporan->get_data_jual_kat_barang($kat_barang);
		$this->load->view('laporan/penjualan_per_kategori/cetak', $x);
	}

	function lap_laba_rugi()
	{
		$tanggal1 = $this->input->post('tgl1');
		$tanggal2 = $this->input->post('tgl2');

		$x['tanggal1'] = $this->input->post('tgl1');
		$x['tanggal2'] = $this->input->post('tgl2');

		$x['jml'] = $this->m_laporan->get_total_lap_laba_rugi($tanggal1, $tanggal2);
		$x['data'] = $this->m_laporan->get_lap_laba_rugi($tanggal1, $tanggal2);
		$data['title'] = 'Laporan';
		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('template/topbar', $data);
		$this->load->view('laporan/laporan_laba_rugi/index', $x);
		$this->load->view('template/footer', $data);
	}

	function lap_laba_rugi_cetak()
	{
		$tanggal1 = $this->input->post('tgl1');
		$tanggal2 = $this->input->post('tgl2');

		$x['tanggal1'] = $this->input->post('tgl1');
		$x['tanggal2'] = $this->input->post('tgl2');

		$x['jml'] = $this->m_laporan->get_total_lap_laba_rugi($tanggal1, $tanggal2);
		$x['data'] = $this->m_laporan->get_lap_laba_rugi($tanggal1, $tanggal2);
		$this->load->view('laporan/laporan_laba_rugi/cetak', $x);
	}


	function lap_resume()
	{
		$start = $this->input->post('tgl1');
		$end = $this->input->post('tgl2');

		$SQL = "SELECT SUM(jual_total) AS total, jual_keterangan FROM tbl_jual 
WHERE jual_tanggal BETWEEN $start AND $end
GROUP BY jual_keterangan";

		$x['tanggal1'] = $this->input->post('tgl1');
		$x['tanggal2'] = $this->input->post('tgl2');
		$data['title'] = 'Laporan';
		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('template/topbar', $data);
		$this->load->view('laporan/resume/index', $x);
		$this->load->view('template/footer', $data);
	}
	function lap_resume_cetak()
	{
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		$data['saldo'] = $this->input->post('saldo');
		$data['start'] = $start;
		$data['end'] = $end;
		$data['getPenjualan'] = $this->m_laporan->queryResume($start, $end);
		$data['cashKasir'] = $this->m_laporan->queryResumeCash($start, $end);
		$data['pengeluaran'] = $this->m_laporan->queryPengeluaran($start, $end);

		$this->load->view('laporan/resume/cetak', $data);
	}

	function lap_hutang_karyawan()
	{

		$x['data'] = $this->m_laporan->get_lap_hutang_karyawan();
		$data['title'] = 'Laporan';
		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('template/topbar', $data);
		$this->load->view('laporan/hutang_karyawan/index', $x);
		$this->load->view('template/footer', $data);
	}
	function lap_hutang_karyawan_cetak()
	{

		$x['data'] = $this->m_laporan->get_lap_hutang_karyawan();
		$this->load->view('laporan/hutang_karyawan/cetak', $x);
	}

	function lap_pengeluaran_toko()
	{
		$tanggal1 = $this->input->post('tgl1');
		$tanggal2 = $this->input->post('tgl2');

		$x['tanggal1'] = $this->input->post('tgl1');
		$x['tanggal2'] = $this->input->post('tgl2');

		$x['data'] = $this->m_laporan->get_laporan_pengeluaran($tanggal1, $tanggal2);
		$data['title'] = 'Laporan';
		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('template/topbar', $data);
		$this->load->view('laporan/pengeluaran_toko/index', $x);
		$this->load->view('template/footer', $data);
	}

	function lap_pengeluaran_toko_cetak()
	{
		$tanggal1 = $this->input->post('tgl1');
		$tanggal2 = $this->input->post('tgl2');

		$x['tanggal1'] = $this->input->post('tgl1');
		$x['tanggal2'] = $this->input->post('tgl2');

		$x['data'] = $this->m_laporan->get_laporan_pengeluaran($tanggal1, $tanggal2);
		$this->load->view('laporan/pengeluaran_toko/cetak', $x);
	}
}

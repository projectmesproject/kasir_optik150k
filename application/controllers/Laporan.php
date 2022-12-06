<?php
class Laporan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('m_kategori');
		$this->load->model('m_barang');
		$this->load->model('m_suplier');
		$this->load->model('m_pembelian');
		$this->load->model('m_penjualan');
		$this->load->model('m_laporan');
		$this->load->model('m_karyawan');
	}

	function index()
	{

		$data['title'] = 'Laporan';
		$data['data'] = $this->m_barang->tampil_barang();
		$data['listBarang'] = $this->m_barang->listBarang();
		$data['kat'] = $this->m_kategori->tampil_kategori();
		$data['karyawan'] = $this->m_karyawan->tampil_karyawan();

		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('template/topbar', $data);
		$this->load->view('laporan/index', $data);
		$this->load->view('template/footer', $data);
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

	function lap_penjualan_periode_cetak()
	{
		$tanggal1 = $this->input->post('tgl1');
		$tanggal2 = $this->input->post('tgl2');
		$nama_barang = $this->input->post('nama_barang');

		$x['tanggal1'] = $this->input->post('tgl1');
		$x['tanggal2'] = $this->input->post('tgl2');
		$x['nama_barang'] = $this->input->post('nama_barang');

		$x['jml'] = $this->m_laporan->get_data__total_jual_periode($tanggal1, $tanggal2, $nama_barang);
		$x['data'] = $this->m_laporan->get_data_jual_periode($tanggal1, $tanggal2, $nama_barang);
		$this->load->view('laporan/penjualan_per_periode/cetak', $x);
	}
	function penjualan_cabang()
	{
		$tanggal1 = $this->input->post('tgl1');
		$tanggal2 = $this->input->post('tgl2');
		$nama_barang = $this->input->post('nama_barang');

		$x['tanggal1'] = $this->input->post('tgl1');
		$x['tanggal2'] = $this->input->post('tgl2');
		$x['nama_barang'] = $this->input->post('nama_barang');

		$x['jml'] = $this->m_laporan->get_total_penjualan_barang($tanggal1, $tanggal2, $nama_barang);
		$x['data'] = $this->m_laporan->get_penjualan_cabang($tanggal1, $tanggal2, $nama_barang);
		$this->load->view('laporan/penjualan_cabang/cetak', $x);
	}
	function laporan_pembelian()
	{
		$tanggal1 = $this->input->post('tgl1');
		$tanggal2 = $this->input->post('tgl2');
		$nama_barang = $this->input->post('nama_barang');
		$x['tanggal1'] = $this->input->post('tgl1');
		$x['tanggal2'] = $this->input->post('tgl2');
		$x['nama_barang'] = $this->input->post('nama_barang');
		$x['jml'] = $this->m_laporan->get_pembelian_total($tanggal1, $tanggal2, $nama_barang);
		$x['data'] = $this->m_laporan->get_pembelian($tanggal1, $tanggal2, $nama_barang);
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
		$data['getPenjualan'] = $this->m_laporan->penjualan_by_metode($start, $end);
		$data['total'] = $this->m_laporan->total_penjualan($start, $end);

		$this->load->view('laporan/resume/cetak', $data);
		// var_dump($data['getPenjualan']);
		// die;
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

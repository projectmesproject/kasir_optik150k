<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_kategori');
		$this->load->model('m_barang');
		$this->load->model('m_suplier');
		$this->load->model('m_pembelian');
	}

	public function index()
	{
		$data['title'] = 'Pembelian';
		$data['sup'] = $this->m_suplier->tampil_suplier();

		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('template/topbar', $data);
		$this->load->view('pembelian/index', $data);
		$this->load->view('template/footer', $data);
	}

	function get_barang()
	{

		$kobar = $this->input->post('kode_brg');
		$x['brg'] = $this->m_barang->get_barang1($kobar);
		$this->load->view('pembelian/detail_barang_beli', $x);
	}

	function add_to_cart()
	{

		$nofak = $this->input->post('nofak');
		$tgl = $this->input->post('tgl');
		$suplier = $this->input->post('suplier');
		$this->session->set_userdata('nofak', $nofak);
		$this->session->set_userdata('tglfak', $tgl);
		$this->session->set_userdata('suplier', $suplier);
		$kobar = $this->input->post('kode_brg');
		$produk = $this->m_barang->get_barang1($kobar);
		$i = $produk->row_array();
		$data = array(
			'id'       => $i['barang_id'],
			'name'     => $i['barang_nama'],
			'satuan'   => $i['barang_satuan'],
			'price'    => $this->input->post('harpok'),
			'harga'    => $this->input->post('harjul'),
			'qty'      => $this->input->post('jumlah')
		);
		$this->cart->insert($data);
		// print_r($this->cart->contents());
		// print_r($data);
		// exit();
		redirect('pembelian');
	}

	function remove()
	{

		$row_id = $this->uri->segment(3);
		$this->cart->update(array(
			'rowid'      => $row_id,
			'qty'     => 0
		));
		redirect('pembelian');
	}

	function simpan_pembelian()
	{

		$nofak = $this->m_pembelian->get_kobel();
		$tglfak = $this->session->userdata('tglfak');
		$suplier = $this->session->userdata('suplier');
		if (!empty($nofak) && !empty($tglfak) && !empty($suplier)) {
			$beli_kode = $this->m_pembelian->get_kobel();
			$order_proses = $this->m_pembelian->simpan_pembelian($nofak, $tglfak, $suplier);
			if ($order_proses) {
				$this->cart->destroy();
				$this->session->unset_userdata('nofak');
				$this->session->unset_userdata('tglfak');
				$this->session->unset_userdata('suplier');
				echo $this->session->set_flashdata('msg', 'Berhasil !');
				redirect('pembelian');
			} else {
				redirect('pembelian');
			}
		} else {
			echo $this->session->set_flashdata('error', 'di Simpan ! Mohon Periksa Kembali Semua Inputan Anda !!!');
			redirect('pembelian');
		}
	}
	public function get_barang_autocomplete()
	{
		$result = $this->m_barang->getBarangList();
		$html = "";
		if (count($result) > 0) {

			foreach ($result as $v) {
				// $response[] = array("value"=>$v['value'],"label"=>$v['label']);
				$html .= "<li class='item_barang' data-value='$v[value]'>$v[label]</li>";
			}
		} else {
			$html .= "<li data-value='tambah_barang' class='item_barang'>(+) Tambah Data Barang</li>";
		}

		echo $html;
	}
	public function get_kode_barang_autocomplete()
	{
		$result = $this->m_barang->getKodeBarangList();
		$html = "";
		if (count($result) > 0) {

			foreach ($result as $v) {
				// $response[] = array("value"=>$v['value'],"label"=>$v['label']);
				$html .= "<li class='item_barang' data-value='$v[value]'>$v[label]</li>";
			}
		} else {
			$html .= "<li data-value='tambah_barang' class='item_barang'>(+) Tambah Data Barang</li>";
		}

		echo $html;
	}
}

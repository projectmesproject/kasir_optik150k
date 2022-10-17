<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{


	function __construct()
	{
		parent::__construct();

		$this->load->model('m_kategori');
		$this->load->model('m_barang');
		///$this->load->library('barcode');
	}

	public function index()
	{
		$data['title'] = "Barang";
		$data['data'] = $this->m_barang->tampil_barang();
		$data['kat'] = $this->m_kategori->tampil_kategori();
		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('template/topbar', $data);
		$this->load->view('barang/index', $data);
		$this->load->view('template/footer', $data);
	}


	function tambah_barang()
	{
		//  Cek jika ada gambar yang ingin di upload
		$upload_image = $_FILES['image']['name'];

		if ($upload_image) {
			$config['allowed_types'] = 'jpeg|jpg|png';
			$config['max_size']    = 700;
			$config['upload_path'] = './assets/upload/';

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('image')) {
				$new_image = $this->upload->data('file_name');
				$this->m_barang->tambah_barang($new_image);
			} else {
				$this->session->set_flashdata('msg2', 'Gagal ditambahkan, photo tidak sesuai ketentuan');
				redirect('barang');
			}
		} else {
			$a = '-';
			$this->m_barang->tambah_barang($a);
		}

		$this->session->set_flashdata('msg', 'Berhasil ditambahkan');

		// $this->m_barang->tambah_barang();
		// $this->session->set_flashdata('msg','Berhasil');
		redirect('barang');
	}


	public function edit_barang1()
	{
		$id = $this->input->post('id');

		$data = $this->m_barang->GetById($id)->row();

		if ($_FILES and $_FILES['image']['name']) {
			$config['upload_path'] = './assets/upload/';
			$config['allowed_types'] = 'jpeg|png|jpg';
			$config['max_size'] = 700;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('image')) {
				$this->session->set_flashdata('msg2', 'Gagal Edit !!');
				redirect('barang');
			} else {
				unlink('assets/upload/' . $data->image);

				$file = $this->upload->data();
				$id = $this->input->post('id');
				$dataku = array(
					'barang_nama' => $this->input->post('nabar'),
					'barang_satuan' => $this->input->post('satuan'),
					'barang_harpok' => $this->input->post('harpok'),
					'barang_harjul' => $this->input->post('harjul'),
					'barang_stok' => $this->input->post('stok'),
					'barang_min_stok' => $this->input->post('min_stok'),
					'barang_kategori_id' => $this->input->post('kategori'),
					'serial_number' => $this->input->post('sn'),
					'image' => $file['file_name'],
				);

				$this->m_barang->UpdateGambar($id, $dataku);
			}
		} else {
			$id = $this->input->post('id');
			$dataku = array(
				'barang_nama' => $this->input->post('nabar'),
				'barang_satuan' => $this->input->post('satuan'),
				'barang_harpok' => $this->input->post('harpok'),
				'barang_harjul' => $this->input->post('harjul'),
				'barang_stok' => $this->input->post('stok'),
				'barang_min_stok' => $this->input->post('min_stok'),
				'barang_kategori_id' => $this->input->post('kategori'),
				'serial_number' => $this->input->post('sn'),
			);

			$this->m_barang->UpdateGambar($id, $dataku);
		}
		$this->session->set_flashdata('msg', 'Berhasil Edit !!');
		redirect('barang');
	}


	function hapus_barang()
	{

		$id = $this->input->post('barang_id');
		$this->m_barang->hapus_barang($id);
		$this->session->set_flashdata('msg', 'Berhasil');
		redirect('barang');
	}
}

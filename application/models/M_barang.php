<?php
class M_barang extends CI_Model
{


	public function tampil_barang()
	{
		$this->db->select('*');
		$this->db->from('tbl_barang');
		$this->db->limit(10);
		$this->db->order_by('barang_id', "DESC");
		$this->db->join('tbl_kategori', 'tbl_kategori.kategori_id=tbl_barang.barang_kategori_id');

		$query = $this->db->get();

		return $query;
	}


	public function tambah_barang($gambar)
	{

		if ($gambar == '-') {
			$data = array(

				"barang_id" => $this->m_barang->get_kobar(),
				"barang_nama" => $this->input->post('nabar'),
				"barang_satuan" => $this->input->post('satuan'),
				"barang_harpok" => str_replace(',', '', $this->input->post('harpok')),
				"barang_harjul" => str_replace(',', '', $this->input->post('harjul')),
				"barang_stok" => $this->input->post('stok'),
				"barang_min_stok" => $this->input->post('min_stok'),
				"barang_kategori_id"  => $this->input->post('kategori'),
				"serial_number"  => $this->input->post('sn'),
			);
		} else {
			$data = array(

				"barang_id" => $this->m_barang->get_kobar(),
				"barang_nama" => $this->input->post('nabar'),
				"barang_satuan" => $this->input->post('satuan'),
				"barang_harpok" => str_replace(',', '', $this->input->post('harpok')),
				"barang_harjul" => str_replace(',', '', $this->input->post('harjul')),
				"barang_stok" => $this->input->post('stok'),
				"barang_min_stok" => $this->input->post('min_stok'),
				"barang_kategori_id"  => $this->input->post('kategori'),
				"serial_number"  => $this->input->post('sn'),
				"image" => $gambar
			);
		}



		$this->db->insert('tbl_barang', $data);
	}

	///baruu
	function get_barang($kobar)
	{
		$this->db->where('barang_nama', $kobar);
		return $this->db->get('tbl_barang');
	}
	///baru	
	function get_barang1($kobar)
	{


		$this->db->where('barang_id', $kobar);
		return $this->db->get('tbl_barang');
	}

	///baruu
	function search_barang($kobar)
	{
		$this->db->like('barang_nama', $kobar, 'both');
		$this->db->order_by('barang_nama', 'ASC');
		$this->db->limit(10);
		return $this->db->get('tbl_barang')->result();
	}

	public function edit_barang($gambar)
	{
		if ($gambar = 'fajar_h30') {
			$data = array(
				"barang_nama" => $_POST['nabar'],
				"barang_satuan" => $_POST['satuan'],
				"barang_harpok" => str_replace(',', '', $_POST['harpok']),
				"barang_harjul" => str_replace(',', '', $_POST['harjul']),
				"barang_stok" => $_POST['stok'],
				"barang_min_stok" => $_POST['min_stok'],
				"barang_kategori_id"  => $_POST['kategori'],
				"serial_number"  => $_POST['sn']
			);
		} else {
			$data = array(
				"barang_nama" => $_POST['nabar'],
				"barang_satuan" => $_POST['satuan'],
				"barang_harpok" => str_replace(',', '', $_POST['harpok']),
				"barang_harjul" => str_replace(',', '', $_POST['harjul']),
				"barang_stok" => $_POST['stok'],
				"barang_min_stok" => $_POST['min_stok'],
				"barang_kategori_id"  => $_POST['kategori'],
				"serial_number"  => $_POST['sn'],
				"image" => $gambar
			);
		}

		$this->db->where('barang_id', $_POST['barang_id']);
		$this->db->update('tbl_barang', $data);
	}

	public function hapus_barang($id)
	{
		$this->db->where('barang_id', $id);
		$query = $this->db->get('tbl_barang');
		$row = $query->row();

		unlink("./assets/upload/$row->image");

		$this->db->delete('tbl_barang', array('barang_id' => $id));
	}

	function get_kobar()
	{
		$q = $this->db->query("SELECT MAX(RIGHT(barang_id,6)) AS kd_max FROM tbl_barang");
		$kd = "";
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $k) {
				$tmp = ((int)$k->kd_max) + 1;
				$kd = sprintf("%06s", $tmp);
			}
		} else {
			$kd = "000001";
		}
		return "BR" . $kd;
	}

	public function GetById($id)
	{
		return $this->db->get_where('tbl_barang', array('id' => $id));
	}

	public function getBarangPaket()
	{
		$this->db->select('*');
		$this->db->from('tbl_barang');
		$this->db->like('barang_id', "PKT");
		return $this->db->get()->result();
	}

	public function UpdateGambar($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('tbl_barang', $data);
	}

	// ahmad updated
	public function getToExcel()
	{
		$this->db->select('*');
		$this->db->from('tbl_barang');
		// $this->db->limit(10);
		$this->db->join('tbl_kategori', 'tbl_kategori.kategori_id=tbl_barang.barang_kategori_id');

		$query = $this->db->get()->result();

		return $query;
	}
	public function addImportToExcel($data)
	{
		return $this->db->insert_batch("tbl_barang", $data);
	}
	public function deleteAll()
	{
		return $this->db->empty_table('tbl_barang');
	}
}

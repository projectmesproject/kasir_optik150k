<?php
class M_barang extends CI_Model
{
	var $table = 'tbl_barang';
	var $primary = 'barang_id';
	var $column_order = array(null, 'barang_id', 'barang_nama', 'barang_satuan', 'barang_harjul', 'barang_stok', 'kategori_nama');
	var $column_search = array('barang_nama');
	var $order = array('barang_id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$nama_barang = $this->input->post('barang_nama');
		$kategori = $this->input->post('kategori_nama');

		if ($kategori) {
			$this->db->where('kategori_nama', $kategori);
		}
		if ($nama_barang) {
			$this->db->where('barang_nama', $nama_barang);
		}
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->order_by($this->primary, "DESC");
		$this->db->join('tbl_kategori', 'tbl_kategori.kategori_id=tbl_barang.barang_kategori_id');

		$i = 0;

		foreach ($this->column_search as $item) // looping awal
		{
			if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
			{

				if ($i === 0) // looping awal
				{
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if (isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}


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

	public function getBarang()
	{
		$this->db->select('*')->from($this->table);
		$query = $this->db->get();
		$return = $query->result();
		return $return;
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
		$q = $this->db->query("SELECT barang_id FROM tbl_barang");
		$kd = "";
		$count = $q->num_rows();
		// if ($q->num_rows() > 0) {
		// 	foreach ($q->result() as $k) {
		// 		$tmp = ((int)$k->kd_max) + 1;
		// 		$kd = sprintf("%06s", $tmp);
		// 	}
		// } else {
		// 	$kd = "000001";
		// }
		$count++;
		$kd = sprintf("%06s", $count);
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

	public function getBarangList()
	{
		$this->db->select('barang_nama as label, CONCAT(barang_harjul, "#", barang_id, "#", barang_satuan, "#", barang_stok) as value');
		$this->db->from('tbl_barang');
		$this->db->like('barang_nama', $this->input->post("search"));
		$dt = $this->db->get()->result_array();
		// $html = "";
		//   foreach($dt as $v ){
		// 		$response[] = array("value"=>$v['value'],"label"=>$v['label']);
		// 		$html .= "<li data-value='$v[value]'>$v[label]</li>";
		// 	}



		// echo json_encode($response);
		return $dt;
	}
}

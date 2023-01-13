<?php
class M_barang_rusak extends CI_Model
{


	public function tampil_barang()
	{
		$this->db->select('*');
		$this->db->from('barang_rusak');
		$this->db->join('tbl_barang', 'tbl_barang.barang_id=barang_rusak.id_barang', "LEFT");

		$query = $this->db->get();

		return $query;
	}

	public function tambah_barang()
	{
		$jmlh = $this->input->post('jumlah');
		$id = $this->input->post('barang');
		$data = array(
			"id_barang" => $this->input->post('barang'),
			"jumlah" => $this->input->post('jumlah'),
			"keterangan" => $this->input->post('ket'),
			"tanggal" => $this->input->post('tgl'),
		);

		$this->db->insert('barang_rusak', $data);
		$this->db->query("update tbl_barang set barang_stok=barang_stok-'$jmlh' where barang_id='$id'");
	}

	public function edit_barang()
	{

		$id_barang_rusak = $_POST['id'];
		$jml = $_POST['jumlah'];
		$id_barang = $this->input->post('barang');
		$data = array(

			"id_barang" => $_POST['barang'],
			"jumlah" => $_POST['jumlah'],
			"keterangan" => $_POST['ket'],
			"tanggal" => $_POST['tgl'],
		);

		$tampung = $this->db->query("select * from barang_rusak where id_rusak='$id_barang_rusak'")->row_array();

		$this->db->where('id_rusak', $_POST['id']);
		$this->db->update('barang_rusak', $data);


		$t = $tampung['jumlah'];


		if ($t > $jml) {
			$angka = $t - $jml;
			$this->db->query("update tbl_barang set barang_stok=barang_stok+'$angka'where barang_id='$id_barang'");
		} else if ($t < $jml) {
			$angka = $jml - $t;
			$this->db->query("update tbl_barang set barang_stok=barang_stok-'$angka' where barang_id='$id_barang'");
		}
	}

	public function hapus_barang($id)
	{
		$tampung = $this->db->query("select * from barang_rusak where id_rusak='$id'")->row_array();
		$angka = $tampung['jumlah'];
		$id_barang = $tampung['id_barang'];

		$this->db->delete('barang_rusak', ['id_rusak' => $id]);
		$this->db->query("update tbl_barang set barang_stok=barang_stok+'$angka' where barang_id='$id_barang'");
	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
	}

	public function getJual()
	{
		$date = date('Y-m-d');
		$data = $this->db->select('*,count(d_jual_qty) as total_qty')->from('tbl_jual')->group_by('d_jual_barang_id')->where('DATE(jual_tanggal)', $date)->join('tbl_detail_jual', 'tbl_detail_jual.d_jual_nofak=tbl_jual.jual_nofak')->get()->result_array();
		ob_start();
?>
		<table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
			<thead class="thead-light">
				<tr>
					<th>Nama Barang</th>
					<th>Qty</th>
				</tr>
			</thead>

			<tbody>
				<?php $i = 1;
				$total = 0; ?>
				<?php foreach ($data as $items) :

					$total += ($items['total_qty']);
				?>

					<tr>
						<td><?= $items['d_jual_barang_nama']; ?></td>
						<td><?= $items['total_qty']; ?></td>

					</tr>

					<?php $i++; ?>
				<?php endforeach; ?>
			</tbody>
			<tfoot class="bg-primary text-white font-weight-bold">
				<tr>
					<td>Total :</td>
					<td><?= $total ?></td>
				</tr>
			</tfoot>
		</table>
<?php
		$konten = ob_get_contents();
		return $konten;
	}

	public function getDataBarang()
	{
		$this->db->select('barang_nama as label, CONCAT(barang_harjul, "#", barang_id, "#", barang_satuan, "#", barang_stok) as value');
		$this->db->from('tbl_barang');
		$this->db->like('barang_nama', $this->input->post("search"));
		$dt = $this->db->get()->result_array();
		$html = "";
		foreach ($dt as $v) {
			$response[] = array("value" => $v['value'], "label" => $v['label']);
			$html .= "<li data-value='$v[value]'>$v[label]</li>";
		}



		echo json_encode($response);
	}


	public function getDataCustomer()
	{
		$this->db->select('barang_nama as label, CONCAT(barang_harjul, "#", barang_id, "#", barang_satuan, "#", barang_stok) as value');
		$this->db->from('tbl_barang');
		$this->db->like('barang_nama', $this->input->post("search"));
		$dt = $this->db->get()->result_array();

		foreach ($dt as $v) {
			$response[] = array("value" => $v['value'], "label" => $v['label']);
		}



		echo json_encode($response);
	}
}

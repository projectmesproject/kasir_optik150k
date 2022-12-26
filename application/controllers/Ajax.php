<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
	}
	public function Saldo()
	{
		$this->session->unset_userdata('saldo');
		$saldo = $this->input->post('saldo');
		$url_base = $this->input->post('url_base');
		// echo '<script>
		// sessionStorage.setItem("saldo", ' . $saldo . ')

		// </script>';
		$this->session->set_userdata(['saldo' => $saldo]);
		// redirect($url_base);
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
						<td><?= ($items['d_jual_barang_nama']); ?></td>
						<td><?= number_format($items['total_qty']); ?></td>
					</tr>
					<?php $i++; ?>
				<?php endforeach; ?>
			</tbody>
			<tfoot class="bg-primary text-white font-weight-bold">
				<tr>
					<td>Total :</td>
					<td><?= number_format($total) ?></td>
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

	public function queryResume($date)
	{
		$this->db->select('*,sum(amount) as total');
		$this->db->from('tbl_resume');
		$this->db->where('DATE(created_at) >=', $date);
		$this->db->where('DATE(created_at) <=', $date);
		// $this->db->where('method_types !=', "Cash");
		$this->db->group_by('method_types');
		$res = $this->db->get()->result_array();
		return $res;
	}
	public function queryResumeCash($date)
	{
		$this->db->select('*,sum(amount) as cash');
		$this->db->from('tbl_resume');
		$this->db->where('DATE(created_at) >=', $date);
		$this->db->where('DATE(created_at) <=', $date);
		$this->db->where('method_types', 'Cash');
		$this->db->group_by('method_types');
		$res = $this->db->get()->row_array();
		return $res;
	}
	public function queryPengeluaran($date)
	{
		$this->db->select('*,sum(nominal) as pengeluaran');
		$this->db->from('pengeluaran');
		$this->db->where('DATE(tanggal) >=', $date);
		$this->db->where('DATE(tanggal) <=', $date);
		$res = $this->db->get()->row();
		return $res;
	}
	public function getResume()
	{
		$date = date('Y-m-d');
		$saldo = $this->session->userdata('saldo');
		$queryPengeluaran = $this->queryPengeluaran($date);
		$queryCash = $this->queryResumeCash($date);
		$query = $this->queryResume($date);
		$res = new stdClass();
		$res->saldo = number_format($saldo);
		ob_start();

	?>
		<input type="hidden" id="saldo_response" value="<?= number_format($saldo) ?>" />
		<table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
			<thead class="thead-light">
				<tr>
					<th style="width:50px;">#</th>
					<th>Metode Pembayaran</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				<?php
				$i = 0;
				$total = 0;
				$no = 1;
				?>
				<?php foreach ($query as $items) :
					$total += $items['total'];
				?>
					<tr>
						<td><?= $no++ ?></td>
						<td><?= ($items['method_types']); ?></td>
						<td><?= number_format($items['total']); ?></td>
					</tr>

					<?php $i++; ?>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr class="bg-danger text-white font-weight-bold">
					<td colspan="2">Pengeluaran </td>
					<td><?= number_format($queryPengeluaran->pengeluaran) ?> </td>
				</tr>
				<tr class="bg-primary text-white font-weight-bold">
					<td colspan="2">Total Di Kasir </td>
					<td><?php
						$wes = 0;
						$wes = $saldo + $queryCash['cash'] - $queryPengeluaran->pengeluaran;
						?> <?= number_format($wes); ?></td>
				</tr>
				<tr class="bg-success text-white font-weight-bold">
					<td colspan="2">Total Keseluruhan Penjualan </td>
					<td><?= number_format($total) ?></td>
				</tr>
			</tfoot>
		</table>
<?php
		// $konten = ob_get_contents();
		// $res->html = $konten;
		// echo json_encode($res);
	}
}

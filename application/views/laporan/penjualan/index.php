<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800">Laporan Penjualan Barang</h1>
	<!-- DataTales Example -->
	<div class="card shadow mb-4">

		<div class="card-body">
			<div class="table-responsive">
				<table border="1" align="center" style="width:900px;margin-bottom:20px;">
					<thead>
					<tr>
						<th style="width:50px;">No</th>
						<th>No Faktur</th>
						<th>Tanggal</th>
						<th>Nama Barang</th>
						<th>Satuan</th>
						<th>Harga Jual</th>
						<th>Qty</th>
						<th>Keterangan</th>
						<th>Total</th>
					</tr>
					</thead>
					<tbody>
					<?php
					$no=0;
					foreach ($data->result_array() as $i) {
						$no++;
						$nofak=$i['jual_nofak'];
						$tgl=$i['jual_tanggal'];
						$barang_nama=$i['d_jual_barang_nama'];
						$barang_satuan=$i['d_jual_barang_satuan'];
						$barang_harjul=$i['d_jual_barang_harjul'];
						$barang_qty=$i['d_jual_qty'];
						$barang_diskon=$i['d_jual_diskon'];
						$barang_total=$i['d_jual_total'];
						?>
						<tr>
							<td style="text-align:center;"><?php echo $no;?></td>
							<td style="padding-left:5px;"><?php echo $nofak;?></td>
							<td style="text-align:center;"><?php echo $tgl;?></td>

							<td style="text-align:left;"><?php echo $barang_nama;?></td>
							<td style="text-align:left;"><?php echo $barang_satuan;?></td>
							<td style="text-align:right;"><?php echo 'Rp '.number_format($barang_harjul);?></td>
							<td style="text-align:center;"><?php echo $barang_qty;?></td>
							<td style="text-align:right;"><?php echo $barang_diskon;?></td>
							<td style="text-align:right;"><?php echo 'Rp '.number_format($barang_total);?></td>
						</tr>
					<?php }?>
					</tbody>
					<tfoot>
					<?php
					$b=$jml->row_array();
					?>
					<tr>
						<td colspan="9" style="text-align:center;"><b>Total</b></td>
						<td style="text-align:right;"><b><?php echo 'Rp '.number_format($b['total']);?></b></td>
					</tr>
					</tfoot>
				</table>

			</div>
		</div>
	</div>

</div>

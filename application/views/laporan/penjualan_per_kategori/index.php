<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800">Laporan Penjualan Pertanggal</h1>
	<!-- DataTales Example -->
	<div class="card shadow mb-4">

		<div class="card-body">
			<div class="table-responsive">
				<div id="laporan">
					<table align="center" style="width:900px; border-bottom:3px double;border-top:none;border-right:none;border-left:none;margin-top:5px;margin-bottom:20px;">
						<!--<tr>
    <td><img src="<?php// echo base_url().'assets/img/kop_surat.png'?>"/></td>
</tr>--><!--- -->
					</table>

					<table border="0" align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:0px;">
						<tr>
							<td colspan="2" style="width:800px;paddin-left:20px;"><center><h4>LAPORAN PENJUALAN BARANG</h4></center><br/></td>
						</tr>

					</table>

					<table border="0" align="center" style="width:900px;border:none;">
						<tr>
							<th style="text-align:left"></th>
						</tr>
					</table>
					<table border="1" align="center" style="width:900px;margin-bottom:20px;">
						<thead>
						<tr>
							<?php $barang_kat_tampung = $this->db->query("select * from tbl_kategori where kategori_id='kat_barang'")->row_array(); ?>
							<th colspan="11" style="text-align:left;">Laporan Per Kategori Barang : <?= $barang_kat_tampung['kategori_nama']; ?> </th>
						</tr>
						<tr>
							<th style="width:50px;">No</th>
							<th>No Faktur</th>
							<th>Tanggal</th>
							<th>Nama Barang</th>
							<th>Satuan</th>
							<th>Harga Jual</th>
							<th>Qty</th>
							<th>Keterangan</th>
							<th>SubTotal</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$no=0;
						$jumlah_total = 0;
						foreach ($data->result_array() as $i) {
							$no++;
							$nofak=$i['jual_nofak'];
							$tgl=$i['jual_tanggal'];
							$nabar=$i['d_jual_barang_nama'];
							$satuan=$i['d_jual_barang_satuan'];
							$harjul=$i['d_jual_barang_harjul'];
							$qty=$i['d_jual_qty'];
							$diskon=$i['d_jual_diskon'];
							$total=$i['d_jual_total'];
							$jumlah_total = $jumlah_total+$total;
							?>
							<tr>
								<td style="text-align:center;"><?php echo $no;?></td>
								<td style="padding-left:5px;"><?php echo $nofak;?></td>
								<td style="text-align:center;"><?php echo $tgl;?></td>
								<td style="text-align:left;"><?php echo $nabar;?></td>
								<td style="text-align:left;"><?php echo $satuan;?></td>
								<td style="text-align:right;"><?php echo 'Rp '.number_format($harjul);?></td>
								<td style="text-align:center;"><?php echo $qty;?></td>
								<td style="text-align:right;"><?php echo $diskon;?></td>
								<td style="text-align:right;"><?php echo 'Rp '.number_format($total);?></td>
							</tr>
						<?php }?>
						</tbody>
						<tfoot>

						<tr>
							<td colspan="8" style="text-align:center;"><b>Total</b></td>
							<td style="text-align:right;"><b><?php echo 'Rp '.number_format($jumlah_total);?></b></td>
						</tr>
						</tfoot>
					</table>
					<table align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:20px;">
						<tr>
							<td></td>
					</table>
				</div>
			</div>
		</div>
	</div>

</div>

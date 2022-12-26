<html lang="en" moznomarginboxes mozdisallowselectionprint>

<head>
    <title>Laporan Penjualan Kasir DP</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/laporan.css') ?>" />
</head>

<body onload="window.print()">
    <div id="laporan">
        <table align="center" style="width:900px; border-bottom:3px double;border-top:none;border-right:none;border-left:none;margin-top:5px;margin-bottom:20px;">

        </table>

        <table border="0" align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:0px;">
            <tr>
                <td colspan="2" style="width:800px;padding-left:20px;">
                    <center>
                        <h4>LAPORAN PENJUALAN KASIR DP</h4>
                    </center><br />
                </td>
            </tr>

        </table>

        <table border="0" align="center" style="width:900px;border:none;">
            <tr>
                <th style="text-align:left"></th>
            </tr>
        </table>
      <!-- Perulangan Customer -->
		<?php if($percustomer){ ?>
		<div class="mt-30">
			<h2 style="text-align: center;">Per Customer</h2>
			<?php
			foreach ($data as $dt) {
				$nama = $dt->nama;

			?>
				<table border="1" align="center" style="width:900px;margin-bottom:20px;">
					<thead>
						<tr>
							<?php if ($nama == "") { ?>
								<th colspan="11" style="text-align:left;">Periode : <?= date('d M Y', strtotime($tanggal1)); ?> - <?= date('d M Y', strtotime($tanggal2)); ?><br></th>
							<?php } else { ?>
								<th colspan="11" style="text-align:left;">Periode : <?= date('d M Y', strtotime($tanggal1)); ?> - <?= date('d M Y', strtotime($tanggal2)); ?><br>Nama Customer / No. Hp : <?= $dt->nama . " - " . $dt->no_hp ?></th>
							<?php } ?>
						</tr>

						<tr>
							<th style="width:50px;">No</th>
							<th>No Faktur</th>
							<th>Customer</th>
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
						$no = 0;
						$data_tes = $dt->items;
						$grandtotal = 0;
						foreach ($data_tes as $idx => $i) {
							$no++;
							$nofak = $i['jual_nofak'];
							$nama = $i['nama'];
							$tgl = $i['jual_tanggal'];
							$nabar = $i['d_jual_barang_nama'];
							$satuan = $i['d_jual_barang_satuan'];
							$harjul = $i['d_jual_barang_harjul'];
							$qty = $i['d_jual_qty'];
							$diskon = $i['d_jual_diskon'];
							$total = $i['d_jual_total'];
							$grandtotal += $total;
						?>
							<tr>
								<td style="text-align:center;"><?php echo $no; ?></td>
								<td style="padding-left:5px;"><?php echo $nofak; ?></td>
								<td style="padding-left:5px;"><?php echo $nama; ?></td>
								<td style="text-align:center;"><?php echo $tgl; ?></td>
								<td style="text-align:left;"><?php echo $nabar; ?></td>
								<td style="text-align:left;"><?php echo $satuan; ?></td>
								<td style="text-align:right;"><?php echo 'Rp ' . number_format($harjul); ?></td>
								<td style="text-align:center;"><?php echo $qty; ?></td>
								<td style="text-align:right;"><?php echo $diskon; ?></td>
								<td style="text-align:right;"><?php echo 'Rp ' . number_format($total); ?></td>
							</tr>
						<?php } ?>
					</tbody>
					<tfoot>

						<tr>
							<td colspan="9" style="text-align:center;"><b>Total</b></td>
							<td style="text-align:right;"><b><?php echo 'Rp ' . number_format($grandtotal); ?></b></td>
						</tr>
					</tfoot>
				</table>

			<?php
			} ?>
		</div>
		<?php } ?>
		<!-- End Perulangan Customer -->


		<!-- Perulangan Kategori -->
		<?php if($perkatbarang){ ?>
		<div class="mt-30">
			<h2 style="text-align: center;">Per Kategori Barang</h2>
			<?php
			foreach ($data2 as $dt) {
				$kategori = $dt->kategori;

			?>
				<table border="1" align="center" style="width:900px;margin-bottom:20px;">
					<thead>
						<tr>
							<?php if ($kategori == "") { ?>
								<th colspan="11" style="text-align:left;">Periode : <?= date('d M Y', strtotime($tanggal1)); ?> - <?= date('d M Y', strtotime($tanggal2)); ?><br></th>
							<?php } else { ?>
								<th colspan="11" style="text-align:left;">Periode : <?= date('d M Y', strtotime($tanggal1)); ?> - <?= date('d M Y', strtotime($tanggal2)); ?><br>Kategori : <?= $kategori ?></th>
							<?php } ?>
						</tr>

						<tr>
							<th style="width:50px;">No</th>
							<th>No Faktur</th>
							<th>Customer</th>
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
						$no = 0;
						$data_tes = $dt->items;
						$grandtotal = 0;
						foreach ($data_tes as $idx => $i) {
							$no++;
							$nofak = $i['jual_nofak'];
							$nama = $i['nama'];
							$tgl = $i['jual_tanggal'];
							$nabar = $i['d_jual_barang_nama'];
							$satuan = $i['d_jual_barang_satuan'];
							$harjul = $i['d_jual_barang_harjul'];
							$qty = $i['d_jual_qty'];
							$diskon = $i['d_jual_diskon'];
							$total = $i['d_jual_total'];
							$grandtotal += $total;
						?>
							<tr>
								<td style="text-align:center;"><?php echo $no; ?></td>
								<td style="padding-left:5px;"><?php echo $nofak; ?></td>
								<td style="padding-left:5px;"><?php echo $nama; ?></td>
								<td style="text-align:center;"><?php echo $tgl; ?></td>
								<td style="text-align:left;"><?php echo $nabar; ?></td>
								<td style="text-align:left;"><?php echo $satuan; ?></td>
								<td style="text-align:right;"><?php echo 'Rp ' . number_format($harjul); ?></td>
								<td style="text-align:center;"><?php echo $qty; ?></td>
								<td style="text-align:right;"><?php echo $diskon; ?></td>
								<td style="text-align:right;"><?php echo 'Rp ' . number_format($total); ?></td>
							</tr>
						<?php } ?>
					</tbody>
					<tfoot>

						<tr>
							<td colspan="9" style="text-align:center;"><b>Total</b></td>
							<td style="text-align:right;"><b><?php echo 'Rp ' . number_format($grandtotal); ?></b></td>
						</tr>
					</tfoot>
				</table>

			<?php
			} ?>
		</div>
		<?php } ?>
		<!-- End Perulangan Kategori -->

		<!-- Perulangan Barang -->
		<?php if($perbarang){ ?>
		<div class="mt-30">
			<h2 style="text-align: center;">Per Barang</h2>
			<?php
			foreach ($data3 as $dt) {
				$barang = $dt->barang;

			?>
				<table border="1" align="center" style="width:900px;margin-bottom:20px;">
					<thead>
						<tr>
							<?php if ($barang == "") { ?>
								<th colspan="11" style="text-align:left;">Periode : <?= date('d M Y', strtotime($tanggal1)); ?> - <?= date('d M Y', strtotime($tanggal2)); ?><br></th>
							<?php } else { ?>
								<th colspan="11" style="text-align:left;">Periode : <?= date('d M Y', strtotime($tanggal1)); ?> - <?= date('d M Y', strtotime($tanggal2)); ?><br>Kategori : <?= $barang ?></th>
							<?php } ?>
						</tr>

						<tr>
							<th style="width:50px;">No</th>
							<th>No Faktur</th>
							<th>Customer</th>
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
						$no = 0;
						$data_tes = $dt->items;
						$grandtotal = 0;
						foreach ($data_tes as $idx => $i) {
							$no++;
							$nofak = $i['jual_nofak'];
							$nama = $i['nama'];
							$tgl = $i['jual_tanggal'];
							$nabar = $i['d_jual_barang_nama'];
							$satuan = $i['d_jual_barang_satuan'];
							$harjul = $i['d_jual_barang_harjul'];
							$qty = $i['d_jual_qty'];
							$diskon = $i['d_jual_diskon'];
							$total = $i['d_jual_total'];
							$grandtotal += $total;
						?>
							<tr>
								<td style="text-align:center;"><?php echo $no; ?></td>
								<td style="padding-left:5px;"><?php echo $nofak; ?></td>
								<td style="padding-left:5px;"><?php echo $nama; ?></td>
								<td style="text-align:center;"><?php echo $tgl; ?></td>
								<td style="text-align:left;"><?php echo $nabar; ?></td>
								<td style="text-align:left;"><?php echo $satuan; ?></td>
								<td style="text-align:right;"><?php echo 'Rp ' . number_format($harjul); ?></td>
								<td style="text-align:center;"><?php echo $qty; ?></td>
								<td style="text-align:right;"><?php echo $diskon; ?></td>
								<td style="text-align:right;"><?php echo 'Rp ' . number_format($total); ?></td>
							</tr>
						<?php } ?>
					</tbody>
					<tfoot>

						<tr>
							<td colspan="9" style="text-align:center;"><b>Total</b></td>
							<td style="text-align:right;"><b><?php echo 'Rp ' . number_format($grandtotal); ?></b></td>
						</tr>
					</tfoot>
				</table>

			<?php
			} ?>
		</div>
		<?php } ?>
		<!-- End Perulangan Barang -->
        <table align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:20px;">
            <tr>
                <td align="right">Medan, <?php echo date('d-M-Y') ?></td>
            </tr>
            <tr>
                <td align="right"></td>
            </tr>

            <tr>
                <td><br /><br /><br /><br /></td>
            </tr>
            <tr>
                <td align="right">( <?php echo $this->session->userdata('username'); ?> )</td>
            </tr>
            <tr>
                <td align="center"></td>
            </tr>
        </table>
        <table align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:20px;">
            <tr>
                <th><br /><br /></th>
            </tr>
            <tr>
                <th align="left"></th>
            </tr>
        </table>
    </div>
</body>

</html>
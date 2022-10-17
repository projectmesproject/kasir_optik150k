<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800">Laporan Data Barang</h1>
	<!-- DataTales Example -->
	<div class="card shadow mb-4">

		<div class="card-body">
			<div class="table-responsive">
				<table border="1" align="center" style="width:900px;margin-bottom:20px;">
					<?php
					$urut=0;
					$nomor=0;
					$group='-';
					foreach($data->result_array() as $d){
						$nomor++;
						$urut++;
						if($group=='-' || $group!=$d['kategori_nama']){
							$kat=$d['kategori_nama'];

							if($group!='-')
								echo "</table><br>";
							echo "<table align='center' width='900px;' border='1'>";
							echo "<tr><td colspan='6'><b>Kategori: $kat</b></td> </tr>";
							echo "<tr style='background-color:#ccc;'>
            <td width='4%' align='center'>No</td>
            <td width='40%' align='center'>Nama Barang</td>
            <td width='10%' align='center'>Satuan</td>
            <td width='20%' align='center'>Harga Jual</td>
            <td width='30%' align='center'>Stok</td>
    
    </tr>";
							$nomor=1;
						}
						$group=$d['kategori_nama'];
						if($urut==500){
							$nomor=0;
							echo "<div class='pagebreak'> </div>";

						}
						?>
						<tr>
							<td style="text-align:center;vertical-align:center;text-align:center;"><?php echo $nomor; ?></td>
							<td style="vertical-align:center;padding-left:5px;"><?php echo $d['barang_nama']; ?></td>
							<td style="vertical-align:center;text-align:center;"><?php echo $d['barang_satuan']; ?></td>
							<td style="vertical-align:center;padding-right:5px;text-align:right;"><?php echo 'Rp '.number_format($d['barang_harjul']); ?></td>
							<td style="vertical-align:center;text-align:center;text-align:center;"><?php echo $d['barang_stok']; ?></td>
						</tr>


						<?php
					}
					?>
				</table>
			</div>
		</div>
	</div>

</div>

<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800">Laporan Stok Barang</h1>
	<!-- DataTales Example -->
	<div class="card shadow mb-4">

		<div class="card-body">
			<div class="table-responsive">
				<table border="1" align="center" style="width:900px;margin-bottom:20px;">
					<?php
					$urut=0;
					$nomor=0;
					$group='-';
					foreach($data->result_array()as $d){
						$nomor++;
						$urut++;
						if($group=='-' || $group!=$d['kategori_nama']){
							$kat=$d['kategori_nama'];
							$query=$this->db->query("SELECT kategori_id,kategori_nama,barang_nama,SUM(barang_stok) AS tot_stok FROM tbl_kategori JOIN tbl_barang ON kategori_id=barang_kategori_id WHERE kategori_nama='$kat'");
							$t=$query->row_array();
							$tots=$t['tot_stok'];
							if($group!='-')
								echo "</table><br>";
							echo "<table align='center' width='900px;' border='1'>";
							echo "<tr><td colspan='2'><b>Kategori: $kat</b></td> <td style='text-align:center;'><b>Total Stok: $tots </b></td></tr>";
							echo "<tr style='background-color:#ccc;'>
    <td width='4%' align='center'>No</td>
    <td width='60%' align='center'>Nama Barang</td>
    <td width='30%' align='center'>Stok</td>
    
    </tr>";
							$nomor=1;
						}
						$group=$d['kategori_nama'];
						if($urut==500){
							$nomor=0;
							echo "<div class='pagebreak'> </div>";
							//echo "<center><h2>KALENDER EVENTS PER TAHUN</h2></center>";
						}
						?>
						<tr>
							<td style="text-align:center;vertical-align:top;text-align:center;"><?php echo $nomor; ?></td>
							<td style="vertical-align:top;padding-left:5px;"><?php echo $d['barang_nama']; ?></td>
							<td style="vertical-align:top;text-align:center;"><?php echo $d['barang_stok']; ?></td>
						</tr>


						<?php
					}
					?>
				</table>
			</div>
		</div>
	</div>

</div>

<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <title>RESUME KEUANGAN</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/laporan.css')?>"/>
</head>
<body>
<div id="laporan">
<table align="center" style="width:900px; border-bottom:3px double;border-top:none;border-right:none;border-left:none;margin-top:5px;margin-bottom:20px;">
<!--<tr> onload="window.print()
    <td><img src="<?php// echo base_url().'assets/img/kop_surat.png'?>"/></td>
</tr>--> <!-- -->
</table>

<table border="0" align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:0px;">
<tr>
    <td colspan="2" style="width:800px;paddin-left:20px;"><center><h4>RESUME KEUANGAN </h4></center><br/></td>
</tr>
                       
</table>
 
<table border="0" align="center" style="width:900px;border:none;">
        <tr>
            <th style="text-align:left"></th>
        </tr>
</table>
<?php 
    
?>
<table border="1" align="center" style="width:900px;margin-bottom:20px;">
<thead>
<tr>
<th colspan="11" style="text-align:left;">Periode : <?= $tanggal1; ?> - <?= $tanggal2; ?></th>
</tr>
    <tr>
        <th style="width:50px;">No</th>
        <th>Keterangan</th>
        <th style="width:250px;"></th>
    </tr>
</thead>
<tbody>

    <tr>
        <td style="text-align:left;">1</td>
        <td style="text-align:left;">Saldo semalam</td>
        <td style="text-align:right;">Rp. <?php
        
        $SSALDO = 0;
        $SQL = "SELECT jumlah  FROM `v13nr2_saldo_awal` WHERE tanggal = subdate(curdate(), 1)";
					$r = $this->db->query($SQL);
					$tunai = $r->result_array();
					//die($this->db->last_query());
					if($tunai){
						
						echo number_format($tunai[0]["jumlah"]);
						
						$SSALDO = $SSALDO +$tunai[0]["jumlah"];
					} else {
						echo "0";
					}
        
        ?></td>
	</tr>
    <tr>
        <td style="text-align:left;">2</td>
        <td style="text-align:left;">Total Penjualan tunai</td>
        <td style="text-align:right;">Rp. 
			<?php
			
					$SQL = "SELECT SUM(jual_total) AS total, jual_keterangan FROM tbl_jual 
WHERE jual_tanggal >= '".$this->input->post('tgl1')." 00:00:01' AND jual_tanggal <= '".$this->input->post('tgl2')." 23:59:59' AND jual_keterangan = 'Lunas'
GROUP BY jual_keterangan";
					$r = $this->db->query($SQL);
					$tunai = $r->result_array();
					//die($this->db->last_query());
					if($tunai){
						
						echo number_format($tunai[0]["total"]);
						$SSALDO = $SSALDO +$tunai[0]["total"];
					} else {
						echo "0";
					}
			?></td>
	</tr>
    <tr>
        <td style="text-align:left;">3</td>
        <td style="text-align:left;">Total penjualan debit</td>
        <td style="text-align:right;">Rp.<?php
			
					$SQL = "SELECT SUM(jual_total) AS total, jual_keterangan FROM tbl_jual 
WHERE jual_tanggal >= '".$this->input->post('tgl1')." 00:00:01' AND jual_tanggal <= '".$this->input->post('tgl2')." 23:59:59' AND jual_keterangan = 'Debit'
GROUP BY jual_keterangan";
					$r = $this->db->query($SQL);
					$tunai = $r->result_array();
					//die($this->db->last_query());
					if($tunai){
						
						echo number_format($tunai[0]["total"]);
						
						$SSALDO = $SSALDO +$tunai[0]["total"];
					} else {
						echo "0";
					}
			?></td>
	</tr>
    <tr>
        <td style="text-align:left;">4</td>
        <td style="text-align:left;">Total penjualan transfer</td>
        <td style="text-align:right;">Rp.<?php
			
					$SQL = "SELECT SUM(jual_total) AS total, jual_keterangan FROM tbl_jual 
WHERE jual_tanggal >= '".$this->input->post('tgl1')." 00:00:01' AND jual_tanggal <= '".$this->input->post('tgl2')." 23:59:59' AND jual_keterangan = 'Transfer'
GROUP BY jual_keterangan";
					$r = $this->db->query($SQL);
					$tunai = $r->result_array();
					//die($this->db->last_query());
					if($tunai){
						
						echo number_format($tunai[0]["total"]);
						
						$SSALDO = $SSALDO +$tunai[0]["total"];
					} else {
						echo "0";
					}
			?></td>
	</tr>
    <tr>
        <td style="text-align:left;">5</td>
        <td style="text-align:left;">Total penjualan ovo</td>
        <td style="text-align:right;">Rp.<?php
			
					$SQL = "SELECT SUM(jual_total) AS total, jual_keterangan FROM tbl_jual 
WHERE jual_tanggal >= '".$this->input->post('tgl1')." 00:00:01' AND jual_tanggal <= '".$this->input->post('tgl2')." 23:59:59' AND jual_keterangan = 'OVO'
GROUP BY jual_keterangan";
					$r = $this->db->query($SQL);
					$tunai = $r->result_array();
					//die($this->db->last_query());
					if($tunai){
						
						echo number_format($tunai[0]["total"]);
						
						$SSALDO = $SSALDO +$tunai[0]["total"];
					} else {
						echo "0";
					}
			?></td>
	</tr>
    <tr>
        <td style="text-align:left;">6</td>
        <td style="text-align:left;">Total penjualan link</td>
        <td style="text-align:right;">Rp.<?php
			
					$SQL = "SELECT SUM(jual_total) AS total, jual_keterangan FROM tbl_jual 
WHERE jual_tanggal >= '".$this->input->post('tgl1')." 00:00:01' AND jual_tanggal <= '".$this->input->post('tgl2')." 23:59:59' AND jual_keterangan = 'LINK'
GROUP BY jual_keterangan";
					$r = $this->db->query($SQL);
					$tunai = $r->result_array();
					//die($this->db->last_query());
					if($tunai){
						
						echo number_format($tunai[0]["total"]);
						
						$SSALDO = $SSALDO +$tunai[0]["total"];
					} else {
						echo "0";
					}
			?></td>
	</tr>
    <tr>
        <td style="text-align:left;">7</td>
        <td style="text-align:left;">Total penjualan dana</td>
        <td style="text-align:right;">Rp.<?php
			
					$SQL = "SELECT SUM(jual_total) AS total, jual_keterangan FROM tbl_jual 
WHERE jual_tanggal >= '".$this->input->post('tgl1')." 00:00:01' AND jual_tanggal <= '".$this->input->post('tgl2')." 23:59:59' AND jual_keterangan = 'DANA'
GROUP BY jual_keterangan";
					$r = $this->db->query($SQL);
					$tunai = $r->result_array();
					//die($this->db->last_query());
					if($tunai){
						
						echo number_format($tunai[0]["total"]);
						
						$SSALDO = $SSALDO +$tunai[0]["total"];
					} else {
						echo "0";
					}
			?></td>
	</tr>
    <tr>
        <td style="text-align:left;">8</td>
        <td style="text-align:left;">Total penjualan lainnya</td>
        <td style="text-align:right;">Rp.<?php
			
					$SQL = "SELECT SUM(jual_total) AS total, jual_keterangan FROM tbl_jual 
WHERE jual_tanggal >= '".$this->input->post('tgl1')." 00:00:01' AND jual_tanggal <= '".$this->input->post('tgl2')." 23:59:59' AND jual_keterangan = 'Lain-Lain'
GROUP BY jual_keterangan";
					$r = $this->db->query($SQL);
					$tunai = $r->result_array();
					//die($this->db->last_query());
					if($tunai){
						
						echo number_format($tunai[0]["total"]);
						
						$SSALDO = $SSALDO +$tunai[0]["total"];
					} else {
						echo "0";
					}
			?></td>
	</tr>
    <tr>
        <td style="text-align:left;">9</td>
        <td style="text-align:left;">Total pengeluaran hari ini</td>
        <td style="text-align:right;">Rp. <?php
        
        $SSALDO = 0;
        $SQL = "SELECT SUM(nominal) as jumlah  FROM `pengeluaran` WHERE tanggal BETWEEN  '".$this->input->post('tgl1')."' AND '".$this->input->post('tgl2')."'";
					$r = $this->db->query($SQL);
					$tunai = $r->result_array();
					//die($this->db->last_query());
					if($tunai){
						
						echo number_format($tunai[0]["jumlah"]);
						
						$SSALDO = $SSALDO -$tunai[0]["jumlah"];
					} else {
						echo "0";
					}
        
        ?></td>
	</tr>
    <tr>
        <td style="text-align:left;">10</td>
        <td style="text-align:left;">Kredit</td>
        <td style="text-align:right;">Rp.<?php
			
					$SQL = "SELECT SUM(jual_total) AS total, jual_keterangan FROM tbl_jual 
WHERE jual_tanggal >= '".$this->input->post('tgl1')." 00:00:01' AND jual_tanggal <= '".$this->input->post('tgl2')." 23:59:59' AND jual_keterangan = 'Kredit'
GROUP BY jual_keterangan";
					$r = $this->db->query($SQL);
					$tunai = $r->result_array();
					//die($this->db->last_query());
					if($tunai){
						
						echo number_format($tunai[0]["total"]);
						
						$SSALDO = $SSALDO +$tunai[0]["total"];
					} else {
						echo "0";
					}
			?></td>
	</tr>
    <tr>
        <td style="text-align:left;">11</td>
        <td style="text-align:left;">Saldo akhir</td>
        <td style="text-align:right;">Rp. <?php echo number_format($SSALDO);?></td>
	</tr>
</tbody>
<tfoot>

    <tr>
        <td colspan="1" style="text-align:center;"><b></b></td>
        <td colspan="1" style="text-align:center;"><b></b></td>
        <td style="text-align:right;"><b></b></td>
    </tr>
</tfoot>
</table>
<table align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:20px;">
    <tr>
        <td></td>
</table>
<table align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:20px;">
    <tr>
        <td align="right">Medan, <?php echo date('d-M-Y')?></td>
    </tr>
    <tr>
        <td align="right"></td>
    </tr>
   
    <tr>
    <td><br/><br/><br/><br/></td>
    </tr>    
    <tr>
        <td align="right">( <?php echo $this->session->userdata('nama');?> )</td>
    </tr>
    <tr>
        <td align="center"></td>
    </tr>
</table>
<table align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:20px;">
    <tr>
        <th><br/><br/></th>
    </tr>
    <tr>
        <th align="left"></th>
    </tr>
</table>
</div>
</body>
</html>
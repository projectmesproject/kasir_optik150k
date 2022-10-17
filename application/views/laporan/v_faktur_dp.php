<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <title>Faktur Penjualan Barang</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/laporan.css')?>"/>
</head>
<body onload="window.print()">
<div id="laporan">
<table align="center" style="width:302px; border-bottom:3px double;border-top:none;border-right:none;border-left:none;margin-top:5px;margin-bottom:20px;">
<!--<tr>
    <td><img src="<?php// echo base_url().'assets/img/kop_surat.png'?>"/></td>
</tr>-->
</table>

<table border="0" align="center" style="width:302px; border:none;margin-top:5px;margin-bottom:0px;">
<tr>
    
</tr>
                       
</table>
<?php 
    $b=$data->row_array();
?>
<table border="0" align="center" style="width:302px;border:none;">
        <?php
            $data1 = $this->db->query("select * from tbl_setting where id=2")->row_array();
            $data2 = $this->db->query("select * from tbl_setting where id=3")->row_array();
            $data4 = $this->db->query("select * from tbl_setting where id=5")->row_array();
        ?>
        <center><img src="<?= base_url('assets/logo/')?><?= $data4['fitur']; ?>" alt="logo" width="130px" ></center>
        <center><h4><?= $data1['fitur']; ?></h4></center>
        <center><?= $data2['fitur']; ?></center> 
        <center><?= $data4['fitur']; ?></center> 
        <br>     
        <hr style="width:302px">
        <br>
        <tr>
            <th style="text-align:left;">No Faktur</th>
            <th style="text-align:left;">: <?php echo $b['jual_nofak'];?></th>

        </tr>
        <tr>
            <th style="text-align:left;">Tanggal</th>
            <th style="text-align:left;">: <?php echo $b['jual_tanggal'];?></th>
        </tr>

        <?php
            $nope = $b['no_hp'];
            $nama_p = $this->db->query("select * from tbl_customer where no_hp='$nope'")->row_array();
        ?>
                <tr>
            <th style="text-align:left;">Nama Pelanggan</th>
            <th style="text-align:left;">: <?php echo $nama_p['nama'];?></th>

        </tr>
        <tr>
            <th style="text-align:left;">No HP</th>
            <th style="text-align:left;">: <?php echo $b['no_hp'];?></th>
        </tr>
        <tr>
            <th style="text-align:left;">Alamat</th>
            <th style="text-align:left;">: <?php echo $nama_p['alamat'];?></th>
        </tr>

        <tr>
        <td><br></td>
        </tr>
		
</table>

<table border="0" align="center" style="width:302px;margin-bottom:20px;border:none;">
<thead>

    <tr>
        <th style="width:25px;">No</th>
        <th style="width:25px;">Nama Barang</th>
  
        <th style="width:25px;">Qty</th>
        <th style="width:25px;">Keterangan</th>
        <th style="width:25px;">SubTotal</th>
    </tr>
</thead>
<tbody>
<?php 
$no=0;
    foreach ($data->result_array() as $i) {
        $no++;
        
        $nabar=$i['d_jual_barang_nama'];
        $satuan=$i['d_jual_barang_satuan'];
        
        $harjul=$i['d_jual_barang_harjul'];
        $qty=$i['d_jual_qty'];
        $diskon=$i['d_jual_diskon'];
        $total=$i['d_jual_total'];
?>
    <tr>
        <td style="text-align:center;"><?php echo $no;?></td>
        <td style="text-align:center;"><?php echo $nabar;?></td>

        <td style="text-align:center;"><?php echo $qty;?></td>
        <td style="text-align:center;"><?php echo $diskon;?></td>
        <td style="text-align:center;"><?php echo 'Rp '.number_format($total);?></td>
    </tr>
<?php }?>
</tbody>

</table>
<table align="center" style="width:302px; border:none;margin-top:5px;margin-bottom:20px;">
<br>     
        <hr style="width:302px">
        <br>
    <tr>
        <th style="text-align:left;">Keterangan</th>
        <th style="text-align:left;">: <?php echo $b['diskon'];?></th>
    </tr>

    <tr>
        <th style="text-align:left;">Total Bayar</th>
        <th style="text-align:left;">: <?php echo 'Rp '.number_format($b['jual_total']).',-';?></th>
    </tr>

    <tr>
        <th style="text-align:left;">Tunai</th>
        <th style="text-align:left;">: <?php echo 'Rp '.number_format($b['jual_jml_uang']).',-';?></th>
    </tr>
 
    <tr>
            <th style="text-align:left;">Kurang</th>
            <th style="text-align:left;">: <?php echo 'Rp '.number_format($b['jual_kembalian']).',-';?></th>
    </tr>
        <td></td>
        <tr>
        <tr>
        <td><br></td>
        </tr>
        <tr>
        <td><br></td>
        </tr>
            <th style="text-align:left;">Keterangan</th>
            <th style="text-align:left;">: <?php echo $b['uang_muka'];?></th>
        </tr>
</table>
<table align="center" style="width:302px; border:none;margin-top:5px;margin-bottom:20px;">


    <tr>
        <td align="right"></td>
    </tr>
   
    <tr>
    <td><br/><br/><br/><br/></td>
    </tr> 
    <tr>
    <td></td>
    </tr>   
    <tr>
        <td align="center"><b>----TERIMA KASIH----</b></td>
    </tr>
    <tr>
        <td align="center"></td>
    </tr>
</table>
<table align="center" style="width:302px; border:none;margin-top:5px;margin-bottom:20px;">
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
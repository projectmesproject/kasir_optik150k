<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <title>laporan hutang karyawan</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/laporan.css')?>"/>
</head>
<body onload="window.print()">
<div id="laporan">
<table align="center" style="width:900px; border-bottom:3px double;border-top:none;border-right:none;border-left:none;margin-top:5px;margin-bottom:20px;">
<!--<tr>
    <td><img src="<?php// echo base_url().'assets/img/kop_surat.png'?>"/></td>
</tr>-->
</table>

<table border="0" align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:0px;">
<tr>
    <td colspan="2" style="width:800px;paddin-left:20px;"><center><h4>LAPORAN HUTANG KARYAWAN</h4></center><br/></td>
</tr>
                       
</table>
 
<table border="0" align="center" style="width:900px;border:none;">
        <tr>
            <th style="text-align:left"></th>
        </tr>
</table>

<table border="1" align="center" style="width:900px;margin-bottom:20px;">
<?php 
    $urut=0;
    $nomor=0;
    $group='-';
    foreach($data->result_array() as $d){
    $nomor++;
    $urut++;
    if($group=='-' || $group!=$d['nama_karyawan']){
        $kat=$d['nama_karyawan'];
        
        if($group!='-')
        echo "</table><br>";
        echo "<table align='center' width='900px;' border='1'>";
        echo "<tr><td colspan='6'><b>Karyawan: $kat</b></td> </tr>";
        echo "<tr style='background-color:#ccc;'>
        <td width='7%' align='center'>No</td>
        <td width='14%' align='center'>Nominal</td>
        <td width='14%' align='center'>Jumlah Bayar</td>
        <td width='14%' align='center'>Jumlah Hutang</td>
        <td width='30%' align='center'>Keterangan</td>
        <td width='14%' align='center'>Tanggal</td>
        
        </tr>";
        
$nomor=1;
    }
    $group=$d['nama_karyawan'];
        if($urut==500){
        $nomor=0;
            echo "<div class='pagebreak'> </div>";

            }
        ?>
        <tr>
                <td style="text-align:center;vertical-align:center;text-align:center;"><?php echo $nomor; ?></td>
                <td style="vertical-align:center;padding-left:5px;">Rp. <?php echo number_format($d['nominal']); ?></td>
                <td style="vertical-align:center;padding-left:5px;">Rp. <?php echo number_format($d['jumlah_bayar']); ?></td>
                <td style="vertical-align:center;padding-left:5px;">Rp. 
                    <?php $jumlah = $d['nominal']-$d['jumlah_bayar'];
                        echo number_format($jumlah);
                    ?>
                </td>
                <td style="vertical-align:center;text-align:center;"><?php echo $d['keterangan']; ?></td>
                <td style="vertical-align:center;text-align:center;text-align:center;"><?php echo $d['tanggal']; ?></td>  
        </tr>
        

        <?php
        }
        ?>
</table>

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
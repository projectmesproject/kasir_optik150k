<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <title>Laporan Pembelian per Supplier</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/laporan.css')?>"/>
</head>
<body>
<div id="laporan">
<table align="center" style="width:900px; border-bottom:3px double;border-top:none;border-right:none;border-left:none;margin-top:5px;margin-bottom:20px;">
<!--<tr>
    <td><img src="<?php// echo base_url().'assets/img/kop_surat.png'?>"/></td>
</tr>-->
</table>

<table border="0" align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:0px;">
<tr>
    <td colspan="2" style="width:800px;paddin-left:20px;"><center><h4>LAPORAN PEMBELIAN PER SUPPLIER</h4></center><br/></td>
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
<th colspan="11" style="text-align:left;">Periode : <?= $tanggal1; ?> - <?= $tanggal2; ?></th>
</tr>
    <tr>
        <th style="width:50px;">No</th>
        <th>Nama Supplier</th>
        <th>Tanggal Beli</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Qty</th>
        <th>Jumlah</th>
    </tr>
</thead>
<tbody>
<?php $no= 1; $total=0; foreach($data as $d){ ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $d['suplier_nama']; ?></td>
        <td><?= $d['beli_tanggal']; ?></td>
        <td><?= $d['barang_nama']; ?></td>
        <td align="right"><?= number_format($d['d_beli_harga']); ?></td>
        <td align="center"><?= $d['d_beli_jumlah']; ?></td>
        <td align="right">Rp. <?= number_format($d['d_beli_total']); ?></td>
    </tr>
<?php $total=$total+$d['d_beli_total']; } ?>
</tbody>
<tfoot>

    <tr>
        <td colspan="6" style="text-align:center;"><b>Total Pengeluaran</b></td>
        <td style="text-align:right;"><b><?php echo 'Rp '.number_format($total);?></b></td>
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
<script>

    var preview = '<?= @$_GET["preview"] ?>';

    if ( preview != 'ya' ) {

        print_data();
    }

    function print_data(){
        
        window.print();
        window.onmouseover = function() { setTimeout(function(){window.close();}, 300); }
    };

</script>
</body>
</html>
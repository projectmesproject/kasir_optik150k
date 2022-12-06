<html lang="en" moznomarginboxes mozdisallowselectionprint>

<head>
    <title>Laporan data Pembelian</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/laporan.css') ?>" />
</head>

<body onload="window.print()">
    <div id="laporan">
        <table align="center" style="width:900px; border-bottom:3px double;border-top:none;border-right:none;border-left:none;margin-top:5px;margin-bottom:20px;">
            <!--<tr>
    <td><img src="<? php // echo base_url().'assets/img/kop_surat.png'
                    ?>"/></td>
</tr>-->
        </table>

        <table border="0" align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:0px;">
            <tr>
                <td colspan="2" style="width:800px;paddin-left:20px;">
                    <center>
                        <h4>LAPORAN PEMBELIAN</h4>
                    </center><br />
                </td>
            </tr>

        </table>

        <table border="0" align="center" style="width:900px;border:none;">
            <tr>
                <th style="text-align:left">Tanggal : <?= date('d-M-Y', strtotime($tanggal1)) . " - " . date('d-M-Y', strtotime($tanggal2)) ?></th>
            </tr>
            <tr>
                <th style="text-align:left">Barang : <?= $nama_barang ?></th>
            </tr>
        </table>

        <table border="1" align="center" style="width:900px;margin-bottom:20px;">
            <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>No Faktur</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Harga Beli</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 0;
                foreach ($data as $value) {
                    $no++;

                ?>
                    <tr>
                        <td style="text-align:center;"><?= $no; ?></td>
                        <td style="text-align:center;"><?= $value->beli_nofak; ?></td>
                        <td style="text-align:center;"><?= date('d-M-Y', strtotime($value->beli_tanggal)); ?></td>
                        <td style="text-align:center;"><?= $value->barang_nama; ?></td>
                        <td style="text-align:right;"><?= 'Rp ' . number_format($value->d_beli_harga); ?></td>
                        <td style="text-align:center;"><?= $value->d_beli_jumlah; ?></td>
                        <td style="text-align:right;"><?= 'Rp ' . number_format($value->d_beli_total); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <?php
                $b = $jml->row_array();
                ?>
                <tr>
                    <td colspan="6" style="text-align:center;"><b>Total</b></td>
                    <td style="text-align:right;"><b><?php echo 'Rp ' . number_format($b['total']); ?></b></td>
                </tr>
            </tfoot>
        </table>
        <table align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:20px;">
            <tr>
                <td></td>
        </table>
        <table align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:20px;">
            <tr>
                <td align="right">Medan, <?= date('d-M-Y') ?></td>
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

</html>_
<html lang="en" moznomarginboxes mozdisallowselectionprint>

<head>
    <title>Laporan data Penjualan Kwitansi</title>
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
                        <h4>LAPORAN PENJUALAN KWITANSI</h4>
                    </center><br />
                </td>
            </tr>

        </table>

        <table border="0" align="center" style="width:900px;border:none;">
            <tr>
                <th style="text-align:left">Tanggal : <?= date('d-M-Y', strtotime($tanggal1)) . " - " . date('d-M-Y', strtotime($tanggal2)) ?></th>
            </tr>
        </table>

        <table border="1" align="center" style="width:900px;margin-bottom:20px;">
            <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>Kode Kwitansi</th>
                    <th>Tanggal</th>
                    <th>Karyawan</th>
                    <th>Nominal</th>
                    <th>Harga Jual</th>
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
                        <td style="text-align:center;"><?= $value->kode_kwitansi; ?></td>
                        <td style="text-align:center;"><?= date('d-M-Y', strtotime($value->date_created)); ?></td>
                        <td style="text-align:center;"><?= $value->karyawan; ?></td>
                        <td style="text-align:center;"><?= 'Rp ' . number_format($value->nominal); ?></td>
                        <td style="text-align:right;"><?= 'Rp ' . number_format($value->harga_jual); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align:center;"><b>Total</b></td>
                    <td style="text-align:right;"><b><?php echo 'Rp ' . number_format($total['harga_jual']); ?></b></td>
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
<html lang="en" moznomarginboxes mozdisallowselectionprint>

<head>
    <title>RESUME KEUANGAN</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/laporan.css') ?>" />
</head>

<body>
    <div id="laporan">
        <table align="center" style="width:900px; border-bottom:3px double;border-top:none;border-right:none;border-left:none;margin-top:5px;margin-bottom:20px;">

        </table>

        <table border="0" align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:0px;">
            <tr>
                <td colspan="2" style="width:800px;padding-left:20px;">
                    <center>
                        <h4>RESUME KEUANGAN </h4>
                    </center><br />
                </td>
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
                    <th colspan="11" style="text-align:left;">Periode : <?= $start; ?> - <?= $end; ?></th>
                </tr>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>Keterangan Penjualan</th>
                    <th style="width:250px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($getPenjualan as $value) {
                    $total_semua_fix = $value->total_semua + $value->total_semua2;
                ?>
                    <tr>
                        <td style="text-align:center;"><?= $no++ ?></td>
                        <td style="text-align:left;">
                            Cara Bayar1 : <?= ($value->jual_keterangan) ?> <br>
                            Cara Bayar2 : <?= $value->jual_keterangan2 ?></td>
                        <td style="text-align:right;">Rp.
                            <?= number_format($total_semua_fix) ?>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">Saldo</td>
                    <td style="text-align: right;">Rp. <?= number_format($saldo) ?></td>
                </tr>
                <tr>
                    <td colspan="2">Subtotal Penjualan</td>
                    <?php

                    foreach ($total as $value) {
                        $result = $value->total_semua;
                    ?>
                        <td style="text-align:right;">Rp.
                            <?= number_format($result) ?>
                        </td>
                    <?php } ?>
                </tr>
                <tr>
                    <td colspan="2">Total Pengeluaran</td>
                    <?php

                    $pengeluaran = $pengeluaran->total_pengeluaran;
                    ?>
                    <td style="text-align:right;">Rp.
                        <?= number_format($pengeluaran) ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Total Penjualan</td>
                    <?php

                    foreach ($total as $value) {
                        $result = $saldo + $value->total_semua;
                        $result -= $pengeluaran;
                    ?>
                        <td style="text-align:right;">Rp.
                            <?= number_format($result) ?>
                        </td>
                    <?php } ?>
                </tr>
            </tfoot>
        </table>
        <table align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:20px;">
            <tr>
                <td></td>
        </table>
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
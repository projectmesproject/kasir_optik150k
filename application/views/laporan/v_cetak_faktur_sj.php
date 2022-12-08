<html lang="en" moznomarginboxes mozdisallowselectionprint>

<head>
    <title>Faktur Penjualan Barang</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/laporan.css') ?>" />

    <link href="<?= base_url('assets/admin/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        * {
            color: #000;
        }
    </style>
</head>

<body onload="window.print()">
    <div id="laporan">
        <table align="center" style="width:302px; border-bottom:3px double;border-top:none;border-right:none;border-left:none;margin-top:5px;margin-bottom:20px;">

        </table>

        <table border="0" align="center" style="width:302px; border:none;margin-top:5px;margin-bottom:0px;">
            <tr>

            </tr>

        </table>
        <?php
        $b = $data->row_array();
        ?>
        <table border="0" align="center" style="width:302px;border:none;">
            <?php
            $data1 = $this->db->query("select * from tbl_setting where id=2")->row_array();
            $data2 = $this->db->query("select * from tbl_setting where id=3")->row_array();
            $data3 = $this->db->query("select * from tbl_setting where id=4")->row_array();
            $data4 = $this->db->query("select * from tbl_setting where id=5")->row_array();
            ?>
            <center><img src="<?= base_url('assets/logo/') ?><?= $data4['fitur']; ?>" alt="logo" width="130px"></center>
            <center>
                <h4><?= $data1['fitur']; ?></h4>
            </center>
            <center><?= $data2['fitur']; ?></center>
            <center><?= $data3['fitur']; ?></center>
            <br>
            <hr style="width:302px">
            <br>
            <tr>
                <th style="text-align:left;">No Faktur</th>
                <th style="text-align:left;">: <?php echo $b['jual_nofak']; ?></th>

            </tr>
            <tr>
                <th style="text-align:left;">Tanggal</th>
                <th style="text-align:left;">: <?php
                                                $userTimezone = new DateTimeZone('Asia/Jakarta');
                                                //				$dataa = $b["jual_tanggal"];
                                                //				$date = new DateTime(".$dataa.");
                                                $date = new DateTime();
                                                //				$myDateTime = new DateTime($date, $userTimezone);
                                                echo $date->format('D, d M Y H:i:s');
                                                ?></th>
            </tr>
            <?php

            ?>
            <tr>
                <th style="text-align:left;">Nama Cabang</th>
                <th style="text-align:left;">: <?php echo $b['cabang']; ?></th>

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
                $no = 0;
                foreach ($data->result_array() as $i) {
                    $no++;

                    $nabar = $i['d_jual_barang_nama'];
                    $satuan = $i['d_jual_barang_satuan'];
                    $qty = $i['d_jual_qty'];
                    $diskon = $i['d_jual_diskon'];
                    $total = $i['d_jual_total'];
                ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no; ?></td>
                        <td style="text-align:center;"><?php echo $nabar; ?></td>


                        <td style="text-align:center;"><?php echo $qty; ?></td>
                        <td style="text-align:center;"><?php echo $diskon; ?></td>
                        <td style="text-align:center;"><?php echo 'Rp ' . number_format($total); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <br>
            <hr style="width:302px">
            <br>
        </table>

        <table align="center" style="width:302px; border:none;margin-top:5px;margin-bottom:20px;">

            <tr>
                <th style="text-align:left;">Keterangan</th>
                <th style="text-align:left;">: <?php echo $b['diskon']; ?></th>
            </tr>

            <tr>
                <th style="text-align:left;">Total Bayar</th>
                <th style="text-align:left;">: <?php echo 'Rp ' . number_format($b['jual_total']) . ',-'; ?></th>
            </tr>

            <tr>
                <th style="text-align:left;">Tunai</th>
                <th style="text-align:left;">: <?php echo 'Rp ' . number_format($b['jual_jml_uang']) . ',-'; ?></th>
            </tr>
            <?php if ($b['jual_jml_uang'] != "") { ?>
                <tr>
                    <th style="text-align:left;">Tunai 2</th>
                    <th style="text-align:left;">: <?php echo 'Rp ' . number_format($b['jual_jml_uang2']) . ',-'; ?></th>
                </tr>
            <?php } ?>

            <?php if ($b['jual_kembalian'] != 0) { ?>
                <tr>
                    <th style="text-align:left;">Kembalian</th>
                    <th style="text-align:left;">: <?php echo 'Rp ' . number_format($b['jual_kembalian']) . ',-'; ?></th>
                </tr>
            <?php } ?>
            <?php if ($b['jual_kurang_uang'] != 0) { ?>
                <tr>
                    <th style="text-align:left;">Kurang</th>
                    <th style="text-align:left;">: <?php echo 'Rp ' . number_format($b['jual_kurang_uang']) . ',-'; ?></th>
                </tr>
            <?php } ?>
            <td></td>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td><br></td>
            </tr>

            <tr>
                <th style="text-align:left;">Metode Pembayaran</th>
                <th style="text-align:left;">: <?php echo $b['jual_keterangan']; ?> <?php if (!empty($b['jual_keterangan2'])) echo ",$b[jual_keterangan2]"; ?></th>
            </tr>
        </table>
        <table align="center" style="width:302px; border:none;margin-top:5px;margin-bottom:20px;">


            <tr>
                <td align="right"></td>
            </tr>

            <tr>
                <td><br /><br /><br /><br /></td>
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
                <th><br /><br /></th>
            </tr>
            <tr>
                <th align="left"></th>
            </tr>
        </table>

        <div class="card-body">
            <?php
            $data1 = $this->db->query("select * from tbl_setting where id=2")->row_array();
            $data2 = $this->db->query("select * from tbl_setting where id=3")->row_array();
            $data3 = $this->db->query("select * from tbl_setting where id=4")->row_array();
            $data4 = $this->db->query("select * from tbl_setting where id=5")->row_array();
            ?>
            <center><img src="<?= base_url('assets/logo/') ?><?= $data4['fitur']; ?>" alt="logo" width="130px"></center>
            <center>
                <h4><?= $data1['fitur']; ?></h4>
            </center>
            <center><?= $data2['fitur']; ?></center>
            <br>
            <?php

            $select = $this->db->query("SELECT jual_nofak FROM tbl_jual WHERE jual_nofak='$b[jual_nofak]'")->result();
            $count = count($select);
            $count++;
            $count = sprintf("%04d", $count);
            $today = date("dmY");
            $bulan = date("m");
            $tahun = date("Y");
            $kode = "DOCSJ$today/$bulan/$count";
            ?>
            <div class="row">
                <div class="col-sm-8">
                    <h2 class="font-weight-bold">Medan</h2>
                    <span class="font-weight-bold" style="font-size: 19px;">SURAT JALAN </span> <span>No. <?= $kode ?> </span><br />
                    <span class="font-weight-bold" style="font-size: 19px;">No. Faktur </span> <span><?php echo $b['jual_nofak']; ?> </span>
                </div>
                <div class="col-sm-4">
                    Medan, <?= date('d-m-Y') ?> <br />
                    Kepada Yth :<br />
                    <?php echo $b['cabang']; ?>
                </div>
            </div>
            <div class="table-responsive mt-3">
                <p>Kami kirimkan barang-barang tersebut dibawah ini dengan kendaraan ....................................................... No.........................................</p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 15%;">Banyaknya</th>
                            <th>Nama Barang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nabar = $i['d_jual_barang_nama'];
                        $satuan = $i['d_jual_barang_satuan'];
                        $qty = $i['d_jual_qty'];
                        $diskon = $i['d_jual_diskon'];
                        $total = $i['d_jual_total'];
                        ?>
                        <tr>
                            <td><?= $qty ?></td>
                            <td><?= $nabar ?></td>
                        </tr>
                        <?php
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="row col-sm-8 mx-auto">
                <div class="col-sm-6">
                    <p>Tanda Terima</p>
                </div>
                <div class="col-sm-6">
                    <p class="text-right">Hormat Kami</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
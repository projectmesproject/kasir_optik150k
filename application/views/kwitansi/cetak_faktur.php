<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/sb-admin-2.css') ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kwitansi</title>
    <style>
        body {
            color: #000;
            font-style: italic;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .bg-opacity {
            background-color: rgba(237, 206, 138, .3);
        }

        .border-bottom-line {
            border-bottom: 2px dashed #000;
            margin-bottom: 2%;
            border-bottom-style: double;
        }

        .border-bottom-dot {
            border-bottom: 2px dashed #000;
            margin-bottom: 2%;
            border-bottom-style: dashed;
        }

        table tr td {
            border-bottom: 1px solid black;
        }

        hr {
            display: block;
            height: -20%;
            border: 0;
            border-top: 1px solid #000;
            margin: 10px 0;
            padding: 0;
        }
    </style>
</head>

<body class="container p-5">
    <?php
    $bulantahun = date('mY');
    $nomor = sprintf("%04d", $data);
    for ($i = 1; $i < 6; $i++) {
        if ($i == $versi) {
    ?>

            <div class="card-body mb-4" style=" -webkit-filter: grayscale(100%);filter: grayscale(100%);background-image:url(<?= base_url('assets/admin/kwitansi_bg/' . $i . ".jpg") ?>);background-color: #cccccc;height: auto;background-position: center; background-repeat: no-repeat;background-size: cover;position:relative;">
                <div style="background-color:#fff;position: absolute;top:0;bottom:0;right:0;left:0;opacity:.8" class="border"></div>
                <div class="d-flex-column">
                    <div class="border-bottom-line col-sm-3 pl-0">
                        <span>No. KWI/OPT/<?= $nomor ?>/<?= $bulantahun ?></span>
                    </div>
                    <div class="col-sm-12 border-bottom-dot pl-0">
                        <span>Sudah Diterima Dari</span>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-sm-2">
                            <span>Banyaknya Uang</span>
                        </div>
                        <div class="col-sm-10">
                            <hr />
                            <hr />
                            <hr />
                            <hr />
                        </div>
                    </div>
                    <div class="col-sm-12 border-bottom-dot pl-0">
                        <span>Untuk Pembayaran</span>
                    </div>
                    <div class="col-sm-12 border-bottom-dot pl-0">
                        <span>&nbsp;</span>
                    </div>
                    <div class="col-sm-12 border-bottom-dot pl-0">
                        <span>&nbsp;</span>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-sm-3 ">
                        <h2 class="font-italic">Jumlah Rp</h2>
                    </div>
                    <div class="col-sm-3">
                        <hr />
                        <hr />
                        <hr />
                        <hr />
                    </div>
                </div>
            </div>
    <?php }
    } ?>
</body>

</html>
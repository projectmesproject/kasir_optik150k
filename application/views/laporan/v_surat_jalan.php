<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= base_url('assets/admin/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
    <title>Print Surat Jalan</title>
    <style>
        * {
            color: #000;
        }
    </style>
</head>

<body>
    <div id="header_section" class="container col-lg-11 mx-auto">
        <div class="card-body">
            <?php
            $b = $data->row_array();
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

            <div class="row">
                <div class="col-sm-8">
                    <h2 class="font-weight-bold">Medan</h2>
                    <span class="font-weight-bold" style="font-size: 19px;">SURAT JALAN </span> <span>No. <?= $b['surat_jalan'] ?> </span><br />
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
                                <td><?= $qty ?></td>
                                <td><?= $nabar ?></td>
                            </tr>
                        <?php
                        }
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
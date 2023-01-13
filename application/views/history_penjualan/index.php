<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data History Penjualan</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- FLASH DATA -->
            <?php
            $dat = $this->session->flashdata('msg');
            if ($dat != "") { ?>
                <div id="notifikasi" class="alert alert-success"><strong>Sukses! </strong> <?= $dat; ?></div>
            <?php } ?>
            <h6 class="m-0 font-weight-bold text-primary">Daftar History Penjualan</h6>
        </div>
        <br>
        <div class="card-body">

            <?php if ($this->session->userdata('level') == 'kasir' || $this->session->userdata('level') == 'penjualan') { ?>
                <form id="filter_history_form">
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label>Cari</label>
                            <?php if ($this->session->userdata('level') == 'kasir') { ?>
                                <input type="search" name="search" placeholder="No. Hp, No. Faktur, Nama Pelanggan" class="form-control" />
                            <?php } else if ($this->session->userdata('level') == 'penjualan') {
                            ?>
                                <input type="search" name="search" placeholder="No. Faktur, Cabang" class="form-control" />

                            <?php
                            } ?>
                        </div>
                        <div class="form-group col-sm-3">
                            <label>&nbsp;</label><br />
                            <button class="btn btn-warning" type="submit">FILTER</button>
                        </div>
                    </div>
                </form>
            <?php } ?>
            <br>
            <div class="table-responsive" id="result_table">
                <table class="table table-bordered" id="table_history" width="100%" cellspacing="0">
                    <?php if ($this->session->userdata('level') != 'kasir' && $this->session->userdata('level') != 'penjualan') { ?>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama PLG</th>
                                <th>Tanggal</th>
                                <th>No HP</th>
                                <th>No Faktur</th>
                                <th>Jumlah</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script>
    $(document).ready(function() {
        tableHistory = $('#table_history').DataTable({
            "processing": true,
            "serverSide": true,
            "retrieve": true,
            "ajax": {
                "url": "<?= base_url('History_penjualan/list_history_penjualan') ?>",
                "type": "POST",
            },
            "columnDefs": [{}, ],
        });
    });
</script>
<script>
    $("#filter_history_form").submit(function(ev) {
        ev.preventDefault();
        $("#result_table").html("<h3 class='text-center'>Loading...</h3>")
        <?php
        $url = base_url() . "/history_penjualan/filter_history";
        if ($this->session->userdata('level') == 'penjualan') {
            $url = base_url() . "/history_penjualan/filter_history_cabang";
        }
        ?>
        $.ajax({
            url: "<?= $url ?>",
            data: $(this).serialize(),
            cache: false,
            type: 'POST',
            success: function(res) {
                console.log(res)
                $("#result_table").html(res)
                $("#dataTable").dataTable()
            }
        })
    })
</script>
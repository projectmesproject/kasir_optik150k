<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-3">
        <div class="card-header py-3">
            <!-- FLASH DATA -->
            <?php
            $dat = $this->session->flashdata('msg');
            if ($dat != "") { ?>
                <div id="notifikasi" class="alert alert-success"><strong>Sukses! </strong> <?= $dat; ?></div>
            <?php } ?>
            <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-primary btn-sm my-3" data-toggle="modal" data-target="#add_kwitansi">
                (+) TAMBAH
            </button>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kode Kwitansi</th>
                            <th>Nominal</th>
                            <th>Karyawan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1;
                        foreach ($data as $p) {
                            $date = date('Y-m-d', strtotime($p->date_created));
                            $today = date("Y-m-d");
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= date('Y-m-d', strtotime($p->date_created)); ?></td>
                                <td><?= $p->kode_kwitansi; ?></td>
                                <td>Rp. <?= number_format($p->nominal); ?></td>
                                <td><?= $p->karyawan; ?></td>
                                <td><?php if ($date == $today) { ?><a class="badge badge-success cetak_mdl text-white" data-id_kwitansi="<?= $p->id_kwitansi; ?>" style="cursor:pointer">Cetak</a> <?php } ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<!-- Modal Tambah Kwitansi -->
<div class="modal fade" id="add_kwitansi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Kwitansi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('kwitansi/tambah_kwitansi') ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nominal<br /><small class="text-danger">Nominal yang akan ditulis</small></label>
                    <input type="number" name="nominal" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="">Harga Jual Kwitansi</label>
                    <input type="number" name="harga" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="">Karyawan</label>
                    <input type="text" name="karyawan" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="pilih_kwitansi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Kwitansi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="id_kwitansi_mdl" value="" />
                <div class="form-group shadow-sm border border-dark p-3 my-3">
                    <label>Kwitansi 1</label>
                    <img src="<?= base_url('assets/img/kwi1.png') ?>" onclick="kwitansiCetak('1')" style="width:100%;height:auto;object-fit:contain;cursor:pointer;" />
                </div>
                <div class="form-group shadow-sm border border-dark p-3 my-3">
                    <label>Kwitansi 2</label>
                    <img src="<?= base_url('assets/img/kwi2.png') ?>" onclick="kwitansiCetak('2')" style="width:100%;height:auto;object-fit:contain;cursor:pointer;" />
                </div>
                <div class="form-group shadow-sm border border-dark p-3 my-3">
                    <label>Kwitansi 3</label>
                    <img src="<?= base_url('assets/img/kwi3.png') ?>" onclick="kwitansiCetak('3')" style="width:100%;height:auto;object-fit:contain;cursor:pointer;" />
                </div>
                <div class="form-group shadow-sm border border-dark p-3 my-3">
                    <label>Kwitansi 4</label>
                    <img src="<?= base_url('assets/img/kwi4.png') ?>" onclick="kwitansiCetak('4')" style="width:100%;height:auto;object-fit:contain;cursor:pointer;" />
                </div>
                <div class="form-group shadow-sm border border-dark p-3 my-3">
                    <label>Kwitansi 5</label>
                    <img src="<?= base_url('assets/img/kwi5.png') ?>" onclick="kwitansiCetak('5')" style="width:100%;height:auto;object-fit:contain;cursor:pointer;" />
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $(".cetak_mdl").click(function() {
        $('#pilih_kwitansi').modal('show')
        var id_kwitansi = $(this).attr('data-id_kwitansi')
        $("#id_kwitansi_mdl").val(id_kwitansi)
    })

    function kwitansiCetak(model) {
        var id = $("#id_kwitansi_mdl").val()
        window.open('<?= base_url() ?>kwitansi/cetak_kwitansi/' + id + "/" + model)

    }
</script>
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
                        foreach ($data as $p) { ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= date('Y-m-d',strtotime($p->date_created)); ?></td>
                                <td><?= $p->kode_kwitansi; ?></td>
                                <td>Rp. <?= number_format($p->nominal); ?></td>
                                <td><?= $p->karyawan; ?></td>
                                <td><a class="badge badge-success" href="<?= base_url(); ?>kwitansi/cetak_kwitansi/<?= $p->id_kwitansi; ?>" target="_blank">Cetak</a></td>
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
                        <label for="">Nominal<br/><small class="text-danger">Nominal yang akan ditulis</small></label>
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

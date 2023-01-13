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
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
              <?php $no = 1;
              foreach ($data as $a) { ?>
                <?php
                $no_fak = $a->jual_nofak;
                if ($a->status == "COMPLETE") {
                  $status = '<div class="badge badge-success">Complete</div>';
                } else if ($a->status == "DP") {
                  $status = '<div class="badge badge-warning">DP</div>';
                } else {
                  $status = '<div class="badge badge-danger">Cancel</div>';
                }

                $nama_plg = "-";
                if ($a->namaplg) {
                  $nama_plg = $a->namaplg;
                }
                if ($a->cabang) {
                  $nama_plg = $a->cabang;
                }
                ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?php echo $nama_plg ?></td>
                  <td><?php echo $a->jual_tanggal ?></td>
                  <td><?php echo $a->no_hp ? $a->no_hp : "-" ?></td>
                  <td><?= $a->jual_nofak; ?></td>
                  <td><?= $a->jumlah_item; ?> items</td>
                  <td>Rp. <?= number_format($a->jual_total); ?></td>
                  <td><?= $status ?></td>
                  <td class="text-center">
                    <a class="badge badge-success" href="<?= base_url(); ?>history_penjualan/in_detail/<?= $a->jual_nofak ?>">View</a>
                    <?php
                    if ($this->session->userdata("level") == "admin") {

                    ?>
                      <a class="badge badge-success" href="<?= base_url(); ?>history_penjualan/cetak_faktur/<?= $a->jual_nofak ?>" target="_blank">Cetak</a>
                      <a class="badge badge-success" href="<?= base_url(); ?>penjualan_edit/index/<?= $a->jual_nofak ?>">Edit</a>
                      <a class="badge badge-success" href="<?= base_url(); ?>history_penjualan/takdeletekowe/<?= $a->jual_nofak ?>">Delete</a>
                      <a class="badge badge-danger" href="<?= base_url(); ?>history_penjualan/batal/<?= $a->jual_nofak ?>">Batal</a>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
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
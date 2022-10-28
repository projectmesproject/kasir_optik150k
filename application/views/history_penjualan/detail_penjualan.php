<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary text-center">KETERANGAN PENJUALAN</h6>
    </div>
    <br>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
          <tr>
            <td width="220">No Faktur</td>
            <td width="20">:</td>
            <td><?= $jual['jual_nofak']; ?></td>
          </tr>
          <tr>
            <td>Tanggal Penjualan</td>
            <td>:</td>
            <td><?php echo $jual['jual_tanggal']; ?></td>
          </tr>
          <tr>
            <td>Customer</td>
            <td>:</td>
            <td><?= $customer['nama']; ?></td>
          </tr>
          <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?= $jual['diskon']; ?></td>
          </tr>
          <tr>
            <td>Total Harga</td>
            <td>:</td>
            <td>Rp. <?= number_format($jual['jual_total']); ?></td>
          </tr>
        </table>
      </div>
      <div class="row float-sm-right mr-3">
        <button class="btn btn-danger" onclick="batal('<?= $jual['jual_nofak']; ?>')">Batal</button>
      </div>
    </div>
  </div>

  <!--  -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary text-center">DAFTAR BARANG</h6>
    </div>
    <br>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Nama Barang</th>
            <th class="text-center">Harga</th>
            <th class="text-center">Qty</th>
            <th class="text-center">Keterangan</th>
            <th class="text-center">Harga Total</th>
          </tr>
          <?php $no = 1;
          foreach ($dt_jual as $a) { ?>
            <tr>
              <td class="text-center"><?= $no++; ?></td>
              <td class="text-center"><?= $a['d_jual_barang_nama']; ?></td>
              <td class="text-center">Rp. <?= number_format($a['d_jual_barang_harjul']); ?></td>
              <td class="text-center"><?= $a['d_jual_qty']; ?></td>
              <td class="text-center"><?= $a['d_jual_diskon']; ?></td>
              <td class="text-center">Rp. <?= number_format($a['d_jual_total']); ?></td>
            </tr>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
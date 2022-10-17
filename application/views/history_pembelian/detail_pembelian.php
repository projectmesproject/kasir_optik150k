<!-- Begin Page Content -->
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary text-center">KETERANGAN PEMBELIAN</h6>
  </div>
  <br>
  <div class="card-body">
    <div class="table-responsive">  
    <?php
      $kd = $data['beli_nofak'];

      $total = 0;

      foreach($barang as $t){
        $total = $total + $t['d_beli_total'];
      }

    ?>
      <table class="table table-bordered" width="100%" cellspacing="0">
          <tr>
            <td width="220">No Faktur</td>
            <td width="20">:</td>
            <td><?= $data['beli_nofak']; ?></td>
          </tr>
          <tr>
            <td>Tanggal Penjualan</td>
            <td>:</td>
            <td><?php echo date("d M Y",strtotime($data['beli_tanggal'])); ?></td>
          </tr>
          <tr>
            <td>Suplier</td>
            <td>:</td>
            <td><?= $data['suplier_nama']; ?></td>
          </tr>
          <tr>
            <td>Total Harga</td>
            <td>:</td>
            <td>Rp. <?= number_format($total); ?></td>
          </tr>
      </table>
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
            <th class="text-center">Harga Total</th>
          </tr>
          <?php $no=1; foreach($barang as $b){ ?>
          <tr>
            <td class="text-center"><?= $no++; ?></td>
            <td class="text-center"><?= $b['barang_nama']; ?></td>
            <td class="text-center"><?= number_format($b['d_beli_harga']); ?></td>
            <td class="text-center"><?= $b['d_beli_jumlah']; ?></td>
            <td class="text-center"><?= number_format($b['d_beli_total']); ?></td>
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
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
  <?php
    $dat = $this->session->flashdata('msg2');
    if ($dat != "") { ?>
      <div id="notifikasi" class="alert alert-danger"><strong> </strong> <?= $dat; ?></div>
    <?php } ?>
    <div class="card-header py-3">
      <?php if ($jual['status'] == 'DP') : ?>
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_hutang_karyawan" style="float:left;">
          (+) Bayar
        </button>
      <?php endif ?>
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
          <?php if ($jual['status'] == 'DP') : ?>
            <tr>
              <td>DP</td>
              <td>:</td>
              <td>Rp. <?= number_format($jual['jual_jml_uang']); ?></td>
            </tr>
            <tr>
              <td>Kurang</td>
              <td>:</td>
              <td>Rp. <?= number_format(abs($jual['jual_kurang_uang'])); ?></td>
            </tr>
          <?php endif ?>
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

<!---------------------------------------------Tambah Data---------------------------------------------->
<div class="modal fade" id="add_hutang_karyawan">
  <div class="modal-dialog">

    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Pelunasan DP</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <?php echo form_open('penjualan/bayar_dp') ?>
      <input type="hidden" readonly value="<?= $jual['jual_nofak']; ?>" name="nofak" class="form-control">
      <input type="hidden" readonly value="<?= abs($jual['jual_kurang_uang'])?>" name="kurang" class="form-control">
      <div class="modal-body">
        <div class="form-group">
          <label>Cara Bayar:</label>
          <select required name="cara_bayar" id="cara_bayar" class="form-control">
            <option value="" selected disabled>-- Pilih Cara Bayar --</option>
            <?php foreach ($cara_bayar as $bayar) {
              if($bayar->cara_bayar =='DP')
              continue;
            ?>
              <option value="<?= $bayar->cara_bayar ?>"><?= $bayar->cara_bayar ?></option>
            <?php
            }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="nominal">Bayar : </label>
          <input type="number" id="nominal" name="bayar" class="form-control" placeholder="Bayar" required>
        </div>

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Simpan" />
      </div>
      </form>
    </div>
  </div>
</div>
<!---------------------------------------------Akhir Tambah Data---------------------------------------------->
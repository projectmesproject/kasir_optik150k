        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->


          <?php
          $dat = $this->session->flashdata('msg');
          if ($dat != "") { ?>
            <div class="alert alert-success"><strong>Sukses! </strong> <?= $dat; ?>
              <a class="btn btn-info" href="<?php echo site_url('penjualan/cetak_faktur') ?>" target="_blank"><span class="fa fa-print"></span>Cetak</a>
            </div>
          <?php } ?>

          <?php
          $dat = $this->session->flashdata('muka');
          if ($dat != "") { ?>
            <div class="alert alert-success"><strong>Sukses! </strong> <?= $dat; ?>
              <a class="btn btn-info" href="<?php echo site_url('penjualan/cetak_faktur_dp') ?>" target="_blank"><span class="fa fa-print"></span>Cetak</a>
            </div>
          <?php } ?>

          <!-- FLASH DATA -->
          <?php
          $dat1 = $this->session->flashdata('error');
          if ($dat1 != "") { ?>
            <div id="notifikasi" class="alert alert-danger"><strong>Gagal !</strong> <?= $dat1; ?></div>
          <?php } ?>



          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Penjualan</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-body">
              <?php echo form_open('Penjualan/add_to_cart') ?>
              <div class="table-responsive">
                <a href="#nabar" class="btn btn-info btn-sm"><i class='fas fa-sync'></i> Refresh</a>
                <hr>
                <table>
                  <tr>
                    <th>Nama Barang : </th>
                  </tr>
                  <tr>
                    <th><input type="text" autocomplete="on" name="nabar" id="nabar" class="form-control input-sm" style="width:200px;">
                    </th>
                  </tr>
                  <div id="detail_barangku" style="position:absolute;">
                  </div>
                </table>
              </div>
              </form>
              <br />
              <hr>
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                    <tr>
                      <th>Kode Barang</th>
                      <th>Nama Barang</th>
                      <th>Satuan</th>
                      <th>Harga Jual</th>
                      <th>Keterangan</th>
                      <th>Jumlah Beli</th>
                      <th>Sub Total</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($this->cart->contents() as $items) : ?>
                      <?php echo form_hidden($i . '[rowid]', $items['rowid']); ?>
                      <tr>
                        <td><?= $items['id']; ?></td>
                        <td><?= $items['name']; ?></td>
                        <td style="text-align:center;"><?= $items['satuan']; ?></td>
                        <td style="text-align:right;"><?php echo number_format($items['amount']); ?></td>
                        <td style="text-align:right;"><?php echo $items['disc']; ?></td>
                        <td style="text-align:center;"><?php echo number_format($items['qty']); ?></td>
                        <td style="text-align:right;"><?php echo number_format($items['subtotal']); ?></td>

                        <td style="text-align:center;"><a href="<?php base_url() ?>penjualan/remove/<?= $items['rowid']; ?>" class="btn btn-warning btn-xs"><span class="fa fa-close"></span> Batal</a></td>
                      </tr>

                      <?php $i++; ?>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                <br>

                <?php echo form_open('Penjualan/simpan_penjualan') ?>
                <a href="#no_hp" class="btn btn-info btn-sm"><i class='fas fa-sync'></i> Refresh</a>

                <hr>
                <table>
                  <tr>
                    <div id="no"></div>
                    <th>No HP : </th>
                  </tr>
                  <tr>
                    <th><input type="text" name="no_hp" list="list_no" autocomplete="off" id="no_hp" class="form-control input-sm" style="width:150px;" required>
                      <datalist id="list_no">
                        <?php foreach ($nohp->result() as $nohp) : ?>
                          <option value="<?= $nohp->no_hp ?>"><?= $nohp->no_hp ?></option>
                        <?php endforeach ?>
                      </datalist>
                    </th>
                  </tr>
                  <div id="detail_customer" style="position:absolute;">
                  </div>
                </table>
                <br>
                <div class="row">
                  <div class="form-group col-sm-3">
                    <label class="font-weight-bold">Total Belanja(Rp) :</label>
                    <input type="text" name="total2" value="<?php echo number_format($this->cart->total()); ?>" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly></th>
                    <input type="hidden" id="total" name="total" value="<?php echo $this->cart->total(); ?>" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly />
                  </div>
                  <div class="form-group col-sm-2">
                    <label class="font-weight-bold">Cara Bayar 1 :</label>
                    <select required name="bayar" id="bayar" class="form-control">
                      <option value="" selected disabled>-- Pilih Cara Bayar --</option>
                      <?php foreach ($cara_bayar as $bayar) {
                      ?>
                        <option value="<?= $bayar->cara_bayar ?>"><?= $bayar->cara_bayar ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-sm-2">
                    <label class="font-weight-bold">Keterangan 1 :</label>
                    <input type="text" id="diskon" name="diskon" class="diskon form-control input-sm" required>
                  </div>
                  <div class="form-group col-sm-2">
                    <label class="font-weight-bold">Cara Bayar 2 :</label>
                    <select required name="bayar" id="bayar" class="form-control">
                      <option value="" selected disabled>-- Pilih Cara Bayar --</option>
                      <?php foreach ($cara_bayar as $bayar) {
                      ?>
                        <option value="<?= $bayar->cara_bayar ?>"><?= $bayar->cara_bayar ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-sm-2">
                    <label class="font-weight-bold">Keterangan 2 :</label>
                    <input type="text" id="diskon" name="diskon" class="diskon form-control input-sm" required>
                  </div>
                </div>
                <br>
                <table>

                  <tr>
                    <td class="col-sm-6" rowspan="3"><button type="submit" class="btn btn-success btn-lg"> CETAK</button></td>
                    <th colspan="4">Total Yang Harus Dibayar (Rp) : </th>
                    <th style="text-align:right;"><input type="text" id="totbayar" value="0" min="0" name="totbayar" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly></th>
                  </tr>



                  <tr>
                    <th colspan="4">Tunai 1(Rp) :</th>
                    <th style="text-align:right;"><input type="text" id="jml_uang" name="jml_uang" class="jml_uang form-control input-sm" style="text-align:right;margin-bottom:5px;" required></th>

                  </tr>
                  <tr>
                    <th colspan="4">Tunai 2(Rp) :</th>
                    <th style="text-align:right;"><input type="text" id="jml_uang" name="jml_uang" class="jml_uang form-control input-sm" style="text-align:right;margin-bottom:5px;" required></th>

                  </tr>
                  <tr>
                    <td></td>
                    <th colspan="4">Kembalian(Rp) :</th>
                    <th style="text-align:right;"><input type="text" id="kembalian" name="kembalian" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" required></th>
                  </tr>


                </table>


                </form>

              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        </div>

        <!-- End of Main Content -->



        <script type='text/javascript'>
          $(function() {

            $("#nabar").autocomplete({
              source: function(request, response) {

                $.ajax({
                  url: "ajax/getDataBarang",
                  type: 'post',
                  dataType: "json",
                  data: {
                    search: request.term
                  },
                  success: function(data) {
                    response(data);
                  }
                });
              },
              select: function(event, ui) {
                var str = ui.item.value;
                var res = str.split("#");

                $('#nabar').val(ui.item.label); // display the selected text
                $('#kode_brg').val(res[1]); // save selected id to input
                $('#harjul').val(res[0]); // save selected id to input
                $('#satuan').val(res[2]); // save selected id to input
                $('#stok').val(res[3]); // save selected id to input
                return false;
              },
              focus: function(event, ui) {
                var str = ui.item.value;
                var res = str.split("#");
                $("#nabar").val(ui.item.label);
                $("#kode_brg").val(res[1]);
                $('#harjul').val(res[0]);
                $('#satuan').val(res[2]); // save selected id to input
                $('#stok').val(res[3]); // save selected id to input
                return false;
              },
            });

          });
        </script>
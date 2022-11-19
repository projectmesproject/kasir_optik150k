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

          $dat = $this->session->flashdata('msg_brg');
          if ($dat != "") { ?>
            <div class="alert alert-success"><strong>Sukses! </strong> <?= $dat; ?>
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
              <div class="row">
                <div class="form-group col-sm-3" style="position: relative;">
                  <label>Nama Barang : </label>
                  <input class="form-control" id="nabar" type="search" autocomplete="off" />
                  <div class="ajax_list_barang">
                    <ul style="list-style:none;" class="list_container" id="list_container">

                    </ul>
                  </div>
                </div>
                <div class="form-group" style="max-width: 10%;">
                  <label>Satuan :</label>
                  <input type="text" readonly id="satuan_ket" name="satuan" class="form-control" />
                  <input type="hidden" readonly id="kode_brg_ket" name="kode_brg_ket" class="form-control" />
                </div>
                <div class="form-group col-sm-1">
                  <label>Stok :</label>
                  <input type="text" readonly id="stok_ket" name="stok_ket" class="form-control" />
                </div>
                <div class="form-group col-sm-2">
                  <label>Harga(Rp) :</label>
                  <input type="text" readonly id="harga_ket" name="harga_ket" class="form-control" />
                </div>
                <div class="form-group col-sm-4">
                  <label>Keterangan :</label>
                  <input type="text" id="keterangan" name="keterangan" class="form-control" />
                </div>
                <div class="form-group col-sm-2">
                  <label>Jumlah :</label>
                  <input type="number" readonly id="jumlah_ket" name="jumlah_ket" class="form-control" />
                </div>
                <div class="form-group col-sm-3">
                  <label>&nbsp;</label><br />
                  <button class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
                </div>
              </div>
              <!-- <div class="table-responsive">
                <a href="#nabar" class="btn btn-info btn-sm"><i class='fas fa-sync'></i> Refresh</a>
                <hr>
                <table class="border">
                  <tr>
                    <th>Nama Barang : </th>
                  </tr>
                  <tr>
                    <th class="col-sm-12">
                      
                    </th>
                  </tr>
                  <div id="detail_barangku" style="position:absolute;">
                  </div>
                </table>
              </div> -->
              </form>
              <br />
              <hr>
              <div class="" style="overflow: hidden;">
                <div class="table-responsive" id="result_table">
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
                </div>
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
                    <th><input type="number" name="no_hp" list="list_no" autocomplete="off" id="no_hp" class="form-control input-sm" style="width:250px;" required>
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
                    <label class="font-weight-bold">Cara Bayar 2 :</label>
                    <select name="bayar2" id="bayar2" class="form-control">
                      <option value="" selected>-- Pilih Cara Bayar --</option>
                      <?php foreach ($cara_bayar as $bayar) {

                        if ($bayar->cara_bayar == 'DP')
                          continue;
                      ?>
                        <option value="<?= $bayar->cara_bayar ?>"><?= $bayar->cara_bayar ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-sm-2" id="status">
                    <label class="font-weight-bold">Status :</label>
                    <select name="status" id="status" class="form-control">
                      <option value="COMPLETE">Lunas</option>
                      <option value="DP">DP</option>
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="font-weight-bold">Keterangan :</label>
                    <input type="text" id="diskon" name="diskon" class="diskon form-control input-sm" required>
                  </div>
                </div>
                <br>
                <?php
                // var_dump($paket);
                foreach ($paket as $pkt) {
                ?>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input checkPaket" type="checkbox" data-kode_brg='<?= $pkt->barang_id ?>' id="pkt<?= $pkt->barang_id ?>" value="<?= $pkt->barang_id ?>">
                    <label class="form-check-label" for="pkt<?= $pkt->barang_id ?>"><?= $pkt->barang_nama ?></label>
                  </div>

                <?php
                }
                ?>
                <table>

                  <tr>
                    <td class="col-sm-6" rowspan="3"><button type="submit" class="btn btn-success btn-lg"> CETAK</button></td>
                    <th colspan="4">Total Yang Harus Dibayar (Rp) : </th>
                    <th style="text-align:right;"><input type="text" id="totbayar" value="<?php echo number_format($this->cart->total()); ?>" min="0" name="totbayar" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly></th>
                  </tr>



                  <tr>
                    <th colspan="4">Tunai 1(Rp) :</th>
                    <th style="text-align:right;"><input type="text" id="jml_uang" name="jml_uang" class="jml_uang form-control input-sm" style="text-align:right;margin-bottom:5px;" required></th>

                  </tr>
                  <tr id="tunai2_la_">
                    <th colspan="4">Tunai 2(Rp) :</th>
                    <th style="text-align:right;"><input type="text" id="jml_uang2" name="jml_uang2" class="jml_uang2 form-control input-sm" style="text-align:right;margin-bottom:5px;" required></th>

                  </tr>
                  <tr>
                    <td></td>
                    <th colspan="4" id="kembalian_label">Kembalian(Rp) :</th>
                    <th style="text-align:right;"><input type="text" id="kembalian" name="kembalian" class="form-control input-sm kembalian" style="text-align:right;margin-bottom:5px;" required readonly></th>
                  </tr>


                </table>


                </form>

              </div>
            </div>
          </div>
          <div class="modal fade" id="add_barang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Tambah Barang</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <?php echo form_open_multipart('Penjualan/tambah_barang') ?>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="nama">Nama Barang : </label>
                    <input type="text" id="nabar" name="nabar" class="form-control" placeholder="Nama Barang" required>
                  </div>

                  <div class="form-group">
                    <label for="satuan">Satuan : </label>
                    <select required name="satuan" id="satuan" class="form-control">
                      <option value="buah">Buah</option>
                    </select>

                  </div>

                  <div class="form-group">
                    <label for="hargapokok">Harga Pokok : </label>
                    <input type="text" id="harpok" name="harpok" class="form-control" placeholder="Harga Pokok" required>
                  </div>

                  <div class="form-group">
                    <label for="hargajual">Harga Jual : </label>
                    <input type="text" id="harjul" name="harjul" class="form-control" placeholder="Harga Jual" required>
                  </div>

                  <div class="form-group">
                    <label for="stok">Stok : </label>
                    <input type="text" id="stok" name="stok" class="form-control" placeholder="Stok" required>
                  </div>

                  <div class="form-group">
                    <label for="minimalstok">Minimal Stok : </label>
                    <input type="text" id="min_stok" name="min_stok" class="form-control" placeholder="Minimal Stok" required>
                  </div>

                  <div class="form-group">
                    <label for="serial">Serial Number : </label>
                    <input type="text" id="sn" name="sn" class="form-control" placeholder="Serial Number" required>
                  </div>

                  <div class="form-group">
                    <label for="Kategori">Kategori : </label>
                    <select required name="kategori" id="kategori" class="form-control">
                      <option value="">-- Pilih Kategori --</option>
                      <?php foreach ($kat->result() as $x) {
                        $id = $x->kategori_id;
                        $nm = $x->kategori_nama;
                      ?>

                        <option value="<?php echo $id; ?>"><?php echo $nm; ?></option>


                      <?php } ?>
                    </select>
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
        </div>
        <!-- /.container-fluid -->

        </div>

        <!-- End of Main Content -->



        <script type='text/javascript'>
          $("#jml_uang2").prop('readonly', true)
          $('.ajax_list_barang').hide()
          $(document).ready(function() {

            $('.select').select2();

          })

          function loadData() {
            $('#dataTable tr').each(function() {
              var kode_brg = $(this).find("td:first").html();
              const selected = [];
              $(".form-check input[type=checkbox]").each(function() {
                selected.push(this.value);
              });
              selected.map((item, index) => {
                if (item == kode_brg) {
                  $('#pkt' + kode_brg).prop('checked', true);
                }
              })
            });
          }
          $("#bayar2").change(function() {
            if (!$("#bayar").val()) {
              swal.fire("Penjualan", "Bayar 1 Harus dipilih", "warning")
              $(this).val("")
            } else {
              if ($(this).val() == "") {
                $("#jml_uang2").prop('readonly', true)
                $("#jml_uang2").val(0)
              } else {
                $("#jml_uang2").prop('readonly', false)
              }
            }

          })
          $(".checkPaket").click(function() {
            let kode_brg = $(this).attr('data-kode_brg')
            if ($(this).is(':checked')) {
              $.ajax({
                url: '<?= base_url() ?>/penjualan/add_to_cart_paket',
                cache: false,
                type: 'POST',
                data: {
                  "kode_brg": kode_brg
                },
                success: function(res) {
                  $('#result_table').html(res)
                }
              })
            } else {
              $.ajax({
                url: '<?= base_url() ?>/penjualan/remove_paket',
                cache: false,
                type: 'POST',
                data: {
                  "kode_brg": kode_brg
                },
                success: function(res) {
                  $('#result_table').html(res)
                }
              })
            }

          })


          $('#nabar').keyup(function() {
            let search = $(this).val();
            if (search == "") {
              $('.ajax_list_barang').hide()
            } else {
              $.ajax({
                url: '<?= base_url() ?>/penjualan/get_barang_autocomplete',
                type: 'POST',
                cache: false,
                data: {
                  "search": search
                },
                success: function(res) {

                  $('.ajax_list_barang').show()
                  $("#list_container").html(res)
                  $('.item_barang').click(function() {
                    let value = $(this).attr('data-value')
                    let label = $(this).text()
                    $('#nabar').val(label)
                    if (value != "tambah_barang") {
                      var res = value.split("#");
                      console.log(res)
                      $('#harga_ket').val(formatUang(res[0]))
                      $('#kode_brg_ket').val(res[1])
                      $('#jumlah_ket').val(1)
                      $('#satuan_ket').val(res[2])
                      $('#stok_ket').val(res[3])
                    } else {
                      $('#add_barang').modal('show')
                    }
                    $('.ajax_list_barang').hide()
                  })
                }
              })
            }

          })

          // $(function() {
          //   loadData()


          //   $("#nabar").autocomplete({
          //     source: function(request, response) {

          //       $.ajax({
          //         url: "ajax/getDataBarang",
          //         type: 'post',
          //         dataType: "json",
          //         data: {
          //           search: request.term
          //         },
          //         success: function(data) {
          //           response(data);
          //         }
          //       });
          //     },
          //     select: function(event, ui) {
          //       var str = ui.item.value;
          //       var res = str.split("#");

          //       $('#nabar').val(ui.item.label); // display the selected text
          //       $('#kode_brg').val(res[1]); // save selected id to input
          //       $('#harjul').val(res[0]); // save selected id to input
          //       $('#satuan').val(res[2]); // save selected id to input
          //       $('#stok').val(res[3]); // save selected id to input
          //       return false;
          //     },
          //     focus: function(event, ui) {
          //       var str = ui.item.value;
          //       var res = str.split("#");
          //       $("#nabar").val(ui.item.label);
          //       $("#kode_brg").val(res[1]);
          //       $('#harjul').val(res[0]);
          //       $('#satuan').val(res[2]); // save selected id to input
          //       $('#stok').val(res[3]); // save selected id to input
          //       return false;
          //     },
          //   });

          // });
        </script>
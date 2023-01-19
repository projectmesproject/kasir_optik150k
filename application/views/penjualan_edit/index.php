    <style>
      .ui-autocomplete {
        z-index: 1050;
        max-height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
      }
    </style>
    <!-- Begin Page Content -->
    <div class="container-fluid">
      <!-- Page Heading -->

      <!-- FLASH DATA -->
      <?php
      $total = 0;
      $dat = $this->session->flashdata('sukses');
      if ($dat != "") { ?>
        <div id="notifikasi" class="alert alert-success"><strong>Sukses! </strong> <?= $dat; ?>
        </div>
      <?php } ?>

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

          <?php echo form_open('Penjualan_edit/add_to_cart') ?>
          <div class="row">
            <div class="form-group col-sm-3" style="position: relative;">
              <label>Nama Barang : </label>
              <input class="form-control" name="nomor_faktur" value="<?= $this->uri->segment(3) ?>" type="hidden" />
              <input class="form-control" id="nabar" name="nabars" type="search" autocomplete="off" />
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
              <?php if ($this->session->userdata('level') == "penjualan") { ?>
                <input type="text" readonly id="harga_ket_cabang" name="harga_ket" class="form-control" />
              <?php } else { ?>
                <input type="text" readonly id="harga_ket" name="harga_ket" class="form-control" />
              <?php  } ?>
            </div>
            <div class="form-group col-sm-4">
              <label>Keterangan :</label>
              <input type="text" id="keterangan" name="keterangan" class="form-control" />
            </div>
            <div class="form-group col-sm-2">
              <label>Jumlah :</label>
              <input type="number" readonly id="jumlah_ket" name="jumlah_ket" class="form-control" min="0" />
            </div>
            <div class="form-group col-sm-3">
              <label>&nbsp;</label><br />
              <button class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
            </div>
          </div>
          </form>
          <hr>


          <div class="" style="overflow: hidden;">
            <div class="table-responsive" id="result_table">
              <table class="table table-bordered table-hover" id="tbl" width="100%" cellspacing="0">
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
                  <?php

                  foreach ($penjualan as $v) {

                  ?>
                    <tr>
                      <td><?php echo $v["d_jual_barang_id"]; ?></td>
                      <td><?php echo $v["d_jual_barang_nama"]; ?></td>
                      <td><?php echo $v["d_jual_barang_satuan"]; ?></td>
                      <td><?php echo number_format($v["d_jual_barang_harjul"]); ?></td>
                      <td>Keterangan</td>
                      <form action="<?= base_url('penjualan_edit/update_qty_detail/' . $v['d_jual_id']) ?>" method="POST">
                        <td>
                          <input type="hidden" name="nomorfaktur" value="<?= $this->uri->segment(3) ?>">
                          <input type="text" name="d_jual_qty" value="<?= $v['d_jual_qty'] ?>">
                        </td>
                      </form>
                      <td><?php echo number_format($v["d_jual_barang_harjul"] * $v["d_jual_qty"]); ?></td>
                      <?php
                      $subtotal = $v["d_jual_barang_harjul"] * $v["d_jual_qty"];
                      $total = $total + $subtotal;

                      ?>
                      <td style="text-align:center;"><a href="<?= base_url('penjualan_edit/remove_from_edit/' . $v['d_jual_id']) ?>?kd=<?php echo $this->uri->segment(3); ?>" class="btn btn-warning btn-xs"><span class="fa fa-close"></span> Delete</a></td>
                    </tr>
                  <?php } ?>

                </tbody>
                <tfoot>
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
                </tfoot>
              </table>
              <br>

              <!-- <?php echo form_open('Penjualan/simpan_penjualan') ?> -->
              <a href="#no_hp" class="btn btn-info btn-sm"><i class='fas fa-sync'></i> Refresh</a>
              <form action="<?= base_url('penjualan_edit/simpan_ulang') ?>" method="POST">


                <hr>
                <table>
                  <tr>
                    <div id="no"></div>
                    <th>No HP : </th>
                  </tr>
                  <tr>
                    <th><input type="text" name="no_hp" list="list_no" autocomplete="off" id="no_hp" value="<?= $penjualan[0]['no_hp'] ?>" class="form-control input-sm" style="width:150px;" required>
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
                <table>

                  <tr>
                    <?php if ($this->uri->segment(3) == $penjualan[0]['jual_nofak']) { ?>
                      <th style="width:140px;">Total Belanja(Rp) :</th>
                      <th style="text-align:right;width:140px;"><input type="text" name="jual_total" value="<?= $total ?>" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly></th>
                      <!-- <input type="hidden" id="total" name="total" value="<?php echo $this->cart->total(); ?>" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly> -->
                      <th>Cara Bayar 1 : </th>
                      <th style="text-align:right;">
                        <select name="jual_keterangan" id="cara_bayar1" class="form-control">
                          <option value="">-- Pilih Cara Bayar --</option>
                          <option value="Cash">Cash</option>
                          <option value="Uang Muka">Uang Muka</option>
                          <option value="Lunas">Lunas</option>
                          <option value="Debit">Debit</option>
                          <option value="Kredit">Kredit</option>
                          <option value="Transfer">Transfer</option>
                          <option value="OVO">OVO</option>
                          <option value="LINK">LINK</option>
                          <option value="DANA">DANA</option>
                          <option value="Lain-Lain">Lain-Lain</option>
                        </select>
                        <!-- <input type="text" id="diskon" value="<?= $penjualan[0]['jual_keterangan'] ?>" name="diskon" class="diskon form-control input-sm" style="text-align:right;margin-bottom:5px;width:150px" required> -->
                      </th>

                      <th>Cara Bayar 2 : </th>
                      <th style="text-align:right;">
                        <select name="jual_keterangan2" id="cara_bayar2" class="form-control">
                          <option value="">-- Pilih Cara Bayar --</option>
                          <option value="Uang Muka">Uang Muka</option>
                          <option value="Lunas">Lunas</option>
                          <option value="Debit">Debit</option>
                          <option value="Kredit">Kredit</option>
                          <option value="Transfer">Transfer</option>
                          <option value="OVO">OVO</option>
                          <option value="LINK">LINK</option>
                          <option value="DANA">DANA</option>
                          <option value="Lain-Lain">Lain-Lain</option>
                        </select>
                      </th>
                    <?php   }  ?>






                  </tr>
                  <br>
                  <?php
                  // var_dump($paket);
                  if ($this->session->userdata('level') == 'admin') {
                    foreach ($paket as $pkt) {
                  ?>
                      <div class="form-check form-check-inline">
                        <input type="hidden" id="nomor_faktur" value="<?= $this->uri->segment(3) ?>">
                        <input class="form-check-input checkPaket" type="checkbox" style=" width: 40px; height: 40px; " data-kode_brg='<?= $pkt->barang_id ?>' id="pkt<?= $pkt->barang_id ?>" value="<?= $pkt->barang_id ?>">
                        <label class="form-check-label" for="pkt<?= $pkt->barang_id ?>"><?= $pkt->barang_nama ?></label>
                      </div>

                  <?php
                    }
                  }
                  ?>
                </table>
                <br>
                <table>

                  <tr>
                    <td style="width:760px;" rowspan="2"><button type="submit" class="btn btn-success btn-lg"> SAVE</button></td>
                    <th>Total Yang Harus Dibayar (Rp) : </th>
                    <th style="text-align:right;"><input type="text" id="totalbayar_edit" value="<?= $total ?>" min="0" class="form-control input-sm" style="text-align:right;margin-bottom:5px;width:150px" readonly></th>
                    <input type="hidden" name="nofak" value="<?= $this->uri->segment(3) ?>">
                    <input type="hidden" name="jual_tanggal" value="<?= $penjualan[0]['jual_tanggal'] ?>">
                  </tr>



                  <tr>
                    <th>Tunai(Rp) 1 :</th>
                    <th style="text-align:right;"><input type="text" id="tunai_edit" name="jual_jml_uang" value="<?= $penjualan[0]['jual_jml_uang'] ?>" class="form-control input-sm" style="text-align:right;margin-bottom:5px;"></th>
                  </tr>

                  <tr>
                    <td></td>
                    <th>Tunai(Rp) 2 :</th>
                    <th style="text-align:right;"><input type="text" id="tunai_edit2" name="jual_jml_uang2" value="<?= $penjualan[0]['jual_jml_uang2'] ?>" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" min="0"></th>
                  </tr>
                  <tr>
                    <td></td>
                    <th>Kembalian(Rp) :</th>
                    <th style="text-align:right;"><input type="text" id="kembalian_edit" name="jual_kembalian" class="form-control input-sm" style="text-align:right;margin-bottom:5px;"></th>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script type='text/javascript'>
      $(document).ready(function() {
        // $('input[name="nabar"]').autocomplete({
        //   source: "<?= base_url('Barang/autoBarang/'); ?>"
        // });
        $('.select').select2();
        loadData()
      })

      function loadData() {
        $('#tbl tr').each(function() {
          var kode_brg = $(this).find("td:first").html();
          console.log(this.value)
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
                  <?php if ($this->session->userdata('level') == 'penjualan') { ?>
                    $('#harga_ket_cabang').val(formatUang(res[4]))
                  <?php } else { ?>
                    $('#harga_ket').val(formatUang(res[0]))
                  <?php } ?>
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

      $(".checkPaket").click(function() {
        let kode_brg = $(this).attr('data-kode_brg')
        let nomor_faktur = $('#nomor_faktur').val()
        if ($(this).is(':checked')) {
          $.ajax({
            url: '<?= base_url() ?>penjualan_edit/add_to_cart_paket',
            cache: false,
            type: 'POST',
            data: {
              "nabars": kode_brg,
              "nomor_faktur": nomor_faktur
            },
            success: function(res) {
              console.log(res)
              // $('#result_table').html(res)
              location.reload()
            }
          })
        } else {
          $.ajax({
            url: '<?= base_url() ?>/penjualan_edit/remove_paket',
            cache: false,
            type: 'POST',
            data: {
              "nabar": kode_brg,
              "nomor_faktur": nomor_faktur
            },
            success: function(res) {
              // $('#result_table').html(res)
              location.reload()
            }
          })
        }

      })

      $(function() {
        let tes = $('#cara_bayar1').val('<?= $penjualan[0]["jual_keterangan"] ?>').trigger('change')
        let tes2 = $('#cara_bayar2').val('<?= $penjualan[0]["jual_keterangan2"] ?>').trigger('change')
        console.log("carabayar1", tes, tes2)
      });

      $("#tunai_edit").keyup(function() {
        var tunai = $("#tunai_edit").val();
        var tunai2 = $("#tunai_edit2").val();
        var total_atas = $("#total").val();
        var grand_total = $("#totalbayar_edit").val();
        var kembalian = $("#kembalian_edit").val();
        var total_tunai = tunai + tunai2
        var hitung = grand_total - total_tunai
        $("#kembalian_edit").val(hitung)
      });
      $("#tunai_edit2").keyup(function() {
        var tunai = $("#tunai_edit").val();
        var tunai2 = $("#tunai_edit2").val();
        var total_atas = $("#total").val();
        var grand_total = $("#totalbayar_edit").val();
        var kembalian = $("#kembalian_edit").val();
        var total_tunai = parseInt(tunai) + parseInt(tunai2)
        var hitung = grand_total - total_tunai
        $("#kembalian_edit").val(hitung)
      });
    </script>
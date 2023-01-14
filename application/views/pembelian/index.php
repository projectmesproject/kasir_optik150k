        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Data Pembelian</h1>


          <!-- DataTales Example -->
          <div class="card shadow mb-4">

            <!-- FLASH DATA -->
            <?php
            $dat = $this->session->flashdata('msg');
            if ($dat != "") { ?>
              <div id="notifikasi" class="alert alert-success"><strong>Sukses! </strong> <?= $dat; ?></div>
            <?php } ?>

            <!-- FLASH DATA -->
            <?php
            $dat1 = $this->session->flashdata('error');
            if ($dat1 != "") { ?>
              <div id="notifikasi" class="alert alert-danger"><strong>Gagal </strong> <?= $dat1; ?></div>
            <?php } ?>




            <div class="card-body">

              <?php echo form_open('Pembelian/add_to_cart') ?>

              <div class="form-group row">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <div class="col-sm-3">
                  <label for="kodebarang"><strong> No Faktur : </strong></label>
                  <?php $this->load->model('M_pembelian');
                  $kode_belii = $this->m_pembelian->get_kobel();
                  ?>
                  <input type="text" name="nofak" value="<?= $kode_belii; ?>" class="form-control" placeholder="No Faktur" required>
                </div>

                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="col-sm-4">
                  <label for="suplier"><strong>Suplier :</strong></label>
                  <select required name="suplier" id="suplier" class="form-control">
                    <option value="">-- Pilih Suplier --</option>
                    <?php foreach ($sup->result_array() as $i) {
                      $id_sup = $i['suplier_id'];
                      $nm_sup = $i['suplier_nama'];
                      $al_sup = $i['suplier_alamat'];
                      $notelp_sup = $i['suplier_notelp'];
                      $sess_id = $this->session->userdata('suplier');
                      if ($sess_id == $id_sup)
                        echo "<option value='$id_sup' selected>$nm_sup</option>";
                      else
                        echo "<option value='$id_sup'>$nm_sup</option>";
                    } ?>
                  </select>
                </div>

              </div>

              <div class="form-group row">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <div class="col-sm-3">
                  <label for="kodebarang"><strong>Tanggal :</strong></label>
                  <input type="date" id="tgl" name="tgl" value="<?php echo $this->session->userdata('tglfak'); ?>" class="form-control" placeholder="Tanggal" required>
                </div>
              </div>

              <hr>


              <!-- <th>Kode Barang : </th> -->
              <!-- </tr>
                <tr>
                  <th> -->
              <div class="row">
                <div class="form-group col-sm-2">
                  <label>Kode Barang :</label>
                  <input class="form-control input-sm" id="kode_brg" name="kode_brg" type="search" autocomplete="off" />
                  <div class="ajax_list_barang" style="width: 550px;">
                    <ul style="list-style:none;display:none;" class="list_container" id="list_container">

                    </ul>
                  </div>
                </div>
                <div class="form-group col-sm-4">
                  <label>Nama Barang :</label>
                  <input type="text" readonly id="nabar" name="nabar" class="form-control" />
                </div>
                <div class="form-group col-sm-2">
                  <label>Satuan :</label>
                  <input type="text" readonly id="satuan" name="satuan" class="form-control" />
                </div>
                <div class="form-group col-sm-2">
                  <label>Harga Beli :</label>
                  <input type="text" id="harpok" name="harpok" class="form-control" required />
                </div>
                <div class="form-group col-sm-2">
                  <label>Jumlah :</label>
                  <input type="number" id="jumlah" name="jumlah" class="form-control" min="0" required />
                </div>
                <div class="form-group ml-3">
                  <label>&nbsp;</label><br />
                  <button class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
                </div>
              </div>
              <!-- <input type="text" name="kode_brg" id="kode_brg" class="form-control input-sm select2" style="width:150px;"> -->
              <!-- </th>
                </tr>
                <div id="detail_barang" style="position:absolute;">

                </div>
              </table>

              </form> -->
              <hr>


              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                    <tr>
                      <th>Kode Barang</th>
                      <th>Nama Barang</th>
                      <th>Satuan</th>
                      <th>Harga Beli</th>
                      <th>Jumlah Beli</th>
                      <th>Sub Total</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Kode Barang</th>
                      <th>Nama Barang</th>
                      <th>Satuan</th>
                      <th>Harga Pokok</th>
                      <th>Jumlah Beli</th>
                      <th>Sub Total</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($this->cart->contents() as $items) : ?>
                      <?php echo form_hidden($i . '[rowid]', $items['rowid']); ?>
                      <tr>
                        <td><?= $items['id']; ?></td>
                        <td><?= $items['name']; ?></td>
                        <td style="text-align:center;"><?= $items['satuan']; ?></td>
                        <td style="text-align:right;"><?php echo number_format($items['price']); ?></td>
                        <td style="text-align:center;"><?php echo number_format($items['qty']); ?></td>
                        <td style="text-align:right;"><?php echo number_format($items['subtotal']); ?></td>
                        <td style="text-align:center;"><a href="<?php base_url() ?>pembelian/remove/<?= $items['rowid']; ?>" class="btn btn-warning btn-xs"><span class="fa fa-close"></span> Batal</a></td>
                      </tr>
                      <?php $i++; ?>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="6" style="text-align:center;">Total</td>
                      <td style="text-align:right;">Rp. <?php echo number_format($this->cart->total()); ?></td>
                    </tr>
                  </tfoot>
                </table>
                <br>
                <div class="col-sm">
                  <a href="<?php echo site_url('pembelian/simpan_pembelian') ?>" class="btn btn-success btn-lg"><span class="fa fa-save"></span> Simpan</a>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        </div>

        <script>
          $('#kode_brg').keyup(function() {
            let search = $(this).val();
            if (search == "") {
              $('.ajax_list_barang').hide()
            } else {
              $.ajax({
                url: '<?= base_url() ?>/pembelian/get_kode_barang_autocomplete',
                type: 'POST',
                cache: false,
                data: {
                  "search": search
                },
                success: function(res) {

                  $('.ajax_list_barang').show()
                  $('#list_container').show()
                  $("#list_container").html(res)
                  $('.item_barang').click(function() {
                    let value = $(this).attr('data-value')
                    if (value != "tambah_barang") {
                      var res = value.split("#");
                      console.log(res)
                      // $('#harga_ket').val(formatUang(res[0]))
                      // $('#kode_brg_ket').val(res[1])
                      $('#kode_brg').val(res[0])
                      $('#nabar').val(res[1])
                      $('#harpok').val(res[2])
                      $('#harjul').val(res[3])
                      $('#satuan').val(res[5])
                      $("#jumlah").val('1')
                      // $('#jumlah_ket').val(1)
                      // $('#satuan_ket').val(res[2])
                      // $('#stok_ket').val(res[3])
                    } else {
                      $('#add_barang').modal('show')
                    }
                    $('.ajax_list_barang').hide()
                  })
                }
              })
            }

          })
        </script>

        <!-- End of Main Content -->
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Data Barang Rusak</h1>


          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- FLASH DATA -->
              <?php
              $dat = $this->session->flashdata('msg');
              if ($dat != "") { ?>
                <div id="notifikasi" class="alert alert-success"><strong>Sukses! </strong> <?= $dat; ?></div>
              <?php } ?>
              <!-- Button to Open the Modal -->
              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_barang">
                (+) TAMBAH
              </button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                    <tr>
                      <th>No</th>
                      <th>Kode Barang</th>
                      <th>Nama Barang</th>
                      <th>Jumlah</th>
                      <th>Keterangan</th>
                      <th>Tanggal</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Kode Barang</th>
                      <th>Nama Barang</th>
                      <th>Jumlah</th>
                      <th>Keterangan</th>
                      <th>Tanggal</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    $no = 1;
                    foreach ($data->result() as $a) :
                      $no + 1;
                      $id_rusak = $a->id_rusak;
                      $id = $a->barang_id;
                      $nm = $a->barang_nama;
                      $jumlah = $a->jumlah;
                      $ket = $a->keterangan;
                      $tgl = $a->tanggal;

                    ?>
                      <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $id; ?></td>
                        <td><?php echo $nm; ?></td>
                        <td><?php echo $jumlah; ?></td>
                        <td><?php echo $ket; ?></td>
                        <td><?php echo $tgl; ?></td>

                        <td>
                          <a class="badge badge-success" href="#modal-edit<?php echo $id_rusak ?>" data-toggle="modal" title="Edit"><span class="fas fa-fw fa-edit"></span> Edit</a>
                          <a class="badge badge-danger" href="#modal-hapus<?php echo $id_rusak ?>" data-toggle="modal" title="Hapus"><span class="fas fa-fw fa-trash"></span> Hapus</a>
                        </td>
                      </tr>
                      <?php $no++; ?>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!---------------------------------------------Tambag Data---------------------------------------------->
        <div class="modal fade" id="add_barang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Tambah Barang Rusak</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <?php echo form_open('Barang_rusak/tambah_barang') ?>
              <div class="modal-body">

                <div class="form-group">
                  <label for="Kategori">Nama Barang : </label><br>
                  <select name="barang" class="form-control">
                    <option value="">-- Pilih Barang --</option>
                    <?php foreach ($kat->result() as $x) {
                      $id = $x->barang_id;
                      $nm = $x->barang_nama;
                    ?>

                      <option value="<?php echo $id; ?>"><?php echo $nm; ?></option>


                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="nama">Jumlah : </label>
                  <input type="text" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah Barang" required>
                </div>



                <div class="form-group">
                  <label for="keterangan">Keterangan: </label>
                  <input type="text" id="ket" name="ket" class="form-control" placeholder="Keterangan" required>
                </div>

                <div class="form-group">
                  <label for="tanggal">Tanggal : </label>
                  <input type="date" id="tgl" name="tgl" class="form-control" placeholder="Harga Jual" required>
                </div>




              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <input type="submit" name="submit" id="submit" class="btn btn-primary" value="SImpan" />
              </div>
              </form>
            </div>
          </div>
        </div>


        <!---------------------------------------------EDIT Data---------------------------------------------->
        <?php $no = 0;
        foreach ($data->result() as $x) : $no++; ?>

          <div class="modal fade" id="modal-edit<?= $x->id_rusak; ?>">
            <div class="modal-dialog">

              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Edit Barang </h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->


                <?php echo form_open('Barang_rusak/edit_barang') ?>
                <div class="modal-body">

                  <input type="hidden" readonly value="<?= $x->id_rusak; ?>" name="id" class="form-control">

                  <div class="form-group">
                    <label for="Kategori">Nama Barang : </label>
                    <select name="barang" class="form-control" disabled>
                      <option value='<?= $x->id_barang; ?>' selected><?= $x->barang_nama; ?></option>";
                      <!-- <?php foreach ($kat->result() as $value) {
                            ?>
                        <option value="<?= $value->barang_id ?>"><?= $value->barang_nama; ?></option>
                      <?php } ?> -->
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="nama">Jumlah : </label>
                    <input type="text" id="jumlah" name="jumlah" value="<?php echo $x->jumlah ?>" class="form-control" placeholder="Jumlah Barang" required>
                  </div>



                  <div class="form-group">
                    <label for="keterangan">Keterangan: </label>
                    <input type="text" id="ket" name="ket" value="<?php echo $x->keterangan ?>" class="form-control" placeholder="Keterangan" required>
                  </div>

                  <div class="form-group">
                    <label for="tanggal">Tanggal : </label>
                    <input type="date" id="tgl" name="tgl" value="<?php echo $x->tanggal ?>" class="form-control" placeholder="Harga Jual" required>
                  </div>



                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Edit" />
                </div>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>


        <!---------------------------------------------Hapus  Data---------------------------------------------->
        <?php $no = 0;
        foreach ($data->result() as $x) : $no++; ?>

          <div class="modal fade" id="modal-hapus<?= $x->id_rusak; ?>">
            <div class="modal-dialog">

              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Hapus Data</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->


                <?php echo form_open('Barang_rusak/hapus_barang') ?>

                <input type="hidden" readonly value="<?= $x->id_rusak; ?>" name="id" class="form-control">
                <div class="modal-body">
                  <p>Apakah Anda Yakin Menghapus Data "<b><?php echo $x->barang_nama; ?></b>" ?</strong>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                  <input type="submit" name="submit" id="submit" class="btn btn-danger" value="Hapus" />
                </div>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
        <script>
          $(document).ready(function() {
            $('select').select2({
              width: '100%',
            })

          });
        </script>
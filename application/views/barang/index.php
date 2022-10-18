        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Data Barang</h1>


          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- FLASH DATA -->
              <?php
              $dat = $this->session->flashdata('msg');
              if ($dat != "") { ?>
                <div id="notifikasi" class="alert alert-success"><strong>Sukses! </strong> <?= $dat; ?></div>
              <?php } ?>

              <?php
              $dat = $this->session->flashdata('msg2');
              if ($dat != "") { ?>
                <div id="notifikasi" class="alert alert-danger"><strong> </strong> <?= $dat; ?></div>
              <?php } ?>
              <!-- Button to Open the Modal -->
              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_barang">
                (+) TAMBAH
              </button>
              <a href="<?php echo base_url("barang/export"); ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Export to Excel</a><br><br>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                    <tr>
                      <th>No</th>
                      <th>KD Barang</th>
                      <th>Nama Barang</th>
                      <th>Satuan</th>
                      <th>Harga Pokok</th>
                      <th>Harga Jual</th>

                      <th>Stok</th>
                      <th>Min Stok</th>
                      <th>Kategori</th>
                      <th>SN</th>
                      <th>Photo</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>KD Barang</th>
                      <th>Nama Barang</th>
                      <th>Satuan</th>
                      <th>Harga Pokok</th>
                      <th>Harga Jual</th>

                      <th>Stok</th>
                      <th>Min Stok</th>
                      <th>Kategori</th>
                      <th>SN</th>
                      <th>Photo</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    $no = 0;
                    foreach ($data->result() as $a) :
                      $no++;
                      $idku = $a->id;
                      $id = $a->barang_id;
                      $nm = $a->barang_nama;
                      $satuan = $a->barang_satuan;
                      $harpok = $a->barang_harpok;
                      $harjul = $a->barang_harjul;

                      $stok = $a->barang_stok;
                      $min_stok = $a->barang_min_stok;
                      $kat_id = $a->barang_kategori_id;
                      $kat_nama = $a->kategori_nama;
                      $serial = $a->serial_number;
                    ?>
                      <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $id; ?></td>
                        <td><?php echo $nm; ?></td>
                        <td><?php echo $satuan; ?></td>
                        <td><?php echo 'Rp ' . number_format($harpok); ?></td>
                        <td><?php echo 'Rp ' . number_format($harjul); ?></td>
                        <td><?php echo $stok; ?></td>
                        <td><?php echo $min_stok; ?></td>
                        <td><?php echo $kat_nama; ?></td>
                        <td><?php echo $serial; ?></td>
                        <td><img class="card-img" alt="..." src="<?= base_url('assets/upload/') . $a->image; ?>" width="80" height="90"></td>
                        <td>
                          <?php if ($this->session->userdata('level') == 'admin') { ?>
                            <a class="badge badge-success" href="#modal-edit<?php echo $idku ?>" data-toggle="modal" title="Edit"><span class="fas fa-fw fa-edit"></span> Edit</a>
                            <a class="badge badge-danger" href="#modal-hapus<?php echo $id ?>" data-toggle="modal" title="Hapus"><span class="fas fa-fw fa-trash"></span> Hapus</a>
                          <?php } ?>
                        </td>
                      </tr>
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
                <h4 class="modal-title">Tambah Barang</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <?php echo form_open_multipart('Barang/tambah_barang') ?>
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

                <div class="form-group">
                  <label for="minimalstok">Gambar : </label>
                  <input type="file" id="image" name="image" class="form-control">
                  <small>Image file size must not exceed 700 kb. Allowed types: png jpg jpeg.</small>
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


        <!---------------------------------------------EDIT Data---------------------------------------------->
        <?php $no = 0;
        foreach ($data->result() as $x) : $no++; ?>

          <div class="modal fade" id="modal-edit<?= $x->id; ?>">
            <div class="modal-dialog">

              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Edit Barang</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->


                <?php echo form_open_multipart('Barang/edit_barang1') ?>
                <div class="modal-body">
                  <input type="hidden" readonly value="<?= $x->id; ?>" name="id" class="form-control">
                  <input type="text" readonly value="<?= $x->barang_id; ?>" name="barang_id" class="form-control">

                  <div class="form-group">
                    <label for="nama">Nama Barang : </label>
                    <input type="text" id="nabar" name="nabar" value="<?php echo $x->barang_nama; ?>" class="form-control" placeholder="Nama Barang" required>
                  </div>

                  <div class="form-group">
                    <label for="satuan">Satuan : </label>
                    <select required name="satuan" id="satuan" class="form-control">
                      <option value="buah">Buah</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="hargapokok">Harga Pokok : </label>
                    <input type="text" id="harpok" name="harpok" value="<?php echo $x->barang_harpok; ?>" class="form-control" placeholder="Harga Pokok" required>
                  </div>
                  <div class="form-group">
                    <label for="hargajual">Harga Jual : </label>
                    <input type="text" id="harjul" name="harjul" value="<?php echo $x->barang_harjul; ?>" class="form-control" placeholder="Harga Jual" required>
                  </div>
                  <div class="form-group">
                    <label for="stok">Stok : </label>
                    <input type="text" id="stok" name="stok" value="<?php echo $x->barang_stok; ?>" class="form-control" placeholder="Stok" required>
                  </div>
                  <div class="form-group">
                    <label for="minimalstok">Minimal Stok : </label>
                    <input type="text" id="min_stok" name="min_stok" value="<?php echo $x->barang_min_stok; ?>" class="form-control" placeholder="Minimal Stok" required>
                  </div>

                  <div class="form-group">
                    <label for="serial">Serial Number : </label>
                    <input type="text" id="sn" name="sn" value="<?php echo $x->serial_number; ?>" class="form-control" placeholder="Serial Number" required>
                  </div>

                  <div class="form-group">
                    <label for="Kategori">Kategori : </label>
                    <select required name="kategori" id="kategori" class="form-control">

                      <?php foreach ($kat->result() as $k2) {
                        $id_kat = $k2->kategori_id;
                        $nm_kat = $k2->kategori_nama;
                        if ($id_kat == $x->kategori_id)
                          echo "<option value='$id_kat' selected>$nm_kat</option>";
                        else
                          echo "<option value='$id_kat'>$nm_kat</option>";
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="minimalstok">Gambar : </label><br>
                    <img src="<?= base_url('assets/upload/') . $x->image; ?>" alt="" width="100" height="100"><br>
                    <input type="file" id="image" name="image" class="form-control">

                    <small>Image file size must not exceed 700 kb and width must not exceed 290, height 385. Allowed types: png jpg jpeg.</small>
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

          <div class="modal fade" id="modal-hapus<?= $x->barang_id; ?>">
            <div class="modal-dialog">

              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Hapus User</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->


                <?php echo form_open('Barang/hapus_barang') ?>

                <input type="hidden" readonly value="<?= $x->barang_id; ?>" name="barang_id" class="form-control">
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
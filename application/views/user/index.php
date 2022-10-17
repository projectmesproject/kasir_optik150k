        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Data User</h1>


          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- FLASH DATA -->
              <?php
              $dat = $this->session->flashdata('msg');
              if ($dat != "") { ?>
                <div id="notifikasi" class="alert alert-success"><strong>Sukses! </strong> <?= $dat; ?></div>
              <?php } ?>
              <!-- Akhir flashdata  -->

              <?php
              $dat = $this->session->flashdata('msg2');
              if ($dat != "") { ?>
                <div id="notifikasi" class="alert alert-danger"><strong> </strong> <?= $dat; ?></div>
              <?php } ?>
              <!-- Button to Open the Modal -->
              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_user">
                (+) TAMBAH
              </button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                    <tr>
                      <th width="50">No</th>
                      <th>Username</th>
                      <th>Level</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Username</th>
                      <th>Level</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    $no = 1;
                    foreach ($data->result_array() as $a) :
                      $id = $a['id'];
                      $us = $a['username'];
                      $lv = $a['level'];

                    ?>
                      <tr>
                        <td><?= $no; ?></td>
                        <td><?php echo $us; ?></td>
                        <td><?php echo $lv; ?></td>
                        <td>
                          <?php if ($a['status'] == 1) {
                            echo 'Active';
                          } else {
                            echo 'Not Active';
                          }

                          ?>
                        </td>
                        <td class="text-center">
                          <a class="badge badge-success" href="#modal-edit<?php echo $id ?>" data-toggle="modal" title="Edit"><span class="fas fa-fw fa-edit"></span> Edit</a>
                          <a class="badge badge-danger" href="#modal-hapus<?php echo $id ?>" data-toggle="modal" title="Hapus"><span class="fas fa-fw fa-trash"></span> Hapus</a>
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
        <div class="modal fade" id="add_user">
          <div class="modal-dialog">

            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Tambah User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <?php echo form_open('User/tambah_user') ?>
              <div class="modal-body">

                <div class="form-group">
                  <label for="username">Username : </label>
                  <input type="text" id="username" name="username" class="form-control" placeholder="Username" value="<?= set_value('username'); ?>" required>
                  <small class="form-text text-danger"><?= form_error('username'); ?></small>
                </div>

                <div class="form-group">
                  <label for="password">Password : </label>
                  <input type="password" id="password" name="password1" class="form-control" placeholder="Password" value="<?= set_value('password1'); ?>" required>
                  <small class="form-text text-danger"><?= form_error('password1'); ?></small>
                </div>

                <div class="form-group">
                  <label for="password">Retype Password : </label>
                  <input type="password" id="password2" name="password2" class="form-control" placeholder="Retype Password" value="<?= set_value('password2'); ?>" required>
                  <small class="form-text text-danger"><?= form_error('password2'); ?></small>
                </div>

                <div class="form-group">
                  <label for="Level">Hak Akses : </label>
                  <select required name="level" id="u_level" class="form-control">
                    <option value="">-- Pilih Hak Akses --</option>
                    <option value="admin">Admin</option>
                    <option value="kasir">Kasir</option>
                    <option value="Pembelian">Pembelian</option>
                    <option value="Penjualan">Penjualan</option>
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


        <!---------------------------------------------EDIT Data---------------------------------------------->
        <?php $no = 0;
        foreach ($data->result() as $x) : $no++; ?>

          <div class="modal fade" id="modal-edit<?= $x->id; ?>">
            <div class="modal-dialog">

              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Edit User</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->


                <?php echo form_open('User/edit_user') ?>

                <input type="hidden" readonly value="<?= $x->id; ?>" name="u_id" class="form-control">
                <div class="modal-body">

                  <div class="form-group">
                    <label for="hakakses">Hak Akses :</label>
                    <select required class="form-control" name="level" id="hakakses">
                      <?php foreach ($hak_akses as $n) { ?>
                        <?php if ($n == $x->level) { ?>
                          <option value="<?= $n; ?>" selected><?= $n; ?></option>
                        <?php } else { ?>
                          <option value="<?= $n; ?>"><?= $n; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="status">Status :</label>
                    <select required class="form-control" name="status" id="status">
                      <?php foreach ($is_active as $m) { ?>
                        <?php if ($m == $x->status) { ?>
                          <option value="<?= $m; ?>" selected>
                            <?php if ($m == 1) {
                              echo 'Active';
                            } else {
                              echo 'Not Active';
                            }
                            ?>

                          </option>
                        <?php } else { ?>
                          <option value="<?= $m; ?>">
                            <?php if ($m == 1) {
                              echo 'Active';
                            } else {
                              echo 'Not Active';
                            }
                            ?>

                          </option>
                        <?php } ?>
                      <?php } ?>
                    </select>
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

          <div class="modal fade" id="modal-hapus<?= $x->id; ?>">
            <div class="modal-dialog">

              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Hapus User</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->


                <?php echo form_open('User/hapus_user') ?>

                <input type="hidden" readonly value="<?= $x->id; ?>" name="u_id" class="form-control">
                <div class="modal-body">
                  <p>Apakah Anda Yakin Menghapus Data "<b><?php echo $x->username; ?></b>" ?</strong>
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
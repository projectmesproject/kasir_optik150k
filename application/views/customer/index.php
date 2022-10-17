        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Data Customer</h1>


          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
                <!-- FLASH DATA -->    
                <?php 
                $dat = $this->session->flashdata('msg');
                    if($dat!=""){ ?>
                          <div id="notifikasi" class="alert alert-success"><strong>Sukses! </strong> <?=$dat;?></div>
                <?php } ?> 
                <!-- Akhir flashdata  -->
      
            <?php 
            $dat = $this->session->flashdata('msg2');
                if($dat!=""){ ?>
                      <div id="notifikasi" class="alert alert-danger"><strong> </strong> <?=$dat;?></div>
            <?php } ?> 
                                    <!-- Button to Open the Modal -->
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_customer">
          (+) TAMBAH
        </button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                    <tr>
                      <th>No</th>
                      <th>Kode Customer</th>
                      <th>Nama</th>
                      <th>No Hp/Telp</th>
                      <th>Alamat</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Kode Customer</th>
                      <th>Nama</th>
                      <th>No Hp/Telp</th>
                      <th>Alamat</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  <?php 
                      $no=1; foreach($customer as $c){
                      ?>
                      <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $c['kd_customer']; ?></td>
                        <td><?= $c['nama']; ?></td>
                        <td><?= $c['no_hp']; ?></td>
                        <td><?= $c['alamat']; ?></td>
                        <td class="text-center">
                          <a class="badge badge-success" href="#modal-edit<?= $c['id']; ?>" data-toggle="modal" title="Edit"><span class="fas fa-fw fa-edit"></span> Edit</a>
                          <a class="badge badge-danger" href="#modal-hapus<?= $c['id']; ?>" data-toggle="modal" title="Hapus"><span class="fas fa-fw fa-trash"></span> Hapus</a>
                      </td>
                      </tr>
                      <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

            <!---------------------------------------------Tambah Data---------------------------------------------->
      <div class="modal fade" id="add_customer">
        <div class="modal-dialog">

          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Tambah User</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <?php echo form_open('Customer/tambah_data') ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="user">Kode Customer : </label>
                    <input type="text" id="kd_customer" name="kd_customer" class="form-control" value="<?= $kd_cus; ?>"  readonly>
                    <small class="form-text text-danger"><?= form_error('kd_customer');?></small>
                </div>

                <div class="form-group">
                    <label for="username">Nama : </label>
                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Customer" value="<?= set_value('nama'); ?>"  required>
                    <small class="form-text text-danger"><?= form_error('nama');?></small>
                </div>

                <div class="form-group">
                    <label for="username">No Hp/Telp : </label>
                    <input type="text" id="no_hp" name="no_hp" class="form-control" placeholder="No Hp/Telp" value="<?= set_value('no_hp'); ?>"  required>
                    <small class="form-text text-danger"><?= form_error('no_hp');?></small>
                </div>

                <div class="form-group">
                    <label for="username">Alamat : </label>
                    <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Alamat" value="<?= set_value('alamat'); ?>"  required>
                    <small class="form-text text-danger"><?= form_error('alamat');?></small>
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
       <!---------------------------------------------Akhir Tambah Data---------------------------------------------->

       <!---------------------------------------------EDIT Data---------------------------------------------->
          <?php $no=0; foreach($customer as $x): $no++; ?>
              
              <div class="modal fade" id="modal-edit<?= $x['id']; ?>">
                <div class="modal-dialog">
              
                  <div class="modal-content">
              
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Edit User</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
              
                    <!-- Modal body -->
              
              
                    <?php echo form_open('Customer/edit_customer') ?>
              
                    <input type="hidden" readonly value="<?= $x['id']; ?>" name="id" class="form-control" >
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="user">Kode Customer : </label>
                            <input type="text" id="kd_customer" name="kd_customer" class="form-control" value="<?= $x['kd_customer']; ?>"  readonly>
                            <small class="form-text text-danger"><?= form_error('kd_customer');?></small>
                        </div>

                        <div class="form-group">
                            <label for="username">Nama : </label>
                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Customer" value="<?= $x['nama']; ?>"  required>
                            <small class="form-text text-danger"><?= form_error('nama');?></small>
                        </div>

                        <div class="form-group">
                            <label for="username">No Hp/Telp : </label>
                            <input type="text" id="no_hp" name="no_hp" class="form-control" placeholder="No Hp/Telp" value="<?= $x['no_hp']; ?>"  required>
                            <small class="form-text text-danger"><?= form_error('no_hp');?></small>
                        </div>

                        <div class="form-group">
                            <label for="username">Alamat : </label>
                            <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Alamat" value="<?= $x['alamat']; ?>"  required>
                            <small class="form-text text-danger"><?= form_error('alamat');?></small>
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
              <?php endforeach;?>
        <!---------------------------------------------EDIT Data---------------------------------------------->

        <!---------------------------------------------Hapus  Data---------------------------------------------->
          <?php $no=0; foreach($customer as $x): $no++; ?>  
            
            <div class="modal fade" id="modal-hapus<?= $x['id']; ?>">
              <div class="modal-dialog">
            
                <div class="modal-content">
            
                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Hapus User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
            
                  <!-- Modal body -->
            
            
                  <?php echo form_open('Customer/hapus_customer') ?>
            
                  <input type="hidden" readonly value="<?= $x['id']; ?>" name="id" class="form-control" >
                  <div class="modal-body">
                      <p>Apakah Anda Yakin Menghapus Data "<b><?= $x['nama']; ?></b>" ?</strong>
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
            <?php endforeach;?>
      <!---------------------------------------------Hapus  Data---------------------------------------------->

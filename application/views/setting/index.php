        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Setting</h1>


          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
                              <!-- FLASH DATA -->    
                              <?php 
      $dat = $this->session->flashdata('msg');
          if($dat!=""){ ?>
                <div id="notifikasi" class="alert alert-success"><strong>Sukses! </strong> <?=$dat;?></div>
      <?php } ?>   

      <?php 
      $dat = $this->session->flashdata('msg2');
          if($dat!=""){ ?>
                <div id="notifikasi" class="alert alert-danger"><strong> </strong> <?=$dat;?></div>
      <?php } ?>             
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                    <tr>
                      <th>No</th>
                      <th>Fitur</th>
                      <th>Nama</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                    <th>No</th>
                      <th>Fitur</th>
                      <th>Nama</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  <?php $no=1; foreach($data as $d){?>
                    <tr>
                      <td><?= $no++; ?></td>
                      <td><?= $d['nama']; ?></td>
                      <td width="300">
                      <?php if($d['cek_gambar']==0){ ?>
                        <?= $d['fitur']; ?>
                      <?php }else{ ?>
                        <img class="card-img" alt="..." src="<?= base_url('assets/logo/') . $d['fitur']; ?>" height="90">
                      <?php } ?>
                      </td>
                      <td class="text-center">
                          <a class="badge badge-success" href="#modal-edit<?= $d['id']; ?>" data-toggle="modal" title="Edit"><span class="fas fa-fw fa-edit"></span> Edit</a>
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

  <!---------------------------------------------EDIT Data---------------------------------------------->
  <?php $no=0; foreach($data as $x): $no++; ?>
      <!---------------------------------------------Edit Data---------------------------------------------->
    <div class="modal fade" id="modal-edit<?= $x['id']; ?>">
      <div class="modal-dialog">

        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Setting</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <?php echo form_open_multipart('setting/tambah_data') ?>
          <input type="text" id="id" name="id" value="<?= $x['id']; ?>" hidden>
          <input type="text" id="cek_gambar" name="cek_gambar" value="<?= $x['cek_gambar']; ?>" hidden>
          <div class="modal-body">
              <div class="form-group">
                  <label for="fitur">Fitur : </label>
                  <input type="text" id="fitur" name="fitur" class="form-control" value="<?= $x['nama']; ?>" readonly>
              </div>

              <?php if($x['cek_gambar']==0){ ?>
              <div class="form-group">
                  <label for="nama">Nama : </label>
                  <input type="text" id="nama" name="nama" class="form-control" value="<?= $x['fitur']; ?>"  required>
              </div>
              <?php }else{ ?>

              <div class="form-group">
                <label for="minimalstok">Gambar : </label><br>
                <img src="<?= base_url('assets/logo/') .$x['fitur']; ?>" alt="" width="100" height="100"><br>
                <input type="file" id="image" name="image" class="form-control" required="">
                <small>Allowed types: png jpg jpeg.</small>
              </div>
              <?php } ?>
      

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
    <?php endforeach;?>

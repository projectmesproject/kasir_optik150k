        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Data Suplier</h1>


          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
                              <!-- FLASH DATA -->    
                              <?php 
      $dat = $this->session->flashdata('msg');
          if($dat!=""){ ?>
                <div id="notifikasi" class="alert alert-success"><strong>Sukses! </strong> <?=$dat;?></div>
      <?php } ?>               
                              <!-- Button to Open the Modal -->
  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_suplier">
    (+) TAMBAH
  </button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                    <tr>
                      <th>No</th>
                      <th>Suplier</th>
                      <th>Alamat</th>
                      <th>No tlp</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                    <th>No</th>
                      <th>Suplier</th>
                      <th>Alamat</th>
                      <th>No tlp</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  <?php 
                    $no=0;
                    foreach ($data->result_array() as $a):
                        $no++;
                        $id=$a['suplier_id'];
                        $nm=$a['suplier_nama'];
                        $al=$a['suplier_alamat'];
                        $tlp=$a['suplier_notelp'];

                ?>
                    <tr>
                        <td ><?php echo $no;?></td>
                        
                        <td><?php echo $nm;?></td>
                        <td><?php echo $al;?></td>
                        <td><?php echo $tlp;?></td>
                        <td>
                            <a class="badge badge-success" href="#modal-edit<?php echo $id?>" data-toggle="modal" title="Edit"><span class="fas fa-fw fa-edit"></span> Edit</a>
                            <a class="badge badge-danger" href="#modal-hapus<?php echo $id?>" data-toggle="modal" title="Hapus"><span class="fas fa-fw fa-trash"></span> Hapus</a>
                        </td>
                    </tr>
                    <?php $no++; ?>
                <?php endforeach;?>
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
<div class="modal fade" id="add_suplier">
  <div class="modal-dialog">

    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Suplier</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <?php echo form_open('Suplier/tambah_suplier') ?>
      <div class="modal-body">
          <div class="form-group">
              <label for="nama">Nama Suplier : </label>
              <input type="text" id="sup_nama" name="sup_nama" class="form-control" placeholder="Suplier"  required>
          </div>

          <div class="form-group">
              <label for="alamat">Alamat : </label>
              <input type="text" id="sup_alamat" name="sup_alamat" class="form-control" placeholder="Alamat"  required>
          </div>

          <div class="form-group">
              <label for="nohp">NO HP : </label>
              <input type="text" id="sup_tlp" name="sup_tlp" class="form-control" placeholder="No HP"  required>
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
<?php $no=0; foreach($data->result() as $x): $no++; ?>
    
<div class="modal fade" id="modal-edit<?= $x->suplier_id; ?>">
  <div class="modal-dialog">

    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Suplier</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->


      <?php echo form_open('Suplier/edit_suplier') ?>

      <input type="hidden" readonly value="<?=$x->suplier_id;?>" name="sup_id" class="form-control" >
      <div class="modal-body">
          <div class="form-group">
              <label for="Suplier">Suplier : </label>
              <input type="text" id="sup_nama" name="sup_nama" value="<?php echo $x->suplier_nama ;?>" class="form-control" placeholder="Suplier"  required>
          </div>

          <div class="form-group">
                <label for="alamat">Alamat :</label>
                <input type="text" id="sup_alamat" name="sup_alamat" value="<?php echo $x->suplier_alamat;?>" class="form-control" placeholder="Alamat" required>
          </div>

          <div class="form-group">
                <label for="nohp">NO HP :</label>
                <input type="text" id="sup_tlp" name="sup_tlp" value="<?php echo $x->suplier_notelp;?>" class="form-control" placeholder="NO HP" required>
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


  <!---------------------------------------------Hapus  Data---------------------------------------------->
  <?php $no=0; foreach($data->result() as $x): $no++; ?>
    
    <div class="modal fade" id="modal-hapus<?= $x->suplier_id; ?>">
      <div class="modal-dialog">
    
        <div class="modal-content">
    
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Hapus Suplier</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
    
          <!-- Modal body -->
    
    
          <?php echo form_open('Suplier/hapus_suplier') ?>
    
          <input type="hidden" readonly value="<?=$x->suplier_id;?>" name="sup_id" class="form-control" >
          <div class="modal-body">
              <p>Apakah Anda Yakin Menghapus Data "<b><?php echo $x->suplier_nama;?></b>" ?</strong>
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
      
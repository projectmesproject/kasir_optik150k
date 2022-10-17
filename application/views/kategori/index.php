        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Data Kategori</h1>


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
  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_kategori">
    (+) TAMBAH
  </button>

  
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                    <tr>
                      <th>No</th>
                      <th>Kategori</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                    <th>No</th>
                      <th>Kategori</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  <?php 
                    $no=0;
                    foreach ($data->result() as $a):
                        $no++;
                        $id=$a->kategori_id;
                        $nm=$a->kategori_nama;

                ?>
                    <tr>
                        <td ><?php echo $no;?></td>
                        
                        <td><?php echo $nm;?></td>
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
<div class="modal fade" id="add_kategori">
  <div class="modal-dialog">

    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Kategori</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <?php echo form_open('Kategori/tambah_kategori') ?>
      <div class="modal-body">
          <div class="form-group">
              <label for="kategori">Kategori : </label>
              <input type="text" id="kategori" name="kategori" class="form-control" placeholder="Kategori"  required>
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
    
<div class="modal fade" id="modal-edit<?= $x->kategori_id; ?>">
  <div class="modal-dialog">

    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Kategori</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->


      <?php echo form_open('Kategori/edit_kategori') ?>

      <input type="hidden" readonly value="<?=$x->kategori_id;?>" name="kategori_id" class="form-control" >
      <div class="modal-body">
          <div class="form-group">
              <label for="kategori">Kategori : </label>
              <input type="text" id="kategori" name="kategori" value="<?php echo $x->kategori_nama ;?>" class="form-control" placeholder="Kategori"  required>
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
    
    <div class="modal fade" id="modal-hapus<?= $x->kategori_id; ?>">
      <div class="modal-dialog">
    
        <div class="modal-content">
    
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Hapus Kategori</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
    
          <!-- Modal body -->
    
    
          <?php echo form_open('Kategori/hapus_kategori') ?>
    
          <input type="hidden" readonly value="<?=$x->kategori_id;?>" name="kategori_id" class="form-control" >
          <div class="modal-body">
              <p>Apakah Anda Yakin Menghapus Data "<b><?php echo $x->kategori_nama;?></b>" ?</strong>
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
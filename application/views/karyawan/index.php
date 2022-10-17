<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Karyawan</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
  
  <?php 
      $dat = $this->session->flashdata('msg');
          if($dat!=""){ ?>
                <div id="notifikasi" class="alert alert-success"><strong>Sukses! </strong> <?=$dat;?></div>
      <?php } ?>  

  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_karyawan">
        (+) TAMBAH
      </button>
  </div>
  <br>
  <div class="card-body">

    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="thead-light">
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Alamat</th>
            <th>Tanggal Masuk</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Alamat</th>
            <th>Tanggal Masuk</th>
            <th>Aksi</th>
          </tr>
        </tfoot>
        <tbody>
        <?php 
                    $no=0;
                    foreach ($data->result() as $a):
                        $no++;
                        $id=$a->id;
                        $nm=$a->nama;
                        $tpt=$a->tempat_lahir;
                        $tgl=$a->tanggal_lahir;
                        $almt=$a->alamat;
                        $tgl_masuk=$a->tanggal_masuk;


                ?>
                    <tr>
                        <td ><?php echo $no;?></td>
                        
                        <td><?php echo $nm;?></td>
                        <td><?php echo $tpt;?></td>
                        <td><?php echo $tgl;?></td>
                        <td><?php echo $almt;?></td>
                        <td><?php echo $tgl_masuk;?></td>
                        
                        <td>
                            <a class="badge badge-success" href="#modal-edit<?php echo $id ;?>" data-toggle="modal" title="Edit"><span class="fas fa-fw fa-edit"></span> Edit</a>
                            <a class="badge badge-danger" href="#modal-hapus<?php echo $id ;?>" data-toggle="modal" title="Hapus"><span class="fas fa-fw fa-trash"></span> Hapus</a>
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
<div class="modal fade" id="add_karyawan">
  <div class="modal-dialog">

    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Karayawan</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <?php echo form_open('Karyawan/tambah_karyawan') ?>
      
      <div class="modal-body">
          <div class="form-group">
              <label for="nama">Nama : </label>
              <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama"  required>
          </div>

          <div class="form-group">
              <label for="tempat lahir">Tempat Lahir : </label>
              <input type="text" id="tempat" name="tempat" class="form-control" placeholder="Tempat Lahir"  required>
          </div>
      
          <div class="form-group">
              <label for="tanggal lahir">Tanggal Lahir : </label>
              <input type="date" id="tgl" name="tgl" class="form-control" placeholder="Tanggal Lahir"  required>
          </div>
      
          <div class="form-group">
              <label for="alamat">Alamat : </label>
              <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="4" placeholder="Alamat" required></textarea>
          </div>


          <div class="form-group">
              <label for="tanggal masuk">Tanggal Masuk : </label>
              <input type="date" id="tgl_masuk" name="tgl_masuk" class="form-control" placeholder="Tanggal Masuk"  required>
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
    
<div class="modal fade" id="modal-edit<?= $x->id; ?>">
  <div class="modal-dialog">

    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Karyawan</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->


      <?php echo form_open('Karyawan/edit_karyawan') ?>

      <input type="hidden" readonly value="<?=$x->id;?>" name="id" class="form-control" >

      <div class="modal-body">
          
         <div class="form-group">
              <label for="nama">Nama : </label>
              <input type="text" id="nama" name="nama" value="<?= $x->nama ;?>" class="form-control" placeholder="Nama"  required>
          </div>

          <div class="form-group">
              <label for="tempat lahir">Tempat Lahir : </label>
              <input type="text" id="tempat" name="tempat" value="<?= $x->tempat_lahir ;?>" class="form-control" placeholder="Tempat Lahir"  required>
          </div>
      
          <div class="form-group">
              <label for="tanggal lahir">Tanggal Lahir : </label>
              <input type="date" id="tgl" name="tgl" class="form-control" value="<?= $x->tanggal_lahir ;?>" placeholder="Tanggal Lahir"  required>
          </div>
      
          <div class="form-group">
              <label for="alamat">Alamat : </label>
              <textarea name="alamat" id="alamat" class="form-control"  cols="30" rows="4" placeholder="Alamat" required><?= $x->alamat ;?></textarea>
          </div>


          <div class="form-group">
              <label for="tanggal masuk">Tanggal Masuk : </label>
              <input type="date" id="tgl_masuk" name="tgl_masuk" class="form-control" value="<?= $x->tanggal_masuk ;?>" placeholder="Tanggal Masuk"  required>
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
    
    <div class="modal fade" id="modal-hapus<?= $x->id; ?>">
      <div class="modal-dialog">
    
        <div class="modal-content">
    
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Hapus Karyawan</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
    
          <!-- Modal body -->
    
    
          <?php echo form_open('Karyawan/hapus_karyawan') ?>
    
          <input type="hidden" readonly value="<?=$x->id;?>" name="id" class="form-control" >
          <div class="modal-body">
              <p>Apakah Anda Yakin Menghapus Data "<b><?php echo $x->nama;?></b>" ?</strong>
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
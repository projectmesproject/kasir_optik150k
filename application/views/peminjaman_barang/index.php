 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Peminjaman Barang</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
       <!-- FLASH DATA -->    
       <?php 
      $dat = $this->session->flashdata('msg');
          if($dat!=""){ ?>
                <div id="notifikasi" class="alert alert-success"><strong>Sukses! </strong> <?=$dat;?></div>
      <?php } ?>   
    <h6 class="m-0 font-weight-bold text-primary">Daftar Peminjaman Barang</h6>
  </div>
  <br>
  <div class="card-body">
    <center>
      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_pinjaman">
        (+) TAMBAH
      </button>
    </center><br>
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>No</th>
            <th>Barang</th>
            <th>Karyawan</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>No</th>
            <th>Barang</th>
            <th>Karyawan</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Aksi</th>
          </tr>
        </tfoot>
        <tbody>
            <?php $no=1; foreach($data as $a){ ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= $a['barang_nama']; ?></td>
            <td><?= $a['nama']; ?></td>
            <td><?= $a['jumlah']; ?></td>
            <td><?= $a['tanggal']; ?></td>
            <td><?= $a['keterangan']; ?></td>
            <td class="text-center">
              <a class="badge badge-success" href="#modal-edit<?= $a['id']; ?>" data-toggle="modal" title="Edit"><span class="fas fa-fw fa-edit"></span> Edit</a>
              <a class="badge badge-danger" href="#modal-hapus<?= $a['id']; ?>" data-toggle="modal" title="Hapus"><span class="fas fa-fw fa-trash"></span> Hapus</a>
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
<div class="modal fade" id="add_pinjaman">
    <div class="modal-dialog">

      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Peminjaman Barang</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <?php echo form_open('peminjaman_barang/tambah_data') ?>
        <div class="modal-body">
          <div class="form-group">
            <label for="Kategori">Karyawan : </label>
                <select required name="karyawan" id="karyawan" class="form-control">
                    <?php foreach($karyawan->result_array() as $d){ ?>
                      <option value="<?= $d['id']; ?>"><?= $d['nama']; ?></option>
                    <?php } ?>
                </select>
           </div> 

           <div class="form-group">
            <label for="barang">Barang : </label>
                <select required name="barang" id="barang" class="form-control">
                <?php foreach($barang->result_array() as $d){ ?>
                      <option value="<?= $d['barang_id']; ?>"><?= $d['barang_nama']; ?></option>
                    <?php } ?>
                </select>
           </div>

            <div class="form-group">
                <label for="nohp">Tanggal : </label>
                <input type="date" id="tanggal" name="tanggal" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="alamat">Jumlah : </label>
              <input type="number" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah"  required>
            </div>

            <div class="form-group">
              <label for="nohp">Keterangan : </label>
              <input type="text" id="keterangan" name="keterangan" class="form-control" required>
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
  <!---------------------------------------------Akhr Tambah Data---------------------------------------------->

  <!---------------------------------------------Edit Data---------------------------------------------->
  <?php $no=0; foreach($data as $x): $no++; ?>
<div class="modal fade" id="modal-edit<?=$x['id']; ?>">
    <div class="modal-dialog">

      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Peminjaman Barang</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <?php echo form_open('peminjaman_barang/editData') ?>
        <input type="hidden" readonly value="<?= $x['id']; ?>" name="id" class="form-control" >
        <div class="modal-body">
          <div class="form-group">
            <label for="Kategori">Karyawan : </label>
                <select required name="karyawan" id="karyawan" class="form-control" required="">
                    <?php foreach($karyawan->result_array() as $d){ ?>
                        <?php if($d['id']==$x['id_karyawan']){ ?>
                            <option value="<?= $d['id']; ?>" selected><?= $d['nama']; ?></option>
                        <?php }else{ ?>
                            <option value="<?= $d['id']; ?>"><?= $d['nama']; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
           </div> 

           <div class="form-group">
            <label for="barang">Barang : </label>
                <select required name="barang" id="barang" class="form-control" required="">
                    <?php foreach($barang->result_array() as $d){ ?>
                        <?php if($d['barang_id']==$x['id_barang']){ ?>
                         <option value="<?= $d['barang_id']; ?>" selected><?= $d['barang_nama']; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
           </div>

            <div class="form-group">
                <label for="nohp">Tanggal : </label>
                <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?= $x['tanggal']; ?>" required="">
            </div>

            <div class="form-group">
              <label for="alamat">Jumlah : </label>
              <input type="number" id="jumlah" name="jumlah" class="form-control" value="<?= $x['jumlah']; ?>" placeholder="Jumlah"  required="">
            </div>

            <div class="form-group">
              <label for="nohp">Keterangan : </label>
              <input type="text" id="keterangan" name="keterangan" class="form-control" value="<?= $x['keterangan']; ?>" required="">
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
  <?php endforeach;?>
  <!---------------------------------------------Akhr Edit Data---------------------------------------------->

   <!---------------------------------------------Hapus  Data---------------------------------------------->
   <?php $no=0; foreach($data as $x): $no++; ?>  
            
            <div class="modal fade" id="modal-hapus<?= $x['id']; ?>">
              <div class="modal-dialog">
            
                <div class="modal-content">
            
                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Hapus Peminjaman Barang</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
            
                  <!-- Modal body -->
            
            
                  <?php echo form_open('peminjaman_barang/hapus_data') ?>
            
                  <input type="hidden" readonly value="<?= $x['id']; ?>" name="id" class="form-control" >
                  <div class="modal-body">
                      <p>Apakah anda yakin menghapus data ?</strong>
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
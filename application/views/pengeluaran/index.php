<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Pengeluaran</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
      <!-- FLASH DATA -->    
     <?php 
      $dat = $this->session->flashdata('msg');
          if($dat!=""){ ?>
                <div id="notifikasi" class="alert alert-success"><strong>Sukses! </strong> <?=$dat;?></div>
      <?php } ?>    
    <h6 class="m-0 font-weight-bold text-primary">Daftar Pengeluaran</h6>
  </div>
  <br>
  <div class="card-body">
    <center>
      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_pengeluaran">
        (+) TAMBAH
      </button>
    </center><br>
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>No</th>
            <th>Jenis Pengeluaran</th>
            <th>Nominal</th>
            <th>Penerima</th>
            <th>Keterangan</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>No</th>
            <th>Jenis Pengeluaran</th>
            <th>Nominal</th>
            <th>Penerima</th>
            <th>Keterangan</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </tfoot>
        <tbody>
        <?php $no=1; foreach($data as $p){ ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= $p['jenis_pengeluaran']; ?></td>
            <td>Rp. <?= number_format($p['nominal']); ?></td>
            <td><?= $p['nama_karyawan']; ?></td>
            <td><?= $p['keterangan']; ?></td>
            <td><?= $p['tanggal']; ?></td>
            <td class="text-center">
              <a class="badge badge-success" href="#modal-edit<?= $p['id']; ?>" data-toggle="modal" title="Edit"><span class="fas fa-fw fa-edit"></span> Edit</a>
              <a class="badge badge-danger" href="#modal-hapus<?= $p['id']; ?>" data-toggle="modal" title="Hapus"><span class="fas fa-fw fa-trash"></span> Hapus</a>
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
<div class="modal fade" id="add_pengeluaran">
    <div class="modal-dialog">

      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Pengeluaran</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <?php echo form_open('pengeluaran/tambah_data') ?>
        <div class="modal-body">
          <div class="form-group">
            <label for="Kategori">Jenis Pengeluaran : </label>
                <select name="jns_pengeluaran" id="jns_pengeluaran" class="form-control" required="">
                  <option value="">---------- Pilih  ----------</option>
                      <option value="Listrik">Listrik</option>
                      <option value="Uang Makan">Uang Makan</option>
                      <option value="Gaji Karyawan">Gaji Karyawan</option>
                      <option value="Lain-Lain">Lain-Lain</option>
                </select>
           </div> 

            <div class="form-group">
                <label for="nohp">Nominal : </label>
                <input type="number" id="nominal" name="nominal" class="form-control" placeholder="Nominal" required="">
            </div>

            <div class="form-group">
            <label for="Kategori">Penerima : </label>
                <select required="" name="penerima" id="penerima" class="form-control">
                  <option value="">---------- Pilih  ----------</option>
                  <?php foreach($karyawan->result_array() as $k){ ?>
                      <option value="<?= $k['id']; ?>"><?= $k['nama']; ?></option>
                  <?php } ?>
                </select>
           </div> 

            <div class="form-group">
              <label for="nohp">Keterangan : </label>
              <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" required="">
            </div>

            <div class="form-group">
              <label for="nohp">Tanggal : </label>
              <input type="date" id="tanggal" name="tanggal" class="form-control" required="">
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
<div class="modal fade" id="modal-edit<?= $x['id']; ?>">
    <div class="modal-dialog">

      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Pengeluaran</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <?php echo form_open('pengeluaran/edit_data') ?>
        <input type="hidden" readonly value="<?= $x['id']; ?>" name="id" class="form-control" >
        <div class="modal-body">
          <div class="form-group">
            <label for="Kategori">Jenis Pengeluaran : </label>
                <select name="jns_pengeluaran" id="jns_pengeluaran" class="form-control" required="">
                  <?php foreach($jenis_pengeluaran as $p){ ?>
                      <?php if($p == $x['jenis_pengeluaran']){ ?>
                        <option value="<?= $p; ?>" selected><?= $p; ?></option>
                      <?php }else{ ?>
                        <option value="<?= $p; ?>"><?= $p; ?></option>
                      <?php } ?>
                  <?php } ?>
                </select>
           </div> 

            <div class="form-group">
                <label for="nohp">Nominal : </label>
                <input type="number" id="nominal" name="nominal" class="form-control" placeholder="Nominal" required="" value="<?= $x['nominal']; ?>">
            </div>

            <div class="form-group">
            <label for="Kategori">Penerima : </label>
                <select required="" name="penerima" id="penerima" class="form-control">
                  <?php foreach($karyawan->result_array() as $k){ ?>
                      <?php if($k['id'] == $x['penerima']){  ?>
                        <option value="<?= $k['id']; ?>" selected><?= $k['nama']; ?></option>
                      <?php }else{ ?>
                        <option value="<?= $k['id']; ?>"><?= $k['nama']; ?></option>
                      <?php } ?>
                  <?php } ?>
                </select>
           </div> 

            <div class="form-group">
              <label for="nohp">Keterangan : </label>
              <input type="text" value="<?= $x['keterangan']; ?>" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" required="">
            </div>

            <div class="form-group">
              <label for="nohp">Tanggal : </label>
              <input type="date" id="tanggal" name="tanggal" class="form-control" required="" value="<?= $x['tanggal']; ?>">
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
  <!---------------------------------------------Akhr Tambah Data---------------------------------------------->

   <!---------------------------------------------Hapus  Data---------------------------------------------->
   <?php $no=0; foreach($data as $x): $no++; ?>  
            
            <div class="modal fade" id="modal-hapus<?= $x['id']; ?>">
              <div class="modal-dialog">
            
                <div class="modal-content">
            
                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Hapus Pengeluaran</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
            
                  <!-- Modal body -->
            
            
                  <?php echo form_open('pengeluaran/hapus_data') ?>
            
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
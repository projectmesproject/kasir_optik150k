        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Data Barang</h1>


          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- import excel -->
              <?php if (!empty($this->session->flashdata('status'))) { ?>
                <div class="alert alert-info" role="alert"><?= $this->session->flashdata('status'); ?></div>
              <?php } ?>
              <form action="<?= base_url('Barang/import'); ?>" method="post" enctype="multipart/form-data">
                <div class="row mb-4">
                  <label class="col-2">Pilih File Excel</label>
                  <div class="col-3 col-md-7">
                    <input type="file" name="fileExcel" class="form-control" required accept=".xls, .xlsx">
                  </div>
                  <button class='btn btn-success' type="submit">
                    Import
                    <i class="fas fas fa-upload"></i>
                  </button>
                </div>

              </form>
              <!-- end import excel -->
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
              <a href="<?php echo base_url("barang/export"); ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Export to Excel</a>
              <a href="<?php echo base_url("barang/deleteAll"); ?>" class="btn btn-danger btn-sm"><i class="fas fa-recycle"></i> Delete All</a>

            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="table" width="100%" cellspacing="0">
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
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
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

        <div class="modal fade" id="modal-edit">
          <div class="modal-dialog">

            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Edit Barang</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->


              <form id="update">
                <div class="modal-body">
                  <label for="nama">Kode Barang : </label>
                  <input type="hidden" readonly value="" name="id" class="form-control">
                  <input type="text" readonly name="barang_id" class="form-control">

                  <div class="form-group">
                    <label for="nama">Nama Barang : </label>
                    <input type="text" id="nabar" name="barang_nama" value="" class="form-control" placeholder="Nama Barang" required>
                  </div>

                  <div class="form-group">
                    <label for="satuan">Satuan : </label>
                    <select required name="barang_satuan" id="satuan" class="form-control">
                      <option value="buah">Buah</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="hargapokok">Harga Pokok : </label>
                    <input type="text" id="harpok" name="barang_harpok" value="" class="form-control" placeholder="Harga Pokok" required>
                  </div>
                  <div class="form-group">
                    <label for="hargajual">Harga Jual : </label>
                    <input type="text" id="harjul" name="barang_harjul" value="" class="form-control" placeholder="Harga Jual" required>
                  </div>
                  <div class="form-group">
                    <label for="hargajual">Harga Cabang : </label>
                    <input type="text" name="barang_harga_cabang" value="" class="form-control" placeholder="Harga Jual" required>
                  </div>
                  <div class="form-group">
                    <label for="stok">Stok : </label>
                    <input type="text" id="stok" name="barang_stok" value="" class="form-control" placeholder="Stok" required>
                  </div>
                  <div class="form-group">
                    <label for="minimalstok">Minimal Stok : </label>
                    <input type="text" id="min_stok" name="barang_min_stok" value="" class="form-control" placeholder="Minimal Stok" required>
                  </div>

                  <div class="form-group">
                    <label for="serial">Serial Number : </label>
                    <input type="text" id="sn" name="serial_number" value="" class="form-control" placeholder="Serial Number" required>
                  </div>

                  <div class="form-group">
                    <label for="Kategori">Kategori : </label>
                    <select required name="barang_kategori_id" id="kategori" class="form-control">
                      <?php foreach ($kat->result() as $value) { ?>
                        <option value="<?= $value->kategori_id ?>"><?= $value->kategori_nama ?></option>
                      <?php } ?>

                    </select>
                  </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-success" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
          </div>
        </div>


        <script>
          $(document).ready(function() {
            tableBarang = $('#table').DataTable({
              "processing": true,
              "serverSide": true,
              "retrieve": true,
              "ajax": {
                "url": "<?= base_url('Barang/list_ajax') ?>",
                "type": "POST",
              },
              "columnDefs": [{}, ],
            });
          });

          $('#update').submit(function(e) {
            e.preventDefault();
            let data = new FormData(this);
            console.log(data)
            $.ajax({
              url: '<?= base_url('barang/update') ?>',
              type: "post",
              data: data,
              dataType: 'json',
              processData: false,
              contentType: false,
              cache: false,
              async: false,
              success: function(data) {
                if (data) {
                  Swal.fire(
                    'Success!',
                    'Data has been created!',
                    'success'
                  )
                  $('#modal-edit').modal('hide');
                  tableBarang.ajax.reload();
                } else {
                  alert('gagal update')
                }

              },
              error: function(e) {
                console.log(e);
              }
            });
          });

          function remove(id) {
            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to remove this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                  url: "<?= base_url('Barang/remove') ?>",
                  method: 'post',
                  dataType: 'json',
                  data: {
                    id: id
                  },
                  success: function(data) {
                    if (data) {
                      Swal.fire(
                        'Deleted!',
                        'Section has been deleted.',
                        'success'
                      )
                      tableBarang.ajax.reload();
                    }
                  }
                })

              }
            })
          }

          function get(id) {
            $.ajax({
              url: "<?= base_url('barang/get') ?>",
              method: "post",
              dataType: "json",
              data: {
                id: id,
              },
              success: function(data) {
                $("input[name=id]").val(data.id);
                $("input[name=barang_id]").val(data.barang_id);
                $("input[name=barang_nama]").val(data.barang_nama);
                $("input[name=barang_satuan]").val(data.barang_satuan);
                $("input[name=barang_harpok]").val(data.barang_harpok);
                $("input[name=barang_harjul]").val(data.barang_harjul);
                $("input[name=barang_harga_cabang]").val(data.barang_harga_cabang);
                $("input[name=barang_stok]").val(data.barang_stok);
                $("input[name=barang_min_stok]").val(data.barang_min_stok);
                $("input[name=serial_number]").val(data.serial_number);
                $("input[name=barang_kategori_id]").val(data.barang_kategori_id);

              }
            })
          }
        </script>
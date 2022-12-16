        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Cabang</h1>


            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <?php
                    $dat = $this->session->flashdata('msg_cbg');
                    if ($dat != "") { ?>
                        <div class="alert alert-success"><strong>Sukses! </strong> <?= $dat; ?>
                        </div>
                    <?php } ?>
                    <!-- import excel -->

                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_cabang">
                        (+) TAMBAH
                    </button>

                    <!-- Button trigger modal -->

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="table" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Cabang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($data->result() as $a) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $a->nama_cabang; ?></td>

                                        <td>
                                            <?php if ($this->session->userdata('level') == 'penjualan') { ?>
                                                <a class="badge badge-success text-white editCabang" data-data='<?= json_encode($a) ?>'><span class="fas fa-fw fa-edit"></span> Edit</a>
                                                <a class="badge badge-danger text-white" style="cursor:pointer;" onclick="deleteCabang('<?php echo $a->id_cabang ?>')"><span class="fas fa-fw fa-trash"></span> Hapus</a>
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

        <!---------------------------------------------Tambah Data---------------------------------------------->
        <div class="modal fade" id="add_cabang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Cabang</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <?php echo form_open_multipart('cabang/tambah_cabang', array("id" => "form_add_cabang")) ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Cabang : </label>
                            <input type="text" id="cabang" name="cabang" class="form-control" placeholder="Nama Cabang" required>
                        </div>

                        <div class="form-group">
                            <label for="satuan">Alamat : </label>
                            <textarea class="form-control" name="alamat"></textarea>

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

        <!---------------------------------------------Tambah Data---------------------------------------------->
        <div class="modal fade" id="edit_cabang_mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Cabang</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <?php echo form_open_multipart('cabang/edit_cabang', array("id" => "form_edit_cabang")) ?>
                    <input type="hidden" name="id_cabang" id="edit_id_cabang" />
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Cabang : </label>
                            <input type="text" id="edit_cabang" name="cabang" class="form-control" placeholder="Nama Cabang" required>
                        </div>

                        <div class="form-group">
                            <label for="satuan">Alamat : </label>
                            <textarea class="form-control" id="edit_alamat" name="alamat"></textarea>

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
        <script>
            $('.editCabang').click(function() {
                let data = $(this).data('data')
                $('#edit_cabang').val(data.nama_cabang)
                $('#edit_alamat').val(data.alamat)
                $('#edit_id_cabang').val(data.id_cabang)
                $('#edit_cabang_mdl').modal('show')
            })

            function deleteCabang(id) {
                Swal.fire({
                    title: 'Hapus Cabang Ini ?',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus Cabang',
                    cancelButtonText: `Batal`,
                    confirmButtonColor: '#dc3545'
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url() ?>cabang/hapus_cabang/' + id,
                            type: 'GET',
                            cache: false,
                            success: function(res) {
                                try {
                                    let response = JSON.parse(res)
                                    if (response.status == 200) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Hapus Cabang',
                                            text: response.message
                                        }).then((result) => {
                                            location.reload()
                                        })
                                    } else {
                                        Swal.fire('Hapus Cabang', response.message, 'warning')
                                    }

                                } catch (e) {
                                    Swal.fire('Hapus Cabang', 'Kesalahan Server', 'error')
                                }
                            }
                        })
                    }
                })
            }
            $(document).ready(function() {
                $('#table').DataTable({
                    scrollY: "480px",
                    scrollCollapse: true,
                    paging: false,
                    scrollX: true,
                    info: true,
                    dom: 'Bfrtip',
                    select: true,

                    // to limit records
                    pageLength: 5,
                });

            });
        </script>
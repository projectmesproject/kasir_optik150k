        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Data Laporan</h1>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <!-- FLASH DATA -->
                    <?php
                    $dat = $this->session->flashdata('msg');
                    if ($dat != "") { ?>
                        <div id="notifikasi" class="alert alert-success"><strong>Sukses! </strong> <?= $dat; ?></div>
                    <?php } ?>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Laporan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <!-- <tfoot>
                    <tr>
                    <th>No</th>
                      <th>Laporan</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot> -->
                            <tbody>

                                <tr>
                                    <td style="text-align:center;vertical-align:middle">1</td>
                                    <td style="vertical-align:middle;">Stok Barang</td>
                                    <td style="text-align:center;">
                                        <a class="btn btn-sm btn-success" href="#lap_data_barang" data-toggle="modal"><span class="fa fa-eye"></span> View</a>
                                        <!-- <a class="btn btn-sm btn-success" href="<?php echo site_url('laporan/lap_data_barang') ?>"><span class="fa fa-print"></span> View</a> -->
                                        <a class="btn btn-sm btn-success" href="<?php echo site_url('laporan/lap_data_barang_cetak') ?>" target="_blank"><span class="fa fa-print"></span> Print</a>
                                    </td>
                                </tr>

                                <!-- <tr>
                                    <td style="text-align:center;vertical-align:middle">2</td>
                                    <td style="vertical-align:middle;">Laporan Stok Barang</td>
                                    <td style="text-align:center;">
                                        <a class="btn btn-sm btn-success" href="<?php echo site_url('laporan/lap_stok_barang') ?>"><span class="fa fa-print"></span> View</a>
                                        <a class="btn btn-sm btn-success" href="<?php echo site_url('laporan/lap_stok_barang_cetak') ?>" target="_blank"><span class="fa fa-print"></span> Print</a>
                                    </td>
                                </tr> -->

                                <!-- <tr>
                                    <td style="text-align:center;vertical-align:middle">2</td>
                                    <td style="vertical-align:middle;">Laporan Penjualan</td>
                                    <td style="text-align:center;">
                                        <a class="btn btn-sm btn-success" href="<?php echo site_url('laporan/lap_data_penjualan') ?>"><span class="fa fa-print"></span> View</a>
                                        <a class="btn btn-sm btn-success" href="<?php echo site_url('laporan/lap_data_penjualan_cetak') ?>" target="_blank"><span class="fa fa-print"></span> Print</a>
                                    </td>
                                </tr> -->

                                <tr>
                                    <td style="text-align:center;vertical-align:middle">2</td>
                                    <td style="vertical-align:middle;">Laporan Penjualan Per Periode</td>
                                    <td style="text-align:center;">
                                        <!-- <a class="btn btn-sm btn-success" href="#lap_jual_periode" data-toggle="modal"><span class="fa fa-eye"></span> View</a> -->
                                        <a class="btn btn-sm btn-success" href="#lap_jual_periode_cetak" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:center;vertical-align:middle">3</td>
                                    <td style="vertical-align:middle;">Laporan Penjualan Per Barang</td>
                                    <td style="text-align:center;">
                                        <!-- <a class="btn btn-sm btn-success" href="#lap_jual_barang" data-toggle="modal"><span class="fa fa-eye"></span> View</a> -->
                                        <a class="btn btn-sm btn-success" href="#lap_jual_barang_cetak" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:center;vertical-align:middle">4</td>
                                    <td style="vertical-align:middle;">Laporan Penjualan Per Kategori Barang</td>
                                    <td style="text-align:center;">
                                        <!-- <a class="btn btn-sm btn-success" href="#lap_penjualan_kat_barang" data-toggle="modal"><span class="fa fa-eye"></span> View</a> -->
                                        <a class="btn btn-sm btn-success" href="#lap_penjualan_kat_barang_cetak" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                    </td>
                                </tr>

                                <!-- <tr>
                                    <td style="text-align:center;vertical-align:middle">6</td>
                                    <td style="vertical-align:middle;">Laporan Laba/Rugi</td>
                                    <td style="text-align:center;">
                                        <a class="btn btn-sm btn-success" href="#lap_laba_rugi" data-toggle="modal"><span class="fa fa-print"></span> View</a>
                                        <a class="btn btn-sm btn-success" href="#lap_laba_rugi_cetak" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                    </td>
                                </tr> -->

                                <tr>
                                    <td style="text-align:center;vertical-align:middle">5</td>
                                    <td style="vertical-align:middle;">Laporan Pengeluaran Toko</td>
                                    <td style="text-align:center;">
                                        <!-- <a class="btn btn-sm btn-success" href="#lap_pengeluaran_toko" data-toggle="modal"><span class="fa fa-eye"></span> View</a> -->
                                        <a class="btn btn-sm btn-success" href="#lap_pengeluaran_toko_cetak" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:center;vertical-align:middle">6</td>
                                    <td style="vertical-align:middle;">Resume Laporan Keuangan</td>
                                    <td style="text-align:center;">
                                        <!-- <a class="btn btn-sm btn-success" href="#lap_resume" data-toggle="modal"><span class="fa fa-eye"></span> View</a> -->
                                        <a class="btn btn-sm btn-success" href="#lap_resume_cetak" data-toggle="modal"><span class="fa fa-print"></span> Print</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

        </div>

        <!-- End of Main Content -->


        <!---------------------------------------------Laporan Data Barang--------------------------------------------->

        <div class="modal fade" id="lap_data_barang">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Pilih Kategori</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <?php echo form_open('Laporan/filter_barang_by_kategori') ?>
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="control-label col-xs-3">Kategori Barang</label>
                            <div class="col-xs-9">
                                <select class="form-control" name="kategori_nama">
                                    <option value="-" selected>- Pilih Kategori Barang -</option>
                                    <?php foreach ($listBarang as $value) { ?>
                                        <option value="<?= $value->kategori_id ?>"><?= $value->kategori_nama ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button class="btn btn-success"><span class="fa fa-print"></span> Print</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!---------------------------------------------Laporan Penjualan Periode--------------------------------------------->

        <div class="modal fade" id="lap_jual_periode">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Pilih Periode</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <?php echo form_open('Laporan/lap_penjualan_periode') ?>
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="control-label col-xs-3">Tanggal Awal</label>
                            <div class="col-xs-9">
                                <input type="date" class="form-control" name="tgl1" value="" placeholder="Tanggal" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-3">Tanggal Akhir</label>
                            <div class="col-xs-9">
                                <input type="date" class="form-control" name="tgl2" value="" placeholder="Tanggal" required>
                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button class="btn btn-success"><span class="fa fa-print"></span> View</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="lap_jual_periode_cetak">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Pilih Periode</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <?php echo form_open('Laporan/lap_penjualan_periode_cetak', 'target="_blank"') ?>
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="control-label col-xs-3">Tanggal Awal</label>
                            <div class="col-xs-9">
                                <input type="date" class="form-control" name="tgl1" value="" placeholder="Tanggal" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-3">Tanggal Akhir</label>
                            <div class="col-xs-9">
                                <input type="date" class="form-control" name="tgl2" value="" placeholder="Tanggal" required>
                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button class="btn btn-success"><span class="fa fa-print"></span> Cetak</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!---------------------------------------------Laporan Penjualan Barang--------------------------------------------->

        <div class="modal fade" id="lap_jual_barang">
            <div class="modal-dialog">

                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Pilih Barang</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <?php echo form_open('Laporan/lap_penjualan_barang') ?>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="Kategori">Barang : </label>
                            <select required name="barang" id="barang" class="form-control">
                                <option value="">-- Pilih Barang --</option>
                                <?php foreach ($data->result_array() as $x) { ?>
                                    <option value="<?= $x['barang_id']; ?>"><?= $x['barang_nama']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button class="btn btn-success"><span class="fa fa-print"></span> View</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="lap_jual_barang_cetak">
            <div class="modal-dialog">

                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Pilih Barang</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <?php echo form_open('Laporan/lap_penjualan_barang_cetak', 'target="_blank"') ?>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="Kategori">Barang : </label>
                            <select required name="barang" id="barang" class="form-control">
                                <option value="">-- Pilih Barang --</option>
                                <?php foreach ($data->result_array() as $x) { ?>
                                    <option value="<?= $x['barang_id']; ?>"><?= $x['barang_nama']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button class="btn btn-success"><span class="fa fa-print"></span> Cetak</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!---------------------------------------------Laporan Penjualan Kategori Barang--------------------------------------------->

        <div class="modal fade" id="lap_penjualan_kat_barang">
            <div class="modal-dialog">

                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Pilih Kategori Barang</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <?php echo form_open('Laporan/lap_penjualan_kat_barang') ?>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="Kategori">Barang : </label>
                            <select required name="kat_barang" id="kat_barang" class="form-control">
                                <option value="">-- Pilih Kategori Barang --</option>
                                <?php foreach ($kat->result_array() as $x) { ?>
                                    <option value="<?= $x['kategori_id']; ?>"><?= $x['kategori_nama']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button class="btn btn-success"><span class="fa fa-print"></span> View</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="lap_penjualan_kat_barang_cetak">
            <div class="modal-dialog">

                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Pilih Kategori Barang</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <?php echo form_open('Laporan/lap_penjualan_kat_barang_cetak', 'target="_blank"') ?>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="Kategori">Barang : </label>
                            <select required name="kat_barang" id="kat_barang" class="form-control">
                                <option value="">-- Pilih Kategori Barang --</option>
                                <?php foreach ($kat->result_array() as $x) { ?>
                                    <option value="<?= $x['kategori_id']; ?>"><?= $x['kategori_nama']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button class="btn btn-success"><span class="fa fa-print"></span> Cetak</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


        <!---------------------------------------------Laporan Penjualan Laba--------------------------------------------->
        <div class="modal fade" id="lap_laba_rugi">
            <div class="modal-dialog">

                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Pilih Periode</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <?php echo form_open('Laporan/lap_laba_rugi') ?>
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="control-label col-xs-3">Tanggal Awal</label>
                            <div class="col-xs-9">
                                <input type="date" class="form-control" name="tgl1" value="" placeholder="Tanggal" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-3">Tanggal Akhir</label>
                            <div class="col-xs-9">
                                <input type="date" class="form-control" name="tgl2" value="" placeholder="Tanggal" required>
                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button class="btn btn-success"><span class="fa fa-print"></span> View</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="lap_laba_rugi_cetak">
            <div class="modal-dialog">

                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Pilih Periode</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <?php echo form_open('Laporan/lap_laba_rugi_cetak', 'target="_blank"') ?>
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="control-label col-xs-3">Tanggal Awal</label>
                            <div class="col-xs-9">
                                <input type="date" class="form-control" name="tgl1" value="" placeholder="Tanggal" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-3">Tanggal Akhir</label>
                            <div class="col-xs-9">
                                <input type="date" class="form-control" name="tgl2" value="" placeholder="Tanggal" required>
                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button class="btn btn-success"><span class="fa fa-print"></span> Cetak</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!---------------------------------------------Laporan Resume--------------------------------------------->
        <div class="modal fade" id="lap_resume">
            <div class="modal-dialog">

                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Pilih Periode</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <?php echo form_open('Laporan/lap_resume') ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label col-xs-3">Tanggal Awal</label>
                            <div class="col-xs-9">
                                <input type="date" class="form-control" name="start" value="" placeholder="start" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-3">Tanggal Akhir</label>
                            <div class="col-xs-9">
                                <input type="date" class="form-control" name="end" value="" placeholder="end" required>
                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button class="btn btn-success"><span class="fa fa-print"></span> View</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="lap_resume_cetak">
            <div class="modal-dialog">

                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Pilih Periode</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <?php echo form_open('Laporan/lap_resume_cetak', 'target="_blank"') ?>
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="control-label col-xs-3">Saldo</label>
                            <div class="col-xs-9">
                                <input type="input" id="saldo" class="form-control" name="saldo" value="" placeholder="Saldo" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-3">Tanggal Awal</label>
                            <div class="col-xs-9">
                                <input type="date" class="form-control" name="start" value="" placeholder="Tanggal" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-3">Tanggal Akhir</label>
                            <div class="col-xs-9">
                                <input type="date" class="form-control" name="end" value="" placeholder="Tanggal" required>
                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button class="btn btn-success"><span class="fa fa-print"></span> Cetak</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


        <!---------------------------------------------Laporan Pengeluaran Toko--------------------------------------------->
        <div class="modal fade" id="lap_pengeluaran_toko">
            <div class="modal-dialog">

                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Pilih Periode</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <?php echo form_open('Laporan/lap_pengeluaran_toko') ?>
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="control-label col-xs-3">Tanggal Awal</label>
                            <div class="col-xs-9">
                                <input type="date" class="form-control" name="tgl1" value="" placeholder="Tanggal" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-3">Tanggal Akhir</label>
                            <div class="col-xs-9">
                                <input type="date" class="form-control" name="tgl2" value="" placeholder="Tanggal" required>
                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button class="btn btn-success"><span class="fa fa-print"></span> View</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="lap_pengeluaran_toko_cetak">
            <div class="modal-dialog">

                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Pilih Periode</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <?php echo form_open('Laporan/lap_pengeluaran_toko_cetak', 'target="_blank"') ?>
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="control-label col-xs-3">Tanggal Awal</label>
                            <div class="col-xs-9">
                                <input type="date" class="form-control" name="tgl1" value="" placeholder="Tanggal" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-3">Tanggal Akhir</label>
                            <div class="col-xs-9">
                                <input type="date" class="form-control" name="tgl2" value="" placeholder="Tanggal" required>
                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button class="btn btn-success"><span class="fa fa-print"></span> Cetak</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#saldo').divide({
                    delimiter: ',',
                    divideThousand: true, // 1,000..9,999
                    delimiterRegExp: /[\.\,\s]/g
                });
            })
        </script>
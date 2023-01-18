<style>
    .ui-autocomplete {
        z-index: 1050;
        max-height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
    }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->


    <?php

    $dat = $this->session->flashdata('msg');
    if ($dat != "") { ?>
        <div class="alert alert-success"><strong>Sukses! </strong> <?= $dat; ?>
            <?php if ($this->session->userdata('level') == 'penjualan') { ?>
                <a class="btn btn-info" href="<?php echo site_url('penjualan/cetak_faktur_cabang') ?>" target="_blank"><span class="fa fa-print"></span>Cetak</a>
            <?php } else { ?>
                <a class="btn btn-info" href="<?php echo site_url('penjualan/cetak_faktur') ?>" target="_blank"><span class="fa fa-print"></span>Cetak</a>

            <?php } ?>
        </div>
    <?php } ?>
    <?php

    $dat = $this->session->flashdata('msg_brg');
    if ($dat != "") { ?>
        <div class="alert alert-success"><strong>Sukses! </strong> <?= $dat; ?>
        </div>
    <?php } ?>

    <?php
    $dat = $this->session->flashdata('muka');
    if ($dat != "") { ?>
        <div class="alert alert-success"><strong>Sukses! </strong> <?= $dat; ?>
            <a class="btn btn-info" href="<?php echo site_url('penjualan/cetak_faktur_dp') ?>" target="_blank"><span class="fa fa-print"></span>Cetak</a>
        </div>
    <?php } ?>

    <!-- FLASH DATA -->
    <?php
    $dat1 = $this->session->flashdata('error');
    if ($dat1 != "") { ?>
        <div id="notifikasi" class="alert alert-danger"><strong>Gagal !</strong> <?= $dat1; ?></div>
    <?php } ?>



    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Penjualan</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <?php echo form_open('history_penjualan_cabang/add_to_cart') ?>
            <input type="hidden" name="nofak" value="<?=  $this->uri->segment(3) ?>">
            <div class="row">
                <div class="form-group col-sm-3" style="position: relative;">
                    <label>Nama Barang : </label>
                    <input class="form-control" id="nabar" type="search" autocomplete="off" />
                    <div class="ajax_list_barang">
                        <ul style="list-style:none;" class="list_container" id="list_container">

                        </ul>
                    </div>
                </div>
                <div class="form-group" style="max-width: 10%;">
                    <label>Satuan :</label>
                    <input type="text" readonly id="satuan_ket" name="satuan" class="form-control" />
                    <input type="hidden" readonly id="kode_brg_ket" name="kode_brg_ket" class="form-control" />
                </div>
                <div class="form-group col-sm-1">
                    <label>Stok :</label>
                    <input type="text" readonly id="stok_ket" name="stok_ket" class="form-control" />
                </div>
                <div class="form-group col-sm-2">
                    <label>Harga(Rp) :</label>
                    <?php if ($this->session->userdata('level') == "penjualan") { ?>
                        <input type="text" readonly id="harga_ket_cabang" name="harga_ket" class="form-control" />
                    <?php } else { ?>
                        <input type="text" readonly id="harga_ket" name="harga_ket" class="form-control" />
                    <?php  } ?>
                </div>
                <div class="form-group col-sm-4">
                    <label>Keterangan :</label>
                    <input type="text" id="keterangan" name="keterangan" class="form-control" />
                </div>
                <div class="form-group col-sm-2">
                    <label>Jumlah :</label>
                    <input type="number" readonly id="jumlah_ket" name="jumlah_ket" class="form-control" min="0" />
                </div>
                <div class="form-group col-sm-3">
                    <label>&nbsp;</label><br />
                    <button class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
                </div>
            </div>
            <!-- <div class="table-responsive">
                <a href="#nabar" class="btn btn-info btn-sm"><i class='fas fa-sync'></i> Refresh</a>
                <hr>
                <table class="border">
                  <tr>
                    <th>Nama Barang : </th>
                  </tr>
                  <tr>
                    <th class="col-sm-12">
                      
                    </th>
                  </tr>
                  <div id="detail_barangku" style="position:absolute;">
                  </div>
                </table>
              </div> -->
            </form>
            <br />
            <hr>
            <div class="" style="overflow: hidden;">
                <div class="table-responsive" id="result_table">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Harga Jual</th>
                                <th>Keterangan</th>
                                <th>Jumlah Beli</th>
                                <th>Sub Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $i = 1;
                            $total = 0;
                            ?>
                            <?php foreach ($penjualan as $items) :
                                $total += $items['d_jual_total'];
                            ?>
                                <tr>
                                    <td><?= $items['d_jual_barang_id']; ?></td>
                                    <td><?= $items['d_jual_barang_nama']; ?></td>
                                    <td style="text-align:center;"><?= $items['d_jual_barang_satuan']; ?></td>
                                    <td style="text-align:right;"><?php echo number_format($items['d_jual_barang_harjul']); ?></td>
                                    <td style="text-align:right;"><?php echo $items['d_jual_diskon']; ?></td>
                                    <td style="text-align:center;">
                                        <form action="<?= base_url('history_penjualan_cabang/updateQty/' . $items['d_jual_id']) ?>" method="post">
                                            <input type="hidden" value="<?= $items['d_jual_qty'] ?>" name="qty">
                                            <input type="hidden" value="<?= $items['d_jual_nofak'] ?>" name="nofak_items">
                                            <input type="hidden" value="<?= $items['d_jual_barang_id'] ?>" name="barang_id">
                                            <input type="hidden" value="<?= $items['d_jual_barang_harjul'] ?>" name="harjul_items">
                                            <input type="text" name="qty" value="<?php echo number_format($items['d_jual_qty']); ?>">
                                        </form>
                                    </td>
                                    <td style="text-align:right;"><?php echo number_format($items['d_jual_total']); ?></td>

                                    <td style="text-align:center;"><a href="<?= base_url('history_penjualan_cabang/removeItems/' . $items['d_jual_nofak'] . "/" . $items['d_jual_id']."/" . $items['d_jual_barang_id']."/".$items['d_jual_qty']) ?>" class="btn btn-warning btn-xs"><span class="fa fa-close"></span> Batal</a></td>
                                </tr>


                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <br>
                <?php
                echo form_open('penjualan/simpan_penjualan_cabang', array("id" => "simpan_penjualan_form")) ?>

                <a href="#no_hp" class="btn btn-info btn-sm"><i class='fas fa-sync'></i> Refresh</a>

                <hr>
                <div class="form-group">
                    <label>Cabang</label>
                    <select name="cabang" class="form-control col-sm-3">
                        <?php foreach ($cabang->result() as $cbg) {
                            $nm = $cbg->nama_cabang;

                        ?>

                            <option value="<?php echo $nm; ?>" <?php if ($jual[0]->cabang == $nm) {
                                                                    echo 'selected';
                                                                } ?>><?php echo $nm; ?></option>


                        <?php } ?>
                    </select>
                </div>

                <br>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label class="font-weight-bold">Total Belanja(Rp) :</label>
                        <input type="text" name="total2" value="<?php echo number_format($total); ?>" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly></th>
                        <input type="hidden" id="total" name="total" value="<?php echo $total; ?>" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly />
                    </div>
                    <div class="form-group col-sm-2">
                        <label class="font-weight-bold">Cara Bayar 1 :</label>
                        <?php if ($this->session->userdata('level') == "penjualan") { ?>
                            <input type="hidden" name="bayar" value="Cash">
                        <?php } ?>
                        <select required name="bayar" id="bayar" class="form-control" <?php if ($this->session->userdata('level') == "penjualan") {
                                                                                            echo "disabled";
                                                                                        } ?>>
                            <option value="" disabled>-- Pilih Cara Bayar --</option>
                            <?php foreach ($cara_bayar as $bayar) {
                            ?>
                                <option value="<?= $bayar->cara_bayar ?>" <?php if ($jual[0]->jual_keterangan == $bayar->cara_bayar) echo 'selected' ?>><?= $bayar->cara_bayar ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-sm-2">
                        <label class="font-weight-bold">Cara Bayar 2 :</label>
                        <input type="hidden" name="bayar2" value="">
                        <select name="bayar2" id="bayar2" class="form-control" disabled>
                            <option value="" selected>-- Pilih Cara Bayar --</option>
                            <?php foreach ($cara_bayar as $bayar) {

                                if ($bayar->cara_bayar == 'DP')
                                    continue;
                            ?>
                                <option value="<?= $bayar->cara_bayar ?>"><?= $bayar->cara_bayar ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-sm-2">
                        <label class="font-weight-bold">Status :</label>
                        <select name="status" id="status" class="form-control">
                            <option value="COMPLETE">Lunas</option>
                            <option value="DP">DP</option>
                            <option value="Kredit" selected>Kredit</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label class="font-weight-bold">Keterangan :</label>
                        <input type="text" id="diskon" name="diskon" class="diskon form-control input-sm" value="<?= $jual[0]->diskon ?>">
                    </div>
                </div>
                <br>

                <table>


                    <tr>
                        <td class="col-sm-6" rowspan="3">
                            <input type="hidden" name="jenis_cetak" id="jenis_cetak" />
                            <small class="text-danger">Cetak Faktur ( Cetak Surat Jalan dan Faktur ) , Cetak Surat Jalan hanya cetak surat jalan </small><br /><br />
                            <button type="submit" class="btn btn-success btn-lg" onclick="submitForm('faktur')"> CETAK FAKTUR</button><br />
                            <br /><button type="submit" class="btn btn-info btn-lg" onclick="submitForm('sj')"> CETAK SURAT JALAN</button>
                        </td>

                        <th colspan="4">Total Yang Harus Dibayar (Rp) : </th>

                        <th style="text-align:right;"><input type="text" id="totbayar" value="<?php echo number_format($total); ?>" min="0" name="totbayar" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly></th>
                    </tr>
                    <tr>
                        <th colspan="4">Tunai 1(Rp) :</th>
                        <th style="text-align:right;"><input type="text" id="jml_uang" name="jml_uang" value="<?php echo number_format($total); ?>" class="jml_uang form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly></th>


                    </tr>
                    <tr id="tunai2_la_">
                        <th colspan="4">Tunai 2(Rp) :</th>
                        <th style="text-align:right;"><input type="text" id="jml_uang2" name="jml_uang2" class="jml_uang2 form-control input-sm" style="text-align:right;margin-bottom:5px;" required></th>

                    </tr>
                    <tr>
                        <td></td>
                        <th colspan="4" id="kembalian_label">Kembalian(Rp) :</th>
                        <th style="text-align:right;"><input type="text" id="kembalian" name="kembalian" value="0" class="form-control input-sm kembalian" style="text-align:right;margin-bottom:5px;" required readonly></th>
                    </tr>


                </table>


                </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="add_barang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Barang</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <?php echo form_open_multipart('Penjualan/tambah_barang') ?>
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
</div>
<!-- /.container-fluid -->

</div>

<!-- End of Main Content -->



<script type='text/javascript'>
    $("#jml_uang2").prop('readonly', true)
    $("#jml_uang2").prop('value', 0)
    $('.ajax_list_barang').hide()
    $(document).ready(function() {
        $('input[name="nabar"]').autocomplete({
            source: "<?= base_url('Barang/autoBarang/'); ?>"
        });
        $('.select').select2();
        loadData()
    })

    function loadData() {
        $('#dataTable tr').each(function() {
            var kode_brg = $(this).find("td:first").html();
            const selected = [];
            $(".form-check input[type=checkbox]").each(function() {
                selected.push(this.value);
            });
            selected.map((item, index) => {
                console.log(item)
                if (item == kode_brg) {
                    $('#pkt' + kode_brg).prop('checked', true);
                }
            })
        });
    }

    function submitForm(jenis) {
        $('#jenis_cetak').val(jenis)
    }

    $('#simpan_penjualan_form').submit(function() {

        var total = $('#totbayar').val()
        var uang = $("#jml_uang").val();
        var uang2 = $("#jml_uang2").val();
        var status = $("#status").val();
        var jenis_cetak = $("#jenis_cetak").val();
        var bayar = parseInt(uang) + parseInt(uang2)
        if (bayar < total && status == 'COMPLETE') {
            swal.fire("Penjualan", "Uang tidak cukup untuk bayar Lunas, silahkan pilih status DP untuk melanjutkan !", "warning")
            return false;
        }
        if (bayar >= total && status == 'COMPLETE') {
            return true;
        }
        if (status == 'DP') {
            return true;
        }
    })
    $("#bayar2").change(function() {
        if (!$("#bayar").val()) {
            swal.fire("Penjualan", "Bayar 1 Harus dipilih", "warning")
            $(this).val("")
        } else {
            if ($(this).val() == "") {
                $("#jml_uang2").prop('readonly', true)
                $("#jml_uang2").val(0)
                // Hitung Ulang
                var uang = $("#jml_uang").val();
                var uang2 = $("#jml_uang2").val();
                var total_b = $("#total").val();
                var diskon = $("#diskon").val();
                var tot_bayar = total_b;
                if (!uang2) {
                    uang2 = 0;
                }
                var totall = parseInt(uang) + parseInt(uang2)
                var hitung = totall - tot_bayar
                $("#totbayar").val(tot_bayar);
                if (parseInt(totall) > parseInt(tot_bayar)) {
                    $("#kembalian_label").text("Kembalian(Rp)")
                    hitung = Math.abs(hitung);
                } else if (parseInt(totall) < parseInt(tot_bayar)) {
                    $("#kembalian_label").text("Kekurangan(Rp)")
                    hitung = Math.abs(hitung);
                }
                if (!hitung) {
                    hitung = 0
                }
                $("#kembalian").val(hitung);
            } else {
                $("#jml_uang2").prop('readonly', false)
            }
        }

    })



    $('#nabar').keyup(function() {
        let search = $(this).val();
        if (search == "") {
            $('.ajax_list_barang').hide()
        } else {
            $.ajax({
                url: '<?= base_url() ?>/penjualan/get_barang_autocomplete',
                type: 'POST',
                cache: false,
                data: {
                    "search": search
                },
                success: function(res) {

                    $('.ajax_list_barang').show()
                    $("#list_container").html(res)
                    $('.item_barang').click(function() {
                        let value = $(this).attr('data-value')
                        let label = $(this).text()
                        $('#nabar').val(label)
                        if (value != "tambah_barang") {
                            var res = value.split("#");
                            console.log(res)
                            <?php if ($this->session->userdata('level') == 'penjualan') { ?>
                                $('#harga_ket_cabang').val(formatUang(res[4]))
                            <?php } else { ?>
                                $('#harga_ket').val(formatUang(res[0]))
                            <?php } ?>
                            $('#kode_brg_ket').val(res[1])
                            $('#jumlah_ket').val(1)
                            $('#satuan_ket').val(res[2])
                            $('#stok_ket').val(res[3])
                        } else {
                            $('#add_barang').modal('show')
                            $('#nabar').val('')
                        }
                        $('.ajax_list_barang').hide()
                    })
                }
            })
        }

    })
</script>
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Pembyaran DP</h1>
<?php 
      $dat = $this->session->flashdata('msg');
          if($dat!=""){ ?>
                <div class="alert alert-success"><strong>Sukses! </strong> <?=$dat;?>
                <a class="btn btn-info" href="<?php echo site_url('penjualan/cetak_faktur')?>" target="_blank"><span class="fa fa-print"></span>Cetak</a>
                </div>
      <?php } ?>
      
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Daftar Pembyaran DP</h6>
  </div>
  <br>
  <div class="card-body">
    <br>
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>No HP</th>
            <th>No Faktur</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>No HP</th>
            <th>No Faktur</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th>Aksi</th>
          </tr>
        </tfoot>
        <tbody>
        <?php $no=1; foreach($data as $a){ ?>
            <?php
                $no_fak = $a['jual_nofak'];
                $jmlh = $this->db->query("select count(d_jual_nofak) as jum from tbl_detail_jual_dp where d_jual_nofak='$no_fak'")->row_array();
            ?>

          <tr>
            <td><?= $no++; ?></td>
            <td><?php echo $a['jual_tanggal']; ?></td>
            <td><?= $a['no_hp']; ?></td>
            <td><?= $a['jual_nofak']; ?></td>
            <td><?= $jmlh['jum']; ?> items</td>
            <td>Rp. <?= number_format($a['jual_total']); ?></td>
            <td class="text-center">
              <a class="badge badge-success" href="<?= base_url(); ?>jual_dp/in_detail/<?= $a['jual_nofak']; ?>">View</a>
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
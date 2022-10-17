<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data History Penjualan</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
  <!-- FLASH DATA -->    
  <?php 
      $dat = $this->session->flashdata('msg');
          if($dat!=""){ ?>
                <div id="notifikasi" class="alert alert-success"><strong>Sukses! </strong> <?=$dat;?></div>
      <?php } ?> 
    <h6 class="m-0 font-weight-bold text-primary">Daftar History Penjualan</h6>
  </div>
  <br>
  <div class="card-body">
    <br>
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama PLG</th>
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
            <th>Nama PLG</th>
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
                $jmlh = $this->db->query("select count(d_jual_nofak) as jum from tbl_detail_jual where d_jual_nofak='$no_fak'")->row_array();
            ?>

          <tr>
            <td><?= $no++; ?></td>
            <td><?php echo $a['namaplg']; ?></td>
            <td><?php echo $a['jual_tanggal']; ?></td>
            <td><?php echo $a['no_hp']; ?></td>
            <td><?= $a['jual_nofak']; ?></td>
            <td><?= $jmlh['jum']; ?> items</td>
            <td>Rp. <?= number_format($a['jual_total']); ?></td>
            <td class="text-center">
              <a class="badge badge-success" href="<?= base_url(); ?>history_penjualan/in_detail/<?= $a['jual_nofak']; ?>">View</a>
              <?php
                if($this->session->userdata("level")=="admin"){
              
              ?>
              <a class="badge badge-success" href="<?= base_url(); ?>history_penjualan/cetak_faktur/<?= $a['jual_nofak']; ?>" target="_blank">Cetak</a>
              <a class="badge badge-success" href="<?= base_url(); ?>penjualan_edit/index/<?= $a['jual_nofak']; ?>">Edit</a>
              <a class="badge badge-success" href="<?= base_url(); ?>history_penjualan/takdeletekowe/<?= $a['jual_nofak']; ?>">Delete</a>
              <?php } ?>
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
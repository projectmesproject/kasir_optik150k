 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data History Pembelian</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Daftar History Pembelian</h6>
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
            <th>Kode Beli</th>
            <th>Nama Suplier</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Kode Beli</th>
            <th>Nama Suplier</th>
            <th>Aksi</th>
          </tr>
        </tfoot>
        <tbody>
          <?php $no=1; foreach($data as $a){ 
            $id = $a['beli_suplier_id'];
            $data1 = $this->db->query("select * from tbl_suplier where suplier_id='$id'")->row_array();
          ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?php echo date("d M Y",strtotime($a['beli_tanggal'])); ?></td>
            <td><?= $a['beli_nofak']; ?></td>
            <td><?= $data1['suplier_nama']; ?></td>
            <td class="text-center">
              <a class="badge badge-success" href="<?= base_url(); ?>history_pembelian/in_detail/<?= $a['beli_nofak']; ?>">View</a>
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
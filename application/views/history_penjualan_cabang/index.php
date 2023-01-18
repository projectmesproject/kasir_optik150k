<div class="container-fluid" style="min-height: 100vh;">


  <div class="title">
    <h6>
      <?php echo $title ?>
    </h6>
  </div>

  <div class="card border-0 shadow mt-5">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Cabang</th>
              <th>Tanggal</th>
              <th>No Faktur</th>
              <th>Jumlah</th>
              <th>Total Harga</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($data_penjualan_cabang as $item) {
            ?>

              <tr>
                <td>
                  <?= $no++ ?>
                </td>
                <td>
                  <?= $item['cabang'] ?>
                </td>
                <td>
                  <?= $item['jual_tanggal'] ?>
                </td>
                <td>
                  <?= $item['jual_nofak'] ?>
                </td>
                <td>
                  <?= $item['jumlah_item'] ?>
                </td>
                <td>
                  Rp. <?= number_format($item['jual_total']) ?>
                </td>
                <td>
                  <div class="badge p-2 rounded-1 
                  <?php
                  switch ($item['status']) {
                    case 'COMPLETE':
                      echo 'badge-success';
                      break;
                    case 'CANCEL':
                      echo 'badge-danger';
                      break;
                    case 'DP':
                      echo 'badge-warning';
                      break;
                  }

                  ?>">
                    <?= $item['status'] ?>
                  </div>
                </td>
                <td>
                  <button data-toggle="modal" id="btn" data-target="#detailModal" class="btn btn-success" onclick="loadDetail('<?php echo $item['jual_nofak'] ?>')">
                    View
                  </button>
                </td>
              </tr>

            <?php } ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>


</div>

<script>
  function loadDetail(id) {
    // console.log(id)

    $.ajax({
      url: ' <?= base_url(); ?>history_penjualan_cabang/in_detail/' + id,
      type: "GET",
      success: (result) => {
        $("#idModalDeep").html(result)

        
      }
    })
  }
</script>
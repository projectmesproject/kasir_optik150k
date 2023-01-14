<?php

if (!$this->session->userdata('level')) {
  $this->session->set_flashdata("message", ' <div class="alert alert-danger" role="alert">
Sesi Login Telah Habis, Silahkan Login Kembali</div>');
  return redirect("/");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?= $title; ?></title>

  <!-- Custom fonts for this template-->
  <link href="<?= base_url('assets/admin/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= base_url('assets/admin/'); ?>css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
  <link href="<?= base_url('assets/admin/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css" />

  <link href="<?= base_url('assets/admin/'); ?>css/jquery-ui.css" rel="stylesheet">
  <link href="<?= base_url('assets/plugins/'); ?>select2/select2.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.js"></script>
  <?php if ($this->session->userdata('level') == "kasir" || $this->session->userdata("level") == "admin") { ?>
    <script>
      document.onkeyup = KeyCheck;

      function KeyCheck(e) {
        var KeyID = (window.event) ? event.keyCode : e.keyCode;
        if (KeyID == 113) {
          $.ajax({
            type: "POST",
            url: "<?php echo site_url('Ajax/getJual'); ?>",
            success: function(msg) {
              $('#teswoii').html(msg);
            }
          });
          $('#modalLaporanPenjualan').modal('show');
        }

        if (KeyID == 115) {
          if ("<?= $this->session->userdata('saldo') ?>" == 0 && $('#saldo_response').val() == 0) {
            $('#modalSaldo').modal('show');
          } else {
            $.ajax({
              type: "POST",
              url: "<?php echo site_url('Ajax/getResume'); ?>",
              success: function(msg) {
                $('#resumewoi').html(msg);
              }
            });
            $('#modalLaporanPenjualanResume').modal('show');
          }
        }
        $('#triggerSaldo').submit(function(ev) {
          ev.preventDefault();
          $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            cache: false,
            data: $(this).serialize(),
            success: function(res) {
              $('#modalSaldo').modal('hide');
              $.ajax({
                type: "POST",
                url: "<?php echo site_url('Ajax/getResume'); ?>",
                success: function(msg) {
                  console.log(msg)
                  $('#resumewoi').html(msg);
                  $('#modalLaporanPenjualanResume').modal('show');

                  $('#label_saldo_lap').text($('#saldo_response').val())
                }
              });
            }
          })
        })
      }
    </script>
  <?php } ?>

  <style>
    .select2-selection {
      -webkit-box-shadow: 0;
      box-shadow: 0;
      background-color: #fff;
      border: 0;
      border-radius: 0;
      color: #555555;
      font-size: 14px;
      outline: 0;
      min-height: 48px;
      text-align: left;
    }

    .select2-selection__rendered {
      margin: 10px;
    }

    .select2-selection__arrow {
      margin: 10px;
    }

    .ajax_list_barang {
      position: absolute;
      bottom: 1;
      max-height: 220px;
      z-index: 100;
      background-color: #fff;
      width: 100%;
      overflow-y: auto;
      overflow-x: hidden;
      margin: 0 !important;
    }

    .list_container {
      list-style: none;
      padding-left: 0px !important;
      margin-left: 0px !important;

      border: 1px solid #eee;
      border-radius: 10px;
    }

    .list_container li {
      padding: 5px;
      padding-bottom: 0px !important;
      border-bottom: 1px solid #e0e0e0;
      cursor: pointer;
    }

    .list_container li:hover {
      background-color: #f0eded;
    }

    /* custom scrollbar */
    ::-webkit-scrollbar {
      width: 20px;
    }

    ::-webkit-scrollbar-track {
      background-color: transparent;
    }

    ::-webkit-scrollbar-thumb {
      background-color: #d6dee1;
      border-radius: 20px;
      border: 6px solid transparent;
      background-clip: content-box;
    }

    ::-webkit-scrollbar-thumb:hover {
      background-color: #a8bbbf;
    }

    input[type="search"] {
      -webkit-appearance: searchfield;
    }

    input[type="search"]::-webkit-search-cancel-button {
      -webkit-appearance: searchfield-cancel-button;
    }

    .modal-fullscreen .modal-dialog {
      max-width: 100%;
      margin: 0;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      height: 100vh;
      display: flex;
      position: fixed;
      z-index: 100000;
    }
  </style>
  <script>
    function formatUang(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
  </script>
</head>

<body id="page-top">
  <!-- Modal -->
  <div class="modal fade modal-fullscreen" id="modalLaporanPenjualanResume" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tanggal : <?= date('d-m-Y'); ?> <br>Saldo Di Kasir : <span id="label_saldo_lap"><?= number_format($this->session->userdata('saldo')) ?></span></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="resumewoi">
            <input type="hidden" id="saldo_response" value="0" />
            tes.
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade modal-fullscreen" id="modalLaporanPenjualan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Penjualan Tanggal : <?= date('d-m-Y'); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="teswoii">tes.</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade bd-example-modal-sm" id="modalSaldo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Anda Belum Mengisi saldo! Mohon isi Saldo Terlebih dahulu</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= base_url('Ajax/Saldo') ?>" id="triggerSaldo" method="post">

          <div class="modal-body">
            <div class="row">
              <div class="col-12">
                <label> Saldo </label>
                <input type="number" class="form-control" name="saldo" placeholder="Saldo" />
              </div>
            </div>

          </div>
          <div class=" modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Confirm</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Page Wrapper -->
  <div id="wrapper">
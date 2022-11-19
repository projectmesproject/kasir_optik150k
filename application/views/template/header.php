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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css" />

  <link href="<?= base_url('assets/admin/'); ?>css/jquery-ui.css" rel="stylesheet">
  <link href="<?= base_url('assets/plugins/'); ?>select2/select2.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.js"></script>
  <?php if ($this->session->userdata('level') == "kasir") { ?>
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
  </style>
  <script>
    function formatUang(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
  </script>
</head>

<body id="page-top">
  <!-- Modal -->
  <div class="modal fade bd-example-modal-lg" id="modalLaporanPenjualan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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
  <!-- Page Wrapper -->
  <div id="wrapper">
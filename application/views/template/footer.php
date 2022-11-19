<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <?php
      $data1 = $this->db->query("select * from tbl_setting where id=1")->row_array();
      ?>
      <span>Copyright &copy; <?= $data1['fitur']; ?> </span>
    </div>
  </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="<?= base_url(); ?>auth/logout">Logout</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/admin/'); ?>vendor/jquery/jquery.min.js"></script>

<script src="<?= base_url('assets/admin/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/admin/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/admin/'); ?>js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= base_url('assets/admin/'); ?>vendor/chart.js/Chart.min.js"></script>

<!-- Page level plugins -->
<script src="<?= base_url('assets/admin/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/admin/'); ?>js/jquery-ui.js"></script>
<script src="<?= base_url('assets/admin/'); ?>js/number-divider.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>



<!-- Page level custom scripts -->
<script src="<?= base_url('assets/admin/'); ?>js/demo/chart-area-demo.js"></script>
<script src="<?= base_url('assets/admin/'); ?>js/demo/chart-pie-demo.js"></script>
<script src="<?= base_url('assets/admin/'); ?>js/jquery-ui.js"></script>

<script src="<?= base_url('assets/'); ?>plugins/sweetalert/sweetalert2.all.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/select2/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $('#dataTable').DataTable();
  });
</script>
<script type="text/javascript">
  $('#notifikasi').slideDown('slow').delay(5000).slideUp('slow');
</script>

<script type="text/javascript">
  $(document).ready(function() {
    //Ajax kabupaten/kota insert
    $("#kode_brg").focus();
    $("#kode_brg").keyup(function() {
      var kobar = {
        kode_brg: $(this).val()
      };
      $.ajax({
        type: "POST",
        url: "<?php echo site_url('pembelian/get_barang'); ?>",
        data: kobar,
        success: function(msg) {
          $('#detail_barang').html(msg);
        }
      });
    });

    $("#kode_brg").keypress(function(e) {
      if (e.which == 13) {
        $("#jumlah").focus();
      }
    });
  });
</script>

<!-------------------------------PENJUALAN------------------------------------------------>

<!--- Pencarian berdasarkan nama -->



<script type="text/javascript">
  $(document).ready(function() {
    //Ajax kabupaten/kota insert
    $("#nabar").focus();
    /**/
    $("#nabar").keyup(function() {
      var kobar = {
        nabar: $(this).val()
      };
      $.ajax({
        type: "POST",
        url: "<?php echo site_url('penjualan/get_barang'); ?>",
        data: kobar,
        success: function(msg) {
          $('#detail_barangku').html(msg);
        }
      });
    });

    $("#nabar").keypress(function(e) {
      if (e.which == 13) {
        $("#jumlah").focus();
      }
    });

  });
</script>





<script type="text/javascript">
  $(document).ready(function() {
    //Ajax kabupaten/kota insert

    $("#no_hp").keyup(function() {
      var kobar = {
        no_hp: $(this).val()
      };
      $.ajax({
        type: "POST",
        url: "<?php echo site_url('customer/get_customer'); ?>",
        data: kobar,
        success: function(msg) {
          $('#detail_customer').html(msg);
        }
      });
    });

  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#diskon").keyup(function() {
      var total_b = $("#total").val();
      var diskon = $("#diskon").val();
      var tot_bayar = total_b;
      $("#totbayar").val(tot_bayar);
    });

    $("#jml_uang").keyup(function() {

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
      if(!hitung){
        hitung = 0
      }
      $("#kembalian").val(hitung);
    });
    $("#jml_uang2").keyup(function() {

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
      if(!hitung){
        hitung = 0
      }
      $("#kembalian").val(hitung);
    });
    // $("#jml_uang2").keyup(function() {

    //   var uang = $("#jml_uang").val();
    //   var total_b = $("#total").val();
    //   var diskon = $("#diskon").val();
    //   var tot_bayar = total_b;
    //   $("#totbayar").val(tot_bayar);
    //   $("#kembalian").val(uang - tot_bayar);
    // });
  });
</script>

<script type="text/javascript">
  $(function() {
    /*
            $('.jml_uang').priceFormat({
                    prefix: '',
                    //centsSeparator: '',
                    centsLimit: 0,
                    thousandsSeparator: ','
            });

            $('#jml_uang2').priceFormat({
                    prefix: '',
                    //centsSeparator: '',
                    centsLimit: 0,
                    thousandsSeparator: ''
            });
            $('#kembalian').priceFormat({
                    prefix: '',
                    //centsSeparator: '',
                    centsLimit: 0,
                    thousandsSeparator: ','
            });
            $('.harjul').priceFormat({
                    prefix: '',
                    //centsSeparator: '',
                    centsLimit: 0,
                    thousandsSeparator: ','
            });
			
			*/
  });
</script>

<!-- SOURCE REVISI -->
<script type="text/javascript">
  $(document).ready(function() {

    // Format mata uang.

    // Format mata uang.
    $('.jml_uang').divide({
      delimiter: ',',
      divideThousand: true, // 1,000..9,999
      delimiterRegExp: /[\.\,\s]/g
    });
    // Format mata uang.
    $('.kembalian').divide({
      delimiter: ',',
      divideThousand: true, // 1,000..9,999
      delimiterRegExp: /[\.\,\s]/g
    });

    // Format mata uang.
    $('#totbayar').divide({
      delimiter: ',',
      divideThousand: true, // 1,000..9,999
      delimiterRegExp: /[\.\,\s]/g
    });

    // Format mata uang.
    $('#jml_uang2').divide({
      delimiter: ',',
      divideThousand: true, // 1,000..9,999
      delimiterRegExp: /[\.\,\s]/g
    });

  })
</script>



</body>

</html>
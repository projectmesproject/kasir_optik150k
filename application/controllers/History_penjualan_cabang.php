<?php
defined('BASEPATH') or exit('No direct script access allowed');



class History_penjualan_cabang extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('m_penjualan');
    if ($this->session->userdata('level') != TRUE) {
      redirect(base_url());
    }
  }

  function index()
  {
    $get_data_penjualan_cabang = $this->m_penjualan->get_penjualan_cabang();
    $data_penjualan_cabang = array();

    $data['title'] = "Data History Penjualan Cabang";

    foreach ($get_data_penjualan_cabang as $item) {
      $jumlah = $this->db->query("select count(d_jual_nofak) as jumlah_nofak from tbl_detail_jual where d_jual_nofak='$item[jual_nofak]'")->row();
      $item['jumlah_item'] = $jumlah->jumlah_nofak;
      array_push($data_penjualan_cabang, $item);
    }


    $data['data_penjualan_cabang'] = $data_penjualan_cabang;

    $this->load->view('template/header', $data);
    $this->load->view('template/sidebar', $data);
    $this->load->view('template/topbar', $data);
    $this->load->view('history_penjualan_cabang/index', $data);
    $this->load->view("modal/detail_penjualan", $data);
    $this->load->view('template/footer', $data);
  }


  function in_detail($id)
  {

    $detail_penjualan = $this->m_penjualan->detail_penjualan($id);
    $penjualan = $this->db->query("select * from tbl_jual where jual_nofak=$id ")->result();
    $penjualan_new = $penjualan[0];

?>
    <div class="table-responsive">
      <table class="table table-bordered" width="100%" cellspacing="0">
        <tr>
          <td width="220">No Faktur</td>
          <td width="20">:</td>
          <td><?= $penjualan_new->jual_nofak; ?></td>
        </tr>
        <tr>
          <td width="220">Tanggal Jual</td>
          <td width="20">:</td>
          <td><?= $penjualan_new->jual_tanggal; ?></td>
        </tr>
        <tr>
          <td width="220">Nama Cabang</td>
          <td width="20">:</td>
          <td><?= $penjualan_new->cabang; ?></td>
        </tr>
        <tr>
          <td width="220">Keterangan</td>
          <td width="20">:</td>
          <td><?= $penjualan_new->diskon; ?></td>
        </tr>
        <tr>
          <td width="220">Total Harga</td>
          <td width="20">:</td>
          <td><?= $penjualan_new->jual_total; ?></td>
        </tr>
      </table>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">DAFTAR BARANG</h6>
      </div>
      <br>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" width="100%" cellspacing="0">
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Nama Barang</th>
              <th class="text-center">Harga</th>
              <th class="text-center">Qty</th>
              <th class="text-center">Keterangan</th>
              <th class="text-center">Harga Total</th>
            </tr>
            <?php $no = 1;
            if (count($detail_penjualan) > 0) {
              foreach ($detail_penjualan as $a) { ?>
                <tr>
                  <td class="text-center"><?= $no++; ?></td>
                  <td class="text-center"><?= $a['d_jual_barang_nama']; ?></td>
                  <td class="text-center">Rp. <?= number_format($a['d_jual_barang_harjul']); ?></td>
                  <td class="text-center"><?= $a['d_jual_qty']; ?></td>
                  <td class="text-center"><?= $a['d_jual_diskon']; ?></td>
                  <td class="text-center">Rp. <?= number_format($a['d_jual_total']); ?></td>
                </tr>
              <?php }
            } else {
              ?>
              <tr>
                <td colspan="6" class="text-center">
                  Noting Data Not Found!
                </td>
              </tr>
            <?php
            }
            ?>
          </table>
        </div>
      </div>
    </div>
<?php
  }
}

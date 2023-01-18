<?php
defined('BASEPATH') or exit('No direct script access allowed');



class History_penjualan_cabang extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('m_penjualan');
    $this->load->model('m_kategori');
    $this->load->model('m_cabang');
    $this->load->model('m_barang');
    $this->load->model('m_suplier');
    $this->load->model('m_penjualan');
    $this->load->model('M_customer');
    $this->load->model('M_Cara_Bayar');
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


  function edit($id)
  {
    $data['title'] = "Edit Penjualan Cabang";
    // Prepare 
    $data['barang'] = $this->m_barang->tampil_barang();
    $data['nohp'] = $this->M_customer->tampil_customer();
    $data['cara_bayar'] = $this->M_Cara_Bayar->list();
    $data['kat'] = $this->m_kategori->tampil_kategori();
    $data['cabang'] = $this->m_cabang->tampil_cabang();
    $data["paket"] = $this->m_barang->getBarangPaket();

    // Set Data
    $data_cart = array();

    // Data
    $this->db->select('A.jual_nofak,B.*');
    $this->db->from('tbl_jual A');
    $this->db->where('A.jual_nofak', $this->uri->segment(3));
    $this->db->where('A.cabang != ""');
    $this->db->join('tbl_detail_jual B', 'B.d_jual_nofak = A.jual_nofak');
    $data["penjualan"] = $this->db->get()->result_array();
    $this->db->select("*");
    $this->db->from("tbl_jual");
    $this->db->where("jual_nofak", $this->uri->segment(3));
    $this->db->where("cabang != ''");
    $data["jual"] =  $this->db->get()->result_object();

    $this->load->view('template/header', $data);
    $this->load->view('template/sidebar', $data);
    $this->load->view('template/topbar', $data);
    $this->load->view('history_penjualan_cabang/edit', $data);
    $this->load->view('template/footer', $data);
  }

  function updateQty($id_jual)
  {
    $qty = $this->input->post('qty');
    $harjul = $this->input->post('harjul_items');
    $nofak = $this->input->post('nofak_items');
    $barang_id = $this->input->post('barang_id');
    $total = (int) $qty * (int) $harjul;

    // Select Stok
    $data = $this->db->query("SELECT barang_stok FROM tbl_barang WHERE barang_id='$barang_id'")->row();
    $qty_barang = $data->barang_stok;
    $qty_update = (int)$qty_barang - (int)$qty;

    // Update Stok
    $this->db->query("UPDATE tbl_barang SET barang_stok='$qty_update' WHERE barang_id='$barang_id'");


    $this->db->query("UPDATE tbl_detail_jual SET d_jual_qty='$qty',d_jual_total='$total' WHERE d_jual_id='$id_jual'");

    redirect('history_penjualan_cabang/edit/' . $nofak);
  }

  function add_to_cart()
  {
    $kobar = $this->input->post('kode_brg_ket');
    
    $stok = $this->input->post("stok_ket");
    $qty = $this->input->post('jumlah_ket');
    $nofak = $this->input->post('nofak');

    $this->m_penjualan->edit_penjualan_cabang($nofak, $kobar,$qty);
    
    redirect('history_penjualan_cabang/edit/' . $nofak);
  }


  function removeItems($nofak, $id_jual,$barang_id,$qty)
  {
    // Select Stok
    $data = $this->db->query("SELECT barang_stok FROM tbl_barang WHERE barang_id='$barang_id'")->row();
    $qty_barang = $data->barang_stok;
    $qty = (int)$qty + (int)$qty_barang;

    // Update Stok
    $this->db->query("UPDATE tbl_barang SET barang_stok='$qty' WHERE barang_id='$barang_id'");
    $this->db->query("DELETE FROM tbl_detail_jual WHERE d_jual_id='$id_jual'");

    redirect('history_penjualan_cabang/edit/' . $nofak);
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
      <div class="card-footer">
        <button class="btn btn-warning" onclick="window.location='<?= base_url() ?>history_penjualan_cabang/edit/<?= $id ?>'">EDIT</button>
        <button class="btn btn-danger">DELETE</button>
      </div>
    </div>
<?php
  }
}

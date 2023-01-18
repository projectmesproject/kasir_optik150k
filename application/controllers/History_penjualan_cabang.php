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

    $select_barang = $this->db->query("SELECT d_jual_nofak,d_jual_qty FROM tbl_detail_jual WHERE d_jual_nofak='$nofak' AND d_jual_barang_id='$barang_id'")->row();
    $select = $this->db->query("SELECT jual_total FROM tbl_jual WHERE jual_nofak='$nofak'")->row();
    $jual_total = $select->jual_total;

    $qty_jual = $select_barang->d_jual_qty;

    $grand_total = 0;

    $this->db->query("UPDATE tbl_barang SET barang_stok=barang_stok + '$qty_jual' WHERE barang_id='$barang_id'");
   
    $this->db->query("UPDATE tbl_barang SET barang_stok=barang_stok - '$qty' WHERE barang_id='$barang_id'");

    $this->db->query("UPDATE tbl_detail_jual SET d_jual_qty='$qty',d_jual_total='$total' WHERE d_jual_id='$id_jual'");

    $select_all_barang = $this->db->query("SELECT d_jual_nofak,d_jual_qty,d_jual_total FROM tbl_detail_jual WHERE d_jual_nofak='$nofak'")->result_array();
    foreach($select_all_barang as $all_jual){
      $grand_total+=$all_jual['d_jual_total'];
    }
    
    $this->db->query("UPDATE tbl_jual SET jual_total='$grand_total' WHERE jual_nofak='$nofak'");

    redirect('history_penjualan_cabang/edit/' . $nofak);
  }

  function add_to_cart()
  {
    $kobar = $this->input->post('kode_brg_ket');

    $stok = $this->input->post("stok_ket");
    $qty = $this->input->post('jumlah_ket');
    $nofak = $this->input->post('nofak');

    $this->m_penjualan->edit_penjualan_cabang($nofak, $kobar, $qty);

    redirect('history_penjualan_cabang/edit/' . $nofak);
  }

  function cetak_faktur_sj($nofak)
  {
    $this->session->set_userdata('nofak', $nofak);
    $x['data'] = $this->m_penjualan->cetak_faktur_cabang();
    $this->load->view('laporan/v_cetak_faktur_sj', $x);
  }
  function cetak_surat_jalan($nofak)
  {
    $this->session->set_userdata('nofak', $nofak);
    $x['data'] = $this->m_penjualan->cetak_faktur_cabang();
    $this->load->view('laporan/v_surat_jalan', $x);
  }

  function update_cabang()
  {
    $cabang = $this->input->post("cabang");
    $nofak = $this->input->post("nofak");

    $this->db->query("UPDATE tbl_jual SET cabang='$cabang' WHERE jual_nofak='$nofak'");
  }


  function removeItems($nofak, $id_jual, $barang_id, $qty)
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

  function hapus_penjualan_cabang($nofak)
  {
    // Proses Get Penjualan
    $get_jual_detail = $this->db->query("SELECT d_jual_nofak,d_jual_qty,d_jual_barang_id FROM tbl_detail_jual WHERE d_jual_nofak='$nofak'")->result_array();
    foreach ($get_jual_detail as $jd) {
      $qty = $jd['d_jual_qty'];
      $barang_id = $jd['d_jual_barang_id'];
      // Update Stok
      $this->db->query("UPDATE tbl_barang SET barang_stok=barang_stok + '$qty' WHERE barang_id='$barang_id'");
    }

    // Hapus tbl_jual
    $this->db->delete('tbl_jual', array('jual_nofak' => $nofak)); 

    
    // Hapus tbl_detail_jual
    $this->db->delete('tbl_detail_jual', array('d_jual_nofak' => $nofak)); 

    $res = new stdClass();
    $res->status = 200;
    $res->message = "Berhasil Hapus Penjualan Cabang";
    echo json_encode($res);
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
          <td>Rp. <?= number_format($penjualan_new->jual_total); ?></td>
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
        <button class="btn btn-danger" onclick="deleteItems('<?= $id ?>')">DELETE</button>
      </div>
    </div>
    <script>
      function deleteItems(id) {
        Swal.fire({
          title: 'Hapus Penjualan Cabang Ini ?',
          showCancelButton: true,
          confirmButtonText: 'Hapus Penjualan Cabang',
          cancelButtonText: `Batal`,
          confirmButtonColor: '#dc3545'
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            $.ajax({
              url: '<?= base_url() ?>history_penjualan_cabang/hapus_penjualan_cabang/' + id,
              type: 'GET',
              cache: false,
              success: function(res) {
                console.log(res)
                try {
                  let response = JSON.parse(res)
                  if (response.status == 200) {
                    Swal.fire({
                      icon: 'success',
                      title: 'Hapus Penjualan Cabang',
                      text: response.message
                    }).then((result) => {
                      location.reload()
                    })
                  } else {
                    Swal.fire('Hapus Penjualan Cabang', response.message, 'warning')
                  }

                } catch (e) {
                  Swal.fire('Hapus Penjualan Cabang', 'Kesalahan Server', 'error')
                }
              }
            })
          }
        })
      }
    </script>
<?php
  }
}

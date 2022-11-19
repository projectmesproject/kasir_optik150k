<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('m_kategori');
        $this->load->model('m_barang');
        $this->load->model('m_suplier');
        $this->load->model('m_penjualan');
        $this->load->model('M_customer');
        $this->load->model('M_Cara_Bayar');
    }

    public function index()
    {
        $data['title'] = 'Penjualan';
        $data['barang'] = $this->m_barang->tampil_barang();
        $data['nohp'] = $this->M_customer->tampil_customer();
        $data['cara_bayar'] = $this->M_Cara_Bayar->list();
        $data['kat'] = $this->m_kategori->tampil_kategori();

        $data["paket"] = $this->m_barang->getBarangPaket();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('penjualan/index', $data);
        $this->load->view('template/footer', $data);
    }
    public function tambah_data()
    {
        $this->form_validation->set_rules('no_hp', 'No Hp/Telp', 'required|trim|min_length[11]|is_unique[tbl_customer.no_hp]', [
            'is_unique' => 'No Hp/Telp ini sudah terdaftar!'
        ]);
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Penjualan';
            $data['customer'] = $this->M_customer->tampilData();
            $data['kd_cus'] = $this->M_customer->getKodeCustomer();

            $this->session->set_flashdata('msg2', 'Data sudah ADA !');
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('penjualan/index', $data);
            $this->load->view('template/footer', $data);
        } else {
            $this->M_customer->tambah_data();
            $this->session->set_flashdata('sukses', 'Data Customer berhasil ditambahkan');

            redirect('penjualan');
        }
    }
    function tambah_barang()
    {
        //  Cek jika ada gambar yang ingin di upload


        $a = '-';
        $this->m_barang->tambah_barang($a);


        $this->session->set_flashdata('msg_brg', 'Berhasil ditambahkan');

        // $this->m_barang->tambah_barang();
        // $this->session->set_flashdata('msg','Berhasil');
        redirect('penjualan');
    }
    public function get_barang()
    {

        $kobar = $this->input->post('nabar');
        $x['brg'] = $this->m_barang->get_barang($kobar);

        $this->load->view('penjualan/detail_barang_jual', $x);
    }

    public function get_barang_autocomplete()
    {
        $result = $this->m_barang->getBarangList();
        $html = "";
        if (count($result) > 0) {

            foreach ($result as $v) {
                // $response[] = array("value"=>$v['value'],"label"=>$v['label']);
                $html .= "<li class='item_barang' data-value='$v[value]'>$v[label]</li>";
            }
        } else {
            $html .= "<li data-value='tambah_barang' class='item_barang'>(+) Tambah Data Barang</li>";
        }

        echo $html;
    }

    function bayar_dp()
    {
        $nofak = $this->input->post("nofak");
        $bayar = $this->input->post("bayar");
        $jml_uang1 = $this->input->post("jml_uang");
        $cara_bayar = $this->input->post("cara_bayar");
        $kurang = $this->input->post("kurang");
        if ($bayar == $kurang) {
            $jml_uang = (int)$bayar + (int)$jml_uang1;

            $data = [
                "jual_kurang_uang" => 0,
                "status" => "COMPLETE",
                "jual_jml_uang" => $jml_uang,
                "jual_keterangan2" => $cara_bayar
            ];

            $this->db->where('jual_nofak', $nofak);
            $this->db->update('tbl_jual', $data);
            redirect('history_penjualan');
        } else {
            $this->session->set_flashdata('msg2', 'Data gagal ditambahkan! uang anda kurang');
            redirect('history_penjualan/in_detail/' . $nofak);
        }
    }

    function get_autocomplete()
    {
        if (isset($_GET['term'])) {
            $result = $this->m_barang->search_barang($_GET['term']);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label'    => $row->barang_nama,
                    );
                echo json_encode($arr_result);
            }
        }
    }

    function get_autocomplete1()
    {
        if (isset($_GET['term'])) {
            $result = $this->M_customer->search_customer($_GET['term']);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label'    => $row->no_hp,
                    );
                echo json_encode($arr_result);
            }
        }
    }

    ///revisi baru 8/10/19
    function add_to_cart()
    {
        $kobar = $this->input->post('kode_brg_ket');
        $produk = $this->m_barang->get_barang1($kobar);
        $i = $produk->row_array();
        $data = array(
            'id'       => $i['barang_id'],
            'id_kat_barang' => $i['barang_kategori_id'],
            'name'     => $i['barang_nama'],
            'satuan'   => $i['barang_satuan'],
            'harpok'   => $i['barang_harpok'],
            'price'    => str_replace(",", "", $this->input->post('harga_ket')),
            'disc'     => $this->input->post('keterangan'),
            'qty'      => $this->input->post('jumlah_ket'),
            'amount'      => str_replace(",", "", $this->input->post('harga_ket'))
        );
        $this->cart->insert($data);
        redirect('penjualan');
    }

    function add_to_cart_paket()
    {
        $kobar = $this->input->post('kode_brg');

        $produk = $this->m_barang->get_barang1($kobar);
        $i = $produk->row_array();
        $data = array(
            'id'       => $i['barang_id'],
            'id_kat_barang' => $i['barang_kategori_id'],
            'name'     => $i['barang_nama'],
            'satuan'   => $i['barang_satuan'],
            'harpok'   => $i['barang_harpok'],
            'price'    => 0,
            'disc'     => 0,
            'qty'      => 1,
            'amount'      => 0
        );
        $this->cart->insert($data);
        ob_start();
?>
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead class="thead-light">
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th>Harga Jual</th>
                    <th>Keterangan</th>
                    <th>Jumlah Beli</th>
                    <th>Sub Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($this->cart->contents() as $items) : ?>
                    <?php echo form_hidden($i . '[rowid]', $items['rowid']); ?>
                    <tr>
                        <td><?= $items['id']; ?></td>
                        <td><?= $items['name']; ?></td>
                        <td style="text-align:center;"><?= $items['satuan']; ?></td>
                        <td style="text-align:right;"><?php echo number_format($items['amount']); ?></td>
                        <td style="text-align:right;"><?php echo $items['disc']; ?></td>
                        <td style="text-align:center;"><?php echo number_format($items['qty']); ?></td>
                        <td style="text-align:right;"><?php echo number_format($items['subtotal']); ?></td>

                        <td style="text-align:center;"><a href="<?php base_url() ?>penjualan/remove/<?= $items['rowid']; ?>" class="btn btn-warning btn-xs"><span class="fa fa-close"></span> Batal</a></td>
                    </tr>

                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php
        $konten = ob_get_contents();
        return $konten;
    }

    function remove()
    {


        $row_id = $this->uri->segment(3);
        $this->cart->update(array(
            'rowid'      => $row_id,
            'qty'     => 0
        ));
        redirect('penjualan');
    }

    function searchForId($id, $array)
    {
        foreach ($array as $key => $val) {
            if ($val['id'] === $id) {
                return $key;
            }
        }
        return null;
    }

    function remove_paket()
    {


        $row_id = $this->input->post('kode_brg');
        $data = $this->cart->contents();
        $key = $this->searchForId($row_id, $data);
        $this->cart->update(array(
            'rowid'      => $key,
            'qty'     => 0
        ));
        ob_start();
    ?>
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead class="thead-light">
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th>Harga Jual</th>
                    <th>Keterangan</th>
                    <th>Jumlah Beli</th>
                    <th>Sub Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($this->cart->contents() as $items) : ?>
                    <?php echo form_hidden($i . '[rowid]', $items['rowid']); ?>
                    <tr>
                        <td><?= $items['id']; ?></td>
                        <td><?= $items['name']; ?></td>
                        <td style="text-align:center;"><?= $items['satuan']; ?></td>
                        <td style="text-align:right;"><?php echo number_format($items['amount']); ?></td>
                        <td style="text-align:right;"><?php echo $items['disc']; ?></td>
                        <td style="text-align:center;"><?php echo number_format($items['qty']); ?></td>
                        <td style="text-align:right;"><?php echo number_format($items['subtotal']); ?></td>

                        <td style="text-align:center;"><a href="<?php base_url() ?>penjualan/remove/<?= $items['rowid']; ?>" class="btn btn-warning btn-xs"><span class="fa fa-close"></span> Batal</a></td>
                    </tr>

                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
<?php
        $konten = ob_get_contents();
        return $konten;
    }
    ///revisi baru 8/10/19

    function simpan_penjualan()
    {
        // jika uang1 > total = kembalian
        // jika uang1 < uang2 = kurang -> status = DP
        $nohp = $this->input->post('no_hp');
        $tampung = $this->db->query("select * from tbl_customer where no_hp='$nohp' ")->row_array();

        $payment1 = [];

        $get_cara_byr = $this->M_Cara_Bayar->list();
        foreach ($get_cara_byr as $byr) {
            if ($byr->cara_bayar == 'DP')
                continue;
            array_push($payment1, $byr->cara_bayar);
        }
        // Jika Bayar1 > Total Bayat
        if (in_array($this->input->post('bayar'), $payment1)) {
            $bayar = $this->input->post('bayar', TRUE);
            $bayar2 = $this->input->post('bayar2', TRUE);
            $total_belanja = $this->input->post('total'); ////sama tambahin ini juga jar kalau di kameranya
            $total = $this->input->post('totbayar');
            $diskon = $this->input->post('diskon');
            $jml_uang = str_replace(",", "", $this->input->post('jml_uang'));
            $jml_uang2 = str_replace(",", "", $this->input->post('jml_uang2'));
            $kembalian = str_replace(",", "", $this->input->post('kembalian'));
            $kurang = 0;
            $total_a = $jml_uang + $jml_uang2;
            if ($total_a > $total) {
                $kembalian = str_replace(",", "", $this->input->post('kembalian'));
                $kurang=0;
            }
            if ($total_a < $total) {
                $kurang = $total_belanja - $total_a;
                $kembalian = 0;
            }

            $status = $this->input->post('status');


            if (!empty($total) && !empty($jml_uang) && !empty($nohp)) {


                $nofak = $this->m_penjualan->get_nofak();
                $this->session->set_userdata('nofak', $nofak);

                if ($tampung['no_hp'] == NULL) {

                    $this->M_customer->tambah_data();
                }
                // $nofak, $total, $jml_uang,$kurang, $kembalian, $bayar,$bayar2, $diskon, $nohp,$status
                $order_proses = $this->m_penjualan->simpan_penjualan($nofak, $total, $jml_uang, $jml_uang2, $kurang, $kembalian, $bayar, $bayar2, $diskon, $nohp, $status);

                if ($order_proses) {
                    $this->cart->destroy();

                    $this->session->unset_userdata('tglfak');
                    $this->session->unset_userdata('suplier');
                    echo $this->session->set_flashdata('msg', 'Berhasil !!');
                    //v13nr redirect('penjualan');	
                    $this->cetak_faktur();
                } else {
                    redirect('penjualan');
                }
            } else {
                echo $this->session->set_flashdata('error', 'Penjualan Gagal di Simpan, Mohon Periksa Kembali Semua Inputan Anda!');
                redirect('penjualan');
            }
        }
    }

    function cetak_faktur()
    {
        $x['data'] = $this->m_penjualan->cetak_faktur();
        $this->load->view('laporan/v_faktur', $x);
        //$this->session->unset_userdata('nofak');
    }

    function cetak_faktur_dp()
    {
        $x['data'] = $this->m_penjualan->cetak_faktur_dp();
        $this->load->view('laporan/v_faktur_dp', $x);
        //$this->session->unset_userdata('nofak');
    }
}

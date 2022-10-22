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

    public function get_barang()
    {

        $kobar = $this->input->post('nabar');
        $x['brg'] = $this->m_barang->get_barang($kobar);
        $this->load->view('penjualan/detail_barang_jual', $x);
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
        $kobar = $this->input->post('kode_brg');

        $produk = $this->m_barang->get_barang1($kobar);
        $i = $produk->row_array();
        $data = array(
            'id'       => $i['barang_id'],
            'id_kat_barang' => $i['barang_kategori_id'],
            'name'     => $i['barang_nama'],
            'satuan'   => $i['barang_satuan'],
            'harpok'   => $i['barang_harpok'],
            'price'    => str_replace(",", "", $this->input->post('harjul')),
            'disc'     => $this->input->post('diskon'),
            'qty'      => $this->input->post('qty'),
            'amount'      => str_replace(",", "", $this->input->post('harjul'))
        );
        $this->cart->insert($data);
        redirect('penjualan');
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

    ///revisi baru 8/10/19

    function simpan_penjualan()
    {
        $nohp = $this->input->post('no_hp');
        $tampung = $this->db->query("select * from tbl_customer where no_hp='$nohp' ")->row_array();
        $payment1 = [
            'Lunas', 'Kredit', 'Debit', 'Transfer', 'OVO', 'LINK', 'DANA', 'Lain-Lain'
        ];
        //        if($this->input->post('bayar')=="Lunas" || $this->input->post('bayar')=="Kredit" || $this->input->post('bayar')=="Debit" || $this->input->post('bayar')=="Transfer" || $this->input->post('bayar')=="OVO" || $this->input->post('bayar')=="LINK" || $this->input->post('bayar')=="DANA")
        if (in_array($this->input->post('bayar'), $payment1)) {
            $bayar = $this->input->post('bayar', TRUE);
            $total_belanja = $this->input->post('total'); ////sama tambahin ini juga jar kalau di kameranya
            $total = $this->input->post('totbayar');
            $diskon = $this->input->post('diskon');
            $jml_uang = str_replace(",", "", $this->input->post('jml_uang'));
            $kembalian = $jml_uang - $total;
            if (!empty($total) && !empty($jml_uang) && !empty($nohp)) {
                if ($jml_uang < $total) {
                    echo $this->session->set_flashdata('error', 'Jumlah Uang yang anda masukan Kurang !!');
                    redirect('penjualan');
                } else {

                    $nofak = $this->m_penjualan->get_nofak();
                    $this->session->set_userdata('nofak', $nofak);

                    if ($tampung['no_hp'] != NULL) {
                        $order_proses = $this->m_penjualan->simpan_penjualan($nofak, $total, $jml_uang, $kembalian, $bayar, $diskon, $nohp);
                    } else {
                        $this->M_customer->tambah_data();
                        $order_proses = $this->m_penjualan->simpan_penjualan($nofak, $total, $jml_uang, $kembalian, $bayar, $diskon, $nohp);
                    }


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
                }
            } else {
                echo $this->session->set_flashdata('error', 'Penjualan Gagal di Simpan, Mohon Periksa Kembali Semua Inputan Anda!');
                redirect('penjualan');
            }
        } elseif ($this->input->post('bayar') == "Uang Muka") {
            $dp = $this->input->post('bayar');
            $total_belanja = $this->input->post('total');

            $total = $this->input->post('totbayar');
            $diskon = $this->input->post('diskon');
            $jml_uang = str_replace(",", "", $this->input->post('jml_uang'));
            $kekurangan = $total - $jml_uang;
            if (!empty($total) && !empty($jml_uang) && !empty($nohp)) {
                $nofak = $this->m_penjualan->get_nofak1();
                $this->session->set_userdata('nofak', $nofak);

                if ($tampung != NULL) {
                    $order_proses = $this->m_penjualan->simpan_penjualan1($nofak, $total, $jml_uang, $kekurangan, $diskon, $nohp, $dp);
                } else {
                    $this->M_customer->tambah_data();
                    $order_proses = $this->m_penjualan->simpan_penjualan1($nofak, $total, $jml_uang, $kekurangan, $diskon, $nohp, $dp);
                }

                if ($order_proses) {
                    $this->cart->destroy();

                    $this->session->unset_userdata('tglfak');
                    $this->session->unset_userdata('suplier');
                    echo $this->session->set_flashdata('muka', 'Berhasil !!');
                    redirect('penjualan');
                } else {
                    redirect('penjualan');
                }
            } else {
                echo $this->session->set_flashdata('error', 'Penjualan Gagal di Simpan, Mohon Periksa Kembali Semua Inputan Anda!');
                redirect('penjualan');
            }
        } else {



            echo $this->session->set_flashdata('error', 'Metode Bayar Tidak Boleh Kosong !');
            redirect('penjualan');
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

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class History_penjualan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('M_penjualan');
        $this->load->model('M_Cara_Bayar');
        if ($this->session->userdata('level') != TRUE) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data['title'] = "Data History Penjualan";
        $data_array = array();

        $data1 = $this->db->query("select A.*, B.nama AS namaplg from tbl_jual  A LEFT JOIN tbl_customer B ON B.no_hp = A.no_hp order by jual_tanggal desc")->result_array();

        foreach ($data1 as $dt) {
            $jmlh = $this->db->query("select count(d_jual_nofak) as jum from tbl_detail_jual where d_jual_nofak='$dt[jual_nofak]'")->row();
            $dt["jumlah_item"] = $jmlh->jum;
            array_push($data_array, $dt);
        }
        $data["data"] = $data_array;


        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('history_penjualan/index', $data);
        $this->load->view('template/footer', $data);
    }

    function in_detail($id)
    {
        $data['title'] = "Detail Penjualan";

        $data['cara_bayar'] = $this->M_Cara_Bayar->list();

        $jual = $this->db->query("select * from tbl_jual where jual_nofak='$id'")->row_array();
        $no_hp = $jual['no_hp'];
        $data['jual'] = $this->db->query("select * from tbl_jual where jual_nofak='$id'")->row_array();


        $data['customer'] = $this->db->query("select * from tbl_customer where no_hp='$no_hp'")->row_array();
        $data['dt_jual'] = $this->db->query("select * from tbl_detail_jual where d_jual_nofak='$id' order by d_jual_id desc")->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('history_penjualan/detail_penjualan', $data);
        $this->load->view('template/footer', $data);
    }

    function cetak_faktur($nofak)
    {
        $this->load->model('m_penjualan');
        $x['data'] = $this->m_penjualan->cetak_faktur2($nofak);
        $this->load->view('laporan/v_faktur', $x);
        //$this->session->unset_userdata('nofak');
    }

    function filter_history()
    {
        $search = $this->input->post('search');
        $data_array = array();

        $data1 = $this->db->query("select A.*, B.nama AS namaplg from tbl_jual  A LEFT JOIN tbl_customer B ON B.no_hp = A.no_hp where A.no_hp LIKE '%$search%' OR A.jual_nofak LIKE '%$search%' OR B.nama LIKE '%$search%'  order by jual_tanggal desc")->result_array();



        foreach ($data1 as $dt) {
            $jmlh = $this->db->query("select count(d_jual_nofak) as jum from tbl_detail_jual where d_jual_nofak='$dt[jual_nofak]'")->row();
            $dt["jumlah_item"] = $jmlh->jum;
            array_push($data_array, $dt);
        }
        $data = $data_array;
       
        ob_start();
?>
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama PLG</th>
                    <th>Tanggal</th>
                    <th>No HP</th>
                    <th>No Faktur</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php $no = 1;
                foreach ($data as $a) { ?>
                    <?php
                    $no_fak = $a['jual_nofak'];
                    if ($a['status'] == "COMPLETE") {
                        $status = '<div class="badge badge-success">Complete</div>';
                    } else if ($a['status'] == "DP") {
                        $status = '<div class="badge badge-warning">DP</div>';
                    } else {
                        $status = '<div class="badge badge-danger">Cancel</div>';
                    }
                    ?>

                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?php echo $a['namaplg']; ?></td>
                        <td><?php echo $a['jual_tanggal']; ?></td>
                        <td><?php echo $a['no_hp']; ?></td>
                        <td><?= $a['jual_nofak']; ?></td>
                        <td><?= $a['jumlah_item']; ?> items</td>
                        <td>Rp. <?= number_format($a['jual_total']); ?></td>
                        <td><?= $status ?></td>
                        <td class="text-center">
                            <a class="badge badge-success" href="<?= base_url(); ?>history_penjualan/in_detail/<?= $a['jual_nofak']; ?>">View</a>
                            <?php
                            if ($this->session->userdata("level") == "admin") {

                            ?>
                                <a class="badge badge-success" href="<?= base_url(); ?>history_penjualan/cetak_faktur/<?= $a['jual_nofak']; ?>" target="_blank">Cetak</a>
                                <a class="badge badge-success" href="<?= base_url(); ?>penjualan_edit/index/<?= $a['jual_nofak']; ?>">Edit</a>
                                <a class="badge badge-success" href="<?= base_url(); ?>history_penjualan/takdeletekowe/<?= $a['jual_nofak']; ?>">Delete</a>
                                <a class="badge badge-danger" href="<?= base_url(); ?>history_penjualan/batal/<?= $a['jual_nofak']; ?>">Batal</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
<?php
        $konten = ob_get_contents();
        return $konten;
    }

    function takdeletekowe()
    {
        $this->db->where('jual_nofak', $this->uri->segment(3));
        $this->db->delete('tbl_jual');
        redirect('history_penjualan');
    }
    function batal()
    {
        $data = [
            'status' => "CANCEL",
        ];
        $this->db->where('jual_nofak', $this->uri->segment(3));
        $this->db->update('tbl_jual', $data);
        redirect('history_penjualan');
    }
}

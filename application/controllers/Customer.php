<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('M_customer');
    }

    public function index()
    {
        $data['title'] = "Customer";
        $data['customer'] = $this->M_customer->tampilData();
        $data['kd_cus'] = $this->M_customer->getKodeCustomer();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('customer/index', $data);
        $this->load->view('template/footer', $data);
    }

    public function get_customer()
    {

        $noHp = $this->input->post('no_hp');
        $x['brg'] = $this->M_customer->get_customer($noHp);
        $x['kd_cus'] = $this->M_customer->getKodeCustomer();
        $this->load->view('customer/detail_customer', $x);
    }

    public function tambah_data()
    {

        $this->form_validation->set_rules('no_hp', 'No Hp/Telp', 'required|trim|min_length[11]|is_unique[tbl_customer.no_hp]', [
            'is_unique' => 'No Hp/Telp ini sudah terdaftar!'
        ]);
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'User';
            $data['customer'] = $this->M_customer->tampilData();
            $data['kd_cus'] = $this->M_customer->getKodeCustomer();

            $this->session->set_flashdata('msg2', 'Data gagal ditambahkan!');
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('customer/index', $data);
            $this->load->view('template/footer', $data);
        } else {
            $this->M_customer->tambah_data();
            $this->session->set_flashdata('msg', 'Data berhasil ditambahkan');
            redirect('customer');
        }
    }

    public function edit_customer()
    {
        $data = array(
            "kd_customer" => $this->input->post('kd_customer'),
            "nama" => $this->input->post('nama'),
            "no_hp" => $this->input->post('no_hp'),
            "alamat" => $this->input->post('alamat')
        );

        $this->db->where('id', $_POST['id']);
        $this->db->update('tbl_customer', $data);
        $this->session->set_flashdata('msg', 'Data berhasil diedit');
        redirect('customer');
    }

    public function hapus_customer()
    {
        $id = $this->input->post('id');
        $this->M_customer->hapus_customer($id);
        $this->session->set_flashdata('msg', 'Data berhasil dihapus');
        redirect('customer');
    }

    public function listCustomer()
    {
        $start = $this->input->post('tgl1');
        $end = $this->input->post('tgl2');
        // var_dump($start, $end);
        // die;
        $res = $this->M_customer->listCustomer($start, $end);
        echo json_encode($res);
    }
}

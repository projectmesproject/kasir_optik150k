<?php
class M_pengeluaran extends CI_Model
{
    private $table = "pengeluaran";
    function tampilData()
    {
        $this->db->select('a.*,b.nama as nama_karyawan');
        $this->db->from("pengeluaran a");
        $this->db->join("karyawan b", "a.penerima=b.id", "left");
        $data = $this->db->get()->result_array();
        return $data;
    }

    function getPengeluaran($start, $end)
    {
        return $this->db->query("SELECT SUM(nominal) as total_pengeluaran FROM pengeluaran WHERE tanggal BETWEEN '$start' AND '$end'")->row();
    }

    function tambahData()
    {
        $uang = $this->input->post('nominal', TRUE);

        $data = [
            "jenis_pengeluaran" => $this->input->post('jns_pengeluaran', TRUE),
            "nominal" => $this->input->post('nominal', TRUE),
            "tanggal" => date('Y-m-d'),
            "keterangan" => $this->input->post('keterangan', TRUE),
            "nama_karyawan" => $this->input->post('karyawan', TRUE),
            "updated_time" => date('Y-m-d H:i:s')
        ];

        $this->db->insert('pengeluaran', $data);
        $this->db->query("update saldo set saldo=saldo-'$uang' where id=1");
    }

    function editData()
    {
        $data = [
            "jenis_pengeluaran" => $this->input->post('jns_pengeluaran', TRUE),
            "nominal" => $this->input->post('nominal', TRUE),
            "tanggal" => $this->input->post('tanggal', TRUE),
            "keterangan" => $this->input->post('keterangan', TRUE),
            "nama_karyawan" => $this->input->post('karyawan', TRUE),
            "updated_time" => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $this->input->post('id', TRUE));
        $this->db->update('pengeluaran', $data);
    }

    function hapusData($id)
    {
        $this->db->delete('pengeluaran', ['id' => $id]);
    }
}

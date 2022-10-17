<?php
class M_pengeluaran extends CI_Model{

    function tampilData(){
        return $this->db->query("select a.id, a.jenis_pengeluaran, a.nominal, a.tanggal, a.keterangan, b.nama as nama_karyawan
                                        from pengeluaran a left join karyawan b on a.penerima=b.id order by a.id desc")->result_array();
    }

    function tambahData(){
        $uang = $this->input->post('nominal',TRUE);

        $data = [
            "jenis_pengeluaran" => $this->input->post('jns_pengeluaran',TRUE),
            "nominal" => $this->input->post('nominal',TRUE),
            "tanggal" => $this->input->post('tanggal',TRUE),
            "keterangan" => $this->input->post('keterangan',TRUE),
            "penerima" => $this->input->post('penerima',TRUE),
        ];

        $this->db->insert('pengeluaran',$data);
        $this->db->query("update saldo set saldo=saldo-'$uang' where id=1");
    }

    function editData(){
        $data = [
            "jenis_pengeluaran" => $this->input->post('jns_pengeluaran',TRUE),
            "nominal" => $this->input->post('nominal',TRUE),
            "tanggal" => $this->input->post('tanggal',TRUE),
            "keterangan" => $this->input->post('keterangan',TRUE),
            "penerima" => $this->input->post('penerima',TRUE),
        ];

        $this->db->where('id',$this->input->post('id',TRUE));
        $this->db->update('pengeluaran',$data);
    }

    function hapusData($id){
        $this->db->delete('pengeluaran',['id' => $id]);
    }

}
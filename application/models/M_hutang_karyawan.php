<?php
class M_hutang_karyawan extends CI_Model{
    
    function tampilData(){
        return $this->db->query("select a.id, a.nominal, a.jumlah_bayar,a.tanggal, a.keterangan, a.status, b.nama as nama_karyawan
                                    from hutang_karyawan a left join karyawan b on a.id_karyawan=b.id order by a.status='Lunas' ")->result_array();
    }

    function tambahData(){
        $data = [
            "id_karyawan" => $this->input->post('karyawan',TRUE),
            "nominal" => $this->input->post('nominal',TRUE),
            "jumlah_bayar" => 0,
            "keterangan" => $this->input->post('keterangan',TRUE),
            "status" => 'BelumLunas',
            "tanggal" => $this->input->post('tanggal',TRUE),
        ];

        $this->db->insert('hutang_karyawan',$data);
    }

    function editData(){
        $data = [
            "id_karyawan" => $this->input->post('karyawan'),
            "nominal" => $this->input->post('nominal'),
            "jumlah_bayar" => $this->input->post('jumlah_bayar'),
            "keterangan" => $this->input->post('keterangan'),
            "status" => $this->input->post('status')
        ];

        $this->db->where('id', $this->input->post('id',TRUE));
		$this->db->update('hutang_karyawan',$data);
    }

    function hapusData($id){
        $this->db->delete('hutang_karyawan',['id' => $id]);
    }

}
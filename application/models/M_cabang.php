<?php
class M_cabang extends CI_Model
{
    public function tampil_cabang()
    {
        return $this->db->get('tbl_cabang');
    }

    public function tambah_cabang()
    {
        $date_created = date('Y-m-d H:i:s');
        

        $data = array(
            "nama_cabang" => $this->input->post('cabang'),
            "alamat" => $this->input->post('alamat'),
            "date_created" => $date_created,
        );

        $this->db->insert('tbl_cabang', $data);
    }
  
    public function edit_cabang(){
        $date_created = date('Y-m-d H:i:s');
        $id = $this->input->post('id_cabang');
        $data = array(
            "nama_cabang" => $this->input->post('cabang'),
            "alamat" => $this->input->post('alamat'),
            "date_updated" => $date_created,
        );

        $this->db->where('id_cabang', $id);
        $this->db->update('tbl_cabang', $data);
    }

    
    public function hapus_cabang1($id)
    {
        $selCabang = $this->db->query("SELECT * FROM tbl_cabang WHERE id_cabang='$id'")->result();
        $dataCabang = $selCabang[0]->nama_cabang;
        $select = $this->db->query("SELECT * FROM tbl_jual WHERE cabang='$dataCabang'");
        $rows = $select->num_rows();
        $res = new stdClass();
        if($rows > 0){
            $res->status = 0;
        } else {
            
            $res->status = 1;
        }
        return $res->status;
    }
}

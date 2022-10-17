<?php
class M_user extends CI_Model{

    public function tampil_user()
    {
        return $this->db->get('user');
    }

    public function tambah_user()
    {
        $data= array(
            "username" => $this->input->post('username'),
            "password" => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            "level" => $this->input->post('level'),
            "status" => 1,
        );

        $this->db->insert('user',$data);
    }

    public function hapus_user($id)
    {
        $this->db->delete('user',['id' => $id]);
    }


}
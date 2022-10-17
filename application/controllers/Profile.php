<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller{

    function __construct(){
        parent::__construct();
        
        $this->load->model('M_user');
		
        if($this->session->userdata('level') != TRUE){
          redirect(base_url());
        }
    }

    function index(){
        $data['title']="Profile";

        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();
        
        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('template/topbar',$data);
        $this->load->view('profile/index',$data);
        $this->load->view('template/footer',$data);
    }

    function edit(){
        $data = [
            "user_nama" => $this->input->post('nama',TRUE)
        ];

        $this->db->where('user_id',$this->input->post('id',TRUE));
        $this->db->update('tbl_user',$data);

        $this->session->set_flashdata('msg','Data berhasil diedit');
        redirect('profile');
    }

    function change_password(){

        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $this->form_validation->set_rules('current_password','Current Password','required|trim');
        $this->form_validation->set_rules('new_password1',' New Password','required|trim|min_length[5]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2','Confirm New Password','required|trim|min_length[5]|matches[new_password1]');

        if($this->form_validation->run() == FALSE){
            $data['title']="Profile";

            $this->load->view('template/header',$data);
            $this->load->view('template/sidebar',$data);
            $this->load->view('template/topbar',$data);
            $this->load->view('profile/index',$data);
            $this->load->view('template/footer',$data);
        }
        else{
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');

            if(!password_verify($current_password,$data['user']['password'])){
                $this->session->set_flashdata('msg2','Data gagal ditambahkan! Password lama salah');
                redirect('profile/change_password');
            }
            else{
                if($current_password == $new_password){
                    $this->session->set_flashdata('msg2','Data gagal ditambahkan! Password lama tidak boleh sama dengan password baru');
                    redirect('profile/change_password');
                }
                else{
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password',$password_hash);
                    $this->db->where('username',$this->session->userdata('username'));
                    $this->db->update('user');

                    $this->session->set_flashdata('msg','Data berhasil diupdate');
                    redirect('profile');
                }
            }
        }
    }

}
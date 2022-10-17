<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller 
{

    function __construct(){
      parent::__construct();
      $this->load->model('m_user');
		
    }
    
    public function index()
    {
        $data['title']='User';
        $data['hak_akses'] = ['admin','kasir'];
        $data['is_active'] = ['1','0'];

        $data['data']=$this->m_user->tampil_user();
        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('template/topbar',$data);
        $this->load->view('user/index',$data);
        $this->load->view('template/footer',$data);
    }

    public function tambah_user()
    {

      $this->form_validation->set_rules('username','Username','required|trim|min_length[5]|is_unique[user.username]',[
        'is_unique' => 'This username has already registered!'
      ]);
      $this->form_validation->set_rules('password1','Password','required|trim|min_length[5]|matches[password2]',[
        'matches' => 'Password dont match!',
        'min_length' => 'Password to short!'
      ]);
      $this->form_validation->set_rules('password2','Password','required|trim|matches[password1]');

      if($this->form_validation->run() == FALSE){
          $data['title']='User';
          $data['data']=$this->m_user->tampil_user();
          
          $this->session->set_flashdata('msg2','Data gagal ditambahkan!');
          $this->load->view('template/header',$data);
          $this->load->view('template/sidebar',$data);
          $this->load->view('template/topbar',$data);
          $this->load->view('user/index',$data);
          $this->load->view('template/footer',$data);
      }
      else{
          $this->m_user->tambah_user();
          $this->session->set_flashdata('msg','Data berhasil ditambahkan');
          redirect('user');
      }

    }

    public function edit_user()
    {
      $data= array(
        "level" => $this->input->post('level',TRUE),
        "status" => $this->input->post('status',TRUE),
    );

    $this->db->where('id',$_POST['u_id']);
    $this->db->update('user',$data);
    $this->session->set_flashdata('msg','Data berhasil diedit');
    redirect('user');

    }


    public function hapus_user()
    {
      $id=$this->input->post('u_id');
      $this->m_user->hapus_user($id);
      $this->session->set_flashdata('msg','Data berhasil dihapus');
      redirect('user');

    }
}
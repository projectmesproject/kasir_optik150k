<?php
class Setting extends CI_Controller{

    function __construct(){
        parent::__construct();

    }

    function index(){
        $data['title']='Setting';

        $data['data'] = $this->db->get('tbl_setting')->result_array();

        $this->load->view('template/header',$data);
		$this->load->view('template/sidebar',$data);
		$this->load->view('template/topbar',$data);
		$this->load->view('setting/index',$data);
		$this->load->view('template/footer',$data);
    }

    function tambah_data(){
        $cek = $this->input->post('cek_gambar',TRUE);
        $id = $this->input->post('id',TRUE);

        if($cek==0){
            $data = [
                "fitur" => $this->input->post('nama',TRUE)
            ];
    
            $this->db->where('id',$this->input->post('id',TRUE));
            $this->db->update('tbl_setting',$data);
    
            $this->session->set_flashdata('msg','Data berhasil diedit');
            redirect('setting');
        }
        else{
            //  Cek jika ada gambar yang ingin di upload
            $upload_image = $_FILES['image']['name'];
            
            if($upload_image){
                $config['allowed_types'] = 'jpeg|jpg|png';
                $config['upload_path'] = './assets/logo/';

                $this->load->library('upload', $config);

                if($this->upload->do_upload('image')){
                    // Ngecek gambar lama
                    $old_image = $data['tbl_setting']['fitur'];
                    unlink(FCPATH .  'assets/logo/' . $old_image);

                    $new_image = $this->upload->data('file_name');
                    
                    $data_tampung = [
                        "fitur" => $new_image
                    ];

                    $this->db->where('id',$id);
                    $this->db->update('tbl_setting',$data_tampung);

                    $this->session->set_flashdata('msg','Data berhasil diedit');
                    redirect('setting');
                }
                else{
                    $this->session->set_flashdata('msg2','Gagal Diupdate, photo tidak sesuai ketentuan');
                    redirect('setting');
                }
            }
        }
  
    }

}
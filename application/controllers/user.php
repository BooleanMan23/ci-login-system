<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function __construct()
    {
      parent::__construct();
      is_logged_in();
      $this->load->model('user_model');   
      $this->load->library('form_validation');
    }

    public function index(){
        $data['user'] = $this->user_model->getDetailUser($this->session->userdata('user_email'));
        $data['title'] = "My Profile";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer', $data);
    }

    public function edit(){
      $data['user'] = $this->user_model->getDetailUser($this->session->userdata('user_email'));
      $data['title'] = "Edit Profile";
      $this->form_validation->set_rules('user_name', 'Full Name', 'required|trim');
      if($this->form_validation->run() == false){
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/edit', $data);
        $this->load->view('templates/footer', $data);
      }else {
        $name = $this->input->post('user_name');
        $email = $this->input->post('user_email'); 
        $upload_image = $_FILES['user_image']['name'];
        if($upload_image){
          $config['allowed_types'] = 'jpg|png';
          $config['max_size']      = 2048;
          $config['upload_path']   = './assets/img/profile/';
          $this->load->library('upload', $config);
          if($this->upload->do_upload('user_image')){
            $old_image = $data['user']['user_image'];
            if($old_image != 'default.png'){
               unlink(FCPATH . 'assets/img/profile/' .$old_image);
            }
            $new_image = $this->upload->data('file_name');
            $this->db->set('user_image', $new_image);
          }else{
            echo $this->upload->display_errors();
          }
        }
        $this->db->set('user_name', $name);
        $this->db->where('user_email', $email);
        $this->db->update('user');
    
       
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                        Your Profle has been updated!
                      </div>');
        redirect('user');
      }
      
    }


}


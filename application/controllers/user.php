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

    public function changepassword(){
      $data['user'] = $this->user_model->getDetailUser($this->session->userdata('user_email'));
        $data['title'] = "Change Password";
        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|trim|min_length[3]|matches[re_new_password]');
        $this->form_validation->set_rules('re_new_password', 'New Password', 'required|trim|min_length[3]|matches[new_password]');
        if($this->form_validation->run() == false){
          $this->load->view('templates/header', $data);
          $this->load->view('templates/sidebar', $data);
          $this->load->view('templates/topbar', $data);
          $this->load->view('user/changepassword', $data);
          $this->load->view('templates/footer', $data);
        }
        else{
          $current_password = $this->input->post('current_password');
          $new_password = $this->input->post('new_password');
          if(!password_verify($current_password, $data['user']['user_password'])){
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                                          Wrong current password!
                                          </div>');
            redirect('user/changepassword');
          }else{
            if($current_password == $new_password){
              $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                                          New password cannot be the same!
                                          </div>');
            redirect('user/changepassword');
            }else{
              $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
              $this->db->set('user_password', $password_hash);
              $this->db->where('user_email', $this->session->userdata('user_email'));
              $this->db->update('user');
              $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Password changed!
              </div>');
              redirect('user/changepassword');
            }
          }
        }
      
    }


}


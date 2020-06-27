<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

        public function __construct()
        {
          parent::__construct();
          $this->load->library('form_validation');
          $this->load->model('user_model');    
        }

	public function index()
	{       $data['title'] = "Login Page";
                $this->load->view('templates/auth_header', $data);
                $this->load->view('auth/login');
                $this->load->view('templates/auth_footer');
        }
        public function register()
        {
           
           $this->form_validation->set_rules('user_name', 'Name', 'required|trim');
           $this->form_validation->set_rules('user_email', 'Email', 'required|trim|valid_email|is_unique[user.user_email] ');
           $this->form_validation->set_rules('user_password1', 'Password', 'required|trim|min_length[3]|matches[user_password2]', ['matches' => 'Password dont match!', 'min_length'=>'Password too short!']);
           $this->form_validation->set_rules('user_password2', 'Password', 'required|trim|matches[user_password1]');

           if($this->form_validation->run() == false){
                        $data['title'] = "Register Page";
                        $this->load->view('templates/auth_header', $data);
                        $this->load->view('auth/register');
                        $this->load->view('templates/auth_footer');        
                               
           }else{
                        $data = [
                                'user_name' => $this->input->post('user_name'),
                                'user_email' => $this->input->post('user_email'),
                                'user_image' => 'default.jpg',
                                'user_password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                                'role_id'=> 2,
                                'user_active' =>1,
                                'date_created' => time()
                        ];
                        $this->user_model->create($data, 'user');
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                        Register Success!
                      </div>');
                        redirect('auth');
                }
              
        }
}

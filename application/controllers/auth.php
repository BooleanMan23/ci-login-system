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
        {      
                $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email');
                $this->form_validation->set_rules('user_password', 'Email', 'trim|required');
                if($this->form_validation->run() == false){
                        $data['title'] = "Login Page";
                        $this->load->view('templates/auth_header', $data);
                        $this->load->view('auth/login');
                        $this->load->view('templates/auth_footer');
                }else{
                   $this->_login();
                }
               
        }

        private function _login(){
           $user_email = $this->input->post('user_email');
           $user_password = $this->input->post('user_password');
           $user = $this->db->get_where('user', ['user_email' => $user_email])->row_array();
           if($user == null ){
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Email not registered!
                </div>');
                redirect('auth/index');
           }else if($user != null){
                if($user['user_active'] == 1){
                        if(password_verify($user_password, $user['user_password'])){
                        $data = [
                                'user_email' => $user['user_email'],
                                'role_id' => $user['role_id'],
                        ];
                        $this->session->set_userdata($data);
                        redirect('user');
                        }else {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                               Password incorrect!
                                </div>');
                                redirect('auth/index'); 
                        }
                }else{
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                        Email has not been activated!
                        </div>');
                        redirect('auth/index'); 
                }
           }
        }

        public function logout(){
                $this->session->unset_userdata('user_email');
                $this->session->unset_userdata('role_id');
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                        You have been logged out!
                        </div>');
                        redirect('auth/index'); 
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
                                'user_name' => htmlspecialchars($this->input->post('user_name', true)),
                                'user_email' => htmlspecialchars($this->input->post('user_email', true)),
                                'user_image' => 'default.jpg',
                                'user_password' => password_hash($this->input->post('user_password1'), PASSWORD_DEFAULT),
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

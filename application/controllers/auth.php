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
                if($this->session->userdata('user_email')){
                        redirect('user');
                } 
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
                        if($user['role_id'] == 1){
                                redirect('admin');
                        }else{
                                redirect('user');
                        }
                       
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
                if($this->session->userdata('user_email')){
                        redirect('user');
                } 
           $this->form_validation->set_rules('user_name', 'Name', 'required|trim');
           $this->form_validation->set_rules('user_email', 'Email', 'required|trim|valid_email|is_unique[user.user_email]',['is_unique' => 'Email has already taken!']);
           $this->form_validation->set_rules('user_password1', 'Password', 'required|trim|min_length[3]|matches[user_password2]', ['matches' => 'Password dont match!', 'min_length'=>'Password too short!']);
           $this->form_validation->set_rules('user_password2', 'Password', 'required|trim|matches[user_password1]');

           if($this->form_validation->run() == false){
                        $data['title'] = "Register Page";
                        $this->load->view('templates/auth_header', $data);
                        $this->load->view('auth/register');
                        $this->load->view('templates/auth_footer');        
                               
           }else{
                        $email = $this->input->post('user_email', true);
                        $data = [
                                'user_name' => htmlspecialchars($this->input->post('user_name', true)),
                                'user_email' => htmlspecialchars($email),
                                'user_image' => 'default.png',
                                'user_password' => password_hash($this->input->post('user_password1'), PASSWORD_DEFAULT),
                                'role_id'=> 2,
                                'user_active' =>0,
                                'date_created' => time()
                        ];
                        
                             // token
                        $token = base64_encode(random_bytes(32));
                        $user_token = [
                                'email' => $email,
                                'token' => $token,
                                'date_created' => time()
                         ];     
                        $this->user_model->create($data, 'user'); 
                        $this->db->insert('user_token', $user_token);
                        $this->_sendEmail($token, 'verify');
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                        Register Success! Activate Your account!
                      </div>');
                        redirect('auth');
                }
              
        }

        public function verify(){
                $email= $this->input->get('email');
                $token = $this->input->get('token');
                $user = $this->db->get_where('user', ['user_email' => $email])->row_array();
                if($user){
                        $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
                        if($user_token){
                                if(time()- $user_token['date_created'] < (60*60*24)){
                                        $this->db->set('user_active', 1);
                                        $this->db->where('user_email',$email);
                                        $this->db->update('user');
                                        $this->db->delete('user_token', ['email' => $email]);
                                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                                        email has been activated!
                                      </div>');
                                        redirect('auth');
                                }else{
                                        $this->db->delete('user', ['user_email' => $email]);
                                        $this->db->delete('user_token', ['email' => $email]);
                                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                                        Account Activation failed! Token Expired.
                                        </div>');
                                        redirect('auth/index'); 
                                }
                        }else{
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                                Account Activation failed! Wrong token.
                                </div>');
                                redirect('auth/index'); 
                        }
                }else{
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                        Account Activation failed! Wrong email.
                        </div>');
                        redirect('auth/index'); 
                }
        }

        private function _sendEmail($token, $type){
                $config = [
                        'protocol' => 'smtp',
                        'smtp_host' => 'ssl://smtp.googlemail.com',
                        'smtp_user' => 'testingaditnegara@gmail.com
                        ',
                        'smtp_pass' => 'adit1514215',
                        'smtp_port' => 465, 
                        'mailtype' => 'html',
                        'charset' => 'utf-8',
                        'newline' => "\r\n"
                ];

           

                $this->load->library('email', $config);
                $this->email->initialize($config);
                $this->email->from('aditnegara51@gmail.com', 'Aditya Negara');
                $this->email->to($this->input->post('user_email') );
                if($type == 'verify'){
                        $this->email->subject('Account Verification');
                        $this->email->message('Click this link to verify your account : <a href="'.base_url().'auth/verify?email=' . $this->input->post('user_email') . '&token=' .urlencode($token) .'">Activate</a>');
                }else if($type == 'forgot'){
                        $this->email->subject('Reset Password');
                        $this->email->message('Click this link to reset your password : <a href="'.base_url().'auth/resetpassword?email=' . $this->input->post('user_email') . '&token=' .urlencode($token) .'">Reset Password</a>');
                         
                }
              
                if($this->email->send()){
                        return true;
                }else {
                        echo $this->email->print_debugger();
                        die;
                }
        }

        public function blocked(){
                $this->load->view('auth/blocked');
        }

        public function forgotPassword(){
                $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email');
                if($this->form_validation->run() == false){
                        $data['title'] = "Forgot Password";
                        $this->load->view('templates/auth_header', $data);
                        $this->load->view('auth/forgot-password');
                        $this->load->view('templates/auth_footer');
                }else{
                        $email = $this->input->post('user_email');
                        $user = $this->db->get_where('user', ['user_email' => $email, 'user_active' => 1])->row_array();
                        if($user){
                                $token = base64_encode(random_bytes(32));
                                $user_token = [
                                        'email' => $email,
                                        'token' => $token,
                                        'date_created' => time()
                                 ];     
                                 $this->db->insert('user_token', $user_token);
                                 $this->_sendEmail($token, 'forgot');
                                 $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                                 Please check your email to reset your password!.
                                 </div>');
                                 redirect('auth/forgotpassword'); 
                         }else{
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                                Email not registered or activated!.
                                </div>');
                                redirect('auth/forgotpassword'); 
                        }

                        }
                }

                public function resetpassword(){
                        $email = $this->input->get('email');
                        $token = $this->input->get('token');
                        $user = $this->db->get_where('user', ['user_email' => $email])->row_array();
                        if($user){
                                $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
                                if($user_token){
                                        $this->session->set_userdata('reset_email', $email);
                                        $this->changePassword();
                                }else{
                                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                                        Reset password failed! Wrong token.
                                        </div>');
                                        redirect('auth');  
                                }
                        }else{
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                                Reset password failed! Wrong email.
                                </div>');
                                redirect('auth'); 
                        }
                }

                public function changePassword(){
                        if(! $this->session->userdata('reset_email')){
                                redirect('auth'); 
                        }
                        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]|matches[re-password]');
                        $this->form_validation->set_rules('re-password', 'Password', 'trim|required|min_length[3]|matches[password]');
                        if($this->form_validation->run() == false){
                                $data['title'] = "Change Password";
                                $this->load->view('templates/auth_header', $data);
                                $this->load->view('auth/change-password');
                                $this->load->view('templates/auth_footer');
                        } else{
                                $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
                                $email = $this->session->userdata('reset_email');
                                $this->db->set('user_password', $password);
                                $this->db->where('user_email', $email);
                                $this->db->update('user');
                                $this->session->unset_userdata('reset_email');
                                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                                Password has been change!.
                                </div>');
                                redirect('auth'); 
                        }
                       
                }
     
        }


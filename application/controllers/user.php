<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function __construct()
    {
      parent::__construct();
      is_logged_in();
      $this->load->model('user_model');    
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


}


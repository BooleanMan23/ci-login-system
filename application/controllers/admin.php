<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
      parent::__construct();
      is_logged_in();
      $this->load->model('admin_model');    
      $this->load->model('menu_model');    
    }

    public function index(){
        $data['user'] = $this->admin_model->getUser($this->session->userdata('user_email'));
        $data['title'] = "Dashboard";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer', $data);
    }

    public function role(){
        $data['user'] = $this->admin_model->getUser($this->session->userdata('user_email'));
        $data['title'] = "Role";
        $data['role'] = $this->admin_model->getRole();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer', $data);
    }

    public function roleAccess($role_id){
        $data['user'] = $this->admin_model->getUser($this->session->userdata('user_email'));
        $data['title'] = "Role";
        $data['role'] = $this->admin_model->getDetailRole($role_id);
        $data['menu'] = $this->menu_model->read();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer', $data);
    }


}


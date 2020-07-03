<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

    public function __construct()
    {
      parent::__construct();
      is_logged_in();
      $this->load->model('menu_model');   
      $this->load->model('user_model');
    }

    public function index(){
        $data['user'] = $this->user_model->getDetailUser($this->session->userdata('user_email'));
        $data['title'] = "Menu Management";
        $data['menu'] = $this->menu_model->read();
        $this->form_validation->set_rules('menuName', 'Menu', 'required');
        if($this->form_validation->run() == false){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer', $data);
        }else{
            $menuData = $this->input->post('menuName');
            $this->menu_model->create($menuData);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New menu created!
            </div>');
            redirect('menu');
        }
          
        
       
    }

    public function submenu(){
        $this->load->model('menu_model');    
        $data['user'] = $this->user_model->getDetailUser($this->session->userdata('user_email'));
        $data['title'] = "Submenu Management";
        $data['menu']  = $this->menu_model->read();
        $data['submenu'] = $this->menu_model->readSubMenu();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'icon', 'required');

        if($this->form_validation->run() == false){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer', $data);
        } else{
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];

            $this->menu_model->createSubMenu($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New submenu created!
            </div>');
            redirect('menu');
        }
 
    }


}


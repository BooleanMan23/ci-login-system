<?php 

class Admin_model extends CI_Model {
    public function getUser($user_email)
    {
       return $this->db->get_where('user', ['user_email' => $user_email])->row_array();
    
    }

    public function getRole(){
        return $this->db->get('role')->result_array();
    }

    public function getDetailRole($role_id){
        return $this->db->get_where('role', ['role_id' => $role_id])->row_array();
    }
}


?>
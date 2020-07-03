<?php 

class User_model extends CI_Model {
    public function create($data, $tableName)
    {
        $this->db->insert($tableName, $data);
    }

    public function getDetailUser($userEmail){
        return $this->db->get_where('user', ['user_email' => $userEmail])->row_array();
    }
}


?>
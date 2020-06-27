<?php 

class User_model extends CI_Model {
    public function create($data, $tableName)
    {
        $this->db->insert($tableName, $data);
    }
}


?>
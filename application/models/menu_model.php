<?php 

class Menu_model extends CI_Model {
    public function read()
    {
        $menus = $this->db->get('user_menu')->result_array();
        return $menus;
    }

    public function create($data){
        $this->db->insert('user_menu', ['menu' => $data ]);
    }

    public function readSubMenu(){
        $query = "SELECT `user_sub_menu`.*, `user_menu`.`menu`
                  FROM `user_sub_menu` JOIN `user_menu`
                  ON `user_sub_menu` . `menu_id` = `user_menu` . `id`
        ";
        return $this->db->query($query)->result_array(); 
    }

    public function createSubMenu($data){
        $this->db->insert('user_sub_menu',$data );
    }
}


?>
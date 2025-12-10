<?php

class Authority_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = "authority";
        $this->primaryKey = "authority.id_auth";
        $this->fields = array(
            "user_group.group_name",
            "menu.menu_name",
            "authority.addable",
            "authority.updateable",
            "authority.deleteable",
            "authority.status",
            "authority.modified_user",            
            "authority.modified_date",            
            "authority.id_group",
            "authority.id_menu",
            "menu.url",
            "menu.parent",
            "menu.id_menu",
            "menu.icon"
            );
        $this->orderBy = array("user_group.group_name" => "ASC","menu.menu_name"=>"ASC");
        $this->relations = array("user_group" => "user_group.id_group = authority.id_group AND user_group.status = authority.status",
            "menu" => "menu.id_menu = authority.id_menu AND menu.status = authority.status");
        $this->joins = array("left","left","left");
        
    }
    public function getMenu($id_group){
        $kondisi = array("authority.id_group"=>$id_group,"authority.status"=>"1");
        $this->orderBy = array("menu.sort"=>"ASC");
        return $result = $this->model->get(__FUNCTION__, $kondisi);
    }
    
    public function getMenuList($id_group){
        $sql = "SELECT m.id_menu, m.parent, m.type, m.menu_name, a.id_auth, a.addable, a.updateable, a.deleteable  
                FROM menu m
                LEFT JOIN authority a on a.id_menu = m.id_menu and a.status=1 and a.id_group='".$id_group."'
                WHERE m.status = 1
                ORDER BY m.type, m.sort";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*public function get_user($param) {
        $select = $this->primaryKey;
        $this->defaultField != "" ? $select .= ", " . $this->defaultField : $select .= "";
        if (!empty($this->fields)) {
            foreach ($this->fields as $field) {
                $select .= ", " . $field;
            }
        }
        $this->db->select($select);
        if (!empty($this->relations)) {
            foreach ($this->relations as $key => $value) {
                $this->db->join($key, $value);
            }
        }
        $this->db->where("nama_user", $param);
        $this->db->or_where("email", $param);
        if (!empty($this->orderBy)) {
            foreach ($this->orderBy as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }
        $query = $this->db->get($this->table);
        return $query->result();
    }
    
    public function get_child($id){
        $this->db->select($this->primaryKey);
        $this->db->where("parent",$id);
        $query = $this->db->get($this->table);
        return $query->result();
    }*/
    
}

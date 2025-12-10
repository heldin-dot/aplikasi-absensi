<?php

class Menu_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = "menu";
        $this->primaryKey = "menu.id_menu";
        $this->fields = array(
            "menu.menu_name",
            "parent.menu_name AS parent_name",
            "menu.url",
            "menu.sort",
            "menu.status",
            "menu.type",
            "menu.icon",
            "menu.modified_date",
            "menu.parent"
            );
        $this->orderBy = array("menu.menu_name" => "ASC");
        $this->relations = array("menu AS parent" => "parent.id_menu = menu.parent");
        $this->joins = array("left");
        
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

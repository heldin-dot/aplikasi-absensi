<?php

class User_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = "user";
        $this->primaryKey = "user.id_user";
        $this->fields = array(            
            "user.name",
            "user.username",
            "user_group.group_name",
            "user.status",
            "user.modified_date",
            "user.password",
            "user.id_group",
            "user.id_branch",
            "user.tipeuser",
            "user.photo",
            "user.menu",
            "branch.nama AS nama_branch"
            );
        $this->orderBy = array("user.username" => "ASC");
        $this->relations = array(
		"user_group"=>"user_group.id_group=user.id_group",
		"branch AS branch" => "branch.id_branch = user.id_branch"
		);
        //    "menu"=>"menu.id_menu=authority.id_menu");
        $this->joins = array(
		"left",
		"left"
		);
    }

    public function get_user($param) {
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
        //$this->db->where("username", $param);
        if(!empty($param)){
            foreach ($param as $key=>$value){
                $this->db->where($key, $value);
            }
        }
        if (!empty($this->orderBy)) {
            foreach ($this->orderBy as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }
        $query = $this->db->get($this->table);
        return $query->result();
    }
    
//    public function get_child($id){
//        $this->db->select($this->primaryKey);
//        $this->db->where("parent",$id);
//        $query = $this->db->get($this->table);
//        return $query->result();
//    }
    
}

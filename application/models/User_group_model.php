<?php

class User_group_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = "user_group";
        $this->primaryKey = "user_group.id_group";
        $this->fields = array(
            "user_group.group_name",
            "user_group.status",
            "user_group.modified_date"
            );
        $this->orderBy = array("user_group.group_name" => "ASC");
//        $this->relations = array("user_group AS parent" => "parent.id_user_group = user_group.parent");
//        $this->joins = array("left");
        
    }
    
}

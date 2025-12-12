<?php

class Branch_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = "branch";
        $this->primaryKey = "branch.id_branch";
        $this->fields = array(
            "branch.nama",
            "branch.timezone",
            "branch.ket",
            "branch.modified_date",
            "branch.modified_user",
            );
        $this->orderBy = array("branch.nama" => "ASC");
//        $this->relations = array("user AS user" => "user.id_user = branch.id_user");
//        $this->joins = array("left");
        
    }
    
}

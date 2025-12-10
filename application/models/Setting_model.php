<?php

class Setting_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = "setting";
        $this->primaryKey = "setting.id_setting";
        $this->fields = array(
            "setting.kode",
            "setting.name",
            "setting.modified_user",
            "setting.modified_date",
            );
        $this->orderBy = array("setting.setting_name" => "ASC");
        $this->relations = array("user AS user" => "user.id_user = setting.id_user");
        $this->joins = array("left");
        
    }

    
    public function getSetting($id){
        $sql = 'SELECT * FROM setting WHERE kode="' . $id .'"';
        $query = $this->db->query($sql);
        $result =$query->row();
        return $result;
//        return $query->result();
    }
    
}

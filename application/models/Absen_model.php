<?php

class Absen_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = "absen";
        $this->primaryKey = "absen.id_absen";
        $this->fields = array(
            "absen.id_user",
            "absen.in_date",
            "absen.in_long",
            "absen.in_lat",
            "absen.in_capture",
            "absen.out_date",
            "absen.out_long",
            "absen.out_lat",
            "absen.out_capture",
            "absen.status",
            "absen.id_branch",
            "user.name AS nama_user"
            );
        $this->orderBy = array("absen.absen_name" => "ASC");
        $this->relations = array("user AS user" => "user.id_user = absen.id_user");
        $this->joins = array("left");
        
    }

    
    public function getAbsen($id){
        $sql = 'SELECT * FROM absen WHERE SUBSTR(in_date,1,10)="'. Date("Y-m-d"). '" AND id_user="' . $id .'"';
        $query = $this->db->query($sql);
        $result =$query->row();
        return $result;
//        return $query->result();
    }
    
}

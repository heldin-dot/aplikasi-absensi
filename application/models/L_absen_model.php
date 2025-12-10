<?php

class L_absen_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = "absen";
        $this->primaryKey = "absen.id_absen";
        $this->fields = array(
            "absen.id_user",
            "branch.nama AS nama_branch",
            "absen.in_date",
            "CONCAT(absen.in_lat,',',absen.in_long) AS latin",
            "absen.in_long",
            "absen.in_lat",
            "absen.in_capture",
            "absen.out_date",
            "CONCAT(absen.out_lat,',',absen.out_long) AS latout",
            "absen.out_long",
            "absen.out_lat",
            "absen.out_capture",
            "absen.id_branch",
            "absen.status",
            "user.name AS nama_user"
            );
        $this->orderBy = array("user.name" => "ASC");
        $this->relations = array(
            "user AS user" => "user.id_user = absen.id_user",
            "branch AS branch" => "branch.id_branch = absen.id_branch"
            );
        $this->joins = array(
            "left",
            "left"
            );
        
        $filter = array('absen.id_absen<>' => '');
        if($this->input->get("tanggal_awal")!=''){
            $tanggal = array('SUBSTR(absen.in_date,1,10)>=' => $this->input->get("tanggal_awal"), 'SUBSTR(absen.in_date,1,10)<=' => $this->input->get("tanggal_akhir"));
            $filter = array_merge($filter, $tanggal);
        }
        if($this->input->get("user")!=''){
            $user = array('absen.id_user=' => $this->input->get("user"));
            $filter = array_merge($filter, $user);
        }
        if($this->input->get("branch")!=''){
            $branc = array('absen.id_branch=' => $this->input->get("branch"));
            $filter = array_merge($filter, $branc);
        }
        $this->where = $filter;
        
    }
    
}

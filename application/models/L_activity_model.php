<?php

class L_activity_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = "activity";
        $this->primaryKey = "activity.id_activity";
        $this->fields = array(
            "activity.id_user",
            "activity.tanggal",
            "activity.judul",
            "activity.isi",
            "activity.keluar",
            "activity.kembali",
            "activity.modified_date",
            "activity.modified_user",
            "activity.id_branch",
            "user.name AS nama_user",
            "branch.nama AS nama_branch"
            );
        $this->orderBy = array("activity.tanggal" => "ASC");
        $this->relations = array(
            "user AS user" => "user.id_user = activity.id_user",
            "branch AS branch" => "branch.id_branch = activity.id_branch"
            );
        $this->joins = array(
            "left",
            "left"
            );
        
        $filter = array('activity.id_activity<>' => '');
        if($this->input->get("tanggal_awal")!=''){
            $tanggal = array('activity.tanggal >=' => $this->input->get("tanggal_awal"), 'activity.tanggal <=' => $this->input->get("tanggal_akhir"));
            $filter = array_merge($filter, $tanggal);
        }
        if($this->input->get("user")!=''){
            $user = array('activity.id_user=' => $this->input->get("user"));
            $filter = array_merge($filter, $user);
        }
        if($this->input->get("branch")!=''){
            $branc = array('activity.id_branch=' => $this->input->get("branch"));
            $filter = array_merge($filter, $branc);
        }
        $this->where = $filter;
        
    }
    
}

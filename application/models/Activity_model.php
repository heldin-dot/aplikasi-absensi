<?php

class Activity_model extends MY_Model {

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
        
    }

    
    public function getActivityToday($id){
        $sql = 'SELECT * FROM activity WHERE id_user ="'. $id .'" ORDER BY tanggal ASC';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
}

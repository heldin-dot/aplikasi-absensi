<?php

class Sakit_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = "sakit";
        $this->primaryKey = "sakit.id_sakit";
        $this->fields = array(
            "sakit.id_user",
            "sakit.diagnosa",
            "sakit.foto",
            "sakit.tgl_mulai",
            "sakit.tgl_akhir",
            "sakit.modified_date",
            "sakit.modified_user",
            "sakit.id_branch",
            "user.name AS nama_user",
            "branch.nama AS nama_branch"
            );
        $this->orderBy = array("sakit.tgl_akhir" => "DESC");
        $this->relations = array(
            "user AS user" => "user.id_user = sakit.id_user",
            "branch AS branch" => "branch.id_branch = sakit.id_branch"
            );
        $this->joins = array(
            "left",
            "left"
            );
        
    }
    
}

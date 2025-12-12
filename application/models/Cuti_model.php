<?php

class Cuti_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = "cuti";
        $this->primaryKey = "cuti.id_cuti";
        $this->fields = array(
            "cuti.status",
            "cuti.id_user",
            "cuti.tujuan",
            "cuti.tgl_mulai AS tgl_mulai",
            "cuti.tgl_akhir AS tgl_akhir",
            "cuti.modified_date AS modified_date",
            "cuti.foto",
            "cuti.atasan1",
            "cuti.telp1",
            "cuti.atasan2",
            "cuti.telp2",
            "cuti.darurat",
            "cuti.handle",
            "cuti.modified_user",
            "cuti.id_branch",
            "user.name AS nama_user",
            "branch.nama AS nama_branch"
            );
        $this->orderBy = array("cuti.status" => "ASC", "cuti.modified_date" => "DESC", "cuti.tgl_akhir" => "DESC");
        $this->relations = array("user AS user" => "user.id_user = cuti.id_user");
        $this->joins = array("left");
        $this->relations = array(
            "user AS user" => "user.id_user = cuti.id_user",
            "branch AS branch" => "branch.id_branch = cuti.id_branch"
            );
        $this->joins = array(
            "left",
            "left"
            );
        
    }
    
}

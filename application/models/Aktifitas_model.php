<?php

class Aktifitas_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = "aktifitas";
        $this->primaryKey = "aktifitas.id_aktifitas";
        $this->fields = array(
            "aktifitas.id_user",
            "aktifitas.tanggal AS tanggal",
            "aktifitas.id_branch",
            "aktifitas.tipe",
            "aktifitas.survey",
            "aktifitas.unit",
            "aktifitas.ket",
            "aktifitas.nopol",
            "aktifitas.modified_date AS modified_date",
            "aktifitas.modified_user",
            "user.name AS nama_user",
            "branch.nama AS nama_branch"
            );
        $this->orderBy = array("aktifitas.modified_date" => "DESC", "aktifitas.tanggal" => "DESC");
        $this->relations = array(
            "user AS user" => "user.id_user = aktifitas.id_user",
            "branch AS branch" => "branch.id_branch = aktifitas.id_branch"
            );
        $this->joins = array("left","left");
        
    }
    
}

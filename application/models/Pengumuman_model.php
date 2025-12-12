<?php

class Pengumuman_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = "pengumuman";
        $this->primaryKey = "pengumuman.id_pengumuman";
        $this->fields = array(
            "pengumuman.judul",
            "pengumuman.isi",
            "pengumuman.modified_date AS modified_date",
            "pengumuman.status",
            "pengumuman.modified_user",
            "user.name AS nama_user"
            );
        $this->orderBy = array("pengumuman.modified_date" => "DESC");
        $this->relations = array("user AS user" => "user.id_user = pengumuman.modified_user");
        $this->joins = array("left");
        
    }
    
}

<?php

class L_aktifitas_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = "aktifitas";
        $this->primaryKey = "aktifitas.id_aktifitas";
        $this->fields = array(
            "aktifitas.id_user",
            "aktifitas.tanggal",
            "aktifitas.id_branch",
            "aktifitas.tipe",
            "aktifitas.survey",
            "aktifitas.unit",
            "aktifitas.ket",
            "aktifitas.nopol",
            "aktifitas.modified_date",
            "aktifitas.modified_user",
            "user.name AS nama_user",
            "branch.nama AS nama_branch"
            );
        $this->orderBy = array("aktifitas.tanggal" => "ASC");
        $this->relations = array(
            "user AS user" => "user.id_user = aktifitas.id_user",
            "branch AS branch" => "branch.id_branch = aktifitas.id_branch"
            );
        $this->joins = array("left","left");
        
        $filter = array('aktifitas.id_aktifitas<>' => '');
        if($this->input->get("tanggal_awal")!=''){
            $tanggal = array('aktifitas.tanggal >=' => $this->input->get("tanggal_awal"), 'aktifitas.tanggal <=' => $this->input->get("tanggal_akhir"));
            $filter = array_merge($filter, $tanggal);
        }
        if($this->input->get("user")!=''){
            $user = array('aktifitas.id_user=' => $this->input->get("user"));
            $filter = array_merge($filter, $user);
        }
        if($this->input->get("branch")!=''){
            $branc = array('aktifitas.id_branch=' => $this->input->get("branch"));
            $filter = array_merge($filter, $branc);
        }
        $this->where = $filter;
    }
    
}

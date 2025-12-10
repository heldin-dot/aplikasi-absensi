<?php

class L_sakit_model extends MY_Model {

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
        
        $filter = array('sakit.id_sakit<>' => '');
        if($this->input->get("tanggal_awal")!=''){
            $tanggal = array(
                'sakit.tgl_mulai >=' => $this->input->get("tanggal_awal"), 
                'sakit.tgl_mulai <=' => $this->input->get("tanggal_akhir"),
            );
            $filter = array_merge($filter, $tanggal);
        }
        if($this->input->get("user")!=''){
            $user = array('sakit.id_user=' => $this->input->get("user"));
            $filter = array_merge($filter, $user);
        }
        if($this->input->get("branch")!=''){
            $branc = array('sakit.id_branch=' => $this->input->get("branch"));
            $filter = array_merge($filter, $branc);
        }
        $this->where = $filter;
        
    }
    
}

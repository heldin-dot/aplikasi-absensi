<?php

class L_cuti_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = "cuti";
        $this->primaryKey = "cuti.id_cuti";
        $this->fields = array(
            "cuti.id_user",
            "cuti.tujuan",
            "cuti.foto",
            "cuti.tgl_mulai",
            "cuti.tgl_akhir",
            "cuti.atasan1",
            "cuti.telp1",
            "cuti.atasan2",
            "cuti.telp2",
            "cuti.darurat",
            "cuti.handle",
            "cuti.status",
            "cuti.modified_date",
            "cuti.modified_user",
            "cuti.id_branch",
            "user.name AS nama_user",
            "branch.nama AS nama_branch"
            );
        $this->orderBy = array("cuti.status" => "ASC");
        $this->relations = array(
            "user AS user" => "user.id_user = cuti.id_user",
            "branch AS branch" => "branch.id_branch = user.id_branch"
            );
        $this->joins = array(
            "left",
            "left"
            );
        
        $filter = array('cuti.id_cuti<>' => '');
        if($this->input->get("tanggal_awal")!=''){
            $tanggal = array('cuti.tgl_mulai >=' => $this->input->get("tanggal_awal"), 'cuti.tgl_mulai <=' => $this->input->get("tanggal_akhir"));
            $filter = array_merge($filter, $tanggal);
        }
        if($this->input->get("user")!=''){
            $user = array('cuti.id_user=' => $this->input->get("user"));
            $filter = array_merge($filter, $user);
        }
        if($this->input->get("branch")!=''){
            $branc = array('cuti.id_branch=' => $this->input->get("branch"));
            $filter = array_merge($filter, $branc);
        }
        if($this->input->get("status")!=''){
            $status = array('cuti.status=' => $this->input->get("status"));
            $filter = array_merge($filter, $status);
        }
        $this->where = $filter;
        
    }
    
}

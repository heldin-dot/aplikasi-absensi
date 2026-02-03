<?php

class Absen_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = "absen";
        $this->primaryKey = "absen.id_absen";
        $this->fields = array(
            "absen.id_user",
            "absen.in_date",
            "absen.in_long",
            "absen.in_lat",
            "absen.in_capture",
            "absen.out_date",
            "absen.out_long",
            "absen.out_lat",
            "absen.out_capture",
            "absen.status",
            "absen.id_branch",
            "user.name AS nama_user"
            );
        $this->orderBy = array("absen.absen_name" => "ASC");
        $this->relations = array("user AS user" => "user.id_user = absen.id_user");
        $this->joins = array("left");
        
    }

    
    public function getAbsen($id){
        // Ambil timezone dari branch user untuk consistency
        $user = $this->db->select('id_branch')->from('user')->where('id_user', $id)->get()->row();
        
        $timezone = 'Asia/Jakarta'; // default
        if ($user && $user->id_branch) {
            $branch = $this->db->select('timezone')->from('branch')->where('id_branch', $user->id_branch)->get()->row();
            if ($branch && !empty($branch->timezone)) {
                $timezone = $branch->timezone;
            }
        }
        
        // Validate timezone
        if (!in_array($timezone, timezone_identifiers_list())) {
            $timezone = 'Asia/Jakarta';
        }
        
        date_default_timezone_set($timezone);
        
        $today = date("Y-m-d");
        // Use parameterized query to prevent SQL injection
        $sql = 'SELECT * FROM absen WHERE DATE(in_date)=? AND id_user=? ORDER BY in_date DESC LIMIT 1';
        $query = $this->db->query($sql, array($today, $id));
        $result = $query->row();
        return $result;
    }
    
}

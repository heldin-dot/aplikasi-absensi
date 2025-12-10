<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Front extends CI_Controller {
 
    function __construct() {
        parent::__construct();
    }

    public function index() {
        if ($this->session->userdata('website_admin_logged_in')) {
            redirect('home');
        } else {
            $data = array(
                'title' => 'AA Admin',
                'base_url' => base_url()
            );
            $this->parser->parse('front/index_view', $data);
        }
    }
    
    public function menu($view) {
        if($view == '' || $view == 'dashboard' || $view == 'home'){
            $view = 'front/dashboard_view';
//        }else if($view == 'profile'){
//            $view = 'profile_view';
        }else{
            $view = str_replace(':', "/", $view);
        }
        
        $data = array(
            'base_url' => base_url(),
            'user_id' => $this->session->userdata('sess_user_id'),
            'user_group' => $this->session->userdata('user_group'),
            'user_nama' => $this->session->userdata('sess_nama'),
            'user_approve' => $this->session->userdata('sess_approve'),
            //'id_auth' => $id_auth,
            //'addable' => $addable,
            'url' => $view,
            'user_photo' => $this->session->userdata('sess_photo')
        );
        
        $this->parser->parse($view, $data);
        
    }
    
    public function getByCalon() {
        $this->load->model('vote_model');
    	$data=$this->vote_model->getByCalon();
        
        $this->load->model('vote_model');
    	$jPemilih=$this->vote_model->getJPemilih();
        
        $this->load->model('vote_model');
    	$jTPS=$this->vote_model->getJTPS();
        
        $result = array("data"=>$data, "jPemilih"=>$jPemilih, "jTPS"=>$jTPS);
	echo json_encode($result,JSON_NUMERIC_CHECK);
    }
    
    public function getTPS() {
        $this->load->model('vote_model');
    	$dataTPS=$this->vote_model->getTPS();
        
        $this->load->model('vote_model');
    	$dataTPSDetail=$this->vote_model->getTPSDetail();
        
//        $hasil= array();
//        $dat2= array();
//        $dat= array();
//        $tps='';
//        $i=0;
//        foreach($dataTPSDetail as $data ){
//            if($tps==''){
//                array_push($hasil, array("name"=>$data['nama_tps']));
//            }elseif($tps!=$data['nama_tps']){
//                array_merge_recursive($hasil, array($dat));
//                array_push($hasil, array("name"=>$data['nama_tps']));
//            }  else {
//                array_push($dat, $data['jumlah']);
//            }
//            $tps=$data['nama_tps'];
////            
//        }
        
        $result = array("dataTPS"=>$dataTPS, "detail"=>$dataTPSDetail);
//        $result = $hasil;
	echo json_encode($result,JSON_NUMERIC_CHECK);
    }
    
    public function getChat() {
        $this->load->model('vote_model');
    	$data=$this->vote_model->getChat();
        
        $result = array("data"=>$data);
//        $result = $hasil;
	echo json_encode($result,JSON_NUMERIC_CHECK);
    }

}

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $data = array(
            'base_url' => base_url()
        );
        $this->parser->parse('dashboard_view', $data);
    }
    
    public function getActivityToday($id) {
        $this->load->model('Activity_model');
    	$data=$this->Activity_model->getActivityToday($id);
	echo json_encode($data,JSON_NUMERIC_CHECK);
    }
}

<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
class User_group extends MY_Controller {

    function __construct() {
        parent::__construct();
        
        //$this->kode_transaksi = "USER";

        $mdl = "user_group_model";
        $this->model_name = $mdl;
        $this->load->model($mdl);
        $this->model = $this->$mdl;
        $this->table = "user_group";
        $this->pkField = "id_group";
        $this->uniqueFields = array("group_name");

        //pair key value (field => TYPE)
        //TYPE: EMAIL/STRING/INT/FLOAT/BOOLEAN/DATE/PASSWORD/URL/IP/MAC/RAW/DATA
        $this->fields = array(
            "action" => array("TIPE" => "TRANSACTION", "LABEL" => "Action"),
            "group_name" => array("TIPE" => "STRING", "LABEL" => "Nama"),         
            "status" => array("TIPE" => "STATUS", "LABEL" => "Status"),
            "modified_date" => array("TIPE" => "DATE", "LABEL" => "Modified Date"),
        );
        //$this->kondisi = array("username"=>$this->input->post("username"),
        //    "password"=>md5($this->input->post("password")));
        
        //$this->model->fieldsView = $this->fields;
    }
    
    public function index() {
        //print_r($this->session->userdata('sess_user_id'));
        
        if (!$this->session->userdata('logged_in')) {
            redirect('Login');
        }
//        else {
//            $data = array(
//                'title' => 'Login Admin',
//                'base_url' => base_url()
//            );
//            $this->parser->parse('login_view', $data);
//        }
    }
    
    public function dataInput() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('group_name', 'Group Name', 'trim|required|min_length[3]|max_length[255]');
        //$this->form_validation->set_rules('status', 'Status', 'required');
        

        if ($this->form_validation->run() == FALSE) {
            return array("valid" => FALSE, "error" => validation_errors());
        } else {
            $data = array();
            foreach ($this->input->post() as $key => $value) {
                if ($key == "method") {
                    
                } elseif ($key == $this->pkField) {
                    $data[$key] = !$value ? $this->uuid->v4() : $value;
                    $this->kode = $data[$key];
                } elseif ($key == 'modified_date') {
                    $data[$key] = date('Y-m-d');
                } elseif ($key == 'password'){
                    $data[$key] = md5($value);
                } else {
                    if (isset($value)) {
                        $data[$key] = $value;
                    }
                }
            }

            return array("valid" => TRUE, "data" => $data);
        }
    }
    
    public function event() {
        $event = $this->model->event();
        foreach ($event as $value) {
            echo $value->id_event;
        }
    }

}

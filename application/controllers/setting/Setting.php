<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
class Setting extends MY_Controller {

    function __construct() {
        parent::__construct();
        
        //$this->kode_transaksi = "USER";

        $mdl = "Setting_model";
        $this->model_name = $mdl;
        $this->load->model($mdl);
        $this->model = $this->$mdl;
        $this->table = "setting";
        $this->pkField = "id_setting";
        $this->uniqueFields = array("id_setting");

        //pair key value (field => TYPE)
        //TYPE: EMAIL/STRING/INT/FLOAT/BOOLEAN/DATE/PASSWORD/URL/IP/MAC/RAW/DATA
        $this->fields = array(
            "nama_user" => array("TIPE" => "STRING", "LABEL" => "Menu Name"),
//            "parent_name" => array("TIPE" => "STRING", "LABEL" => "Parent Menu"),
//            "url" => array("TIPE" => "STRING", "LABEL" => "URL"),
//            "sort" => array("TIPE" => "INT", "LABEL" => "Sort"),
//            "status" => array("TIPE" => "STATUS", "LABEL" => "Status"),
//            "type" => array("TIPE" => "INT", "LABEL" => "Type"),
//            "icon" => array("TIPE" => "ICON", "LABEL" => "Icon"),
//            "modified_date" => array("TIPE" => "DATE", "LABEL" => "Modified Date"),
//            "action" => array("TIPE" => "TRANSACTION", "LABEL" => "Action")
           
//            "foto" => array("TIPE" => "IMAGE", "LABEL" => "Foto", "LOKASI" => "files/image/user/"),
//            "parent" => array("TIPE" => "STRING", "LABEL" => "Parent", "CUSTOM" => FALSE),
//            "hak_akses" => array("TIPE" => "STRING", "LABEL" => "Hak Akses", "CUSTOM" => TRUE)
        );
        
        //$this->model->fieldsView = $this->fields;
    }
    
    public function index() {
        $data = array(
            'base_url' => base_url(),
            'user_id' => $this->session->userdata('sess_user_id'),
//            'user_email' => $this->session->userdata('sess_email'),
            'user_nama' => $this->session->userdata('sess_nama'),
//            'user_hak_akses' => $this->session->userdata('sess_hak_akses')
        );
        $this->parser->parse("setting/menu_view", $data);        
    }
    
    public function dataInput() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('id_user', 'User', 'trim|required|min_length[3]|max_length[255]');
//        $this->form_validation->set_rules('type', 'Menu Type', 'required');
//        $this->form_validation->set_rules('url', 'URL', 'trim|required|min_length[1]|max_length[255]');
//        $this->form_validation->set_rules('status', 'Status', 'required');
        

        if ($this->form_validation->run() == FALSE) {
            return array("valid" => FALSE, "error" => validation_errors());
        } else {
            $data = array();
            foreach ($this->input->post() as $key => $value) {
                if ($key == "method") {
                    
                } elseif ($key == $this->pkField) {
                    $data[$key] = !$value ? $this->uuid->v4() : $value;
                } elseif ($key == 'in_date') {
                    $data[$key] = date('Y-m-d H:i:s');
                } elseif ($key == 'out_date') {
                    $data[$key] = date('Y-m-d H:i:s');
                } else {
                    if (isset($value)) {
                        $data[$key] = $value;
                    }
                }
            }

            return array("valid" => TRUE, "data" => $data);
        }
    }
    
    public function getSetting($id) {
    	$data=$this->Setting_model->getSetting($id);
	echo json_encode($data,JSON_NUMERIC_CHECK);
//        $event = $this->model->getAbsen($id);
//        
//        return $event;
    }

}

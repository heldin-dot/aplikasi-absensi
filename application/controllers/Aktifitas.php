<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
class Aktifitas extends MY_Controller {

    function __construct() {
        parent::__construct();
        
        //$this->kode_transaksi = "USER";

        $mdl = "Aktifitas_model";
        $this->model_name = $mdl;
        $this->load->model($mdl);
        $this->model = $this->$mdl;
        $this->table = "aktifitas";
        $this->pkField = "id_aktifitas";
        $this->uniqueFields = array("id_aktifitas");

        //pair key value (field => TYPE)
        //TYPE: EMAIL/STRING/INT/FLOAT/BOOLEAN/DATE/PASSWORD/URL/IP/MAC/RAW/DATA
        $this->fields = array(
            "nama_user" => array("TIPE" => "STRING", "LABEL" => "Menu Name"),
            "tanggal" => array("TIPE" => "DATE", "LABEL" => "URL"),
            "nama_branch" => array("TIPE" => "STRING", "LABEL" => "Sort"),
            "tipe" => array("TIPE" => "STRING", "LABEL" => "URL"),
            "survey" => array("TIPE" => "STRING", "LABEL" => "URL"),
            "unit" => array("TIPE" => "STRING", "LABEL" => "URL"),
            "ket" => array("TIPE" => "STRING", "LABEL" => "URL"),
            "nopol" => array("TIPE" => "STRING", "LABEL" => "URL"),
            "modified_date" => array("TIPE" => "DATE", "LABEL" => "Status"),
            "action" => array("TIPE" => "TRANSACTION", "LABEL" => "Action")
           
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

        $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('id_branch', 'Kota', 'required');
        $this->form_validation->set_rules('tipe', 'Tipe Survey', 'required');
        $this->form_validation->set_rules('survey', 'Survey', 'required');
        $this->form_validation->set_rules('unit', 'Type Unit', 'required');
        $this->form_validation->set_rules('nopol', 'No Polisi', 'required');
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
                } elseif ($key == 'tanggal') {
//                    $data[$key] = date('Y-m-d');
                    $data[$key] = backend_date($value);
                } elseif ($key == 'modified_date') {
                    $data[$key] = date('Y-m-d');
                } else {
                    if (isset($value)) {
                        $data[$key] = $value;
                    }
                }
            }

            return array("valid" => TRUE, "data" => $data);
        }
    }

}

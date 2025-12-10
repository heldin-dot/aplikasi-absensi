<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
class Activity extends MY_Controller {

    function __construct() {
        parent::__construct();
        
        //$this->kode_transaksi = "USER";

        $mdl = "Activity_model";
        $this->model_name = $mdl;
        $this->load->model($mdl);
        $this->model = $this->$mdl;
        $this->table = "activity";
        $this->pkField = "id_activity";
        $this->uniqueFields = array("id_activity");

        //pair key value (field => TYPE)
        //TYPE: EMAIL/STRING/INT/FLOAT/BOOLEAN/DATE/PASSWORD/URL/IP/MAC/RAW/DATA
        $this->fields = array(
            "nama_user" => array("TIPE" => "STRING", "LABEL" => "Menu Name"),
            "tanggal" => array("TIPE" => "DATE", "LABEL" => "URL"),
            "judul" => array("TIPE" => "STRING", "LABEL" => "Sort"),
            "keluar" => array("TIPE" => "TIME", "LABEL" => "URL"),
            "kembali" => array("TIPE" => "TIME", "LABEL" => "URL"),
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

        $this->form_validation->set_rules('judul', 'Judul', 'trim|required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('isi', 'ISI', 'required');
        $this->form_validation->set_rules('keluar', 'Jam Keluar', 'required');
        $this->form_validation->set_rules('kembali', 'Jam Kembali', 'required');
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
                    $data[$key] = date('Y-m-d');
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
    
    public function getActivity($id) {
//    	$data=$this->Activity_model->getActivity($id);
//	echo json_encode($data,JSON_NUMERIC_CHECK);
//        $event = $this->model->getActivity($id);
//        
//        return $event;
    }

}

<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
class Branch extends MY_Controller {

    function __construct() {
        parent::__construct();
        
        //$this->kode_transaksi = "USER";

        $mdl = "Branch_model";
        $this->model_name = $mdl;
        $this->load->model($mdl);
        $this->model = $this->$mdl;
        $this->table = "branch";
        $this->pkField = "id_branch";
        $this->uniqueFields = array("id_branch");

        //pair key value (field => TYPE)
        //TYPE: EMAIL/STRING/INT/FLOAT/BOOLEAN/DATE/PASSWORD/URL/IP/MAC/RAW/DATA
        $this->fields = array(
            "nama" => array("TIPE" => "STRING", "LABEL" => "Menu Name"),
            "timezone" => array("TIPE" => "STRING", "LABEL" => "Timezone"),
            "ket" => array("TIPE" => "STRING", "LABEL" => "Sort"),
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

        $this->form_validation->set_rules('nama', 'Diagnsa', 'trim|required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('timezone', 'Timezone', 'trim|required');
        

        if ($this->form_validation->run() == FALSE) {
            return array("valid" => FALSE, "error" => validation_errors());
        } else {
            $data = array();
            foreach ($this->input->post() as $key => $value) {
                if ($key == "method") {
                    
                } elseif ($key == $this->pkField) {
                    $data[$key] = !$value ? $this->uuid->v4() : $value;
                } elseif ($key == 'tgl_mulai') {
                    $data[$key] = backend_date($value);
                } elseif ($key == 'tgl_akhir') {
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

    public function upload_file($id='') {
        $result = array();
        $id = $id;
        $lokasi = "./files/image/branch/";
        if (($_FILES[$id]["size"] > 20000000)) {
            $result = array('msg' => "File terlalu besar.");
        } elseif ($_FILES[$id]["error"] > 0) {
            $result = array('msg' => "Return Code: " . $_FILES[$id]["error"] . "<br>");
        } elseif ($this->security->sanitize_filename($_FILES[$id]["name"]) == FALSE) {
            $result = array('msg' => "Nama File tidak baik. Ganti nama file!");
        } elseif ($this->security->xss_clean($_FILES[$id]['tmp_name'], TRUE) === FALSE) {
            $result = array('msg' => "File gambar tidak baik. Harap ganti file!");
        } else {
            $filename = $id . date("Y-m-d-H-m-s");

            if (file_exists($lokasi . $filename)) {
                chmod($lokasi . $filename, 0777);
                unlink($lokasi . $filename);
            }

            $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
            $nama = $withoutExt . ".png";
            $this->resize_image($_FILES[$id]['tmp_name'], $lokasi . $nama, 800, 800);
//            move_uploaded_file($_FILES[$id]["tmp_name"], $lokasi . $_FILES[$id]["name"]);

            $result = array('success' => true, $id => $nama);
        }
//        print_r($result);
        echo json_encode($result);
    }

    private function resize_image($fn, $nama, $w, $h) {
        $size = getimagesize($fn);
        $ratio = $size[0] / $size[1]; // width/height
        if ($ratio > 1) {
            $width = $w;
            $height = $h / $ratio;
        } else {
            $width = $w * $ratio;
            $height = $h;
        }
        $src = imagecreatefromstring(file_get_contents($fn));
        $dst = imagecreatetruecolor($width, $height);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
        imagedestroy($src);
        imagepng($dst, $nama); // adjust format as needed
        imagedestroy($dst);
    }

}

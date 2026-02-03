<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
class Absen extends MY_Controller {

    function __construct() {
        parent::__construct();
        
        //$this->kode_transaksi = "USER";

        $mdl = "Absen_model";
        $this->model_name = $mdl;
        $this->load->model($mdl);
        $this->model = $this->$mdl;
        $this->table = "absen";
        $this->pkField = "id_absen";
        $this->uniqueFields = array("id_absen");

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
        // Get user branch for attendance location tracking
        $user_id = $this->session->userdata('sess_user_id');
        $user = $this->db->select('id_branch')->from('user')->where('id_user', $user_id)->get()->row();
        $user_branch = $user ? $user->id_branch : '';
        
        $data = array(
            'base_url' => base_url(),
            'user_id' => $user_id,
            'user_nama' => $this->session->userdata('sess_nama'),
            'user_branch' => $user_branch
        );
        $this->parser->parse("absen_view", $data);        
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
                    $this->pkFieldValue = !$value ? $this->uuid->v4() : $value;
                    $data[$key] = $this->pkFieldValue;
                } elseif ($key == 'id_user') {
                    // Jika id_user tidak valid atau literal string '{user_id}', gunakan session
                    if (!$value || $value == '{user_id}') {
                        $data[$key] = $this->session->userdata('sess_user_id');
                    } else {
                        $data[$key] = $value;
                    }
                } elseif ($key == 'id_branch') {
                    // Jika id_branch kosong atau tidak valid, ambil dari user yang sedang login
                    if (!$value || $value === '') {
                        $user_id = $this->session->userdata('sess_user_id');
                        $user = $this->db->select('id_branch')->from('user')->where('id_user', $user_id)->get()->row();
                        $data[$key] = $user ? $user->id_branch : '';
                    } else {
                        $data[$key] = $value;
                    }
                } else {
                    if (isset($value)) {
                        $data[$key] = $value;
                    }
                }
            }

            return array("valid" => TRUE, "data" => $data);
        }
    }
    
    public function getWaktuServer() {
        // Get user timezone from their branch with validation
        $user_id = $this->session->userdata('sess_user_id');
        
        if (!$user_id) {
            header('Content-Type: text/plain');
            http_response_code(401);
            echo 'Unauthorized';
            return;
        }
        
        $user = $this->db->select('id_branch')->from('user')->where('id_user', $user_id)->get()->row();
        
        $timezone = 'Asia/Jakarta'; // default
        if ($user && $user->id_branch) {
            $branch = $this->db->select('timezone')->from('branch')->where('id_branch', $user->id_branch)->get()->row();
            if ($branch && !empty($branch->timezone)) {
                $timezone = $branch->timezone;
            }
        }
        
        // Validate timezone before using
        if (!in_array($timezone, timezone_identifiers_list())) {
            $timezone = 'Asia/Jakarta';
        }
        
        date_default_timezone_set($timezone);
        header('Content-Type: text/plain; charset=utf-8');
        echo date("Y-m-d H:i:s");
    }
    
    public function getAbsen($id) {
        // Jika parameter tidak valid atau '{user_id}' (not parsed), gunakan session
        if (!$id || $id == '{user_id}') {
            $id = $this->session->userdata('sess_user_id');
        }
        
        try {
            $data = $this->Absen_model->getAbsen($id);
            header('Content-Type: application/json');
            echo json_encode($data);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => $e->getMessage()));
        }
    }

    public function upload_file($id='') {
        $result = array();
        $id = $id;
        $lokasi = "./files/upload/";
		//print_r($_FILES['in_capture']);
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

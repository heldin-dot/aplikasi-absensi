<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
class Cuti extends MY_Controller {

    function __construct() {
        parent::__construct();
        
        //$this->kode_transaksi = "USER";

        $mdl = "Cuti_model";
        $this->model_name = $mdl;
        $this->load->model($mdl);
        $this->model = $this->$mdl;
        $this->table = "cuti";
        $this->pkField = "id_cuti";
        $this->uniqueFields = array("id_cuti");

        //pair key value (field => TYPE)
        //TYPE: EMAIL/STRING/INT/FLOAT/BOOLEAN/DATE/PASSWORD/URL/IP/MAC/RAW/DATA
        $this->fields = array(
            "status" => array("TIPE" => "STRING", "LABEL" => "Sort"),
            "nama_user" => array("TIPE" => "STRING", "LABEL" => "Menu Name"),
            "tujuan" => array("TIPE" => "STRING", "LABEL" => "Sort"),
            "tgl_mulai" => array("TIPE" => "DATE", "LABEL" => "URL"),
            "tgl_akhir" => array("TIPE" => "DATE", "LABEL" => "URL"),
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

        $this->form_validation->set_rules('tujuan', 'Tujuan', 'trim|required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'required');
        $this->form_validation->set_rules('tgl_akhir', 'Tanggal Akhir', 'required');
        

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

    public function upload_file() {
        $result = array();
        $lokasi = "./files/image/cuti/";
        
        $nameFile = date("Y-m-d-H-i-s-").time(). ".png";
        $output_file = "./files/image/ttd/" . $nameFile;
        $this->base64_to_jpeg($_POST["image"], $output_file);
//        echo $nameFile;
        $this->add_ZK_mark($output_file, $output_file);
        
        $result = array('success' => true, 'image' => $nameFile);
        echo json_encode($result);
    }
    
    function base64_to_jpeg($base64_string, $output_file) {
        $ifp = @fopen($output_file, "wb");

        $data = explode(',', $base64_string);

        @fwrite($ifp, base64_decode($data[1]));
        @fclose($ifp);
        return $output_file;

    }

    function add_ZK_mark($inputfile, $outputfile) {

    //    var_dump(gd_info());
        $im = @imagecreatefrompng($inputfile);

        $bg = @imagecolorallocate($im, 255, 255, 255);
        $textcolor = @imagecolorallocate($im, 0, 0, 255);

        list($x, $y, $type) = getimagesize($inputfile);

        $txtpos_x = $x - 170;
        $txtpos_y = $y - 20;

        @imagestring($im, 5, $txtpos_x, $txtpos_y, '', $textcolor);

        $txtpos_x = $x - 145;
        $txtpos_y = 20;

        @imagestring($im, 3, $txtpos_x, $txtpos_y, '', $textcolor);

        @imagepng($im, $outputfile);

        // Output the image
        //imagejpeg($im);

        @imagedestroy($im);

    }


}

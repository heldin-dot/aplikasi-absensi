<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
class Menu extends MY_Controller {

    function __construct() {
        parent::__construct();
        
        //$this->kode_transaksi = "USER";

        $mdl = "Menu_model";
        $this->model_name = $mdl;
        $this->load->model($mdl);
        $this->model = $this->$mdl;
        $this->table = "menu";
        $this->pkField = "id_menu";
        $this->uniqueFields = array("menu_name");

        //pair key value (field => TYPE)
        //TYPE: EMAIL/STRING/INT/FLOAT/BOOLEAN/DATE/PASSWORD/URL/IP/MAC/RAW/DATA
        $this->fields = array(
            "menu_name" => array("TIPE" => "STRING", "LABEL" => "Menu Name"),
            "parent_name" => array("TIPE" => "STRING", "LABEL" => "Parent Menu"),
            "url" => array("TIPE" => "STRING", "LABEL" => "URL"),
            "sort" => array("TIPE" => "INT", "LABEL" => "Sort"),
            "status" => array("TIPE" => "STATUS", "LABEL" => "Status"),
            "type" => array("TIPE" => "INT", "LABEL" => "Type"),
            "icon" => array("TIPE" => "ICON", "LABEL" => "Icon"),
            "modified_date" => array("TIPE" => "DATE", "LABEL" => "Modified Date"),
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

        $this->form_validation->set_rules('menu_name', 'Menu Name', 'trim|required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('type', 'Menu Type', 'required');
        $this->form_validation->set_rules('url', 'URL', 'trim|required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('status', 'Status', 'required');
        

        if ($this->form_validation->run() == FALSE) {
            return array("valid" => FALSE, "error" => validation_errors());
        } else {
            $data = array();
            foreach ($this->input->post() as $key => $value) {
                if ($key == "method") {
                    
                } elseif ($key == $this->pkField) {
                    $data[$key] = !$value ? $this->uuid->v4() : $value;
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


//    public function masuk() {
//        $errors = array();
//        $data = array();
//        
//        if (!$this->input->post('username')) {
//            $errors['username'] = 'Username belum diisi.';
//        }
//        if (!$this->input->post('password')) {
//            $errors['password'] = 'Password belum diisi.';
//        }
//        
//        if (!empty($errors)) {
//            $data['success'] = false;
//            $data['errors']  = $errors;
//        } else {
////            $condition["email"] = $this->input->post('email');
////            $user = $this->m_users_model->get(NULL, $condition);
//            $user = $this->get();
////            echo "<pre>";
////            var_dump($user);
////            echo "</pre>";
//            if (count($user) > 0) {
//                foreach ($user as $row) {
////                    if (md5($this->input->post('password')) == $row->password) {
////                        $result = $this->get();
////                        if(count($result)>0){
////                            foreach($result as $rs){
////                                $res[] = $rs->id_user;
////                            }
////                        }else{
////                            $res = array();
////                        }
//                     
//                $sess_data = array(
//                    'sess_user_id' => $row->id_user,
//                    'sess_name' => $row->name
//                );
//                $this->session->set_userdata($sess_data);
//                $data['success'] = true;
//                $data['message'] = 'Success!';
////                    } else {
////                        $data['success'] = false;
////                        $data['errors'] = array('password' => 'Password Anda salah.');
////                    }
//                }
//            } else {
//                $data['success'] = false;
//                $data['errors'] = array('username' => 'Username atau Password Anda salah.');
//            }
//        }
//        echo json_encode($data);
//    }
//    
//    public function dataInput() {
//        $this->load->library('form_validation');
//        $this->form_validation->set_error_delimiters('', '');
//
//        $this->form_validation->set_rules('nama_user', 'Nama User', 'trim|required|min_length[3]|max_length[255]|callback_nama_user_check');
//        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');
//        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]|max_length[255]');
//        $this->form_validation->set_rules('foto', 'Foto', 'required|min_length[1]|max_length[255]');
//        $this->form_validation->set_rules('parent', 'Parent', 'trim|required|max_length[255]|callback_parent_check');
//
//        if ($this->form_validation->run() == FALSE) {
//            return array("valid" => FALSE, "error" => validation_errors());
//        } else {
//            $data = array();
//            foreach ($this->input->post() as $key => $value) {
//                if ($key == "method") {
//                    
//                } elseif ($key == $this->pkField) {
//                    $data[$key] = !$value ? $this->uuid->v4() : $value;
//                } elseif ($key == 'password') {
//                    if ($value != "UPDATE_USER") {
//                        $data[$key] = md5($value);
//                    }
//                } else {
//                    if (isset($value)) {
//                        $data[$key] = $value;
//                    }
//                }
//            }
//            
////            if($this->session->has_userdata('sess_level_id')) {
////                $this->session->set_userdata('sess_level_id', $this->input->post('id_level'));
////            }
//
//            return array("valid" => TRUE, "data" => $data);
//        }
//    }

    public function nama_user_check($str) {
        return $this->is_unique("nama_user", $str, __FUNCTION__, "Nama User");
    }

    public function email_check($str) {
        return $this->is_unique("email", $str, __FUNCTION__, "Email");
    }

    public function password_check($pwd) {
        $cek = array();
        $cek["m_users.id_user"] = $this->input->post("id_user");
        $cek["m_users.password"] = md5($pwd);
        $hasil = $this->model->check($cek);
        if ($hasil) {
            return TRUE;
        } else {
            $this->form_validation->set_message("password_check", "Password lama salah.");
            return FALSE;
        }
    }

    public function parent_check($value) {
        
        $data["m_user.id_user"] = $value;
        $result = $this->model->check($data);
        if (!$result) {
            $this->form_validation->set_message(__FUNCTION__, "Parent " . $value . " tidak ada.");
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function ubah_password() {
        $result = array();
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[255]|xss_clean|callback_password_check');
        $this->form_validation->set_rules('password1', 'Password Baru', 'trim|required|min_length[3]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('password2', 'Pengulangan Password', 'trim|required|min_length[3]|max_length[255]|xss_clean|matches[password1]');
        if ($this->form_validation->run() == FALSE) {
            $result = array("msg" => validation_errors());
        } else {       
            $data = array();
            $id_user = $this->input->post("id_user");
            $data["m_users.password"] = md5($this->input->post("password2"));
            $hasil = $this->model->update($id_user, $data);
            if($hasil) {
                $result = array("success" => TRUE);
            } else {
                $result = array("msg" => "Gagal tersimpan.");
            }
        }
        echo json_encode($result);
    }

       

    private function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
    
    public function event() {
        $event = $this->model->event();
        foreach ($event as $value) {
            echo $value->id_event;
        }
    }

}

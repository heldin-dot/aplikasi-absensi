<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index() {
        if ($this->session->userdata('website_admin_logged_in')) {
            redirect('home');
        } else {
            $data = array(
                'title' => 'Login Admin',
                'base_url' => base_url()
            );
            $this->parser->parse('login_view', $data);
        }
    }

    public function masuk() {
        $errors = array();
        $data = array();
        
        if (!$this->input->post('login_username')) {
            $errors['username'] = 'Username belum diisi.';
        }
        if (!$this->input->post('login_password')) {
            $errors['password'] = 'Password belum diisi.';
        }
        
        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors']  = $errors;
        } else {
//            $condition["email"] = $this->input->post('email');
//            $user = $this->m_users_model->get(NULL, $condition);
            $cond = array("user.username"=>$this->input->post('login_username'),
                "user.status"=>"1");
            $user = $this->user_model->get_user($cond);
            if (count($user) > 0) {
                foreach ($user as $row) {
                    if (md5($this->input->post('login_password')) == $row->password) {
//                        $result = $this->user_model->get_child($row->id_user);
//                        if(count($result)>0){
//                            foreach($result as $rs){
//                                $res[] = $rs->id_user;
//                            }
//                        }else{
//                            $res = array();
//                        }
                     
                        $sess_data = array(
                            'sess_user_id' => $row->id_user,
                            'user_group' => $row->id_group,
                            'sess_nama' => $row->name,
                            'sess_photo' => $row->photo,
                            'sess_menu' => $row->menu,
                            'sess_tipe' => $row->tipeuser,
                            'sess_branch' => $row->id_branch,
                            'website_admin_logged_in' => TRUE,
//                            'child' => $res
                        );
                        $this->session->set_userdata($sess_data);
                        $data['success'] = true;
                        $data['message'] = 'Success!';
                    } else {
                        $data['success'] = false;
                        $data['errors'] = array('password' => 'Password Anda salah.');
                    }
                }
            } else {
                $data['success'] = false;
                $data['errors'] = array('username' => 'Username Anda salah / Akun Tidak Aktif.');
            }
        }

        echo json_encode($data);
    }

    public function keluar() {
        $this->session->sess_destroy();
        redirect('login');
    }
    
    public function check_session() {
        if ($this->session->userdata('website_admin_logged_in')) {
            echo json_encode(array("login" => TRUE));
        } else {
            echo json_encode(array("login" => FALSE));
        }
    }

}

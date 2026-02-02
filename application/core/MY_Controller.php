<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    var $model;
    var $model_name;
    var $table;
    var $pkField;
    var $pkFieldValue;
    var $uniqueFields = array();
    var $fields = array();
    var $data = array();
//    var $detail_model;
//    var $detail_model_name;
//    var $detail_table;
//    var $detail_pkField;
//    var $detail_fkField;
//    var $detail_uniqueFields = array();
//    var $detail_fields = array();
//    var $detail_data = array();
    var $kode;
    var $kode_transaksi = "";
    var $tambah = true; //false;
    var $ubah = true; //false;
    var $hapus = true; //false;
    var $lihat = true; //false;
    var $tombol_cetak = false;
    var $removeAdd = array();
    var $convert = array();
    
    var $validasi = true;

    function __construct() {
        parent::__construct();

        if (!$this->session->userdata('website_admin_logged_in')) {
            $data = array(
                'base_url' => base_url(),
            );
            $this->parser->parse('login_view', $data);
        }
    }

    function getAuth($id_auth) {
        $this->load->model("authority_model");
        $cond = array("authority.id_auth"=>$id_auth, "authority.status"=>"1");
//        $cond = array("authority.id_menu" => $id_menu, 
//            "authority.id_group"=>$this->session->userdata('user_group'));
        $lists = $this->authority_model->get(NULL,$cond);
//        var_dump($lists);
        if ($lists) {
            foreach ($lists as $value) {
                $this->ubah = $value['updateable'];
                $this->hapus = $value['deleteable'];
            }
        } else {
            $this->ubah = false;
            $this->hapus = false;
        }
    }
   

    public function ajax_list($id_auth) {
        $this->getAuth($id_auth);
//        $this->get_hak_akses($this->kode_transaksi);
//        if (!$this->lihat) {
//            $output = array(
//                "draw" => $_POST['draw'],
//                "recordsTotal" => 0,
//                "recordsFiltered" => 0,
//                "data" => array()
//            );
//        } else {
            $filter = array();
            if($this->input->post("filter")) {
                foreach ($this->input->post("filter") as $key => $value) {
                    if (strpos($key, ".")) {
                        $filter[$key] = $value;
                    } else {
                        $filter[$this->table . "." . $key] = $value;
                    }
                }
            }
            foreach($this->uniqueFields as $k => $val){
                if($this->input->post($val) || $this->input->post($val) !=''){
                    $filter[$this->table .".". $val] = $this->input->post($val);
                }
            }
            if($this->input->get("key") && $this->input->get("val") && $this->session->userdata("hak_akses")!=0) {
                if($this->session->userdata("hak_akses")==9){
                    $filter[$this->table .".". $this->input->get("key")]=$this->input->get("val");
                }elseif($this->session->userdata("hak_akses")==2){
                    $param = $this->session->userdata("child");
                    array_push($param,$this->input->get("val"));
                    $filter[$this->table .".". $this->input->get("key")]=$param;
                }else{
                    $filter[$this->table .".". $this->input->get("key")]=$this->input->get("val");
                }
            }else{
                $filter[$this->table .".". $this->input->get("key")]=$this->input->get("val");
            }
			
			
            $lists = $this->model->get_datatables($filter);
            $data = array();
            $no = !$this->input->post("start") ? 0 : $this->input->post("start"); //$_POST['start'];
            foreach ($lists as $list) {
                $no++;
                $row = array();
                
                // Add default value for NULL fields
                foreach ($this->fields as $key => $value) {
                    if (!isset($list[$key])) {
                        $list[$key] = "-";
                    }
                }

                foreach ($this->fields as $key => $value) {
                    if ($key == "action") {
                        if(isset($value["ACTION_NAME"])){
                            $row[] = $this->action($list[$this->pkField],$value["ACTION_NAME"]);
                        }else{
                            $row[] = $this->action($list[$this->pkField]);
                        }
                    } elseif ($key == "delete") {
                        $row[] = $this->action_delete($list[$this->pkField]);
                    } elseif ("TIPE" == array_search("IMAGE", $value)) {
                        $row[] = '<img id="image-table" src="' . base_url() . $value["LOKASI"] . $list[$key] . '?rand='. $this->uuid->v4() . '" alt="' . $list[$key] . '">';
                    }elseif ("TIPE" == array_search("ICON", $value)) {
                        $row[] = '<i class="material-icons">' . $list[$key] . '</i>';
                    } elseif ("TIPE" == array_search("LINK", $value)) {
                        $row[] = '<a href="' . $value["URL"] . $list[$key] . '" target="_blank">' . $list[$key] . '</a>';
                    } elseif ("TIPE" == array_search("LOC", $value)) {
                        $row[] = "<a target='_blank' href='https://www.google.com/maps/place/".$list[$key]."' class='uk-badge uk-badge-success'>View Location</a>";
                    } elseif ("TIPE" == array_search("CUTI", $value)) {
                        if ($list[$key]=="2") {
                            $row[] = "<span class='uk-badge uk-badge-success'>TERIMA</span>";
                        }
                        if ($list[$key]=="1") {
                            $row[] = "<span class='uk-badge uk-badge-danger'>TOLAK</span>";
                        }
                        if ($list[$key]=="0") {
                            $row[] = "<span class='uk-badge uk-badge-info'>PENDING</span>";
                        }
                    } elseif ("TIPE" == array_search("DATE", $value)) {
                        $row[] = "<div align='center'>".frontend_date($list[$key])."</div>";
//                        $row[] = $list[$key];                                            
                    }elseif ("TIPE" == array_search("BOOLEAN", $value)) {
                        $custom = isset($value["CUSTOM"]) ? $value["CUSTOM"] : FALSE;
                        if ($custom) {
                            $row[] = $this->customList($key, $list[$key], "123");
                        } else {
                            $row[] = $this->aktifList($list[$key], $list[$this->pkField]);
                        }
                    } elseif ("TIPE" == array_search("KELAMIN", $value)) {
                        //$custom = isset($value["CUSTOM"]) ? $value["CUSTOM"] : FALSE;
                        if ($list[$key]=="1") {
                            $row[] = "Laki-Laki";
                        } else {
                            $row[] = "Perempuan";
                        }
                    } elseif ("TIPE" == array_search("STATUS", $value)) {
                        //$custom = isset($value["CUSTOM"]) ? $value["CUSTOM"] : FALSE;
                        if ($list[$key]=="0") {
                            $row[] = "<div style='width: 50%;' align='center'><i class='material-icons'>&#xE5CD;</i> Non Aktif</div>";
                        } else if ($list[$key]=="2") {
                            $row[] = "<div style='width: 50%;' align='center'><i class='material-icons'>&#xE15B;</i> Pending</div>";
                        } else {
                            $row[] = "<div style='width: 50%;' align='center'><i class='material-icons'>&#xE5CA;</i> Aktif</div>";
                        }
                     } elseif ("TIPE" == array_search("STRING", $value)) {
                        $custom = isset($value["CUSTOM"]) ? $value["CUSTOM"] : FALSE;
                        
                        // Special handling for timezone field
                        if ($key == "timezone") {
                            $timezoneMap = array(
                                'Asia/Jakarta' => 'Indonesia Barat',
                                'Asia/Makassar' => 'Indonesia Tengah',
                                'Asia/Jayapura' => 'Indonesia Timur'
                            );
                            $displayValue = isset($timezoneMap[$list[$key]]) ? $timezoneMap[$list[$key]] : $list[$key];
                            $row[] = $displayValue;
                        } elseif ($custom) {
                            $row[] = $this->customAdmin($list[$key]);
                        } else {
                            $row[] = $list[$key];
                        }
                    } elseif ("TIPE" == array_search("FLOAT", $value)) {
                        $row[] = number_format($list[$key], 0, '.', ',');
                    } elseif ("TIPE" == array_search("DETAIL", $value)) {
                        $model = isset($value["MODEL"]) ? $value["MODEL"] : "";
                        $table = isset($value["TABLE"]) ? $value["TABLE"] : "";
                        $kondisi[$table . "." . $this->pkField] = $list[$this->pkField];
                        $this->load->model($model);
                        $detail = $this->$model->get(NULL, $kondisi);
                        $row[] = $detail;
                    } else {
                        $row[] = $list[$key];
                    }
                }
                $data[] = $row;
            }

            $draw = !$this->input->post("draw") ? 1 : $this->input->post("draw");
            $output = array(
                "draw" => $draw, //$_POST['draw'],
//                "recordsTotal" => $this->model->count_all(),
                "recordsTotal" => $this->model->count_filtered($filter),
                "recordsFiltered" => $this->model->count_filtered($filter),
                "data" => $data
            );
//        }
        echo json_encode($output);
    }

    public function get() {
        $cari = NULL;
        $kondisi = array();
        if ($this->input->post()) {
            foreach ($this->input->post() as $key => $value) {
                if ($key == "cari" || $key == "q") {
                    $cari = $value;
                } elseif (strpos($key, ".")) {
                    $kondisi[$key] = $value;
                } else {
                    $kondisi[$this->table . "." . $key] = $value;
                }
            }
        }
        $result = $this->model->get($cari, $kondisi);
        echo json_encode($result);
    }

    public function add() {
//        $this->get_hak_akses($this->kode_transaksi);
//        if (!$this->tambah) {
//            $result = array("msg" => "Anda tidak berhak menambah data. Kode Transaksi: " . $this->kode_transaksi);
//        } else {
            $result = array();
            $data = $this->dataInput();
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
            if ($data["valid"]) {
                $insert = $this->model->add($data["data"]);
                if ($insert) {
                    if($this->kode) {
                        $result = array("success" => TRUE, "id" => $this->pkFieldValue, "kode" => $this->kode);
                    } else {
                        $result = array("success" => TRUE, "id" => $this->pkFieldValue);
                    }
                } else {
                    $result = array("msg" => "Gagal tersimpan.", "success" => FALSE);
                }
            } else {
                $result = array("msg" => $data["error"], "success" => FALSE);
            }
//        }
        echo json_encode($result);
    }

//    public function addDetail($dataDetail, $modelName) {
//        $result = array();
//        if ($dataDetail) {
//            $this->load->model($modelName);
//            foreach ($dataDetail as $value) {
//                $insert = $this->$modelName->add($value);
//            }
//            if ($insert) {
//                $result = array("success" => TRUE);
//            } else {
//                $result = array("msg" => "Gagal tersimpan.");
//            }
//        } else {
//            $result = array("msg" => "Data kosong.");
//        }
//        return $result;
//    }

    public function update() {
//        $this->get_hak_akses($this->kode_transaksi);
        if (!$this->ubah) {
            $result = array("msg" => "Anda tidak berhak merubah data. Kode Transaksi: " . $this->kode_transaksi);
        } else {
            $result = array();
            $data = $this->dataInput();
            if ($data["valid"]) {
                $update = $this->model->update($this->input->post($this->pkField), $data["data"]);
                if ($update) {
                    if($this->kode) {
                        $result = array("success" => TRUE, "id" => $this->pkFieldValue, "kode" => $this->kode);
                    } else {
                        $result = array("success" => TRUE, "id" => $this->pkFieldValue);
                    }
                } else {
                    $result = array("msg" => "Gagal diupdate.", "success" => FALSE);
                }
            } else {
                $result = array("msg" => $data["error"], "success" => FALSE);
            }
        }
        echo json_encode($result);
    }

//    public function updateDetail($dataDetail, $modelName, $filter) {
//        $result = array();
//        $this->load->model($modelName);
//        $this->$modelName->delete_by($filter);
//        if ($dataDetail) {
//            foreach ($dataDetail as $value) {
//                $insert = $this->$modelName->add($value);
//            }
//            if ($insert) {
//                $result = array("success" => TRUE);
//            } else {
//                $result = array("msg" => "Gagal diupdate.");
//            }
//        } else {
//            $result = array("msg" => "Data detail kosong.");
//        }
//        return $result;
//    }

    public function delete($id) {
//        $this->get_hak_akses($this->kode_transaksi);
        if ($this->session->userdata('hak_akses')==2) {      
            $result = array("success" => FALSE, "msg" => "Anda tidak berhak menghapus data.");
        } else {
            if ($id) {
                $delete = $this->model->delete($id);
                if ($delete) {
                    $result = array("success" => TRUE);
                } else {
                    $result = array("msg" => "Gagal menghapus data.");
                }
            }
        }
        echo json_encode($result);
    }

    public function edit($id) {
        if ($id) {
            $data = $this->model->get_by_id($id);
            echo json_encode($data);
        }
    }

    public function aktif() {
//        $this->get_hak_akses($this->kode_transaksi);
        if (!$this->ubah) {
            $result = array("msg" => "Anda tidak berhak merubah data. Kode Transaksi: " . $this->kode_transaksi);
        } else {
            $result = array();
            $data["aktif"] = $this->input->post("aktif");
            if ($data) {
                $update = $this->model->update($this->input->post($this->pkField), $data);
                if ($update) {
                    $result = array("success" => TRUE);
                } else {
                    $result = array("msg" => "Gagal diupdate.");
                }
            } else {
                $result = array("msg" => $data["error"]);
            }
        }
        echo json_encode($result);
    }

    public function active() {
//        $this->get_hak_akses($this->kode_transaksi);
        if (!$this->ubah) {
            $result = array("msg" => "Anda tidak berhak merubah data. Kode Transaksi: " . $this->kode_transaksi);
        } else {
            $data = array();
            $result = array();
            $data[$this->input->post("field")] = $this->input->post("value");
            if ($data) {
                $update = $this->model->update($this->input->post($this->pkField), $data);
                if ($update) {
                    $result = array("success" => TRUE);
                } else {
                    $result = array("msg" => "Gagal diupdate.");
                }
            } else {
                $result = array("msg" => $data["error"]);
            }
        }
        echo json_encode($result);
    }

    public function is_unique($field, $value, $callback, $alias, $id = NULL) {
        if ($this->input->post($this->pkField)) {
            $data[$this->table . "." . $this->pkField . " != "] = $this->input->post($this->pkField);
        }
        $data[$field] = $value;
        $result = $this->model->check($data, $id);
        if ($result) {
            $this->form_validation->set_message($callback, $alias . " " . $value . " sudah ada.");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function tanggal_check($date) {
        $day = (int) substr($date, 0, 2);
        $month = (int) substr($date, 3, 2);
        $year = (int) substr($date, 6, 4);
        return checkdate($month, $day, $year);
    }
    
    function tanggal_periode_check($date) {
        $this->load->model("M_periode_model");
        return $this->M_periode_model->tanggal_periode($date);
    }

    function tanggal_transaksi_check($date) {
        $this->load->model("M_periode_model");
        return $this->M_periode_model->tanggal_transaksi($date);
    }

    public function action($id, $fname = '') {
        $tombol = '';
        if($fname != ''){
            foreach($fname as $k => $val){
                if($this->ubah == '1' && $k=='EDIT'){
                    $tombol .='<a href="javascript:void(0);" title="Edit" onclick="'.$val.'(' . "'" . $id . "'" . ')"><i class="material-icons md-24">&#xE8F4;</i></a>';
                }   
                if($this->hapus == '1' && $k=='HAPUS'){
                    $tombol .= '<a href="javascript:void(0);" title="Hapus" onclick="'.$val.'(' . "'" . $id . "'" . ')"><i class="material-icons md-24">&#xE872;</i></a>';
                }
                if($k=='DETAIL'){
                    $tombol .='<a href="javascript:void(0);" title="Detail" onclick="'.$val.'(' . "'" . $id . "'" . ')"><i class="material-icons md-24">&#xE85D;</i></a>';
                }
                if($k=='APPROVE'){
                    $tombol .='<a href="javascript:void(0);" title="Confirm" onclick="'.$val.'(' . "'" . $id . "'" . ')"><i class="material-icons md-24">&#xE862;</i></a>';
                }
            }            
        }else{
            if($this->ubah == '1'){
                $tombol .= '<a href="javascript:void(0);" title="Edit" onclick="edit(' . "'" . $id . "'" . ')"><i class="material-icons md-24">&#xE8F4;</i></a>';
            }

            if($this->hapus == '1'){
                $tombol .= '<a href="javascript:void(0);" title="Hapus" onclick="hapus(' . "'" . $id . "'" . ')"><i class="material-icons md-24">&#xE872;</i></a>';
            }
        }
                
                  
//        if ($cetak && $this->lihat) {
//            $tombol .= ' <a class="btn btn-xs btn-warning" href="#" data-toggle="modal" data-target="#modal_cetak" title="Cetak" onclick="cetak(' . "'" . $id . "'" . ')"><i class="glyphicon glyphicon-print"></i></a>';
//        }
        return $tombol;
    }

    public function action_delete($id) {
        return '<a href="javascript:void(0);" title="Hapus" onclick="hapus(' . "'" . $id . "'" . ')"><i class="material-icons md-24">&#xE872;</i></a>';
    }

    public function aktifList($aktif, $id) {
        return $aktif == 1 ? '<input id="' . $id . '" type="checkbox" checked onclick="edit_aktif(' . "'" . $id . "'" . ')" data-md-icheck />' : '<input id="' . $id . '" type="checkbox" onclick="edit_aktif(' . "'" . $id . "'" . ')" data-md-icheck/>';
    }

    public function customList($pre, $value, $id) {
        return $value == 1 ? '<input id="' . $pre . $id . '" type="checkbox" checked onclick="edit_list(' . "'" . $pre . "'" . ', ' . "'" . $id . "'" . ')" data-md-icheck />' : '<input id="' . $pre . $id . '" type="checkbox" onclick="edit_list(' . "'" . $pre . "'" . ', ' . "'" . $id . "'" . ')" data-md-icheck/>';
    }

    public function customAdmin($value) {
        if ($value == 0) {
            $value = 'Super Administrator';
        }
        elseif ($value == 1) {
            $value = 'Administrator';
        }
        else {
            $value = 'User';
        }
        return $value ;
    }
    
    
    private function is_uniques($fields) {
        $cek = array();
        $unique = TRUE;
        $pesan = "";
        if (!empty($fields)) {
            foreach ($fields as $key => $value) {
                if ($this->model->cek($key, $value)) {
                    $pesan .= $value . ' sudah ada.<br/>';
                    $unique = FALSE;
                }
            }
        }
        $cek["unique"] = $unique;
        $cek["pesan"] = $pesan;
        return $cek;
    }
    
//    public function save($model, $method, $inputs, $fields, $pkField, $pkFieldValue, $uniqueFields = array(), $remove = array(), $convert = array()) {
//        $isValid = array();
//        $validasi = TRUE;
//        $pesan = "";
//        $data = array();
//        $dataBaru = array();
//
//        try {
//            if ($fields) {
//                foreach ($fields as $field => $type) {
//                    $input = $inputs[$field];
//                    $data[$field] = $input;
//                }
//                if ($method == "tambah") {
//                    $unique = array();
//                    if ($uniqueFields) {
//                        foreach ($uniqueFields as $uniqueField) {
//                            $unique[$uniqueField] = $data[$uniqueField];
//                        }
//                    }
//                    $isUnique = $this->is_uniques($unique);
//                    $validasi = $isUnique["unique"];
//                    $pesan .= $isUnique["pesan"];
//                }
//
//                if ($validasi) {
//                    foreach ($remove as $field) {
//                        unset($data[$field]);
//                    }
//                    $dataBaru = array_replace($data, $convert);
//                    $this->load->model($model);
//                    if ($method == "tambah") {
//                        try {
//                            $id = $this->uuid->v4();
//                            $dataBaru[$pkField] = $id;
//                            if ($this->$model->add($dataBaru)) {
//                                return array('success' => true);
//                            } else {
//                                return array('success' => FALSE, 'msg' => 'Proses simpan gagal.');
//                            }
//                        } catch (Exception $exc) {
//                            var_dump($exc->getMessage());
//                        }
//                    } elseif ($method == "ubah") {
//                        try {
//                            if ($this->$model->update($pkFieldValue, $dataBaru)) {
//                                return array('success' => true, 'id' => $pkFieldValue);
//                            } else {
//                                return array('success' => FALSE, 'msg' => 'Proses update gagal.');
//                            }
//                        } catch (Exception $exc) {
//                            var_dump($exc->getTraceAsString());
//                        }
//                    } else {
//                        echo json_encode(array('success' => false, "msg" => "Maaf, Anda tidak berhak."));
//                    }
//                } else {
//                    return array('success' => FALSE, "msg" => $pesan);
//                }
//            }
//        } catch (Exception $exc) {
//            var_dump($exc->getMessage());
//        }
//    }

    public function unsetAll() {
        $this->model;
        $this->model_name = "";
        $this->pkField = "";
        $this->uniqueFields = array();
        $this->fields = array();
        $this->data = array();
//        $this->detail_model;
//        $this->detail_table = "";
//        $this->detail_pkField = "";
//        $this->detail_fkField = "";
//        $this->detail_uniqueFields = array();
//        $this->detail_fields = array();
//        $this->detail_data = array();
        $this->tambah = false;
        $this->ubah = false;
        $this->hapus = false;
        $this->lihat = false;
    }
    
}

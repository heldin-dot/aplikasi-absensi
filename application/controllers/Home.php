<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MY_Controller {

    var $base_url;
    var $menu_string;

    function __construct() {
        parent::__construct();
        
        $mdl = "authority_model";
        $this->model_name = $mdl;
        $this->load->model($mdl);
        $this->model = $this->$mdl;
        $this->table = "authority";
        $this->pkField = "id_auth";

        //pair key value (field => TYPE)
        //TYPE: EMAIL/STRING/INT/FLOAT/BOOLEAN/DATE/PASSWORD/URL/IP/MAC/RAW/DATA
        $this->fields = array(
            "group_name" => array("TIPE" => "STRING", "LABEL" => "Group Name"),
            "menu_name" => array("TIPE" => "STRING", "LABEL" => "Menu Name"),         
            "addable" => array("TIPE" => "STRING", "LABEL" => "Addable"),
            "updateable" => array("TIPE" => "STRING", "LABEL" => "Updateable"),
            "deleteable" => array("TIPE" => "STRING", "LABEL" => "Deleteable"),
            "status" => array("TIPE" => "INT", "LABEL" => "Status"),
            "modified_date" => array("TIPE" => "DATE", "LABEL" => "Modified Date"),
            "action" => array("TIPE" => "TRANSACTION", "LABEL" => "Action")
        );
        
        if (!$this->session->userdata('website_admin_logged_in')) {
            redirect('login');
        }
    }

    public function index() {
        $this->getListMenu();
        $data = array(
            'base_url' => base_url(),
            'keluar' => base_url() . 'login/keluar',
            'user_id' => $this->session->userdata('sess_user_id'),
            'user_group' => $this->session->userdata('user_group'),
            'user_nama' => $this->session->userdata('sess_nama'),
            'user_menu' => $this->session->userdata('sess_menu'),
            'user_tipe' => $this->session->userdata('sess_tipe'),
            'user_branch' => $this->session->userdata('sess_branch'),
            'default_content' => base_url() . 'home/menu/dashboard',
            'menu_list' => $this->menu_string,
            'user_photo' => $this->session->userdata('sess_photo')
        );
        
        $this->parser->parse('home_view', $data);
    }
    
    public function getListMenu(){
        $dt = $this->model->getMenu($this->session->userdata('user_group')); 
        if ($this->session->userdata('sess_menu')==0){
//            $this->menu_string='<ul id="menu_top">';
            $this->menu_string='<ul id="kUI_menu" style="background-color:rgba(0, 0, 0, 0); color:#F8F8FF;">';
        }else{
            $this->menu_string='<ul >';
        }
        $listMenu = $this->buildTree($dt);
        //echo "<pre>";
        //var_dump($dt);
        //print_r($listMenu);
        //echo "</pre>";
        $this->createMenu($listMenu);
        $this->menu_string .= '</ul>';
        
    }   
    
    function createMenu(array &$elements){
        foreach($elements as $e){
            if ($this->session->userdata('sess_menu')==0){
                // MENU ATAS
                if($e['parent'] == '' && !isset ($e['children'])){
                    $this->menu_string .= '
                                            <li title="'.$e['menu_name'].'">
                                                <a style="color:#F8F8FF;" href="javascript:void(0)" onclick="showContent(\''.$e['url'].'\',\''.$e['id_auth'].'\',\''.$e['addable'].'\')">
                                                <i class="material-icons">'.$e['icon'].'</i> '.$e['menu_name'].'
                                                </a>
                                            </li>
                                        ';
                }else if($e['parent'] == '' && isset($e['children'])){
                    if($e['parent']==''){
                        $this->menu_string .= '
                                                <li title="'.$e['menu_name'].'"><i class="material-icons">'.$e['icon'].'</i> '.$e['menu_name'].' <ul>
                                            ';
                    }
                    $this->createMenu($e['children']);                
                    $this->menu_string .= '</ul></li>';
                    
                }else{
                    if (isset($e['parent']) != '' && isset($e['children']) != ''){
                        $this->menu_string .= '<li title="'.$e['menu_name'].'">'
                                            . '<a style="color:#000000;" href="javascript:void(0)" onclick="showContent(\''.$e['url'].'\',\''.$e['id_auth'].'\',\''.$e['addable'].'\')"> '.$e['menu_name'].'</a>'
                                            . '<ul>';
                        $this->createMenu($e['children']);
                        $this->menu_string .= '</ul></li>';
                    }else{
                           
                        $this->menu_string .='<li title="'.$e['menu_name'].'">'
                                            . '<a style="color:#000000;" href="javascript:void(0)" onclick="showContent(\''.$e['url'].'\',\''.$e['id_auth'].'\',\''.$e['addable'].'\')"> '.$e['menu_name'].'</a>'
                                            . '</li>';
                    }
                }
                
                
            }else{
                // MENU KIRI
                if($e['parent'] == '' && !isset ($e['children'])){
                    $this->menu_string .= '<li title="'.$e['menu_name'].'">
                                <a href="javascript:void(0)" onclick="showContent(\''.$e['url'].'\',\''.$e['id_auth'].'\',\''.$e['addable'].'\')">
                                <span class="menu_icon"><i class="material-icons">'.$e['icon'].'</i></span>
                                <span class="menu_title">'.$e['menu_name'].'</span>
                                </a>
                            </li>';
                }else if(isset($e['children'])){
                    if($e['parent']==''){
                        $this->menu_string .= '<li><a href="#">
                                <span class="menu_icon"><i class="material-icons">'.$e['icon'].'</i></span>
                                <span class="menu_title">'.$e['menu_name'].'</span>
                            </a>
                            <ul>';
                    }else{
                         $this->menu_string .= '<li class="submenu_trigger"><a href="#">
                                <span class="menu_title">'.$e['menu_name'].'</span>
                            </a>
                            <ul>';

                    }
                    $this->createMenu($e['children']);                
                    $this->menu_string .= '</ul></li>';
                }else{
                    $this->menu_string .='<li><a href="javascript:void(0)" onclick="showContent(\''.$e['url'].'\',\''.$e['id_auth'].'\',\''.$e['addable'].'\')">'.$e['menu_name'].'</a></li>';
                }
            }
        }
    }
    
    public function buildTree(array &$elements, $parentId = '', $depth = 0) {
        if($depth > 1000) return '';
        $branch = array();

        foreach ($elements as $element) {
            if ($element['parent'] == $parentId && $element['menu_name']!=NULL) {
                $children = $this->buildTree($elements, $element['id_menu'], $depth+1);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[$element['id_menu']] = $element;
                unset($elements[$element['id_menu']]);
                              
            }
        }
//        print_r($branch);
        return $branch;
    }
        
    public function menu($view,$id_auth,$addable) {
        if($view == '' || $view == 'dashboard' || $view == 'home'){
            $view = 'dashboard_view';
        }else if($view == 'profile'){
            $view = 'profile_view';
        }else{
            $view = str_replace(':', "/", $view);
        }
        
        $data = array(
            'base_url' => base_url(),
            'user_id' => $this->session->userdata('sess_user_id'),
            'user_group' => $this->session->userdata('user_group'),
            'user_nama' => $this->session->userdata('sess_nama'),
            'user_tipe' => $this->session->userdata('sess_tipe'),
            'user_branch' => $this->session->userdata('sess_branch'),
            'id_auth' => $id_auth,
            'addable' => $addable,
            'user_photo' => $this->session->userdata('sess_photo')
        );
        
        $this->parser->parse($view, $data);
        
    }
    
    public function upload($name) {
        $dir = date('Ym');
    	$lokasi = "./files/".$dir."/";
    	$id = $name;
        $i=0;
    	if (($_FILES[$id]["size"] < 50000000)) {
            if ($_FILES[$id]["error"] > 0) {
                echo json_encode(array('msg' => "Return Code: " . $_FILES[$id]["error"] . "<br>"));
            } else {
                if(!is_dir($lokasi)){
                    mkdir($lokasi);
                }
                while (file_exists($lokasi . $_FILES[$id]["name"])) {
                    $_FILES[$id]["name"]= pathinfo($_FILES[$id]["name"],PATHINFO_FILENAME).$i.".".pathinfo($_FILES[$id]["name"],PATHINFO_EXTENSION);
                    $i++;
                }
                move_uploaded_file($_FILES[$id]["tmp_name"], $lokasi . $_FILES[$id]["name"]);
                echo json_encode(array('success' => true, 'filename' => $lokasi.$_FILES[$id]["name"]));
//                echo json_encode(array('success' => true, "image" => $id));
            } 
    			/*$import = $this->import($_FILES[$id]["name"]);
    			if ($import != "") {
    				echo json_encode($import);
    			}*/
    	} else {
            echo json_encode(array('msg' => "File terlalu besar."));
    	}
    }
    
    public function sertifikat() {
        $this->load->library('Pdf');
        $font = 'helvetica';
        $fontSize = 6;
        $pdf = new Pdf('P', 'inch', 'A4', true, 'UTF-8', false);
        //$pdf = new Pdf('P','mm',array('195','141'));
        $pdf->SetFont($font, '', $fontSize);
        $pdf->SetHeaderMargin(10);
        $pdf->SetTopMargin(1);
        $pdf->setFooterMargin(1);
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->SetAuthor('TSM');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage('L', array(235.3, 145.7));
        
        $content ='<div align="center"><h1>SERTIFIKAT</h1></div>';
        $pdf->writeHTML($content, false, false, true, false, '');

        $pdf->Output('BAA.pdf', 'I');
    }
    
//    public function dashboard() {
//        $this->load->model("M_pasien_model");
//        $condition = array();
//        $total = $this->M_pasien_model->total($condition);
//        echo json_encode($total);
//    }

}

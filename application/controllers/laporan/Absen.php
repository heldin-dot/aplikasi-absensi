<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
class Absen extends MY_Controller {

    function __construct() {
        parent::__construct();
        
        //$this->kode_transaksi = "USER";

        $mdl = "L_absen_model";
        $this->model_name = $mdl;
        $this->load->model($mdl);
        $this->model = $this->$mdl;
        $this->table = "absen";
        $this->pkField = "id_absen";
        $this->uniqueFields = array("id_absen");

        //pair key value (field => TYPE)
        //TYPE: EMAIL/STRING/INT/FLOAT/BOOLEAN/DATE/PASSWORD/URL/IP/MAC/RAW/DATA
        $this->fields = array(
            "delete" => array("TIPE" => "TRANSACTION", "LABEL" => "Action"),
            "nama_user" => array("TIPE" => "STRING", "LABEL" => "User"),
            "nama_branch" => array("TIPE" => "STRING", "LABEL" => "Branch"),
            "in_date" => array("TIPE" => "DATE", "LABEL" => "Check In Date"),
            "latin" => array("TIPE" => "LOC", "LABEL" => "Location Check In"),
            "out_date" => array("TIPE" => "DATE", "LABEL" => "Check Out Date"),
            "latout" => array("TIPE" => "LOC", "LABEL" => "Location Check Out"),
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
                    $this->pkFieldValue = !$value ? $this->uuid->v4() : $value;
                    $data[$key] = $this->pkFieldValue;
//                } elseif ($key == 'in_date') {
//                    $data[$key] = date('Y-m-d H:i:s');
//                } elseif ($key == 'out_date') {
//                    $data[$key] = date('Y-m-d H:i:s');
                } else {
                    if (isset($value)) {
                        $data[$key] = $value;
                    }
                }
            }

            return array("valid" => TRUE, "data" => $data);
        }
    }
    
    public function getAbsen($id) {
    	$data=$this->Absen_model->getAbsen($id);
	echo json_encode($data,JSON_NUMERIC_CHECK);
//        $event = $this->model->getAbsen($id);
//        
//        return $event;
    }
    
    function printData(){
        $this->excel_();
		ob_start ();
        
        $bold = array('font'=> array('bold'=>true));
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
//        $this->load->model('setting_model');
//        $setting = $this->setting_model->get_by_id('0');
		
        $this->excel->getActiveSheet()->setCellValue('A1',$this->config->item("PT"));
        $this->excel->getActiveSheet()->setCellValue('A2', $this->config->item("ALAMAT")); 
        $this->excel->getActiveSheet()->setCellValue('A3', 'Telp. '.$this->config->item("TELP").'- Fax. '.$this->config->item("FAX")); 
        $this->excel->getActiveSheet()->setCellValue('A4', 'Email : '.$this->config->item("EMAIL")); 
        $this->excel->getActiveSheet()->getStyle('A1:A4')->applyFromArray($bold);
        $this->excel->getActiveSheet()->getStyle('A1:A4')->getFont()->setSize(8);;
        
        $this->excel->getActiveSheet()->setCellValue('A6','NO');
        $this->excel->getActiveSheet()->setCellValue('B6','USER');
        $this->excel->getActiveSheet()->setCellValue('C6','BRANCH');
        $this->excel->getActiveSheet()->setCellValue('D6','CHECKIN DATE');
        $this->excel->getActiveSheet()->setCellValue('E6','CHECKIN LOCATION');
        $this->excel->getActiveSheet()->setCellValue('F6','CHECKOUT DATE');
        $this->excel->getActiveSheet()->setCellValue('G6','CHECKOUT LOCATION');
        $this->excel->getActiveSheet()->getStyle('A6:G6')->applyFromArray($bold);
		
        $this->load->model('L_absen_model');
    	$data = $this->L_absen_model->get_datatables();
//    	echo json_encode($data,JSON_NUMERIC_CHECK);
        
        $no=1;
        $r=7;
        foreach ($data as $row) {
            $this->excel->getActiveSheet()->setCellValue('A'.$r, $no);
            $this->excel->getActiveSheet()->setCellValue('B'.$r, $row['nama_user']);
            $this->excel->getActiveSheet()->setCellValue('C'.$r, $row['nama_branch']);
            $this->excel->getActiveSheet()->setCellValue('D'.$r, $row['in_date']);
            $this->excel->getActiveSheet()->setCellValue('E'.$r, $row['latin']);
            $this->excel->getActiveSheet()->setCellValue('F'.$r, $row['out_date']);
            $this->excel->getActiveSheet()->setCellValue('G'.$r, $row['latout']);
            $r++;
            $no++;
        }
        
        $filename='ABSEN.xlsx';
        //header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
		ob_end_clean();

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
    }
    
    public function excel_(){
        
        $this->load->library('Excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $this->excel->getActiveSheet()->setTitle('DATA');
        
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getDefaultStyle()->getFont()->setName('Helvetica');
        $this->excel->getDefaultStyle()->getFont()->setSize(8); 
        
        $border = array(
            'borders' => array(
                'top'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN),
                'bottom'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN),
                'left'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN),
                'right'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN)
            )
        );
        
        $borderBold = array(
            'borders' => array(
                'top'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN),
                'bottom'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN),
                'left'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN),
                'right'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN)
            ),
            'font' => array('bold'=>true)
        );
        
        $borderBoldCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN),
                'bottom'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN),
                'left'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN),
                'right'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN)
            ),
            'font' => array('bold'=>true)
        );
        
        $right = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        
        $rightBorder = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN),
                'bottom'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN),
                'left'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN),
                'right'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN)
            )
        );
        
        $rightBorderBold = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN),
                'bottom'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN),
                'left'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN),
                'right'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN)
            ),
            'font' => array('bold'=>true)
        );
        
        $center = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        
        $centerBorder = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN),
                'bottom'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN),
                'left'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN),
                'right'=> array('style'=>  PHPExcel_Style_Border::BORDER_THIN)
            )
        );
        
        $centerBold = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'font' => array('bold'=>true)
        );
        
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

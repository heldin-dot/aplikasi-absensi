<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
class Cuti extends MY_Controller {

    function __construct() {
        parent::__construct();
        
        //$this->kode_transaksi = "USER";

        $mdl = "L_cuti_model";
        $this->model_name = $mdl;
        $this->load->model($mdl);
        $this->model = $this->$mdl;
        $this->table = "cuti";
        $this->pkField = "id_cuti";
        $this->uniqueFields = array("id_cuti");

        //pair key value (field => TYPE)
        //TYPE: EMAIL/STRING/INT/FLOAT/BOOLEAN/DATE/PASSWORD/URL/IP/MAC/RAW/DATA
        $this->fields = array(
            "nama_user" => array("TIPE" => "STRING", "LABEL" => "Menu Name"),
            "nama_branch" => array("TIPE" => "STRING", "LABEL" => "Menu Name"),
            "tujuan" => array("TIPE" => "STRING", "LABEL" => "Sort"),
            "darurat" => array("TIPE" => "STRING", "LABEL" => "Sort"),
            "atasan1" => array("TIPE" => "STRING", "LABEL" => "URL"),
            "telp1" => array("TIPE" => "STRING", "LABEL" => "URL"),
            "atasan2" => array("TIPE" => "STRING", "LABEL" => "URL"),
            "telp2" => array("TIPE" => "STRING", "LABEL" => "URL"),
            "handle" => array("TIPE" => "STRING", "LABEL" => "URL"),
            "tgl_mulai" => array("TIPE" => "DATE", "LABEL" => "URL"),
            "tgl_akhir" => array("TIPE" => "DATE", "LABEL" => "URL"),
            "status" => array("TIPE" => "CUTI", "LABEL" => "Sort"),
           
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
        $this->excel->getActiveSheet()->setCellValue('D6','TUJUAN');
        $this->excel->getActiveSheet()->setCellValue('E6','NO DARURAT');
        $this->excel->getActiveSheet()->setCellValue('F6','ATASAN 1');
        $this->excel->getActiveSheet()->setCellValue('G6','TELP 1');
        $this->excel->getActiveSheet()->setCellValue('H6','ATASAN 2');
        $this->excel->getActiveSheet()->setCellValue('I6','TELP 2');
        $this->excel->getActiveSheet()->setCellValue('J6','DI HANDLE OLEH');
        $this->excel->getActiveSheet()->setCellValue('K6','TANGGAL IZIN');
        $this->excel->getActiveSheet()->setCellValue('L6','SAMPAI');
        $this->excel->getActiveSheet()->setCellValue('M6','STATUS');
        $this->excel->getActiveSheet()->getStyle('A6:M6')->applyFromArray($bold);
		
        $this->load->model('L_cuti_model');
    	$data = $this->L_cuti_model->get_datatables();
//    	echo json_encode($data,JSON_NUMERIC_CHECK);
        
        $no=1;
        $r=7;
        foreach ($data as $row) {
            if($row['status']==1){
                $status = 'TOLAK';
            }else if($row['status']==2){
                $status = 'TERIMA';
            }else{
                $status = 'PENDING';
            }
            $this->excel->getActiveSheet()->setCellValue('A'.$r, $no);
            $this->excel->getActiveSheet()->setCellValue('B'.$r, $row['nama_user']);
            $this->excel->getActiveSheet()->setCellValue('C'.$r, $row['nama_branch']);
            $this->excel->getActiveSheet()->setCellValue('D'.$r, $row['tujuan']);
            $this->excel->getActiveSheet()->setCellValue('E'.$r, $row['darurat']);
            $this->excel->getActiveSheet()->setCellValue('F'.$r, $row['atasan1']);
            $this->excel->getActiveSheet()->setCellValue('G'.$r, $row['telp1']);
            $this->excel->getActiveSheet()->setCellValue('H'.$r, $row['atasan2']);
            $this->excel->getActiveSheet()->setCellValue('I'.$r, $row['telp2']);
            $this->excel->getActiveSheet()->setCellValue('J'.$r, $row['handle']);
            $this->excel->getActiveSheet()->setCellValue('K'.$r, $row['tgl_mulai']);
            $this->excel->getActiveSheet()->setCellValue('L'.$r, $row['tgl_akhir']);
            $this->excel->getActiveSheet()->setCellValue('M'.$r, $status);
            $r++;
            $no++;
        }
        
        $filename='CUTI.xlsx';
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

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
}

class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		
	}

	// Page footer
	public function Footer() {
		
		
		$this->SetY(-5);
		$this->SetFont('helvetica', 'I', 8);
		$this->Cell(0, 5, 'Hal. '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

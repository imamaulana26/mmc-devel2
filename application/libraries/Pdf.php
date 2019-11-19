<?php defined('BASEPATH') or exit('No direct script access allowed');
include_once APPPATH . '/third_party/fpdf/fpdf.php';
class Pdf extends FPDF
{

    function __construct($orientation = 'L', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
        date_default_timezone_set('Asia/Jakarta');
    }

    function Header()
    {
        global $title;
        // Logo
        $this->Image('./assets/images/logo-bsm.png', 170, 6, 30);
        $lebar = $this->w;
        $this->SetFont('Times', 'B', 15);
        $w = $this->GetStringWidth($title);
        $this->SetX(($lebar - $w) / 2);
        $this->Cell($w, 9, $title, 0, 1, 'C');
        $this->Ln();
        $this->line($this->GetX(), $this->GetY(), $this->GetX() + $lebar - 20, $this->GetY());
        $this->Ln(5);
        
        // set header table
        // $this->Cell(25);
        // $this->SetFont('Times', 'B', 12);
        // $this->Cell(10, 6, 'No', 1, 0, 'C');
        // $this->Cell(35, 6, 'Kode Cabang', 1, 0, 'C');
        // $this->Cell(80, 6, 'Nama Cabang', 1, 0, 'C');
        // $this->Cell(80, 6, 'Nama Area', 1, 0, 'C');
        // $this->Cell(20, 6, 'Region', 1, 1, 'C');
    }


    function Footer()
    {
        $this->SetY(-15);
        $lebar = $this->w;
        $this->SetFont('Times', '', 10);
        $this->line($this->GetX(), $this->GetY(), $this->GetX() + $lebar - 20, $this->GetY());
        $this->SetY(-15);
        $this->SetX(0);
        $this->Ln(1);
        $hal = 'Page : ' . $this->PageNo() . '/{nb} | Multiposting Murabahah Channeling';
        $this->Cell($this->GetStringWidth($hal), 10, $hal);
        $tanggal  = 'Printed : ' . date('d-m-Y  H:i:s') . ' ';
        $this->Cell($lebar - $this->GetStringWidth($hal) - $this->GetStringWidth($tanggal) - 20);
        $this->Cell($this->GetStringWidth($tanggal), 10, $tanggal);
    }
}

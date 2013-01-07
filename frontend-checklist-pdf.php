<?php
require('fpdf/fpdf.php');
@session_start();

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('times','',20);
$pdf->Cell(0,20, utf8_decode($_SESSION['frontend-checklist-pdf-title']), 0, 1, 'C');

$pdf->SetFont('times','',16);
foreach($_SESSION['frontend-checklist-items'] as $item) {
	$pdf->Cell(5,5,' ', 1, 0); //checkbox
	$pdf->Cell(0,5,' '.utf8_decode(strip_tags(htmlspecialchars_decode($item['text']))), 0, 1); //text
	$pdf->Cell(10,5,' ', 0, 1); //margin between checkboxes
}

$pdf->Output();
?>
<?php
require('chinese.php');

$pdf=new PDF_Chinese();
$pdf->AddBig5Font();
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Big5','',20);
$pdf->Write(10,'�E�Q���Ǧ~�פj�Ǻ¿�J�ǩۥ�');
$pdf->Output();
?>

<?php
require('chinese.php');

$pdf=new PDF_Chinese();
$pdf->AddBig5Font();
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Big5','',20);
$pdf->Write(10,'九十五學年度大學甄選入學招生');
$pdf->Output();
?>

<?php
require_once('TCPDF-main/tcpdf.php');

// Recoger los datos enviados
$useremail = $_GET['useremail'];
$vhid = $_GET['vhid'];
$fromdate = $_GET['fromdate'];
$todate = $_GET['todate'];
$message = $_GET['message'];

// Generación del PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nombre de tu Empresa');
$pdf->SetTitle('Reporte de Reserva');
$pdf->AddPage();

$html = '<h1>Reporte de Reserva</h1>
         <h2>Detalles de la Reserva</h2>
         <p><b>Cliente:</b> ' . $useremail . '</p>
         <p><b>Vehículo:</b> ' . $vhid . '</p>
         <p><b>Desde:</b> ' . $fromdate . '</p>
         <p><b>Hasta:</b> ' . $todate . '</p>
         <p><b>Mensaje:</b> ' . $message . '</p>';


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('reporte_reserva.pdf', 'I');

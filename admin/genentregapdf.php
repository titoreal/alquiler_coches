<?php
require_once('../TCPDF-main/tcpdf.php');
require_once('includes/config.php');

// Obtiene el ID de la reserva
$bookingId = isset($_GET['bookingId']) ? intval($_GET['bookingId']) : 0;

// Consulta a la base de datos para obtener los detalles de la reserva y del vehículo
$sql = "SELECT b.*, v.VehiclesTitle, v.VehiclesBrand, v.PricePerDay, v.FuelType, v.ModelYear, v.SeatingCapacity, v.Vimage1
        FROM tblbooking b
        JOIN tblvehicles v ON b.VehicleId = v.id
        WHERE b.id = :bookingId";
$query = $dbh->prepare($sql);
$query->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
$query->execute();
$result = $query->fetch(PDO::FETCH_OBJ);

if ($result) {
    // Calcular la cantidad de días y el importe total
    $fromDate = DateTime::createFromFormat('d/m/Y', $result->FromDate);
    $toDate = DateTime::createFromFormat('d/m/Y', $result->ToDate);
    $interval = $fromDate->diff($toDate);
    $numDays = $interval->days;
    $totalAmount = $numDays * $result->PricePerDay;

    // Crear el PDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Nombre de tu Empresa');
    $pdf->SetTitle('Reporte de Entrega de Vehículo');
    $pdf->AddPage();

    // Contenido del PDF
    $html = "<h1>Reporte de Entrega de Vehículo</h1>
             <h2>Detalles de la Reserva</h2>
             <p><b>ID de Reserva:</b> {$result->id}</p>
             <p><b>Email del Cliente:</b> {$result->userEmail}</p>
             <p><b>ID del Vehículo:</b> {$result->VehicleId}</p>
             <p><b>Vehículo:</b> {$result->VehiclesTitle}</p>
             <p><b>Desde:</b> {$result->FromDate}</p>
             <p><b>Hasta:</b> {$result->ToDate}</p>
             <p><b>Mensaje:</b> {$result->message}</p>
             <p><b>Estado:</b> {$result->Status}</p>
             <p><b>Fecha de Publicación:</b> {$result->PostingDate}</p>
             <p><b>Precio por Día:</b> {$result->PricePerDay}</p>
             <p><b>Tipo de Combustible:</b> {$result->FuelType}</p>
             <p><b>Año del Modelo:</b> {$result->ModelYear}</p>
             <p><b>Capacidad de Asientos:</b> {$result->SeatingCapacity}</p>
             <p><b>Importe Total:</b> $" . number_format($totalAmount, 2) . "</p>";

    // Agregar espacio para la firma
    $html .= "<p><b>Firma del Cliente:</b> _______________________________</p>
                       <p><b>Fecha:</b> " . date('d/m/Y') . "</p>";
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('reporte_entrega_vehiculo.pdf', 'I');
} else {
    echo "Reserva no encontrada.";
}

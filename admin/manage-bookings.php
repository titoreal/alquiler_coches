<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_REQUEST['eid'])) {
        $eid = intval($_GET['eid']);
        $status = "2";
        $currentDate = date('Y-m-d H:i:s'); // Fecha y hora actual

        $sql = "UPDATE tblbooking SET Status=:status, PostingDate=:postingDate WHERE id=:eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':postingDate', $currentDate, PDO::PARAM_STR);
        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
        $query->execute();

        $msg = "Reserva cancelada ";
    }

    if (isset($_REQUEST['aeid'])) {
        $aeid = intval($_GET['aeid']);
        $status = 1;
        $currentDate = date('Y-m-d H:i:s'); // Fecha y hora actual

        $sql = "UPDATE tblbooking SET Status=:status, PostingDate=:postingDate WHERE id=:aeid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':postingDate', $currentDate, PDO::PARAM_STR);
        $query->bindParam(':aeid', $aeid, PDO::PARAM_STR);
        $query->execute();

        $msg = "Reserva confirmada satisfactoriamente";
    }

    if (isset($_REQUEST['deid'])) {
        $deid = intval($_GET['deid']);
        $status = 3; // Estado Entregado
        $currentDate = date('Y-m-d H:i:s'); // Fecha y hora actual

        $sql = "UPDATE tblbooking SET Status=:status, PostingDate=:postingDate WHERE id=:deid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':postingDate', $currentDate, PDO::PARAM_STR);
        $query->bindParam(':deid', $deid, PDO::PARAM_STR);
        $query->execute();

        $msg = "Vehículo entregado en alquiler";
    }

    if (isset($_REQUEST['reid'])) {
        $reid = intval($_GET['reid']);
        $status = 4; // Estado Recibido
        $currentDate = date('Y-m-d H:i:s'); // Fecha y hora actual

        $sql = "UPDATE tblbooking SET Status=:status, PostingDate=:postingDate WHERE id=:reid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':postingDate', $currentDate, PDO::PARAM_STR);
        $query->bindParam(':reid', $reid, PDO::PARAM_STR);
        $query->execute();

        $msg = "Vehículo devuelto en agencia";
    }

?>


<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <title>Portal de Renta de Vehículos |Administrador: Manejo de Reservas </title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!-- Bootstrap social button library -->
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <!-- Bootstrap file input -->
    <link rel="stylesheet" href="css/fileinput.min.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <!-- Admin Stye -->
    <link rel="stylesheet" href="css/style.css">
    <style>
    .errorWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #dd3d36;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }

    .succWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #5cb85c;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }
    </style>

</head>

<body>
    <?php include('includes/header.php'); ?>

    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">

                        <h2 class="page-title">Administarción de Reservas</h2>

                        <!-- Zero Configuration Table -->
                        <div class="panel panel-default">
                            <div class="panel-heading">Información de Reservas</div>
                            <div class="panel-body">
                                <?php if ($error) { ?><div class="errorWrap">
                                    <strong>ERROR</strong>:<?php echo htmlentities($error); ?>
                                </div><?php } else if ($msg) { ?><div class="succWrap">
                                    <strong>ÉXITO</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
                                <table id="zctb" class="display table table-striped table-bordered table-hover"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Vehículo</th>
                                            <th>Desde</th>
                                            <th>Hasta</th>
                                            <th>Mensaje</th>
                                            <th>Estatus</th>
                                            <th>Fecha de Publicación</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Vehículo</th>
                                            <th>Desde</th>
                                            <th>Hasta</th>
                                            <th>Mensaje</th>
                                            <th>Estatus</th>
                                            <th>Fecha de Publicación</th>
                                            <th>Acción</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                            $sql = "SELECT tblusers.FullName, tblbrands.BrandName, tblvehicles.VehiclesTitle, tblbooking.FromDate, tblbooking.ToDate, tblbooking.message, tblbooking.VehicleId as vid, tblbooking.Status, tblbooking.PostingDate, tblbooking.id from tblbooking join tblvehicles on tblvehicles.id = tblbooking.VehicleId join tblusers on tblusers.EmailId = tblbooking.userEmail join tblbrands on tblvehicles.VehiclesBrand = tblbrands.id";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) { ?>
                                        <tr>
                                            <td><?php echo htmlentities($cnt); ?></td>
                                            <td><?php echo htmlentities($result->FullName); ?></td>
                                            <td><a href="edit-vehicle.php?id=<?php echo htmlentities($result->vid); ?>"><?php echo htmlentities($result->BrandName); ?>,
                                                    <?php echo htmlentities($result->VehiclesTitle); ?></a></td>
                                            <td><?php echo htmlentities($result->FromDate); ?></td>
                                            <td><?php echo htmlentities($result->ToDate); ?></td>
                                            <td><?php echo htmlentities($result->message); ?></td>
                                            <td>
                                                <?php
                                                            switch ($result->Status) {
                                                                case 0:
                                                                    echo 'Sin confirmar';
                                                                    break;
                                                                case 1:
                                                                    echo 'Confirmada';
                                                                    break;
                                                                case 2:
                                                                    echo 'Cancelada';
                                                                    break;
                                                                case 3:
                                                                    echo 'Entregado';
                                                                    break;
                                                                case 4:
                                                                    echo 'Recibido';
                                                                    break;
                                                            }
                                                            ?>
                                            </td>
                                            <td><?php echo htmlentities($result->PostingDate); ?></td>
                                            <td>
                                                <?php if ($result->Status == 0) { ?>
                                                <a href="manage-bookings.php?aeid=<?php echo htmlentities($result->id); ?>"
                                                    onclick="return confirm('¿Desea confirmar ésta reserva?')">Confirmar</a>
                                                /
                                                <a href="manage-bookings.php?eid=<?php echo htmlentities($result->id); ?>"
                                                    onclick="return confirm('¿Desea cancelar ésta reserva?')">Cancelar</a>
                                                <?php } elseif ($result->Status == 1) { ?>
                                                <a href="manage-bookings.php?deid=<?php echo htmlentities($result->id); ?>"
                                                    onclick="return confirm('¿Confirmar entrega del vehículo?')">Entregar</a>
                                                <script>
                                                document.querySelector(
                                                    "[href='manage-bookings.php?deid=<?php echo htmlentities($result->id); ?>']"
                                                    ).addEventListener("click", function(event) {
                                                    event.preventDefault();
                                                    window.open(
                                                        'genentregapdf.php?bookingId=<?php echo htmlentities($result->id); ?>',
                                                        '_blank');
                                                    window.location.href = this.href;
                                                });
                                                </script>
                                                <?php } elseif ($result->Status == 3) { ?>
                                                <a href="manage-bookings.php?reid=<?php echo htmlentities($result->id); ?>"
                                                    onclick="return confirm('¿Confirmar recepción del vehículo?')">Recibir</a>
                                                <?php } elseif ($result->Status == 4) { ?>
                                                <span>Concluido</span>
                                                <!-- Mensaje cuando la reserva esté completamente cerrada -->
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php $cnt++;
                                                }
                                            } ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>



                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
<?php } ?>
<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin']) == 0) {	
    header('location:index.php');
} else {
    if(isset($_POST['updateprofile'])) {
        $userid = intval($_GET['id']);
        $fullname = $_POST['fullname'];
        $emailid = $_POST['emailid'];
        $contactno = $_POST['contactno'];
        $dob = $_POST['dob'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $country = $_POST['country'];

        $sql = "UPDATE tblusers SET FullName=:fullname, EmailId=:emailid, ContactNo=:contactno, dob=:dob, Address=:address, City=:city, Country=:country WHERE id=:userid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fullname', $fullname, PDO::PARAM_STR);
        $query->bindParam(':emailid', $emailid, PDO::PARAM_STR);
        $query->bindParam(':contactno', $contactno, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->bindParam(':country', $country, PDO::PARAM_STR);
        $query->bindParam(':userid', $userid, PDO::PARAM_STR);
        $query->execute();
        $msg = "Información del usuario actualizada satisfactoriamente";
    }

    $userid = intval($_GET['id']);
    $sql = "SELECT * from tblusers WHERE id=:userid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':userid', $userid, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
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
	
	<title>Portal de Renta de Autos | Administrador: Crear Marca</title>

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
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>

</head>
<body>
    <?php include('includes/header.php');?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php');?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Editar Información del Usuario</h2>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <?php if($msg) { ?>
                                    <div class="succWrap"><strong>ÉXITO</strong>:<?php echo htmlentities($msg); ?> </div>
                                <?php } ?>
                                <form method="post" class="form-horizontal">
                                    <!-- Aquí van los campos del formulario -->
                                    <div class="form-group">
              <label class="control-label">Nombre Completo</label>
              <input class="form-control white_bg" name="fullname" value="<?php echo htmlentities($result->FullName);?>" id="fullname" type="text"  required>
            </div>
            <div class="form-group">
              <label class="control-label">Email </label>
              <input class="form-control white_bg" value="<?php echo htmlentities($result->EmailId);?>" name="emailid" id="emaiid" type="email" required>
            </div>
            <div class="form-group">
              <label class="control-label">Teléfono</label>
              <input class="form-control white_bg" name="contactno" value="<?php echo htmlentities($result->ContactNo);?>" id="contactno" type="text" required>
            </div>
            <div class="form-group">
              <label class="control-label">Fecha de Nacimiento&nbsp;(dd/mm/aaaa)</label>
              <input class="form-control white_bg" value="<?php echo htmlentities($result->dob);?>" name="dob" placeholder="dd/mm/aaaa" id="dob" type="text" >
            </div>
            <div class="form-group">
              <label class="control-label">Su dirección</label>
              <textarea class="form-control white_bg" name="address" rows="4" ><?php echo htmlentities($result->Address);?></textarea>
            </div>
            <div class="form-group">
              <label class="control-label">País</label>
              <input class="form-control white_bg"  id="country" name="country" value="<?php echo htmlentities($result->Country);?>" type="text">
            </div>
            <div class="form-group">
              <label class="control-label">Ciudad</label>
              <input class="form-control white_bg" id="city" name="city" value="<?php echo htmlentities($result->City);?>" type="text">
            </div>         
           
           <div class="form-group">
             <button type="submit" name="updateprofile" class="btn">Guardar Cambios <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
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


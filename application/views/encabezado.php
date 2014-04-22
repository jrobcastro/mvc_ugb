<!DOCTYPE html> 
<html lang="en"> 
	<head> 
		<base href="<?php echo base_url(); ?>">
		<meta charset="utf-8"> 
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title>Activo fijo | UGB</title> 
		<!-- Bootstrap --> 
		<link href="css/bootstrap.min.css" rel="stylesheet"> 
		<!-- JQUERY UI --> 
		<link href="css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet"> 
		<link href="css/smoothness/jquery-ui-1.10.4.custom.min.css" rel="stylesheet"> 
	</head> 
	 
	<body> 
 
		<div class="page-header"> 
  			<center><h1>Activos Fijos <small>Universidad General Gerardo Barrios</small></h1></center> 
		</div> 
 
		<p class="navbar-text navbar-right"><?php echo(isset($usuario)&&$usuario!=false)?'Bienvenido:'.$usuario['nombre']:'' ?> <?php echo(isset($usuario)&&$usuario!=false)?"<a href='acceso/salir' class='navbar-link'>Salir</a>":''; ?></p> 
 
		<!-- DIALOGO --> 
		<div id="dialogo" style="display:none;"><div class="notify"></div></div> 
 
		<!-- ALERTA --> 
		<div class="col-md-4 col-md-offset-4" style="position:fixed;" id="msj"></div>

<!DOCTYPE html>
<html >
		<head>
			<meta charset="UTF-8">
			<link rel="icon" href="http://cellaron.com/media/wysiwyg/zte-mwc-2015-8-l-124x124.png">
			<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/loginStyle.css"/>
			<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/sweetalert/dist/sweetalert.css" />
			<script src="<?php echo base_url(); ?>assets/css/sweetalert/dist/sweetalert.min.js"></script>
			<title>ZTE Fonade Proyect</title>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
			<script type="text/javascript" charset="utf-8" async defer>
					function showMessage(){
							sweetAlert("Error de autentificación", "Por favor verificar los datos", "error");
					}
			</script>
		</head>

		<body>
			<div class="body"></div>
				<div class="grad"></div>
				<div class="header">
					<div>ZTE - FONADE Project</div>
				</div>
				<br>
				<form id="login" action="ArcadiaLogin_submit" method="post" accept-charset="utf-8" >
				<div class="login">
						<input type="text" placeholder="Usuario" name="user" required><br>
						<input type="password" placeholder="Password" name="password" required><br>
						<input type="submit" class="button" onclick = 'this.form.action = "<?php echo base_url() ?>User/loginUser"' value="Ingresar">
				</div>
				<?php
				if (isset($user)) {
					if ($user == "Error de informacion"){
						echo '<script type="text/javascript">showMessage();</script>';
					}
				}
				?>
			<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
		</body>
</html>
<?php  ?>
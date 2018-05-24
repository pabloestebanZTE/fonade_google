<!DOCTYPE html>
<html lang="en">
<head>
<title>Creación Otros Tickets</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<link rel="icon" href="http://cellaron.com/media/wysiwyg/zte-mwc-2015-8-l-124x124.png">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/zerogrid.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/forms.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/wheelmenu.css">
<link href="<?php echo base_url(); ?>assets/css/index.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/sweetalert/dist/sweetalert.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsiveslides.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/etiqueta.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oleo+Script:400,700" >
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Teko:400,700">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.6.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/cufon-yui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/cufon-replace.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/Swis721_Cn_BT_400.font.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/Swis721_Cn_BT_700.font.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tms-0.3.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tms_presets.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jcarousellite.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/script.js"></script>
<script src="<?php echo base_url(); ?>assets/js/css3-mediaqueries.js"></script>
<script src="<?php echo base_url(); ?>assets/js/responsiveslides.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tabs.js"></script>
<script src="<?php echo base_url(); ?>assets/css/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.wheelmenu.js"></script>

<script>
    var cantidadTec = 0;
    $(document).ready(function(){
      $(".wheel-button").wheelmenu({
        trigger: "hover",
        animation: "fly",
        animationSpeed: "fast"
      });
    });

    function showMessage(){

        var a = "<?php echo $msj[0]; ?>";
        var b = "<?php echo $msj[1]; ?>";
        var c = "<?php echo $msj[2]; ?>";
        sweetAlert(a, b, c);
    }

    function fillInputs(){
      var e = document.getElementById("pvd");
      var valorOption = e.options[e.selectedIndex].value;
      var res = valorOption.split("/");
      document.getElementById("dep-cit").value = res[1]+" / "+res[2];
      document.getElementById("direccion").value = res[3];
      document.getElementById("tipologia").value = res[4];
      document.getElementById("Administrador").value = res[5];
      document.getElementById("CAdministrador").value = res[6];

      console.log(valorOption);
    }

    function añadirTec(){
      var select = document.getElementById("tec-0");
      var div = document.getElementById("divTec");
      var select2 = select.cloneNode(true);
      cantidadTec++;
      select2.id = "tec-"+cantidadTec;
      select2.name = "tec-"+cantidadTec;
      div.appendChild(select2);
    }

    function arreglarForm(){
    var valorOption = 7;
    console.log(valorOption);
    var fechaInicio = document.getElementById("date");
    var fechaFin = document.getElementById("dateF");
    var labelFecha = document.getElementById("labelFecha");
    var labelFechaF = document.getElementById("labelFechaF");
    var labelTec = document.getElementById("labelTec");
    var selectTec = document.getElementById("tec-0");
    var BEditar = document.getElementById("BEditar");
    var tipoSelect = document.getElementById("tipoSelect");
    var selectTipo = document.getElementById("selectTipo");
    var labelCCC = document.getElementById("labelCCC");
    var fieldCCC = document.getElementById("fieldCCC");

    if(valorOption == 6){
      fechaInicio.style.display = 'none';
      fechaFin.style.display = 'none';
      labelFecha.style.display = 'none';
      labelFechaF.style.display = 'none';
      labelTec.style.display = 'none';
      selectTec.style.display = 'none';
      BEditar.style.display = 'none';
      selectTipo.style.display = 'block';
      tipoSelect.style.display = 'block';
      labelCCC.style.display = 'block';
      fieldCCC.style.display = 'block';
      document.getElementById("date").required="";
      document.getElementById("dateF").required="";
      document.getElementById("fieldCCC").required="required";
    } else {
      fechaInicio.style.display = 'block';
      fechaFin.style.display = 'block';
      labelFecha.style.display = 'block';
      labelFechaF.style.display = 'block';
      labelTec.style.display = 'block';
      selectTec.style.display = 'block';
      BEditar.style.display = 'block';
      selectTipo.style.display = 'none';
      tipoSelect.style.display = 'none';
      labelCCC.style.display = 'none';
      fieldCCC.style.display = 'none';
      document.getElementById("date").required="required";
      document.getElementById("dateF").required="required";
      document.getElementById("fieldCCC").required="";
    }
    if(valorOption == 7){
      fechaInicio.style.display = 'block';
      fechaFin.style.display = 'block';
      labelFecha.style.display = 'block';
      labelFechaF.style.display = 'block';
      labelTec.style.display = 'block';
      selectTec.style.display = 'block';
      BEditar.style.display = 'block';
      selectTipo.style.display = 'none';
      tipoSelect.style.display = 'none';
      labelCCC.style.display = 'block';
      fieldCCC.style.display = 'block';
      document.getElementById("date").required="required";
      document.getElementById("dateF").required="required";
      document.getElementById("fieldCCC").required="";
    }
  }
</script>

</head>
<body id="page1">
<div class="body1">
	<div class="body2">
  <div class="body5">
		<div class="main zerogrid">
<!-- header -->
			<header>
				<div class="wrapper row">
				<h1><a id="logo"><img src="<?php echo base_url(); ?>assets/images/logo.png" /></a></h1>
				<nav>
					<ul id="menu">
          	<?php
							if ($_SESSION['permissions'] != NULL){
                echo "<li id='nav1'><a href='".base_url()."User/loadPrincipalView'>Bienvenid@<span>".$_SESSION['name']."</span></a></li>";
								if($_SESSION['permissions'][3] == 1){
									echo "<li id='nav3'><a href='#'>PVD<span>HV</span></a></li>";
								}
								if($_SESSION['permissions'][1] == 1){
									echo "<li id='nav4'><a href='".base_url()."Mantenimientos/loadMPView'>Preventivos<span>Mantenimientos</span></a></li>";
								}
								if($_SESSION['permissions'][2] == 1){
									echo "<li id='nav4'><a href='".base_url()."MCorrectivos/formMC'>Correctivos<span>Mantenimientos</span></a></li>";
								}
								if($_SESSION['permissions'][4] == 1){
                  echo "<li id='nav2'><a href='http://legalizaciones.us-west-2.elasticbeanstalk.com/?usuarioAdmin=".$_SESSION['id']."&passAdmin=".$_SESSION['pass']."'>legalizaciones<span>legalizaciones</span></a></li>";
                }
								if($_SESSION['permissions'][5] == 1){
                  echo "<li id='nav5'><a href='".base_url()."ZTEPlatform/platformZTE'>ZTE<span>Plataforma</span></a></li>";
								}
							}
            ?>
						<li id="nav6"><a href="<?php echo base_url(); ?>welcome/index">Salir<span>Logout</span></a></li>
					</ul>
				</nav>
				</div>
			</header>
<!-- header end-->
    </div>
		</div>
	</div>
</div>
	<div class="body3">
		<div class="main zerogrid">
<!-- content -->
			<article id="content">
        <div class="wrapper row">
          <?php
            if($_SESSION['permissions'][5] == 1){
              echo "<div class='wrapperWheel'>";
                echo "<div class='mainWheel'>";
                  echo "<a href='#wheel1' class='wheel-button nw'>";
                    echo "<span><img src='".base_url()."assets/images/plus.ico' /></span>";
                  echo "</a>";
                  echo "<ul id='wheel1'  data-angle='all'>";
                    echo "<li class='item'><div id='cae_texto'><a href='".base_url()."Ticket/OtherTicketsPrincipal'><img src='".base_url()."assets/images/return.png' /></a>Return</div></li>";
                  echo "</ul>";
                echo "</div>";
              echo "</div>";
              if ($msj != ""){
                echo "<script type='text/javascript'>showMessage();</script>";
              }
            }
            if($_SESSION['permissions'][11] == 1){
              echo "<section class='col-4-4'>";
                echo "<div class='wrap-col'>";
                  echo "<h2 class='under'>Creación de Tickets : Correctivos</h2>";
                    echo "<div class='wrapper tabs'>";
                    echo "<div id='tabPreventivos'>";
                    echo "<div class='form-style-5'>";
                      echo "<form  name='formulario' id='formulario' method='post' accept-charset='utf-8'>";
                        echo "<fieldset>";
                          echo "<legend><span class='number'>1</span> Información PVD</legend>";
                          echo "<label for='job'>ID PVD:</label>";
                          echo "<select id='pvd' name='pvd' onchange='fillInputs()'>";
                            echo "<option value='-1'></option>";
                            for($i = 0; $i<count($pvds); $i++){
                              echo "<option value='".$pvds[$i]->getId()."/".$pvds[$i]->getCity()."/".$pvds[$i]->getDepartment()."/".$pvds[$i]->getDireccion()."/".$pvds[$i]->getTipologia()."/".$pvds[$i]->getAdmin()['N_NAME']."/".$pvds[$i]->getAdmin()['I_PHONE']."'>".$pvds[$i]->getId()."</option>";
                            }
                          echo "</select>";
                          echo "<label for='job'>Departament / Ciudad:</label>";
                          echo "<input type='text' name='dep-cit'  id='dep-cit' value='' disabled='disabled'>";
                          echo "<label for='job'>Dirección:</label>";
                          echo "<input type='text' name='direccion'  id='direccion' value='' disabled='disabled'>";
                          echo "<label for='job'>Tipologia:</label>";
                          echo "<input type='text' name='tipologia'  id='tipologia' value='' disabled='disabled'>";
                          echo "<label for='job'>Nombre administrador:</label>";
                          echo "<input type='text' name='Administrador'  id='Administrador' value='' disabled='disabled'>";
                          echo "<label for='job'>Contacto administrador:</label>";
                          echo "<input type='text' name='CAdministrador'  id='CAdministrador' value='' disabled='disabled'>";

                          echo "<legend><span class='number'>2</span> Información Ticket</legend>";

                          echo "<select id='pvd' name='tipoC'>";
                            echo "<option value='Reposicion'>Reposicion</option>";
                            echo "<option value='Correctivo'>Correctivo</option>";
                          echo "</select>";
                          echo "<label for='job' id='labelFecha'>Fecha Inicio:</label>";
                          echo "<input type='date' name='date' id='date' placeholder='Fecha Inicio*' required>";
                          echo "<label for='job' id='labelFechaF'>Fecha Fin:</label>";
                          echo "<input type='date' name='dateF' id='dateF' placeholder='Fecha Fin*' required>";
                          echo "<label for='job' id='labelCCC' style='display: none;'>Ticket CCC:</label>";
                          echo "<input type='text' name='fieldCCC' id='fieldCCC' placeholder='Ticket CCC*' style='display: none;'>";
                          echo "<label for='job' id='tipoSelect' style='display: none;'>Tipo de Elemento:</label>";
                          echo "<select id='selectTipo' name='selectTipo' style='display: none;>";
                            echo "<option value='AA'>AA</option>";
                            echo "<option value='IT'>IT</option>";
                            echo "<option value='AA'>AA</option>";
                          echo "</select>";
                          echo "<label for='job' id='labelTec'>Nombre técnico(s):</label>";
                          echo "<div name='divTec' id='divTec'>";
                            echo "<select id='tec-0' name='tec-0' >";
                              echo "<option value='-1'></option>";
                              for($i = 0; $i<count($users); $i++){
                                echo "<option value='".$users[$i]->getName()." ".$users[$i]->getLastname()." / ".$users[$i]->getID()."'>".$users[$i]->getName()." ".$users[$i]->getLastname()."</option>";
                              }
                            echo "</select>";
                          echo "</div>";
                          echo "<button value='Añadir técnico' name='BEditar' id='BEditar' type='button' class='btn btn-primary' onclick= 'añadirTec()'>Añadir técnico</button><br><br>";

                          echo "<label for='job'>Observaciones :</label>";
                          echo "<textarea name='Observaciones' id='Observaciones' placeholder='Máximo 500 caracteres *'></textarea>";
                        echo "<input type='submit' value='Crear Ticket' class='btn btn-success' onclick =\"this.form.action = '".base_url()."Ticket/createCorrectiveTicket'\" >";
                      echo "</form>";
                    echo "</div>";
                  echo "</div>";
                echo "</div>";
              echo "</div>";
            echo "</section>";
            echo "<script>arreglarForm();</script>";

          } else {
            echo "<h2 class='under'>No tienes permisos para acceder a esta area</h2>";
          }
        ?>
        </div>
			</article>
		</div>
	</div>

		<div class="main zerogrid">
<!-- footer -->
<!-- footer end -->
		</div>
  <script type="text/javascript"> Cufon.now(); </script>
  <script>
    $(document).ready(function() {
      tabs.init();
    })
  </script>
</body>
</html>

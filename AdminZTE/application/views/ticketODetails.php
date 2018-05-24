<!DOCTYPE html>
<html lang="en">
<head>
<title>Creacion Tickets</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<link rel="icon" href="http://cellaron.com/media/wysiwyg/zte-mwc-2015-8-l-124x124.png">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/zerogrid.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/forms.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/wheelmenu.css">
<link href="<?php echo base_url(); ?>assets/css/index.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/sweetalert/dist/sweetalert.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsiveslides.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/multiTable.css">
<!--etiquetas de texto de iconos de menu-->
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
          if(isset($ticket)){
            echo "<section class='col-4-4'>";


            echo "<div class='wrapperWheel'>";
              echo "<div class='mainWheel'>";
                echo "<a href='#wheel1' class='wheel-button nw'>";
                  echo "<span><img src='".base_url()."assets/images/ticket2.png' /></span>";
                echo "</a>";
                echo "<ul id='wheel1'  data-angle='all'>";
                  echo "<li class='item'><div class='cae_texto'><a href='".base_url()."Ticket/OtherTicketsPrincipal'><img src='".base_url().">assets/images/return.png' /></a>Return</div></li>";
                echo "</ul>";
              echo "</div>";
            echo "</div>";


            echo "<h2 class='under'>Página principal Tickets Número: ".$ticket->getId()."</h2>";
              echo "<div class='wrap-col'>";
                echo "<div id='pricing-table' class='clear'>";

                        echo "<div class='plan' id='most-popular'>";
                            echo "<h3>Ticket<span><img src='".base_url()."assets/images/ticket2.png'/></span></h3>";
                            echo "<ul>";
                                echo "<li><b>ID: </b> ".$ticket->getId()."</li>";
                                echo "<li><b>Estado: </b> ".$ticket->getStatus()."</li>";
                                echo "<li><b>Fecha Inicio: </b> ".$ticket->getDateS()."</li>";
                                echo "<li><b>Fecha Fin: </b> ".$ticket->getDateF()."</li>";
                                echo "<li><b>Duración: </b> ".$ticket->getDuracion()."</li>";
                                echo "<li><b>PVD: </b>".$ticket->getColor()."</li>";
                                echo "<li><b>Observación: </b> ".$ticket->getObservacionesI()."</li>";
                            echo "</ul>";
                        echo "</div>";
                      
                    echo "<div class='plan' id='most-popular'>";
                        echo "<h3>Técnicos<span><img src='".base_url()."assets/images/tech.png'/></span></h3>";
                        echo "<ul>";
                          if (count($ticket->getTechs())>0){
                             for ($i=0; $i<count($ticket->getTechs()) ; $i++) { 
                                 echo  "<li><b>Nombre: </b>".$ticket->getTechs()[$i]->getName()." ".$ticket->getTechs()[$i]->getLastname()."</li>";
                              }                             
                          } else {
                            echo "<li><b> No hay personal asociado al ticket</b></li>";
                          }  
                        echo "</ul>";
                    echo "</div>";
                echo "</div>";
              echo "</div>";
            echo "</section>";
          }
        ?>
        </div>
			</article>
		</div>
	</div>		
</body>
</html>
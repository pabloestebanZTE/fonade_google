<!DOCTYPE html>
  <html lang="en">
  <head>
    <title>ZTE Plataforma</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="icon" href="http://cellaron.com/media/wysiwyg/zte-mwc-2015-8-l-124x124.png">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/reset.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/layout.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/zerogrid.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tablesStyles.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/wheelmenu.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/index.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/sweetalert/dist/sweetalert.css" />    
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/etiqueta.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oleo+Script:400,700" >
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Teko:400,700">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/cufon-yui.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/cufon-replace.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/Swis721_Cn_BT_400.font.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/Swis721_Cn_BT_700.font.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tabs.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/css3-mediaqueries.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/css/canvasJS/canvasjs.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/css/sweetalert/dist/sweetalert.min.js"></script>
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
    </script>
  </head>

  <body id="page4">

  	<div class="body1">
  	<div class="body2">
  	<div class="body5">
  		<div class="main zerogrid">
  <!-- header -->
  			<header>
          <br>
  				<div class="wrapper rơw">
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
                    echo "<li id='nav4'><a href='".base_url()."MCorrectivos/verMC'>Correctivos<span>Mantenimientos</span></a></li>";
                  }
                  if($_SESSION['permissions'][4] == 1){
									echo "<li id='nav2'><a href='http://legalizaciones.us-west-2.elasticbeanstalk.com/?usuarioAdmin=".$_SESSION['id']."&passAdmin=".$_SESSION['pass']."'>legalizaciones<span>legalizaciones</span></a></li>";
								}
                  if($_SESSION['permissions'][5] == 1){
                    echo "<li id='nav5' class='active'><a href='#''>ZTE<span>Plataforma</span></a></li>";
                  }
                }
              ?>
              <li id="nav6"><a href="<?php echo base_url(); ?>welcome/index">Salir<span>Logout</span></a></li>
  					</ul>
  				</nav>
  				</div>
  			</header>
  <!-- header end-->
  <!-- content -->
  		</div>
  	</div>
  	</div>
  	</div>
  	<div class="body3">
  		<div class="main zerogrid">
  			<article id="content">
  				<div class="wrapper">
            <?php
              if($_SESSION['permissions'][5] == 1){
                echo "<div class='wrapperWheel'>";
                  echo "<div class='mainWheel'>";
                    echo "<a href='#wheel1' class='wheel-button ne'>";
                      echo "<span><img src='".base_url()."assets/images/pvd.png' /></span>";
                    echo "</a>";
                    echo "<ul id='wheel1'  data-angle='all'>";
                      echo "<li class='item'><div class='cae_texto' id='cae_texto'><a href='".base_url()."User/loadPrincipalView'><img src='".base_url()."assets/images/return.png' /></a>Return</div></li>";
                    echo "</ul>";

                echo "<br><br><br><br><div class='wrapperWheel'>";
                  echo "<div class='mainWheel'>";
                    echo "<a href='#wheel' class='wheel-button'>";
                      echo "<span><img src='".base_url()."assets/images/home.png' /></span>";
                    echo "</a>";
                    echo "<div class='pointer'><center>Clic sobre mi</center></div>";
                    echo "<ul id='wheel'  data-angle='all'>";
                      echo "<li class='item'><div class='cae_texto' id='cae_texto'><a href='".base_url()."KPI/KPIPrincial'><img src='".base_url()."assets/images/KPI.png' /></a>KPI</div></li>";
                      echo "<li class='item'><div class='cae_texto' id='cae_texto'><a href='".base_url()."Ticket/TicketPrincipal'><img src='".base_url()."assets/images/ticket2.png' /></a><p>Ticket</p></div></li>";
                      echo "<li class='item'><div class='cae_texto' id='cae_texto'><a href=''#home'><img src='".base_url()."assets/images/process.png' /></a>Process</div></li>";
                      echo "<li class='item'><div class='cae_texto' id='cae_texto'><a href='".base_url()."User/detailByUser'><img src='".base_url()."assets/images/personal2.png' /></a>Personal</div></li>";
                      echo "<li class='item'><div class='cae_texto' id='cae_texto'><a href=''#home'><img src='".base_url()."assets/images/quality.png' /></a>Quality</div></li>";
                    echo "</ul>";
                  echo "</div>";
                echo "</div>";
                echo "<br><br><br><br><br><br>";
              }
             ?>
          </div>
  			</article>
  		</div>
  	</div>
  	<div class="body4">
  		<div class="main zerogrid">
  			<article id="content2">
  				<div class="wrapper row">

  				</div>
  			</article>
  <!-- content end -->
  		</div>
  	</div>
    <script type="text/javascript"> Cufon.now(); </script>
    <script>
    	$(document).ready(function() {
    		tabs.init();
    	})
    </script>
  </body>
</html>

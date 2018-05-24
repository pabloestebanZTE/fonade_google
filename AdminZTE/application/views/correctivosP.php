<!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Preventivos Principal</title>
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
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/etiqueta.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/sweetalert/dist/sweetalert.css" />
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
          var a = "<?php echo $msg[0]; ?>";
          var b = "<?php echo $msg[1]; ?>";
          var c = "<?php echo $msg[2]; ?>";
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
                      echo "<span><img src='".base_url()."assets/images/ticket2.png' /></span>";
                    echo "</a>";
                    echo "<ul id='wheel1'  data-angle='NE' class='wheel'>";
                      echo "<li class='item'><div class='cae_texto'><a href='".base_url()."Ticket/TicketPrincipal'><img src='".base_url()."assets/images/return.png' /></a>Return</div></li>";
                      echo "<li class='item'><div class='cae_texto'><a href='".base_url()."Ticket/CorrectiveCreation'><img src='".base_url()."assets/images/plus.ico' /></a>Plus</div></li>";
                    echo "</ul>";
                    echo "<br><br><br><br>";
                  echo "</div>";
                echo "</div>";
                echo "<br><br><br><br><br><br>";
              }
             ?>


             <div class="wrapper tabs">
               <?php
               if($_SESSION['permissions'][1] == 1){
                 if (isset($tickets)){
                   echo "<div id='tab"."1"."'>";
                     echo "<div class='wrapperTable'>";
                      echo "<table id='table'>";
                        echo "<thead>";
                          echo "<tr>";
                            echo "<th>Ticket</th>";
                            echo "<th>Tipo</th>";
                            echo "<th>Región</th>";
                            echo "<th>PVD</th>";
                            echo "<th>Departamento/Ciudad</th>";
                            echo "<th>Año</th>";
                            echo "<th>Mes</th>";
                          echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                           for ($i = 0; $i<count($tickets); $i++){
                             echo "<tr>";
                               echo "<td><a href='".base_url()."Ticket/ticketCorrectiveDetails?k_ticket=".$tickets[$i]->id."'>".$tickets[$i]->id."</a></td>";
                               echo "<td>".$tickets[$i]->dateStartIT."</td>";
                               echo "<td>".$tickets[$i]->idMaintenance->region."</td>";
                               echo "<td>".$tickets[$i]->idMaintenance->id."</td>";
                               echo "<td>".$tickets[$i]->idMaintenance->deparment." / ".$tickets[$i]->idMaintenance->city."</td>";
                               if (explode("-",$tickets[$i]->dateStart) != "0000"){
                                 echo "<td>".explode("-",$tickets[$i]->dateStart)[0]."</td>";
                               } else {
                                 echo "<td></td>";
                               }
                               $dateObj   = DateTime::createFromFormat('!m', explode("-",$tickets[$i]->dateStart)[1]);
                               if ($dateObj != "" && explode("-",$tickets[$i]->dateStart)[1] != "00"){
                                  echo "<td>".$dateObj->format('F')."</td>";
                               } else {
                                echo "<td></td>";
                               }
                            echo "</tr>";
                          }
                        echo "</tbody>";
                      echo "</table>";
                    echo "</div>";
                  echo "</div>";
                 }
                 if ($msg != ""){
                   echo "<script type='text/javascript'>showMessage();</script>";
                 }
               }
               ?>
             </div>
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
    <script src="<?php echo base_url(); ?>assets/js/tablefilter.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style/tablefilter.css">
    <script data-config>
      var filtersConfig = {
        base_path: '<?php echo base_url(); ?>assets/js/',
        filters_row_index: 1,
        alternate_rows: true,
        grid_cont_css_class: 'grd-main-cont',
        grid_tblHead_cont_css_class: 'grd-head-cont',
        grid_tbl_cont_css_class: 'grd-cont',
		    loader: true
      };
        var tf1 = new TableFilter('table', filtersConfig);
        tf1.init();
    </script>
  </body>
</html>

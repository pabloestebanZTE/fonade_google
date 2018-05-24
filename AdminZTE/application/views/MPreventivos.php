<!DOCTYPE html>
  <html lang="en">
  <head>
    <title>M. Preventivos</title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="icon" href="http://cellaron.com/media/wysiwyg/zte-mwc-2015-8-l-124x124.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/reset.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/layout.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/zerogrid.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/styleDropdown.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tablesStyles.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/style/tablefilter.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link href="https://fonts.googleapis.com/css?family=Oleo+Script:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Teko:400,700" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tablefilter.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/cufon-yui.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/cufon-replace.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/Swis721_Cn_BT_400.font.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/Swis721_Cn_BT_700.font.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tabs.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/css3-mediaqueries.js"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/css/canvasJS/canvasjs.min.js"></script> -->
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/css/canvasJS/charts/Charts.js"></script> -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/sweetalert/dist/sweetalert.css" />
    <script src="<?php echo base_url(); ?>assets/css/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" charset="utf-8" async defer>
    function modalEditar(idT){
      var ticket = <?php echo json_encode($PVDs); ?>;
      for(var i = 0; i < ticket.length ; i++){
        if(ticket[i].maintenance){
          for(var j = 0; j < ticket[i].maintenance.length; j++){
            if(ticket[i].maintenance[j].ticket){
              if(idT == ticket[i].maintenance[j].ticket[0].id){
                $('#idpvd').val("");
                $('#ciudad').val("");
                $('#departamento').val("");
                $('#region').val("");
                $('#direccion').val("");
                $('#tipo').val("");
                $('#idticket').val("");
                $('#estado').val("");
                $('#fechai').val("");
                $('#fechaf').val("");
                $('#duracion').val("");
                $('#fechaiit').val("");
                $('#fechafit').val("");
                $('#fechaiaa').val("");
                $('#fechafaa').val("");
                $('#tit').val("");
                $('#ait').val("");
                $('#taa').val("");
                $('#aaa').val("");

                $('#idpvd').val(ticket[i].id);
                $('#ciudad').val(ticket[i].city);
                $('#departamento').val(ticket[i].deparment);
                $('#region').val(ticket[i].region);
                $('#direccion').val(ticket[i].direccion);
                $('#tipo').val(ticket[i].tipologia);
                $('#idticket').val(ticket[i].maintenance[j].ticket[0].id);
                $('#estado').val(ticket[i].maintenance[j].ticket[0].status);
                if(ticket[i].maintenance[j].ticket[0].dateStart != "0000-00-00"){
                  $('#fechai').val(ticket[i].maintenance[j].ticket[0].dateStart);
                }
                if(ticket[i].maintenance[j].ticket[0].dateFinish != "0000-00-00"){
                  $('#fechaf').val(ticket[i].maintenance[j].ticket[0].dateFinish);
                }
                $('#duracion').val(ticket[i].maintenance[j].ticket[0].duracion);
                if(ticket[i].maintenance[j].ticket[0].dateStartIT != "0000-00-00"){
                  $('#fechaiit').val(ticket[i].maintenance[j].ticket[0].dateStartIT);
                }
                if(ticket[i].maintenance[j].ticket[0].dateFinishIT != "0000-00-00"){
                  $('#fechafit').val(ticket[i].maintenance[j].ticket[0].dateFinishIT);
                }
                if(ticket[i].maintenance[j].ticket[0].dateStartAA != "0000-00-00"){
                  $('#fechaiaa').val(ticket[i].maintenance[j].ticket[0].dateStartAA);
                }
                if(ticket[i].maintenance[j].ticket[0].dateFinishAA != "0000-00-00"){
                  $('#fechafaa').val(ticket[i].maintenance[j].ticket[0].dateFinishAA);
                }
                $("#link").attr("href", "<?php echo base_url(); ?>Ticket/ticketDetails?k_ticket="+ticket[i].maintenance[j].ticket[0].id);
                try {
                    $('#tit').val(ticket[i].maintenance[j].ticket[0].techs.users.IT_T.N_NAME+" "+ticket[i].maintenance[j].ticket[0].techs.users.IT_T.N_LASTNAME);
                } catch (e) {
                  console.log("no tit");
                }
                try {
                    $('#ait').val(ticket[i].maintenance[j].ticket[0].techs.users.IT_A.N_NAME+" "+ticket[i].maintenance[j].ticket[0].techs.users.IT_A.N_LASTNAME);
                } catch (e) {
                  console.log("no ait");
                }
                try {
                    $('#taa').val(ticket[i].maintenance[j].ticket[0].techs.users.AA_T.N_NAME+" "+ticket[i].maintenance[j].ticket[0].techs.users.AA_T.N_LASTNAME);
                } catch (e) {
                  console.log("no taa");
                }
                try {
                    $('#aaa').val(ticket[i].maintenance[j].ticket[0].techs.users.AA_A.N_NAME+" "+ticket[i].maintenance[j].ticket[0].techs.users.AA_A.N_LASTNAME);
                } catch (e) {
                  console.log("no aaa");
                }
                $('#myModal').modal('show');
              }
            }
          }
        }
      }
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
                    echo "<li id='nav4' class='active'><a>Preventivos<span>Mantenimientos</span></a></li>";
                  }
                  if($_SESSION['permissions'][2] == 1){
                    echo "<li id='nav4'><a href='#'>Correctivos<span>Mantenimientos</span></a></li>";
                  }
                  if($_SESSION['permissions'][4] == 1){
									echo "<li id='nav2'><a href='http://legalizaciones.us-west-2.elasticbeanstalk.com/?usuarioAdmin=".$_SESSION['id']."&passAdmin=".$_SESSION['pass']."'>legalizaciones<span>legalizaciones</span></a></li>";
								}
                  if($_SESSION['permissions'][5] == 1){
                    echo "<li id='nav5'><a href='".base_url()."ZTEPlatform/platformZTE'>ZTE<span>Plataforma</span></a></li>";
                  }
                }
              ?>
              <li id="nav6"><a href="<?php echo base_url(); ?>Welcome/index">Salir<span>Logout</span></a></li>
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
    <!-- graficas -->
    <div class="container">
        <article id="content" class="row bg-white">
          <div class="wrapper col-md-12">
            <h2 class="under">Información General</h2>
            <h3 class="under">Usuario: zte-fonade / Password: a4b3c2d1</h3>

            <!-- primera Grafica -->
            <section>
              <script type='text/javascript' src='http://181.49.46.6/javascripts/api/viz_v1.js'></script>
              <div class='tableauPlaceholder' style='width: 100%; height: 564px;'>
                <object class='tableauViz' width='100%' height='564' style='display:none;'>
                  <param name='host_url' value='http%3A%2F%2F181.49.46.6%2F' />
                  <param name='embed_code_version' value='3' />
                  <param name='site_root' value='' />
                  <param name='name' value='ReporteFonade&#47;Cantidaddemantenimientosporregin' />
                  <param name='tabs' value='yes' />
                  <param name='toolbar' value='yes' />
                  <param name='showAppBanner' value='false' />
                  <param name='filter' value='iframeSizedToWindow=true' />
                </object>
              </div>
            </section>
            <section>
              <script type='text/javascript' src='http://181.49.46.6/javascripts/api/viz_v1.js'></script>
              <div class='tableauPlaceholder' style='width: 100%; height: 564px;'>
                <object class='tableauViz' width='100%' height='564' style='display:none;'>
                  <param name='host_url' value='http%3A%2F%2F181.49.46.6%2F' />
                  <param name='embed_code_version' value='3' />
                  <param name='site_root' value='' />
                  <param name='name' value='ANSFonade&#47;MantenimientosFinalizados' />
                  <param name='tabs' value='yes' /><param name='toolbar' value='yes' />
                  <param name='showAppBanner' value='false' />
                  <param name='filter' value='iframeSizedToWindow=true' />
                </object>
              </div>
            </section>


      <!-- fin graficas -->
      <!-- tablas -->
      <div class="wrapper tabs">
            <?php
            if($_SESSION['permissions'][1] == 1){
              if (isset($tablas)){
                $meses[1] = 'Enero';
                $meses[2] = 'Febrero';
                $meses[3] = 'Marzo';
                $meses[4] = 'Abril';
                $meses[5] = 'Mayo';
                $meses[6] = 'Junio';
                $meses[7] = 'Julio';
                $meses[8] = 'Agosto';
                $meses[9] = 'Septiembre';
                $meses[10] = 'Octubre';
                $meses[11] = 'Noviembre';
                $meses[12] = 'Diciembre';
                $meses[13] = 'Enero';
                $meses[14] = 'Febrero';
                $meses[15] = 'Marzo';

                echo "<br><br><br>";
          echo "<h2 class='under'>"."Resumen mensual de estados por Ticket</h2>";
          // echo "<div class='contenedorMeses'";
            echo '<div class="dropdown">';
              echo '<button class="btn btn-primary dropdown-toggle btn-drop" type="button" data-toggle="dropdown">meses&nbsp;';
              echo '<span class="caret"></span></button>';
                echo "<ul class='dropdown-menu scrollable-menu drop'>";
                    echo "<li class='dropdown-header'>2017: </li>";

                  for ($p = 1; $p <= count($meses); $p++){
                    if ($p == 15){
                      echo "<li class='selected mes'><a href='#tab".$p."'><center>".$meses[$p]."</center></a></li>";
                    } else {
                        if ($p == 13) {
                          echo "<li class='dropdown-header'>2018: </li>";
                        }
                          echo "<li class='mes'><a class='mesa' href='#tab".$p."'><center>".$meses[$p]."</center></a></li>";
                    }
                  }
               echo "</ul>";
            echo "</div>";
          // echo "</div>";

                for ($p = 1; $p <= count($meses); $p++){
                  echo "<div class='tab-content' id='tab".$p."'>";
                    echo "<div class='wrapperTable'>";

                      //Tabla 3
                      echo "<h2 class='under'>"."Detalle de tickets zona 1 y 4 mes de ".$meses[$p]."</h2>";
                      echo "<table id='table3-".$p."'>";
                        echo "<thead>  <tr>";
                        echo "<th></th>";
                        echo "<th>Reg.</th>";
                        echo "<th>Departamento / Ciudad</th>";
                        echo "<th>PVD</th>";
                        echo "<th>Ticket</th>";
                        echo "<th>Estado IT</th>";
                        echo "<th>Estado AA</th>";
                        echo "<th>Estado</th>";
                        echo "<th>Inicio</th>";
                        echo "<th>Fin</th>";
                        echo "<th>Días</th>";
                        echo "<tr></thead><tbody>";
                        echo "</tbody></table>";
                        echo "<br><br><br><br><br>";
                    echo "</div>";
                  echo "</div>";
                }
              }
            }
            ?>
          </div>
          </div>
        </article>
      </div>
    </div>

      <!-- Fin tablas -->

    <?php
    if($_SESSION['permissions'][1] == 1){
      if(isset($MP)){

        if ($msg != ""){
          echo "<script type='text/javascript'>showMessage();</script>";
        }
      }
    }
    ?>

  <div class="body4">
   <div class="main zerogrid">
     <article id="content2">
       <div class="wrapper row">

       </div>
     </article>
   <!-- content end -->
   </div>
 </div>

<!-- MODAL MP -->
    <div id="myModal" class="modal fade" role="dialog">
      <section id="contact">
            <div class="contact-section">
            <div class="container">
              <form>
                <div class="col-md-6 form-line">
                    <div class="form-group">
                      <label for="exampleInputUsername">Id PVD :</label>
                      <input type="text" class="form-control" id="idpvd" name="idPVD" disabled="disabled">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail">Región :</label>
                      <input type="email" class="form-control" id="region" name="region" disabled="disabled">
                    </div>
                    <div class="form-group">
                      <label for="telephone">Departamento :</label>
                      <input type="tel" class="form-control" id="departamento" name="dep" disabled="disabled">
                    </div>
                    <div class="form-group">
                      <label for="telephone">Ciudad :</label>
                      <input type="tel" class="form-control" id="ciudad" name="ciudad" disabled="disabled">
                    </div>
                    <div class="form-group">
                      <label for="telephone">Dirección :</label>
                      <input type="tel" class="form-control" id="direccion" name="direccion" disabled="disabled">
                    </div>
                    <div class="form-group">
                      <label for="telephone">Tipologia :</label>
                      <input type="tel" class="form-control" id="tipo" name="tipo" disabled="disabled">
                    </div>
                </div>
                <div class="col-md-6 form-line">
                    <div class="form-group">
                      <label for="exampleInputUsername">Id Ticket :</label>
                      <input type="text" class="form-control" id="idticket" name="idticket" disabled="disabled">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail">Estado :</label>
                      <input type="email" class="form-control" id="estado" name="estado" disabled="disabled">
                    </div>
                    <div class="form-group">
                      <label for="telephone">Fecha Inicio :</label>
                      <input type="tel" class="form-control" id="fechai" name="fechai" disabled="disabled">
                    </div>
                    <div class="form-group">
                      <label for="telephone">Fecha Fin :</label>
                      <input type="tel" class="form-control" id="fechaf" name="fechaf" disabled="disabled">
                    </div>
                    <div class="form-group">
                      <label for="telephone">Duración :</label>
                      <input type="tel" class="form-control" id="duracion" name="duracion" disabled="disabled">
                    </div>
                </div>
                <div class="col-md-6 form-line">
                    <div class="form-group">
                      <label for="exampleInputUsername">Técnico IT :</label>
                      <input type="text" class="form-control" id="tit" name="tit" disabled="disabled">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail">Auxiliar IT :</label>
                      <input type="email" class="form-control" id="ait" name="ait" disabled="disabled">
                    </div>
                    <div class="form-group">
                      <label for="telephone">Fecha Inicio IT :</label>
                      <input type="tel" class="form-control" id="fechaiit" name="fechaiit" disabled="disabled">
                    </div>
                    <div class="form-group">
                      <label for="telephone">Fecha Fin IT :</label>
                      <input type="tel" class="form-control" id="fechafit" name="fechafit" disabled="disabled">
                    </div>
                    <br><br><br><br><br><br>
                    <a href="#" class="btn btn-success" role="button" id="link" name="link">Más detalles</a>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputUsername">Técnico AA :</label>
                    <input type="text" class="form-control" id="taa" name="taa" disabled="disabled">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail">Auxiliar AA :</label>
                    <input type="email" class="form-control" id="aaa" name="aaa" disabled="disabled">
                  </div>
                  <div class="form-group">
                    <label for="telephone">Fecha Inicio AA :</label>
                    <input type="tel" class="form-control" id="fechaiaa" name="fechaiaa" disabled="disabled">
                  </div>
                  <div class="form-group">
                    <label for="telephone">Fecha Fin AA :</label>
                    <input type="tel" class="form-control" id="fechafaa" name="fechafaa" disabled="disabled">
                  </div>
                  <br><br><br><br><br><br>
                    <button type="button" class="btn btn-default submit" data-dismiss="modal"><i class="fa fa-paper-plane" aria-hidden="true"></i> Volver</button>
                </div>
              </form>
            </div>
          </div>

          </section>
        </div>

    <script type="text/javascript"> Cufon.now(); </script>
    <script>
      $(document).ready(function() {
        tabs.init();
      })
    </script>

    <script data-config>
          $(function () {
          var ticket = <?php echo json_encode($PVDs); ?>;
          for(var i = 0; i < ticket.length ; i++){
            if(ticket[i].maintenance){
              for(var j = 0; j < ticket[i].maintenance.length; j++){
                if(ticket[i].maintenance[j].ticket){
                  //console.log(ticket[i].maintenance[j].ticket);
                  var año = ticket[i].maintenance[j].date.split("-")[0];
                  var mes = ticket[i].maintenance[j].date.split("-")[1];
                  var linea = "<tr>";
                  linea = linea  + "<td><div style='width: 20px; height: 20px; border-radius: 50%; background: #"+ticket[i].maintenance[j].ticket[0].color+"; '>&nbsp;</div></td>";
                  linea = linea  + "<td>"+ticket[i].region.split(" ")[1]+"</td>";
                  linea = linea  + "<td>"+ticket[i].deparment+" / "+ticket[i].city+"</td>";
                  linea = linea  + "<td>"+ticket[i].id+"</td>";

                  // linea = linea  + "<td><a onclick='modalEditar("+ticket[i].id+","+ticket[i].city+","+ticket[i].deparment+","+ticket[i].region+","+ticket[i].direccion+","+ticket[i].tipologia+","+ticket[i].maintenance[j].ticket[0].id+","+
                  // ticket[i].maintenance[j].ticket[0].status+","+ticket[i].maintenance[j].ticket[0].dateStart+","+ticket[i].maintenance[j].ticket[0].dateFinish+","+ticket[i].maintenance[j].ticket[0].dateStartIT+","+ticket[i].maintenance[j].ticket[0].dateStartAA
                  // +","+ticket[i].maintenance[j].ticket[0].dateFinishIT+","+ticket[i].maintenance[j].ticket[0].dateFinishAA+","+ticket[i].maintenance[j].ticket[0].duracion+","+ticket[i].maintenance[j].ticket[0].color+","+ticket[i].maintenance[j].ticket[0].techs+")'>"+ticket[i].maintenance[j].ticket[0].id+"</a></td>";

                  linea = linea  + "<td><a onclick='modalEditar(\""+ticket[i].maintenance[j].ticket[0].id+"\")'>"+ticket[i].maintenance[j].ticket[0].id+"</a></td>";

                  if(ticket[i].maintenance[j].ticket[0].dateStartIT == "0000-00-00"){
                    ticket[i].maintenance[j].ticket[0].dateStartIT = null;
                  }

                  if(ticket[i].maintenance[j].ticket[0].dateFinishIT == "0000-00-00"){
                    ticket[i].maintenance[j].ticket[0].dateFinishIT = null;
                  }

                  if(ticket[i].maintenance[j].ticket[0].dateStartAA == "0000-00-00"){
                    ticket[i].maintenance[j].ticket[0].dateStartAA = null;
                  }

                  if(ticket[i].maintenance[j].ticket[0].dateFinishAA == "0000-00-00"){
                    ticket[i].maintenance[j].ticket[0].dateFinishAA = null;
                  }

                  if((ticket[i].maintenance[j].ticket[0].dateStartIT == null) && (ticket[i].maintenance[j].ticket[0].dateFinishIT == null )){
                    linea = linea  + "<td>Sin Iniciar</td>";
                  }
                  if((ticket[i].maintenance[j].ticket[0].dateStartIT != null ) && (ticket[i].maintenance[j].ticket[0].dateFinishIT == null )){
                    linea = linea  + "<td>En Progreso</td>";
                  }
                  if((ticket[i].maintenance[j].ticket[0].dateStartIT != null ) && (ticket[i].maintenance[j].ticket[0].dateFinishIT != null )){
                    linea = linea  + "<td>Ejecutado</td>";
                  }

                  if((ticket[i].maintenance[j].ticket[0].dateStartAA == null ) && (ticket[i].maintenance[j].ticket[0].dateFinishAA == null )){
                    linea = linea  + "<td>Sin Iniciar</td>";
                  }
                  if((ticket[i].maintenance[j].ticket[0].dateStartAA != null ) && (ticket[i].maintenance[j].ticket[0].dateFinishAA == null )){
                    linea = linea  + "<td>En Progreso</td>";
                  }
                  if((ticket[i].maintenance[j].ticket[0].dateStartAA != null ) && (ticket[i].maintenance[j].ticket[0].dateFinishAA != null)){
                    linea = linea  + "<td>Ejecutado</td>";
                  }

                  linea = linea  + "<td>"+ticket[i].maintenance[j].ticket[0].status+"</td>";
                  if(ticket[i].maintenance[j].ticket[0].dateStart == "0000-00-00" || ticket[i].maintenance[j].ticket[0].dateStart == null){
                    ticket[i].maintenance[j].ticket[0].dateStart = "";
                  }
                  if(ticket[i].maintenance[j].ticket[0].dateFinish == "0000-00-00" || ticket[i].maintenance[j].ticket[0].dateFinish == null){
                    ticket[i].maintenance[j].ticket[0].dateFinish = "";
                  }
                  linea = linea  + "<td>"+ticket[i].maintenance[j].ticket[0].dateStart+"</td>";
                  linea = linea  + "<td>"+ticket[i].maintenance[j].ticket[0].dateFinish+"</td>";
                  linea = linea  + "<td>"+ticket[i].maintenance[j].ticket[0].duracion+"</td>";

                  linea = linea + "</tr>";
                  if(mes == 01 && año == 2017){
                    $("#table3-1").find('tbody').append(linea);
                  }
                  if(mes == 02 && año == 2017){
                    $("#table3-2").find('tbody').append(linea);
                  }
                  if(mes == 03 && año == 2017){
                    $("#table3-3").find('tbody').append(linea);
                  }
                  if(mes == 04 && año == 2017){
                    $("#table3-4").find('tbody').append(linea);
                  }
                  if(mes == 05 && año == 2017){
                    $("#table3-5").find('tbody').append(linea);
                  }
                  if(mes == 06 && año == 2017){
                    $("#table3-6").find('tbody').append(linea);
                  }
                  if(mes == 07 && año == 2017){
                    $("#table3-7").find('tbody').append(linea);
                  }
                  if(mes == 08 && año == 2017){
                    $("#table3-8").find('tbody').append(linea);
                  }
                  if(mes == 09 && año == 2017){
                    $("#table3-9").find('tbody').append(linea);
                  }
                  if(mes == 10 && año == 2017){
                    $("#table3-10").find('tbody').append(linea);
                  }
                  if(mes == 11 && año == 2017){
                    $("#table3-11").find('tbody').append(linea);
                  }
                  if(mes == 12 && año == 2017){
                    $("#table3-12").find('tbody').append(linea);
                  }
                  if(mes == 01 && año == 2018){
                    $("#table3-13").find('tbody').append(linea);
                  }
                  if(mes == 02 && año == 2018){
                    $("#table3-14").find('tbody').append(linea);
                  }
                  if(mes == 03 && año == 2018){
                    $("#table3-15").find('tbody').append(linea);
                  }
                }
              }
            }
          }

          var filtersConfig = {
            col_0: "none",
            col_10: "none",
            base_path: '<?php echo base_url(); ?>assets/js/',
            filters_row_index: 1,
            alternate_rows: true,
            loader: true
          };
            var tf1 = new TableFilter('table3-1', filtersConfig);
            tf1.init();
            var tf2 = new TableFilter('table3-2', filtersConfig);
            tf2.init();
            var tf3 = new TableFilter('table3-3', filtersConfig);
            tf3.init();
            var tf4 = new TableFilter('table3-4', filtersConfig);
            tf4.init();
            var tf5 = new TableFilter('table3-5', filtersConfig);
            tf5.init();
            var tf6 = new TableFilter('table3-6', filtersConfig);
            tf6.init();
            var tf7 = new TableFilter('table3-7', filtersConfig);
            tf7.init();
            var tf8 = new TableFilter('table3-8', filtersConfig);
            tf8.init();
            var tf9 = new TableFilter('table3-9', filtersConfig);
            tf9.init();
            var tf10 = new TableFilter('table3-10', filtersConfig);
            tf10.init();
            var tf11 = new TableFilter('table3-11', filtersConfig);
            tf11.init();
            var tf12 = new TableFilter('table3-12', filtersConfig);
            tf12.init();
            var tf13 = new TableFilter('table3-13', filtersConfig);
            tf13.init();
            var tf14 = new TableFilter('table3-14', filtersConfig);
            tf14.init();
            var tf15 = new TableFilter('table3-15', filtersConfig);
            tf15.init();
        });


    </script>
  </body>
</html>

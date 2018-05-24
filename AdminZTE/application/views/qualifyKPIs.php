<!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Calificar KPIs</title>
    <meta charset="utf-8">

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
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tabs2.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/css3-mediaqueries.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/css/canvasJS/canvasjs.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/css/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.wheelmenu.js"></script>
    <script type="text/javascript" charset="utf-8">
      function showMessage(){
        var a = "<?php echo $msg[0]; ?>";
        var b = "<?php echo $msg[1]; ?>";
        var c = "<?php echo $msg[2]; ?>";
        sweetAlert(a, b, c);
      }

      function cambiarAtributo(x, f, val1, val2){
        for(var i = 0; i < x; i++){
          for(var j = 0; j < 12; j++){
            for(var k = 0; k < f; k++){
              var dateField1 = document.getElementById("field-"+i+"-"+j+"-"+k+"-1");
              var dateField2 = document.getElementById("field-"+i+"-"+j+"-"+k+"-2");
              var dateField3 = document.getElementById("field-"+i+"-"+j+"-"+k+"-3");
              try {dateField1.removeAttribute('disabled');} catch(err) {console.log("fieldNotFound 0");}
              try {dateField2.removeAttribute('disabled');} catch(err) {console.log("fieldNotFound 0");}
              try {dateField2.removeAttribute('disabled');} catch(err) {console.log("fieldNotFound 0");}
            }
          }
        }
        var buttonField = document.getElementById("BEditar"+val1+val2);
        var buttonEnviar = document.getElementById("btnSubmit"+val1+val2);
        buttonEnviar.removeAttribute('disabled');
        buttonField.setAttribute("disabled","disabled");
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
        <article id="content">
          <div class="wrapper">
            <?php
            if($_SESSION['permissions'][5] == 1){
              echo "<div class='wrapperWheel'>";
                echo "<div class='mainWheel'>";
                  echo "<a href='".base_url()."KPI/KPIPrincial' class='wheel-button nw'>";
                    echo "<span><img src='".base_url()."assets/images/KPI.png' /></span>";
                  echo "</a>";
                  echo "<div class='pointer'><center>KPIs</center></div>";
                  echo "<ul id='wheel'  data-angle='all'>";
                  echo "</ul>";
                echo "</div>";
              echo "</div>";
              echo "<br>";
              if (isset($dates)){
                echo "<h2 class='under'>Selecciona el año y el mes para calificar</h2>";
                echo "<div class='wrapper tabs'>";
                  echo "<ul class='nav'>";
                    echo "<center>";
                    for ($p = 0; $p < count($dates['years']); $p++){
                      if ($p == 0){
                        echo "<li class='selected'><a href='#tab".$p."'><center>".$dates['years'][$p]['Q_ANO']."</center></a></li>";
                      } else {
                        echo "<li><a href='#tab".$p."'><center>".$dates['years'][$p]['Q_ANO']."</center></a></li>";
                      }
                    }
                    echo "</center>";
                  echo "</ul><br><br><br>";

                  for ($p = 0; $p < count($dates['years']); $p++){
                    echo "<ul class='nav'>";
                      echo "<div class='tab-content' id='tab".$p."'>";

                        echo "<center>";
                        for ($i = 1; $i <= 12; $i++){
                          if ($dates[$dates['years'][$p]['Q_ANO']][$i] != NULL){
                            echo "<li><a href='#tab".$p.$i."'><center>".$dates[$dates['years'][$p]['Q_ANO']][$i."alfa"]."</center></a></li>";
                          }
                          if ($kpi_name == ""){
                            $kpi_name = $kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][0]['KPI']['N_NAME'];
                            $kpi_desc = $kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][0]['KPI']['N_DESCRIPTION'];
                          }
                        }
                        echo "</center>";
                      echo "</div>";
                    echo "</ul>";

                  }

                  for ($p = 0; $p < count($dates['years']); $p++){
                    for ($i = 1; $i <= 12; $i++){
                      if ($dates[$dates['years'][$p]['Q_ANO']][$i] != NULL){
                        echo "<div class='tab-content' id='tab".$p.$i."'>";
                          echo "<h2 class='under'>".$kpi_name." : ".$kpi_desc." de ".$dates[$dates['years'][$p]['Q_ANO']][$i.'alfa']."</h2>";
                          echo "<button value='Editar".$p.$i."' name='BEditar".$p.$i."' id='BEditar".$p.$i."' type='button' class='btn btn-primary' onclick= 'cambiarAtributo(".json_encode(count($dates['years'])).",".json_encode($cantidad).",".json_encode($p).",".json_encode($i).")'>Editar</button><br><br>";
                          echo "<form method='post' name='formActualizar'>";
                            echo "<input type='submit' value='Calificar' disabled='disabled' id='btnSubmit".$p.$i."' name='btnSubmit".$p.$i."' class='btn btn-success'  onclick = \"this.form.action = '".base_url()."KPI/updateKPI' \"><br><br>";
                            echo "<div class='wrapperTable'>";
                              echo "<div class='table'>";
                                $flag = 1;
                                for ($j = 0; $j<$cantidad; $j++){
                                  if($kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j] != null && $flag == 1){
                                    $flag = 0;
                                    echo "<input id='kpi' name='kpi' type='hidden'  class='form-control' value='".$kpi_name."'>";
                                    echo "<input id='cell1' name='cell1' type='hidden'  class='form-control' value='".$kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['N_NOMBREVALOR1']."'>";
                                    echo "<input id='cell2' name='cell2' type='hidden'  class='form-control' value='".$kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['N_NOMBREVALOR2']."'>";
                                    echo "<input id='cell3' name='cell3' type='hidden'  class='form-control' value='".$kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['N_NOMBREVALOR3']."'>";
                                    echo "<div class='row header'>";
                                      echo "<div class='cell'>"."Nombre"."</div>";
                                      if($kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['N_NOMBREVALOR1'] != NULL)
                                        echo "<div class='cell'>".$kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['N_NOMBREVALOR1']."</div>";
                                      if($kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['N_NOMBREVALOR2'] != NULL)
                                        echo "<div class='cell'>".$kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['N_NOMBREVALOR2']."</div>";
                                      if($kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['N_NOMBREVALOR3'] != NULL)
                                        echo "<div class='cell'>".$kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['N_NOMBREVALOR3']."</div>";
                                      echo "<div class='cell'>"."Valor Esperado"."</div>";
                                      echo "<div class='cell'>"."Valor Real"."</div>";
                                    echo "</div>";
                                  }
                                }

                                for ($j = 0; $j<$cantidad; $j++){
                                  if($kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j] != null){
                                    echo "<div class='row'>";
                                      echo "<div class='cell'>".$kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['user']['N_NAME']." ".$kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['user']['N_LASTNAME']."</div>";
                                      if($kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['N_NOMBREVALOR1'] != NULL)
                                        echo "<div class='cell'><input style='font-size:12px' id='field-".$p."-".$i."-".$j."-1'  name='field-".$p."-".$i."-".$j."-1' disabled='true' aria-describedby='basic-addon1' value='".$kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['Q_VALORREAL1']."'></div>";
                                      if($kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['N_NOMBREVALOR2'] != NULL)
                                        echo "<div class='cell'><input  style='font-size:12px' id='field-".$p."-".$i."-".$j."-2'  name='field-".$p."-".$i."-".$j."-2' disabled='true' aria-describedby='basic-addon1' value='".$kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['Q_VALORREAL2']."'></div>";
                                      if($kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['N_NOMBREVALOR3'] != NULL)
                                        echo "<div class='cell'><input style='font-size:12px'id='field-".$p."-".$i."-".$j."-3' name='field-".$p."-".$i."-".$j."-3' disabled='true' aria-describedby='basic-addon1' value='".$kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['Q_VALORREAL3']."'></div>";



                                      echo "<div class='cell'>".$kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['KPI']['Q_VALORESPERADO']."% "."</div>";
                                      $acumulado = $kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['KPI']['Q_VALORESPERADO'];
                                      $indicators = explode(",",$kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['KPI']['N_ESTANDARES']);
                                      for($flag = 0; $flag < count($indicators); $flag++){
                                        if($flag == 0){
                                          $acumulado = $acumulado -($indicators[$flag] * $kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['Q_VALORREAL1']);
                                        }
                                        if($flag == 1){
                                          if($indicators[$flag-1] == 0){
                                            $acumulado = $acumulado -(($indicators[$flag]) * ($kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['Q_VALORREAL1']-$kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['Q_VALORREAL2']));
                                          } else {
                                            $acumulado = $acumulado -($indicators[$flag] * $kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['Q_VALORREAL2']);
                                          }
                                        }
                                        if($flag == 2){
                                          $acumulado = $acumulado -($indicators[$flag] * $kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['Q_VALORREAL3']);
                                        }
                                      }
                                      if ($acumulado <0){
                                        $acumulado = 0;
                                      }
                                      echo "<div class='cell'>".$acumulado."% "."</div>";


                                      echo "<input id='idKPI-".$p."-".$i."-".$j."' name='idKPI-".$p."-".$i."-".$j."' type='hidden'  class='form-control' value='".$kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['K_IDKPI_RESUELTO']."'>";
                                      echo "<input id='name-".$p."-".$i."-".$j."' name='name-".$p."-".$i."-".$j."' type='hidden'  class='form-control' value='".$kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['user']['N_NAME']." ".$kpis[$dates['years'][$p]['Q_ANO']][$i]['users'][$j]['user']['N_LASTNAME']."'>";
                                    echo "</div>";
                                  }
                                }
                                echo "<input id='cantidadY' name='cantidadY' type='hidden'  class='form-control' value='".count($dates['years'])."'>";
                                echo "<input id='cantidadU' name='cantidadU' type='hidden'  class='form-control' value='".$cantidad."'>";
                              echo "</div>";
                            echo "</div>";
                          echo "</form>";
                        echo "</div>";
                      }
                    }
                  }
                echo "</div>";
              }
            }
            ?>
            <br><br><br><br><br><br><br><br><br><br><br><br><br>
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

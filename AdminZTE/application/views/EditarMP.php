<!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Editar Preventivos</title>

      <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!--   ICONO PAGINA    -->
        <link rel="icon" href="http://cellaron.com/media/wysiwyg/zte-mwc-2015-8-l-124x124.png">
        <!--   BOOTSTRAP    -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <!--   HEADER CSS    -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/reset.css" type="text/css" media="all">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/zerogrid.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" type="text/css" media="all">
        <!-- jquery JS -->
        <script src="<?php echo base_url(); ?>assets/js/jquery-2.1.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>  
        <!-- Push.js   -->
        <script src="<?php echo base_url(); ?>assets/js/push.min.js"></script>    
  </head>

  <body>
  	<div class="body1">
      <div class="body2">
        <div class="body5">
          <div class="main zerogrid">
      <!-- header -->
            <header>
              <div class="wrapper rơw">
              <h1><a id="logo"><img src="<?php echo base_url(); ?>assets/images/logo.png" /></a></h1>
              <nav>
                <ul id="menu" class="menuTop">
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
 <div class="bodyEdit">
      <section class="content">
        <div class="row">
          <div class="col-xs-10 col-xs-offset-1">
            <div class="box">
               <center><h3><legend>Mantenimientos Preventivos</legend></h3></center><hr>        
             <!-- /.box-header -->
             <div class='box-body'>
               <table id='tablePreventive' class='table table-bordered table-striped table-hover'>
                 
               </table>
             </div>
           <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
</div>

<!-- Modal Cierre -->
<div id="modalEditTicket" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg2">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?php echo base_url(); ?>assets/images/close.png" alt="cerrar" id="modalImage" ></button>
        <h3 class="modal-title" id="myModalLabel"></h3>
      </div>
      <div class="modal-body">
        <div>
         <form class="well form-horizontal" id="formModal" action=""  method="post" data-action="FOR_UPDATE" novalidate="novalidate">
          <fieldset>
            <div class="widget bg_white m-t-25 display-block">
                <h2 class="h4 mp">
                    <i class="fa fa-fw fa-question-circle"></i>&nbsp;&nbsp; General
                </h2>
                <fieldset class="col-md-6 control-label">
                <!-- valores ocultos -->
                <input type="hidden" id="mtxtTicket" value="">

                  <div class="form-group">
                    <label for="mtxtPVD" class="col-md-3 control-label">PVD: &nbsp;</label>
                    <div class="col-md-8 selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input name="mtxtPVD" id="mtxtPVD" class="form-control" type="text" disabled="true">
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="mtxtProgramado" class="col-md-3 control-label">Programado: &nbsp;</label>
                    <div class="col-md-8 selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-dashboard"></i></span>
                            <input name="mtxtProgramado" id="mtxtProgramado" class="form-control" type="text" disabled="true">
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="mtxtIniMant" class="col-md-3 control-label">Ini Manten: &nbsp;</label>
                    <div class="col-md-8 selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            <input name="mtxtIniMant" id="mtxtIniMant" class="form-control" type="text" disabled="true">
                        </div>
                    </div>
                  </div>
                </fieldset>
                <!--  fin seccion izquierda form-->
                <!--  inicio seccion derecha form-->
                <fieldset>
                  
                  <div class="form-group">
                    <label for="mtxtEstado" class="col-md-3 control-label">Estado: &nbsp;</label>
                    <div class="col-md-8 selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon" id="statusColor"><i class="glyphicon glyphicon-hand-right"></i></span>
                            <select name="mtxtEstado" id="mtxtEstado" class="form-control"> <!-- onchange="realizarCalificacion()" -->
                                <option value="1">Abierto</option>
                                <option value="2">En Progreso</option>
                                <option value="3">Cancelado</option>
                                <!-- <option value="4">En Espera Interventoria</option> -->
                                <option value="5">Ejecutado</option>
                            </select>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="mtxtDuracion" class="col-md-3 control-label">Duración: &nbsp;</label>
                    <div class="col-md-8 selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            <input name="mtxtDuracion" id="mtxtDuracion" class="form-control" type="text" disabled="true">
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="mtxtFinMant" class="col-md-3 control-label">Fin Manten: &nbsp;</label>
                    <div class="col-md-8 selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            <input name="mtxtFinMant" id="mtxtFinMant" class="form-control" type="text" disabled="true">
                        </div>
                    </div>
                  </div>                 
                </fieldset>
                <!--  fin seccion derecha form---->
            </div>

            <div class="widget bg_white m-t-25 display-block">
                <h2 class="h4 mp">
                    <i class="fa fa-fw fa-question-circle"></i>IT
                </h2>
                <fieldset class="col-md-6 control-label">
                    <div class="form-group">
                  <label for="mtxtTecIT" class="col-md-3 control-label">Téc IT: &nbsp;</label>
                  <div class="col-md-8 selectContainer">
                      <div class="input-group">
                          <span class="input-group-addon"><i class='glyphicon glyphicon-user'></i></span>
                          <select name="mtxtTecIT" id="mtxtTecIT" class="form-control"> <!-- onchange="realizarCalificacion()" -->
                              <option value=""></option>
                          </select>
                      </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="mtxtIniIT" class="col-md-3 control-label">Inicio IT: &nbsp;</label>
                  <div class="col-md-8 selectContainer">
                      <div class="input-group">
                          <span class="input-group-addon"><i class='glyphicon glyphicon-calendar'></i></span>
                          <input name="mtxtIniIT" id="mtxtIniIT" class="form-control" type="date">
                      </div>
                  </div>
                </div>
                </fieldset>
                <!--  fin seccion izquierda form---->

                <!--  inicio seccion derecha form---->
                <fieldset>
                  <div class="form-group">
                    <label for="mtxtAuxIT" class="col-md-3 control-label">Aux IT: &nbsp;</label>
                    <div class="col-md-8 selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class='glyphicon glyphicon-user'></i></span>
                            <select name="mtxtAuxIT" id="mtxtAuxIT" class="form-control"> <!-- onchange="realizarCalificacion()" -->
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="mtxtFinIT" class="col-md-3 control-label">Fin IT: &nbsp;</label>
                    <div class="col-md-8 selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class='glyphicon glyphicon-calendar'></i></span>
                            <input name="mtxtFinIT" id="mtxtFinIT" class="form-control" type="date">
                        </div>
                    </div>
                  </div>
                </fieldset>
            </div>

            <div class="widget bg_white m-t-25 display-block">
                <h2 class="h4 mp">
                    <i class="fa fa-fw fa-question-circle"></i>&nbsp;&nbsp; AA
                </h2>
                <fieldset class="col-md-6 control-label">

                  <div class="form-group">
                    <label for="mtxtTecAA" class="col-md-3 control-label">Téc AA: &nbsp;</label>
                    <div class="col-md-8 selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class='glyphicon glyphicon-user'></i></span>
                            <select name="mtxtTecAA" id="mtxtTecAA" class="form-control"> <!-- onchange="realizarCalificacion()" -->
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="mtxtIniAA" class="col-md-3 control-label">Inicio AA: &nbsp;</label>
                    <div class="col-md-8 selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class='glyphicon glyphicon-calendar'></i></span>
                            <input name="mtxtIniAA" id="mtxtIniAA" class="form-control" type="date">
                        </div>
                     </div>
                  </div>
                </fieldset>
                  <!--  fin seccion izquierda form---->

                  <!--  inicio seccion derecha form---->
                  <fieldset>

                    <div class="form-group">
                      <label for="mtxtAuxAA" class="col-md-3 control-label">Aux AA: &nbsp;</label>
                      <div class="col-md-8 selectContainer">
                          <div class="input-group">
                              <span class="input-group-addon"><i class='glyphicon glyphicon-user'></i></span>
                              <select name="mtxtAuxAA" id="mtxtAuxAA" class="form-control"> <!-- onchange="realizarCalificacion()" -->
                                  <option value=""></option>
                              </select>
                          </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="mtxtFinAA" class="col-md-3 control-label">Fin AA: &nbsp;</label>
                      <div class="col-md-8 selectContainer">
                          <div class="input-group">
                              <span class="input-group-addon"><i class='glyphicon glyphicon-calendar'></i></span>
                              <input name="mtxtFinAA" id="mtxtFinAA" class="form-control" type="date">
                          </div>
                      </div>
                    </div>
                  </fieldset>
              </div>

              <div class="widget bg_white m-t-25 display-block">
                  <div class="form-group" id="formCenter">
                    <!-- <label for="mtxtObservaciones" class="col-md-3 control-label">Observaciones: &nbsp;</label> -->
                      <div class="col-md-10 selectContainer">
                          <div class="input-group">
                              <span class="input-group-addon"><i class='glyphicon glyphicon-edit'></i></span>
                              <input name="mtxtObservaciones" id="mtxtObservaciones" class="form-control" type="text" placeholder="Observaciones">
                          </div>
                      </div>
                  </div>                
              </div>

          </fieldset>
         </form>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="mbtnCerrarModal" data-dismiss="modal"><i class='glyphicon glyphicon-remove'></i>&nbsp;Cancelar</button>
        <button type="button" class="btn btn-info" id="mbtnUpdticket"><i class='glyphicon glyphicon-save'></i>&nbsp;Actualizar</button>
      </div>
    </div>
  </div>
</div>

 
    <script type="text/javascript">var baseurl = "<?php echo base_url(); ?>";</script>
    <!-- declarola url para usarla con js y los permisos -->
    <script type="text/javascript">
        var baseurl = "<?php echo base_url(); ?>";
        var permisos = "<?php echo $_SESSION['permissions'][4]; ?>"
    </script>
        <!-- DataTables -->
    <script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <!-- llenar tabla y editar -->
    <script src="<?php echo base_url(); ?>assets/js/editPreventivos/editPreventTable.js"></script>


  </body>
</html>

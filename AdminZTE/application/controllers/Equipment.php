<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require ('assets/extensions/fpdf/fpdf.php');


class Equipment extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('data/dao_user_model');
        $this->load->model('data/dao_PVD_model');
        $this->load->model('data/dao_ticket_model');
        $this->load->model('data/dao_inventory_model');
        $this->load->model('data/dao_softwareStuff_model');
        $this->load->model('data/dao_MC_model');
        $this->load->model('user_model');
        $this->load->model('equipment_model');
        $this->load->model('correctiveM_model');
        $this->load->model('mail/mail_manager');

        $this->load->library('session');
 $this->load->helper('form');
    }

    public function inventoryPVD(){
      if($_GET['k_tipo'] == "Pl"){
        $_GET['k_tipo'] = "Plus";
      }
      if($_GET['k_tipo'] == "Pi"){
        $_GET['k_tipo'] = "Piloto";
      }
      $respuesta['ticket'] = $_GET['k_ticket'];
      $respuesta['PVD'] = $this->dao_PVD_model->getPVDbyId($_GET['k_pvd']);
      $respuesta['CCC'] =  $this->dao_PVD_model->getAllCCCTicketsPerPBV($_GET['k_pvd']);
      $respuesta['inventory'] = $this->dao_inventory_model->getEquipmentTypePVD($_GET['k_fase'], $_GET['k_tipo'], $_GET['k_pvd']);
      $respuesta['generic'] = $this->dao_inventory_model->getAllEquipment($_GET['k_fase'], $_GET['k_tipo'], $_GET['k_pvd']);
      $respuesta['software'] = $this->dao_softwareStuff_model->getAllSoftwareInventoryPerPVD($_GET['k_pvd']);
      $respuesta['estadoI'] = $this->dao_ticket_model->getEstadoI($_GET['k_ticket']);

      $respuesta['avance'] = 0;
      $porcentaje = 100/count($respuesta['inventory']);
      if ($respuesta['PVD']->getRegion() == "Zona 1"){
        $stirngPrecio = "V_PRICE_R1";
      }
      if ($respuesta['PVD']->getRegion() == "Zona 4"){
        $stirngPrecio = "V_PRICE_R4";
      }
      for($i = 0; $i< count($respuesta['generic']); $i++){
        for($j = 0; $j <count($respuesta['generic'][$i]['category']); $j++){
          if($respuesta['generic'][$i]['category'][$j]['V_PRICE_R4'] > 0){
            $respuesta['inventory'][$i]['price'] = $respuesta['generic'][$i]['category'][$j][$stirngPrecio];
          }
        }
      }
      for($i = 0; $i< count($respuesta['inventory']); $i++){
        $respuesta['inventory'][$i]['valorT'] = 0;
        $respuesta['inventory'][$i]['funcional'] = 0;
        $respuesta['inventory'][$i]['averiado'] = 0;
        $respuesta['inventory'][$i]['NE'] = 0;
        $respuesta['inventory'][$i]['avance'] = 0;
        $valoresParciales = array();
        $p = 0;
        for($j = 0; $j< count($respuesta['inventory'][$i]['inventario']); $j++){
          if($folders[$respuesta['inventory'][$i]['N_NAME']][$respuesta['inventory'][$i]['inventario'][$j]['K_IDPVD_PLACE']['N_NAME']]['Antes del Mantenimiento'] == 1 && $respuesta['inventory'][$i]['inventario'][$j]['N_ESTADO'] != "Averiado"){
            $respuesta['inventory'][$i]['inventario'][$j]['progreso'] = $respuesta['inventory'][$i]['inventario'][$j]['progreso'] + 0;
          }
          if($folders[$respuesta['inventory'][$i]['N_NAME']][$respuesta['inventory'][$i]['inventario'][$j]['K_IDPVD_PLACE']['N_NAME']]['Durante el Mantenimiento'] == 1 && $respuesta['inventory'][$i]['inventario'][$j]['N_ESTADO'] != "Averiado"){
            $respuesta['inventory'][$i]['inventario'][$j]['progreso'] = $respuesta['inventory'][$i]['inventario'][$j]['progreso'] + 0;
          }
          if($folders[$respuesta['inventory'][$i]['N_NAME']][$respuesta['inventory'][$i]['inventario'][$j]['K_IDPVD_PLACE']['N_NAME']]['Despues del Mantenimiento'] == 1 && $respuesta['inventory'][$i]['inventario'][$j]['N_ESTADO'] != "Averiado"){
            $respuesta['inventory'][$i]['inventario'][$j]['progreso'] = $respuesta['inventory'][$i]['inventario'][$j]['progreso'] + 0;
          }
          if ($respuesta['PVD']->getRegion() == "Zona 1"){
            $url = "https://drive.google.com/drive/folders/0BxX2l5kpb3SaZGNJT0E4OTY0Rjg";
          }
          if ($respuesta['PVD']->getRegion() == "Zona 4"){
            $url = "https://drive.google.com/drive/folders/0BxX2l5kpb3SabFduRW1hMFhyWDQ";
          }
          if (isset($respuesta['inventory'][$i]['inventario'][$j]['url'])){
            $respuesta['inventory'][$i]['inventario'][$j]['url'] = $url;
          }
          if($respuesta['inventory'][$i]['inventario'][$j]['N_ESTADO'] == "Funcional"){
            if($respuesta['inventory'][$i]['inventario'][$j][$stirngPrecio] > 0){
              $respuesta['inventory'][$i]['funcional']++;
            }
            if($respuesta['inventory'][$i]['inventario'][$j]['Q_PROGRESS'] == 1){
              $respuesta['inventory'][$i]['valorT'] += $respuesta['inventory'][$i]['inventario'][$j][$stirngPrecio];
              $respuesta['inventory'][$i]['inventario'][$j]['progreso'] = $respuesta['inventory'][$i]['inventario'][$j]['progreso'] + 100;
            }
            $valoresParciales[$p] = $respuesta['inventory'][$i]['inventario'][$j]['progreso'];
            $p++;
          }
          if($respuesta['inventory'][$i]['inventario'][$j]['N_ESTADO'] == "Averiado"){
            $respuesta['inventory'][$i]['averiado']++;
          }
          if($respuesta['inventory'][$i]['inventario'][$j]['N_ESTADO'] == "No encontrado"){
            $respuesta['inventory'][$i]['NE']++;
          }
        }
        if (count($valoresParciales) > 0){
          $porcentaje  = 100 / count($valoresParciales);
        }
        for($p = 0; $p<count($valoresParciales); $p++){
          $respuesta['inventory'][$i]['avance'] += $porcentaje / 100 * $valoresParciales[$p];
        }
         $respuesta['inventory'][$i]['avance'] = number_format((float) $respuesta['inventory'][$i]['avance'], 2, '.', '');
         $respuesta['avance'] = $respuesta['avance'] + ((100/count($respuesta['inventory']))/100*$respuesta['inventory'][$i]['avance']);
      }
      $respuesta['avance'] = number_format((float) $respuesta['avance'], 2, '.', '');
      $this->dao_ticket_model->updateProgress($respuesta['avance'], $_GET['k_ticket']);
      //print_r($respuesta);
      $this->load->view('PmaintenanceProcedure', $respuesta);
    }

    public function updateInventory(){
      $cantidadElementos = $_POST['Elements'];
      for($i = 0; $i < $cantidadElementos; $i++){
        $equipment = new equipment_model;
        $ref = $_POST['selectElement'.$i];
        $equipment = $equipment->createEquipment($_POST['idElement'.$i], $_POST['selectElement'.$i], $_POST['observaciones'.$i], "", "", $_POST['fieldName'.$i], $_POST['selectMarca'.$i], $_POST['selectModelo'.$i], $_POST['fieldPlaca'.$i], $_POST['fieldParte'.$i], $_POST['selectEstados'.$i], $_POST['selectFinalizado'.$i]);
        $equipment->setZona($_POST['selectZones'.$i]);
        if($equipment->getEstado() == "Averiado"){
          $ticketCorrective = new correctiveM_model;
          $ticketCorrective = $ticketCorrective->createMaintenance($_POST['idCM'.$i], $_POST['idElement'.$i], $_POST['cccTicket'.$i], "", "", "", $_POST['descripcionFalla'.$i], $_POST['referenciaEquiposAveriados'.$i], $_POST['pruebas'.$i], $_POST['equiposAveriados'.$i], $_POST['elementos'.$i],  $_POST['selectFalla'.$i], "", "");
        }
        if($_POST['idElement'.$i] == ""){
          $idstuff = $this->dao_inventory_model->insertEquipment($equipment, $_POST['pvd']);
          if($equipment->getEstado() == "Averiado"){
            $this->dao_MC_model->insertMC($ticketCorrective, $idstuff);
          }
          if($ref == 45 || $ref == 42 || $ref == 46 || $ref == 47 || $ref == 48){
            $this->dao_softwareStuff_model->createSoftwareStuff("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", $idstuff);
          }
        } else {
          if($equipment->getEstado() == "Averiado"){
            if($_POST['idCM'.$i] == ""){
              $this->dao_MC_model->insertMC($ticketCorrective, $equipment->getId());
            } else {
              $this->dao_MC_model->updateMC($ticketCorrective);
            }
          }
          $this->dao_inventory_model->updateEquipment($equipment,$_POST['pvd'] );
        }
      }
      $this->inventoryPVD();
    }

    public function updateSoftwareInventory(){
      for($i = 0; $i < $_POST['Elements']; $i++){
        $this->dao_softwareStuff_model->updateSoftwareInventory($_POST['idSS'.$i], $_POST['SOVer'.$i], $_POST['OfficeVer'.$i], $_POST['AntivirusVer'.$i], $_POST['BrowserVer'.$i], $_POST['SimonticVer'.$i], $_POST['MagicVer'.$i], $_POST['SacVer'.$i], $_POST['SemillaVer'.$i], $_POST['JawsVer'.$i]);
      }
      $this->inventoryPVD();
    }

    public function createFolders(){
      $folders['Computador convencional']['Acceso a Internet']['Antes del Mantenimiento'] = "";
      $folders['Computador convencional']['Acceso a Internet']['Despues del Mantenimiento'] = "";
      $folders['Computador convencional']['Acceso a Internet']['Durante el Mantenimiento'] = "";
      $folders['Computador convencional']['Aspectos generales'] = $folders['Computador convencional']['Servicios complementarios'] = $folders['Computador convencional']['Recepción y registro'] = $folders['Computador convencional']['Producción de contenidos'] = $folders['Computador convencional']['Consultas rápidas'] = $folders['Computador convencional']['Almacenamiento'] = $folders['Computador convencional']['Capacitación'] = $folders['Computador convencional']['Entretenimiento'] = $folders['Computador convencional']['Innovación'] = $folders['Computador convencional']['Acceso a internet'];
      $folders['Soporte consolas y televisores'] = $folders['Mobiliario (muebles, enceres y señalización)'] = $folders['Alarma para PVD'] = $folders['Redes de datos'] = $folders['Redes electricas'] = $folders['Camara IP'] = $folders['DVD player'] = $folders['Video Beam'] = $folders['Mesa electrificada de 6 a 8 puestos'] = $folders['Mezclador de audio'] = $folders['Grabadora audio digital'] = $folders['Tripode para microfonos'] = $folders['Tripode de cabeza fluida para camara'] = $folders['Tripode ajustable para luces'] = $folders['Microfono inalambrico de solapa'] = $folders['Microfono con cable'] = $folders['Mezclador de video'] = $folders['Camara fotografica'] = $folders['Camara de video'] = $folders['Audifonos para estudio profesional'] = $folders['Lampara escualizable'] = $folders['Diadema para equipo de computo con microfono'] = $folders['Membrana táctil para televisores de 55 Y 58'] = $folders['Home cinema'] = $folders['Consola de juegos'] = $folders['UPS'] = $folders['Televisor LED desde 32 a 42'] = $folders['Tableta digitalizadora'] = $folders['Impresora'] = $folders['Servidor'] = $folders['Workstation y-o administrador de red'] = $folders['Computador All in One'] = $folders['Computador portatil'] = $folders['Computador convencional'];
      return $folders;
    }

    public function deleteElement(){
      $this->dao_inventory_model->deteleElementById($_GET['k_element']);
      $this->inventoryPVD();
    }

    public function updateCCC(){
      $cantidad = (count($_POST)-2-($_POST['Elements']*3))/5;
      for($i = 0; $i < $cantidad+$_POST['Elements']; $i++){
        $this->dao_MC_model->editCCC($_POST['idCCC'.$i], $_POST['select'.$i], $_POST['observciones'.$i], $_POST['selectTipo'.$i], $_POST['desc'.$i], $_GET['k_pvd']);
      }
      $this->inventoryPVD();
    }

    public function approveTicket(){
      $this->dao_ticket_model->approveTicket($_GET['k_ticket']);
    //  $this->mail_manager->mailNotification($_GET['k_ticket']);
      $PVD = $this->dao_PVD_model->getPVDbyId($_GET['k_pvd']);
      //-------------------------------email------------------

     $cuerpo = "<html>
                   <head>
                   <title>asignacion</title>
                    <link rel= 'stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css'>
                    <link rel= 'stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css'>
                     <script src='//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js'></script>

                   </head>
                  <body>
                   <h4>Buen Día, se confirma que el reporte correspondiente al PVD ".$_GET['k_pvd']." ha sido entregado y se encuentra disponible en la plataforma para su revisión.</h4><br>

                   El link a la página del mantenimiento es el siguiente:

                   <a href='http://zte.consorcio2018technical.com/index.php/Equipment/inventoryPVD?k_fase=".$_GET['k_fase']."&k_tipo=".$_GET['k_tipo']."&k_pvd=".$_GET['k_pvd']."&k_ticket=".$_GET['k_ticket']."'>Página principal ticket número ".$_GET['k_ticket']."<a>
             <div class='box-body'>
                <table id='example1' class='table table-bordered table-striped'>

                  <tbody>
                  ";
                 $cuerpo = $cuerpo."<tfoot>

                               </tfoot>
                </table>
              </div><br><br>
              <p style= 'color: blue'> Este es un correo automático. Por favor, no responda este mensaje. </p>

           </body>
           </html>
       ";

     $this->load->library('email');

     $config['mailtype'] = 'html'; // o text
     $this->email->initialize($config);

     $this->email->from('zolid@zte.com', 'ZOLID_ZTE');

   //  $this->email->to(strtolower($mailEngC).', '.strtolower($asig->getMail()));

     if($PVD->getRegion() == "Zona 1"){
      $this->email->to('sandra.cardenas@zte.com.cn, jonnatan.villalobos@zte.com.cn, marcela.espitiacuervo@zte.com.cn, johan.beltran@zte.com.cn, coordinador.tecnico1@fonadeud.com.co');
      }else {
      $this->email->to('sandra.cardenas@zte.com.cn, oscar.gonzalez01@zte.com.cn, juan.ramirez@zte.com.cn, johan.beltran@zte.com.cn, coordinador.tecnico4@fonadeud.com.co');
     }

     $this->email->cc('paestebanv@gmail.com');//, cesar.rios.ext@claro.com.co

     $this->email->bcc('pablo.esteban@zte.com.cn');

     $this->email->subject("Notificación de finalización mantenimiento preventivo. PVD: ".$_GET['k_pvd'].".");

     $this->email->message($cuerpo);

     $this->email->send();

      $this->inventoryPVD();
    }

    public function palabritas(){
      $frase = "super fuerte";
      $lng = strlen($frase);
      $counter = 0;
      for($i = 0; $i < $lng; $i++){
        $counter = $i;
        for($j = 0; $j < $lng; $j++){
          echo $frase[$counter];
          $counter++;
          if($counter == $lng){
            $counter= 0;
          }
        }
        echo "<br>";
      }
    }
}

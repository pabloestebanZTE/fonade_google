<?php

$msgJS = "";

defined('BASEPATH') OR exit('No direct script access allowed');

include 'fileManager.php';       // include the class

class Mantenimientos extends CI_Controller {



   function __construct() {
       parent::__construct();
       $this->load->model('data/dao_ticket_model');
       $this->load->model('data/dao_maintenance_model');
       $this->load->model('data/dao_user_model');
       $this->load->model('data/dao_PVD_model');
       $this->load->model('user_model');
       $this->load->model('maintenance_model');
       $this->load->model('ticket_model');
   }

   public function createTicketMP(){
     $date = explode("-",$_POST['date']);
     $newdate = $date[0]."-".$date[1]."-01";
     $pvd = explode("/",$_POST['pvd']);
     $maintenance = new maintenance_model;
     $maintenance = $maintenance->createMaintenance("",$pvd[0],"1",$newdate);
     $idMiantenance = $this->dao_maintenance_model->createMaintenance($maintenance);
     if($idMiantenance != "No existe mantenimiento" && $idMiantenance != "Error de informacion"){
       $count = $this->dao_ticket_model->ticketQuantity();
       for($i = strlen($count); $i <5; $i++){
         $count = "0".$count;
       }
       $idNewTicket = "TPM-".$pvd[0]."-".$count;
       $ticket = new ticket_model;
       $ticket = $ticket->createTicket($idNewTicket, $idMiantenance, "Abierto", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL,$_POST['Observaciones']);
       $ticket->setDateS($_POST['date']);
       $ticket->setDateF($_POST['dateFinish']);

       $this->dao_ticket_model->insertTicket($ticket, 1);
       $id = $this->dao_ticket_model->getTicketByID($idNewTicket);

       if($id != "No ticket" && $id != "Error en BD"){
         if($_POST['TIT'] != -1){
           $this->dao_ticket_model->insertTech($ticket->getId(), explode("/",$_POST['TIT'])[1], "IT-T");
         }
         if($_POST['AIT'] != -1){
           $this->dao_ticket_model->insertTech($ticket->getId(), explode("/",$_POST['AIT'])[1], "IT-A");
         }
         if($_POST['TAA'] != -1){
           $this->dao_ticket_model->insertTech($ticket->getId(), explode("/",$_POST['TAA'])[1], "AA-T");
         }
         if($_POST['AAA'] != -1){
           $this->dao_ticket_model->insertTech($ticket->getId(), explode("/",$_POST['AAA'])[1], "AA-A");
         }
         $GLOBALS['$msgJS'][0] = "Ticket Creado";
         $GLOBALS['$msgJS'][1] = "Ticket ID: ".$ticket->getId();
         $GLOBALS['$msgJS'][2] = "success";
       } else {
         $GLOBALS['$msgJS'][0] = "Algo salio mal";
         $GLOBALS['$msgJS'][1] = "Contacte al administrador del servicio";
         $GLOBALS['$msgJS'][2] = "error";
       }
   } else {
       $GLOBALS['$msgJS'][0] = "Algo salio mal";
       $GLOBALS['$msgJS'][1] = "Contacte al administrador del servicio";
       $GLOBALS['$msgJS'][2] = "error";
      }
     // print_r($GLOBALS['$msgJS']);
     $this->preventivosPrincipal();
   }

   public function preventivosInterventoria(){
     $respuesta['tickets'] = $this->dao_ticket_model->getAllTickets();
     $this->load->view('preventivosI', $respuesta);
   }

   public function preventivosPrincipal(){
     $PVDs = $this->dao_PVD_model->getPVDs();
     for($i = 0; $i < count($PVDs); $i++){
       $PVDs[$i]->setMaintenance($this->dao_maintenance_model->getManPrePerPVD($PVDs[$i]->getId()));
       for($j = 0; $j < count($PVDs[$i]->getMaintenance()); $j++){
         $PVDs[$i]->getMaintenance()[$j]->setTicket($this->dao_ticket_model->getTicketsPerMaintenance($PVDs[$i]->getMaintenance()[$j]->getId()));
       }
     }
     $respuesta['PVDs'] = $PVDs;
     $respuesta['MP'] = $this->arregloGraficasMP($PVDs);
     $respuesta['tablas'] = $this->arregloTablas($respuesta['MP']);
     if ($GLOBALS['$msgJS'] != ""){
       $respuesta['msg'] = $GLOBALS['$msgJS'];
     }
     $this->load->view('preventivosP', $respuesta);
   }

   public function correctivosPrincipal(){
     $respuesta['tickets'] = $this->dao_ticket_model->getAllOtherCorrectiveMaintenances();
     $respuesta['PVDs'] = $this->dao_PVD_model->getPVDs();


     for($i = 0; $i < count($respuesta['tickets']); $i++){
       for($j = 0; $j <  count($respuesta['PVDs']); $j++){
         if($respuesta['tickets'][$i]->idMaintenance == $respuesta['PVDs'][$j]->id){
           $respuesta['tickets'][$i]->idMaintenance = $respuesta['PVDs'][$j];
           // print_r($respuesta['tickets'][$i]);
           // echo "<br><br>";
           $j = count($respuesta['PVDs']);
         }
       }
     }
     $this->load->view('correctivosP', $respuesta);
   }

   function loadMPView(){
       $PVDs = $this->dao_PVD_model->getPVDs();
       for($i = 0; $i < count($PVDs); $i++){
         $PVDs[$i]->setMaintenance($this->dao_maintenance_model->getManPrePerPVD($PVDs[$i]->getId()));
         for($j = 0; $j < count($PVDs[$i]->getMaintenance()); $j++){
           $PVDs[$i]->getMaintenance()[$j]->setTicket($this->dao_ticket_model->getTicketsPerMaintenance($PVDs[$i]->getMaintenance()[$j]->getId()));
         }
       }
       $respuesta['PVDs'] = $PVDs;
       $respuesta['MP'] = $this->arregloGraficasMP($PVDs);
       $respuesta['tablas'] = $this->arregloTablas($respuesta['MP']);
       if ($GLOBALS['$msgJS'] != ""){
         $respuesta['msg'] = $GLOBALS['$msgJS'];
       }
       $this->load->view('MPreventivos', $respuesta);
   }

   function editarMP(){
     // $PVDs = $this->dao_PVD_model->getPVDs();
     // $countPVD = count($PVDs);
     // for($i = 0; $i < $countPVD; $i++){
     //   $PVDs[$i]->setMaintenance($this->dao_maintenance_model->getManPrePerPVD($PVDs[$i]->getId()));
     //   for($j = 0; $j < count($PVDs[$i]->getMaintenance()); $j++){
     //     if($j != 0){
     //       $pvdHelp = clone $PVDs[$i];
     //       $pvdHelp->getMaintenance()[$j]->setTicket($this->dao_ticket_model->getTicketsPerMaintenance($pvdHelp->getMaintenance()[$j]->getId()));
     //       $mant[0] = $pvdHelp->getMaintenance()[$j];
     //       $pvdHelp->setMaintenance($mant);
     //       $PVDs[count($PVDs)] = $pvdHelp;
     //     } else {
     //       $PVDs[$i]->getMaintenance()[0]->setTicket($this->dao_ticket_model->getTicketsPerMaintenance($PVDs[$i]->getMaintenance()[0]->getId()));
     //     }
     //   }
     // }
     // $respuesta['users'] = $this->dao_user_model->getAllUsers();
     // $respuesta['PVDs'] = $PVDs;
     // header('Content-Type: text/plain');
     // print_r($respuesta);
     $this->load->view('EditarMP'/*, $respuesta*/);
   }



   /***************editarMP camilo***************/
   public function getEditarMP(){
    // header('Content-Type: text/plain');
    $respuesta['ticket'] = $this->dao_ticket_model->getAllTicketsCI();
    $respuesta['ticketUser'] = $this->dao_ticket_model->getAllTicketUserCI();
    $respuesta['user'] = $this->dao_user_model->getAllUsersCI();
    $respuesta['maintenance'] = $this->dao_maintenance_model->getAllMaintenancesCI();
    $respuesta['pvd'] = $this->dao_PVD_model->getAllPVDCI();
    $respuesta['city'] = $this->dao_PVD_model->getAllCitiesCI();
    $respuesta['region'] = $this->dao_PVD_model->getAllRegionCI();
    $respuesta['department'] = $this->dao_PVD_model->getAllDepartmentsCI();

    // añadiendo la region a los depart. coincidientes
    for ($i=0; $i < count($respuesta['department']) ; $i++) {
      for ($j=0; $j < count($respuesta['region']); $j++) {
        if ($respuesta['department'][$i]->K_IDREGION == $respuesta['region'][$j]->K_IDREGION) {
          $respuesta['department'][$i]->K_IDREGION = $respuesta['region'][$j];
          $j = count($respuesta['region']) + 1;//+1 se usa para romper el for de abajo
        }
      }
    }
    // añandiendo departments a las city coincidientes
    for ($i=0; $i < count($respuesta['city']) ; $i++) {
      for ($j=0; $j < count($respuesta['department']); $j++) {
        if ($respuesta['city'][$i]->K_IDDEPARTMENT == $respuesta['department'][$j]->K_IDDEPARTMENT) {
          $respuesta['city'][$i]->K_IDDEPARTMENT = $respuesta['department'][$j];
          $j = count($respuesta['department']) + 1;//+1 se usa para romper el for de abajo
        }
      }
    }
    // añandiendo city a los PVD coincidientes
    for ($i=0; $i < count($respuesta['pvd']) ; $i++) {
      for ($j=0; $j < count($respuesta['city']); $j++) {
        if ($respuesta['pvd'][$i]->K_IDCITY == $respuesta['city'][$j]->K_IDCITY) {
          $respuesta['pvd'][$i]->K_IDCITY = $respuesta['city'][$j];
          $j = count($respuesta['city']) + 1;//+1 se usa para romper el for de abajo
        }
      }
    }
    // añandiendo pvd a los maintenance
    for ($i=0; $i < count($respuesta['maintenance']) ; $i++) {
      for ($j=0; $j < count($respuesta['pvd']); $j++) {
        if ($respuesta['maintenance'][$i]->K_IDPVD == $respuesta['pvd'][$j]->K_IDPVD) {
          $respuesta['maintenance'][$i]->K_IDPVD = $respuesta['pvd'][$j];
          $j = count($respuesta['pvd']) + 1;//+1 se usa para romper el for de abajo
        }
      }
    }
    // añandiendo maintenance a los ticket
    for ($i=0; $i < count($respuesta['ticket']) ; $i++) {
      for ($j=0; $j < count($respuesta['maintenance']); $j++) {
        if ($respuesta['ticket'][$i]->K_IDMAINTENANCE == $respuesta['maintenance'][$j]->K_IDMAINTENANCE) {
          $respuesta['ticket'][$i]->K_IDMAINTENANCE = $respuesta['maintenance'][$j];
          $j = count($respuesta['maintenance']) + 1;//+1 se usa para romper el for de abajo
        }
      }
    }
    /****************ahora pasamos de user a ticket****************/
    // añandiendo user a los ticketUser
    for ($i=0; $i < count($respuesta['ticketUser']) ; $i++) {
      for ($j=0; $j < count($respuesta['user']); $j++) {
        if ($respuesta['ticketUser'][$i]->K_IDUSER == $respuesta['user'][$j]->K_IDUSER) {
          $respuesta['ticketUser'][$i]->K_IDUSER = $respuesta['user'][$j];
          $j = count($respuesta['user']) + 1;//+1 se usa para romper el for de abajo
        }
      }
    }
    // añandiendo ticketUser a los ticket
    // Agrego los disintos usuarios de un mismo ticket (ticketUser) a nuestro objeto de ticket

    for ($i=0; $i < count($respuesta['ticket']) ; $i++) {
      $flag = 0;
      for ($j=0; $j < count($respuesta['ticketUser']); $j++) {
        if ($respuesta['ticket'][$i]->K_IDTICKET == $respuesta['ticketUser'][$j]->K_IDTICKET  && $respuesta['ticketUser'][$j]->N_TYPE == 'IT-T') {
          $respuesta['ticket'][$i]->T_IT = $respuesta['ticketUser'][$j];
          $flag++;
        }
        if ($respuesta['ticket'][$i]->K_IDTICKET == $respuesta['ticketUser'][$j]->K_IDTICKET  && $respuesta['ticketUser'][$j]->N_TYPE == 'IT-A') {
          $respuesta['ticket'][$i]->A_IT = $respuesta['ticketUser'][$j];
          $flag++;
        }
        if ($respuesta['ticket'][$i]->K_IDTICKET == $respuesta['ticketUser'][$j]->K_IDTICKET  && $respuesta['ticketUser'][$j]->N_TYPE == 'AA-T') {
          $respuesta['ticket'][$i]->T_AA = $respuesta['ticketUser'][$j];
          $flag++;
        }
        if ($respuesta['ticket'][$i]->K_IDTICKET == $respuesta['ticketUser'][$j]->K_IDTICKET  && $respuesta['ticketUser'][$j]->N_TYPE == 'AA-A') {
          $respuesta['ticket'][$i]->A_AA = $respuesta['ticketUser'][$j];
          $flag++;
        }
        if ($flag == 4){
          $j = count($respuesta['ticketUser']) + 1;//+1 se usa para romper el for de abajo
        }
      }
    }
     // print_r($respuesta['ticket']);
    echo json_encode($respuesta['ticket']);


   }
   /***************FIN  editarMP camilo***************/
   /*Actualizar mantenimiento preventivo Camilo*/
   public function updateMantPreventivo(){
    // recibo los datos enviados por post
    $parameter['ticket'] = $this->input->post('mtxtTicket');
    $parameter['estado'] = $this->input->post('mtxtEstado');
    $parameter['tecIT'] = $this->input->post('mtxtTecIT');
    $parameter['auxIT'] = $this->input->post('mtxtAuxIT');
    $parameter['iniIT'] = $this->input->post('mtxtIniIT');
    $parameter['finIT'] = $this->input->post('mtxtFinIT');
    $parameter['color'] = $this->input->post('mtxtColor');
    $parameter['duracion'] = $this->input->post('mtxtDuracion');
    $parameter['iniMant'] = $this->input->post('mtxtIniMant');
    $parameter['finMant'] = $this->input->post('mtxtFinMant');
    $parameter['tecAA'] = $this->input->post('mtxtTecAA');
    $parameter['auxAA'] = $this->input->post('mtxtAuxAA');
    $parameter['iniAA'] = $this->input->post('mtxtIniAA');
    $parameter['finAA'] = $this->input->post('mtxtFinAA');
    $parameter['observaciones'] = $this->input->post('mtxtObservaciones');
    //enviamos los pareametros al modelo
    $respuesta = $this->dao_ticket_model->updateMantPreventivo($parameter);
    if ($respuesta == null) {
      $respuesta = 1;
    }else{
      $respuesta = 0;
    }

    echo json_encode($respuesta);
   }


   function updateMP(){
   $mantenimientos = $_POST['cantidad'];
   for($i = 0; $i<=$mantenimientos+1;$i++){
     if ($_POST[$i."-1"] != ""){
       $mantenimiento = new maintenance_model();
       $ticket =  new ticket_model();
       $mantenimiento = $mantenimiento->createMaintenance($_POST[$i."-7"],"","",$_POST[$i."-1"]);
       $this->dao_maintenance_model->updateDateManPre($mantenimiento);
       $dateStart = NULL;
       $dateFinish = NULL;
       if($_POST[$i."-3"] == "Ejecutado" || $_POST[$i."-3"] == "En Progreso" || $_POST[$i."-3"] == "Cancelado" || $_POST[$i."-3"] == "Abierto"){
         if($_POST[$i."-8"] != "" && $_POST[$i."-12"] != ""){
           $date1=date_create($_POST[$i."-8"]);
           $date2=date_create($_POST[$i."-12"]);
           $diff=date_diff($date1,$date2);
           $diff = $diff->format("%R%a days")[0];
           if($diff == "+" ){
             $dateStart = $_POST[$i."-8"];
           } else {
             $dateStart = $_POST[$i."-12"];
           }
         }

         if($_POST[$i."-9"] != "" && $_POST[$i."-13"] != ""){
           $date1=date_create($_POST[$i."-9"]);
           $date2=date_create($_POST[$i."-13"]);
           $diff=date_diff($date1,$date2);
           $days = $diff->format("%R%a days");
           $diff = $diff->format("%R%a days")[0];
           if($diff == "+" ){
             $dateFinish = $_POST[$i."-13"];
           } else {
             $dateFinish = $_POST[$i."-9"];
           }
         }

         if($_POST[$i."-8"] == "" && $_POST[$i."-12"] != ""){
           $dateStart = $_POST[$i."-12"];
         }
         if($_POST[$i."-8"] != "" && $_POST[$i."-12"] == ""){
           $dateStart = $_POST[$i."-8"];
         }

         if ($_POST[$i."-3"] == "Cancelado"){
           $color = "000000";
         }
         if ($_POST[$i."-3"] == "Ejecutado"){
           $color = "3399FF";
         }
         if ($_POST[$i."-3"] == "En Progreso"){

           $color = "00CC00";
         }

         $ticket = $ticket->createTicket($_POST[$i."-2"], $_POST[$i."-7"],$_POST[$i."-3"], $dateStart, $dateFinish, "", $_POST[$i."-8"], $_POST[$i."-9"], $_POST[$i."-12"], $_POST[$i."-13"], "", "", $_POST[$i."-observacionesInicio"]);
         $duration = $ticket->calculateDuration();
         $ticket->setDuracion($duration);
         $color = "FFFFFF";
         if ($_POST[$i."-3"] == "Cancelado"){
           $color = "000000";
         }
         if ($_POST[$i."-3"] == "Ejecutado"){
           $color = "3399FF";
         }
         if ($_POST[$i."-3"] == "En Progreso"){
           if($duration <=  2){
             $color = "00CC00";
           }
           if($duration > 2 && $duracion <= 4){
             $color = "FFFF00";
           }
           if($duration > 4 && $duracion <= 6){
             $color = "660066";
           }
           if($duration > 6){
             $color = "FF0000";
           }
         }
         $ticket->setColor($color);
         $oldTicket = $this->dao_ticket_model->getTicketByID($ticket->getId());
         if($oldTicket == "No ticket"){
           $this->dao_ticket_model->insertTicket($ticket, $ticket->getStatus());
         } else {
           $this->dao_ticket_model->updateTicket($ticket, $ticket->getStatus());
         }
         $mantenimiento->setTicket($ticket);
       }
       if($_POST[$i."-10"] != -1){
         if($_POST[$i."-10"] != ""){
           $this->dao_ticket_model->insertTech($ticket->getId(), explode("/",$_POST[$i."-10"])[1], "IT-T");
         }
       }
       if($_POST[$i."-11"] != -1){
         if($_POST[$i."-11"] != ""){
           $this->dao_ticket_model->insertTech($ticket->getId(), explode("/",$_POST[$i."-11"])[1], "IT-A");
         }
       }
       if($_POST[$i."-14"] != -1){
         if($_POST[$i."-14"] != ""){
           $this->dao_ticket_model->insertTech($ticket->getId(), explode("/",$_POST[$i."-14"])[1], "AA-T");
         }
       }
       if($_POST[$i."-15"] != -1){
         if($_POST[$i."-15"] != ""){
           $this->dao_ticket_model->insertTech($ticket->getId(), explode("/",$_POST[$i."-15"])[1], "AA-A");
         }
       }
     }
   }
   $this->editarMP();
 }

   function actualizarMP(){
       $excel = new fileManager;
       $result = $excel->excelReader("uploadMantenimientosP");
       $GLOBALS['$msgJS'][0] = "Bien Hecho";
       $GLOBALS['$msgJS'][1] = "Base de datos actualizada";
       $GLOBALS['$msgJS'][2] = "success";
       $this->loadMPView();
   }

   function arregloTablas($MP){

     $tablas['Enero']['tabla1'] = $this->resumenPreventivosMes($MP, 'Enero');
     $tablas['Enero']['tabla2'] = $this->avanceDepartamentos($MP, 'Enero');
     $tablas['Enero']['tabla3'] = $this->detalleTickets($MP, 'Enero');
     $tablas['Febrero']['tabla1'] = $this->resumenPreventivosMes($MP, 'Febrero');
     $tablas['Febrero']['tabla2'] = $this->avanceDepartamentos($MP, 'Febrero');
     $tablas['Febrero']['tabla3'] = $this->detalleTickets($MP, 'Febrero');
     $tablas['Marzo']['tabla1'] = $this->resumenPreventivosMes($MP, 'Marzo');
     $tablas['Marzo']['tabla2'] = $this->avanceDepartamentos($MP, 'Marzo');
     $tablas['Marzo']['tabla3'] = $this->detalleTickets($MP, 'Marzo');
     $tablas['Abril']['tabla1'] = $this->resumenPreventivosMes($MP, 'Abril');
     $tablas['Abril']['tabla2'] = $this->avanceDepartamentos($MP, 'Abril');
     $tablas['Abril']['tabla3'] = $this->detalleTickets($MP, 'Abril');
     $tablas['Mayo']['tabla1'] = $this->resumenPreventivosMes($MP, 'Mayo');
     $tablas['Mayo']['tabla2'] = $this->avanceDepartamentos($MP, 'Mayo');
     $tablas['Mayo']['tabla3'] = $this->detalleTickets($MP, 'Mayo');
     $tablas['Junio']['tabla1'] = $this->resumenPreventivosMes($MP, 'Junio');
     $tablas['Junio']['tabla2'] = $this->avanceDepartamentos($MP, 'Junio');
     $tablas['Junio']['tabla3'] = $this->detalleTickets($MP, 'Junio');
     $tablas['Julio']['tabla1'] = $this->resumenPreventivosMes($MP, 'Julio');
     $tablas['Julio']['tabla2'] = $this->avanceDepartamentos($MP, 'Julio');
     $tablas['Julio']['tabla3'] = $this->detalleTickets($MP, 'Julio');
     $tablas['Agosto']['tabla1'] = $this->resumenPreventivosMes($MP, 'Agosto');
     $tablas['Agosto']['tabla2'] = $this->avanceDepartamentos($MP, 'Agosto');
     $tablas['Agosto']['tabla3'] = $this->detalleTickets($MP, 'Agosto');
     $tablas['Septiembre']['tabla1'] = $this->resumenPreventivosMes($MP, 'Septiembre');
     $tablas['Septiembre']['tabla2'] = $this->avanceDepartamentos($MP, 'Septiembre');
     $tablas['Septiembre']['tabla3'] = $this->detalleTickets($MP, 'Septiembre');
     $tablas['Octubre']['tabla1'] = $this->resumenPreventivosMes($MP, 'Octubre');
     $tablas['Octubre']['tabla2'] = $this->avanceDepartamentos($MP, 'Octubre');
     $tablas['Octubre']['tabla3'] = $this->detalleTickets($MP, 'Octubre');
     $tablas['Noviembre']['tabla1'] = $this->resumenPreventivosMes($MP, 'Noviembre');
     $tablas['Noviembre']['tabla2'] = $this->avanceDepartamentos($MP, 'Noviembre');
     $tablas['Noviembre']['tabla3'] = $this->detalleTickets($MP, 'Noviembre');
     $tablas['Diciembre']['tabla1'] = $this->resumenPreventivosMes($MP, 'Diciembre');
     $tablas['Diciembre']['tabla2'] = $this->avanceDepartamentos($MP, 'Diciembre');
     $tablas['Diciembre']['tabla3'] = $this->detalleTickets($MP, 'Diciembre');
     return $tablas;
   }

   function avanceDepartamentos($MP, $mes){
     $tabla2['Titulos'][0] = "Departamento";
     $tabla2['Titulos'][1] = "Región";
     $tabla2['Titulos'][2] = "Planeado";
     $tabla2['Titulos'][3] = "Ejecutado";
     $tabla2['Titulos'][4] = "En Progreso";
     $tabla2['Titulos'][5] = "Ejecutado + Progreso";
     $tabla2['Titulos'][6] = "% Ejecución";
     $tabla2['Titulos'][7] = "%(Ejec.+Prog.)";

     $counter = 0;
     for ($i = 0; $i<count($MP[$mes])-2;$i++){
       $flag = "true";
       for($j = 0; $j<count($ciudades); $j++){
         if($MP[$mes][$i]['departamento'] == $ciudades[$j]){
           $flag = "false";
         }
       }
       if($flag == "true"){
         $ciudades[$counter]=$MP[$mes][$i]['departamento'];
         $regiones[$counter]=$MP[$mes][$i]['region'];
         $counter++;
       }
     }
     $tabla2['ciudades'] = $ciudades;

     for ($i = 0; $i<count($MP[$mes])-2;$i++){
       for($j = 0; $j < count($ciudades); $j++){
         $tabla2[$ciudades[$j]][0] = $regiones[$j];
         $tabla2[$ciudades[$j]][1] = 0;
         $tabla2[$ciudades[$j]][2] = 0;
         $tabla2[$ciudades[$j]][3] = 0;
         $tabla2[$ciudades[$j]][4] = 0;
         $tabla2[$ciudades[$j]][5] = 0;
         $tabla2[$ciudades[$j]][6] = 0;
       }
     }

     for ($i = 0; $i<count($MP[$mes])-2;$i++){
       for($j = 0; $j < count($ciudades); $j++){
         if($ciudades[$j] == $MP[$mes][$i]['departamento']){
           if($MP[$mes][$i]['mantenimiento']->getTicket() == "No Ticket" || $MP[$mes][$i]['mantenimiento']->getTicket()[0]->getStatus() == "Abierto"){
             $tabla2[$ciudades[$j]][1]++;
           } else {
             if ($MP[$mes][$i]['mantenimiento']->getTicket()[0]->getStatus() == "Ejecutado" ){
               $tabla2[$ciudades[$j]][2]++;
               $tabla2[$ciudades[$j]][1]++;
             } else {
               $tabla2[$ciudades[$j]][3]++;
               $tabla2[$ciudades[$j]][1]++;
             }
           }
         }
       }
     }

     $precision = 2;
     for ($i = 0; $i<count($MP[$mes])-2;$i++){
       for($j = 0; $j < count($ciudades); $j++){
         $tabla2[$ciudades[$j]][4] = $tabla2[$ciudades[$j]][3] + $tabla2[$ciudades[$j]][2];
         $tabla2[$ciudades[$j]][5] = number_format((float) 100/$tabla2[$ciudades[$j]][1]*$tabla2[$ciudades[$j]][2], $precision, '.', '');
         $tabla2[$ciudades[$j]][6] = number_format((float) 100/$tabla2[$ciudades[$j]][1]*$tabla2[$ciudades[$j]][4], $precision, '.', '');
       }
     }
     return $tabla2;
   }

   function detalleTickets($MP, $mes){
     $tabla3['Titulos'][0] = "";
     $tabla3['Titulos'][1] = "Item";
     $tabla3['Titulos'][2] = "Región ";
     $tabla3['Titulos'][3] = "Departamento / Ciudad";
     $tabla3['Titulos'][4] = "PVD";
     $tabla3['Titulos'][5] = "Tipo";
     $tabla3['Titulos'][6] = "Ticket";
     $tabla3['Titulos'][8] = "Inicio";
     $tabla3['Titulos'][9] = "Fin";
     $tabla3['Titulos'][10] = "Días";
     $tabla3['Titulos'][7] = "Estado";

     $contador = 0;
     for ($i = 0; $i<count($MP[$mes])-2;$i++){
       if ($MP[$mes][$i]['mantenimiento']->getTicket() != 'No Ticket'){
           $tabla3['lineas'][$contador][1] = $contador+1;
           $tabla3['lineas'][$contador][8] = $MP[$mes][$i]['mantenimiento']->getTicket()[0]->getDateS();
           $tabla3['lineas'][$contador][9] = $MP[$mes][$i]['mantenimiento']->getTicket()[0]->getDateF();
           $tabla3['lineas'][$contador][10] = $MP[$mes][$i]['mantenimiento']->getTicket()[0]->getDuracion();
           $tabla3['lineas'][$contador][2] = $MP[$mes][$i]['region'];
           $tabla3['lineas'][$contador][7] = $MP[$mes][$i]['mantenimiento']->getTicket()[0]->getStatus();
           $tabla3['lineas'][$contador][6] = $MP[$mes][$i]['mantenimiento']->getTicket()[0]->getId();
           $tabla3['lineas'][$contador][4] = $MP[$mes][$i]['idPVD'];
           $tabla3['lineas'][$contador][5] = $this->dao_ticket_model->getProgress($MP[$mes][$i]['mantenimiento']->getTicket()[0]->getId());
           $tabla3['lineas'][$contador][3] = $MP[$mes][$i]['departamento']." / ".$MP[$mes][$i]['ciudad'];
           $tabla3['lineas'][$contador][0] = $MP[$mes][$i]['mantenimiento']->getTicket()[0]->getColor();
           $contador++;
       }
     }
     return $tabla3;
   }

   function resumenPreventivosMes($MP, $mes){
     $precision = 2;
     $tabla1['Titulos'][0] = "Región";
     $tabla1['Titulos'][1] = "Planeado";
     $tabla1['Titulos'][2] = "Ejecutado";
     $tabla1['Titulos'][3] = "En Progreso";
     $tabla1['Titulos'][4] = "Ejecutado + Progreso";
     $tabla1['Titulos'][5] = "% Ejecución";
     $tabla1['Titulos'][6] = "% (Ejecución + Progreso)";

     $tabla1['linea1'][0]='Región 1';
     $tabla1['linea1'][1]= $MP[$mes]['Zona']['Zona1']['Estado']['Progreso']+$MP[$mes]['Zona']['Zona1']['Estado']['Ejecutado']+$MP[$mes]['Zona']['Zona1']['Estado']['Abierto'];
     $tabla1['linea1'][2]= $MP[$mes]['Zona']['Zona1']['Estado']['Ejecutado'];
     $tabla1['linea1'][3]= $MP[$mes]['Zona']['Zona1']['Estado']['Progreso'];
     $tabla1['linea1'][4]= $MP[$mes]['Zona']['Zona1']['Estado']['Progreso']+$MP[$mes]['Zona']['Zona1']['Estado']['Ejecutado'];
     $tabla1['linea1'][5]= number_format((float) 100/$tabla1['linea1'][1]*$tabla1['linea1'][2], $precision, '.', '');
     $tabla1['linea1'][6]= number_format((float) 100/$tabla1['linea1'][1]*($tabla1['linea1'][2]+$tabla1['linea1'][3]), $precision, '.', '');

     $tabla1['linea2'][0]='Región 4';
     $tabla1['linea2'][1]= $MP[$mes]['Zona']['Zona4']['Estado']['Progreso']+$MP[$mes]['Zona']['Zona4']['Estado']['Ejecutado']+$MP[$mes]['Zona']['Zona4']['Estado']['Abierto'];
     $tabla1['linea2'][2]= $MP[$mes]['Zona']['Zona4']['Estado']['Ejecutado'];
     $tabla1['linea2'][3]= $MP[$mes]['Zona']['Zona4']['Estado']['Progreso'];
     $tabla1['linea2'][4]= $MP[$mes]['Zona']['Zona4']['Estado']['Progreso']+$MP[$mes]['Zona']['Zona4']['Estado']['Ejecutado'];
     $tabla1['linea2'][5]= number_format((float) 100/$tabla1['linea2'][1]*$tabla1['linea2'][2], $precision, '.', '');
     $tabla1['linea2'][6]= number_format((float) 100/$tabla1['linea2'][1]*($tabla1['linea2'][2]+$tabla1['linea2'][3]), $precision, '.', '');

     $tabla1['linea3'][0]= "Total";
     $tabla1['linea3'][1]= $tabla1['linea2'][1]+$tabla1['linea1'][1];
     $tabla1['linea3'][2]= $tabla1['linea2'][2]+$tabla1['linea1'][2];
     $tabla1['linea3'][3]= $tabla1['linea2'][3]+$tabla1['linea1'][3];
     $tabla1['linea3'][4]= $tabla1['linea2'][4]+$tabla1['linea1'][4];
     $tabla1['linea3'][5]= number_format((float) (100/($tabla1['linea2'][1]+$tabla1['linea1'][1]))*($tabla1['linea2'][2]+$tabla1['linea1'][2]), $precision, '.', '');
     $tabla1['linea3'][6]= number_format((float) (100/($tabla1['linea2'][1]+$tabla1['linea1'][1]))*($tabla1['linea2'][2]+$tabla1['linea1'][2]+$tabla1['linea1'][3]+$tabla1['linea2'][3]), $precision, '.', '');

     return $tabla1;
   }

   function arregloGraficasMP($PVDs){
     $MP = $this->definirArregloMP();

     for($i = 0; $i < count($PVDs); $i++){
       for($j = 0; $j < count($PVDs[$i]->getMaintenance()); $j++){
         $MP = $this->reconocerMes($PVDs[$i]->getMaintenance()[$j], $MP, $PVDs[$i]->getRegion(), $PVDs[$i]->getCity(), $PVDs[$i]->getDepartment(), $PVDs[$i]->getId(), $PVDs[$i]->getRegion(),$PVDs[$i]->getTipologia());
       }
     }
     return $MP;
   }

   function reconocerMes($mantenimiento , $MP, $region, $city, $department, $id, $regionPVD, $tipologia){
     $month = explode("-",$mantenimiento->getDate());
     switch ($month[1]) {
       case 1:
         $MP['Enero'][$MP['Enero']['contador']]['mantenimiento']= $mantenimiento;
         $MP['Enero'][$MP['Enero']['contador']]['ciudad']= $city;
         $MP['Enero'][$MP['Enero']['contador']]['departamento']= $department;
         $MP['Enero'][$MP['Enero']['contador']]['idPVD']= $id;
         $MP['Enero'][$MP['Enero']['contador']]['region']= $regionPVD;
         $MP['Enero'][$MP['Enero']['contador']]['tipologia']= $tipologia;
         $MP['Enero']['contador']++;
         $MP['Enero']['Zona']=$this->reconocerZona($region, $MP['Enero']['Zona'], $mantenimiento);
         break;
       case 2:
         $MP['Febrero'][$MP['Febrero']['contador']]['mantenimiento']= $mantenimiento;
         $MP['Febrero'][$MP['Febrero']['contador']]['ciudad']= $city;
         $MP['Febrero'][$MP['Febrero']['contador']]['departamento']= $department;
         $MP['Febrero'][$MP['Febrero']['contador']]['idPVD']= $id;
         $MP['Febrero'][$MP['Febrero']['contador']]['region']= $regionPVD;
         $MP['Febrero'][$MP['Febrero']['contador']]['tipologia']= $tipologia;
         $MP['Febrero']['contador']++;
         $MP['Febrero']['Zona']=$this->reconocerZona($region, $MP['Febrero']['Zona'], $mantenimiento);
         break;
       case 3:
         $MP['Marzo'][$MP['Marzo']['contador']]['mantenimiento']= $mantenimiento;
         $MP['Marzo'][$MP['Marzo']['contador']]['ciudad']= $city;
         $MP['Marzo'][$MP['Marzo']['contador']]['departamento']= $department;
         $MP['Marzo'][$MP['Marzo']['contador']]['idPVD']= $id;
         $MP['Marzo'][$MP['Marzo']['contador']]['region']= $regionPVD;
         $MP['Marzo'][$MP['Marzo']['contador']]['tipologia']= $tipologia;
         $MP['Marzo']['contador']++;
         $MP['Marzo']['Zona']=$this->reconocerZona($region, $MP['Marzo']['Zona'], $mantenimiento);
         break;
       case 4:
         $MP['Abril'][$MP['Abril']['contador']]['mantenimiento']= $mantenimiento;
         $MP['Abril'][$MP['Abril']['contador']]['ciudad']= $city;
         $MP['Abril'][$MP['Abril']['contador']]['departamento']= $department;
         $MP['Abril'][$MP['Abril']['contador']]['idPVD']= $id;
         $MP['Abril'][$MP['Abril']['contador']]['region']= $regionPVD;
         $MP['Abril'][$MP['Abril']['contador']]['tipologia']= $tipologia;
         $MP['Abril']['contador']++;
         $MP['Abril']['Zona']=$this->reconocerZona($region, $MP['Abril']['Zona'], $mantenimiento);
         break;
       case 5:
         $MP['Mayo'][$MP['Mayo']['contador']]['mantenimiento']= $mantenimiento;
         $MP['Mayo'][$MP['Mayo']['contador']]['ciudad']= $city;
         $MP['Mayo'][$MP['Mayo']['contador']]['departamento']= $department;
         $MP['Mayo'][$MP['Mayo']['contador']]['idPVD']= $id;
         $MP['Mayo'][$MP['Mayo']['contador']]['region']= $regionPVD;
         $MP['Mayo'][$MP['Mayo']['contador']]['tipologia']= $tipologia;
         $MP['Mayo']['contador']++;
         $MP['Mayo']['Zona']=$this->reconocerZona($region, $MP['Mayo']['Zona'], $mantenimiento);
         break;
       case 6:
         $MP['Junio'][$MP['Junio']['contador']]['mantenimiento']= $mantenimiento;
         $MP['Junio'][$MP['Junio']['contador']]['ciudad']= $city;
         $MP['Junio'][$MP['Junio']['contador']]['departamento']= $department;
         $MP['Junio'][$MP['Junio']['contador']]['idPVD']= $id;
         $MP['Junio'][$MP['Junio']['contador']]['region']= $regionPVD;
         $MP['Junio'][$MP['Junio']['contador']]['tipologia']= $tipologia;
         $MP['Junio']['contador']++;
         $MP['Junio']['Zona']=$this->reconocerZona($region, $MP['Junio']['Zona'], $mantenimiento);
         break;
       case 7:
         $MP['Julio'][$MP['Julio']['contador']]['mantenimiento']= $mantenimiento;
         $MP['Julio'][$MP['Julio']['contador']]['ciudad']= $city;
         $MP['Julio'][$MP['Julio']['contador']]['departamento']= $department;
         $MP['Julio'][$MP['Julio']['contador']]['idPVD']= $id;
         $MP['Julio'][$MP['Julio']['contador']]['region']= $regionPVD;
         $MP['Julio'][$MP['Julio']['contador']]['tipologia']= $tipologia;
         $MP['Julio']['contador']++;
         $MP['Julio']['Zona']=$this->reconocerZona($region, $MP['Julio']['Zona'], $mantenimiento);
         break;
       case 8:
         $MP['Agosto'][$MP['Agosto']['contador']]['mantenimiento']= $mantenimiento;
         $MP['Agosto'][$MP['Agosto']['contador']]['ciudad']= $city;
         $MP['Agosto'][$MP['Agosto']['contador']]['departamento']= $department;
         $MP['Agosto'][$MP['Agosto']['contador']]['idPVD']= $id;
         $MP['Agosto'][$MP['Agosto']['contador']]['region']= $regionPVD;
         $MP['Agosto'][$MP['Agosto']['contador']]['tipologia']= $tipologia;
         $MP['Agosto']['contador']++;
         $MP['Agosto']['Zona']=$this->reconocerZona($region, $MP['Agosto']['Zona'], $mantenimiento);
         break;
       case 9:
         $MP['Septiembre'][$MP['Septiembre']['contador']]['mantenimiento']= $mantenimiento;
         $MP['Septiembre'][$MP['Septiembre']['contador']]['ciudad']= $city;
         $MP['Septiembre'][$MP['Septiembre']['contador']]['departamento']= $department;
         $MP['Septiembre'][$MP['Septiembre']['contador']]['idPVD']= $id;
         $MP['Septiembre'][$MP['Septiembre']['contador']]['region']= $regionPVD;
         $MP['Septiembre'][$MP['Septiembre']['contador']]['tipologia']= $tipologia;
         $MP['Septiembre']['contador']++;
         $MP['Septiembre']['Zona']=$this->reconocerZona($region, $MP['Septiembre']['Zona'], $mantenimiento);
         break;
       case 10:
         $MP['Octubre'][$MP['Octubre']['contador']]['mantenimiento']= $mantenimiento;
         $MP['Octubre'][$MP['Octubre']['contador']]['ciudad']= $city;
         $MP['Octubre'][$MP['Octubre']['contador']]['departamento']= $department;
         $MP['Octubre'][$MP['Octubre']['contador']]['idPVD']= $id;
         $MP['Octubre'][$MP['Octubre']['contador']]['region']= $regionPVD;
         $MP['Octubre'][$MP['Octubre']['contador']]['tipologia']= $tipologia;
         $MP['Octubre']['contador']++;
         $MP['Octubre']['Zona']=$this->reconocerZona($region, $MP['Octubre']['Zona'], $mantenimiento);
         break;
       case 11:
         $MP['Noviembre'][$MP['Noviembre']['contador']]['mantenimiento']= $mantenimiento;
         $MP['Noviembre'][$MP['Noviembre']['contador']]['ciudad']= $city;
         $MP['Noviembre'][$MP['Noviembre']['contador']]['departamento']= $department;
         $MP['Noviembre'][$MP['Noviembre']['contador']]['idPVD']= $id;
         $MP['Noviembre'][$MP['Noviembre']['contador']]['region']= $regionPVD;
         $MP['Noviembre'][$MP['Noviembre']['contador']]['tipologia']= $tipologia;
         $MP['Noviembre']['contador']++;
         $MP['Noviembre']['Zona']=$this->reconocerZona($region, $MP['Noviembre']['Zona'], $mantenimiento);
         break;
       case 12:
         $MP['Diciembre'][$MP['Diciembre']['contador']]['mantenimiento']= $mantenimiento;
         $MP['Diciembre'][$MP['Diciembre']['contador']]['ciudad']= $city;
         $MP['Diciembre'][$MP['Diciembre']['contador']]['departamento']= $department;
         $MP['Diciembre'][$MP['Diciembre']['contador']]['idPVD']= $id;
         $MP['Diciembre'][$MP['Diciembre']['contador']]['region']= $regionPVD;
         $MP['Diciembre'][$MP['Diciembre']['contador']]['tipologia']= $tipologia;
         $MP['Diciembre']['contador']++;
         $MP['Diciembre']['Zona']=$this->reconocerZona($region, $MP['Diciembre']['Zona'], $mantenimiento);
         break;
       default:
         break;
     }
     return $MP;
   }

   function reconocerZona($zona, $arregloZona, $mantenimiento){
     switch ($zona) {
       case 'Zona 1':
         $arregloZona['Zona1']['Cantidad']++;
         $arregloZona['Zona1']['Estado'] = $this->reconocerEstado($mantenimiento->getTicket(), $arregloZona['Zona1']['Estado']);
         break;
       case 'Zona 4':
         $arregloZona['Zona4']['Cantidad']++;
         $arregloZona['Zona4']['Estado'] = $this->reconocerEstado($mantenimiento->getTicket(), $arregloZona['Zona4']['Estado']);
         break;
       default:
         break;
     }
     return $arregloZona;
   }

   function reconocerEstado($estado, $arregloEstado){
     if($estado != 'No Ticket'){
       $estado = $estado[0]->getStatus();
     }

     switch ($estado) {
       case 'Abierto':
         $arregloEstado['Abierto']++;
         break;
       case 'No Ticket':
         $arregloEstado['Abierto']++;
         break;
       case 'En Progreso':
         $arregloEstado['Progreso']++;
         break;
       case 'Ejecutado':
         $arregloEstado['Ejecutado']++;
         break;
       default:
         break;
     }
     return $arregloEstado;
   }

   function definirArregloMP(){
     $MP['Enero']['contador']=0;
     $MP['Febrero']['contador']=0;
     $MP['Marzo']['contador']=0;
     $MP['Abril']['contador']=0;
     $MP['Mayo']['contador']=0;
     $MP['Junio']['contador']=0;
     $MP['Julio']['contador']=0;
     $MP['Agosto']['contador']=0;
     $MP['Septiembre']['contador']=0;
     $MP['Octubre']['contador']=0;
     $MP['Noviembre']['contador']=0;
     $MP['Diciembre']['contador']=0;

     $MP['Enero']['Zona']['Zona1']['Cantidad']=0;
     $MP['Enero']['Zona']['Zona4']['Cantidad']=0;
     $MP['Febrero']['Zona']['Zona1']['Cantidad']=0;
     $MP['Febrero']['Zona']['Zona4']['Cantidad']=0;
     $MP['Marzo']['Zona']['Zona1']['Cantidad']=0;
     $MP['Marzo']['Zona']['Zona4']['Cantidad']=0;
     $MP['Abril']['Zona']['Zona1']['Cantidad']=0;
     $MP['Abril']['Zona']['Zona4']['Cantidad']=0;
     $MP['Mayo']['Zona']['Zona1']['Cantidad']=0;
     $MP['Mayo']['Zona']['Zona4']['Cantidad']=0;
     $MP['Junio']['Zona']['Zona1']['Cantidad']=0;
     $MP['Junio']['Zona']['Zona4']['Cantidad']=0;
     $MP['Julio']['Zona']['Zona1']['Cantidad']=0;
     $MP['Julio']['Zona']['Zona4']['Cantidad']=0;
     $MP['Agosto']['Zona']['Zona1']['Cantidad']=0;
     $MP['Agosto']['Zona']['Zona4']['Cantidad']=0;
     $MP['Septiembre']['Zona']['Zona1']['Cantidad']=0;
     $MP['Septiembre']['Zona']['Zona4']['Cantidad']=0;
     $MP['Octubre']['Zona']['Zona1']['Cantidad']=0;
     $MP['Octubre']['Zona']['Zona4']['Cantidad']=0;
     $MP['Noviembre']['Zona']['Zona1']['Cantidad']=0;
     $MP['Noviembre']['Zona']['Zona4']['Cantidad']=0;
     $MP['Diciembre']['Zona']['Zona1']['Cantidad']=0;
     $MP['Diciembre']['Zona']['Zona4']['Cantidad']=0;

     $MP['Enero']['Zona']['Zona1']['Estado']['Abierto']=0;
     $MP['Enero']['Zona']['Zona1']['Estado']['Ejecutado']=0;
     $MP['Enero']['Zona']['Zona1']['Estado']['Progreso']=0;
     $MP['Enero']['Zona']['Zona4']['Estado']['Abierto']=0;
     $MP['Enero']['Zona']['Zona4']['Estado']['Ejecutado']=0;
     $MP['Enero']['Zona']['Zona4']['Estado']['Progreso']=0;
     $MP['Febrero']['Zona']['Zona1']['Estado']['Abierto']=0;
     $MP['Febrero']['Zona']['Zona1']['Estado']['Ejecutado']=0;
     $MP['Febrero']['Zona']['Zona1']['Estado']['Progreso']=0;
     $MP['Febrero']['Zona']['Zona4']['Estado']['Abierto']=0;
     $MP['Febrero']['Zona']['Zona4']['Estado']['Ejecutado']=0;
     $MP['Febrero']['Zona']['Zona4']['Estado']['Progreso']=0;
     $MP['Marzo']['Zona']['Zona1']['Estado']['Abierto']=0;
     $MP['Marzo']['Zona']['Zona1']['Estado']['Ejecutado']=0;
     $MP['Marzo']['Zona']['Zona1']['Estado']['Progreso']=0;
     $MP['Marzo']['Zona']['Zona4']['Estado']['Abierto']=0;
     $MP['Marzo']['Zona']['Zona4']['Estado']['Ejecutado']=0;
     $MP['Marzo']['Zona']['Zona4']['Estado']['Progreso']=0;
     $MP['Abril']['Zona']['Zona1']['Estado']['Abierto']=0;
     $MP['Abril']['Zona']['Zona1']['Estado']['Ejecutado']=0;
     $MP['Abril']['Zona']['Zona1']['Estado']['Progreso']=0;
     $MP['Abril']['Zona']['Zona4']['Estado']['Abierto']=0;
     $MP['Abril']['Zona']['Zona4']['Estado']['Ejecutado']=0;
     $MP['Abril']['Zona']['Zona4']['Estado']['Progreso']=0;
     $MP['Mayo']['Zona']['Zona1']['Estado']['Abierto']=0;
     $MP['Mayo']['Zona']['Zona1']['Estado']['Ejecutado']=0;
     $MP['Mayo']['Zona']['Zona1']['Estado']['Progreso']=0;
     $MP['Mayo']['Zona']['Zona4']['Estado']['Abierto']=0;
     $MP['Mayo']['Zona']['Zona4']['Estado']['Ejecutado']=0;
     $MP['Mayo']['Zona']['Zona4']['Estado']['Progreso']=0;
     $MP['Junio']['Zona']['Zona1']['Estado']['Abierto']=0;
     $MP['Junio']['Zona']['Zona1']['Estado']['Ejecutado']=0;
     $MP['Junio']['Zona']['Zona1']['Estado']['Progreso']=0;
     $MP['Junio']['Zona']['Zona4']['Estado']['Abierto']=0;
     $MP['Junio']['Zona']['Zona4']['Estado']['Ejecutado']=0;
     $MP['Junio']['Zona']['Zona4']['Estado']['Progreso']=0;
     $MP['Julio']['Zona']['Zona1']['Estado']['Abierto']=0;
     $MP['Julio']['Zona']['Zona1']['Estado']['Ejecutado']=0;
     $MP['Julio']['Zona']['Zona1']['Estado']['Progreso']=0;
     $MP['Julio']['Zona']['Zona4']['Estado']['Abierto']=0;
     $MP['Julio']['Zona']['Zona4']['Estado']['Ejecutado']=0;
     $MP['Julio']['Zona']['Zona4']['Estado']['Progreso']=0;
     $MP['Agosto']['Zona']['Zona1']['Estado']['Abierto']=0;
     $MP['Agosto']['Zona']['Zona1']['Estado']['Ejecutado']=0;
     $MP['Agosto']['Zona']['Zona1']['Estado']['Progreso']=0;
     $MP['Agosto']['Zona']['Zona4']['Estado']['Abierto']=0;
     $MP['Agosto']['Zona']['Zona4']['Estado']['Ejecutado']=0;
     $MP['Agosto']['Zona']['Zona4']['Estado']['Progreso']=0;
     $MP['Septiembre']['Zona']['Zona1']['Estado']['Abierto']=0;
     $MP['Septiembre']['Zona']['Zona1']['Estado']['Ejecutado']=0;
     $MP['Septiembre']['Zona']['Zona1']['Estado']['Progreso']=0;
     $MP['Septiembre']['Zona']['Zona4']['Estado']['Abierto']=0;
     $MP['Septiembre']['Zona']['Zona4']['Estado']['Ejecutado']=0;
     $MP['Septiembre']['Zona']['Zona4']['Estado']['Progreso']=0;
     $MP['Octubre']['Zona']['Zona1']['Estado']['Abierto']=0;
     $MP['Octubre']['Zona']['Zona1']['Estado']['Ejecutado']=0;
     $MP['Octubre']['Zona']['Zona1']['Estado']['Progreso']=0;
     $MP['Octubre']['Zona']['Zona4']['Estado']['Abierto']=0;
     $MP['Octubre']['Zona']['Zona4']['Estado']['Ejecutado']=0;
     $MP['Octubre']['Zona']['Zona4']['Estado']['Progreso']=0;
     $MP['Noviembre']['Zona']['Zona1']['Estado']['Abierto']=0;
     $MP['Noviembre']['Zona']['Zona1']['Estado']['Ejecutado']=0;
     $MP['Noviembre']['Zona']['Zona1']['Estado']['Progreso']=0;
     $MP['Noviembre']['Zona']['Zona4']['Estado']['Abierto']=0;
     $MP['Noviembre']['Zona']['Zona4']['Estado']['Ejecutado']=0;
     $MP['Noviembre']['Zona']['Zona4']['Estado']['Progreso']=0;
     $MP['Diciembre']['Zona']['Zona1']['Estado']['Abierto']=0;
     $MP['Diciembre']['Zona']['Zona1']['Estado']['Ejecutado']=0;
     $MP['Diciembre']['Zona']['Zona1']['Estado']['Progreso']=0;
     $MP['Diciembre']['Zona']['Zona4']['Estado']['Abierto']=0;
     $MP['Diciembre']['Zona']['Zona4']['Estado']['Ejecutado']=0;
     $MP['Diciembre']['Zona']['Zona4']['Estado']['Progreso']=0;
     return $MP;
   }

   public function loadCorrectiveView(){
     // $respuesta['tickets'] = $this->dao_ticket_model->getAllOtherCorrectiveMaintenances();
     $respuesta['tickets'] = $this->dao_ticket_model->getAllOtherCorrectiveMaintenances();
     $respuesta['pvds'] = $this->dao_PVD_model->getPVDs();

     // print_r($respuesta['pvds']);
     for($i = 0; $i < count($respuesta['tickets']); $i++){
       for($j = 0; $j < count($respuesta['pvds']); $j++){
         if($respuesta['pvds'][$j]->id == $respuesta['tickets'][$i]->idMaintenance){
           $respuesta['tickets'][$i]->idMaintenance = $respuesta['pvds'][$j];
         }
       }
     }
    // print_r($respuesta['tickets']);
     $this->load->view('correctiveMaintenances', $respuesta);

   }
}

?>

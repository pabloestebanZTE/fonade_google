<?php

 defined('BASEPATH') OR exit('No direct script access allowed');
 $msj = "";
class Ticket extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('data/dao_maintenance_model');
        $this->load->model('data/dao_PVD_model');
        $this->load->model('data/dao_ticket_model');
        $this->load->model('data/dao_user_model');
    }

    public function TicketPrincipal(){
      $this->load->view('ticketsPrincipal');
    }

    public function TicketCreation(){
        $respuesta['pvds'] = $this->dao_PVD_model->getPVDs();
        $respuesta['users'] = $this->dao_user_model->getAllUsers();
        $respuesta['msj'] = $GLOBALS['$msj'];
        $this->load->view('ticketCreation', $respuesta);
    }

    public function ticketDetails(){
      $respuesta['ticket'] = $this->dao_ticket_model->getTicketByID($_GET['k_ticket']);
      $respuesta = $this->fixArrayUsers($respuesta);
      $respuesta['maintenance'] = $this->dao_maintenance_model->getManPrePerID($respuesta['ticket']->getIdM());
      $respuesta['PVD'] = $this->dao_PVD_model->getPVDbyId($respuesta['maintenance']->getIdPVD());
      $this->load->view('ticketDetail', $respuesta);
    }

    public function ticketCorrectiveDetails(){
      echo "correctivos";
      $respuesta['ticket'] = $this->dao_ticket_model->getCorrectiveTicketByID($_GET['k_ticket']);
      // $respuesta = $this->fixArrayUsers($respuesta);
      // $respuesta['maintenance'] = $this->dao_maintenance_model->getManPrePerID($respuesta['ticket']->getIdM());
      // $respuesta['PVD'] = $this->dao_PVD_model->getPVDbyId($respuesta['maintenance']->getIdPVD());
      // $this->load->view('ticketDetail', $respuesta);
    }

     //----------------------------------camilo----------------------------------
    public function ticketODetails(){
      $respuesta['ticket']=$this->dao_ticket_model->getTicketOByID($_GET['k_ticket']);
      $this->load->view('ticketODetails',$respuesta);
      }
//------------------------------------------------------------------------------

    public function fixArrayUsers($respuesta){
      $i = 0;
      if($respuesta['ticket']->getTechs()['users']>0){
        if($respuesta['ticket']->getTechs()['users']['AA_T'] != ""){
          $respuesta['viaticos'][$i] =  $respuesta['ticket']->getTechs()['users']['AA_T'];
          $i++;
        }
        if($respuesta['ticket']->getTechs()['users']['AA_A'] != ""){
          $respuesta['viaticos'][$i] =  $respuesta['ticket']->getTechs()['users']['AA_A'];
          $i++;
        }
        if($respuesta['ticket']->getTechs()['users']['IT_T'] != ""){
          $respuesta['viaticos'][$i] =  $respuesta['ticket']->getTechs()['users']['IT_T'];
          $i++;
        }
        if($respuesta['ticket']->getTechs()['users']['IT_A'] != ""){
          $respuesta['viaticos'][$i] =  $respuesta['ticket']->getTechs()['users']['IT_A'];
          $i++;
        }
      }
      return $respuesta;
    }

    public function updateTicketDetail(){
      $this->dao_ticket_model->updateTicketDetails($_POST);
      $respuesta['ticket'] = $this->dao_ticket_model->getTicketByID($_POST['id']);
      $respuesta = $this->fixArrayUsers($respuesta);
      $respuesta['maintenance'] = $this->dao_maintenance_model->getManPrePerID($respuesta['ticket']->getIdM());
      $respuesta['PVD'] = $this->dao_PVD_model->getPVDbyId($respuesta['maintenance']->getIdPVD());
      $this->load->view('ticketDetail', $respuesta);
    }

    public function OtherTicketsPrincipal(){
      $respuesta['tickets'] = $this->dao_ticket_model->getAllOtherMaintenances();
      $this->load->view('OthersPrincipal', $respuesta);
    }

    public function OtherTicketCreation(){
      $respuesta['categorias'] = $this->dao_ticket_model->getAllOtherCategories();
      $respuesta['pvds'] = $this->dao_PVD_model->getPVDs();
      $respuesta['users'] = $this->dao_user_model->getAllUsers();
      $respuesta['msj'] = $GLOBALS['$msj'];
      $this->load->view('ticketOtherCreation', $respuesta);
    }

    public function CorrectiveCreation(){
      $respuesta['categorias'] = $this->dao_ticket_model->getAllOtherCategories();
      $respuesta['pvds'] = $this->dao_PVD_model->getPVDs();
      $respuesta['users'] = $this->dao_user_model->getAllUsers();
      $respuesta['msj'] = $GLOBALS['$msj'];
      $this->load->view('ticketCorrectiveCreation', $respuesta);
    }

    public function createOtherTicket(){
      if($_POST['tipo'] == 6){
        $ticket = $this->dao_ticket_model->createTicketCCC($_POST['fieldCCC'],  explode("/", $_POST['pvd'])[0],$_POST['Observaciones'], $_POST['selectTipo']);
      } else {
        $j = 0;
        for($i = 6; $i<count($_POST); $i++){
          if(explode("/",$_POST['tec-'.$j])[1] != ""){
            $users[$j] = explode("/",$_POST['tec-'.$j])[1];
            $j++;
          }
        }
        $pvd = explode("/", $_POST['pvd'])[0];
        $ticketO = new ticket_model;
        if($_POST['tipo'] != 7){
          $ticketO = $ticketO->createTicket("TO-",$pvd,$_POST['tipo'], $_POST['date'], $_POST['dateF'], $_POST['duracion'], "", "", "", "", $users, "", $_POST['Observaciones']);
        } else {
          $ticketO = $ticketO->createTicket("TC-",$pvd,$_POST['tipo'], $_POST['date'], $_POST['dateF'], $_POST['duracion'], "", "", "", "", $users, "", $_POST['Observaciones']);
          $ticketO->setAlmuerzos($_POST['fieldCCC']);
        }
        $duration = $ticketO->calculateDuration();
        $ticketO->setDuracion($duration);
        $ticket = $this->dao_ticket_model->insertOtherTicket($ticketO);
      }
      if($ticket == "Error en BD"){
        $respuesta['msg'][0] = "Algo salio mal, no se pudo crear el ticket";
        $respuesta['msg'][1] = "Contacte al administrador del servicio";
        $respuesta['msg'][2] = "error";
      } else {
        $respuesta['msg'][1] = $ticket;
        $respuesta['msg'][0] = "Ticket Creado";
        $respuesta['msg'][2] = "success";
      }
      $respuesta['hola'] = "hola";
      $respuesta['tickets'] = $this->dao_ticket_model->getAllOtherMaintenances();
      $this->load->view('OthersPrincipal', $respuesta);
    }

    public function createCorrectiveTicket(){
      $_POST['tipo'] = 7;
      if($_POST['tipo'] == 6){
        // $ticket = $this->dao_ticket_model->createTicketCCC($_POST['fieldCCC'],  explode("/", $_POST['pvd'])[0],$_POST['Observaciones'], $_POST['selectTipo']);
      } else {
        $j = 0;
        for($i = 6; $i<count($_POST); $i++){
          if(explode("/",$_POST['tec-'.$j])[1] != ""){
            $users[$j] = explode("/",$_POST['tec-'.$j])[1];
            $j++;
          }
        }
        $pvd = explode("/", $_POST['pvd'])[0];
        $ticketO = new ticket_model;
        if($_POST['tipo'] != 7){
          // $ticketO = $ticketO->createTicket("TO-",$pvd,$_POST['tipo'], $_POST['date'], $_POST['dateF'], $_POST['duracion'], "", "", "", "", $users, "", $_POST['Observaciones']);
        } else {
          $ticketO = $ticketO->createTicket("TC-",$pvd,$_POST['tipo'], $_POST['date'], $_POST['dateF'], $_POST['duracion'], "", "", "", "", $users, "", $_POST['Observaciones']);
          $ticketO->setAlmuerzos($_POST['fieldCCC']);
        }
        $duration = $ticketO->calculateDuration();
        $ticketO->setDuracion($duration);
        $ticketO->setColor($_POST['tipoC']);

        $ticket = $this->dao_ticket_model->insertOtherTicket($ticketO);
      }
      if($ticket == "Error en BD"){
        $respuesta['msg'][0] = "Algo salio mal, no se pudo crear el ticket";
        $respuesta['msg'][1] = "Contacte al administrador del servicio";
        $respuesta['msg'][2] = "error";
      } else {
        $respuesta['msg'][1] = $ticket;
        $respuesta['msg'][0] = "Ticket Creado";
        $respuesta['msg'][2] = "success";
      }
      $respuesta['hola'] = "hola";
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


}

?>

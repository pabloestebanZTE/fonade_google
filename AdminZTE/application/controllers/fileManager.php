<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include 'excel_reader.php';       // include the class

class fileManager extends CI_Controller{

    function __construct() {
        parent::__construct();
        $this->load->model('data/dao_ticket_model');
        $this->load->model('data/dao_maintenance_model');
        $this->load->model('data/dao_user_model');
        $this->load->model('data/dao_PVD_model');
        $this->load->model('user_model');
        $this->load->model('maintenance_model');
    }

    function updateFile($ruta, $error, $name, $tmpName){
        $result;
        if(!$error){
            $file_name = $name;
      //      $file_type = $_FILES['fileActividad']['type'];
            $file_name = preg_replace("/[^a-z0-9_\.\-[:space:]]/i", "_", $file_name);
            move_uploaded_file($tmpName, $ruta.$file_name);
            $result[0] =  "true";
            $result[1] =  'Congratulations!  Your file was accepted.';
            $result[2] =  $file_name;
        //    $result[3] =  $file_type;
        } else {
            $result[0] =  "false";
            $result[1] = 'Ooops!  Your upload triggered the following error:  '.$error;
        }
        return $result;
    }

    function excelReader($file){
        $excel = new PhpExcelReader;
        $excel->read('files/'.$file.'.xls');
        $this->actualizarMantenimientos($excel);
    }

    function actualizarMantenimientos($excel){
        for ($i = 2; $i<=$excel->sheets[0]['numRows']; $i++){
            //print_r($excel->sheets[0]['cells'][$i]);
            $mantenimiento = new maintenance_model();
            $daoMantenimiento = new dao_maintenance_model();
            $mantenimiento = $mantenimiento->createMaintenance($excel->sheets[0]['cells'][$i][5], $excel->sheets[0]['cells'][$i][4], "", $excel->sheets[0]['cells'][$i][6]);
            $mantenimientoBD = $daoMantenimiento->getManPrePerID($mantenimiento->getId());
            //print_r($respuesta);
            if(strtotime($mantenimiento->getDate())  != strtotime($mantenimientoBD->getDate())){
                $respuestaAct = $daoMantenimiento->updateDateManPre($mantenimientoBD->getId(), $mantenimiento->getDate());
            }
            if($excel->sheets[0]['cells'][$i][7] != NULL){
              $ticket = new ticket_model();
              $daoTicket = new dao_ticket_model();
              $ticket = $ticket->createTicket($excel->sheets[0]['cells'][$i][7], $excel->sheets[0]['cells'][$i][5], $excel->sheets[0]['cells'][$i][8], $excel->sheets[0]['cells'][$i][9], $excel->sheets[0]['cells'][$i][10], $excel->sheets[0]['cells'][$i][11]);
              $ticketBD = $daoTicket->getTicketByID($ticket->getId());
              if($ticketBD == "No ticket"){
                if ($excel->sheets[0]['cells'][$i][10] == ""){
                  $daoTicket->insertTicket($ticket, "Abierto");
                } else {
                  $daoTicket->insertTicket($ticket, "Cerrado");
                }
              } else {
                if ($excel->sheets[0]['cells'][$i][10] == ""){
                  $daoTicket->updateTicket($ticket, "Abierto");
                } else {
                  $daoTicket->updateTicket($ticket, "Cerrado");
                }
              }
            }
        }
    }

}

?>

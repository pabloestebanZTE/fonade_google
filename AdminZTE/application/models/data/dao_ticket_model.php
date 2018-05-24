<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

//    session_start();

    class Dao_ticket_model extends CI_Model{

      public function __construct(){
          $this->load->model('ticket_model');
          $this->load->model('data/configdb_model');
      }

      public function getTicketsPerMaintenance($id){

          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          $sql = "SELECT * FROM ticket where K_IDMAINTENANCE = ".$id.";";
          if ($session != "false"){
            $result = $session->query($sql);
            if ($result->num_rows > 0) {
              $i = 0;
              while($row = $result->fetch_assoc()) {
                  $ticket = new ticket_model();
                  $sql2 = "SELECT n_name from ticket_status where K_IDSTATUSTICKET = ".$row['K_IDSTATUSTICKET'].";";
                  $result2 = $session->query($sql2);
                  $row2 = $result2->fetch_assoc();

                  $sql3 = "SELECT * FROM ticket_user where K_IDTICKET = '".$row['K_IDTICKET']."';";
                  $result3 = $session->query($sql3);
                  while($row3 = $result3->fetch_assoc()) {
                    $sql4 = "SELECT N_NAME, N_LASTNAME, K_IDUSER FROM user where K_IDUSER = ".$row3['K_IDUSER'].";";
                    $result4 = $session->query($sql4);
                    $row4 = $result4->fetch_assoc();
                    $tipoTech = explode("-",$row3['N_TYPE']);
                    if($tipoTech[0] == "IT"){
                      if ($tipoTech[1] == "T"){
                        $users['users']['IT_T'] = $row4;
                      } else {
                        $users['users']['IT_A'] = $row4;
                      }
                    } else {
                      if ($tipoTech[1] == "T"){
                        $users['users']['AA_T'] = $row4;
                      } else {
                        $users['users']['AA_A'] = $row4;
                      }
                    }
                  }
                  if ($row2['n_name'] == "Abierto"){
                    $row['D_STARTDATE'] = "";
                    $row['D_FINISHDATE'] = "";
                    $row['I_DURATION'] = "";
                  }
                  $ticket = $ticket->createTicket($row['K_IDTICKET'], $row['K_IDMAINTENANCE'], $row2['n_name'], $row['D_STARTDATE'], $row['D_FINISHDATE'], $row['I_DURATION'], $row['D_STARTDATEIT'], $row['D_FINISHDATEIT'], $row['D_STARTDATEAA'], $row['D_FINISHDATEAA'], $users, $row['N_COLOR'], $row['K_OBSERVATION_I']);
                  $respuesta[$i] = $ticket;
                  $i++;
              }
            } else {
              $respuesta = "No Ticket";
            }
          }
          else {
            $respuesta = "Error de informacion";
          }
            //  $db->Connection->closeSession($session);
          return $respuesta;
          }

          public function getTicketByID($id){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT * FROM ticket where K_IDTICKET = '".$id."';";
            if ($session != "false"){
              $result = $session->query($sql);
              if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $ticket = new ticket_model();
                $sql2 = "SELECT n_name from ticket_status where K_IDSTATUSTICKET = ".$row['K_IDSTATUSTICKET'].";";
                $result2 = $session->query($sql2);
                $row2 = $result2->fetch_assoc();
                $sql3 = "SELECT * FROM ticket_user where K_IDTICKET = '".$row['K_IDTICKET']."';";
                $result3 = $session->query($sql3);
                while($row3 = $result3->fetch_assoc()) {
                  $sql4 = "SELECT N_NAME, N_LASTNAME, K_IDUSER FROM user where K_IDUSER = ".$row3['K_IDUSER'].";";
                  $result4 = $session->query($sql4);
                  $row4 = $result4->fetch_assoc();
                  $row4['Almuerzos'] = $row3['Q_ALMUERZOS'];
                  $row4['Estadias'] = $row3['Q_ESTADIA'];
                  $row4['Observaciones'] = $row3['N_OBSERVATION_F'];
                  $tipoTech = explode("-",$row3['N_TYPE']);
                  if($tipoTech[0] == "IT"){
                    if ($tipoTech[1] == "T"){
                      $users['users']['IT_T'] = $row4;
                    } else {
                      $users['users']['IT_A'] = $row4;
                    }
                  } else {
                    if ($tipoTech[1] == "T"){
                      $users['users']['AA_T'] = $row4;
                    } else {
                      $users['users']['AA_A'] = $row4;
                    }
                  }
                }
                $ticket = $ticket->createTicket($row['K_IDTICKET'], $row['K_IDMAINTENANCE'], $row2['n_name'], $row['D_STARTDATE'], $row['D_FINISHDATE'], $row['I_DURATION'], $row['D_STARTDATEIT'], $row['D_FINISHDATEIT'], $row['D_STARTDATEAA'], $row['D_FINISHDATEAA'], $users, $row['N_COLOR'], $row['K_OBSERVATION_I']);
                $ticket->setObservacionesF($row['N_OBSERVATION_F']);
                $ticket->setAlmuerzos($row['Q_ALMUERZOS']);
                $ticket->setEstadia($row['Q_ESTADIA']);
                $respuesta = $ticket;
              } else {
                $respuesta = "No ticket";
                }
            } else {
              $respuesta = "Error en BD";
            }
            return $respuesta;
          }

          public function getCorrectiveTicketByID($id){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT * FROM ticket_others where K_IDTICKETOTHERS = '".$id."';";
            if ($session != "false"){
              $result = $session->query($sql);
              if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $ticket = new ticket_model();
                $sql2 = "SELECT n_name from ticket_status where K_IDSTATUSTICKET = ".$row['K_IDSTATUSTICKET'].";";
                $result2 = $session->query($sql2);
                $row2 = $result2->fetch_assoc();
                $sql3 = "SELECT * FROM ticket_user where K_IDTICKET = '".$row['K_IDTICKET']."';";
                $result3 = $session->query($sql3);
                while($row3 = $result3->fetch_assoc()) {
                  $sql4 = "SELECT N_NAME, N_LASTNAME, K_IDUSER FROM user where K_IDUSER = ".$row3['K_IDUSER'].";";
                  $result4 = $session->query($sql4);
                  $row4 = $result4->fetch_assoc();
                  $row4['Almuerzos'] = $row3['Q_ALMUERZOS'];
                  $row4['Estadias'] = $row3['Q_ESTADIA'];
                  $row4['Observaciones'] = $row3['N_OBSERVATION_F'];
                  $tipoTech = explode("-",$row3['N_TYPE']);
                  if($tipoTech[0] == "IT"){
                    if ($tipoTech[1] == "T"){
                      $users['users']['IT_T'] = $row4;
                    } else {
                      $users['users']['IT_A'] = $row4;
                    }
                  } else {
                    if ($tipoTech[1] == "T"){
                      $users['users']['AA_T'] = $row4;
                    } else {
                      $users['users']['AA_A'] = $row4;
                    }
                  }
                }
                $ticket = $ticket->createTicket($row['K_IDTICKET'], $row['K_IDMAINTENANCE'], $row2['n_name'], $row['D_STARTDATE'], $row['D_FINISHDATE'], $row['I_DURATION'], $row['D_STARTDATEIT'], $row['D_FINISHDATEIT'], $row['D_STARTDATEAA'], $row['D_FINISHDATEAA'], $users, $row['N_COLOR'], $row['K_OBSERVATION_I']);
                $ticket->setObservacionesF($row['N_OBSERVATION_F']);
                $ticket->setAlmuerzos($row['Q_ALMUERZOS']);
                $ticket->setEstadia($row['Q_ESTADIA']);
                $respuesta = $ticket;
              } else {
                $respuesta = "No ticket";
                }
            } else {
              $respuesta = "Error en BD";
            }
            return $respuesta;
          }

          public function getAllTickets(){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT * FROM ticket;";
            if ($session != "false"){
              $result = $session->query($sql);
              if ($result->num_rows > 0) {
                $i = 0;
                while($row = $result->fetch_assoc()) {
                    $ticket = new ticket_model();
                    $sql2 = "SELECT n_name from ticket_status where K_IDSTATUSTICKET = ".$row['K_IDSTATUSTICKET'].";";
                    $result2 = $session->query($sql2);
                    $row2 = $result2->fetch_assoc();
                    $mantenimiento = $this->dao_maintenance_model->getManPrePerID($row['K_IDMAINTENANCE']);
                    $pvd = $this->dao_PVD_model->getPVDbyId($mantenimiento->getIdPVD());
                    $ticket = $ticket->createTicket($row['K_IDTICKET'], $row['K_IDMAINTENANCE'], $row2['n_name'], $row['D_STARTDATE'], $row['D_FINISHDATE'], $row['I_DURATION'], "", "", "", "", "", "", "");
                    $ticket->setAlmuerzos($row['Q_ALMUERZOS']);
                    $ticket->setEstadoI($row['N_ESTADO_I']);
                    $ticket->setEstadia($pvd);
                    $respuesta[$i] = $ticket;
                    $i++;
                }
              } else {
                $respuesta = "No tickets";
                }
            } else {
              $respuesta = "Error en BD";
            }
            return $respuesta;
          }

          public function insertTicket($ticket, $tipo){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT K_IDSTATUSTICKET from ticket_status where N_NAME = '".$ticket->getStatus()."';";
            $result = $session->query($sql);
            $row = $result->fetch_assoc();
            $sql = "insert into ticket (K_IDTICKET, K_IDMAINTENANCE, K_IDSTATUSTICKET, D_STARTDATE, D_POSIBLE_START_DATE, D_POSIBLE_FINISH_DATE)
              values ('".$ticket->getId()."',".$ticket->getIdM().",".$row['K_IDSTATUSTICKET'].",STR_TO_DATE('".$ticket->getDateS()."', '%Y-%m-%d'),STR_TO_DATE('".$ticket->getDateS()."', '%Y-%m-%d'),STR_TO_DATE('".$ticket->getDateF()."', '%Y-%m-%d'));";
              $session->query($sql);
              $ticket->setDateF(NULL);
              if ($ticket->getDateS() != NULL){
                $sql = "UPDATE ticket SET D_STARTDATE=STR_TO_DATE('".$ticket->getDateS()."', '%Y-%m-%d')"." WHERE K_IDTICKET='".$ticket->getId()."';";
                $session->query($sql);
              }
              if ($ticket->getDateF() != NULL){
                $sql = "UPDATE ticket SET D_FINISHDATE=STR_TO_DATE('".$ticket->getDateF()."', '%Y-%m-%d')"." WHERE K_IDTICKET='".$ticket->getId()."';";
                $session->query($sql);
              }
              if ($ticket->getDuracion() != NULL){
                $sql = "UPDATE ticket SET I_DURATION=".$ticket->getDuracion()." WHERE K_IDTICKET='".$ticket->getId()."';";
                $session->query($sql);
              }
              if ($ticket->getDateSAA() != NULL){
                $sql = "UPDATE ticket SET D_STARTDATEAA=STR_TO_DATE('".$ticket->getDateSAA()."', '%Y-%m-%d')"." WHERE K_IDTICKET='".$ticket->getId()."';";
                $session->query($sql);
              }
              if ($ticket->getDateFAA() != NULL){
                $sql = "UPDATE ticket SET D_FINISHDATEAA=STR_TO_DATE('".$ticket->getDateFAA()."', '%Y-%m-%d')"." WHERE K_IDTICKET='".$ticket->getId()."';";
                $session->query($sql);
              }
              if ($ticket->getDateSIT() != NULL){
                $sql = "UPDATE ticket SET D_STARTDATEIT=STR_TO_DATE('".$ticket->getDateSIT()."', '%Y-%m-%d')"." WHERE K_IDTICKET='".$ticket->getId()."';";
                $session->query($sql);
              }
              if ($ticket->getDateFIT() != NULL){
                $sql = "UPDATE ticket SET D_FINISHDATEIT=STR_TO_DATE('".$ticket->getDateFIT()."', '%Y-%m-%d')"." WHERE K_IDTICKET='".$ticket->getId()."';";
                $session->query($sql);
              }
              if ($ticket->getColor() != NULL){
                $sql = "UPDATE ticket SET N_COLOR='".$ticket->getColor()."' WHERE K_IDTICKET='".$ticket->getId()."';";
                $session->query($sql);
              }


              if ($ticket->getObservacionesI() != NULL){
              $sql = "UPDATE ticket SET K_OBSERVATION_I='".$ticket->getObservacionesI()."' WHERE K_IDTICKET='".$ticket->getId()."';";
              $session->query($sql);
            }
          }

          public function updateTicket($ticket, $tipo){
              $dbConnection = new configdb_model();
              $session = $dbConnection->openSession();
              $sql = "SELECT K_IDSTATUSTICKET from ticket_status where N_NAME = '".$ticket->getStatus()."';";
              $result = $session->query($sql);
              $row = $result->fetch_assoc();
              $sql = "UPDATE ticket SET K_IDSTATUSTICKET=".$row['K_IDSTATUSTICKET'].", K_OBSERVATION_I = '".$ticket->getObservacionesI()."' WHERE K_IDTICKET='".$ticket->getId()."';";
              $session->query($sql);
              if ($ticket->getDateS() != NULL){
                $sql = "UPDATE ticket SET D_STARTDATE=STR_TO_DATE('".$ticket->getDateS()."', '%Y-%m-%d')"." WHERE K_IDTICKET='".$ticket->getId()."';";
                $session->query($sql);
              }
              if ($ticket->getDateF() != NULL){
                $sql = "UPDATE ticket SET D_FINISHDATE=STR_TO_DATE('".$ticket->getDateF()."', '%Y-%m-%d')"." WHERE K_IDTICKET='".$ticket->getId()."';";
                $session->query($sql);
              }
              if ($ticket->getDuracion() != NULL){
                $sql = "UPDATE ticket SET I_DURATION=".$ticket->getDuracion()." WHERE K_IDTICKET='".$ticket->getId()."';";
                $session->query($sql);
              }
              if ($ticket->getDateSAA() != NULL){
                $sql = "UPDATE ticket SET D_STARTDATEAA=STR_TO_DATE('".$ticket->getDateSAA()."', '%Y-%m-%d')"." WHERE K_IDTICKET='".$ticket->getId()."';";
                $session->query($sql);
              }
              if ($ticket->getDateFAA() != NULL){
                $sql = "UPDATE ticket SET D_FINISHDATEAA=STR_TO_DATE('".$ticket->getDateFAA()."', '%Y-%m-%d')"." WHERE K_IDTICKET='".$ticket->getId()."';";
                $session->query($sql);
              }
              if ($ticket->getDateSIT() != NULL){
                $sql = "UPDATE ticket SET D_STARTDATEIT=STR_TO_DATE('".$ticket->getDateSIT()."', '%Y-%m-%d')"." WHERE K_IDTICKET='".$ticket->getId()."';";
                $session->query($sql);
              }
              if ($ticket->getDateFIT() != NULL){
                $sql = "UPDATE ticket SET D_FINISHDATEIT=STR_TO_DATE('".$ticket->getDateFIT()."', '%Y-%m-%d')"." WHERE K_IDTICKET='".$ticket->getId()."';";
                $session->query($sql);
              }
              if ($ticket->getColor() != NULL){
                $sql = "UPDATE ticket SET N_COLOR='".$ticket->getColor()."' WHERE K_IDTICKET='".$ticket->getId()."';";
                $session->query($sql);
              }
          }

          public function insertTech($ticket, $user, $type){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql2 = "SELECT COUNT(*) FROM ticket_user WHERE K_IDTICKET = '".$ticket."' and N_TYPE = '".$type."';";
            $result = $session->query($sql2);
            $row = $result->fetch_assoc();
            if ($row['COUNT(*)'] > 0) {
              $sql3 = "UPDATE ticket_user SET K_IDUSER = ".$user." WHERE K_IDTICKET = '".$ticket."' and N_TYPE = '".$type."';";
              $session->query($sql3);
            } else {
              $sql = "insert into ticket_user (K_IDTICKET, K_IDUSER, N_TYPE)
                values ('".$ticket."',".$user.",'".$type."');";
              $session->query($sql);
            }
          }

          public function ticketQuantity(){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT COUNT(K_IDTICKET) from ticket;";
            $result = $session->query($sql);
            $row = $result->fetch_assoc();
            return $row['COUNT(K_IDTICKET)'];
          }

          public function updateTicketDetails($ticket){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = " UPDATE ticket_user SET Q_ESTADIA = ".$ticket['estadia'].", Q_ALMUERZOS = ".$ticket['almuerzo'].", N_OBSERVATION_F='".$ticket['Observaciones']."' where K_IDTICKET = '".$ticket['id']."' and K_IDUSER = ".$ticket['user'].";";
            $result = $session->query($sql);
          }


            public function getAllOtherTicket(){
              $dbConnection = new configdb_model();
              $session = $dbConnection->openSession();
              $sql = "SELECT * FROM ticket_others";
              if ($session != "false"){
                $result = $session->query($sql);
                if ($result->num_rows > 0) {
                  $i = 0;
                  while($row = $result->fetch_assoc()) {
                      $ticket = new ticket_model();
                      $sql2 = "SELECT n_name from ticket_status where K_IDSTATUSTICKET = ".$row['K_IDSTATUSTICKET'].";";
                      $result2 = $session->query($sql2);
                      $row2 = $result2->fetch_assoc();
                      $ticket = $ticket->createTicket($row['K_IDTICKET'], $row['K_IDMAINTENANCE'], $row2['n_name'], $row['D_STARTDATE'], $row['D_FINISHDATE'], $row['I_DURATION']);
                      $respuesta[$i] = $ticket;
                      $i++;
                  }
                } else {
                  $respuesta = "No tickets";
                  }
              } else {
                $respuesta = "Error en BD";
              }
            }

            public function getAllOtherCategories(){
              $dbConnection = new configdb_model();
              $session = $dbConnection->openSession();
              $sql = "SELECT * FROM ticket_other_status";
              if ($session != "false"){
                $result = $session->query($sql);
                if ($result->num_rows > 0) {
                  $i = 0;
                  while($row = $result->fetch_assoc()) {
                    $respuesta[$i] = $row;
                    $i++;
                  }
                } else {
                  $respuesta = "No tickets";
                  }
              } else {
                $respuesta = "Error en BD";
              }
              return $respuesta;
            }

            public function insertOtherTicket($ticket){
              $dbConnection = new configdb_model();
              $session = $dbConnection->openSession();
              $sql = "SELECT count(K_IDTICKETOTHERS) from ticket_others;";
              if ($session != "false"){
                $result = $session->query($sql);
                $row = $result->fetch_assoc();
                for($i = strlen($row['count(K_IDTICKETOTHERS)']); $i <5; $i++){
                  $row['count(K_IDTICKETOTHERS)'] = "0".$row['count(K_IDTICKETOTHERS)'];
                }
                $sql2 = "INSERT INTO ticket_others (K_IDTICKETOTHERS, D_STARTDATE, D_FINISHDATE, I_DURATION, K_IDTICKETT, N_OBSERVATION_F, N_TIPO)
                  values ('".$ticket->getId().$row['count(K_IDTICKETOTHERS)']."',STR_TO_DATE('".$ticket->getDateS()."', '%Y-%m-%d'), STR_TO_DATE('".$ticket->getDateF()."', '%Y-%m-%d'), ".$ticket->getDuracion().", ".$ticket->getStatus().", '".$ticket->getObservacionesI()."','".$ticket->getColor()."');";
                // echo $sql2;
                if($ticket->getIdM() != "-1"){
                  $sql3 = "UPDATE ticket_others SET K_IDPVD =".$ticket->getIdM()." where K_IDTICKETOTHERS = '".$ticket->getId().$row['count(K_IDTICKETOTHERS)']."';";
                }
                $session->query($sql2);
                $session->query($sql3);
                if($ticket->getAlmuerzos() != ""){
                  $sql5 = "UPDATE ticket_others SET K_IDTICKETCC = '".$ticket->getAlmuerzos()."' WHERE K_IDTICKETOTHERS = '".$ticket->getId().$row['count(K_IDTICKETOTHERS)']."';";
                  $session->query($sql5);
                }
                $sql4 = "";
                for($q = 0; $q < count($ticket->getTechs()); $q++){
                  $sql4 = "INSERT INTO ticketo_user (K_IDTICKETO, K_IDUSER)
                  values ('".$ticket->getId().$row['count(K_IDTICKETOTHERS)']."',".$ticket->getTechs()[$q]." ); ";
                  $session->query($sql4);
                }
                $respuesta = "El ticket ".$ticket->getId().$row['count(K_IDTICKETOTHERS)']." se ha creado correctamente";
              }else {
                $respuesta = "Error en BD";
              }
              return $respuesta;
            }

            public function getAllOtherMaintenances(){
              $dbConnection = new configdb_model();
              $session = $dbConnection->openSession();
              $sql = "SELECT * FROM ticket_others";
              if ($session != "false"){
                $result = $session->query($sql);
                if ($result->num_rows > 0) {
                  $i = 0;
                  while($row = $result->fetch_assoc()) {
                      $ticket = new ticket_model();
                      $sql2 = "SELECT n_name from ticket_other_status where K_IDSTATUSTICKETO = ".$row['K_IDTICKETT'].";";
                      $result2 = $session->query($sql2);
                      $row2 = $result2->fetch_assoc();
                      $ticket = $ticket->createTicket($row['K_IDTICKETOTHERS'], $row['K_IDPVD'], $row2['n_name'], $row['D_STARTDATE'], $row['D_FINISHDATE'], $row['I_DURATION'], "", "", "", "", "", "", $row['N_OBSERVATION_F']);
                      $respuesta[$i] = $ticket;
                      $i++;
                  }
                } else {
                  $respuesta = "No tickets";
                }
              } else {
                $respuesta = "Error en BD";
              }
              return $respuesta;
            }


            public function getAllOtherCorrectiveMaintenances(){
              $dbConnection = new configdb_model();
              $session = $dbConnection->openSession();
              $sql = "SELECT * FROM ticket_others where N_TIPO = 'Correctivo' OR N_TIPO = 'Reposicion'";
              //Verificar que la sesion exista
              if ($session != "false"){
                $result = $session->query($sql);
              //Verificar que la consulta traiga algo
                if ($result->num_rows > 0) {
                  $i = 0;
                  while($row = $result->fetch_assoc()) {
                        $ticket = new ticket_model();
                        $ticket = $ticket->createTicket($row['K_IDTICKETOTHERS'], $row['K_IDPVD'], "", $row['D_STARTDATE'], $row['D_FINISHDATE'], $row['I_DURATION'], $row['N_TIPO'], "", "", "", "", "", $row['N_OBSERVATION_F']);
                        $respuesta[$i] = $ticket;
                        $i++;
                  }
                } else {
                  $respuesta = "No tickets";
                }
              } else {
                $respuesta = "Error en BD";
              }
              // print_r($respuesta);
              return $respuesta;
            }


             //-------------------------------------camilo-------------------------------------
            public function getTicketOByID($id){
              $dbConnection = new configdb_model();
              $session = $dbConnection->openSession();
              $sql = "SELECT * FROM ticket_others where K_IDTICKETOTHERS = '".$id."';";
              if ($session != "false"){
                $result = $session->query($sql);
                if ($result->num_rows > 0) {
                  $row = $result->fetch_assoc();
                  $ticket = new ticket_model();
                  $sql2 = "SELECT n_name from ticket_other_status where K_IDSTATUSTICKETO = ".$row['K_IDTICKETT'].";";
                  $result2 = $session->query($sql2);
                  $row2 = $result2->fetch_assoc();
                  $sql3 = "SELECT * FROM ticketo_user where K_IDTICKETO = '".$row['K_IDTICKETOTHERS']."';";
                  $result3 = $session->query($sql3);
                  $i=0;
                  while($row3 = $result3->fetch_assoc()) {
                    $sql4 = "SELECT * FROM user where K_IDUSER = ".$row3['K_IDUSER'].";";
                    $result4 = $session->query($sql4);
                    $row4 = $result4->fetch_assoc();
                    $user = new user_model();
                    $user = $user->createUser($row4['k_IDUSER'],'',$row4['N_NAME'],$row4['N_LASTNAME']);
                    $users[$i] = $user;
                    $i++;
                  }
                  $ticket = $ticket->createTicket($row['K_IDTICKETOTHERS'], '',$row2['n_name'], $row['D_STARTDATE'], $row['D_FINISHDATE'], $row['I_DURATION'],'','','','', $users,$row['K_IDPVD'], $row['N_OBSERVATION_F']);//usé en la casilla 'color', para ingresar el ID del PVD

                  $ticket->setObservacionesF($row['N_OBSERVATION_F']);
                  $ticket->setAlmuerzos($row['Q_ALMUERZOS']);
                  $ticket->setEstadia($row['Q_ESTADIA']);
                  $respuesta = $ticket;
                } else {
                  $respuesta = "No ticket";
                  }
              } else {
                $respuesta = "Error en BD";
              }
              return $respuesta;
            }
    //-----------------------------------------------------------------------------------------------------
            public function createTicketCCC($id, $pvd, $desc, $tipo){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            if ($session != "false"){
              $sql = "INSERT INTO ticket_ccc (K_IDTICKET_CCC, K_IDPVD, N_DESCRIPTION, N_ESTADO, N_TIPO)
                values ('".$id."', '".$pvd."', '".$desc."', 'Abierto', '".$tipo."');";
              $session->query($sql);
              $sql2 = "SELECT * FROM ticket_ccc WHERE K_IDTICKET_CCC = '".$id."';";
              $result2 = $session->query($sql2);
              if ($result2->num_rows > 0) {
                $respuesta = $id;
              } else {
                $respuesta = "Error en BD";
              }
            } else {
              $respuesta = "Error en BD";
            }
            return $respuesta;
          }

          public function approveTicket($ticket){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "UPDATE ticket SET N_ESTADO_I = 1 WHERE K_IDTICKET = '".$ticket."';";
            $session->query($sql);
          }

          public function updateProgress($progress, $ticket){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "UPDATE ticket SET Q_ESTADIA = ".explode(".",$progress)[0].", Q_ALMUERZOS = ".explode(".",$progress)[0]." WHERE K_IDTICKET = '".$ticket."';";
            $session->query($sql);
          }

          public function getProgress($ticket){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT Q_ESTADIA FROM ticket WHERE K_IDTICKET = '".$ticket."';";
            if ($session != "false"){
              $result = $session->query($sql);
              $row = $result->fetch_assoc();
            }
            return $row['Q_ESTADIA'];
          }

          public function getEstadoI($ticket){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT N_ESTADO_I FROM ticket WHERE K_IDTICKET = '".$ticket."';";
            if ($session != "false"){
              $result = $session->query($sql);
              $row = $result->fetch_assoc();
            }
            return $row['N_ESTADO_I'];
          }

          public function getAllTicketsCI(){
            $query = $this->db->get("ticket");
            return $query->result();
          }

          public function getAllTicketUserCI(){
            $query = $this->db->get("ticket_user");
            return $query->result();
          }

          // Obtengo los parametros y enviamos datos a las distintas funciones
          // para su actualizacion o asignacion
          public function updateMantPreventivo($parameter){
            //llama funcion para actualizar tabala ticket
            $res = $this->updtTicket($parameter);
            if ($res == "error") {return "error updtTicket";}
            //Si existe tecnico it llama funcion para actualizar
            if ($parameter['tecIT']) {
              $res = $this->assignTechnicalIT($parameter);
              if ($res == "error") {return "error assignTechnicalIT";}
            }
            //Si existe auxiliar it llama funcion para actualizar
            if ($parameter['auxIT']) {
              $res = $this->assignAuxiliaryIT($parameter);
              if ($res == "error") {return "error assignAuxiliaryIT";}
            }
            //Si existe tecnico AA llama funcion para actualizar
            if ($parameter['tecAA']) {
              $res = $this->assignTechnicalAA($parameter);
              if ($res == "error") {return "error assignTechnicalAA";}
            }
            //Si existe auxiliar it llama funcion para actualizar
            if ($parameter['auxAA']) {
              $res = $this->assignAuxiliaryAA($parameter);
              if ($res == "error") {return "error assignAuxiliaryAA";}
            }
          }

          public function updtTicket($parameter){
            $camposTicket = array(
                  'K_IDSTATUSTICKET' => $parameter['estado'],
                  'D_STARTDATE' => $parameter['iniMant'],
                  'D_FINISHDATE' => $parameter['finMant'],
                  'I_DURATION' => $parameter['duracion'],
                  'D_STARTDATEAA' => $parameter['iniAA'],
                  'D_FINISHDATEAA' => $parameter['finAA'],
                  'D_STARTDATEIT' => $parameter['iniIT'],
                  'D_FINISHDATEIT' => $parameter['finIT'],
                  'N_COLOR' => $parameter['color'],
                  'K_OBSERVATION_I' => $parameter['observaciones']
            );
            $this->db->where('K_IDTICKET', $parameter['ticket']);
            $this->db->update('ticket',$camposTicket);
            $error = $this->db->error();
            if ($error['message']) {
              print_r($error);
              return "error";
            }
          }

          public function assignTechnicalIT($parameter){

            $camposTicketUser = array(
              'K_IDTICKET' => $parameter['ticket'],
              'K_IDUSER' => $parameter['tecIT'],
              'N_TYPE' => 'IT-T'
            );

              $this->db->select("K_IDTICKET,N_TYPE");
              $this->db->from('ticket_user');
              $this->db->where('K_IDTICKET', $parameter['ticket']);
              $this->db->where('N_TYPE', 'IT-T');
              $query = $this->db->get();

              if($query->num_rows() > 0 ){
                $this->db->where('K_IDTICKET', $parameter['ticket']);
                $this->db->where('N_TYPE', 'IT-T');
                $this->db->update('ticket_user', $camposTicketUser);
              }else{
                $this->db->insert('ticket_user',$camposTicketUser);
              }
              $error = $this->db->error();
              if ($error['message']) {
                print_r($error);
                return "error";
              }


          }

          public function assignAuxiliaryIT($parameter){

            $camposTicketUser = array(
              'K_IDTICKET' => $parameter['ticket'],
              'K_IDUSER' => $parameter['auxIT'],
              'N_TYPE' => 'IT-A'
            );

              $this->db->select("K_IDTICKET,N_TYPE");
              $this->db->from('ticket_user');
              $this->db->where('K_IDTICKET', $parameter['ticket']);
              $this->db->where('N_TYPE', 'IT-A');
              $query = $this->db->get();

              if($query->num_rows() > 0 ){
                $this->db->where('K_IDTICKET', $parameter['ticket']);
                $this->db->where('N_TYPE', 'IT-A');
                $this->db->update('ticket_user', $camposTicketUser);
              }else{
                $this->db->insert('ticket_user',$camposTicketUser);
              }
              $error = $this->db->error();
              if ($error['message']) {
                print_r($error);
                return "error";
              }
          }

          public function assignTechnicalAA($parameter){

            $camposTicketUser = array(
              'K_IDTICKET' => $parameter['ticket'],
              'K_IDUSER' => $parameter['tecAA'],
              'N_TYPE' => 'AA-T'
            );

            $this->db->select("K_IDTICKET,N_TYPE");
            $this->db->from('ticket_user');
            $this->db->where('K_IDTICKET', $parameter['ticket']);
            $this->db->where('N_TYPE', 'AA-T');
            $query = $this->db->get();

            if($query->num_rows() > 0 ){
              $this->db->where('K_IDTICKET', $parameter['ticket']);
              $this->db->where('N_TYPE', 'AA-T');
              $this->db->update('ticket_user', $camposTicketUser);
            }else{
              $this->db->insert('ticket_user',$camposTicketUser);
            }

            $error = $this->db->error();
            if ($error['message']) {
              print_r($error);
              return "error";
            }

          }

          public function assignAuxiliaryAA($parameter){

            $camposTicketUser = array(
              'K_IDTICKET' => $parameter['ticket'],
              'K_IDUSER' => $parameter['auxAA'],
              'N_TYPE' => 'AA-A'
            );

            $this->db->select("K_IDTICKET,N_TYPE");
            $this->db->from('ticket_user');
            $this->db->where('K_IDTICKET', $parameter['ticket']);
            $this->db->where('N_TYPE', 'AA-A');
            $query = $this->db->get();

            if($query->num_rows() > 0 ){
              $this->db->where('K_IDTICKET', $parameter['ticket']);
              $this->db->where('N_TYPE', 'AA-A');
              $this->db->update('ticket_user', $camposTicketUser);
            }else{
              $this->db->insert('ticket_user',$camposTicketUser);
            }

            $error = $this->db->error();
            if ($error['message']) {
              print_r($error);
              return "error";
            }
          }








        }
?>

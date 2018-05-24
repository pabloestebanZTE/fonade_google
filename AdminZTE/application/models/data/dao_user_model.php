<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

//    session_start();

    class Dao_user_model extends CI_Model{

        public function __construct(){
            $this->load->model('user_model');
            $this->load->model('data/configdb_model');
            $this->load->model('ticket_model');
            $this->load->model('maintenance_model');
            $this->load->model('pvd_model');
        }

        public function startSession(user_model $user){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT * FROM user where K_IDUSER = "."'".$user->getId()."' and N_PASSWORD = '".$user->getPass()."';";
            if ($session != "false"){
                $result = $session->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $user->setName($row['N_NAME']);
                    $user->setLastname($row['N_LASTNAME']);

                    $sql2 = "SELECT * FROM user_permission WHERE  k_idtypeuser = ".$row['K_IDTYPEUSER'];
                    $result2 = $session->query($sql2);
                    if ($result2->num_rows > 0) {
                        $count = 0;
                        while($row2 = $result2->fetch_assoc()) {
                            $permissons[$count] = $row2['K_IDPERMISSION'];
                            $count++;
                        }
                        $user->setPermissions($permissons);
                        $dbConnection->startSession($user->getId(),$user->getPass(),$user->getName(),$user->getLastname(),$this->arrayPermissions($user->getPermissions()));
                    }
                } else {
                    $user = "Error de informacion";
                }
                $dbConnection->closeSession($session);
                return $user;
            }
        }

        public function arrayPermissions($permissions){
            for($i = 0; $i<11; $i++){
                $arrayPermissions[$i] = 0;
            }
            for($i = 0; $i <count($permissions); $i++){
              $arrayPermissions[$permissions[$i]] = 1;
            }
            return $arrayPermissions;
        }
        //------------------------------------------------------------------------
        public function getAllUsers(){
          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          $sql = "SELECT * FROM user ORDER BY N_NAME;";
          if ($session != "false"){
            $result = $session->query($sql);
            if ($result->num_rows > 0) {
              $i = 0;
              while($row = $result->fetch_assoc()) {
                  $user = new user_model();
                  $user = $user->createUser($row['K_IDUSER'], "", $row['N_NAME'], $row['N_LASTNAME']);
                  $sql2 = "SELECT * FROM ticket_user WHERE K_IDUSER = ".$row['K_IDUSER'].";";
                  $result2 = $session->query($sql2);
                  $tickets = null;

                  if ($result2->num_rows > 0) {
                    $j=0;
                    while ($row2 =$result2->fetch_assoc()) {

                        $sql3 = "SELECT * FROM ticket WHERE K_IDTICKET = '".$row2['K_IDTICKET']."';";
                        $result3 = $session->query($sql3);
                        $row3 = $result3->fetch_assoc();
                        $ticket = new ticket_model;
                        $sql4 = "SELECT * FROM maintenance WHERE K_IDMAINTENANCE = ".$row3['K_IDMAINTENANCE'].";";
                        $result4 = $session->query($sql4);
                        $row4 = $result4->fetch_assoc();
                        $maintenance = new maintenance_model;
                        $sql5 = "SELECT * FROM pvd WHERE K_IDPVD = ".$row4['K_IDPVD'].";";
                        $result5 = $session->query($sql5);
                        $row5 = $result5->fetch_assoc();
                        //echo "<br>";
                        //print_r($row5);
                        $sql6 = "SELECT * FROM city WHERE K_IDCITY = ".$row5['K_IDCITY'].";";
                        $result6 = $session->query($sql6);
                        $row6 = $result6->fetch_assoc();
                        //print_r($row6);
                        $sql7 = "SELECT * FROM department WHERE K_IDDEPARTMENT = ".$row6['K_IDDEPARTMENT'].";";
                        $result7 = $session->query($sql7);
                        $row7 = $result7->fetch_assoc();
                        //print_r($row7);
                        $pvd = new PVD_model;

                        $pvd = $pvd->createPVD($row5['K_IDPVD'], $row6['N_NAME'], $row7['N_NAME'], $row7['K_IDREGION'], $row5['N_DIRECCION'], $row5['N_FASE'], $row5['N_TIPOLOGIA']);

                        $maintenance = $maintenance->createMaintenance($row4['K_IDMAINTENANCE'], $pvd, $row4['K_IDMAINTENANCET'], $row4['D_STARTDATE']);

                      if ($row2['N_TYPE'] == "IT-T" || $row2['N_TYPE'] == "IT-A") {
                          $row3['D_STARTDATEAA'] = null;
                          $row3['D_FINISHDATEAA'] = null;
                      }
                      if ($row2['N_TYPE'] == "AA-T" || $row2['N_TYPE'] == "AA-A") {
                          $row3['D_STARTDATEIT'] = null;
                          $row3['D_FINISHDATEIT'] = null;
                      }

                        $ticket = $ticket->createTicket($row3['K_IDTICKET'],$maintenance, $row3['K_IDSTATUSTICKET'], $row3['D_STARTDATE'], $row3['D_FINISHDATE'], $row3['I_DURATION'], $row3['D_STARTDATEIT'], $row3['D_FINISHDATEIT'], $row3['D_STARTDATEAA'], $row3['D_FINISHDATEAA'], "", $row3['N_COLOR'], $row3['K_OBSERVATION_I']);
                        $tickets[$j] = $ticket;
                        $j++;
                    }

                  }else{
                    //este usuario no tiene actividades

                  }
                  $user->setIdticket($tickets);
                  $respuesta[$i] = $user;
                  $i++;
              }
            } else {
              $respuesta = "No Users";
              }
          } else {
            $respuesta = "Error en BD";
          }
          return $respuesta;
        }
//-------------------------------------------------------------------------------------------
        public function getUserById($id){
          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          $sql = "SELECT * FROM user where K_IDUSER = ".$id.";";
          if ($session != "false"){
            $result = $session->query($sql);
            if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              $user = new user_model();
              $user = $user->createUser($row['K_IDUSER'], "", $row['N_NAME'], $row['N_LASTNAME']);
              $respuesta = $user;
            }
          } else {
            $respuesta = "Error en BD";
          }
          return $respuesta;
        }

        public function getAllUsersCI(){
          $query = $this->db->get("user");
          return $query->result();            
        }
        // Trae todos los tecnicos IT
        public function getTechnicalIT(){
           $query = $this->db->query("SELECT DISTINCT tu.K_IDUSER as id, concat(u.N_NAME,' ', u.N_LASTNAME)as nombre 
                             FROM ticket_user tu
                             inner join user u
                             on tu.K_IDUSER = u.K_IDUSER
                             where 
                             N_TYPE = 'IT-T'");
           return $query->result();
        }
        // Trae todos los auxiliares IT
        public function getAuxiliarIT(){
           $query = $this->db->query("SELECT DISTINCT tu.K_IDUSER as id, concat(u.N_NAME,' ', u.N_LASTNAME)as nombre 
                             FROM ticket_user tu
                             inner join user u
                             on tu.K_IDUSER = u.K_IDUSER
                             where 
                             N_TYPE = 'IT-A'");

           return $query->result();
        }
        // Trae todos los tecnicos AA
        public function getTechnicalAA(){
           $query = $this->db->query("SELECT DISTINCT tu.K_IDUSER as id, concat(u.N_NAME,' ', u.N_LASTNAME)as nombre 
                             FROM ticket_user tu
                             inner join user u
                             on tu.K_IDUSER = u.K_IDUSER
                             where 
                             N_TYPE = 'AA-T'");
           return $query->result();
        }
        // Trae todos los auxiliares AA
        public function getAuxiliarAA(){
           $query = $this->db->query("SELECT DISTINCT tu.K_IDUSER as id, concat(u.N_NAME,' ', u.N_LASTNAME)as nombre 
                             FROM ticket_user tu
                             inner join user u
                             on tu.K_IDUSER = u.K_IDUSER
                             where 
                             N_TYPE = 'AA-A'");
           return $query->result();
        }




    }
?>

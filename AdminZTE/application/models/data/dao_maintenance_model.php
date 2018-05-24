<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

//    session_start();

    class Dao_maintenance_model extends CI_Model{

        public function __construct(){
            $this->load->model('maintenance_model');
            $this->load->model('data/configdb_model');
        }

        public function createMaintenance($maintenance){
          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          if ($session != "false"){
            $sql = "INSERT into maintenance (K_IDPVD, K_IDMAINTENANCET, D_STARTDATE) values (".$maintenance->getIdPVD().",1,STR_TO_DATE('".$maintenance->getDate()."', '%Y-%m-%d'));";
            $session->query($sql);

            $sql2= "SELECT * from maintenance where K_IDPVD = ".$maintenance->getIdPVD().";";
            $result = $session->query($sql2);
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                $maint = $row;
              }
            } else {
                $maint['K_IDMAINTENANCE'] = "No existe mantenimiento";
            }
          } else {
            $maint['K_IDMAINTENANCE'] = "Error de informacion";
          }

          return $maint['K_IDMAINTENANCE'];
        }

        public function getManPrePerPVD($id){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT * FROM maintenance where K_IDMAINTENANCET = 1 and K_IDPVD = ".$id.";";
            if ($session != "false"){
              $result = $session->query($sql);
              if ($result->num_rows > 0) {
                $i = 0;
                while($row = $result->fetch_assoc()) {
                    $maintenance = new maintenance_model();
                    $maintenance = $maintenance->createMaintenance($row['K_IDMAINTENANCE'], $row['K_IDPVD'], "Preventivo", $row['D_STARTDATE']);
                    $respuesta[$i] = $maintenance;
                    $i++;
                }
              }
            }
            else {
              $respuesta = "Error de informacion";
            }
              //  $db->Connection->closeSession($session);
            return $respuesta;
            }

            public function getManPrePerID($id){
              $dbConnection = new configdb_model();
              $session = $dbConnection->openSession();
              $sql = "SELECT * FROM maintenance where K_IDMAINTENANCE = ".$id.";";
              if ($session != "false"){
                $result = $session->query($sql);
                if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                      $maintenance = new maintenance_model();
                      $maintenance = $maintenance->createMaintenance($row['K_IDMAINTENANCE'], $row['K_IDPVD'], "Preventivo", $row['D_STARTDATE']);
                      $respuesta = $maintenance;
                  }
                } else {
                    $respuesta = "No existe mantenimiento";
                }
              } else {
                $respuesta = "Error de informacion";
              }
              return $respuesta;
            }

            public function updateDateManPre($maintenance){
              $dbConnection = new configdb_model();
              $session = $dbConnection->openSession();
              $sql = "UPDATE maintenance SET D_STARTDATE = STR_TO_DATE('".$maintenance->getDate()."', '%Y-%m-%d') where K_IDMAINTENANCE = ".$maintenance->getId().";";
              if ($session != "false"){
                $result = $session->query($sql);
              } else {
                $respuesta = "No se pudo actualizar";
              }
            }

            public function getAllMaintenancesCI(){
              $query = $this->db->get("maintenance");
              return $query->result();  
            }




        }
?>

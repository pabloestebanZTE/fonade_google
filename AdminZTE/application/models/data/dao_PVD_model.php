<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

//    session_start();

    class Dao_PVD_model extends CI_Model{

        public function __construct(){
            $this->load->model('pvd_model');
            $this->load->model('data/configdb_model');
        }

        public function getPVDbyId($id){
          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          $sql = "SELECT pvd.K_IDPVD, pvd.K_IDCITY, pvd.K_IDEJECUTOR, pvd.K_IDADMIN, pvd.N_NAME, pvd.N_DIRECCION, pvd.N_TIPOLOGIA, pvd.N_FASE, region.N_NAME FROM pvd, city, department, region WHERE pvd.K_IDPVD = '".$id."' and  pvd.K_IDCITY = city.K_IDCITY and city.K_IDDEPARTMENT = department.K_IDDEPARTMENT and department.K_IDREGION = region.K_IDREGION ORDER BY region.N_NAME, department.N_NAME, city.N_NAME;";
          if ($session != "false"){
            $result = $session->query($sql);
            if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              $sql2 = "SELECT region.N_NAME as rn, department.N_NAME as dn, city.N_NAME as cn FROM pvd, city, department, region where pvd.K_IDCITY = city.K_IDCITY and city.K_IDDEPARTMENT = department.K_IDDEPARTMENT and department.K_IDREGION = region.K_IDREGION and pvd.K_IDPVD =".$row['K_IDPVD'].";";
              $result2 = $session->query($sql2);
              if ($result2->num_rows > 0) {
                $row2 = $result2->fetch_assoc();
                $PVD = new PVD_model();
                $PVD = $PVD->createPVD($row['K_IDPVD'], $row2['cn'], $row2['dn'], $row2['rn'], $row['N_DIRECCION'], $row['N_FASE'], $row['N_TIPOLOGIA']);
                $respuesta = $PVD;
              }
            }
            $sql = "SELECT * FROM pvd_place WHERE K_IDPVDT = '".$PVD->getTipologia()."';";
            $result = $session->query($sql);
            $i = 0;
            while($row = $result->fetch_assoc()) {
              $sql2 = "SELECT * FROM pvd_zone WHERE K_IDPVDZONE = ".$row['K_IDPVDZONE'].";";
              $result2 = $session->query($sql2);
              $row2 = $result2->fetch_assoc();
              $zones[$i] = $row2;
              $i++;
            }
            $respuesta->setZones($zones);
          } else {
            $respuesta = "Error de informacion";
          }
          return $respuesta;
        }

        public function getPVDs(){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT pvd.K_IDPVD, pvd.K_IDCITY, pvd.K_IDEJECUTOR, pvd.K_IDADMIN, pvd.N_NAME, pvd.N_DIRECCION, pvd.N_TIPOLOGIA, pvd.N_FASE, region.N_NAME FROM pvd, city, department, region WHERE pvd.K_IDCITY = city.K_IDCITY and city.K_IDDEPARTMENT = department.K_IDDEPARTMENT and department.K_IDREGION = region.K_IDREGION ORDER BY region.N_NAME, department.N_NAME, city.N_NAME;";
            if ($session != "false"){
              $result = $session->query($sql);
              if ($result->num_rows > 0) {
                $i = 0;
                while($row = $result->fetch_assoc()) {
                  $sql2 = "SELECT region.N_NAME as rn, department.N_NAME as dn, city.N_NAME as cn FROM pvd, city, department, region where pvd.K_IDCITY = city.K_IDCITY and city.K_IDDEPARTMENT = department.K_IDDEPARTMENT and department.K_IDREGION = region.K_IDREGION and pvd.K_IDPVD =".$row['K_IDPVD'].";";
                  $result2 = $session->query($sql2);
                  if ($result2->num_rows > 0) {
                    $row2 = $result2->fetch_assoc();
                    $PVD = new PVD_model();
                    $PVD = $PVD->createPVD($row['K_IDPVD'], $row2['cn'], $row2['dn'], $row2['rn'], $row['N_DIRECCION'], $row['N_FASE]'], $row['N_TIPOLOGIA']);
                    $sql3 = "SELECT * from admin_pvd where K_IDADMIN =". $row['K_IDADMIN'].";";
                    $result3 = $session->query($sql3);
                    $row3 = $result3->fetch_assoc();
                    $PVD->setAdmin($row3);
                    $respuesta[$i] = $PVD;
                    $i++;
                  }
                }
              }
            } else {
              $respuesta = "Error de informacion";
            }
              //  $db->Connection->closeSession($session);
                return $respuesta;
            }

            public function getAllCCCTicketsPerPBV($idPvd){
              $dbConnection = new configdb_model();
              $session = $dbConnection->openSession();
              $sql  = "SELECT * FROM ticket_ccc WHERE K_IDPVD = ".$idPvd.";";
              if ($session != "false"){
                $result = $session->query($sql);
                if ($result->num_rows > 0) {
                  $i = 0;
                  while($row = $result->fetch_assoc()) {
                    $respuesta[$i] = $row;
                    $i++;
                  }
                }
              }
              return $respuesta;
            }

            public function getAllPVDCI(){
              $query = $this->db->get("pvd");
              return $query->result();
            }

            public function getAllCitiesCI(){
              $query = $this->db->get("city");
              return $query->result();
            }

            public function getAllDepartmentsCI(){
              $query = $this->db->get("department");
              return $query->result();
            }

            public function getAllRegionCI(){
              $query = $this->db->get("region");
              return $query->result();
            }

            public function getAllPVDs(){
              $dbConnection = new configdb_model();
              $session = $dbConnection->openSession();
              $sql = "SELECT * FROM pvd";
              if ($session != "false"){
                $result = $session->query($sql);
                if ($result->num_rows > 0) {
                  $i = 0;
                  while($row = $result->fetch_assoc()) {
                    $pvd = new Pvd_model();
                    $pvd = $pvd->createPVD($row['K_IDPVD'], $row['K_IDCITY'], "", "", $row['N_DIRECCION'], $row['N_FASE'], $row['N_TIPOLOGIA']);
                    $respuesta[$i] = $pvd;
                    $i++;
                  }
                }
              } else {
                $respuesta = "Error de informacion";
              }
              return $respuesta;
            }

        }
?>

<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

//    session_start();

    class Dao_kpi_model extends CI_Model{

        public function __construct(){
            $this->load->model('data/configdb_model');
        }

        public function getKPIperSource($id){
          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          $sql = "SELECT * from users_kpi where K_IDUSER =".$id.";";
          if ($session != "false"){
            $result = $session->query($sql);
            if ($result->num_rows > 0) {
              $i = 0;
              while($row = $result->fetch_assoc()) {
                $sql2 = "SELECT * from kpi WHERE K_IDKPI = ".$row['K_IDKPI'].";";
                $result2 = $session->query($sql2);
                $row2 = $result2->fetch_assoc();
                $respuesta[$i] = $row2;
                $i++;
              }
            } else {
              $respuesta = "No KPIs";
              }
          } else {
            $respuesta = "Error en BD";
          }
          return $respuesta;
        }

        public function getAllKPI(){
          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          $sql = "SELECT * from kpi;";
          if ($session != "false"){
            $result = $session->query($sql);
            if ($result->num_rows > 0) {
              $i = 0;
              while($row = $result->fetch_assoc()) {
                $row['fuentes'] = $this->getKPIUsers($row['K_IDKPI'], $session);
                $respuesta[$i] = $row;
                $i++;
              }
            } else {
              $respuesta = "No KPIs";
              }
          } else {
            $respuesta = "Error en BD";
          }
          return $respuesta;
        }

        public function getKPIUsers($kpi, $session){
          $sql = "SELECT * from users_kpi where K_IDKPI =".$kpi.";";
          $result = $session->query($sql);
          if ($result->num_rows > 0) {
            $i = 0;
            while($row = $result->fetch_assoc()) {
              $sql2 = "SELECT * FROM user where K_IDUSER =".$row['K_IDUSER'].";";
              $result2 = $session->query($sql2);
              $row2 = $result2->fetch_assoc();
              $respuesta[$i] = $row2;
              $i++;
            }
          } else {
            $respuesta = "No Fuentes";
            }
          return $respuesta;
        }

        public function getKPIEvaluates($idKPI){
          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          $sql = "SELECT Q_ANO from kpi_resuelto where K_IDKPI = ".$idKPI." GROUP by Q_ANO;";
          if ($session != "false"){
            $result = $session->query($sql);
            if ($result->num_rows > 0) {
              $i = 0;
              while($row = $result->fetch_assoc()) {
                $sql2 = "SELECT Q_MES from kpi_resuelto where K_IDKPI = ".$idKPI." and Q_ANO = ".$row['Q_ANO']." GROUP by Q_MES;";
                $result2 = $session->query($sql2);
                while($row2 = $result2->fetch_assoc()) {
                  $kpis[$row['Q_ANO']][$row2['Q_MES']] = $row2['Q_MES'] ;
                  $kpis[$row['Q_ANO']][$row2['Q_MES']."alfa"] = $this->fixMonth($row2['Q_MES']);
                }
                $kpis['years'][$i] = $row;
                $i++;
              }
            } else {
              $kpis = "No years";
              }
          } else {
            $kpis = "Error en BD";
          }

          $sql3 = "SELECT * from kpi_resuelto where K_IDKPI = ".$idKPI.";";
          if ($session != "false"){
            $result = $session->query($sql3);
            if ($result->num_rows > 0) {
              $i = 0;
              while($row = $result->fetch_assoc()) {
                $sql4 = "SELECT * from user where K_IDUSER = ".$row['K_IDUSER'].";";
                $result4 = $session->query($sql4);
                $row4 = $result4->fetch_assoc();
                $sql5 = "SELECT * from kpi where K_IDKPI = ".$row['K_IDKPI'].";";
                $result5 = $session->query($sql5);
                $row5 = $result5->fetch_assoc();
                $row['KPI'] = $row5;
                $row['user']=$row4;
                $users[$row['Q_ANO']][$row['Q_MES']]['users'][$i] = $row;
                $i++;
              }
            } else {
              $respuesta = "No KPIs";
              }
          } else {
            $respuesta = "Error en BD";
          }
          $respuesta[1] = $kpis;
          $respuesta[2] = $users;
          $respuesta[3] = $i;

          return $respuesta;
        }

        public function updateKPIResuelto($kpi_resuelto){
          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          for($i = 0; $i<count($kpi_resuelto);$i++){
            if($kpi_resuelto[$i]['value1'] != null){
              $sql = "UPDATE kpi_resuelto SET Q_VALORREAL1 = '".$kpi_resuelto[$i]['value1']."' where K_IDKPI_RESUELTO = ".$kpi_resuelto[$i]['id'].";";
              if ($session != "false"){
                $session->query($sql);
              } else {
                $respuesta = 'false';
              }
            }
            if($kpi_resuelto[$i]['value2'] != null){
              $sql2 = "UPDATE kpi_resuelto SET Q_VALORREAL2 = '".$kpi_resuelto[$i]['value2']."' where K_IDKPI_RESUELTO = ".$kpi_resuelto[$i]['id'].";";
              if ($session != "false"){
                $session->query($sql2);
              } else {
                $respuesta = 'false';
              }
            }
            if($kpi_resuelto[$i]['value3'] != null){
              $sql3 = "UPDATE kpi_resuelto SET Q_VALORREAL3 = '".$kpi_resuelto[$i]['value3']."' where K_IDKPI_RESUELTO = ".$kpi_resuelto[$i]['id'].";";
              if ($session != "false"){
                $session->query($sql3);
              } else {
                $respuesta = 'false';
              }
            }
          }
          return $respuesta;
        }

        public function fixMonth($month){
          switch ($month) {
            case '1':
              $month = 'Enero';
              break;
            case '2':
              $month = 'Febrero';
              break;
            case '3':
              $month = 'Marzo';
              break;
            case '4':
              $month = 'Abril';
              break;
            case '5':
              $month = 'Mayo';
              break;
            case '6':
              $month = 'Junio';
              break;
            case '7':
              $month = 'Julio';
              break;
            case '8':
              $month = 'Agosto';
              break;
            case '9':
              $month = 'Septiembre';
              break;
            case '10':
              $month = 'Octubre';
              break;
            case '11':
              $month = 'Noviembre';
              break;
            case '12':
              $month = 'Diciembre';
              break;
            default:
              $month = "";
              break;
          }
          return $month;
        }
    }
?>

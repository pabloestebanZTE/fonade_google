<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

//    session_start();

    class Dao_softwareStuff_model extends CI_Model{

        public function __construct(){
            $this->load->model('data/configdb_model');
        }

        public function createSoftwareStuff($OS, $OF, $OV, $AV, $AVV, $BR, $BRV, $SI, $SIV, $MA, $MAV, $SAC, $SACV, $SEM, $SEMV, $JAWS, $id){
          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          if ($session != "false"){
            $sql = "INSERT INTO software_inventory (N_OPERATIVE_SYSTEM, N_OFFICE_VERSION, N_ANTIVIRUS_VERSION, N_BROWSER_VERSION, N_SIMONTIC_VERSION, N_MAGIC_VERSION, N_SAC_VERSION, N_SEMILLA_VERSION, N_JAWS_VERSION, K_IDSTUFF)
                VALUES ('".$OS."', '".$OV."', '".$AVV."', '".$BRV."', '".$SIV."','".$MAV."', '".$SACV."', '".$SEMV."', '".$JAWS."', ".$id.");";
                echo "<br><br><br>".$sql;
            $result = $session->query($sql);
          } else {
            $user = "Error de informacion";
          }
          return $respuesta;
        }

        public function getAllSoftwareInventoryPerPVD($idPVD){
          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          $sql = "SELECT  K_SOFTWARE_INVENTORY,N_OPERATIVE_SYSTEM, N_OFFICE_VERSION, N_ANTIVIRUS_VERSION, N_BROWSER_VERSION, N_SIMONTIC_VERSION, N_MAGIC_VERSION, N_SAC_VERSION, N_SEMILLA_VERSION, N_JAWS_VERSION, stuff.K_IDSTUFF
          FROM software_inventory, pvd, stuff WHERE software_inventory.K_IDSTUFF = stuff.K_IDSTUFF and stuff.K_IDPVD = pvd.K_IDPVD and pvd.K_IDPVD = ".$idPVD.";";
          if ($session != "false"){
            $result = $session->query($sql);
            if ($result->num_rows > 0) {
              $i = 0;
              while($row = $result->fetch_assoc()) {
                $sql2 = "SELECT K_IDMODEL, N_SERIAL FROM stuff WHERE K_IDSTUFF = ".$row['K_IDSTUFF'].";";
                $result2 = $session->query($sql2);
                $row2 = $result2->fetch_assoc();
                $sql3 = "SELECT N_NAME, K_IDMANUFACTURER from model WHERE K_IDMODEL = ".$row2['K_IDMODEL'].";";
                $result3 = $session->query($sql3);
                $row3 = $result3->fetch_assoc();
                $sql4 = "SELECT N_NAME FROM manufacturer WHERE K_IDMANUFACTURER = ".$row3['K_IDMANUFACTURER'].";";
                $result4 = $session->query($sql4);
                $row4 = $result4->fetch_assoc();
                $row['marca'] = $row4['N_NAME'];
                $row['modelo'] = $row3['N_NAME'];
                $row['serial'] = $row2['N_SERIAL'];
                $respuesta[$i] = $row;
                $i++;
              }
            }
          } else {
            $respuesta = "Error de informacion";
          }
          return $respuesta;
        }

        public function updateSoftwareInventory($id, $SO, $office, $AV, $Br, $SIM, $MAG, $SAC, $SEM, $JAWS){
          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          $sql = "UPDATE software_inventory SET N_OPERATIVE_SYSTEM = '".$SO."', N_OFFICE_VERSION = '".$office."', N_ANTIVIRUS_VERSION = '".$AV."', N_BROWSER_VERSION = '".$Br."', N_SIMONTIC_VERSION = '".$SIM."', N_MAGIC_VERSION = '".$MAG."', N_SAC_VERSION ='".$SAC."', N_SEMILLA_VERSION='".$SEM."', N_JAWS_VERSION = '".$JAWS."' WHERE K_SOFTWARE_INVENTORY = ".$id.";";
          if ($session != "false"){
            $result = $session->query($sql);
            $respuesta = "true";
          } else {
            $respuesta = "Error de informacion";
          }
          return $respuesta;
        }
    }
?>

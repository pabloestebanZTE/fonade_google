<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  //    session_start();

  class Dao_inventory_model extends CI_Model{
    public function __construct(){
      $this->load->model('data/configdb_model');
    }

    public function getStuffCatById($id){
      $dbConnection = new configdb_model();
      $session = $dbConnection->openSession();
      $sql = "SELECT * FROM stuff_category WHERE K_IDSTUFF_CATEGORY = ".$id.";";
      if ($session != "false"){
        $result = $session->query($sql);
        $respuesta = $result->fetch_assoc();
      } else {
        $respuesta = "Error de informacion";
      }
      return $respuesta;
    }

    public function getEquipmentTypePVD($id_fase, $id_tipo, $id_pvd){
      if ($id_tipo == "A" || $id_tipo == "B" || $id_tipo == "C" || $id_tipo == "D"){
        $id_tipo = "Tipo ".$id_tipo;
      }
      $dbConnection = new configdb_model();
      $session = $dbConnection->openSession();
      $sql = "SELECT K_IDTYPOLOGY from typology where N_NAME = '".$id_tipo."';";
      if ($session != "false"){
        $result = $session->query($sql);
        $row = $result->fetch_assoc();
        $sql = "SELECT * FROM equipment_type where K_IDPHASE = ".$id_fase." and K_IDTYPOLOGY =".$row['K_IDTYPOLOGY'].";";
        $result = $session->query($sql);
        if ($result->num_rows > 0) {
          $i = 0;
          while($row = $result->fetch_assoc()) {
            $sql2 = "SELECT N_NAME FROM equipment_generic where K_IDEQUIPMENT_GENERIC = ".$row['K_IDEQUIPMENT_GENERIC'].";";
            $result2 = $session->query($sql2);
            $row2 = $result2->fetch_assoc();
            $row['N_NAME'] = $row2['N_NAME'];
            $respuesta[$i] = $row;
            $sql3 = "SELECT stuff.N_NAME, stuff.K_IDSTUFF, stuff.K_IDPVD_PLACE, stuff.K_IDMODEL, stuff.N_SERIAL, stuff.N_PLACAINVENTARIO, stuff.N_PARTE, stuff.N_ESTADO, stuff.K_IDSTUFF_CATEGORY, stuff.K_IDPVD, stuff.Q_PROGRESS, stuff_category.V_PRICE_R1, stuff_category.V_PRICE_R4 from stuff, stuff_category, equipment_generic where K_IDPVD = ".$id_pvd." and equipment_generic.K_IDEQUIPMENT_GENERIC=stuff_category.K_IDEQUIPMENT_GENERIC and stuff_category.K_IDSTUFF_CATEGORY=stuff.K_IDSTUFF_CATEGORY and equipment_generic.K_IDEQUIPMENT_GENERIC=".$row['K_IDEQUIPMENT_GENERIC'].";";
            $result3 = $session->query($sql3);
            if ($result3->num_rows > 0) {
              $j = 0;
              while($row3 = $result3->fetch_assoc()) {
                $sql4 = "SELECT * FROM pvd_zone WHERE K_IDPVDZONE = ".$row3['K_IDPVD_PLACE'].";";
                $result4 = $session->query($sql4);
                $row4 = $result4->fetch_assoc();
                $row3['K_IDPVD_PLACE'] = $row4;
                $sql5 = "SELECT * FROM ticket_corrective_maintenance WHERE K_IDSTUFF = ".$row3['K_IDSTUFF'].";";
                $result5 = $session->query($sql5);
                if ($result5->num_rows > 0) {
                  while($row5 = $result5->fetch_assoc()) {
                    $row3['corrective'] = $row5;
                  }
                }
                $respuesta[$i]['inventario'][$j] = $row3;
                $respuesta[$i]['inventario'][$j]['url'] = "";
                $j++;
              }
            } else {
              $respuesta[$i]['inventario'] = "NI";
            }
            $i++;
          }
        }
      } else {
        $respuesta = "Error de informacion";
      }
      return $respuesta;
    }

    public function getAllEquipment($id_fase, $id_tipo, $id_pvd){
      if ($id_tipo == "A" || $id_tipo == "B" || $id_tipo == "C" || $id_tipo == "D"){
        $id_tipo = "Tipo ".$id_tipo;
      }
      $dbConnection = new configdb_model();
      $session = $dbConnection->openSession();
      $sql = "SELECT K_IDTYPOLOGY from typology where N_NAME = '".$id_tipo."';";
      if ($session != "false"){
        $result = $session->query($sql);
        $row = $result->fetch_assoc();
        $sql = "SELECT * FROM equipment_type where K_IDPHASE = ".$id_fase." and K_IDTYPOLOGY =".$row['K_IDTYPOLOGY'].";";
        $result = $session->query($sql);
        if ($result->num_rows > 0) {
          $i = 0;
          while($row = $result->fetch_assoc()) {
            $sql2 = "SELECT N_NAME FROM equipment_generic where K_IDEQUIPMENT_GENERIC = ".$row['K_IDEQUIPMENT_GENERIC'].";";
            $result2 = $session->query($sql2);
            $row2 = $result2->fetch_assoc();
            $row['N_NAME'] = $row2['N_NAME'];
            $respuesta[$i] = $row;
            $sql3 =  "SELECT * FROM stuff_category WHERE K_IDEQUIPMENT_GENERIC = ".$row['K_IDEQUIPMENT_GENERIC'].";";
            $result3 = $session->query($sql3);
            if ($result3->num_rows > 0) {
              $j = 0;
              while($row3 = $result3->fetch_assoc()) {
                $respuesta[$i]['category'][$j] = $row3;
                $sql4 = "SELECT * FROM model where K_IDSTUFF_CATEGORY = ".$row3['K_IDSTUFF_CATEGORY'].";";
                $result4 = $session->query($sql4);
                  if ($result4->num_rows > 0) {
                    $k = 0;
                    while($row4 = $result4->fetch_assoc()) {
                      $sql5 = "SELECT * FROM manufacturer WHERE K_IDMANUFACTURER = ".$row4['K_IDMANUFACTURER'].";";
                      $result5 = $session->query($sql5);
                      $row5 = $result5->fetch_assoc();
                      $row4['K_IDMANUFACTURER'] = $row5;
                      $respuesta[$i]['category'][$j]['model'][$k] = $row4;
                      $k++;
                    }
                  }
                  $sql6 = "SELECT * FROM checklist where K_IDEQUIPMENT_GENERIC = ".$row['K_IDEQUIPMENT_GENERIC'].";";
                  $result6 = $session->query($sql6);
                  if ($result6->num_rows > 0) {
                    $l = 0;
                    while($row6 = $result6->fetch_assoc()) {
                      $sql7 = "SELECT * FROM item_checklist WHERE K_IDITEM_CHECKLIST = ".$row6['K_IDITEM_CHECKLIST'].";";
                      $result7 = $session->query($sql7);
                      $row7 = $result7->fetch_assoc();
                      $row6['K_IDITEM_CHECKLIST'] = $row7;
                      $respuesta[$i]['rutina'][$l] = $row6;
                      $l++;
                    }
                  }
                $j++;
              }
            }
        //    print_r($respuesta[$i]);
        //    echo "<br><br>";
            $i++;
          }
        }
      } else {
        $respuesta = "Error de informacion";
      }
      return $respuesta;
    }

    public function insertEquipment($equipment, $pvd){
      $dbConnection = new configdb_model();
      $session = $dbConnection->openSession();
      $sql = "INSERT INTO stuff (K_IDMODEL, N_SERIAL, N_PLACAINVENTARIO, N_PARTE, N_ESTADO, K_IDSTUFF_CATEGORY, K_IDPVD, Q_PROGRESS, K_IDPVD_PLACE, N_NAME)
        values (".$equipment->getModelo().", '".$equipment->getSerial()."', '".$equipment->getPlaca()."', '".$equipment->getParte()."', '".$equipment->getEstado()."', ".$equipment->getCategoria().", ".$pvd.", ".$equipment->getProgress().",".$equipment->getZona().",'".$equipment->getTipo1()."' );";
      if ($session != "false"){
        $session->query($sql);
        $sql2 = "SELECT K_IDSTUFF FROM stuff WHERE K_IDMODEL = '".$equipment->getModelo()."' and N_SERIAL = '".$equipment->getSerial()."' and N_PLACAINVENTARIO = '".$equipment->getPlaca()."' and N_PARTE = '".$equipment->getParte()."' and N_ESTADO = '".$equipment->getEstado()."' and K_IDSTUFF_CATEGORY = '".$equipment->getCategoria()."' and K_IDPVD = '".$pvd."' and Q_PROGRESS = '".$equipment->getProgress()."' and K_IDPVD_PLACE = '".$equipment->getZona()."';";
        $result = $session->query($sql2);
        while($row = $result->fetch_assoc()) {
          $respuesta = $row['K_IDSTUFF'];
        }
      } else {
        $respuesta = "Error de informacion";
      }
      return $respuesta;
    }

    public function updateEquipment($equipment, $PVD){
      $dbConnection = new configdb_model();
      $session = $dbConnection->openSession();
      $sql = "UPDATE stuff SET N_ESTADO = '".$equipment->getEstado()."', Q_PROGRESS =".$equipment->getProgress().", N_NAME ='".$equipment->getTipo1()."', N_SERIAL = '".$equipment->getSerial()."', N_PARTE = '".$equipment->getParte()."', N_PLACAINVENTARIO = '".$equipment->getPlaca()."' where K_IDSTUFF = ".$equipment->getId().";";
      $session->query($sql);
      if($equipment->getZona() != -1){
        $sql2 = "UPDATE stuff SET K_IDPVD_PLACE = '".$equipment->getZona()."' where K_IDSTUFF = ".$equipment->getId().";";
      }
      $session->query($sql2);
    }

    public function deteleElementById($id){
      $dbConnection = new configdb_model();
      $session = $dbConnection->openSession();
      $sql = "DELETE FROM stuff WHERE K_IDSTUFF = ".$id.";";
      $session->query($sql);
      $sql2 = "DELETE FROM software_inventory WHERE K_IDSTUFF =".$id.";";
      $session->query($sql2);
     }

     public function getModelbiId($idModel){
      $dbConnection = new configdb_model();
      $session = $dbConnection->openSession();
      $sql =  "SELECT * FROM model WHERE K_IDMODEL = ".$idModel.";";
      if ($session != "false"){
        $result = $session->query($sql);
        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $sql2 = "SELECT * FROM manufacturer WHERE K_IDMANUFACTURER = ".$row['K_IDMANUFACTURER'].";";
          $sql3 = "SELECT * FROM stuff_category WHERE K_IDSTUFF_CATEGORY = ".$row['K_IDSTUFF_CATEGORY'].";";
          $result2 = $session->query($sql2);
          $result3 = $session->query($sql3);
          $row2 = $result2->fetch_assoc();
          $row3 = $result3->fetch_assoc();
        }
        $respuesta['ma'] = $row2['N_NAME'];
        $respuesta['sc'] = $row3['N_NAME'];
        $respuesta['mo'] = $row['N_NAME'];
      }
      return $respuesta;
    }

    public function getCorrectiveTicketPerStuff($idStuff){
      $dbConnection = new configdb_model();
      $session = $dbConnection->openSession();
      $sql =  "SELECT * FROM ticket_corrective_maintenance WHERE K_IDSTUFF = ".$idStuff.";";
      if ($session != "false"){
        $result = $session->query($sql);
        $row = $result->fetch_assoc();
      }
      return $row;
    }

    public function getAllStuffPerPVD($idPVD){
      $dbConnection = new configdb_model();
      $session = $dbConnection->openSession();
      $sql = "SELECT * FROM stuff WHERE K_IDPVD = ".$idPVD.";";
      if ($session != "false"){
        $result = $session->query($sql);
        $i = 0;
        while($row = $result->fetch_assoc()) {
          $respuesta[$i] = $row;
          $i++;
        }
      }
      return $respuesta;
    }

    public function getAAperPVD($pvd, $reg){
      $dbConnection = new configdb_model();
      $session = $dbConnection->openSession();
      $sql = "SELECT * FROM stuff_category where K_IDEQUIPMENT_GENERIC = 34 ;";
      $result = $session->query($sql);
      if ($result->num_rows > 0) {
        $i = 0;
        while($row = $result->fetch_assoc()) {
          $respuesta[$i] = $row;
          $i++;
        }
      }

      $sql = "SELECT * FROM stuff where K_IDPVD = ".$pvd." and K_IDSTUFF_CATEGORY = 211";
      $result = $session->query($sql);
      if ($result->num_rows > 0) {
        $i = 0;
        while($row = $result->fetch_assoc()) {
          if($row['N_ESTADO']  == "Funcional"){
            $respuesta[12][0]++;
            $respuesta[12][2]+= $respuesta[0][$reg];
          }
          if($row['N_ESTADO']  == "Averiado"){
            $respuesta[12][1]++;
          }
          $i++;
        }
      } else {
         $respuesta[12][0] = 0;
         $respuesta[12][1] = 0;
      }

      $sql = "SELECT * FROM stuff where K_IDPVD = ".$pvd." and K_IDSTUFF_CATEGORY = 212";
      $result = $session->query($sql);
      if ($result->num_rows > 0) {
        $i = 0;
        while($row = $result->fetch_assoc()) {
          if($row['N_ESTADO']  == "Funcional"){
            $respuesta[18][0]++;
            $respuesta[18][2]+= $respuesta[1][$reg];
          }
          if($row['N_ESTADO']  == "Averiado"){
            $respuesta[18][1]++;
          }
          $i++;
        }
      } else {
        $respuesta[18][0] = 0;
        $respuesta[18][1] = 0;
      }

      $sql = "SELECT * FROM stuff where K_IDPVD = ".$pvd." and K_IDSTUFF_CATEGORY = 213";
      $result = $session->query($sql);
      if ($result->num_rows > 0) {
        $i = 0;
        while($row = $result->fetch_assoc()) {
          if($row['N_ESTADO']  == "Funcional"){
            $respuesta[24][0]++;
            $respuesta[24][2]+= $respuesta[2][$reg];
          }
          if($row['N_ESTADO']  == "Averiado"){
            $respuesta[24][1]++;
          }
          $i++;
        }
      } else {
        $respuesta[24][0] = 0;
        $respuesta[24][1] = 0;
     }

      $sql = "SELECT * FROM stuff where K_IDPVD = ".$pvd." and K_IDSTUFF_CATEGORY = 214";
      $result = $session->query($sql);
      if ($result->num_rows > 0) {
        $i = 0;
        while($row = $result->fetch_assoc()) {
          if($row['N_ESTADO']  == "Funcional"){
            $respuesta[36][0]++;
            $respuesta[36][2]+= $respuesta[3][$reg];
          }
          if($row['N_ESTADO']  == "Averiado"){
            $respuesta[36][1]++;
          }
          $i++;
        }
      } else {
        $respuesta[36][0] = 0;
        $respuesta[36][1] = 0;
      }

      $sql = "SELECT * FROM stuff where K_IDPVD = ".$pvd." and K_IDSTUFF_CATEGORY = 215";
      $result = $session->query($sql);
      if ($result->num_rows > 0) {
        $i = 0;
        while($row = $result->fetch_assoc()) {
          if($row['N_ESTADO']  == "Funcional"){
            $respuesta[48][0]++;
            $respuesta[48][2]+= $respuesta[4][$reg];
          }
          if($row['N_ESTADO']  == "Averiado"){
            $respuesta[48][1]++;
          }
           $i++;
        }
      } else {
        $respuesta[48][0] = 0;
        $respuesta[48][1] = 0;
      }

      $sql = "SELECT * FROM stuff where K_IDPVD = ".$pvd." and K_IDSTUFF_CATEGORY = 216";
      $result = $session->query($sql);
      if ($result->num_rows > 0) {
        $i = 0;
        while($row = $result->fetch_assoc()) {
          if($row['N_ESTADO']  == "Funcional"){
            $respuesta[9][0]++;
            $respuesta[9][2]+= $respuesta[5][$reg];
          }
          if($row['N_ESTADO']  == "Averiado"){
            $respuesta[9][1]++;
          }
          $i++;
        }
      } else {
        $respuesta[9][0] = 0;
        $respuesta[9][1] = 0;
      }
      return $respuesta;

    }
  }
?>

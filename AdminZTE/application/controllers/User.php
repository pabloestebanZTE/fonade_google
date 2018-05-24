<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('data/dao_user_model');
        $this->load->model('data/configdb_model');
    }

    public function loadPrincipalView(){
      $this->load->view('principal');
    }

    function loginUser() {
      $user = new user_model();
      $user = $user->createUser($_POST['user'], $_POST['password'],'','');
      $user = $this->dao_user_model->startSession($user);
      $respuesta['user'] = $user;
      if ($user != "Error de informacion"){
        $this->load->view('principal');
      } else {
        $this->load->view('login', $respuesta);
      }
    }

    public function detailByUser(){

      $person['user'] = $this->dao_user_model->getAllUsers();
      $this->load->view('userDetails', $person);
    }
    //obtener todos los tecnicos y auxiliares
    public function getTechnical(){
      // header('Content-Type: text/plain');
      // Usuarios IT
      $user['IT-T'] = $this->dao_user_model->getTechnicalIT();
      $user['IT-A'] = $this->dao_user_model->getAuxiliarIT();
      // //Usuario AA
      $user['AA-T'] = $this->dao_user_model->getTechnicalAA();
      $user['AA-A'] = $this->dao_user_model->getAuxiliarAA();
      // print_r($user);
      echo json_encode($user);

    }
}

?>

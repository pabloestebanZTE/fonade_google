<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ZTEPlatform extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('data/dao_user_model');
        $this->load->model('data/configdb_model');
    }

    public function platformZTE(){
      $this->load->view('ZTEPlatform');
    }

}

?>

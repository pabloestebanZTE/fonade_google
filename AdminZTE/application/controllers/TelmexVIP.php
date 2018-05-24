<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class TelmexVIP extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('form');
    }

    public function routingVerification(){
      $this->load->view('dataValidation');
    }

}

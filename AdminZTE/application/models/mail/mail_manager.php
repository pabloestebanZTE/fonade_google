<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Mail_manager extends CI_Model{

        public function __construct(){
            $this->load->model('data/configdb_model');
            $this->load->model('data/dao_ticket_model');
        }

        public function mailtest(){
          $this->load->library('email');


          $this->email->from('your@example.com', 'Your Name');
          $this->email->to('yuyupa14@gmail.com, andrea.rosero.ext@claro.com.co, andrea.lorenaroserochasoy@zte.com.cn, pablo.esteban@zte.com.cn');
          $this->email->cc('another@another-example.com');
          $this->email->bcc('them@their-example.com');

          $this->email->subject('Email Test');
          $this->email->message('Testing the email class.');

          $this->email->send();
        }


      	public function mailNotification($pvd){
          $ticket = $this->dao_ticket_model->getTicketByID();
     	 		$destinatario = "andrea.lorenaroserochasoy@zte.com.cn,paestebanv@gmail.com,pablo.esteban@zte.com.cn,andrea.rosero.ext@claro.com.co";
          $asunto = "Este mensaje es de prueba";
          $hearder = 'MIME-Version: 1.0' . "\r\n";
          $hearder .= 'Content-type: text/html; charset=utf-8' . "\r\n";
          $hearder .= "From: desarrolladores_ZTE";
          $cuerpo = "
          <html>
          <head>
             <title>Prueba de correo</title>
          </head>
          <body>
          <h1>Hola prueba</h1>
          <p>
          <b>Este es el correo  electrónico de prueba</b>. Esta es una prueba de envio de correo . Este es el cuerpo del mensaje, es una prueba sin envio de ninguna variable y pruebo enviando a dos destinatarios, ya no se que mas escrbirle al cuerpo para quede mas largo y lo pueda visualizar mejor.
          </p>
          </body>
          </html>
          ";
          echo "<br><br><br>";
          echo "correo enviado";
          mail($destinatario,$asunto,$cuerpo,$hearder);
          return "ok";
        }
    }
?>

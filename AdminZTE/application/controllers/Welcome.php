<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		/*$this->load->model('data/configdb_model');
		$dbConnection = new configdb_model();
		$session = $dbConnection->openSession();
		if ($session != "false"){

										$sql = "SELECT * FROM city LIMIT 10";
										$result = $session->query($sql);

										if ($result->num_rows > 0) {
												while($row = $result->fetch_assoc()) {
							print_r($row);
												}
										} else {
												echo "0 results";
										}
										$dbConnection->closeSession($session);
		}*/
		$inicio['user'] = "Inicio sencillo";
		$this->load->view('login', $inicio);
	}
}

<?php
	//require_once 'Profesor_model.php';

	class PVD_model extends CI_Model{

		public $id;
		public $city;
    public $deparment;
    public $region;
		public $ejecutor;
		public $admin;
    public $direccion;
    public $tipologia;
    public $fase;
    public $maintenance;
		public $zones;

		public function __construct(){

		}

		public function getId(){return $this->id;}

		public function setId($id){$this->id = $id;}

    public function getCity(){return $this->city;}

    public function setCity($city){$this->city = $city;}

    public function getDepartment(){return $this->deparment;}

    public function setDepartment($deparment){$this->deparment = $deparment;}

    public function getRegion(){return $this->region;}

    public function setRegion($region){$this->region = $region;}

    public function getEjecutor(){return $this->ejecutor;}

    public function setEjecutor($ejecutor){$this->ejecutor = $ejecutor;}

    public function getAdmin(){return $this->admin;}

    public function setAdmin($admin){$this->admin = $admin;}

    public function getDireccion(){return $this->direccion;}

    public function setDireccion($direccion){$this->direccion = $direccion;}

    public function getTipologia(){return $this->tipologia;}

    public function setTipologia($tipologia){$this->tipologia = $tipologia;}

    public function getFase(){return $this->fase;}

    public function setFase($fase){$this->fase = $fase;}

    public function getMaintenance(){return $this->maintenance;}

    public function setMaintenance($maintenance){$this->maintenance = $maintenance;}

		public function getZones(){return $this->zones;}

    public function setZones($zones){$this->zones = $zones;}

		public function createPVD($id, $city, $deparment, $region, $direccion, $fase, $tipologia){
			$newPVD= new PVD_model();
			$newPVD->setId($id);
			$newPVD->setCity($city);
      $newPVD->setDepartment($deparment);
      $newPVD->setRegion($region);
      $newPVD->setDireccion($direccion);
      $newPVD->setFase($fase);
      $newPVD->setTipologia($tipologia);
			return $newPVD;
    }
	}
?>

<?php
	//require_once 'Profesor_model.php';

	class CorrectiveM_model extends CI_Model{

		protected $id;
    protected $idTicket;
    protected $idUser;
		protected $idPVD;
    protected $idPlace;
    protected $quantity;
    protected $damage;
		protected $idEquipment;
		protected $description;
    protected $stuff;
		protected $startDate;
		protected $finishDate;
		protected $status;

		public function __construct(){

		}

		public function getStatus(){return $this->status;}

		public function setStatus($status){$this->status = $status;}

		public function getFDate(){return $this->finishDate;}

		public function setFDate($finishDate){$this->finishDate = $finishDate;}

		public function getSDate(){return $this->startDate;}

		public function setSDate($startDate){$this->startDate = $startDate;}

		public function getId(){return $this->id;}

		public function setId($id){$this->id = $id;}

    public function getTicket(){return $this->idTicket;}

    public function setTicket($idTicket){$this->idTicket = $idTicket;}

    public function getUser(){return $this->idUser;}

    public function setUser($idUser){$this->idUser = $idUser;}

    public function getPVD(){return $this->idPVD;}

    public function setPVD($idPVD){$this->idPVD = $idPVD;}

    public function getPlace(){return $this->idPlace;}

    public function setPlace($idPlace){$this->idPlace = $idPlace;}

    public function getQuantity(){return $this->quantity;}

    public function setQuantity($quantity){$this->quantity = $quantity;}

    public function getDamage(){return $this->damage;}

    public function setDamage($damage){$this->damage = $damage;}

    public function getEquipment(){return $this->idEquipment;}

    public function setEquipment($idEquipment){$this->idEquipment = $idEquipment;}

    public function getDescription(){return $this->description;}

    public function setDescription($description){$this->description = $description;}

    public function getStuff(){return $this->stuff;}

    public function setStuff($stuff){$this->stuff = $stuff;}

		public function createMaintenance($id, $idTicket, $idUser, $idPVD, $idPlace, $quantity, $damage, $idEquipment, $description, $stuff, $startDate, $finishDate, $status){
			$newMaintenance= new correctiveM_model();
			$newMaintenance->setId($id);
      $newMaintenance->setTicket($idTicket);
      $newMaintenance->setUser($idUser);
      $newMaintenance->setPVD($idPVD);
      $newMaintenance->setPlace($idPlace);
      $newMaintenance->setQuantity($quantity);
      $newMaintenance->setDamage($damage);
      $newMaintenance->setEquipment($idEquipment);
      $newMaintenance->setDescription($description);
      $newMaintenance->setStuff($stuff);
			$newMaintenance->setSDate($startDate);
			$newMaintenance->setFDate($finishDate);
			$newMaintenance->setStatus($status);
			return $newMaintenance;
    }
	}
?>

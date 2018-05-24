<?php
	//require_once 'Profesor_model.php';

	class Ticket_model extends CI_Model{

		public $id;
		public $idMaintenance;
    public $status;
    public $dateStart;
		public $dateFinish;
    public $dateStartIT;
		public $dateFinishIT;
   public $dateStartAA;
		public $dateFinishAA;
		public $techs;
		public $duracion;
		public $color;
		public $observacionesInicio;
		public $observacionesFinal;
		public $estadia;
		public $almuerzos;
		public $estadoI;

		public function __construct(){

		}

		public function getEstadoI(){return $this->estadoI;}

		public function setEstadoI($estadoI){$this->estadoI = $estadoI;}

		public function getId(){return $this->id;}

		public function setId($id){$this->id = $id;}

    public function getIdM(){return $this->idMaintenance;}

    public function setIdM($idMaintenance){$this->idMaintenance = $idMaintenance;}

    public function getStatus(){return $this->status;}

    public function setStatus($status){$this->status = $status;}

    public function getDateS(){return $this->dateStart;}

    public function setDateS($dateStart){$this->dateStart = $dateStart;}

    public function getDateF(){return $this->dateFinish;}

    public function setDateF($dateFinish){$this->dateFinish = $dateFinish;}

		public function getDateSIT(){return $this->dateStartIT;}

    public function setDateSIT($dateStartIT){$this->dateStartIT = $dateStartIT;}

    public function getDateFIT(){return $this->dateFinishIT;}

    public function setDateFIT($dateFinishIT){$this->dateFinishIT = $dateFinishIT;}

		public function getDateSAA(){return $this->dateStartAA;}

		public function setDateSAA($dateStartAA){$this->dateStartAA = $dateStartAA;}

		public function getDateFAA(){return $this->dateFinishAA;}

		public function setDateFAA($dateFinishAA){$this->dateFinishAA = $dateFinishAA;}

    public function getDuracion(){return $this->duracion;}

    public function setDuracion($duracion){$this->duracion = $duracion;}

		public function getTechs(){return $this->techs;}

		public function setTechs($techs){$this->techs = $techs;}

		public function getColor(){return $this->color;}

		public function setColor($color){$this->color = $color;}

    public function getObservacionesI(){return $this->observacionesInicio;}

    public function setObservacionesI($observacionesInicio){$this->observacionesInicio = $observacionesInicio;}

		public function getObservacionesF(){return $this->observacionesFinal;}

		public function setObservacionesF($observacionesFinal){$this->observacionesFinal = $observacionesFinal;}

		public function getAlmuerzos(){return $this->almuerzos;}

		public function setAlmuerzos($almuerzos){$this->almuerzos = $almuerzos;}

		public function getEstadia(){return $this->estadia;}

		public function setEstadia($estadia){$this->estadia = $estadia;}

		public function createTicket($id, $idMaintenance, $status, $dateStart, $dateFinish, $duracion, $dateStartIT, $dateFinishIT, $dateStartAA, $dateFinishAA, $techs, $color, $observacionesInicio){
      $newTicket= new ticket_model();
			$newTicket->setId($id);
			$newTicket->setIdM($idMaintenance);
      $newTicket->setStatus($status);
      $newTicket->setDateS($dateStart);
      $newTicket->setDateF($dateFinish);
      $newTicket->setDuracion($duracion);
			$newTicket->setDateSIT($dateStartIT);
			$newTicket->setDateFIT($dateFinishIT);
			$newTicket->setDateSAA($dateStartAA);
			$newTicket->setDateFAA($dateFinishAA);
			$newTicket->setTechs($techs);
			$newTicket->setColor($color);
     		$newTicket->setObservacionesI($observacionesInicio);
			return $newTicket;
    }

		public function calculateDuration(){
			if ($this->getDateS() != NULL && $this->getDateF() != NULL){
				$date1=date_create($this->getDateS());
				$date2=date_create($this->getDateF());
				$diff=date_diff($date1,$date2);
				$diff = $diff->format("%a");
			} else {
				if ($this->getDateS() != NULL){
					$date1=date_create($this->getDateS());
					date_default_timezone_set("America/Bogota");
					$date = date("Y-m-d");
					$date2 = date_create($date);
					$diff=date_diff($date1,$date2);
					$diff = $diff->format("%a");
				} else {
					$diff = NULL;
				}
			}
			if ($diff == 0){
				$diff = 1;
			}
			return $diff;
		}
	}
?>

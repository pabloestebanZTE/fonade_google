<?php
	//require_once 'Profesor_model.php';

	class Equipment_model extends CI_Model{

		protected $id;
		protected $categoria;
		protected $tipo1;
		protected $tipo2;
		protected $serial;
		protected $other;
		protected $marca;
    protected $modelo;
		protected $placa;
		protected $parte;
		protected $estado;
		protected $progress;
		protected $zona;

		public function __construct(){
		}

		public function getId(){return $this->id;}

		public function setId($id){$this->id = $id;}

		public function getCategoria(){return $this->categoria;}

		public function setCategoria($categoria){$this->categoria = $categoria;}

    public function getTipo1(){return $this->tipo1;}

    public function setTipo1($tipo1){$this->tipo1 = $tipo1;}

		public function getTipo2(){return $this->tipo2;}

		public function setTipo2($tipo2){$this->tipo2 = $tipo2;}

		public function getOther(){return $this->other;}

		public function setOther($other){$this->other = $other;}

    public function getSerial(){return $this->serial;}

    public function setSerial($serial){$this->serial = $serial;}

    public function getMarca(){return $this->marca;}

    public function setMarca($marca){$this->marca = $marca;}

    public function getModelo(){return $this->modelo;}

    public function setModelo($modelo){$this->modelo = $modelo;}

		public function getPlaca(){return $this->placa;}

		public function setPlaca($placa){$this->placa = $placa;}

		public function getParte(){return $this->parte;}

    public function setParte($parte){$this->parte = $parte;}

		public function getEstado(){return $this->estado;}

    public function setEstado($estado){$this->estado = $estado;}

		public function getProgress(){return $this->progress;}

    public function setProgress($progress){$this->progress = $progress;}

		public function getZona(){return $this->zona;}

		public function setZona($zona){$this->zona = $zona;}

		public function createEquipment($id, $categoria, $tipo1, $tipo2, $other,$serial, $marca, $modelo, $placa, $parte, $estado, $progress){
			$newEquipment = new equipment_model();
			$newEquipment->setId($id);
			$newEquipment->setCategoria($categoria);
			$newEquipment->setTipo1($tipo1);
			$newEquipment->setTipo2($tipo2);
			$newEquipment->setOther($other);
			$newEquipment->setSerial($serial);
			$newEquipment->setMarca($marca);
      $newEquipment->setModelo($modelo);
			$newEquipment->setPlaca($placa);
			$newEquipment->setParte($parte);
			$newEquipment->setEstado($estado);
			$newEquipment->setProgress($progress);

			return $newEquipment;
    }
	}
?>

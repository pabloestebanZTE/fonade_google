<?php
	//require_once 'Profesor_model.php';

	class User_model extends CI_Model{

		public $id;
		public $idTicket;//---------camilo-----
		public $pass;
		public $name;
		public $lastname;
    protected $permissions;

		public function __construct(){

		}

		public function getId(){return $this->id;}

		public function setId($id){$this->id = $id;}

		public function getIdTicket(){return $this->idTicket;}//----------camilo
		
		public function setIdTicket($idTicket){$this->idTicket = $idTicket;}//------------camilo

    public function getName(){return $this->name;}

    public function setName($name){$this->name = $name;}

    public function getPass(){return $this->pass;}

    public function setPass($pass){$this->pass = $pass;}

    public function getLastname(){return $this->lastname;}

    public function setLastname($lastname){$this->lastname = $lastname;}

    public function getPermissions(){return $this->permissions;}

    public function setPermissions($permissions){$this->permissions = $permissions;}

		public function createUser($id, $pass, $name, $lastname){
			$newUsuario= new user_model();
			$newUsuario->setId($id);
			$newUsuario->setPass($pass);
			$newUsuario->setName($name);
			$newUsuario->setLastname($lastname);

			return $newUsuario;
    	}
	}
?>

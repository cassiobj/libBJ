<?php
include "defines.php";
include "enum.php";
//include "stdObject.php";

if (!defined('T_CONEXAO_SINGLETON_H'))
{
	define('T_CONEXAO_SINGLETON_H', '0');

	class T_CONEXAO_SINGLETON
	{
		private static $instance;
		private $host="localhost";
		private $username;
		private $password;
		private $database;
		public $conexao=NULL;		
		
		public static function getInstance()
		{
		
			if(!self::$instance) {
				self::$instance = new self();
			}
			return self::$instance;
		}
		
		public function __construct($Host="localhost", $User = "", $Password = "", $Database="")
		{
			$this->host = $Host;
			$this->username = $User;
			$this->password = $Password;
		}
		
		public function setHost($Host) { $this->host = $Host; }
		public function getHost() { return $this->host ; }
		
		public function setUserName($user) { $this->username = $user; }
		public function getUserName() { return $this->username ; }
		
		public function setPassword($pass) { $this->password = $pass; }
		public function getPassword() { return $this->password ; }
		
		public function setDatabase($Database) { $this->database = $Database;}
		public function getDatabase() { return $this->database ; }
		
		public function connect()
		{
			$this->conexao = new mysqli($this->host, $this->username, $this->password, $this->database); 
			
			if ($this->conexao->connect_errno) 
			{
				showMessageSystemErro("Erro ao conectar com base:(" . $this->conexao->connect_errno  . ")  " . $this->conexao->connect_error );
				return;
			}
								
		}	
		
		public function disconnect()
		{
			$this->conexao->close();
			$this->conexao=NULL;
		}
		
		public function __destruct()
		{
			if ($this->conexao)
			{
				$this->conexao->close();
			}
		}
	}
	
}	

?>
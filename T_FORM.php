<?php

if (!defined('T_FORM_H')) {
	define('T_FORM_H', '0');

	if (!defined('POST')) {
		define('POST', 'POST');
	}
	
	if (!defined('GET')) {
		define('GET', 'GET');
	}
	
	class T_FORM
	{
		private static $criouHiddens;
		private $nameForm="";
		private $idForm="";
		private $method;
		private $idUsuario="";
		private $idGrupoUsuario="";
		private $idRegistro="";
		private $operacao = "";
		
		public function __construct($nome="form1", $metodo="GET", $url = "#")
		{
			$this->nameForm=$nome;
			$this->idForm=$nome;
			$this->method=$metodo;
			$this->url="#";
		}
		
		public function setName($xNameForm)	{ $this->nameForm = $xNameForm;}	
		public function getName()	{ return $this->nameForm ;}
		public function setID($xIDForm)	{ $this->idForm = $xIDForm; }	
		public function setFormMethodPost() { $this->method="POST";	}
		public function setFormMethodGet() { $this->method="GET";}
		public function setFormActiont($action) { $this->url=$action; }
		
		public function setIdUsuario($idUser) { $this->idUsuario = $idUser;}
		public function getIdUsuario() { return $this->idUsuario;}
		
		public function setIdGrupoUsuario($idGrupoUser) { $this->idGrupoUsuario = $idGrupoUser;}
		public function getIdGrupoUsuario() { return $this->idGrupoUsuario;}
		
		public function setIdRegistro($id) { $this->idRegistro = $id;}
		public function getIdRegistro() { return $this->idRegistro;}
		
		public function setOperacao($op) { $this->operacao = $op;}
		public function getOperacao() { return $this->operacao;}
		
		
		
		public function setFormMethod($METHOD) 
		{
			if ($METHOD!=POST && $METHOD!=GET)
			{
				showMessageSystemErro("Metodo ${METHOD} declarado para <form> é invalido.");
				return;
			}		
			$this->method=$METHOD;
		}
		
		
		
		public function openForm()
		{
			if (strlen($this->idForm)==0)
			{
				$this->idForm = $this->nameForm;
			}
			
			echo "<form method=\"" . $this->method . "\" action=\"". $this->url . "\" name=\"" . $this->nameForm . "\" id=\"" . $this->idForm . "\" enctype=\"multipart/form-data\" >";
			if (!self::$criouHiddens)
			{
				self::$criouHiddens = true;				
				echo "<input type=\"hidden\" name = \"txtMyPaginaTab\" id = \"txtMyPaginaTab\" value=\"\" >";
				echo "<input type=\"hidden\" name = \"txtLimitePagina\" id = \"txtLimitePagina\" value=\"\"  >";
				echo "<input type=\"hidden\" name = \"txtIndiceRegistro\" id = \"txtIndiceRegistro\" value=\"\" >";
				echo "<input type=\"hidden\" name = \"txtOperacao\" id = \"txtOperacao\" value=\"{$this->operacao}\" >";
				echo "<input type=\"hidden\" name = \"txtIdUsuario\" id = \"txtIdUsuario\" value=\"{$this->idUsuario}\" >";
				echo "<input type=\"hidden\" name = \"txtIdGrupoUsuario\" id = \"txtIdGrupoUsuario\" value=\"{$this->idGrupoUsuario}\" >";
				echo "<input type=\"hidden\" name = \"txtID\" id = \"txtID\" value=\"{$this->idRegistro}\" >";
			}
		}
		
		public function closeForm()
		{			
			echo "</form>";
		}
	}

}
?>
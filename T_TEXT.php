<?php 
include "defines.php";
include "enum.php";
//include "stdObject.php";
include "T_FONT.php";
include "T_BORDER.php";
include "T_INPUT.php";

if (!defined('T_TEXT_H'))
{
	define('T_TEXT_H', '0');


	class T_TEXT extends T_INPUT
	{		
		private $value;
		private $validation;
		private $descricao="";
		private $placeHolder="";
		private $readonly="";

		public function __construct($nome="txtText", $tipo = "TEXT", $maxSize=4096)
		{
			parent::__construct($nome, $tipo);			
			$this->setMaxLength($maxSize);	
						
		}
		
		public function setDescription($text) { $this->descricao=$text ; } 
		public function getDescription() { return $this->descricao ; }
		
		public function setPlaceHolder($text) { $this->placeHolder=$text ; } 
		public function getPlaceHolder() { return $this->placeHolder ; }
		
		/*public function setDisabled($valor)
		{
			if ($valor)
				$this->readonly = "readonly";
			else
				$this->readonly = "";
		}*/
	
		public function show($inside="")
		{
			
			if ($this->descricao!="")
			{
				$inside =" title=\"{$this->descricao}\" ";
			}
			if ($this->placeHolder != "")
			{
				$inside = $inside . " placeholder=\"{$this->placeHolder}\" ";
			}
			
			
			parent::show($inside);
			
		}					
			
	}
}


?>

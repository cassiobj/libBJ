<?php 
include "defines.php";
include "enum.php";
//include "stdObject.php";
include "T_FONT.php";
include "T_BORDER.php";
include "T_INPUT.php";

if (!defined('T_TEXTDATA_H'))
{
	define('T_TEXTDATA_H', '0');


	class T_TEXTDATA extends T_INPUT
	{		
		private $value;
		private $validation;
		private $descricao="";
		private $placeHolder="";
		private $readonly="";
		private $nomeID="";
		private $enableCalendar=true;

		public function __construct($nome="txtText", $tipo = "TEXT", $maxSize=4096)
		{
			parent::__construct($nome, $tipo);			
			$this->setMaxLength($maxSize);	
			$this->setReadonly(true) ;
			$this->nomeID = $nome;
		}
		
		public function setDescription($text) { $this->descricao=$text ; } 
		public function getDescription() { return $this->descricao ; }
		
		public function setPlaceHolder($text) { $this->placeHolder=$text ; } 
		public function getPlaceHolder() { return $this->placeHolder ; }
		
		public function setCalendarEnable($valor) { $this->enableCalendar = $valor; }
		public function getCalendarEnable() { return $this->enableCalendar ; }
		
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
			
			$nome = $this->nomeID;
			if ($this->enableCalendar) { $this->setFunctionOnClick("displayCalendar(document.forms[0].{$nome},'yyyy-mm-dd',this)"); }
			//$inside = $inside . "onClick=\" displayCalendar(document.forms[0].{$this->getID()},'yyyy-mm-dd',this)\"";
			parent::show($inside);
			
		}					
			
	}
}


?>

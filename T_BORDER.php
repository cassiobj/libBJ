<?php
include "defines.php";
//include "stdObject.php";
include "enum.php";

if (!defined('T_BORDER_H'))
{
	define('T_BORDER_H', '0');

	class T_BORDER
	{
		private $borda;
		private $isSet=false;
		

		public function __construct()
		{
			$this->borda = new Enum("type", "size", "color") ;
			$this->borda->type="solid";
			$this->borda->size="1";
			$this->borda->color="#000000";			
		}
	
		public function setType($valor) { $this->borda->type = $valor; $this->isSet=true; }	
		public function getType() { return $this->borda->type;  }	
		
		public function setSize($sizePixels) { $this->borda->size = $sizePixels; $this->isSet=true;}
		public function getSize($sizePixels) { return $this->borda->size;  }
		
		public function setColor($color) { $this->borda->color = $color; $this->isSet=true; }
		public function getColor($color) { return $this->borda->color ;}
				
		
		public function border() 
		{
			$retorno="";
			if ($this->isSet)
			{
				$retorno =  "border: " . $this->borda->size . "px " . $this->borda->type . " " . $this->borda->color . "; ";
			}
			return $retorno;
		}
		
		/*		
		font-family: Verdana;
		font-style: normal;
		font-variant: normal;
		font-weight: normal;
		font-size: 12px;
		line-height: 100%;
		font-size-adjust: none;
		font-stretch: normal;
		text-decoration: none;
		*/
	}	
}


?>
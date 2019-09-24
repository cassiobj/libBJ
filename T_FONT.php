<?php

include "defines.php";
include "enum.php";
//include "stdObject.php";

if (!defined('T_FONT_H'))
{
	define('T_FONT_H', '0');

	class T_FONT
	{
		private $fonte;
		private $isSet=false;

		public function __construct()
		{
			$this->fonte = new Enum("height", "size", "nome", "style") ;
			$this->fonte->nome="Verdana";
			$this->fonte->size="13";
			$this->fonte->height="100";
			$this->fonte->style="normal";
			
		}
		
		public function setName($valor) { $this->fonte->nome=$valor; $this->isSet=true;}	
		public function getName() { return $this->fonte->nome; $this->isSet=true;}	
		
		public function setSize($sizePixels) { $this->fonte->size = $sizePixels; $this->isSet=true;}
		public function getSize() { return $this->fonte->size; $this->isSet=true;}
		
		public function setHeight($sizePercent) { $this->fonte->height = $sizePercent; $this->isSet=true;}
		public function getHeight() { return $this->fonte->height; $this->isSet=true;}
		
		public function setStyle($nameStyle) { $this->fonte->style = $nameStyle; $this->isSet=true;}
		public function getStyle() { return $this->fonte->style; $this->isSet=true;}
		
		public function clear() {
			unset($this->fonte); 
			$this->isSet=false;
		}
		
		public function font() {
			//14px/100% Verdana;
			$retorno="";
			if ($this->isSet)
			{
				$retorno="";
				$retorno = $retorno . "font: " . $this->fonte->size . "px/" . $this->fonte->height . "% " . $this->fonte->nome . "; ";
				$retorno = $retorno .  "font-style: " . $this->fonte->style . "; ";
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
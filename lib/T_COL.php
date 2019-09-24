<?php

include "defines.php";
include "enum.php";
//include "stdObject.php";
include "T_FONT.php";
include "T_BORDER.php";

if (!defined('T_COL_H'))
{
	define('T_COL_H', '0');


	class T_COL
	{
		private $nameCol;
		private $classe;
		private $idCol;
		private $colSpan=0;
		private $height="-1";
		private $width="-1";
		private $color="-";
		private $textAlign="-";
		private $divAlign="-";
		private $verticalAlign="-";
		private $backgroundColor="-";
		private $cursor="";
		/*private $conteudo;
		private $tpConteudo;*/
		private $Border;
		private $Font;
		private $arrConteudo=array();
		private $isHeader ;
		private $onClickEvent="";
		private $title="";
		private $styleAdd = "";
		
		
		
		public function __construct()
		{
			$this->nameCol="";
			$this->classe="";
			$this->idCol="";
			$this->colSpan=0;
			
			
			$this->nameCol = "tdCol";
			$this->Font = new T_FONT(); 
			$this->Border = new T_BORDER();
			$this->isHeader=false;
		}
		
		public function setHeader($valBoolean) { $this->isHeader = $valBoolean; }
		public function getHeader() {return $this->isHeader;}
		
		public function setCursor($cursor) { $this->cursor = $cursor; }
		
		public function setName($nome) { $this->nameCol=$nome;}
		public function getName() { return $this->nameCol;}
		public function setClass($nome) { $this->classe=$nome;}
		public function getClass() { return $this->classe; }	
		public function setID($nome) { $this->idCol=$nome;}
		public function getID() { return $this->idCol; }
		
		public function setBackgroundColor($valor) { $this->backgroundColor=$valor;}
		public function getBackgroundColor() { return $this->backgroundColor; }
		
		public function setColor($valor) { $this->color=$valor;}
		public function getColor() { return $this->color; }
		
		public function setHeight($valor) { $this->height=$valor;}
		public function getHeight() { return $this->height; }
		
		public function setTitle($titulo) {$this->title=$titulo;}
		
		public function setWidth($valor) { $this->width=$valor;}
		public function getWidth() { return $this->width; }
		
		public function setColSpan($valor) { $this->colSpan=$valor; }
		public function getColSpan() { return $this->colSpan; }
		
		public function setTextAlign($valor) { $this->textAlign=$valor; }	
		public function getTextAlign() { return $this->textAlign; }
		
		public function setDivAlign($valor) { $this->divAlign=$valor; }	
		public function getDivAlign() { return $this->divAlign; }
		
		public function setStyle($valor) {$this->styleAdd = $valor; }
		
		
		
		public function setVerticalAlign($valor) { $this->verticalAlign=$valor; }	
		public function getVerticalAlign() { return $this->verticalAlign; }
		
		public function font() {return $this->Font; }
		public function border() { return $this->Border;}
		public function setBorder($borda) 
		{
			unset($this->Border);
			$this->Border = $borda;		
		}
		public function setFunctionOnClick($functionCall) { $this->onClickEvent = $functionCall;}
		
		public function copyBorder($borda)	{ $this->Border = unserialize(serialize($borda)) ;}
		
		public function set($valor) 
		{
			$tipo=gettype($valor);		
			array_push($this->arrConteudo, array($tipo, $valor));
			
			
			
			
			//$tpConteudo
			/*"boolean"
			"integer"
			"double" (for historical reasons "double" is returned in case of a float, and not simply "float")
			"string"
			"array"
			"object"
			"resource"
			"NULL"*/
			
			
		}
		
		public function clear()
		{
			unset($this->arrConteudo);
			$this->arrConteudo=array();
		}
		
		
		public function show()
		{
			if ($this->isHeader) { $this->showInternal("th"); }
			else { $this->showInternal("td"); }
		}
		
		public function showAsHeader()
		{
			$this->showInternal("th");
		}
		
		private function showInternal($tipo)
		{
			$estilo="";
			if (strlen($this->idCol)==0) { $this->idCol = $this->nameCol;}
			
			if ($this->height != "-1") { $estilo = $estilo . "height: " . $this->height . "; "; }
			if ($this->width != "-1") {$estilo = $estilo . "width: " . $this->width . "; "; }
			if ($this->backgroundColor != "-") {$estilo = $estilo . "background-color: " . $this->backgroundColor . "; "; }
			if ($this->color != "-") {$estilo = $estilo . "color: " . $this->color . "; "; }
			if ($this->textAlign != "-") { $estilo = $estilo . "text-align: " . $this->textAlign . "; ";}
			if ($this->verticalAlign != "-") { $estilo = $estilo . "vertical-align: " . $this->verticalAlign . "; ";			}
			if ($this->cursor != "") { $estilo = $estilo . "cursor: " . $this->cursor . "; ";			}
			$estilo = $estilo . $this->Font->font();
			$estilo = $estilo . $this->Border->border();
			
			if ($this->styleAdd != "")
			{
				$estilo = $estilo . ";" . $this->styleAdd; 
			}
	
			echo "<${tipo} ";
			if (strlen($this->classe) > 0)	{ echo "class = \"" . $this->classe . "\" "; }
			if (strlen($estilo) > 0)	{ echo "style = \"" . $estilo . "\" "; }
			if ($this->colSpan > 0 ) { echo "colspan=\"" . $this->colSpan . "\" "; }
			if (strlen($this->title)> 0) { echo "title=\"" . $this->title . "\" "; }
			echo " name = \"" . $this->nameCol . "\" ";
			echo " id = \"" . $this->idCol . "\" ";
			
			if ($this->onClickEvent != "")
			{
				echo " onclick=\"" . $this->onClickEvent . "\" ";
			}
			
			echo ">"; 
			
			// caso tenha div, exibir
			if ($this->divAlign!="-")
			{
				echo "<div style=\"text-align:{$this->divAlign}; width:100%;\" >";
			}
				
			
			foreach ($this->arrConteudo as $itemConteudo)
			{
				if ($itemConteudo[0]=="object") { $itemConteudo[1]->show(); }
				else { echo $itemConteudo[1]; }
			}
			
			if ($this->divAlign!="-")
			{
				echo "</div>";
			}
			
			echo "</${tipo}>";
		}
		
		 
			
	}

}
?>

<?php

include "defines.php";
include "enum.php";
//include "stdObject.php";
include "T_TABLE.php";
include "T_FONT.php";
include "T_BORDER.php";

if (!defined('T_ROW_H'))
{
	define('T_ROW_H', '0');

	
	class T_ROW
	{
		private $nameRow;
		private $classe;
		private $idRow;
		private $colSpan;
		private $height=-1;
		private $width=-1;
		private $color="-";
		private $backgroundColor="-";
		private $text_align="";
		public $cols=array();
		private $Font ;
		private $Border;
		private $ownerTable;
		
		
		public function __construct()
		{
			$this->nameRow="";
			$this->classe="";
			$this->idRow="";
			$this->colspan=0;
			$this->text_align="";
			
			$this->Font = new T_FONT();
			$this->Border = new T_BORDER();
			$this->nameRow = "trRow";
			
		}
		
		
		
		public function setName($nome) { $this->nameRow=$nome;}
		public function getName() { return $this->nameRow;}
		public function setClass($nome) { $this->classe=$nome;}
		public function getClass() { return $this->classe; }	
		public function setID($nome) { $this->idRow=$nome;}
		public function getID() { return $this->idRow; }
		
		public function setBackgroundColor($valor) { $this->backgroundColor=$valor;}
		public function getBackgroundColor() { return $this->backgroundColor; }
		
		public function setColor($valor) { $this->color=$valor;}
		public function getColor() { return $this->color; }
		
		public function setHeight($valor) { $this->height=$valor;}
		public function getHeight() { return $this->height; }
		
		public function setWidth($valor) { $this->width=$valor;}
		public function getWidth() { return $this->width; }
		public function setOwnerTable($table) { $this->ownerTable = $table ; }
		
		public function setTextAlign($align) { return $this->text_align = $align;}
		
		public function font() { return $this->Font; }
		public function border() { return $this->Border;}
		
		public function setBorder($borda)
		{
			unset($this->Border);
			$this->Border = $borda;
		}
		
		public function copyBorder($borda)	{	$this->Border = unserialize(serialize($borda)) ;}
		
		public function createCol($pos)
		{
			if (count($this->cols)-1 < $pos)
			{
				for ($i=count($this->cols); $i <= $pos; $i++)
				{			
					array_push($this->cols, new T_COL());
					$this->cols[$i]->setName("td{$pos}");					
				}
				return;
			}
		}
		
		
		public function setCol($pos, $conteudo)
		{
			$this->createCol($pos);
			$this->cols[$pos]->set($conteudo);			
		}
		
		public function setColHeader($pos, $conteudo)
		{
			$this->createCol($pos);
			$this->cols[$pos]->setHeader(true);
			$this->cols[$pos]->set($conteudo);
		}
		
		
		public function startShow()
		{
			$estilo="";
			if (strlen($this->idRow)==0) {
				$this->idRow = $this->nameRow;
			}
				
			if ($this->height >= 0) {
				$estilo = $estilo . "height: " . $this->height . "; ";
			}
			if ($this->width >= 0) {
				$estilo = $estilo . "width: " . $this->height . "; ";
			}
			
			if (strlen($this->text_align) > 0 )
			{
				$estilo = $estilo . "text-align: " . $this->text_align . "; ";
			}
			
			if ($this->backgroundColor != "-") {
				$estilo = $estilo . "background-color: " . $this->backgroundColor . "; ";
			}
			if ($this->color != "-") {
				$estilo = $estilo . "color: " . $this->color . "; ";
			}
			$estilo = $estilo . $this->Border->border();
		
		
			echo "<tr ";
			if (strlen($this->classe) > 0)	{
				echo " class = \"" . $this->classe . "\" ";
			}
			if (strlen($estilo) > 0)	{
				echo " style = \"" . $estilo . "\" ";
			}
			echo " name = \"" . $this->nameRow . "\" ";
			echo " id = \"" . $this->idRow . "\" ";
			echo ">" ;
		}
		
		public function endShow()
		{
			echo "</tr>";
		}
	}

}

?>

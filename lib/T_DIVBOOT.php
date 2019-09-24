<?php

include "defines.php";
include "enum.php";
//include "stdObject.php";
include "T_FONT.php";
include "T_BORDER.php";

if (!defined('T_DIVBOOT_H'))
{
	define('T_DIVBOOT_H', '0');
	
	
	
	

	class T_COLDIVBOOT
	{
		private $name = ""	;
		private $ownerTable ="";
		private $tam = "";
		
		private $height="-1";
		private $width="-1";
		private $color="-";
		private $textAlign="-";
		private $divAlign="-";
		private $verticalAlign="-";
		private $backgroundColor="-";
		private $cursor="";
		private $idCol="";
		private $title="";
		private $onClickEvent ="";
		private $arrConteudo = array();
		private $Border;
		private $Font;
		
		public function setName($nome)	{	$this->name = $nome; }
		public function setOwnerTable($table) { $this->ownerTable = $table; }
		public function setTam($tam)	{	$this->tam = $tam; }

		public function __construct()
		{
			$this->name="";
			$this->classe="";
			$this->idCol="";
			
				
				
			$this->name = "tdCol";
			$this->Font = new T_FONT();
			$this->Border = new T_BORDER();	
			
		}
		
		public function setCursor($cursor) { $this->cursor = $cursor; }
		
		
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
		
		public function setTextAlign($valor) { $this->textAlign=$valor; }
		public function getTextAlign() { return $this->textAlign; }
		
		
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
			
			
			$estilo = "";
			if ($this->height != "-1") { $estilo = $estilo . "height: " . $this->height . "; "; }
			if ($this->width != "-1") {$estilo = $estilo . "width: " . $this->width . "; "; }
			if ($this->backgroundColor != "-") {$estilo = $estilo . "background-color: " . $this->backgroundColor . "; "; }
			if ($this->color != "-") {$estilo = $estilo . "color: " . $this->color . "; "; }
			if ($this->textAlign != "-") { $estilo = $estilo . "text-align: " . $this->textAlign . "; ";}
			if ($this->verticalAlign != "-") { $estilo = $estilo . "vertical-align: " . $this->verticalAlign . "; ";			}
			if ($this->cursor != "") { $estilo = $estilo . "cursor: " . $this->cursor . "; ";			}
			$estilo = $estilo . $this->Font->font();
			$estilo = $estilo . $this->Border->border();
			
			$nomeClasse = "col-sm-{$this->tam}";
			if (strlen($this->classe) > 0)
			{
				$nomeClasse .= " {$this->classe}";
			}
			
			echo "<div class=\"{$nomeClasse}\" ";
			
			if (strlen($estilo) > 0)	{ echo "style = \"" . $estilo . "\" "; }
			
			if (strlen($this->title)> 0) { echo "title=\"" . $this->title . "\" "; }
			echo " name = \"" . $this->name . "\" ";
			echo " id = \"" . $this->idCol . "\" ";
				
			if ($this->onClickEvent != "")
			{
				echo " onclick=\"" . $this->onClickEvent . "\" ";
			}
			
			echo ">";
			
			foreach ($this->arrConteudo as $itemConteudo)
			{
				if ($itemConteudo[0]=="object") { $itemConteudo[1]->show(); }
				else { echo $itemConteudo[1]; }
			}
			
			
			echo "</div>";
		}
		
	};
	
	
	
	class T_ROWDIVBOOT
	{
		private $name="";		
		private $classe="";
		public $cols=array();
		private $ownerTable ="";
		private $textAlign="";
		private $width="";
		private $height="";
		private $verticalAlign="-";
		
		public function setName($nome)	{	$this->name = $nome; }
		public function getName() { return $this->name;}
		public function setClass($nome) { $this->classe=$nome;}
		public function getClass() { return $this->classe; }
		public function setOwnerTable($table) { $this->ownerTable = $table; }
		public function setTextAlign($valor) { $this->textAlign = $valor; }
		public function setWidth($valor) { $this->width = $valor; }
		public function setHeight($valor) { $this->height = $valor; }
		
		
		public function setVerticalAlign($valor) { $this->verticalAlign=$valor; }
		public function getVerticalAlign() { return $this->verticalAlign; }
		
			
		public function setCol($pos, $tam, $conteudo)
		{
			$this->createCol($pos, $tam);
			$this->cols[$pos]->set($conteudo);
		}
		
		public function getCol($col)
		{			
			return $this->cols[$col];
		}
	
		public function createCol($pos, $tam)
		{
			if (count($this->cols)-1 < $pos)
			{
				for ($i=count($this->cols); $i <= $pos; $i++)
				{
					array_push($this->cols, new T_COLDIVBOOT());
					$this->cols[$i]->setName("td{$pos}");
					$this->cols[$i]->setTam($tam);
				}
				return;
			}
		}
	
		public function show()
		{
			$style = "";
			$sep="";
			if ($this->textAlign != "")
			{
				$style .= $sep . "text-align: " . $this->textAlign ;
				$sep = ";";
			}	
			if ($this->width!="")
			{
				$style .= $sep . " width: " . $this->width ;
				$sep = ";";
			}
			if ($this->height!="")
			{
				$style .= $sep . " height: " . $this->height ;
				$sep = ";";
			}
			if ($this->verticalAlign != "-") 
			{ 
				$style .= $sep .  "vertical-align: " . $this->verticalAlign;				
				$sep = "; ";
			}
			

				
		
			echo "<div class=\"row\" ";
			if ($this->name!="") echo "id=\"$this->name\" name=\"$this->name\" ";
			if ($style != "") echo "style=\"$style\" ";
			echo ">";
					
			if (count($this->cols) > 0)
			{
				for ($i=0; $i < count($this->cols); $i++)
				{
					$this->cols[$i]->show();
				}
			}
			
			echo "</div>";
		}
	
	
	}
	
	
	class T_DIVBOOT
	{
		private $nameTable="";
		private $classe="";
		private $onBeforeShow = "";
		private $onAfterShow = "";
		private $header = "";
		
		private $widthH = "";
		private $heightH = "";
		private $classeH="";
		
		
		public $rows=array();
		
		public function setName($nome)	{	$this->nameTable = $nome; }
		public function getName()	{	return $this->nameTable;}
		
		public function setHeader($header)	{	$this->header = $header; }
		
		public function setClass($classe)	{ $this->classe = $classe; }
		public function getClass()	{ $this->classe; }
		public function setClassHeader($classeH)	{ $this->classeH = $classeH; }
		public function getClassHeader()	{ $this->classeH; }
		
		public function setBeforeShow($script)
		{
			$this->onBeforeShow=$script;
		}
		public function getBeforeShow()
		{
			return $this->onBeforeShow;
		}
		
		public function setAfterShow($script)
		{
			$this->onAfterShow=$script;
		}
		
		public function getAfterShow()
		{
			return $this->onAfterShow;
		}
		
		public function createRow($lin, $col, $tam)
		{		
			if (count($this->rows)-1 < $lin)
			{
				for ($i=count($this->rows); $i <= $lin; $i++)
				{
				 array_push($this->rows, new T_ROWDIVBOOT());
				 $this->rows[$i]->setName("row_{$i}");
				 $this->rows[$i]->setOwnerTable($this);
				}			
				$this->rows[$i-1]->createCol($col, $tam);
				
				return;
			}		
		}
		
		public function set($lin, $col, $tam, $conteudo)
		{		
			$this->createRow($lin, $col, $tam);
			$this->rows[$lin]->setCol($col, $tam, $conteudo);
		}
		
		public function cell($lin, $col)
		{
			return 	$this->rows[$lin]->getCol($col);
		}
		
		public function clear($lin)
		{
			if ($lin < count($this->rows))
			{				
					$this->rows[$lin]->clear();
			}
		}
		
		
		
		
		
		public function row($col)
		{			
			return $this->rows[$col];
		}
		
		
		public function show()
		{
			$this->display();
		}
		
		public function display()
		{
			if ($this->header!="")
			{
				$nomeClasse = "jumbotron vertical-center container-fluid";
				if ($this->classeH!="") $nomeClasse .= " {$this->classeH}";
				
				
				echo "<div class=\"{$nomeClasse}\" \">";
				
				
				
				echo "{$this->header}</div>";
				 
				
			}
			
			
			if (strlen($this->onBeforeShow) > 0)
			{
				echo "<script>";
				echo $this->onBeforeShow;
				echo "</script>";
			}
			
			$nomeFMT = "";
			if ($this->nameTable!="") $nomeFMT =  "name='{$this->nameTable}' id='{$this->nameTable}'";
			
			$nomeClasse = "container-fluid";
			if ($this->classe!="")  $nomeClasse .= " {$this->classe}";  
				
			
			echo "<div class=\"{$nomeClasse}\" {$nomeFMT} >";
			
			
			
			if (count($this->rows) > 0)
			{
			
				
				/*echo "<div ";
				$nomeClasse = "row";
				if ($this->classe!="") $nomeClasse .= " {$this->classe}";  
					
					echo "class='{$nomeClasse}'";
				echo ">";*/
				
				
				
				for ($i=0; $i < count($this->rows); $i++)
				{
					$this->rows[$i]->show();
				}
				
				//echo "</div>";
				#if ($this->header!="") echo "</div>";
			}
			
			echo "</div>";
			
			if (strlen($this->onAfterShow) > 0)
			{
				echo "<script>";
				echo $this->onAfterShow;
				echo "</script>";
			}
				
		}
		
	}
};


?>
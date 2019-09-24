<?php


include "defines.php";
include "enum.php";
//include "stdObject.php";
include "T_FONT.php";
include "T_BORDER.php";

if (!defined('T_TABLE_H'))
{
	define('T_TABLE_H', '0');
	
class T_TABLE
{
	private $nameTable;
	private $classe;
	private $classeHeader;
	private $classeNormal;
	private $classeAlternate;
	private $idTable;
	private $colSpan;
	private $height=-1;
	private $width=-1;
	private $color="-";
	private $border="1";
	private $cellPadding="1";	
	private $cellSpacing="1";	
	private $backgroundColor="-";
	private $onBeforeShow="";
	private $onAfterShow="";
	private $isBootstrap = false;
	private $isStriped = false;
	private $isHover = false;
	public $font;
	
	
	public $rows=array();
	
	
	
	public function __construct($isBootstrap = false)
	{
		$this->nameTable="";
		$this->classe="";
		$this->classeNormal="";
		$this->classeAlternate="";
		$this->classeHeader="";
		$this->idTable="";
		$this->colSpan=0;
		$this->width="100%";
		$this->nameTable = "tbTab";
		$this->font = new T_FONT() ;
		$this->isBootstrap = $isBootstrap;
		
	}
	
	public function setBootstrap($isBootStrap) { $this->isBootstrap = $isBootStrap; }
	public function setStrip($isStriped) { $this->isStriped = $isStriped; }
	public function setHover($isHover) { $this->isHover = $isHover; }
	
	public function setName($nome) { $this->nameTable=$nome;}
	public function getName() { return $this->nameTable;}
	public function setClass($nome) { $this->classe=$nome;}
	public function setClassRowNormal($nome) { $this->classeNormal=$nome;}
	public function setClassRowAlternate($nome) { $this->classeAlternate=$nome; }
	public function setClassHeader($nome) { $this->classeHeader=$nome;}
	
	public function getClass() { return $this->classe; }	
	public function getClassHeader() { return $this->classeHeader; }
	public function getClassRowNormal() { return $this->classeNormal; }
	public function getClassRowAlternate() { return $this->classeAlternate;}
	
	public function setID($nome) { $this->idTable=$nome;}
	public function getID() { return $this->idTable; }
	
		
	public function setBackgroundColor($valor) { $this->backgroundColor=$valor;}
	public function getBackgroundColor() { return $this->backgroundColor; }
	
	public function setColor($valor) { $this->color=$valor;}
	public function getColor() { return $this->color; }
	
	public function setHeight($valor) { $this->height=$valor;}
	public function getHeight() { return $this->height; }
	
	public function setWidth($valor) { $this->width=$valor;}
	public function getWidth() { return $this->width; }
	
	public function setBorder($valor) { $this->border=$valor;}
	public function getBorder() { return $this->border; }
	
	public function setCellPadding($valor) { $this->cellPadding=$valor;}
	public function getCellPadding() { return $this->cellPadding; }
	
	public function setCellSpacing($valor) { $this->cellSpacing=$valor;}
	public function getCellSpacing() { return $this->cellSpacing; }
	
	
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
	
	
	
	public function createRow($lin, $col)
	{		
		if (count($this->rows)-1 < $lin)
		{
			for ($i=count($this->rows); $i <= $lin; $i++)
			{
			 array_push($this->rows, new T_ROW());
			 $this->rows[$i]->setName("tr{$i}");
			 $this->rows[$i]->setOwnerTable($this);			 
			}			
			$this->rows[$i-1]->createCol($col);
			
			return;
		}		
	}
	
	public function set($lin, $col, $conteudo)
	{		
		$this->createRow($lin, $col);
		$this->rows[$lin]->setCol($col, $conteudo);
	}
	
	public function setHeader($lin, $col, $conteudo)
	{
		$this->createRow($lin, $col);	
		$this->rows[$lin]->setColHeader($col, $conteudo);	
	}
	
	
	
	
	public function clear($lin, $col)
	{
		if ($lin < count($this->rows))
		{		
			if ($col < count($this->rows[$lin]->cols))
			$this->rows[$lin]->cols[$col]->clear();
		}	
	}
	
	public function setColTextAlign($lin, $col, $align)
	{
		$this->createRow($lin, $col);
		$this->rows[$lin]->cols[$col]->setTextAlign($align);
	}
	
	public function cell($lin, $col)
	{
		$this->createRow($lin, $col);
		return $this->rows[$lin]->cols[$col];
	}
	
	//public function setFont()
	
	
	public function display()
	{
		$maxCol = 0;
		// determinando tamanho máximo de colunas
		
		
		for ($i=0; $i < count($this->rows); $i++)
		{			
			if (count($this->rows[$i]->cols) > $maxCol)
			{
				$maxCol=count($this->rows[$i]->cols);
			}
		}
		
		// ajeitando colspan das colunas
		for ($i=0; $i < count($this->rows); $i++)
		{
			// contando o total de colspan
			$totColSpan=0;
			foreach ($this->rows[$i]->cols as $coluna)
			{
				$totColSpan = $totColSpan + $coluna->getColSpan();
			}
						
			if ((count($this->rows[$i]->cols) < $maxCol) && (count($this->rows[$i]->cols) > 0))
			{
				
				$teste = $maxCol - count($this->rows[$i]->cols);				
				$this->rows[$i]->cols[count($this->rows[$i]->cols)-1]->setColSpan(($maxCol - count($this->rows[$i]->cols))+ 0 - ($totColSpan-1) );
				
			}				
		}
		
		if (strlen($this->onBeforeShow) > 0)
		{
			echo "<script>";
			echo $this->onBeforeShow;
			echo "</script>";
		}
		
		$this->open();
		
		/*for ($i=0; $i < count($this->rows); $i++)
		{
			for ($j=0; $j < count($this->rows[$i]->cols); $j++)
			{		
				echo "i: {$i}   j: {$j}<br>";
			}
		}*/
		
		$this->configClasses();
		
		for ($i=0; $i < count($this->rows); $i++)
		{
			
			
			$this->rows[$i]->startShow(); 
		
				
			for ($j=0; $j < count($this->rows[$i]->cols); $j++)
			{
				// verificando classe
				//$i==0 ? $this->rows[$i]->cols[$j]->showAsHeader() :  $this->rows[$i]->cols[$j]->show();
				$this->rows[$i]->cols[$j]->show();
			}	
			$this->rows[$i]->endShow();
		}
		$this->close();
		
		if (strlen($this->onAfterShow) > 0)
		{
			echo "<script>";
			echo $this->onAfterShow;
			echo "</script>";
		}
	}
	
	
	public function configClasses()
	{
	
		$ini=0;
		$normal="";
		$alternada="";
		if ((strlen($this->classeHeader) > 0)) // caso haja classe de header informada
		{
			$this->rows[0]->setClass($this->classeHeader);
			$ini=1;
		}
		
		if ((strlen($this->classeNormal) > 0) && (strlen($this->classeAlternate) > 0))
		{
			$normal=$this->classeNormal;
			$alternada=$this->classeAlternate;
		}
		else if ((strlen($this->classeNormal) > 0) && (strlen($this->classeAlternate) == 0))
		{
			$normal=$this->classeNormal;
			$alternada=$this->classeNormal;
		}
		else if ((strlen($this->classeAlternate) > 0) && (strlen($this->classeNormal) == 0))
		{
			$normal=$this->classeAlternate;
			$alternada=$this->classeAlternate;
		}
		else if ((strlen($this->classeAlternate) == 0) && (strlen($this->classeNormal) == 0) && (strlen($this->classe) > 0))
		{
			$normal=$this->classe;
			$alternada=$this->classe;
		}
		else
		{
			return;
		}
	
		for ($i=$ini; $i < count($this->rows); $i++)
		{
			if (($i %2)==0)
			{
				$this->rows[$i]->setClass($normal);
			}
			else
			{	
				$this->rows[$i]->setClass($alternada);
			}
		}
				
	}
	
	
	public function show() { $this->display(); }
	
	public function open()
	{
		$estilo="";
		if (strlen($this->idTable)==0) { $this->idTable = $this->nameTable;}
		
		$estilo = $estilo . $this->font->font();
		if (strlen($this->height) > 0) { $estilo = $estilo . ";height: " . $this->height . "; "; }
		if (strlen($this->width) > 0) {$estilo = $estilo . ";width: " . $this->width . "; "; }
		if ($this->backgroundColor != "-") {$estilo = $estilo . "background-color: " . $this->backgroundColor . "; "; }
		if ($this->color != "-") {$estilo = $estilo . "color: " . $this->color . "; "; }
		
		$nomeClasse="";
		if ($this->isBootstrap)
		{
			$nomeClasse = "table table-responsive";
			if ($this->isStriped)
				$nomeClasse .= " table-striped";		
			
			if ($this->isHover)
				$nomeClasse .= " table-hover";
		}
		

		echo "<table border=\"". $this->border . "\" cellpadding=\"". $this->cellPadding . "\" cellspacing=\"". $this->cellSpacing . "\" ";
		
		if (strlen($this->classe) > 0)			
			$nomeClasse .= " {$this->classe}";
		
		if ($nomeClasse !="") { echo "class = \"" . $nomeClasse . "\" "; }
		
		if (strlen($estilo) > 0)	{ echo "style = \"" . $estilo . "\" "; }
		echo " name = \"" . $this->nameTable . "\" ";
		echo " id = \"" . $this->idTable . "\" ";
		echo ">" ;
	}
	
	
	public function close()
	{
		echo "</table>";
	}
}

}

?>
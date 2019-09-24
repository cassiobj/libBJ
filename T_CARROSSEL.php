<?php

include "defines.php";
include "enum.php";
//include "stdObject.php";
include "T_FONT.php";
include "T_BORDER.php";

if (!defined('T_CARROSSEL_H'))
{
	define('T_CARROSSEL_H', '0');
	
	class T_ITEMCARROSSEL
	{
		private $name="";
		private $classe="";
		private $imagem="";
		private $classeImagem="";
		private $classeCaption="";
		private $classeTexto="";
		private $textoCaption="";
		private $texto="";
		
		
		public function setName($nome) { $this->name=$nome; }
		public function setClass($classe) { $this->classe=$classe; }
		public function setTextCaption($text) { $this->textoCaption=$text; }
		public function setText($text) { $this->texto=$text; }
		public function setImagem($imagem) { $this->imagem=$imagem; }
		
		
		public function setClassImage($classe) { $this->classeImage=$classe; }
		
		public function getName($nome) { return $this->name; }
		public function getClass($classe) { $this->classe; }
		public function getTextCaption($text) { $this->textoCaption; }
		public function getText($text) { $this->texto; }
		
		public function show($active="")
		{
			
		
			$nomeClasse="item";
			if ($active!="") $nomeClasse .= " {$active}";
			echo "	<div class=\"$nomeClasse\" >";
			
			if ($this->imagem!="")
			{
				$nomeClasse = "";
				if ($this->classeImagem!="") $nomeClasse = "class=\"{$this->classeImagem}\" ";
					
				echo "	<img src=\"$this->imagem\" $nomeClasse style=\"width:100%;\" >";
			}
			
			if ($this->textoCaption!="")
			{
				$nomeClasse = "carousel-caption";
				if ($this->classeCaption!="") $nomeClasse .= " {$this->classeCaption}";
				
				echo "		<div class=\"{$nomeClasse}\" >";
				echo "			{$this->textoCaption}";
				echo "		</div>";
			}
			
			if ($this->texto!="")
			{
				
				if ($this->classeTexto!="") 
				{	
					echo "<span class=\"$this->classeTexto\">";
					echo $this->texto;
					echo "</span>";
				}
				else 
					echo $this->texto;
			
			}
			
			
			
			echo "</div>";
		}
		
	}

	class T_CARROSSEL
	{
		private $name="";
		private $classe="";
		private $arrItens=array();		
		private $seconds=0;
		
		public function setName($nome) { $this->name=$nome; }
		public function setClass($classe) { $this->classe=$classe; }
		public function setTime($value) { $this->seconds = $value; }
		
		public function add($imagem="", $textoCaption="", $texto="" )
		{
			$aux = new T_ITEMCARROSSEL();
			array_push($this->arrItens, $aux);
			$i = count($this->arrItens)-1;	
			
			if ($imagem!="") $this->arrItens[$i]->setImagem($imagem);
			if ($textoCaption!="") $this->arrItens[$i]->setTextCaption($textoCaption);
			if ($texto!="") $this->arrItens[$i]->setText($texto);
			
			return $i;
		}
		
		public function getItem($indice)
		{
			return  $this->arrItens[$indice];
		}
		
		public function display()
		{
			$this->show();
		}
		
		public function show()
		{
			$intervalo = "";
			if ($this->seconds != "0")
			{
				$valorSecond = $this->seconds * 1000;
				$intervalo = " data-interval=\"{$valorSecond}\" ";
			}
			
			//echo "<div class=\"container\">";
			$nomeClasse = "carousel slide";
			if ($this->classe!="") $nomeClasse .= " {$this->classe}";
			
			if ($this->name=="") $this->name = "myCarousel";
			$nomeFMT="";
			if ($this->name!="") $nomeFMT = " name=\"{$this->name}\" id=\"{$this->name}\" ";
			
			echo "<div class=\"{$nomeClasse}\" data-ride=\"carousel\" {$nomeFMT} $intervalo >";
			
			$ativo="class=\"active\"";
			echo "<ol class=\"carousel-indicators\">";			
			for ($i=0; $i < count($this->arrItens) ; $i++)
			{
				echo "<li data-target=\"#{$nomeFMT}\" data-slide-to=\"{$i}\" {$ativo}></li>";
				$ativo = "";
			}
			echo "</ol>";
			
			$ativo="active";
			$nomeClasse="carousel-inner";
			if ($this->classe!="") $nomeClasse .= " {$this->classe}";
			
			
					
			echo "<div class=\"{$nomeClasse}\" role=\"listbox\" >";
			
			for ($i=0; $i < count($this->arrItens) ; $i++)
			{
				$this->arrItens[$i]->show($ativo);
				$ativo="";
			}
			
			echo "</div>";
			
			
			
			// imprimindo os botões
			
			echo "<a class=\"left carousel-control\" href=\"#{$this->name}\" data-slide=\"prev\"> ";
			echo "<span class=\"glyphicon glyphicon-chevron-left\"></span>";
			echo "<span class=\"sr-only\">Previous</span> ";
			echo "</a>";
			echo "<a class=\"right carousel-control\" href=\"#{$this->name}\" data-slide=\"next\"> ";
			echo "<span class=\"glyphicon glyphicon-chevron-right\"></span> ";
			echo "<span class=\"sr-only\">Next</span>";
			echo "</a>";
			
			
			
			
			echo "</div>";
			
			
			
			
			
			if ($this->seconds != 0)
			{
				
			}
			
			//echo "</div>";
		}
		
	}

};

?>
<?php

include "defines.php";
include "enum.php";
//include "stdObject.php";
include "T_FONT.php";
include "T_BORDER.php";


if (!defined('T_INPUT_H'))
{
	define('T_INPUT_H', '0');
	
	
	class T_INPUT
	{
		private $nameInput;
		private $classe;
		private $idInput;	
		private $height=-1;
		private $width=-1;
		private $color="-";
		private $textAlign="left";
		private $backgroundColor="-";
		private $value;
		private $type;
		private $size=0;
		private $maxlength=0;
		private $disabled="";
		private $readonly="";
		private $mask="";
		
		private $showed;
		private $Font;
		private $Border;
		private $onClick="";
		private $onChange="";
		
		
		public function __construct($nome="tInput", $tipo="TEXT")
		{
			$this->nameInput="";
			$this->classe="";
			$this->idInput="";
			$this->value="";
			
			
			
			$this->nameInput = $nome;
			$this->type=$tipo;
			$this->Font = new T_FONT();
			$this->Border = new T_BORDER();
			$this->showed=false;
		}
		
		public function setName($nome) { $this->nameInput=$nome; $this->showed=false;}
		public function getName() { return $this->nameInput;}
		public function setClass($nome) { $this->classe=$nome;}
		public function getClass() { return $this->classe; }	
		public function setID($nome) { $this->idInput=$nome; $this->showed=false;}
		public function getID() { return $this->idInput; }
		
		public function setBackgroundColor($valor) { $this->backgroundColor=$valor;}
		public function setMask($mask) { $this->mask=$mask;}
		public function getBackgroundColor() { return $this->backgroundColor; }
		
		public function setColor($valor) { $this->color=$valor;}
		public function getColor() { return $this->color; }
		
		public function setHeight($valor) { $this->height=$valor;}
		public function getHeight() { return $this->height; }
		
		public function setWidth($valor) { $this->width=$valor;}
		public function getWidth() { return $this->width; }
		
		
		public function setType($tipo) { $this->type = $tipo; }
		public function getType() { return $this->type; }
		
		public function setTextAlign($valor) { $this->textAlign=$valor; }	
		public function getTextAlign() { return $this->textAlign; }
		
		public function setMaxLength($valor) { $this->maxlength=$valor;}
		public function getMaxLength() { return $this->maxlength; }

		public function setSize($sizePixels) { $this->size = $sizePixels;}
		public function getSize() { return $this->size; }
		
		public function font() {return $this->Font; }
		public function border() { return $this->Border;}
		public function setBorder($borda) 
		{
			unset($this->Border);
			$this->Border = $borda;		
		}
		public function setDisabled($isDisable)
		{
			if ($isDisable)
			{
				$this->disabled="disabled";
			}
			else
			{
				$this->disabled="";
			}
		}
		
		public function getDisabled()
		{
			if ($this->disabled=="disabled")
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		public function setReadonly($valor)
		{
			if ($valor)
				$this->readonly = "readonly";
				else
					$this->readonly = "";
		}
		
		
		public function copyBorder($borda)	{ $this->Border = unserialize(serialize($borda)) ;}
		
		public function setValue($valor) 
		{
			if ($this->showed)
			{
				echo '<script> $("#' . $this->nameInput . '").val("' . $valor . '") </script>';
			}
			else
			{
				$this->value = $valor;
			}		
		}
		
		public function getValue() { return $this->value ; }
		
		
		public function show($inside ="")
		{
			$estilo="";
			if (strlen($this->idInput)==0) { $this->idInput = $this->nameInput;}
			
			if ($this->height >= 0) { $estilo = $estilo . "height: " . $this->height . "; "; }
			if ($this->width >= 0) {$estilo = $estilo . "width: " . $this->width . "; "; }
			if ($this->backgroundColor != "-") {$estilo = $estilo . "background-color: " . $this->backgroundColor . "; "; }
			if ($this->color != "-") {$estilo = $estilo . "color: " . $this->color . "; "; }
			if ($this->textAlign != "-") { $estilo = $estilo . "text-align: " . $this->textAlign . "; ";}
			 
			$estilo = $estilo . $this->border()->border();
			
		
					
			echo "<input " . $inside;
			echo " type=\"{$this->type}\" ";			
			if (strlen($this->classe) > 0)	{ echo " class = \"" . $this->classe . "\" "; }
			if (strlen($estilo) > 0)	{ echo "style = \"" . $estilo . "\" "; }			
						
			echo " name = \"" . $this->nameInput . "\" ";
			if ($this->size > 0) { echo " size = \"" . $this->size . "\" "; }
			if ($this->maxlength > 0) { echo " maxlength = \"" . $this->maxlength . "\" "; }
			echo " id = \"" . $this->idInput . "\" value = \"" . $this->value . "\" ";
			if ($this->onClick!="")
			{
				echo " onclick=\"" . $this->onClick . "\" ";
			}			
			
			if ($this->onChange!="")
			{
				echo " onChange=\"" . $this->onChange . "\" ";
			}
			
			echo " {$this->disabled} {$this->readonly}>"; 
		
			if ($this->mask!="")
			{
				echo <<<EOT
				<script>
				$('#{$this->nameInput}').mask("{$this->mask}");
				</script>
EOT;
			}
			
			
			$this->showed=true;
		}
		
		 
		public function setFunctionOnClick($funcao) 
		{ 
			if ($this->onClick == "")
				$this->onClick = $funcao;
			else 
				$this->onClick = $this->onClick . ";" . $funcao; 
		}
		
		public function setFunctionOnChange($funcao)
		{
			if ($this->onChange == "")
				$this->onChange = $funcao;
				else
					$this->onChange = $this->onChange . ";" . $funcao;
		}
			
	}
}

?>


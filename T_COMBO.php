<?php

include "defines.php";
include "enum.php";
//include "stdObject.php";
include "T_FONT.php";
include "T_BORDER.php";


if (!defined('T_COMBO_H'))
{
	define('T_COMBO_H', '0');
	
	
	class T_COMBO
	{
		private $nameCombo;
		private $classe;
		private $idCombo;	
		private $height=-1;
		private $width=-1;
		private $color="-";
		private $textAlign="left";
		private $backgroundColor="-";
		private $value="";
		private $disabled="";
		private $onChange="";
		private $isMultiple="";
		private $readonly="";
		

		private $showed;
		private $Font;
		private $Border;
		private $elements;
		
		public function __construct($nomeCombo="")
		{
			$this->nameCombo=$nomeCombo;
			$this->classe="";
			$this->idCombo="";
			$this->value="";		
			
			$this->nameCol = "cbCombo";
			$this->Font = new T_FONT();
			$this->Border = new T_BORDER();
			$this->showed=false;
		}
		
		public function setName($nome) { $this->nameCombo=$nome; $this->showed=false;}
		public function getName() { return $this->nameCombo;}
		public function setClass($nome) { $this->classe=$nome;}
		public function getClass() { return $this->classe; }	
		public function setID($nome) { $this->idCombo=$nome; $this->showed=false;}
		public function getID() { return $this->idCombo; }
		
		public function setBackgroundColor($valor) { $this->backgroundColor=$valor;}
		public function getBackgroundColor() { return $this->backgroundColor; }
		
		public function setColor($valor) { $this->color=$valor;}
		public function getColor() { return $this->color; }
		
		
		public function setHeight($valor) { $this->height=$valor;}
		public function getHeight() { return $this->height; }
		
		public function setWidth($valor) { $this->width=$valor;}
		public function getWidth() { return $this->width; }
		
		
		public function setOnChange($script) { $this->onChange=$script; }
		public function getOnChange() { return $this->onChange; }
		
		public function setTextAlign($valor) { $this->textAlign=$valor; }	
		public function getTextAlign() { return $this->textAlign; }
		
		
		
		public function setMultiple($valor=false) 
		{
			if ($valor)
			{
				$this->isMultiple = "multiple";
			}
			else
			{
				$this->isMultiple = "";
			}
		}
		
		public function font() {return $this->Font; }
		public function border() { return $this->Border;}
		public function setBorder($borda) 
		{
			unset($this->Border);
			$this->Border = $borda;		
		}
		
		public function copyBorder($borda)	{ $this->Border = unserialize(serialize($borda)) ;}
		
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
		
		public function setValue($valor) 
		{
			if ($this->showed)
			{
				echo '<script> $("#' . $this->nameCombo . '").val("' . $valor . '") </script>';
			}
			else
			{
				$this->value = $valor;
			}		
		}
		
		public function setElements($array)
		{
			$this->elements = $array;
		}
		
		public function getElements()
		{
			return $this->elements;
		}
		
		public function addElement($key, $value)
		{
			if (!$this->showed)
			{
				$this->elements[$key] = $value;
			}
			else
			{
				?>
				<script>
					$("#<?php echo $this->idCombo?>").append(new Option("<?php echo $value?>", "<?php echo $key?>"));
				</script>				
				<?php 
			}
		}
		
		
		public function show()
		{
			$estilo="";
			if (strlen($this->idCombo)==0) { $this->idCombo = $this->nameCombo;}
			
			if ($this->height >= 0) { $estilo = $estilo . "height: " . $this->height . "; "; }
			if ($this->width >= 0) {$estilo = $estilo . "width: " . $this->width . "; "; }
			if ($this->backgroundColor != "-") {$estilo = $estilo . "background-color: " . $this->backgroundColor . "; "; }
			if ($this->color != "-") {$estilo = $estilo . "color: " . $this->color . "; "; }
			if ($this->textAlign != "-") { $estilo = $estilo . "text-align: " . $this->textAlign . "; ";}
			$estilo = $estilo . $this->Border->border();
			
			
					
			echo "<select ";
			if (strlen($this->classe) > 0)	{ echo "class = \"" . $this->classe . "\" "; }
			if (strlen($estilo) > 0)	{ echo "style = \"" . $estilo . "\" "; }			
			echo " name = \"" . $this->nameCombo . "\" ";
			echo " id = \"" . $this->idCombo . "\" ";
			if (strlen($this->onChange))
			{
				echo " onChange=\"{$this->onChange}\" " ;
			}
			echo "";
			echo "{$this->readonly} {$this->disabled} {$this->isMultiple}>"; 
			
			foreach( $this->elements as $key => $text)
			{
				if ($key == $this->value )
				{
					echo "<option value=\"" . $key . "\" selected>" . $text ."</option>\n";
				}
				else
				{
					echo "<option value=\"" . $key . "\">" . $text ."</option>\n";
				}
			}
			echo "</select>";
			$this->showed=true;
		}
		
		 
			
	}
}

?>


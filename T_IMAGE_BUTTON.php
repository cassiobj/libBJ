<?php 
include "defines.php";
include "enum.php";
//include "stdObject.php";
include "T_FONT.php";
include "T_BORDER.php";
include "T_INPUT.php";

if (!defined('T_IMAGE_BUTTON_H'))
{
	define('T_IMAGE_BUTTON_H', '0');

	class T_IMAGE_BUTTON
	{
	
		private static $criado;
		private $JQUERY;
		private $imageOver;
		private $imageNotOver;
		private $onClickEvent;
		private $showed;
		private $height=0;
		private $width=0;
		private $name="";
		private $hint="";
		private $border="0";
	
		public function __construct($nomeBotao="", $nomeImagemOver="", $nomeImagemNotOver="", $evento="" )
		{
			$this->name = $nomeBotao;
			$this->imageOver = $nomeImagemOver;
			$this->imageNotOver = $nomeImagemNotOver;
			$this->showed=false;
			$this->onClickEvent = $evento;
			$this->JQUERY=T_JQUERY::getInstance();
			if (!self::$criado)
			{
				self::$criado=true;
				$scripts=<<<EOT
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
				
EOT;
				$this->JQUERY->addJavaFunction($scripts);
			}
		}
		
		public function setPathImage($pathImage) { $this->imageOver = $pathImage;}		
		public function getPathImage() { return $this->imageOver;}
		
		public function setName($nome) { $this->name = $nome;}		
		public function getName() { return $this->name;}
		
		public function setBorder($tamBorda) { $this->border = $tamBorda;}		
		public function getBorder() { return $this->border;}
		
		public function setPathImageNotOver($pathImage) { $this->imageNotOver = $pathImage;}		
		public function getPathImageNotOver() { return $this->imageNotOver;}
		
		public function setPathImageOver($pathImage) { $this->imagetOver = $pathImage;}		
		public function getPathImageOver() { return $this->imageOver;}
		
		public function setSquareWidth($tamanho) 
		{ 
			$this->height = $tamanho;
			$this->width = $tamanho;			
		}
		
		public function setWidth($tamanho)	{$this->width = $tamanho;	}
		public function getWidth()	{return $this->width;	}
		
		public function setHeight($tamanho) { $this->height = $tamanho;}
		public function getHeight() { return $this->height;}
		
		public function setHint($mensagem) { $this->hint = $mensagem;}
		public function getHint() { return $this->hint;}
			
		
		
		public function setFunctionOnClick($functionCall) 
		{ 
			$this->onClickEvent = $functionCall;
		}
		
		public function show($inside ="")
		{
				
			if ($this->imageNotOver!="")
			{
				echo "<a href=\"#\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('{$this->name}','','{$this->imageOver}',1)\"><img class=\"figuraBotao\" title=\"{$this->hint}\" src=\"{$this->imageNotOver}\" name=\"{$this->name}\" id=\"{$this->name}\" ";
				if ($this->height > 0) { echo " height=\"{$this->height}\"  ";}
				if ($this->width > 0) { echo " width=\"{$this->width}\"  ";}
				echo "border=\"{$this->border}\" onClick = \"{$this->onClickEvent}\" ></a>";
			}
			else
			{
				echo "<img ";
				
				if (strlen($this->imageOver) > 0)
				{
					echo "src=\"{$this->imageOver}\" ";
				}
				
				if ($this->height > 0) { echo " height=\"{$this->height}\"  ";}
				if ($this->width > 0) { echo " width=\"{$this->width}\"  ";}
							
				if ($this->onClickEvent != "")
				{
				echo " onclick=\"" . $this->onClickEvent . "\" ";
				}
				echo ">";
			}
				
				
			$this->showed=true;
		}
	
	}
	
}
?>

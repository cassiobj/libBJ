<?php

include "defines.php";
include "enum.php";
//include "stdObject.php";
include "T_FONT.php";
include "T_BORDER.php";

if (!defined('T_CARBAR_H'))
{
	define('T_CARBAR_H', '0');

	class T_ITEM_CARBAR
	{
		private $name = "";
		private $classe = "";
		private $tag="";
		private $descMenu = "";
		private $url="";
		private $newWindow=false;
		private $onClickEvent="";
		private $isDropDown=false;
		private $arrItem=array();
		
		public function __construct()
		{
			$this->name = "";
			$this->classe = "";
			$this->tag="";
			$this->descMenu = "";
			$this->url="";
		}
		
		public function setName($nome) { $this->name = $name; }
		public function getName() { return $this->name; }
		
		public function setTag($tag) { $this->tag = $tag; }
		public function getTag() { return $this->tag; }
		public function setURL($url) { $this->url = $url; }
		public function getURL() { return $this->url; }
		
		public function setDesc($desc) { $this->descMenu = $desc; }
		public function getDesc() { return $this->descMenu; }
		
		public function setNewWindow($newWindow) { $this->newWindow = $newWindow; }
		public function getNewWindow() { return $this->newWindow; }
		public function setFunctionOnClick($onClick) { $this->onClickEvent = $onClick; }
		
		public function setDropDown($dropDown) { $this->isDropDown = $dropDown; }
		
		public function setSubMenu($tag, $desc, $url="", $newWindow="N")
		{
			$aux = new T_ITEM_CARBAR();
			$aux->setTag($tag);
			$aux->setDesc($desc);
			$aux->setURL($url);			
			if ($newWindow=="S")  $aux->setNewWindow(true);
			array_push($this->arrItem, $aux);
			$this->isDropDown = true;
		}
		
		public function display()
		{

			#echo "<li><a href=\"#myPage\">HOME</a></li>";
			
			if (!$this->isDropDown)
			{
								
				$desc = $this->descMenu;
				$tag = $this->tag;
				
				$classeFMT = "";			
				if ($this->classe != "") $classeFMT = "class=\"{$this->classe}\"";
				
				echo "<li {$classeFMT}";
				
				if ($this->url != "")
				{
					$tag = $this->url;				
					$target = "";
					if ($this->newWindow) $target = " target=\"_blank\" ";
				
					echo "><a  href=\"{$tag}\" {$target} >{$desc}</a>";
				}
				else
					echo "><a href=\"{$tag}\">{$desc}</a>";
				
				echo "</li>";
					
			}
			else
			{
				$classeFMT = "class=\"dropdown\"";
				if ($this->classe != "") $classeFMT = "class=\"dropdown {$this->classe}\"";

				
				
				echo "<li {$classeFMT}";
				
				
				$desc = $this->descMenu;
				$tag = $this->tag;
				if ($this->url != "")
				{
					$tag = $this->url;
					$target = "";
					if ($this->newWindow) $target = " target=\"_blank\" ";
				
					echo "><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\" {$target} >{$desc}<span class=\"caret\"></span></a>";
				}
				else
					echo "><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">{$desc}<span class=\"caret\"></span></a>";
				
				
				$classeFMT = "class=\"dropdown-menu\"";
				if ($this->classe != "") $classeFMT = "class=\"dropdown-menu {$this->classe}\"";
					
				
				
				
				
				foreach ($this->arrItem as $i => $item)
				{
					$classeFMT = "";
					if ($this->classe != "") $classeFMT = "class=\"{$this->classe}\"";
					
					echo "<li {$classeFMT}";
					
					$desc = $item->getDesc();
					$tag = $item->getTag();
					
					if ($item->getURL() != "")
					{
						$tag = $item->getURL();
						$target = "";
						if ($item->getNewWindow() ) $target = " target=\"_blank\" ";
					
						echo "><a href=\"{$tag}\" {$target} >{$desc}</a>";
					}
					else
						echo "><a href=\"{$tag}\">{$desc}</a>";
					
					echo "</li>";
				}
				echo "</ul>";
			
				
				echo "</li>";
			}
			
			
		}
		
		
	}
	
	class T_CARBAR
	{
		
		private $name="";
		private $classe="";
		private $imagem="";
		
		private $arrItem = array(); 
		
		private $tagsMenu;
		private $descsMenu;
		private $URLSMenu;
		private $newWindow;
		private $onClickEvent="";
		private $logado = false;
		private $mostraLogin = true;
		private $mostraCarrinho = true;
		
		public function __construct()
		{
			$this->name="";
			$this->classe="";
			$this->tagsMenu = array();
			$this->descsMenu = array();
			$this->URLSMenu = array();
			$this->newWindow = array();
			
			
		}
		
		public function exibeLogin($valor) { $this->mostraLogin = $valor; }
		public function exibeCarrinho($valor) { $this->mostraCarrinho = $valor; }
		
		
		public function setLogado($valor) { $this->logado = $valor; }
		public function setName($nome) { $this->name = $name; }
		public function getName() { return $this->name; }
		
		public function getItemMenu($indice) { return $this->arrItem[$indice] ; }
		
		public function setLogo($imagem) { $this->imagem = $imagem ; }
		
		public function display()
		{
			$this->show();
		}
		
		public function setMenu($tag, $desc, $url="", $newWindow="N")
		{
			$aux = new T_ITEM_CARBAR();
			$aux->setTag($tag);
			$aux->setDesc($desc);
			$aux->setURL($url);			
			if ($newWindow=="S")  $aux->setNewWindow(true);
			array_push($this->arrItem, $aux);
			
			array_push($this->tagsMenu, $tag);
			array_push($this->descsMenu, $desc);
			array_push($this->URLSMenu, $url);
			array_push($this->newWindow, $newWindow);
		}
		
		public function show()
		{
			$nomeClasse = "navbar navbar-default navbar-fixed-top";
			if ($this->classe != "")
			{
				$nomeClasse .= " " . $this->classe;
			}
			
			$nameFMT = "";
			if ($this->name != "")
			{
				$nameFMT = "name=\"{$this->name}\" id=\"{$this->name}\" ";
			}
			
			echo "<nav class=\"$nomeClasse\" {$nameFMT} >";
			echo "	<div class=\"container\">"; 
			echo "		<div class=\"navbar-header\">";
			
			
			echo <<<EOT
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        		<span class="icon-bar"></span>
        		<span class="icon-bar"></span>
        		<span class="icon-bar"></span>                        
      		</button>
EOT;
			if ($this->imagem!="")
			{
				
				//echo "<a class=\"navbar-brand\" href=\"#myPage\"><img src=\"{$this->imagem}\" class=\"img-responsive\" width=\"20%\" height=\"20%\" ></a>";
				echo "<a class=\"navbar-brand\" href=\"#myPage\"><img src=\"{$this->imagem}\" class=\"img-responsive\"  ></a>";
			}			
			echo "		</div>";
			
			
			if (count($this->arrItem) > 0 )
			{
				echo "<div class=\"collapse navbar-collapse\" id=\"myNavbar\">";
				echo "<ul class=\"nav navbar-nav navbar-right\">";
				
				foreach ($this->arrItem as $i => $item)
				{
					$item->display();
					
				}
				
				echo "<li>";
				echo "&nbsp&nbsp&nbsp";
				echo "</li>";
				echo "<li name = 'liLogin' id='liLogin'>";
				if ($this->mostraLogin)
				{		
					if (! $this->logado)
					{
						showTabLogin($this->mostraLogin, $this->mostraCarrinho);				
					}
				}
				echo "</li>";
				
				echo "</ul>";
				echo "</div>";
			}
				
			
			
			/*if (count($this->tagsMenu) > 0)
			{
				echo "<div class=\"collapse navbar-collapse\" id=\"myNavbar\">";
				echo "<ul class=\"nav navbar-nav navbar-right\">";
			
				foreach ($this->tagsMenu as $i => $tag) 
				{
    				$desc = $this->descsMenu[$i];
    				$url = $this->URLSMenu[$i];    				
    				   				
    				echo "<li ";
    						
    				if ($this->URLSMenu[$i] != "")
    				{
    					$tag = $this->URLSMenu[$i];
    					$target = "";
    					if ($this->newWindow[$i] == "S") $target = " target=\"_blank\" ";
    						
    					echo "><a href=\"{$tag}\" {$target} >{$desc}</a>";
    				}
    				else    				
    					echo "><a href=\"{$tag}\">{$desc}</a>";
    				
    				echo "</li>";
				}
				echo "</ul>";
				echo "</div>";
			}*/
			
			
			echo "	</div>";
			echo "</nav>";
		}
		
		
		
	};
	
};


?>
<?php 
include "defines.php";
include "enum.php";
//include "stdObject.php";
include "T_JQUERY.php";

if (!defined('T_HTML_H'))
{
	define('T_HTML_H', '0');


	class T_HTML
	{
		private static $instance;
		private $charset="UTF-8";
		private $scriptsFile= array();
		private $CSSsFile= array();
		private $titlePagina="";
		private $arrBody= array();
		private $styleBody="";
		private $background="";
		private $viewport="";
		
		public function addViewPort($xViewPort)
		{
			$this->viewport=$xViewPort;
		}
		
		public static function getInstance()
		{
		
			if(!self::$instance) {
				self::$instance = new self();
			}
			return self::$instance;
		}
		
		private function __construct()
		{
			
			// array de body
			// criado com a finalidade de nomear bodys para caso algum momento ser criado um 
			// outro body
			array_push($this->arrBody, "mainBody" );
		}
		
		
		
		public function setCharset($xCharset)
		{
			$this->charset = $xCharset;
		}
		
		public function addScriptFile($nomeScript, $endScript)
		{
			$i=0;
			$varArray=array();
			foreach ($this->scriptsFile as $varArray)
			{
				if ($varArray[0] == $nomeScript)
				{				
					showMessageSystemErro("Script ${nomeScript} em ${endScript} já declarado.");
					return false;
				}
				$i = $i +1;
			}		
			array_push( $this->scriptsFile , array( $nomeScript, $endScript ) );
			//$scriptsFile[$i] = array( $nomeScript, $endScript );
			return true;
		}
		
		public function addCSSFile($nomeMeta, $endScript)
		{		
			$varArray=array();
			foreach ($this->CSSsFile as $varArray)
			{
				if ($varArray[0] == $nomeMeta)
				{
					showMessageSystemErro("Stylesheet ${nomeMeta} em ${endScript} já declarado.");
					return false;
				}			
			}		
			array_push( $this->CSSsFile , array( $nomeMeta, $endScript ) );		
			return true;
		}
		
		public function setTitle($xTitle)
		{
			$this->titlePagina = $xTitle;
		}
		
		
		public function initShow()
		{
			/*header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
			 header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
			 header( 'Cache-Control: no-store, no-cache, must-revalidate' );
			 header( 'Pragma: no-cache' );
			 header( 'Content-Type: text/html; charset=iso-8859-1' );*/
			echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Frameset//EN\">";
			echo "<html>";
		}
		
		public function showHead()
		{
			$cssFile="";
			$javascriptFile="";
			
			
			
			
			
			
			echo "<head>";
			
			//header( 'Content-Type: text/html; charset=UTF-8' );
			//echo "<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\" />";
			//echo "<meta content=\"text/html; charset=utf-8\" http-equiv=\"content-type\">";
			echo "<meta content=\"text/html; charset=" . $this->charset . "\" http-equiv=\"content-type\">";
			
			if ($this->viewport != "")
			{
				echo "<meta name=\"viewport\" content=\"{$this->viewport}\">";
			}
			
			
			foreach ($this->CSSsFile as $varArray)
			{
				$cssFile = $varArray[1];
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $cssFile . "\">";
			}
			
			
			foreach ($this->scriptsFile as $varArray)
			{
				$javascriptFile = $varArray[1];
				echo "<script  type=\"text/JavaScript\" src=\"" . $javascriptFile . "?token=" . date('YmdHis') . "\"></script>";
			}
			
			//echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../estilos/ddsmoothmenu.css\">";
			//echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../estilos/ddsmoothmenu-v.css\">";
			//echo "<script  type=\"text/JavaScript\" src=\"../scripts/jquery-1.11.0.js\"></script>";
			//echo "<script  type=\"text/JavaScript\" src=\"../scripts/ddsmoothmenu.js\"></script>";
			
			
			echo "<title>" . $this->titlePagina . "</title>";
			echo "</head>";
			
			
		}
		
		public function endShow()
		{	
			$JQUERY=T_JQUERY::getInstance();
			echo "</html>";		
			$JQUERY->show();
		}
		
		
		/*public function openBody()
		{
			echo "<body id=\"". $this->arrBody[0] . "\" name=\"". $this->arrBody[0] . "\" >";
		}*/
		
		public function setStyleBody($style)
		{
			$this->styleBody = $style;
		}
		
		public function setBackgroundBody($imagem="")
		{
			$this->background = $imagem;
		}
		
		public function openBody($nomeBody="")
		{	
			if (strlen($nomeBody) > 0)
			{	
				if (array_search($nomeBody) >= 0)
				{
					showMessageSystemErro("Body ID ${nomeBody} ja existente.");
					return;
				}
				array_push($this->arrBody, $nomeBody);		
				echo "<body id=\"{$nomeBody}\" name=\"{$nomeBody}\" ";
				if ($this->styleBody != "")
				{
					echo "style=\"{$this->styleBody}\" ";
				}
				
				if ($this->background != "")
				{
					echo "background=\"{$this->background}\" ";
				}
				
				echo ">";
			}
			else
			{
				echo "<body  id=\"". $this->arrBody[0] . "\" name=\"". $this->arrBody[0] . "\" ";
				if ($this->styleBody != "")
				{
					echo "style=\"{$this->styleBody}\" ";
				}
				if ($this->background != "")
				{
					echo "background=\"{$this->background}\" ";
				}
				
				echo ">";
			}
		}
		
		
		
		
		public function closeBody()
		{
			echo "</body>";
		}
		
		public function closeAllBodys()
		{
			for ($i=0; $i < sizeof($this->arrBody);$i=$i + 1 )
			{
				echo "</body>";
			}
		}
		
		
		
		public function toArray()
		{
			return (array) $this;
		}
	}
}
?>
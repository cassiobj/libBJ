<?php 

include "defines.php";
include "enum.php";
//include "stdObject.php";

if (!defined('T_JQUERY_H'))
{
	define('T_JQUERY_H', '0');


	class T_JQUERY
	{
		private static $instance;
		private $strFunction="";
		private $strChangeFunction="";
		private $strClickFunction="";
		private $strReadyFunction="";
		private $strJavaFunction="";
		private $strCSS="";
		
	
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
			
		}
		
		public function addCSS($str)
		{
			$this->strCSS = $this->strCSS . "\n\n" . $str;
		}
		
		public function addFunction($str)
		{
			$this->strFunction = $this->strFunction . "\n\n" . $str;			
		}
		
		public function addChangeFunction($str)
		{
			$this->strChangeFunction = $this->strChangeFunction . "\t" . $str . "\n\n";
		}
		public function addClickFunction($str)
		{
			$this->strClickFunction = $this->strClickFunction . "\t" . $str . "\n\n";
		}
		
		public function addReadyFunction($str)
		{
			$this->strReadyFunction = $this->strReadyFunction . "\t" . $str . "\n\n";
		}
		
		public function addJavaFunction($str)
		{
			$this->strJavaFunction = $this->strJavaFunction . "\t" . $str . "\n\n";
		}
		
		public function show()
		{
			if (strlen($this->strCSS) > 0)
			{
				echo "<style type=\"text/css\">";
				echo $this->strCSS;
				echo "</style>";
			}
			
			echo "<script>";
			
			if (strlen($this->strJavaFunction) > 0)
			{
				echo $this->strJavaFunction;
			}
			
			if ( (strlen($this->strFunction) > 0) ||
				 (strlen($this->strChangeFunction) > 0) ||
				 (strlen($this->strClickFunction) > 0) ||
				 (strlen($this->strReadyFunction) > 0)	)
			{
				echo "$(function(){";
			}
			
			if (strlen($this->strFunction) > 0)
			{				
				echo $this->strFunction;				
			}
			
			
				
			
			if (strlen($this->strChangeFunction) > 0)
			{
				$this->strChangeFunction = str_replace("\n", "\n\t",   $this->strChangeFunction);
				
				echo "jQuery(document).on(\"change\", function(e) {\n"; 
				echo "var \$changed = $(e.target);\n\n";
				
				echo  $this->strChangeFunction;
				
				echo "});\n";
			}

			if (strlen($this->strClickFunction) > 0)
			{
				$this->strClickFunction = str_replace("\n", "\n\t",   $this->strClickFunction);
			
				echo "jQuery(document).on(\"click\", function(e) {\n";
				echo "var \$clicked = $(e.target);\n\n";
			
				echo  $this->strClickFunction;
			
				echo "});\n";
			}
				
			
			if (strlen($this->strReadyFunction) > 0)
			{
				$this->strReadyFunction = str_replace("\n", "\n\t",   $this->strReadyFunction);
			
				echo "$(document).ready(function(){\n";							
				echo  $this->strReadyFunction;			
				echo "});\n";
			}
			
			if ( (strlen($this->strFunction) > 0) ||
					(strlen($this->strChangeFunction) > 0) ||
					(strlen($this->strClickFunction) > 0) ||
					(strlen($this->strReadyFunction) > 0)	)
			{
				echo "});";
			}
			echo "</script>";
		}
		
	}
}
?>
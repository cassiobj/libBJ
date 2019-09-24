<?php

include "defines.php";
include "enum.php";
//include "stdObject.php";
include "T_CONEXAO.php";
include "T_DATASET.php";

if (!defined('T_DATAGRID_H'))
{
	define('T_DATAGRID_H', '0');
	
	class T_DATAGRID extends T_TABLE
	{
		private $separador;
		private $classeNormal;
		private $classeAlter;
		
		
		public function __construct($isBootstrap = false)
		{
			parent::__construct();
			parent::setBootstrap($isBootstrap);
		}
		
		
		public function setSeparator($character) { $this->separador = $character;} 
		public function getSeparator() { return $this->separador;}
		
		public function setClassLinNormal($classe) { $this->classeNormal = $classe;} 
		public function setClassLinAlter($classe) { $this->classeAlter = $classe;}
		
		public function getClassLinNormal() { return $this->classeNormal ;} 
		public function getClassLinAlter() { return $this->classeAlter; }
		
		public function setHeaderIndice($lin, $col, $conteudo, $campo, $ajaxCall="")
		{
			$auxConteudo = "<a href=\"#\" class=\"tituloTabela\">{$conteudo}</a>";
			parent::setHeader($lin, $col, $auxConteudo);			
			$this->rows[$lin]->cols[$col]->setFunctionOnClick("setIndice('{$campo}');{$ajaxCall}");
		}
		
	}
	
}

?>
<?php

//include "../sgc/funcoesSistema.php";
include "defines.php";
include "enum.php";
//include "stdObject.php";
include "T_SESSION.php";
include "T_HTML.php";
include "T_FORM.php";
include "T_TABLE.php";
include "T_ROW.php";
include "T_COL.php";
include "T_COMBO.php";
include "T_INPUT.php";
include "T_CONEXAO.php";
include "T_DATASET.php";
include "T_LOOKUP_COMBO.php";
include "T_CHECK_COMBO.php";
include "T_TEXT.php";
include "T_BUTTON.php";

if (!defined('T_TABLE_SYS_H'))
{
	define('T_TABLE_SYS_H', '0');

	class T_TABLE_SYS extends T_TABLE
	{
		private $conexao=NULL;
		private $idUsuario=NULL;
		private $idGrupoUsuario=NULL;
		
		public function __construct($idUser=0, $idGrupoUser=0, $Conn = NULL, $isBootStrap = false)
		{
			parent::__construct();
			parent::setBootstrap($isBootStrap);
			if ($idUser != 0)
			{
				$this->idUsuario = $idUser;
			}
			
			if ($idGrupoUser != 0)
			{
				$this->idGrupoUsuario = $idGrupoUser;
			}
			
			if ($Conn!=NULL)
			{
				$this->conexao = $Conn;
			}			
		}
		
		public function setConnection($Conn) { $this->conexao = $Conn; }
		
		public function setIdUser($idUser) { $this->idUsuario = $idUser; }
		public function getIdUser() { return $this->idUsuario ; }
		
		public function setIdGrupoUser($idGrupoUser) { $this->idGrupoUsuario = $idGrupoUser; }
		public function getIdGrupoUser() { return $this->idGrupoUsuario ; }
				
		public function show()
		{	
			//$menu = montaMenu($this->idUsuario, $this->idGrupoUsuario, $this->conexao);
			//parent::set(0,0, $menu); 
			parent::show();
						
		}
		
				
		
	}
	
}

?>

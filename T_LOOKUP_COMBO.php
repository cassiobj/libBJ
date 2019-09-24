<?php

include "defines.php";
include "enum.php";
//include "stdObject.php";
include "T_FONT.php";
include "T_BORDER.php";
include "T_COMBO.php";
include "T_DATASET.php";


if (!defined('T_LOOKUP_COMBO_H'))
{
	define('T_LOOKUP_COMBO_H', '0');

	class T_LOOKUP_COMBO extends T_COMBO
	{
		private $conexao=NULL;
		private $idField=NULL;
		private $textField=NULL;
		private $orderField=NULL;
		private $table=NULL;
		private $filterTable=NULL;
		private $tConsulta=NULL;
		private $isISO = false;
		
		public function __construct($Conn = NULL)
		{
			parent::__construct();
			if ($Conn!=NULL)
			{
				$this->conexao = $Conn;
			}
		}
		
		public function setConnection($Conn) { $this->conexao = $Conn; }
		
		public function setIdField($idField) { $this->idField = $idField; }
		public function getIdField() { return $this->idField ; }
		
		public function setISO($iso) { $this->isISO = $iso ;} 
		
		public function setTextField($textField) { $this->textField = $textField; }
		public function getTextField() { return $this->textField ; }
		
		public function setOrderField($orderField) { $this->orderField = $orderField; }
		public function getOrderField() { return $this->orderField ; }
		
		public function setTable($table) { $this->table = $table; }
		public function getTable() { return $this->table ; }
		
		public function setFilterTable($filtro) { $this->filterTable = $filtro; }
		public function getFilterTable() { return $this->filterTable ; }
		
		public function readData()
		{
			if ($this->idField==NULL) { showMessageSystemErro("Erro em T_LOOKUP_COMBO : idField não informado."); }
			if ($this->textField==NULL) { showMessageSystemErro("Erro em T_LOOKUP_COMBO : textField não informado."); }
			if ($this->table==NULL) { showMessageSystemErro("Erro em T_LOOKUP_COMBO : table não informado."); }
			
			$sql = "select " . $this->idField . ", " . $this->textField . " from " . $this->table;
			if ($this->filterTable != NULL) { $sql = $sql . " where " . $this->filterTable; }
			if ($this->orderField != NULL) { $sql = $sql . " order by " . $this->orderField; }
						
			
			$this->tConsulta = new T_DATASET($this->conexao);
			$this->tConsulta->query($sql);
			
						
			while ( $this->tConsulta->fetchRow() )
			{
				if ($this->isISO)
					$this->addElement( $this->tConsulta->getFieldISO($this->idField) , $this->tConsulta->getFieldISO($this->textField));
				else
					$this->addElement( $this->tConsulta->getField($this->idField) , $this->tConsulta->getField($this->textField));
			}
		}
		
		public function getQuery()
		{
			$sql = "select " . $this->idField . ", " . $this->textField . " from " . $this->table;
			if ($this->filterTable != NULL) { $sql = $sql . " where " . $this->filterTable; }
			if ($this->orderField != NULL) { $sql = $sql . " order by " . $this->orderField; }
				
			return $sql;
		}
		
		public function show()
		{
			$this->readData();
			parent::show();
		}
		
				
		
	}
	
}

?>
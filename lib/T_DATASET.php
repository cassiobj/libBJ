<?php

include "defines.php";
include "enum.php";
//include "stdObject.php";
include "T_CONEXAO.php";

if (!defined('T_DATASET_H'))
{
	define('T_DATASET_H', '0');

	class T_DATASET
	{
		
		private $conexao;
		private $conGlobal;
		private $res;
		private $recno=-1;
		private $recordCount=0;
		private $lock = true;
		public $row=NULL;
		
		public function setLock($valor) { $this->lock = $valor ; } 
		public function getLock() { return $this->lock; }
		
		public function recordCount() { return $this->recordCount; } 

		public function __construct($Conn=NULL)
		{
			$this->conGlobal = $Conn;
			if ($Conn)
			{				
				$this->conexao = $Conn->conexao;
			}	
			$this->recno=0;
			$this->recordCount=0;
		}
		
		public function query($sql)
		{
			$this->recordCount=0;
			$this->recno=-1;
			
			
			if (!$this->lock)
			{
				//$this->conexao->trans_start();
				$this->conexao->query('SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;');
			}
			
			if (!($this->res = $this->conexao->real_query($sql)))
			{
				showMessageSystemErro("Erro ao executar query:\\n\\n {$sql} \\n\\n"  . $this->conexao->error );
				return -1;
			}
			
			if (isset($this->res->num_rows))
			{
				$this->recordCount= $this->res->num_rows;
			}
			else
			{
				
				if ($this->res = $this->conexao->store_result()) 
				{
					
					$this->recordCount= $this->res->num_rows;
				}
			}
			
			return 0;
		}
		
		public function fetchRow()
		{
			if (!($this->row = $this->res->fetch_assoc()))
			{				
				return false ;
			}
			else
			{
				$this->recno++;
				return true;
			}
		}
		
		public function getFieldISO($nome) { return  htmlentities($this->row[$nome], ENT_QUOTES | ENT_HTML5 ,'UTF-8', true); }
		public function getField($nome) { return  $this->row[$nome]; }
		public function setConnection($Conn) { $this->conexao = $Conn; }
		
		public function recno($indice=NULL)
		{
			if ($indice)
			{
				$this->recno = $indice;			
				if ($this->res->data_seek($this->recno)) { return true; }
				else { return false; }			
			}
			else
				return $this->recno;
		}		
		
		public function eof() { return ($this->recno == ($this->recordCount-1));}		
		public function bof() { return ($this->recno == 0); }
		
		public function getLastID()
		{			
			return $this->conexao->insert_id;			
		}

	}

}



?>
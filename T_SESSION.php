<?php

include "defines.php";
include "enum.php";
//include "stdObject.php";
include "T_JQUERY.php";

if (!defined('T_SESSION_H'))
{
	define('T_SESSION_H', '0');


	class T_SESSION
	{
		private static $instance;
		private $timeout=300	;
		
	

		public static function getInstance()
		{
			
			if(!self::$instance) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		private function __construct()
		{
			$this->check_sessao_start();
			// array de body
			// criado com a finalidade de nomear bodys para caso algum momento ser criado um
			// outro body			
		}
		
		public function setTimeout($segundos)
		{
			$this->timeout=$segundos;
			$this->check_sessao_start();
			$_SESSION['TIMEOUT'] = $segundos;
		}
		
		private function  check_sessao_start()
		{			
			if (!isset($_SESSION))
			{				
				@ob_start();
				if(session_status()!=PHP_SESSION_ACTIVE)  session_start();						
				session_cache_limiter('private');
				ini_set('session.gc_maxlifetime', 99999999);
				ini_set('session.save_path', dirSessao);		// variavel em defines.php	
				ini_set('session.name', "PHPSESSID");
				ini_set('session.serialize_handler', "php");				
				session_cache_expire(86400); 
				session_set_cookie_params(86400);
			}
				//$_SESSION['LAST_ACTIVITY'] = time();
			
		}
		
		public function defineSessao($sessao)		
		{
			$this->check_sessao_start(); 
			
			# LOOP THROUGH IT			
			foreach(array_keys($sessao) as $chave)
			{
				#$print $key.", ".$value."<br />";
				$_SESSION[$chave] = $sessao[$chave];
			}
			$_SESSION['LAST_ACTIVITY'] = time();
		}
		
		public function getSessao()
		{
			return $_SESSION;
		}
		
		public function defineChave($chave, $valor)
		{
			$this->check_sessao_start();
			$_SESSION[$chave] = $valor;			
		}
		
		public function getChave($chave)
		{
			$this->check_sessao_start();
			return $_SESSION[$chave];
		}
		
		public function getChaveNum($chave)
		{
			$retorno = 0;
			$this->check_sessao_start();
			if (isset($_SESSION[$chave])) $retorno = $_SESSION[$chave];
			return $retorno;
		}
		
		public function existeChave($chave)
		{
			$this->check_sessao_start();
			if (isset($_SESSION[$chave]))
				return true;
			else
				return false;			
		}
		
		public function deleteChave($chave)
		{
			$this->check_sessao_start();
			if (isset($_SESSION[$chave]))
			{
				unset($_SESSION[$chave]);
				return true;
			}
			else
				return false;
		}
		
		

		public function validaSessao()
		{
			$this->check_sessao_start();
			if (isset($_SESSION['TIMEOUT'])) { $this->timeout = $_SESSION['TIMEOUT']; };  
			if ( (!isset($_SESSION['LAST_ACTIVITY'])) || (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $this->timeout)))
			{
				// last request was more than 30 minates ago
				echo "Sessao Expirada. <br>Redirecionando...";
				/*echo <<<EOT
<script language="JavaScript">
var time = null
function move()
{
	window.location.replace("http://10.0.18.20/sgc");
}
timer=setTimeout('move()',3000);
</script>
EOT;*/
				session_destroy();   // destroy session data in storage
				session_unset();     // unset $_SESSION variable for the runtime
				exit;
				re8turn(false);				
			}
			$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
			return(true);
		}

	}
	
}
?>
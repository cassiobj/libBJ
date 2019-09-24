<?php

if (!defined('defines'))
{
	define('defines', '1');
	
	
	global $dirSession;
	
	//define('dirSessao', "/tmp");
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		$dirSession = "D:\\sessoes";
		define('dirSessao', "D:\\sessoes");
	} else {
		$dirSession = "/tmp";
		define('dirSessao', "/tmp");
	}
	
	
		
	function showMessageSystemErro($mensagem)
	{ 
		$msg="";
		$msg = "ERRO DE SISTEMA:\\n\\n";
		$msg = $msg . $mensagem;
		$msg = $msg . "Informe a equipe de desenvolvimento.";
		
		//echo "<script>alert('Entrou');</script>";
		//echo "<script language=\"JavaScript\">alert('${msg}');</script>";	
		echo "<script>alert(\"" . $msg . "\");</script>";
		
	}

	function getUserEmail($email)
	{
		$arrEmail = split("@", $email);
		return $arrEmail[0];   
	}

	
	
}
	
?>
<?php 


include "dadosConn.php";
include "defines.php";
include "T_CONEXAO.php";
include "T_DATASET.php";



$conn = new T_CONEXAO($dbAddrHost, $dbUser, $dbPass, $dbName);
$conn->connect();



//$side = $_GET["side"];
// Na linha abaixo é dado um escape, para retirar caracteres que possam prejudicar a consulta sql
$q = $_GET["q"];
//$cd_usuario = $_GET["cd_usuario"];

$campoTexto = $_GET["campoTexto"];
$campoID = $_GET["campoID"];

$tabela = $_GET["tabela"];

$campoConsulta=$campoTexto;
if (isset($_GET["campoConsulta"]) && $_GET["campoConsulta"] != "" )
{
	$campoConsulta = $_GET["campoConsulta"];
}

$filtro="";
if (isset($_GET["filtro"]) && $_GET["filtro"] != "" )
{
	$filtro = " and " . $_GET["filtro"];
}

$ordem = $campoTexto;
if (isset($_GET["ordem"]) && $_GET["ordem"] != "" )
{
	$ordem = $_GET["ordem"];
}

$resposta="";
$sep = "";




// Abaixo a sql que retornará os dados
$queryData = "SELECT {$campoID}, {$campoTexto} FROM {$tabela} where upper({$campoConsulta}) like '%". strtoupper($q) ."%' {$filtro} order by {$ordem} ";



$Tabela = new T_DATASET($conn);

$Tabela->query($queryData);



$tot = $Tabela->recordCount();

if ($tot==0)
{
	echo "0";
	exit;
}
echo "<meta content=\"text/html; charset=ISO-8859-1\" http-equiv=\"content-type\">|";
$sep = "";
$retorno="";
$i=0;
while ($Tabela->fetchRow())
{	
	$cd_id = $Tabela->getField($campoID);
	$nome_texto = $Tabela->getField($campoTexto);
	$retorno = $retorno . $sep . $cd_id . "#" . $nome_texto;
	$sep = "|";
}

echo $retorno;

?>

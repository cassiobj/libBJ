<?php

include "defines.php";
//include "stdObject.php";
include "enum.php";
include "T_FONT.php";
include "T_BORDER.php";
include "T_COMBO.php";
include "T_CONEXAO.php";
include "T_DATASET.php";
include "T_JQUERY.php";


if (!defined('T_CHECK_COMBO_H'))
{
	define('T_CHECK_COMBO_H', '0');

	class T_CHECK_COMBO extends T_COMBO
	{		
		private $idTitulo=0;
		private $JQUERY;
		private $painelChecked="";
		private $hasPainelChecked=0;
		private $filterOn="";
		private $hasFilterOn="0";
		private $filterOff="";
		private $hasFilterOff="0";
		private $classButtonChecked="";
		private $conn;
		
		private $nameTxtFiltroHidden = "";
		private $idUser=0;
		
		public function __construct()
		{
			parent::__construct();
			$this->JQUERY=T_JQUERY::getInstance();
			parent::addElement("NULL", "Selecione");
			$this->painelChecked="";
			$this->hasPainelChecked="0";
		}
		
		public function addTitulo($value)
		{
			parent::addElement("TITULO_". $this->idTitulo, $value);
			$this->idTitulo = $this->idTitulo + 1;
		}
		
		public function addFiltro($tipo, $key, $texto)
		{
			$chave=$tipo.":".$key;
			$valor="&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" . $texto;
			parent::addElement($chave, $valor);		
		}

		public function setPainelChecked($nomePainel) { $this->painelChecked=$nomePainel; $this->hasPainelChecked=1; }	
		public function getPainelChecked() { return $this->painelChecked;}
		
		public function setClassButtonChecked($classe) { $this->classButtonChecked=$classe ;}
		public function getClassButtonChecked() { return $this->classButtonChecked;}
		
		public function setIdUserFiltro($idUserSessao, $conn) 
		{ 	
			$this->idUser = $idUserSessao; 
			$this->conn=$conn;
		}
		public function getIdUserFiltro() { return $this->idUser ; }
		
		
		public function setFunctionOnChecked($function)
		{
			$this->filterOn=$function;
			$this->hasFilterOn=1;
		}
		
		public function setFunctionOnUnchecked($function)
		{
			$this->filterOff=$function;
			$this->hasFilterOff=1;
		}
				
		public function hasPainelChecked() { return $this->hasPainelChecked==0 ? true: false; }
		
		public function getChaveFiltro()
		{
			$TFiltro = new T_DATASET($this->conn);
			$query = "select anFiltro from cpeConfig.cpc_filtroSessao where idUser = {$this->idUser} and anChave = '{$this->nameTxtFiltroHidden}' ";
			$TFiltro->query($query);
			
			$retorno="";
			if ($TFiltro->recordCount() > 0)
			{
				$TFiltro->fetchRow();
				$retorno = $TFiltro->getField("anFiltro");
			}
			else
			{
				$query = "insert into cpeConfig.cpc_filtroSessao (idUser, anChave) values ( {$this->idUser}, '{$this->nameTxtFiltroHidden}') ";
				$TFiltro->query($query);
			}
			return $retorno;
		}
		
		
		
		public function show()
		{			
			$this->nameTxtFiltroHidden = "txtFiltro_" . $this->getName();
			$filtroCombo="";
			$stringSalvaAjaxFiltro = "";
			$stringApagaAjaxFiltro = "";
			if ($this->idUser!=0)
			{									
				$filtroCombo = $this->getChaveFiltro();
				$stringSalvaAjaxFiltro = "salvaSessaoFiltro({$this->idUser} , '{$this->nameTxtFiltroHidden}', strAux);"; 
				$stringApagaAjaxFiltro = "salvaSessaoFiltro({$this->idUser}, '{$this->nameTxtFiltroHidden}', newFiltro);";
			}
			
			parent::show();
			echo "<input type=\"hidden\" name = \"" . $this->nameTxtFiltroHidden . "\" id = \"" . $this->nameTxtFiltroHidden . "\" value=\"{$filtroCombo}\" >";
			
			/* -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
			 *  verificando existência de filtro de sessão 
			-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=  */
			$arrFiltros = explode("|", $filtroCombo);
			$totFiltros = count($arrFiltros) -1;
			if ($totFiltros > 0)
			{
				$jQuery = T_JQUERY::getInstance();
				
				
				$scriptCria="";
				echo <<<EOT
				<script>
				$('#{$this->getName()} option').eq(0).text('{$totFiltros} Filtro(s)');$('#{$this->getName()} option').eq(0).text('{$totFiltros} Filtro(s)');
				</script>
EOT;
				for ($i=0; $i < count($arrFiltros)-1; $i++ )
				{
					$valorFiltro = $arrFiltros[$i];
//					echo "$valorFiltro";
					
					$scriptCria= $scriptCria . <<<EOT
					
					if ("{$this->hasPainelChecked}" == "1")
					{
						comboFiltro = document.getElementById("{$this->getName()}");						 
						var trFiltro = document.getElementById("{$this->painelChecked}");
						var strText = "";
						var indice=0;
						for (i = 0; i < comboFiltro.length; i++) {
        					if (comboFiltro.options[i].value == "{$valorFiltro}")
        					{
        						strText = comboFiltro.options[i].text.trim();
        						indice = i;        						
        						var strTextNew = '»\\xA0\\xA0\\xA0\\xA0\\xA0' + strText;
        						comboFiltro.options[i].text=strTextNew;
        						break;
        					}
    					} 
						
						var botao=document.createElement("INPUT");
						botao.setAttribute("type", "button");
						botao.setAttribute("name", "botFiltro_{$valorFiltro}");
						botao.setAttribute("id", "botFiltro_{$valorFiltro}" );
						botao.value=strText + '   x';	
						botao.setAttribute("onclick", 'delFiltro_{$this->getName()}(this, ' + indice.toString() + ', "{$valorFiltro}")' );
						trFiltro.appendChild(botao);
					}
					
EOT;
				}
				$jQuery->addJavaFunction($scriptCria);
			}
			
			
			
			/* -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
			 *  MONTA COMBO FILTRO
			 -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=  */			
			$str = <<<EOT

if (e.target.id == '{$this->getName()}' )
{ 			
	if ($("#{$this->getName()}").val() == 'NULL' || $("#{$this->getName()}").val().indexOf("TITULO_") != -1 || $("#{$this->getName()} option:selected").text().indexOf("»")!=-1 )
	{
		$("#{$this->getName()}").val('NULL');
		return;
	}
	
	$("#{$this->nameTxtFiltroHidden}").val( $("#{$this->nameTxtFiltroHidden}").val() +  $("#{$this->getName()}").val() + "|" );
	var strAux = $("#{$this->nameTxtFiltroHidden}").val();
	
	arrFiltros = strAux.split("|");			
	totFiltros = arrFiltros.length - 1;	
	$('#{$this->getName()} option').eq(0).text(totFiltros.toString() + ' Filtro(s)');
 	{$stringSalvaAjaxFiltro}
	var strText = $('#{$this->getName()} option:selected').text().substring(7,100);	
	var strTextNew = '»\\xA0\\xA0\\xA0\\xA0\\xA0' + strText;
	$('#{$this->getName()} option:selected').text(strTextNew);
	if ("{$this->hasPainelChecked}" == "1")
	{
		var trFiltro = document.getElementById("{$this->painelChecked}");
		comboFiltro = document.getElementById("{$this->getName()}");
		var botao=document.createElement("INPUT");
		botao.setAttribute("type", "button");
		botao.setAttribute("name", "botFiltro_" + $("#{$this->getName()}").val() );
		botao.setAttribute("id", "botFiltro_" + $("#{$this->getName()}").val() );
		botao.value=strText + '   x';	
		botao.setAttribute("onclick", 'delFiltro_{$this->getName()}(this, ' + comboFiltro.selectedIndex.toString() + ', "' + comboFiltro.value + '")' );
		trFiltro.appendChild(botao);
		
	}
	$("#{$this->getName()}").val('NULL');	
	
	if ("{$this->hasFilterOn}" == "1")
	{		
		{$this->filterOn};
	}
} 
EOT;
			$this->JQUERY->addChangeFunction($str);

			if ($this->hasPainelChecked==1)
			{		
				$str = <<<EOT
function delFiltro_{$this->getName()}(botao, indice, valor)
{
	var comboFiltro = document.getElementById("{$this->getName()}");
	var trFiltro = document.getElementById("{$this->painelChecked}");
	var txtComboFiltros = document.getElementById("{$this->nameTxtFiltroHidden}");
	var arrFiltros = new Array();
	var newFiltro = new String();
	var textoBotaoOld = new String();
	var textoComboNew = new String();
	var i=0, totFiltros=0;
   
	arrFiltros = txtComboFiltros.value.split("|");	
	newFiltro = "";
	for (i=0; i< arrFiltros.length-1; i++ )
	{
		if (arrFiltros[i] != valor)
		{
			newFiltro = newFiltro + arrFiltros[i] + "|";
			totFiltros++;
		}		
	}
	txtComboFiltros.value=newFiltro;
	{$stringApagaAjaxFiltro}
	
	
	for (i=0; i < comboFiltro.options.length; i++)
	{
		if (comboFiltro.options[i].value == valor)
		{
			textoBotaoOld = comboFiltro.options[i].text.substring(6,30);
			textoComboNew= '\\xA0\\xA0\\xA0\\xA0\\xA0\\xA0\\xA0' + textoBotaoOld;
			comboFiltro.options[i].text = textoComboNew;			
		}
	}
	
	
	textoComboNull="Selecione";
	if (totFiltros >0)
	{
		textoComboNull = totFiltros.toString() + ' Filtro(s)';
	}
	comboFiltro.options[0].text = textoComboNull;
	
	trFiltro.removeChild(botao);



	if ("{$this->hasFilterOff}" == "1")
	{
		{$this->filterOff};
	}
}
EOT;

				$this->JQUERY->addJavaFunction($str);
			}		
		}
		
				
		
	}
	
}

?>
<?php

include "defines.php";
include "enum.php";
//include "stdObject.php";
include "T_FONT.php";
include "T_BORDER.php";
include "T_INPUT.php";


if (!defined('T_INPUT_SEARCH_H'))
{
	define('T_INPUT_SEARCH_H', '0');


	class T_INPUT_SEARCH extends T_INPUT
	{
		private static $criouSearch;
		private $nomeCampo="";
		private $nomeCampoOld="";
		private $nomeCampoID="";
		private $nomeLista="";
		private $nomeDiv="";
		private $sizeLista="10";		
		private $widthLista="";
		private $heightLista="";
		private $classLista="";
		private $valueID="0";
		private $jQuery;
		private $conn;
		
		private $campoTexto="";
		private $campoID="";
		private $tabela="";
		private $filtroTabela="";
		private $orderTabela="";
		
		public function __construct($nomeCampo="", $nomeCampoID="", $conn="")
		{
			$this->conn=$conn;
			$this->nomeCampo=$nomeCampo;
			$this->nomeCampoOld=$nomeCampo . "_old";
			$this->nomeCampoID=$nomeCampoID;
			$this->nomeLista=$nomeCampo . "_list";
			$this->nomeDiv=$nomeCampo . "_div";
			$this->classLista="listaSearch";
			parent::__construct($nomeCampo, "text");
			$this->jQuery = T_JQUERY::getInstance();		
			
		}
		
		
	
		public function setOrderTable($ordem) { $this->orderTabela = $ordem; }  
		public function getOrderTable() { return $this->orderTabela; }
		
		public function setFilterTable($filtro) { $this->filtroTabela = $filtro; }  
		public function getFilterTabl() { return $this->filtroTabela; }
		
		public function setFieldList($campo) { $this->campoTexto = $campo; }  
		public function getFieldList() { return $this->campoTexto; }
		
		public function setFieldID($campo) { $this->campoID = $campo; }  
		public function getFieldID() { return $this->campoID; }
		
		public function setTableList($table) { $this->tabela = $table; }  
		public function getTableList() { return $this->tabela; }

		public function setName($nome) { $this->nomeCampo = $name; $this->nomeCampoOld=$nome . "_old"; }  
		public function getName() { return $this->nomeCampo; }
		

		public function setSizeLista($size) { $this->sizeLista = $size; }  
		public function getSizeLista() { return $this->sizeLista; }
		
		public function setWidthLista($valor) { $this->widthLista = $valor; }
		public function getWidthLista() { return $this->widthLista; }
		
		public function setHeightLista($valor) { $this->heightLista = $valor; }
		public function getHeightLista() { return $this->heightLista; }
		
		public function setNomeCampoID($nomeCampoID) { $this->nomeCampoID = $nomeCampoID; }  
		public function getNomeCampoID() { return $this->nomeCampoID; }
		
		public function setClassLista($classe) { $this->classLista = $classe; }
		public function getClassLista() { return $this->classLista; }
		
		public function setValueID($id) { $this->valueID = $id; }
		public function getValueID() { return $this->valueID; }
				

		public function show($inside="")
		{
			$scriptCss=<<<EOT
			#{$this->nomeDiv}
			{
				position:absolute;
				width:500px;
				height:200px;
				padding:0px;
				//display:none;
				margin-top:-1px;
				border-top:0px;
				overflow:hidden;
				border:0px #CCC solid;
				background-color: white;
			}
EOT;
			$this->jQuery->addCSS($scriptCss);
			
			/*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			 JQUERY DE ONCLICK
			-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-*/

			$scriptClick=<<<EOT
			if (e.target.id!="{$this->nomeLista}")
			{					
				$("#{$this->nomeDiv}").fadeOut();
			}
			
			
EOT;
			$this->jQuery->addClickFunction($scriptClick);
			
			/*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			 JQUERY DE ONREADY
			-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-*/
			$scriptReady=<<<EOT
			$("#{$this->nomeDiv}").focusout(function(){
					  jQuery("#{$this->nomeDiv}").fadeOut();
					  if ($("#{$this->nomeCampo}").val().length != 0)
					  {
					  	$("#{$this->nomeCampo}").val( $("#{$this->nomeCampoOld}").val());
					  }
					  else
					  {
					  	$("#{$this->nomeCampoOld}").val("");
					  	$("#{$this->nomeCampoID}").val("0");					  	
					  }
			});
			
			$("#{$this->nomeCampo}").focusout(function(){
					  if ($("#{$this->nomeCampo}").val().length == 0)
					  {
					  	$("#{$this->nomeCampoOld}").val("");
					  	$("#{$this->nomeCampoID}").val("0");					  	
					  }
			});
			
			$("#{$this->nomeCampo}").keypress(function(e)
		  	{
				  //alert(e.keyCode);
				  if (e.keyCode == 13)
				  {
				     setSearch( document.getElementById("{$this->nomeLista}") ,"{$this->nomeCampoID}", "{$this->nomeCampo}");
				     jQuery("#{$this->nomeDiv}").fadeOut();
				  }
				  else
				  {
					//  showResultCliente(document.getElementById("{$this->nomeCampo}").value);
				  }
				  //setClienteSearch( document.getElementById("{$this->nomeLista}") ,"{$this->nomeCampoID}", "{$this->nomeCampo}");
		  	});
		  	
		  	$("#{$this->nomeLista}").keydown(function()
			{					  
				  setSearch( document.getElementById("{$this->nomeLista}") ,"{$this->nomeCampoID}", "{$this->nomeCampo}");
			});
			
			$("#{$this->nomeLista}").keyup(function()
			{					  
				  setSearch( document.getElementById("{$this->nomeLista}") ,"{$this->nomeCampoID}", "{$this->nomeCampo}");
			});
			  
			$("#{$this->nomeCampo}").keydown(function(e)
		  	{
			  //alert(e.keyCode);
			  if (e.keyCode == 38)
			  {
			  	document.getElementById("{$this->nomeLista}").selectedIndex = document.getElementById("{$this->nomeLista}").selectedIndex -1;
			  }
			  if (e.keyCode == 40)
			  {
				  document.getElementById("{$this->nomeLista}").selectedIndex = document.getElementById("{$this->nomeLista}").selectedIndex +1;
			  }
			  if (e.keyCode == 13)
			  {
			     setSearch( document.getElementById("{$this->nomeLista}") ,"{$this->nomeCampoID}", "{$this->nomeCampo}");
			  }
		  	});
		  	
		  	$("#{$this->nomeCampo}").keyup(function(e)
		  	{
			  //alert(e.keyCode);
			  if (e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 13 && e.keyCode != 16 && e.keyCode != 39 && e.keyCode != 37 && e.keyCode != 18 && e.keyCode !=144 && e.keyCode != 20 &&  
			      e.keyCode != 36 && e.keyCode != 35 && e.keyCode != 34 && e.keyCode != 33  && e.keyCode != 17 && e.keyCode != 145 && e.keyCode != 27 && e.keyCode != 93 && e.keyCode != 91 && 
			      e.keyCode != 93  )					  
			  {
				  showResultSearch(document.getElementById("{$this->nomeCampo}").value, $('#{$this->nomeCampoID}').val() );
			  }
		  	});
			
		  	 $("#{$this->nomeLista}").click(function()
			  {					  
				  setSearch( document.getElementById("{$this->nomeLista}") ,"{$this->nomeCampoID}", "{$this->nomeCampo}");
			  });
		  	
EOT;
			$this->jQuery->addReadyFunction($scriptReady);
			
			/*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			 SCRIPT JAVA DE BUSCA 
			 -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-*/
			if (!self::$criouSearch)
			{
				self::$criouSearch = true;
			
				$paramCampoTexto="";				
				if ($this->campoTexto != "") { $paramCampoTexto = "&campoTexto={$this->campoTexto}"; }
				
				$paramCampoID="";
				if ($this->campoID != "") { $paramCampoID = "&campoID={$this->campoID}"; }
				
				$paramTabela="";
				if ($this->tabela != "") { $paramTabela = "&tabela={$this->tabela}"; }						
		
				$paramFiltroTabela="";
				if ($this->filtroTabela != "") { $paramFiltroTabela = "&filtro={$this->filtroTabela}"; }
				
				$paramOrdemTabela="";
				if ($this->orderTabela != "") { $paramOrdemTabela = "&ordem={$this->orderTabela}"; }
								
				
			$scriptFuncao=<<<EOT
			function setSearch(campoSelect, nomeCampoId, nomeCampoNome)
			{
				var campoId = document.getElementById(nomeCampoId);
			    var campoNome = document.getElementById(nomeCampoNome);
			    
			    if ( campoSelect.options.length == 0 || campoNome.value.trim().length == 0 )
				{
			    	campoId.value='0'    	
			    	campoNome.value='';
			    	$("#{$this->nomeCampoOld}").val(campoNome.value);
			    	return;
				}
			
			    if (campoSelect.selectedIndex >= 0)
			    {
					campoId.value = campoSelect.value;;
					campoNome.value = campoSelect.options[campoSelect.selectedIndex].text;
					$("#{$this->nomeCampoOld}").val(campoNome.value);  	  
			    }			    
			    
			}
			
			function showResultSearch(str, cd_usuario) 
			{
			  if (str.length==0) 
			  {	  	
				document.getElementById("{$this->nomeLista}").style.display = 'none';	
				document.getElementById("{$this->nomeDiv}").style.display='none';		
			    return;
			  }
			  xmlhttp.onreadystatechange=function() {
			    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			
			      var listaNome = document.getElementById("{$this->nomeLista}");
				  var resposta=xmlhttp.responseText;
				  
				  //$('#tbCampos').append(resposta);
				  
			      if (resposta == '0')
			      {
			    	  listaNome.style.display='none';    	  
			    	  document.getElementById("{$this->nomeDiv}").style.display='none';
			      }	
			      else
			      {
			    	  listaNome.style.display='';    	  
			    	  document.getElementById("{$this->nomeDiv}").style.display="";
			    	  
			
			    	  listaNome.options.clear
					  var arrSearch=resposta.split("|");
			    	  $('#{$this->nomeLista}').find('option').remove().end();    	  
			
					  for (i=1; i< arrSearch.length ; i++)
					  {		
						  	var arrCampos = arrSearch[i].split("#");
				    	 	var opcaoAdd = document.createElement("option");
				    	 	
				    	 	opcaoAdd.value = arrCampos[0];
							opcaoAdd.text = arrCampos[1];			
							opcaoAdd.setAttribute("class","{$this->classLista}");
							
							
							//opcoes.add(element[,index]
							try
							{
							   //for IE earlier than version 8
								listaNome.add(opcaoAdd, listaNome.options[null]);
							}
							catch (e)
							{
								listaNome.add(option,null);
							}
					  }
			    	  
			      }      
			    }
			  }
			  xmlhttp.open("GET","../lib/ajaxInputSearch.php?q="+str + "&cd_usuario=" + cd_usuario + "{$paramCampoTexto}{$paramCampoID}{$paramTabela}{$paramFiltroTabela}{$paramOrdemTabela}" ,true);
			  xmlhttp.send();
			}
  
			
EOT;
			$this->jQuery->addJavaFunction($scriptFuncao);
			}
						
			parent::show("autocomplete=off");
					 		
			$tamanhos="";
			if ($this->widthLista != "")
			{
				$tamanhos = $tamanhos . "; width: {$this->widthLista} ";
			}
			
			if ($this->heightLista != "")
			{
				$tamanhos = $tamanhos . "; heigh: {$this->heightLista} ";
			}
					
			$valorTexto=parent::getValue();
			echo "<input type=\"hidden\" name = \"{$this->nomeCampoOld}\" id = \"{$this->nomeCampoOld}\" value=\"{$valorTexto}\" >";
			echo "<input type=\"hidden\" name = \"{$this->nomeCampoID}\" id = \"{$this->nomeCampoID}\" value=\"{$this->valueID}\" >";
			echo "<div id=\"{$this->nomeDiv}\" name=\"{$this->nomeDiv}\" style=\"vertical-align: top; text-align: left; ${tamanhos}\" >";					
			echo "<select class=\"{$this->classLista}\"  name=\"{$this->nomeLista}\" id=\"{$this->nomeLista}\" size=\"{$this->sizeLista}\" style=\"text-align: left; ${tamanhos}\" >";					
			echo "</select>";
			echo "</div>";
			echo "<script>";
			echo "document.getElementById('{$this->nomeLista}').style.display = 'none';";
			echo "document.getElementById('{$this->nomeDiv}').style.display='none';";			
			echo "</script>";
		}
		
	}
}
?>
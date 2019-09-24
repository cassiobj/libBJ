<?php 
include "defines.php";
//include "stdObject.php";
include "enum.php";
include "T_FONT.php";
include "T_BORDER.php";
include "T_INPUT.php";

if (!defined('T_BUTTON_H'))
{
	define('T_BUTTON_H', '0');


	class T_BUTTON extends T_INPUT
	{		
		private $value;

		public function __construct($nome="btForm", $texto = "button")
		{
			parent::__construct($nome, "BUTTON");
			$this->setTextAlign("center");
			$this->setValue($texto);
			$this->setSize(0);
			$this->setMaxLength(0);	
						
		}

		public function setSubmitForm($objForm, $link, $funcaoCheck = "checkNada")
		{ 
			
			$funcao="submitForm('" . $objForm->getName() . "', '" . $link  . "', " . $funcaoCheck . ")";
			parent::setFunctionOnClick($funcao);
		}
		
		public function setBackButton()
		{
				
			$funcao="window.history.back()";
			parent::setFunctionOnClick($funcao);
		}
			
	}
}


?>

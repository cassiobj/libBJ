<?php

if (substr($_SERVER['SERVER_ADDR'], 0, 4) != "127." && substr($_SERVER['SERVER_ADDR'], 0, 4) != "192." && $_SERVER['SERVER_ADDR'] != "::1" )
{
    if($_SERVER["HTTPS"] != "on")
    {
    	header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    	exit();
    } 
}

//echo $_SERVER['SERVER_ADDR'];

include "dadosConn.php";
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
include "T_DIVBOOT.php";
include "T_BUTTON.php";
include "T_HEAD.php";
include "T_DATAGRID.php";
include "T_FONT.php";
include "T_IMAGE_BUTTON.php";
include "T_INPUT_SEARCH.php";
include "T_INPUT.php";
include "T_JQUERY.php";
include "T_RADIO.php";
include "T_SESSION.php";
include "T_TABLE_SYS.php";
include "T_TEXT.php";
include "T_TEXTAREA.php";
include "T_TEXTDATA.php";
include "T_NAVBAR.php";
include "T_CARBAR.php";
include "T_CARROSSEL.php";




?>
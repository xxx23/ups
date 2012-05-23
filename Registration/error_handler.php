<?php
/***
FILE:   error_handler.php
DATE:   2006/11/26
AUTHOR: zqq

錯誤處理
**/

set_error_handler('error_handler', E_ALL);

function error_handler($errNo, $errStr, $errFile, $errLine)
{
	if(ob_get_length())
		ob_clean();
	$error_message = 'ERROR: ' . $errNo . chr(10) . 'TEXT: ' . $errStr . chr(10) . 'LOVATION: ' . $errFile . ',line' . $errLine;	
	//echo $error_message;
	//exit;
}

?>
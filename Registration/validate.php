<?php
/***
FILE:   validate.php
DATE:   2006/11/26
AUTHOR: zqq

驗證的php檔
**/
	
session_start();
require_once ('../config.php');
require_once ('error_handler.php');
require_once ('validate.class.php');
global $DB_CONN;
global $PERSONAL_PATH;
//new
$validator = new Validate($DB_CONN,$PERSONAL_PATH);
	
// 使用驗證的方式 php or AJAX
$validationType = '';

if( isset($_GET['validationType'])){
	$validationType = $_GET['validationType'];
}

//PHP 驗證[步驟一] 註冊帳號 內容的正確性之後導向不同頁面
if( $validationType == 'php'){
	//
	header("Location:".$validator->ValidatePHP());
}
//AJAX
else{
	$response = 
		'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.
		'<response>'.
			'<result>';
	if(isset($_POST['fieldID']) && ($_POST['fieldID'] == 'txtCkPassword'))
		$response .= $validator->ValidateAJAX2($_POST['inputValue'], $_POST['inputValue2'], $_POST['fieldID']);
	else
		$response .= $validator->ValidateAJAX($_POST['inputValue'], $_POST['fieldID']);
	$response .=	'</result>'.
			'<fieldid>'.
				htmlentities($_POST['fieldID']).
			'</fieldid>'.
			'<msg>'.
				'*'.$validator->getErrorMsg().'*'.
			'</msg>'.
		'</response>';		
		//產生response
		if(ob_get_length()){
			ob_clean();
		}
	header('Content-Type: text/xml');
	echo $response;	
}
?>

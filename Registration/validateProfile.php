<?php
/***
FILE:   validateProfile.php
DATE:   2006/11/26
AUTHOR: zqq

驗證的php檔
**/
	session_start();
	require_once ('../config.php');
	//require_once ('error_handler.php');
	require_once ('validateProfile.class.php');
	global $DB_CONN;

	$validator = new ValidateProfile($DB_CONN);

	// 使用驗證的方式 php or AJAX
	$validationType = '';
	$prefix ='';
	if( isset($_GET['validationType'])){
		$validationType = $_GET['validationType'];
	}
	if( isset($_GET['prefix'])){
		$prefix = $_GET['prefix'];
	}
	//PHP
	if( $validationType == 'php'){
		header("Location:".$validator->ValidatePHP());
	}
	//AJAX
	else if( $prefix != ''){
		$address = $validator->findSimAddr( $prefix );
		for($v = current($address); $v != FALSE; $v=next($address) ){
			printf("%s\n",$v);
		}
	}//AJAX
	else{
		$response = 
			'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.
			'<response>'.
				'<result>'.
					$validator->ValidateAJAX($_POST['inputValue'], $_POST['fieldID']).
				'</result>'.
				'<fieldid>'.
					$_POST['fieldID'].
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

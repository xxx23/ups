<?php
/***
FILE:   
DATE:   
AUTHOR: zqq

驗證的php檔
**/	
	session_start();
	require_once ('../config.php');
	require_once ('validate_begin_course.class.php');
	$validator = new ValidateBeginCourse($DB_CONN);
    
    // 使用驗證的方式 php or AJAX
	$validationType = '';
	$prefix ='';
	$target = '';
	if( isset($_GET['validationType'])){
		$validationType = $_GET['validationType'];
	}
	if( isset($_GET['target'])){
		$target = $_GET['target'];
	}	
	if( isset($_GET['prefix'])){
		$prefix = $_GET['prefix'];
	}
	$attribute = $_GET['attribute'];
    //PHP
    if( $validationType == 'php'){
	  $mystr= $validator->ValidatePHP($attribute);
	  header("Location:".$mystr);
	}
	//AJAX
	else if( $prefix != ''){
		switch( $target ){			
			case 'begin_course_name'	:
				$outputData = $validator->findCourseName( $prefix );
				break;
		}
		
		for($v = current($outputData); $v != FALSE; $v=next($outputData) ){
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

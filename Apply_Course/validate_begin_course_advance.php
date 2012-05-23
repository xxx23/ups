<?php
/***
FILE:   
DATE:   
AUTHOR: zqq

驗證的php檔
**/	
	//init
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	session_start();
	require_once ('validate_begin_course_advance.class.php');
	$validator = new ValidateBeginCourseAdvance($DB_CONN);
	
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
		
	//PHP
	if( $validationType == 'php'){
		header("Location:".$validator->ValidatePHP());
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
	}
	//AJAX
	else if( $_GET[target] == 'course_classify'){
		$response = $validator->queryCourseClassify($_GET['nodeValue'], $_GET['level']);
		$doc = new DOMDocument('1.0','UTF-8');
		$doc->formatOutput = true;
		$root = $doc->createElement('all');
		$root = $doc->appendChild($root);		
		switch($_GET['level']){
			case '1':
			//level 2
			for($j=0; $j < 3;$j++){
				$select = $doc->createElement('select');
				$select = $root->appendChild($select);
				for($i=0; $i < count($response[$j]);$i++){			
					$title = $doc->createElement('option');
					$title = $select->appendChild($title);				
					$cd = $doc->createElement('course_classify_cd');
					$cd = $title->appendChild($cd);				
					$cd_text = $doc->createTextNode($response[$j][$i]['course_classify_cd']);
					$cd_text = $cd->appendChild($cd_text);				
					$name = $doc->createElement('course_classify_name');
					$name = $title->appendChild($name);		
					$name_text = $doc->createTextNode($response[$j][$i]['course_classify_name']);
					$name_text = $name->appendChild($name_text);													
				}
			}			
			break;
			
			case '2':
			for($j=0; $j < 2; $j++){
				$select = $doc->createElement('select');
				$select = $root->appendChild($select);
				for($i=0; $i < count($response[$j]);$i++){			
					$title = $doc->createElement('option');
					$title = $select->appendChild($title);				
					$cd = $doc->createElement('course_classify_cd');
					$cd = $title->appendChild($cd);				
					$cd_text = $doc->createTextNode($response[$j][$i]['course_classify_cd']);
					$cd_text = $cd->appendChild($cd_text);				
					$name = $doc->createElement('course_classify_name');
					$name = $title->appendChild($name);		
					$name_text = $doc->createTextNode($response[$j][$i]['course_classify_name']);
					$name_text = $name->appendChild($name_text);													
				}
			}			
			break;
			
			case '3':
			for($j=0; $j < 1; $j++){
				$select = $doc->createElement('select');
				$select = $root->appendChild($select);
				for($i=0; $i < count($response[$j]);$i++){			
					$title = $doc->createElement('option');
					$title = $select->appendChild($title);				
					$cd = $doc->createElement('course_classify_cd');
					$cd = $title->appendChild($cd);				
					$cd_text = $doc->createTextNode($response[$j][$i]['course_classify_cd']);
					$cd_text = $cd->appendChild($cd_text);				
					$name = $doc->createElement('course_classify_name');
					$name = $title->appendChild($name);		
					$name_text = $doc->createTextNode($response[$j][$i]['course_classify_name']);
					$name_text = $name->appendChild($name_text);													
				}
			}				
			break;
		}
		$XML_Document =  $doc->saveXML();
		header('Content-Type: text/xml');  //這行一定要加 orz
		echo $XML_Document;
	}	
	//AJAX
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
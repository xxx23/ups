<?php
/*
更新textArea的內容到資料庫
*/
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	
	$targetTextArea = $_POST['target'];
	$content = $_POST['content'];
	//如果不為空 更新 
	if($targetTextArea != ''){
		//取出要更改的名子
		$sql_field = explode('-',$targetTextArea);		
		$sql = "UPDATE course_basic SET ".$sql_field[1]."='".$content."' WHERE course_cd=".$_SESSION[cur_course_cd];
		//echo $sql;
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
	}
	//成功 輸出寫入的字串
	//echo $content;
	$doc = new DOMDocument('1.0','UTF-8');
	$doc->formatOutput = true;
	
	$response = $doc->createElement('response');
	$response = $doc->appendChild($response);
	
	$id	  	= $doc->createElement('id');			
	$id->appendChild($doc->createTextNode('div_' . $sql_field[1]));
	//$content_node = $doc->createElement('content');			
	//$content_node->appendChild($doc->createTextNode($content));	
	//echo $content;
	$response->appendChild($id);
	//$response->appendChild($content_node);
	$XML_Document =  $doc->saveXML();
	header('Content-Type: text/xml');  //這行一定要加 orz
	echo $XML_Document;
?>

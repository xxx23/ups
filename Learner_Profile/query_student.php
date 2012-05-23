<?php
/***
FILE:  
DATE:   2006/11/26
AUTHOR: zqq

驗證的php檔
**/
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");


	switch($_GET[action]){
		case 'personal_name':
			$sql = "SELECT r.login_id, p.personal_name FROM register_basic r, personal_basic p WHERE r.personal_id=p.personal_id and p.personal_name like '".$_GET[prefix]."%' ";
			
			$res = $DB_CONN->query($sql);
			while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
				printf("%s\n", $row[login_id]."-".$row[personal_name] );
			}			
			break;
		case 'login_id';
			$sql = "SELECT r.login_id, p.personal_name FROM register_basic r, personal_basic p WHERE r.personal_id=p.personal_id and r.login_id like '".$_GET[prefix]."%' ";
			
			$res = $DB_CONN->query($sql);
			while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
				printf("%s\n", $row[login_id]."-".$row[personal_name] );
			}	
			
			break;
		default:break;	
	
	}


?>
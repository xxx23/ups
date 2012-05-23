<?php
/*******************************************************/
/* id: textbook_frame.php 2007/11/12 by hushpuppy Exp. */
/* function: 教材另開新分頁		               */
/*******************************************************/

include "../config.php";
require_once("./lib/textbook_func.inc");

	$login_id = 'guest'; 
	
	global $DB_CONN, $HOME_PATH;
	$isExist = $DB_CONN->getOne("select count(*) from `register_basic` where login_id='$login_id' and login_state='1';");
	
	if($isExist != 1)
		loginFail(0);
	$sql = "SELECT personal_id, role_cd FROM register_basic WHERE login_id = '$login_id' AND validated='1'";
	$res = db_query($sql);
	if( ($res->numRows()) == 0)//帳號不核准使用
	{
		//導向回首頁
		loginFail(2);
	}
	else{
	
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		$personal_id = $row[personal_id];
		$role_cd = $row[role_cd];
	
	}	
		
	//註冊session
	session_start();
	$_SESSION['personal_id'] = $personal_id;
	$_SESSION['role_cd'] = $role_cd;
	$_SESSION['template_path'] = $HOME_PATH . "themes/";
    $_SESSION['template'] = "IE2";
    $_SESSION['begin_course_cd'] = '202';

	//setMenu($personal, $role_cd);
/*
	//查出IP
	$ip = getenv ( "REMOTE_ADDR" );
	if ( $ip == "" )
		$ip = $HTTP_X_FORWARDED_FOR;
	if ( $ip == "" )
		$ip = $REMOTE_ADDR;		
	//-------------------------------------------------------
	// 登入後會將這個user 記在 online_number 
	if( isset($_SESSION['online_cd ']) ){ //同一個來源
		$sql = "UPDATE online_number SET status='重新登入中', idle='".date('U')."' WHERE online_cd='".$_SESSION['online_cd ']."'";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());			
	}
	else{ 
		$sql = "INSERT INTO online_number (personal_id, host, time, idle, status) VALUES ('".$personal_id."','".$ip."','".date("U")."','".date("U")."','登入系統中')";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$sql = "SELECT online_cd FROM online_number WHERE personal_id='".$personal_id."' and host='".$ip."'";
		$online_cd = $DB_CONN->getOne($sql);
		$_SESSION['online_cd'] = $online_cd;						
	}
	//echo $sql;	
	//--------------------------------------------------------
	$_SESSION['personal_ip'] = $ip;	
 */	

	//學習追蹤-登入系統
//	LEARNING_TRACKING_start(1, 1, -1, $_SESSION['personal_id']);


    $Content_cd = $_GET['content_cd'];
    if($Content_cd != '13371')
    {
        die();
    }
//		    die('123');

//checkMenu("/Teaching_Material/textbook_preview.php");
//學習紀錄~~~
//LEARNING_TRACKING_start(4, 1, $_SESSION['begin_course_cd'], $_SESSION['personal_id']);


$sql = "select * from class_content where content_cd = '$Content_cd' order by cast(menu_parentid as unsigned) asc, seq asc;";
$AddNode = buildTreeStructure($sql, $Content_cd);
//更變為瀏覽而不是編輯
$AddNode = str_replace("tea_","stu_",$AddNode);

$smtpl = new Smarty;
$smtpl->assign("Content_cd",$Content_cd);

$Script_path = $WEBROOT . $JAVASCRIPT_PATH ;
$smtpl->assign("script_path", $Script_path);

$smtpl->assign("WEBROOT", $WEBROOT);
//print $AddNode;
//build tree
$smtpl->assign("addNode", $AddNode); 
//assign "課程科目教材編號" for inserting node
$smtpl->assign("Content_cd", $Content_cd);  

assignTemplate($smtpl, "/teaching_material/textbook_frame.tpl");

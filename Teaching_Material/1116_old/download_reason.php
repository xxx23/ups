<?php
require_once("../config.php");
include('../session.php');
$smtpl = new Smarty;
$personal_id=$_SESSION["personal_id"];
$sql="select personal_name,identify_id,organization from  personal_basic where personal_id='$personal_id'";
$result=db_getRow($sql);

$sql="select login_id from register_basic where personal_id='$personal_id'";
$login_id=db_getOne($sql);
$personal_name=$result["personal_name"];
$identify_id=$result["identify_id"];
$organization=$result["organization"];

$share = $_GET['share'];
	$share = $share!='' ? $share : '0';
if($share == 1) // ±Ð§÷¤À¨É
	$_SESSION["content_cd"] = $_GET['content_cd'];
	
$smtpl->assign("share",$share); 

$smtpl->assign("login_id",$login_id); 
$smtpl->assign("personal_id",$personal_id); 
$smtpl->assign("personal_name",$personal_name);
$smtpl->assign("identify_id",$identify_id); 
$smtpl->assign("organization",$organization);
assignTemplate($smtpl, "/teaching_material/download_reason.tpl");
?>

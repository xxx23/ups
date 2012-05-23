<?php
/****************************************************/
/* id:redirect_file.php v1.0 2007/4/21 by hushpuppy */
/* function: 進入本章教材,編輯內容 		    */
/****************************************************/
include "../config.php";
require_once("../session.php");
require_once("./lib/textbook_func.inc");

checkMenu("/Teaching_Material/textbook_manage.php");
$Begin_course_cd = $_SESSION['begin_course_cd']; 	//取得開課編號

//不管在個人化頁面或課程頁面中，進入授課教材管理時，僅會編輯到屬於"自己"的教材，因此記在session變數中
//在課程頁面時，有可能要存取"本課程"(不一定屬於個人)所用的教材，路徑中的personal_id將不同，以此變數區隔。
//因此，在進入：textbook_manage_personal.php、textbook_manage.php時，註冊為1
//在進入edit_textbook_current.php、textbook_preview.php時，註冊為0
$_SESSION['self_textbook'] = '0';

//$Teacher_cd = $_SESSION['personal_id'];
$Teacher_cd = getTeacherId();

//取得本課程現用的教材編號
$sql = "select content_cd from class_content_current where begin_course_cd = $Begin_course_cd;";
$Content_cd = $DB_CONN->getOne($sql);
if(PEAR::isError($Content_cd))	die($Content_cd->userinfo);

if(!isset($Content_cd) || $Content_cd == 0){
	echo "您尚未選取本課程教材，請由\"授課教材管理\"選取。";
	echo "或按<font color=\"red\"><a href=./textbook_manage.php>這裡</a> </font>指定教材。";
}
else{
    header("Location: ./tea_loadTreeFromDB.php?content_cd=$Content_cd");
}

?>

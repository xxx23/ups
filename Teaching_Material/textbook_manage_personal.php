<?php
/* id: textbook_manage.php 2007/3/12 v1.0 by hushpuppy Exp. */
/* function: 教師教材管理頁面 */
include "../config.php";
require_once("../session.php");
require_once("./lib/textbook_mgt_func.inc");
require_once("./lib/textbook_func.inc");

checkMenu("/Teaching_Material/textbook_manage.php");

global $Teacher_cd, $Begin_course_cd, $Course_cd, $Textbook_name, $Difficulty, $Attributes, $IsPublic;
global $smtpl;// for test
global $DATA_FILE_PATH, $MEDIA_FILE_PATH, $COURSE_FILE_PATH;

$Teacher_cd = $_SESSION['personal_id'];
$Course_cd = $_SESSION['course_cd'];

$Textbook_name = $_POST['textbook_name'];
$Difficulty = $_POST['difficulty'];
$Attributes = $_POST['attributes'];
$IsPublic = $_POST['isPublic'];
$M_Content_cd = $_POST['modify_content_cd']; //modify時，擷取的content_cd
$C_Content_cd = $_POST['create_content_cd'];

//不管在個人化頁面或課程頁面中，進入授課教材管理時，僅會編輯到屬於"自己"的教材，因此記在session變數中
//在課程頁面時，有可能要存取"本課程"(不一定屬於個人)所用的教材，路徑中的personal_id將不同，以此變數區隔。
//因此，在進入：textbook_manage_personal.php、textbook_manage.php時，註冊為1
//在進入edit_textbook_current.php、textbook_preview.php時，註冊為0
$_SESSION['self_textbook'] = '1';

$smtpl = new Smarty;

/* modify by zoe
 * 暫時把 teacher_cd 以及 begin_course_cd 傳給教材上傳用的php 
 * 也許有一天會改掉
$smtpl->assign("teacher_cd",$Teacher_cd);
$smtpl->assign("begin_course_cd",$_SESSION['begin_course_cd']);
 */
//教材新增
if(isset($_POST['submit_create'])){
  $tmp = strpos($Textbook_name, "/");
  if(is_numeric(strpos($Textbook_name, "/")) || is_numeric(strpos($Textbook_name, "\\")) ){
      echo "<script>alert(\"警告!你所輸入教材名稱包含不合法字元!\");</script>";
  }
  else{
	$status_str = "教材新增成功!";
	$t = create_textbook();
	if($t == 0)
		$smtpl->assign("status","教材名稱重複! 請重新輸入!");
	else
	  $smtpl->assign("status","\"".$Textbook_name."\"".$status_str);
  }
}

//新增並進入編輯教材
else if(isset($_POST['create_and_edit'])){
	$t = create_textbook();
	if($t == 0)
		$smtpl->assign("status","教材名稱重複! 請重新輸入!");
	else
		header("Location: ./tea_loadTreeFromDB.php?content_cd=$C_Content_cd");
}
//修改教材名稱屬性
else if(isset($_POST['submit_modify'])){
	$status_str = "教材屬性修改成功!";
	$t = modify_textbook();
	if($t == 0)
		$smtpl->assign("status","教材名稱重複! 請重新修改!");
	else
		$smtpl->assign("status","\"".$Textbook_name."\"".$status_str);
}
//修改並進入編輯教材內容
else if(isset($_POST['modify_and_edit'])){
	$t = modify_textbook();
	if($t == 0)
		$smtpl->assign("status","教材名稱重複! 請重新修改!");
	else
		//$smtpl->assign("status","asdf");
		header("Location: ./tea_loadTreeFromDB.php?content_cd=$M_Content_cd");
}

//刪除整份教材
else if(isset($_POST['del_textbook'])){	
	$status_str = "教材刪除成功!";
	$Content_cd = $_POST['del_textbook_this'];
	$t = delete_textbook();
	$smtpl->assign("status","\"".$t."\"".$status_str);
}


	//$smtpl->assign("is_course_master",1);
	//找出這位教師的所有教材
	$sql = "select * from course_content where teacher_cd = '$Teacher_cd;'";
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->getMessage());

	$array = array('0' => '--');
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$i = $row['content_cd'];
		$array[$i] = $row['content_name'];
	}
	$smtpl->assign("textbook_opt",$array);
	$smtpl->assign("textbook_slt",1);
	$smtpl->assign("tbArray",$array);

//ftp路徑
$sql = "select login_id from register_basic where personal_id = '$Teacher_cd'";
$login_id = $DB_CONN->getOne($sql);

if(PEAR::isError($login_id))	die($login_id->userinfo);
$ftp_path = "ftp://".$login_id."@".$FTP_IP.":".$FTP_PORT."/textbook/";

$smtpl->assign("ftp_ip",$FTP_IP);
$smtpl->assign("ftp_port",$FTP_PORT);
$smtpl->assign("ftp_path",$ftp_path);
$smtpl->assign("tpl_path",$tpl_path);
assignTemplate($smtpl,"/teaching_material/textbook_manage_personal.tpl");
?>

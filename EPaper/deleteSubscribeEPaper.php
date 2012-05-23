<?
/*
DATE:   2007/04/06
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$absoluteURL = $HOMEURL . "EPaper/";

	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色

	$begin_course_cd = $_POST['begin_course_cd'];
	
	//從Table person_epaper中刪除資料
	$sql = "DELETE FROM person_epaper WHERE personal_id=$personal_id AND begin_course_cd=$begin_course_cd";
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	header("Location: showSubscribeEPaperList.php")
?>

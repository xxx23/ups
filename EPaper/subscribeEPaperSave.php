<?
/*
DATE:   2007/04/04
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH . $CSS_VERSION_PATH;
	$absoluteURL = $HOMEURL . "EPaper/";

	session_start();
	$personal_id = $_SESSION['personal_id'];				//取得個人編號
	$role_cd = $_SESSION['role_cd'];						//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];		//取得課程代碼

	$isSubscribe = $_POST["isSubscribe"];
	
	if($isSubscribe == 1)
	{
		$sql = "INSERT INTO person_epaper 
								(
									personal_id, 
									begin_course_cd, 
									if_subscription
								) VALUES (
									$personal_id, 
									$begin_course_cd,
									'Y'
								)";
	}
	else
	{
		$sql = "DELETE FROM person_epaper 
							WHERE 
								personal_id=$personal_id AND 
								begin_course_cd=$begin_course_cd";
	}
	$sth = $DB_CONN->prepare($sql);
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());

	
	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	$title = "訂閱電子報";
	
	if($isSubscribe == 1)	$content = "訂閱成功";
	else					$content = "取消訂閱成功";

	$tpl->assign("title", $title);
	$tpl->assign("content", $content);
	
	assignTemplate($tpl, "/epaper/message.tpl");
?>
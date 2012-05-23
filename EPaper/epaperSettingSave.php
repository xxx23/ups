<?
/*
DATE:   2007/04/10
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH . $CSS_VERSION_PATH;
	$absoluteURL = $HOMEURL . "EPaper/";	


	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼
	
	if($role_cd == 0)//系統管理者
	{
		$begin_course_cd = -1;
	}

	$epaper_cd = $_POST["epaper_cd"];
	$if_auto = $_POST["if_auto"];
	
	//新增課程電子報設定
	$sql = "UPDATE e_paper 
			SET if_auto = '$if_auto' 
			WHERE epaper_cd = $epaper_cd";
	$sth = $DB_CONN->prepare($sql);
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	$title = "設定電子報";
	$content = "修改成功!!";
	
	$tpl->assign("title", $title);
	$tpl->assign("content", $content);
	
	assignTemplate($tpl, "/epaper/message.tpl");
?>
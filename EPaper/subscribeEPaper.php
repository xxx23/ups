<?
/*
DATE:   2007/04/04
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "EPaper/";

	session_start();
	$personal_id = $_SESSION['personal_id'];				//取得個人編號
	$role_cd = $_SESSION['role_cd'];						//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];		//取得課程代碼

	
	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	//從Table person_epaper判斷是否有訂閱課程電子報
	$sql = "SELECT * FROM person_epaper 
					WHERE 
						begin_course_cd=$begin_course_cd AND 
						personal_id=$personal_id";	
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	
	$resultNum = $res->numRows();
	
	if($resultNum > 0)	{	$isSubscribe = 1;	}
	else				{	$isSubscribe = 0;	}
	$tpl->assign("isSubscribe", $isSubscribe);
	$tpl->assign("role_cd",$role_cd);
	assignTemplate($tpl, "/epaper/subscribeEPaper.tpl");
?>

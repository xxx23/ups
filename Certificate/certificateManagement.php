<?
/*
DATE:   2007/10/19
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "Certificate/";
	
	
	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_GET['begin_course_cd'];		//取得課程編號
	
	$backPage = $_GET['incomingPage'];					//取得上一頁
	
	
	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	$tpl->assign("begin_course_cd", $begin_course_cd);
	
	$tpl->assign("backPage", $backPage);
	
	//取得menu
	$menu = $_GET['menu'];	
	if( isset($menu) == false)	$menu = 1;
	
	switch($menu)
	{	
	case 1:	$tpl->assign("content", "setupCertificate.php?begin_course_cd=$begin_course_cd");	break;
	case 2:	$tpl->assign("content", "printCertificate.php?begin_course_cd=$begin_course_cd");	break;
	default:$tpl->assign("content", "");	break;
	}


	//目前的頁面
	$tpl->assign("currentPage", "certificateManagement.php");
	
	assignTemplate($tpl, "/certificate/certificateManagement.tpl");
?>

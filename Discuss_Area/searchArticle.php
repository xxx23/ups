<?
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "Discuss_Area/";


	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼
	
	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	//目前的頁面
	$tpl->assign("currentPage", "searchArticle.php");
	
	if(isset($isShowSmartyTemplate) == 0)	$isShowSmartyTemplate = 1;
	
	if($isShowSmartyTemplate == 1)	assignTemplate($tpl, "/discuss_area/searchArticle.tpl");
?>

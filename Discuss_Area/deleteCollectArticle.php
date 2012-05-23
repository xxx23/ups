<?
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");
	
	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_POST['begin_course_cd'];		//取得課程代碼
	$discuss_cd = $_POST['discuss_cd'];					//取得討論區編號
	$discuss_content_cd = $_POST['discuss_content_cd'];	//取得文章編號
	$reply_content_cd = $_POST['reply_content_cd'];		//取得回覆文章編號

	//從Table discuss_hoarding刪除被收藏的回覆文章
	$sql = "DELETE FROM discuss_hoarding WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd AND discuss_content_cd=$discuss_content_cd AND reply_content_cd=$reply_content_cd AND personal_id=$personal_id";	
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	header("Location: showCollectArticleList.php");
?>

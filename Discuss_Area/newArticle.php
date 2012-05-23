<?
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "Discuss_Area/";

	session_start();
	$personal_id = $_SESSION['personal_id'];				//取得個人編號
	$role_cd = $_SESSION['role_cd'];						//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];		//取得課程代碼
	$discuss_cd = $_SESSION['discuss_cd'];					//取得討論區編號
	$discuss_content_cd = $_SESSION['discuss_content_cd'];	//取得文章編號
	$reply_content_cd = $_GET['reply_content_cd'];			//取得回覆文張編號

	$behavior = $_GET['behavior'];						//取得行為
	$type = $_GET['type'];

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	$tpl->assign("reply_content_cd", $reply_content_cd);
	
	$tpl->assign("behavior", $behavior);
	$tpl->assign("type", $type);

	//目前的Action
	$action = $_GET['action'];
	if( isset($action) == false)	$action = "new";
	$tpl->assign("action", $action);


	if($action == "reply")
	{
		//action為reply時	//回覆文章

		//從Table discuss_content搜尋某篇回復的文章
		$sql = "SELECT * FROM discuss_content WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd AND discuss_content_cd=$discuss_content_cd AND reply_content_cd=$reply_content_cd";	
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
	
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		
		//對discuss_title作處理
		$discuss_title = "RE:" . $row[discuss_title];
		
		//對content_body作處理
		$content_body = ">" . str_replace("\n", "\n>", $row[content_body]) . "\n";
		
		//輸出discuss_title
		$tpl->assign("discuss_title", $discuss_title);
	//	$tpl->assign("content_body",$content_body);
	}
	
	//從Table personal_basic搜尋角色的簽名檔,放到content_body上
	$sql = "SELECT * FROM personal_basic WHERE personal_id=$personal_id";	
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());

	$res->fetchInto($row, DB_FETCHMODE_ASSOC);

	if($row[signature] != "")
	{
		$content_body = $content_body ."\n\n\n--\n" . $row[signature];
	}

	//輸出content_body
	$tpl->assign("content_body", $content_body);

	//目前的頁面
	$tpl->assign("currentPage", "newArticle.php");
	
	assignTemplate($tpl, "/discuss_area/newArticle.tpl");
?>

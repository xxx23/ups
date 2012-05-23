<?
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");


	
	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_GET['begin_course_cd'];		//取得課程代碼
	$discuss_cd = $_GET['discuss_cd'];					//取得討論區編號
	$discuss_content_cd = $_GET['discuss_content_cd'];	//取得文章編號
	$reply_content_cd = $_GET['reply_content_cd'];		//取得回覆文章編號
	
	$behavior = $_GET['behavior'];						//取得行為
	
    $action = $_GET['action'];							//取得action
    $type = $_GET['type'];
	
	$message = $_GET['message'];						//取得訊息	

	print_r($discuss_content_cd);
		
	//註冊課程代碼到SESSION	
	if( isset($begin_course_cd) == true)	$_SESSION['begin_course_cd'] = $begin_course_cd;
	else									$begin_course_cd = $_SESSION['begin_course_cd'];
	
	//註冊討論區編號到SESSION	
	if( isset($discuss_cd) == true)	$_SESSION['discuss_cd'] = $discuss_cd;
	else							$discuss_cd = $_SESSION['discuss_cd'];
	
	//註冊文章編號到SESSION	
	if( isset($discuss_content_cd) == true)	$_SESSION['discuss_content_cd'] = $discuss_content_cd;
	else									$discuss_content_cd = $_SESSION['discuss_content_cd'];
	
	//設定reply_content_cd的值
	if( isset($reply_content_cd) == false)	$reply_content_cd = 1;
	
	
	//增加某篇回復文章的瀏覽次數
	$sql = "SELECT * FROM discuss_content WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd AND discuss_content_cd=$discuss_content_cd AND reply_content_cd=$reply_content_cd";	
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$replyNum = $res->numRows();
	if($replyNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		
		$viewed = $row[viewed];
		
		$viewed++;
		
		
		//更新資料到Table discuss_info
		$sql = "UPDATE discuss_content SET viewed='$viewed' WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd AND discuss_content_cd=$discuss_content_cd AND reply_content_cd=$reply_content_cd";
		$sth = $DB_CONN->prepare($sql);
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());
	}
	
	//增加整個文章主題的瀏覽次數
	$sql = "SELECT * FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd AND discuss_content_cd=$discuss_content_cd";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$articleNum = $res->numRows();
	if($articleNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		
		$viewed = $row[viewed];
		
		$viewed++;
		
		//更新資料到Table discuss_subject
		$sql = "UPDATE discuss_subject SET viewed='$viewed' WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd AND discuss_content_cd=$discuss_content_cd";
		$sth = $DB_CONN->prepare($sql);
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());
	}	
	
	header("Location: showArticle.php?behavior=$behavior&reply_content_cd=$reply_content_cd&message=$message&action=$action&type=$type");
	
?>

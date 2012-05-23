<?
/*
DATE:   2007/01/17
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");

	session_start();
	$personal_id = $_SESSION['personal_id'];				//取得個人編號
	$role_cd = $_SESSION['role_cd'];						//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];		//取得課程代碼
	$discuss_cd = $_SESSION['discuss_cd'];					//取得討論區編號
	$discuss_content_cd = $_SESSION['discuss_content_cd'];	//取得文章編號
	
	$reply_content_cd = $_POST['reply_content_cd'];			//取得回覆文章編號
	
	
	//增加這篇回覆文章的瀏覽次數
	//從Table discuss_content取出資料
	$sql = "SELECT * FROM discuss_content WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd AND discuss_content_cd=$discuss_content_cd AND reply_content_cd=$reply_content_cd";	
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	
	$replyNum = $res->numRows();
	if($replyNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);

		$viewNum = $row[viewed];
		
		//增加瀏覽的次數
		$viewNum++;
		$sql = "UPDATE discuss_content SET viewed=$viewNum WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd AND discuss_content_cd=$discuss_content_cd AND reply_content_cd=$reply_content_cd";
		$sth = $DB_CONN->prepare($sql);
		$DB_CONN->execute($sth);
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
		$sql = "UPDATE discuss_subject SET viewed=$viewed WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd AND discuss_content_cd=$discuss_content_cd";
		$sth = $DB_CONN->prepare($sql);
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());
	}	


	//產生AJAX Reponse
	$response = 
			"<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>
			<response>
				<reply_content_cd>$reply_content_cd</reply_content_cd>
				<viewNum>$viewNum</viewNum>
			</response>";
	
	header('Content-Type: text/xml');
	echo $response;	
?>

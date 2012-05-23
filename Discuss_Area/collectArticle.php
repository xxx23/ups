<?
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");


	session_start();
	$personal_id = $_SESSION['personal_id'];				//取得個人編號
	$role_cd = $_SESSION['role_cd'];						//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];		//取得課程代碼
	$discuss_cd = $_SESSION['discuss_cd'];					//取得討論區編號
	$discuss_content_cd = $_SESSION['discuss_content_cd'];	//取得文章編號
	$reply_content_cd = $_GET['reply_content_cd'];			//取得回覆文章編號
	
	$behavior = $_GET['behavior'];							//取得行為
	
	$target = $_GET['target'];								//取得要收藏的目標
	
	if($target == "oneReply")
	{
		//收藏文章到Table discuss_hoarding
		collectOneReply($DB_CONN, $begin_course_cd, $discuss_cd, $discuss_content_cd, $reply_content_cd, $personal_id);
	}
	else if($target == "oneTopic")
	{
		//收藏整個主題的文章
	
		//從Table discuss_content取得整個主題所有的文章
		$sql = "SELECT * FROM discuss_content WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd AND discuss_content_cd=$discuss_content_cd ORDER BY reply_content_cd ASC";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
	
		$replyNum = $res->numRows();
		if($replyNum > 0)
		{
			$rowCounter = 0;
		
			//取出所有的資料
			while($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{	
				$replyData[$rowCounter] = $row;
				
				$rowCounter++;
			}
			$replyDataNumber = $rowCounter;
	
			for($replyDataCounter=0; $replyDataCounter<$replyDataNumber; $replyDataCounter++)
			{
				$reply_content_cd_tmp = $replyData[$replyDataCounter][reply_content_cd];
				
				//收藏文章到Table discuss_hoarding
				collectOneReply($DB_CONN, $begin_course_cd, $discuss_cd, $discuss_content_cd, $reply_content_cd_tmp, $personal_id);
			}
		}
	}

	$message = "CollectSuccess";

	header("Location: ArticleList_intoArticle.php?behavior=$behavior&discuss_content_cd=$discuss_content_cd&reply_content_cd=$reply_content_cd&message=$message");
	
/**********************************************************************************/
	
	function collectOneReply($DB_CONN, $begin_course_cd, $discuss_cd, $discuss_content_cd, $reply_content_cd, $personal_id)
	{	
		//從Table discuss_hoarding判斷是否收藏過這篇回覆的文章
		$sql = "SELECT * FROM discuss_hoarding WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd AND discuss_content_cd=$discuss_content_cd AND reply_content_cd=$reply_content_cd AND personal_id=$personal_id";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
	
		$replyNum = $res->numRows();
		if($replyNum == 0)
		{
			//尚未收藏這篇回覆的文章
		
			//新增資料到Table discuss_hoarding
			$sql = "INSERT INTO discuss_hoarding 
							(	begin_course_cd, 
								discuss_cd, 
								discuss_content_cd, 
								reply_content_cd, 
								personal_id
							) VALUES (
								$begin_course_cd,
								$discuss_cd,
								$discuss_content_cd,
								$reply_content_cd,
								$personal_id
							)";
			$sth = $DB_CONN->prepare($sql);
			$res = $DB_CONN->execute($sth);
			if (PEAR::isError($res))	die($res->getMessage());
		}
	}
?>

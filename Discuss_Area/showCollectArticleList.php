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


	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	$tpl->assign("isDeleteOn", 1);	//是否允許刪除
	
	//從Table discuss_content搜尋個人收藏的所有的文章, 依照回覆的日期做遞減排序
	$sql = "SELECT * FROM discuss_hoarding A, discuss_content B WHERE 
						A.personal_id = $personal_id AND 
						A.begin_course_cd = B.begin_course_cd AND 
						A.discuss_cd = B.discuss_cd AND 
						A.discuss_content_cd = B.discuss_content_cd AND 
						A.reply_content_cd = B.reply_content_cd 
					ORDER BY B.d_reply DESC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	
	$replyNum = $res->numRows();
	$tpl->assign("replyNum", $replyNum);
	
	if($replyNum > 0)
	{
		$rowCounter = 0;
	
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$replyData[$rowCounter] = $row;
			
			$rowCounter++;
		}
		$replyDataNumber = $rowCounter;
		
		$replyListCounter = 0;
		for($replyDataCounter = 0; $replyDataCounter<$replyDataNumber; $replyDataCounter++)
		{
			$author_personal_id_tmp = $replyData[$replyDataCounter][reply_person];
			
			//從Table personal_basic尋找作者的名子或是暱稱
			$sql = "SELECT * FROM personal_basic WHERE personal_id=$author_personal_id_tmp";
			$res = $DB_CONN->query($sql);
			if(PEAR::isError($res))	die($res->getMessage());
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			if($row[nickname] != "")
			{
				$author = $row[nickname];
			}
			else
			{
				$author = $row[personal_name];
			}
			
			//從Table discuss_info 尋找討論區的名稱
			$sql = "SELECT * FROM discuss_info WHERE begin_course_cd=" . $replyData[$replyDataCounter][begin_course_cd] . " AND discuss_cd=" . $replyData[$replyDataCounter][discuss_cd];
			$res = $DB_CONN->query($sql);
			if(PEAR::isError($res))	die($res->getMessage());
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			$discuss_name = $row[discuss_name];
			
			//從Table begin_course尋找課程名稱
			$sql = "SELECT * FROM begin_course WHERE begin_course_cd=" . $replyData[$replyDataCounter][begin_course_cd];
			$res = $DB_CONN->query($sql);
			if(PEAR::isError($res))	die($res->getMessage());
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			$begin_course_name = $row[begin_course_name];
			
			
			//將資料填入replyList中
			$replyList[$replyListCounter++] = 
					array(
							"begin_course_cd" => $replyData[$replyDataCounter][begin_course_cd], 
							"discuss_cd" => $replyData[$replyDataCounter][discuss_cd], 
							"discuss_content_cd" => $replyData[$replyDataCounter][discuss_content_cd], 
							"reply_content_cd" => $replyData[$replyDataCounter][reply_content_cd], 							
							"d_reply" => $replyData[$replyDataCounter][d_reply], 
							"discuss_title" => $replyData[$replyDataCounter][discuss_title], 
							"discuss_author" => $author, 
							"begin_course_name" => $begin_course_name, 
							"discuss_name" => $discuss_name
							);
			
		}
		$tpl->assign("replyList", $replyList);
	}
	
	//目前的頁面
	$tpl->assign("currentPage", "showCollectArticleList.php");
	
	if(isset($isShowSmartyTemplate) == 0)	$isShowSmartyTemplate = 1;
	if($isShowSmartyTemplate == 1)
	{
		assignTemplate($tpl, "/discuss_area/collectArticleList.tpl");
	}
?>

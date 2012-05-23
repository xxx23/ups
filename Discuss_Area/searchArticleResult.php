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
	
	$searchType = $_POST['searchType'];		//取得搜尋的目標
	$keyword = $_POST['keyword'];		//取得搜尋的關鍵字
	
	//將關鍵字依照空白做切割
	$token = strtok($keyword, " ");
	$keywordListCounter = 0;
	
	while($token !== false)
	{
		$keywordList[$keywordListCounter++] = $token;
		
   		$token = strtok(" ");
	}
	$keywordListNumber = $keywordListCounter;
	
	
	//設定檔案路徑
	$FILE_PATH = $COURSE_FILE_PATH . $begin_course_cd . "/Discuss_Area/";
	$tmp_FILE_PATH = $FILE_PATH;	
	$tmp_FILE_PATH = substr($tmp_FILE_PATH, 0, strrpos($tmp_FILE_PATH, "/"));
	$tmp_FILE_PATH = substr($tmp_FILE_PATH, 0, strrpos($tmp_FILE_PATH, "/"));
	$tmp_FILE_PATH = substr($tmp_FILE_PATH, 0, strrpos($tmp_FILE_PATH, "/"));
	$FILE_PATH = $RELEATED_PATH . substr($FILE_PATH, strrpos($tmp_FILE_PATH, "/")+1, strlen($FILE_PATH));

	
	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	$tpl->assign("keyword", $keyword);
	$tpl->assign("searchType", $searchType);
	
	//從Table discuss_content依照關鍵字搜尋所有的文章, 依照回覆的日期做排序
	$limit_cond = " AND (EXISTS( SELECT * FROM discuss_groups LEFT JOIN discuss_menber_groups ON
     						discuss_groups.begin_course_cd=discuss_menber_groups.begin_course_cd AND
		   				discuss_groups.group_no=discuss_menber_groups.group_no
					WHERE discuss_groups.begin_course_cd=$begin_course_cd AND
						discuss_groups.discuss_cd = discuss_content.discuss_cd AND
						(discuss_groups.is_public='y' OR 
						 (discuss_groups.is_public='n' AND discuss_menber_groups.student_id=$personal_id)
						))
			     OR 
			     EXISTS( SELECT * FROM teach_begin_course WHERE teacher_cd=$personal_id AND begin_course_cd=$begin_course_cd))";
	$searchOn = 1;
	switch($searchType)
	{
	case 1:	//依照discuss_title做搜尋
			$sql = "SELECT * FROM discuss_content WHERE begin_course_cd=$begin_course_cd";
			if($keywordListNumber > 0)
			{
				$sql = $sql . " AND (discuss_title LIKE '%$keywordList[0]%'";
				
				for($keywordListCounter=1; $keywordListCounter<$keywordListNumber; $keywordListCounter++)
				{
					$sql = $sql . " OR discuss_title LIKE '%$keywordList[$keywordListCounter]%'";
				}
				
				$sql = $sql . " )";
			}
			//判斷是否為私人小組的文章，如果是就不能搜尋
			//$sql = $sql . " AND NOT EXISTS( SELECT * FROM discuss_groups
			//  				INNER JOIN discuss_member_groups ON discuss_groups.begin_course_cd=discuss_member_groups.begin_course_cd
			//					, discuss_groups.discuss_cd=discuss_member_groups.discuss_cd
			//				WHERE discuss_groups.begin_course_cd=$begin_course_cd AND 
			//					discuss_groups.discuss_cd = discuss_content.discuss_cd AND 
			//					(discuss_groups.is_public='n' OR discuss_member_groups.student_id=$personal_id) )";

			//判斷是否為私人小組的文章，如果是就不能搜尋，目前暫定不能尋找私人小組文章，僅管是小組成員也是
			$sql = $sql . $limit_cond;

			$sql = $sql . " ORDER BY d_reply DESC";
			
			break;
	case 2:	//依照reply_person做搜尋

			//從Table personal_basic尋找作者名子或是暱稱的personal_id
			$sql = "SELECT * FROM personal_basic";			
			if($keywordListNumber > 0)
			{
				$sql = $sql . " WHERE personal_name LIKE '%$keywordList[0]%' OR nickname LIKE '%$keywordList[0]%'";
				
				for($keywordListCounter=1; $keywordListCounter<$keywordListNumber; $keywordListCounter++)
				{
					$sql = $sql . " OR personal_name LIKE '%$keywordList[$keywordListCounter]%' OR nickname LIKE '%$keywordList[$keywordListCounter]%'";
				}
			}
			$sql = $sql . " ORDER BY personal_id ASC";
	
			$res = $DB_CONN->query($sql);
			if(PEAR::isError($res))	die($res->getMessage());

			$personalNum = $res->numRows();	
			if($personalNum > 0)
			{
				$rowCounter = 0;
		
				while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
				{	
					$personalData[$rowCounter] = $row;
					$personalData[$rowCounter][personal_id] . "<br>";
					$rowCounter++;
				}
				$personalDataNumber = $rowCounter;
				
				
				//依照personal_id去搜尋
				$sql = "SELECT * FROM discuss_content WHERE begin_course_cd=$begin_course_cd";			
				if($personalDataNumber > 0)
				{
					$sql = $sql . " AND (reply_person=" . $personalData[0][personal_id];
					
					for($personalDataCounter=1; $personalDataCounter<$personalDataNumber; $personalDataCounter++)
					{
						$sql = $sql . " OR reply_person=" . $personalData[$personalDataCounter][personal_id];
					}
					$sql = $sql . ")";
				}
				//判斷是否為私人小組的文章，如果是就不能搜尋，目前暫定不能尋找私人小組文章，僅管是小組成員也是
				$sql = $sql . $limit_cond;
				$sql = $sql . " ORDER BY d_reply DESC";
			}
			else
			{
				$searchOn = 0;
			}
			
			break;
	case 3:	//依照content_body做搜尋
			$sql = "SELECT * FROM discuss_content WHERE begin_course_cd=$begin_course_cd";
			if($keywordListNumber > 0)
			{
				$sql = $sql . " AND (content_body LIKE '%$keywordList[0]%'";
				
				for($keywordListCounter=1; $keywordListCounter<$keywordListNumber; $keywordListCounter++)
				{
					$sql = $sql . " OR content_body LIKE '%$keywordList[$keywordListCounter]%'";
				}
				
				$sql = $sql . " )";
			}
			//判斷是否為私人小組的文章，如果是就不能搜尋，目前暫定不能尋找私人小組文章，僅管是小組成員也是
			$sql = $sql . $limit_cond;
			$sql = $sql . " ORDER BY d_reply DESC";
			
			break;
	default://依照discuss_title做搜尋
			$sql = "SELECT * FROM discuss_content WHERE begin_course_cd=$begin_course_cd";
			if($keywordListNumber > 0)
			{
				$sql = $sql . " AND (discuss_title LIKE '%$keywordList[0]%'";
				
				for($keywordListCounter=1; $keywordListCounter<$keywordListNumber; $keywordListCounter++)
				{
					$sql = $sql . " OR discuss_title LIKE '%$keywordList[$keywordListCounter]%'";
				}
				
				$sql = $sql . " )";
			}
			//判斷是否為私人小組的文章，如果是就不能搜尋，目前暫定不能尋找私人小組文章，僅管是小組成員也是
			$sql = $sql . $limit_cond;
			$sql = $sql . " ORDER BY d_reply DESC";
			
			break;
	}
	
	$replyNum = 0;
	if($searchOn == 1)
	{	
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		$replyNum = $res->numRows();
	}	
	$tpl->assign("replyNum", $replyNum);
	
	if($replyNum > 0)
	{
		$rowCounter = 0;
		
		while($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
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
			
			if( strncmp($discuss_name, "精華區_", strlen("精華區_")) == 0)	
			{
					$discuss_name = str_replace("精華區_", "", $discuss_name);
			}
			
			//將資料填入replyList中
			$replyList[$replyListCounter++] = 
					array(
							"discuss_cd" => $replyData[$replyDataCounter][discuss_cd], 
							"discuss_content_cd" => $replyData[$replyDataCounter][discuss_content_cd], 
							"reply_content_cd" => $replyData[$replyDataCounter][reply_content_cd], 
							"discuss_title" => $replyData[$replyDataCounter][discuss_title], 
							"discuss_author" => $author, 
							"discuss_name" => $discuss_name, 
							"d_reply" => $replyData[$replyDataCounter][d_reply]
							);
			
		}
		$tpl->assign("replyList", $replyList);
	}
	
	//目前的頁面
	$tpl->assign("currentPage", "searchArticleResult.php");
	
	assignTemplate($tpl, "/discuss_area/searchArticleResult.tpl");
?>

<?
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");	
	require_once("../library/account.php");

	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH . $CSS_VERSION_PATH;

	$absoluteURL = $HOMEURL . "Discuss_Area/";

	//取得所有參數
	$argument = $_GET['argument'];
						
	$begin_course_cd = strtok($argument, "_");		//取得begin_course_cd
	$discuss_cd = strtok("_");				//取得discuss_cd	
	$discuss_content_cd = strtok("_");		//取得discuss_content_cd
	$reply_content_cd = strtok("_");		//取得reply_content_cd
	
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
	
	session_start();
	$template = db_getOne("SELECT course_style FROM `personal_basic` WHERE personal_id=$_SESSION[personal_id];");
	if(empty($template))
		$template = get_style($_SESSION['personal_id'], "course_style");
	$_SESSION['template'] = $template;
	
	$tpl->assign("current_reply_content_cd", $reply_content_cd);
	
	//是否顯示上方選單
	$tpl->assign("isShowMenu", 0);
	
	//從Table discuss_content搜尋所有的文章, 依照parent的回覆文章編號做遞增排序(reply_conten_parentcd), 然後依照回覆文張編號做遞減排序(reply_content_cd)
	$sql = "SELECT * FROM discuss_content WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd AND discuss_content_cd=$discuss_content_cd ORDER BY reply_conten_parentcd ASC, reply_content_cd DESC";	
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
		
		
		$replyListTreeArrayNumber = 0;	//樹狀結構大小的初始值
		for($replyDataCounter = 0; $replyDataCounter<$replyDataNumber; $replyDataCounter++)
		{		
		
			$author_personal_id_tmp = $replyData[$replyDataCounter][reply_person];
				
			//從Table personal_basic尋找作者的名子或是暱稱以及個人資料
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
				$author = $row[student_name];
			}
			$student_name = $row[student_name];
			$nickname = $row[nickname];
			$personal_home = $row[personal_home];
			$photo = $row[photo];
			$feedback = $row[feedback];
			
			//計算檔案的大小
			$file_picture_name_size = "";
			if($replyData[$replyDataCounter][file_picture_name] != "")
			{	  
			  	$file_picture_name_size = filesize($FILE_PATH . $replyData[$replyDataCounter][file_picture_name]);
				$replyData[$replyDataCounter]['file_picture_name_size'] = $file_picture_name_size;
			}
			//產生一個ReplyListTreeArray的Entry
			$newReplyListTreeArrayEntry =
						array(
							"level" => 0, 
							"reply_content_cd" => $replyData[$replyDataCounter][reply_content_cd], 
							"replyDataCounter" => $replyDataCounter, 
							"author" => $author, 
							"student_name" => $student_name, 
							"nickname" => $nickname, 
							"personal_home" => $personal_home, 
							"photo" => $photo, 
							"feedback" => $feedback
							);
			
			//儲存成樹狀的資料結構
			if($replyListTreeArrayNumber == 0)
			{
				$replyListTreeArray[0] = $newReplyListTreeArrayEntry;
			}
			else
			{
				//蒐尋父節點在replyListTreeArray的位置
				for(	$replyListTreeArrayCounter=0;
						$replyListTreeArrayCounter<$replyListTreeArrayNumber; 
					 	$replyListTreeArrayCounter++
					 )
				{
					if($replyListTreeArray[$replyListTreeArrayCounter][reply_content_cd] == $replyData[$replyDataCounter][reply_conten_parentcd])
					{
						//設定資料的level
						$newReplyListTreeArrayEntry[level] = $replyListTreeArray[$replyListTreeArrayCounter][level]+1;
						
						//將資料位置做調整
						for($replyListTreeArrayMoveEntryCounter=$replyListTreeArrayNumber-1; 
							$replyListTreeArrayMoveEntryCounter>$replyListTreeArrayCounter; 
							$replyListTreeArrayMoveEntryCounter--
							)
						{
							$replyListTreeArray[$replyListTreeArrayMoveEntryCounter+1] = $replyListTreeArray[$replyListTreeArrayMoveEntryCounter];
						}
						//將資料放到replyListTreeArray裡面
						$replyListTreeArray[$replyListTreeArrayCounter+1] = $newReplyListTreeArrayEntry;
						
						break;
					}
				}
			}
			$replyListTreeArrayNumber++;
		}
		
		
		//依照replyListTreeArray將資料放置到replyList
		$currentReplyArrayNumber = 0;	//預設為顯示第一篇回覆的文章
		$replyListCounter = 0;
		for($replyListTreeArrayCounter=0; 
			$replyListTreeArrayCounter<$replyListTreeArrayNumber; 
			$replyListTreeArrayCounter++)
		{

			//取得要顯示的回覆文章在replyList的位置
			if($reply_content_cd == $replyListTreeArray[$replyListTreeArrayCounter][reply_content_cd])	$currentReplyArrayNumber = $replyListCounter;
	
			//echo $replyListTreeArray[$replyListTreeArrayCounter][level] . "<br>";	//for test
			
			//放入文章資料以及個人資料
			$replyList[$replyListCounter++] = 
						array(
							"level" => $replyListTreeArray[$replyListTreeArrayCounter][level], 
							"reply_content_cd" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][reply_content_cd], 
							"d_reply" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][d_reply], 
							"discuss_title" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][discuss_title], 
							"reply_person" => $replyListTreeArray[$replyListTreeArrayCounter][author], 
							"content_body" => nl2br($replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][content_body]), 
							"viewed" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][viewed], 
							"file_picture_name" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][file_picture_name],
							"file_picture_name_url" => $FILE_PATH . "" . $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][file_picture_name],
							"file_picture_name_size" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][file_picture_name_size],
							"file_av_name" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][file_av_name],
							"student_name" => $replyListTreeArray[$replyListTreeArrayCounter][student_name],
							"nickname" => $replyListTreeArray[$replyListTreeArrayCounter][nickname],
							"personal_home" => $replyListTreeArray[$replyListTreeArrayCounter][personal_home],
							"photo" => $replyListTreeArray[$replyListTreeArrayCounter][photo],
							"feedback" => $replyListTreeArray[$replyListTreeArrayCounter][feedback]
							);
		}
		$tpl->assign("replyList", $replyList);
		
		$tpl->assign("currentReplyArrayNumber", $currentReplyArrayNumber);
		
	}
	
	//目前的頁面
	$tpl->assign("currentPage", "showArticle_rss.php");
	
	assignTemplate($tpl, "/discuss_area/showArticle.tpl");
?>

<?
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "Discuss_Area/";

	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];				//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];		//取得課程代碼
	$discuss_cd = $_SESSION['discuss_cd'];				//取得討論區編號
	$discuss_content_cd = $_SESSION['discuss_content_cd'];		//取得文章編號
	$reply_content_cd = $_GET['reply_content_cd'];			//取得回覆文章編號
	
	$behavior = $_GET['behavior'];					//取得行為
	
	$action = $_GET['action'];					//取得action
	
    $type = $_GET['type'];					//是否為社群

	$message = $_GET['message'];					//取得訊息

	//設定檔案路徑
	$FILE_PATH = $COURSE_FILE_PATH . $begin_course_cd . "/Discuss_Area/";
	$tmp_FILE_PATH = $FILE_PATH;	
	$tmp_FILE_PATH = substr($tmp_FILE_PATH, 0, strrpos($tmp_FILE_PATH, "/"));
	$tmp_FILE_PATH = substr($tmp_FILE_PATH, 0, strrpos($tmp_FILE_PATH, "/"));
	$tmp_FILE_PATH = substr($tmp_FILE_PATH, 0, strrpos($tmp_FILE_PATH, "/"));
	$FILE_PATH = $RELEATED_PATH . substr($FILE_PATH, strrpos($tmp_FILE_PATH, "/")+1, strlen($FILE_PATH));

	//$tpl->assign("discuss_content_cd",$discuss_content_cd);

	require_once($HOME_PATH . 'library/smarty_init.php'); 
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	$tpl->assign("current_reply_content_cd", $reply_content_cd);
	
	$tpl->assign("behavior", $behavior);
	$tpl->assign("personal_id",$personal_id);	
	
	if($action == 'disableFunction')
	{		
		$tpl->assign("isShowMenu", 0);	//是否顯示上方選單		
		$tpl->assign("isBackOn", 0);	//是否允許回上一頁
	}
	else if($action == 'searchArticle')
	{
		$tpl->assign("isShowMenu", 0);	//是否顯示上方選單	
		$tpl->assign("isBackOn", 1);	//是否允許回上一頁
		$tpl->assign("backLink", "searchArticle.php");	//上一頁連結
    }
    else if($type == 'group')
    {
		$tpl->assign("isShowMenu", 1);	//是否顯示上方選單
		$tpl->assign("isBackOn", 1);	//是否允許回上一頁
		$tpl->assign("backLink", "groupShowArticleList.php?behavior=$behavior");	//上一頁連結
    }
	else
	{		
		$tpl->assign("isShowMenu", 1);	//是否顯示上方選單
		$tpl->assign("isBackOn", 1);	//是否允許回上一頁
		$tpl->assign("backLink", "showArticleList.php?behavior=$behavior");	//上一頁連結
	}
	
	
	if($message == "CollectSuccess")
	{
		$tpl->assign("message", "收藏成功");
	}
	
	
	//從Table discuss_content搜尋所有的文章, 依照parent的回覆文章編號做遞增排序(reply_conten_parentcd), 然後依照回覆文張編號做遞減排序(reply_content_cd)
	//使用discuss_content_viewed這個table，來看該篇文章是否有被看過了
	$sql = "SELECT d.* , v.personal_id 
	  FROM discuss_content as d left join discuss_content_viewed as v
	  ON d.begin_course_cd = v.begin_course_cd 
	  AND d.discuss_cd = v.discuss_cd
	  AND d.discuss_content_cd = v.discuss_content_cd
	  AND d.reply_content_cd = v.reply_content_cd
	  AND v.personal_id = $personal_id
	  WHERE d.begin_course_cd = $begin_course_cd
	  AND d.discuss_cd = $discuss_cd
	  AND d.discuss_content_cd = $discuss_content_cd
	  ORDER by d.d_reply ASC";

	//file_put_contents("/tmp/a.txt",$sql);

	$res = db_query($sql);
	
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
            $res = db_query($sql);

			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			if($row[nickname] != "")
			{
			  	$author_id = $author_personal_id_tmp;
				$author = $row[nickname];
			}
			else
			{
			  	$author_id = $author_personal_id_tmp;
				$author = $row[personal_name];
			}
			$student_name = $row[personal_name];
			$nickname = $row[nickname];
			$personal_home = $row[personal_home];
			$photo = $row[photo];
			$feedback = $row[feedback];
			
			//計算檔案的大小
			$file_picture_name_size = "";
			if($replyData[$replyDataCounter]['file_picture_name'] != "")
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
							"photo" => getPersonalWebPath($row['personal_id']) .ltrim($photo,'/'), 
							"feedback" => $feedback,
							"author_id" => $author_id,
							"viewed" => $replyData[$replyDataCounter][personal_id],
							"reply_parentcd" => $replyData[$replyDataCounter]['reply_conten_parentcd']
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

						//將資料位置調整
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
			$content_temp=explode("\n",$replyData[$replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter]][content_body]);

			//把別人回文章的地方加上顏色 
			$s_content_body = "";
			foreach($content_temp as $tmp)
			{
				if($tmp[0] == '>')
				  	$s_content_body .= "<font style='background-color: #D0E0D0'>".$tmp."</font>";
				else
					$s_content_body .= $tmp;
			}
	
			//放入文章資料以及個人資料
			$replyList[$replyListCounter++] = 
						array(
							"level" => $replyListTreeArray[$replyListTreeArrayCounter][level], 
							"reply_content_cd" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][reply_content_cd], 
							"d_reply" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][d_reply], 
							"discuss_title" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][discuss_title], 
							"reply_person" => $replyListTreeArray[$replyListTreeArrayCounter][author], 
							"content_body" => nl2br($s_content_body), 
							"viewed" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][viewed], 
							"file_picture_name" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][file_picture_name],
							"file_picture_name_url" => $FILE_PATH . "" . $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][file_picture_name],
							"file_picture_name_size" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][file_picture_name_size],
							"file_av_name" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][file_av_name],
							"student_name" => $replyListTreeArray[$replyListTreeArrayCounter][student_name],
							"nickname" => $replyListTreeArray[$replyListTreeArrayCounter][nickname],
							"personal_home" => $replyListTreeArray[$replyListTreeArrayCounter][personal_home],
							"photo" => $replyListTreeArray[$replyListTreeArrayCounter][photo],
							"feedback" => $replyListTreeArray[$replyListTreeArrayCounter][feedback],
							"author_id" => $replyListTreeArray[$replyListTreeArrayCounter][author_id],
							"viewed_before" => $replyListTreeArray[$replyListTreeArrayCounter][viewed],
							"reply_parent_cd" => $replyListTreeArray[$replyListTreeArrayCounter]['reply_parentcd']
						      );

		}

			
		//依照d_reply來排列順序 原本的程式是由大排到小，不符合實際觀看的先後順序，在這邊把它調整過來。
		//回文順序是由先回文的在最上面，最後回文的在最下面。
		//modify by Samuel 09/05/24
		for($d_counter = 0 ; $d_counter < $replyListCounter ; $d_counter++ )
		{	
		  	// 第一筆的資料最大，最後一筆的最小。
			if($replyList[$d_counter]['reply_content_cd'] == $replyList[$d_counter+1]['reply_parent_cd'])
			{
			  	$start_pos = $d_counter+1 ;
			  	// 計算有幾項相同的。
			  	for($i = 0 ; $replyList[$start_pos+$i+1]['reply_parent_cd']==$replyList[$d_counter]['reply_content_cd'];$i++);
				$stop_pos = $start_pos + $i ;
				while($start_pos < $stop_pos)
				{
				  	swap($replyList[$start_pos],$replyList[$stop_pos]);
					$start_pos ++ ;
					$stop_pos -- ;
				}
				$d_counter = $stop_pos-1;
			}
			//edit by aeil
			if($reply_content_cd == $replyList[$d_counter]['reply_content_cd'])
			  $currentReplyArrayNumber = $d_counter;
			//end
		}
		
		$tpl->assign("replyList", $replyList);
		
	}
		$tpl->assign("currentReplyArrayNumber", $currentReplyArrayNumber);
    
    $tpl->assign("type", $type);

	//目前的頁面
	$tpl->assign("currentPage", "showArticle.php");
	
	assignTemplate($tpl, "/discuss_area/showArticle.tpl");

	//====================================================================//
	//add by Samuel 09/05/24
	function swap(&$a,&$b)
	{
	  	$temp = $a ; 
		$a = $b ;
		$b = $temp ;
	}
?>

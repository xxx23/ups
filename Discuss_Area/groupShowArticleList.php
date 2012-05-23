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
	$discuss_cd = $_SESSION['discuss_cd'];				//取得討論區編號	
	$ArticleList = $_SESSION['ArticleList'];				//取得ArticleList的程式行為

	$behavior = $_GET['behavior'];						//取得行為

	//var_dump($_SESSION);
	
	//設定showArticleListTemplateNumber的值
	$showArticleListTemplateNumber = $_GET['showArticleListTemplateNumber'];		//取得樣板編號	
	if( isset($showArticleListTemplateNumber) == false)
	{	
		$showArticleListTemplateNumber = $_SESSION['showArticleListTemplateNumber'];
	}
	if( isset($showArticleListTemplateNumber) == false)
	{		
		//註冊樣板編號到SESSION
		$showArticleListTemplateNumber = 1;
		$_SESSION['showArticleListTemplateNumber'] = $showArticleListTemplateNumber;
	}

	//設定檔案路徑
	$FILE_PATH = $COURSE_FILE_PATH . $begin_course_cd . "/Discuss_Area/";
	$tmp_FILE_PATH = $FILE_PATH;	
	$tmp_FILE_PATH = substr($tmp_FILE_PATH, 0, strrpos($tmp_FILE_PATH, "/"));
	$tmp_FILE_PATH = substr($tmp_FILE_PATH, 0, strrpos($tmp_FILE_PATH, "/"));
	$tmp_FILE_PATH = substr($tmp_FILE_PATH, 0, strrpos($tmp_FILE_PATH, "/"));
	$FILE_PATH = $RELEATED_PATH . substr($FILE_PATH, strrpos($tmp_FILE_PATH, "/")+1, strlen($FILE_PATH));


	require_once($HOME_PATH . 'library/smarty_init.php');
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("javascriptPath", $JAVASCRIPT_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	$tpl->assign("behavior", $behavior);

	//是否顯示RSS訂閱
	$showRss = 1;
	$tpl->assign("showRss", $showRss);
	$tpl->assign("rssPage", "articleList_rss.php?personal_id=$personal_id&begin_course_cd=$begin_course_cd&discuss_cd=$discuss_cd");
	
	if($role_cd==0)//系統管理者
	{
		$tpl->assign("isDeleteOn", 1);	//是否允許刪除
		$tpl->assign("isCollectOn", 1);	//是否允許收藏文章
		$tpl->assign("isBackOn", 1);	//是否允回上一頁
	}
	else if($role_cd==1)//教師
	{
		$tpl->assign("isDeleteOn", 1);	//是否允許刪除
		$tpl->assign("isCollectOn", 1);	//是否允許收藏文章
		$tpl->assign("isBackOn", 1);	//是否允回上一頁
	}
	else if($role_cd==3)//學生
	{
		$tpl->assign("isDeleteOn", 0);	//是否允許刪除
		$tpl->assign("isCollectOn", 0);	//是否允許收藏文章
		$tpl->assign("isBackOn", 1);	//是否允回上一頁
	}
	else//其它
	{
		$tpl->assign("isDeleteOn", 0);	//是否允許刪除
		$tpl->assign("isCollectOn", 0);	//是否允許收藏文章
		$tpl->assign("isBackOn", 1);	//是否允回上一頁
	}
	
	switch($ArticleList){
	case "DisableReturn":	$tpl->assign("isBackOn", 0);
							break;
	default:break;
	}


	//輸出樣板編號
	$tpl->assign("showArticleListTemplateNumber", $showArticleListTemplateNumber);

	//取得頁碼
	$currentPageNumber = $_GET['currentPageNumber'];
	if( isset($currentPageNumber) == false)	$currentPageNumber = 1;
	$tpl->assign("currentPageNumber", $currentPageNumber);
	
	//每頁顯示的文章數
	$pageArticleNumber = 10;

	//取得排序的方式
	$sortby = $_GET['sortby'];
	if( isset($sortby) == false)	$sortby = 1;
	$tpl->assign("sortby", $sortby);
	$tpl->assign("personal_id",$personal_id);

	$templateNumber = $showArticleListTemplateNumber;
//	$templateNumber = 2 ; 
	if($templateNumber == 1)
	{
		//第一種樣板

		//從Table discuss_subject搜尋所有的文章, 並做排序
		switch($sortby)
		{
		case 1:	//依照discuss_content_cd做排序
				$sql = "SELECT * FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd ORDER BY discuss_content_cd DESC";
				break;
		case 2:	//依照標題discuss_title做排序
				$sql = "SELECT * FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd ORDER BY discuss_title DESC";
				break;
		case 3:	//依照作者discuss_author做排序
				$sql = "SELECT * FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd ORDER BY discuss_author DESC";
				break;
		case 4:	//依照d_created做排序
				$sql = "SELECT * FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd ORDER BY d_created DESC";
				break;
		case 5:	//依照最後回覆d_replied做排序
				$sql = "SELECT * FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd ORDER BY d_replied DESC";
				break;
		case 6:	//依照觀看次數viewed做排序
				$sql = "SELECT * FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd ORDER BY viewed DESC";
				break;
		case 7:	//依照觀看次數reply_count做排序
				$sql = "SELECT * FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd ORDER BY reply_count DESC";
				break;
		default://依照discuss_content_cd做排序
				$sql = "SELECT * FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd ORDER BY discuss_content_cd DESC";
				break;
		}
	
        $res = db_query($sql);
		
		$articleNum = $res->numRows();
		$tpl->assign("articleNum", $articleNum);
	/*	
		$sql = "SELECT v.personal_id FROM d AS didcuss_content 
		  left join V as discuss_content_viewed
		  ON d.begin_course_cd = v.begin_course_cd
		  AND d.discuss_cd = v.discuss_cd
		  AND d.discuss_content_cd = v.discuss_content_cd
		  WHERE d.begin_course_cd = $begin_course_cd
		  AND d.discuss_cd = $discuss_cd
		  AND d.discuss_content_cd = ";
	 */
		if($articleNum > 0)
		{
			$rowCounter = 0;
			
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{	
				$articleData[$rowCounter] = $row;
				
				$rowCounter++;
			}
			$articleDataNumber = $rowCounter;
			
			
			$articleListCounter = 0;
			$articleListNumber = 0;
			for($articleDataCounter = 0; $articleDataCounter<$articleDataNumber; $articleDataCounter++)
			{
				//依照頁碼顯示資料, 過濾掉不顯示的資料
				if( $articleDataCounter < ($currentPageNumber-1)*$pageArticleNumber )	continue;
				if( $articleDataCounter >= ($currentPageNumber)*$pageArticleNumber )	continue;
			
			
				$author_personal_id_tmp = $articleData[$articleDataCounter][discuss_author];
				
				//從Table personal_basic尋找作者的名子或是暱稱
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


				//判斷裡面的文章回覆有沒有看過
				$sql = "SELECT v.personal_id 
				  FROM discuss_content AS d LEFT JOIN discuss_content_viewed AS v
				  ON d.begin_course_cd = v.begin_course_cd
				  AND d.discuss_cd = v.discuss_cd
				  AND d.discuss_content_cd = v.discuss_content_cd
				  AND d.reply_content_cd = v.reply_content_cd
				  AND v.personal_id = $personal_id
				  WHERE d.begin_course_cd = $begin_course_cd
				  AND d.discuss_cd = $discuss_cd
				  AND d.discuss_content_cd = {$articleData[$articleDataCounter]['discuss_content_cd']}";

	//			file_put_contents("/tmp/a.txt",$sql);

				$viewed_result = db_getAll($sql);
				
				$viewed = 0 ;
				foreach($viewed_result as $value)
				{
				  if($value['personal_id'] == NULL)// 表示文章沒有被看過，要顯示 '+' 
				    	$viewed++;
				}
				

				//將資料填入articleList中
				$articleList[$articleListCounter++] = 
						array(
								"discuss_content_cd" => $articleData[$articleDataCounter][discuss_content_cd], 
								"discuss_title" => $articleData[$articleDataCounter][discuss_title], 
								"discuss_author" => $author, 
								"viewed" => $articleData[$articleDataCounter][viewed], 
								"reply_count" => $articleData[$articleDataCounter][reply_count],
								"d_created" => $articleData[$articleDataCounter][d_created], 
								"d_replied" => $articleData[$articleDataCounter][d_replied],
								"author_id" => $author_id,
								"viewed_all" => $viewed 
							      );
				// 如果 articleList裡面的viewed不是0，即表示有文章仍沒被看過，要顯示加號
			}
			$articleListNumber = $articleListCounter;
			
			//輸出文章標題列表
			$tpl->assign("articleList", $articleList);
	
			//從Table discuss_content搜尋回覆的文章資訊
			$rowShowNumber = 5;	//最多顯示5筆
			for($articleListCounter = 0; $articleListCounter<$articleListNumber; $articleListCounter++)
			{
				//從Table discuss_content搜尋所有的文章, 依照回覆的日期做排序
				$sql = "SELECT * FROM discuss_content WHERE 
							begin_course_cd=$begin_course_cd AND 
							discuss_cd=$discuss_cd AND 
							discuss_content_cd=" . $articleList[$articleListCounter][discuss_content_cd] . "
							ORDER BY d_reply DESC";	
                $res = db_query($sql);
				
				$replyNum = $res->numRows();
				
				if($replyNum > 0)
				{
					$rowCounter = 0;				
		
					while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
					{	
						$replyData[$rowCounter] = $row;
						
						$rowCounter++;
						
						if($rowCounter == $rowShowNumber)	break;
					}
					$replyDataNumber = $rowCounter;
					
					
					$replyListCounter = 0;
					for($replyDataCounter = 0; $replyDataCounter<$replyDataNumber; $replyDataCounter++)
					{						
						$author_personal_id_tmp = $replyData[$replyDataCounter][reply_person];
							
						//從Table personal_basic尋找作者的名子或是暱稱以及個人資料
						$sql = "SELECT * FROM personal_basic WHERE personal_id=$author_personal_id_tmp";
                        $res = db_query($sql);
						
						$res->fetchInto($row, DB_FETCHMODE_ASSOC);
						if($row[nickname] != "")
						{
							$author = $row[nickname];
						}
						else
						{
							$author = $row[student_name];
						}
						
						//放入文章資料以及個人資料
						$replyList[$articleListCounter][$replyListCounter++] = 
									array(											
											"reply_content_cd" => $replyData[$replyDataCounter][reply_content_cd], 
											"d_reply" => $replyData[$replyDataCounter][d_reply], 
											"discuss_title" => $replyData[$replyDataCounter][discuss_title], 
											"reply_person" => $author, 
											"personal_home" => $personal_home,
											);
					}//end for($replyDataCounter = 0; $replyDataCounter<$replyDataNumber; $replyDataCounter++)
					
					//輸出回覆文章列表
					$tpl->assign("replyList", $replyList);
				}//end if($replyNum > 0)
			}//end for($articleListCounter = 0; $articleListCounter<$articleListNumber; $articleListCounter++)
	
		}
	}//end if($templateNumber == 1)	//第一種樣板
	else if($templateNumber == 2)
	{
		//第二種樣板
		
		//從Table discuss_content搜尋所有的文章, 依照回覆的日期做遞減排序
		$sql = "SELECT * FROM discuss_content WHERE 
						begin_course_cd=$begin_course_cd AND 
						discuss_cd=$discuss_cd
						ORDER BY d_reply DESC";	
        $res = db_query($sql);
		
		$replyNum = $res->numRows();
		$tpl->assign("replyNum", $replyNum);		//輸出回覆文章數
		
		
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
					
				//從Table personal_basic尋找作者的名子或是暱稱以及個人資料
				$sql = "SELECT * FROM personal_basic WHERE personal_id=$author_personal_id_tmp";
                $res = db_query($sql);
				
				$res->fetchInto($row, DB_FETCHMODE_ASSOC);
				if($row[nickname] != "")
				{
					$author = $row[nickname];
				}
				else
				{
					$author = $row[personal_name];
				}
				
				//放入文章資料以及個人資料
				$replyList[$replyListCounter++] = 
							array(
									"replyListCounter" => $replyListCounter, 
									"discuss_content_cd" => $replyData[$replyDataCounter][discuss_content_cd], 									
									"reply_content_cd" => $replyData[$replyDataCounter][reply_content_cd], 
									"d_reply" => $replyData[$replyDataCounter][d_reply], 
									"discuss_title" => $replyData[$replyDataCounter][discuss_title], 
									"reply_person" => $author, 
									"content_body" => nl2br($replyData[$replyDataCounter][content_body]), 
									"viewed" => $replyData[$replyDataCounter][viewed], 
									"file_picture_name" => $replyData[$replyDataCounter][file_picture_name],
									"file_picture_name_url" => $FILE_PATH . "" . $replyData[$replyDataCounter][file_picture_name],
									"file_picture_name_size" => $file_picture_name_size,
									"file_av_name" => $replyData[$replyDataCounter][file_av_name],
									"student_name" => $student_name,
									"nickname" => $nickname,
									"personal_home" => $personal_home,
									"photo" => $photo,
									"feedback" => $feedback
									);
			}//end for($replyDataCounter = 0; $replyDataCounter<$replyDataNumber; $replyDataCounter++)
			
			//輸出回覆文章列表
			$tpl->assign("replyList", $replyList);
		}//end if($replyNum > 0)
			
			
	}//end if($templateNumber == 2)	//第二種樣板

	//總共有幾頁
	$totalPageNumber = ceil($articleNum/$pageArticleNumber);	//無條件進位
	if($totalPageNumber == 0)	$totalPageNumber = 1;
	$tpl->assign("totalPageNumber",  $totalPageNumber);

	for($counter=0; $counter<$totalPageNumber; $counter++)
	{
		$pageLinkList[$counter] = $counter+1;
	}
    $tpl->assign("pageLinkList", $pageLinkList);

    //次要教師 限制只能參與 by carlcarl
    $sql = "select course_master from teach_begin_course 
        where teacher_cd=$personal_id and begin_course_cd=$begin_course_cd";
    $isCourseMaster = db_getOne($sql);

    $tpl->assign("isCourseMaster", $isCourseMaster);

	//目前的頁面
	$tpl->assign("currentPage", "showArticleList.php");
	
	if(isset($isShowSmartyTemplate) == 0)	$isShowSmartyTemplate = 1;
	if($isShowSmartyTemplate == 1)
	{
		switch($templateNumber)
		{
			case 1:		assignTemplate($tpl, "/discuss_area/groupArticleList.tpl");		break;
			//case 2:		assignTemplate($tpl, "/discuss_area/groupArticleList_bbs.tpl");	break;			
			default:	assignTemplate($tpl, "/discuss_area/groupArticleList.tpl");		break;
		}
	}
?>

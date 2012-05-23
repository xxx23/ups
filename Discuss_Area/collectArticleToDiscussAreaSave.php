<?
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	
	session_start();
	$personal_id = $_SESSION['personal_id'];				//取得個人編號
	$role_cd = $_SESSION['role_cd'];						//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];		//取得課程代碼
	
	$src_discuss_cd = $_POST['src_discuss_cd'];					//取得來源的討論區編號
	$src_discuss_content_cd = $_POST['src_discuss_content_cd'];	//取得來源的文章編號
	$discussAreaNum = $_POST['discussAreaNum'];					//取得參數的個數
	
	$behavior = $_POST['behavior'];					//取得參數的個數
	
	//設定目前時間
	$currentTime = TIME_date(2) . " " . TIME_time(2);
	
	
	//取得來源Table discuss_subject的資料
	$sql = "SELECT * FROM discuss_subject  
					WHERE 
						begin_course_cd = $begin_course_cd AND 
						discuss_cd = $src_discuss_cd AND 
						discuss_content_cd = $src_discuss_content_cd";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	
	if($res->numRows() > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		$src_discuss_subject = $row;
		
		//取得來源Table discuss_content的資料
		$sql = "SELECT * FROM discuss_content  
					WHERE 
						begin_course_cd = $begin_course_cd AND 
						discuss_cd = $src_discuss_cd AND 
						discuss_content_cd = $src_discuss_content_cd 
					ORDER BY reply_content_cd ASC";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		if($res->numRows() > 0)
		{
			$src_discuss_content_Counter = 0;
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{				
				$src_discuss_content[$src_discuss_content_Counter++] = $row;
			}
			$src_discuss_content_Number = $src_discuss_content_Counter;
		}
	
		//取得所有的參數
		for($discussAreaCounter=0; $discussAreaCounter<$discussAreaNum; $discussAreaCounter++)
		{
			$nameTmp = "discuss_cd_" . ($discussAreaCounter+1);
			
			$discussArea[$discussAreaCounter] = $_POST[$nameTmp];	//取得參數		
			
			//有被勾選的資料就將來源的文章複製過去
			if(isset($discussArea[$discussAreaCounter]) == true)
			{
				$dst_discuss_cd = $discussArea[$discussAreaCounter];
			
				//從Table discuss_subject取得新的dst_discuss_content_cd
				$sql = "SELECT * FROM discuss_subject 
								WHERE 
									begin_course_cd = $begin_course_cd AND 
									discuss_cd = $dst_discuss_cd";
				$res = $DB_CONN->query($sql);
				if (PEAR::isError($res))	die($res->getMessage());
			
				$articleNum = $res->numRows();
				if($articleNum == 0)
				{
					$dst_discuss_content_cd = 1;
				}
				else
				{
					$dst_discuss_content_cd_tmp = 0;
					while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
					{				
						if($row[discuss_content_cd] > $dst_discuss_content_cd_tmp)	
							$dst_discuss_content_cd_tmp = $row[discuss_content_cd];
					}
				
					$dst_discuss_content_cd = $dst_discuss_content_cd_tmp + 1;
				}
				
				//新增資料到Table discuss_subject
				$sql = "INSERT INTO discuss_subject 
								(
									begin_course_cd, 
									discuss_cd, 
									discuss_content_cd, 
									discuss_title, 
									discuss_author, 
									viewed, 
									reply_count, 
									d_created, 
									d_replied
								) VALUES (
									$begin_course_cd, 
									$dst_discuss_cd, 
									$dst_discuss_content_cd, 
									'".addslashes($src_discuss_subject['discuss_title'])."', 
									$src_discuss_subject[discuss_author], 
									0, 
									$src_discuss_subject[reply_count], 
									'$currentTime', 
									'$src_discuss_subject[d_replied]'
								)";
				db_query($sql);
				
				//複製資料到Table discuss_content
				for($src_discuss_content_Counter=0; 
					$src_discuss_content_Counter<$src_discuss_content_Number; 
					$src_discuss_content_Counter++)
				{
					$FILE_PATH = $COURSE_FILE_PATH . $begin_course_cd . "/Discuss_Area/";
					$fileName = $src_discuss_content[$src_discuss_content_Counter]['file_picture_name']; 		//檔案名稱
					if(trim($fileName) != "")
					{
					  	$ext = strrchr( $fileName, '.' );			//副檔名
						$newFileName = $begin_course_cd . "_" . $dst_discuss_cd . "_" . $dst_discuss_content_cd . "_" . $src_discuss_content[$src_discuss_content_Counter]['reply_content_cd'] . $ext;	//新檔案名稱: 課程編號+討論區編號+文章編號+第幾個回覆者
						$fileUrl = $FILE_PATH . $newFileName;	//檔案的連結
						//沒做錯誤判斷，反正錯了文章也還是要備份過去(後人可以補上sql的交易方式)
						copy($FILE_PATH . ltrim($src_discuss_content[$src_discuss_content_Counter]['file_picture_name'],"/"),$FILE_PATH.ltrim($newFileName,"/")); 
					}
					$sql = "INSERT INTO discuss_content 
									(
										begin_course_cd, 
										discuss_cd, 
										discuss_content_cd, 
										reply_content_cd, 
										reply_conten_parentcd, 
										d_reply, 
										discuss_title, 
										reply_person, 
										content_body, 
										viewed, 
										file_picture_name
									) VALUES (
										$begin_course_cd, 
										$dst_discuss_cd, 
										$dst_discuss_content_cd, 
										" . $src_discuss_content[$src_discuss_content_Counter][reply_content_cd] . ", 
										" . $src_discuss_content[$src_discuss_content_Counter][reply_conten_parentcd] . ", 
										'" . $src_discuss_content[$src_discuss_content_Counter][d_reply] . "', 
										'" . addslashes($src_discuss_content[$src_discuss_content_Counter]['discuss_title']) . "', 
										" . $src_discuss_content[$src_discuss_content_Counter][reply_person] . ", 
										'" . addslashes($src_discuss_content[$src_discuss_content_Counter]['content_body']) . "', 
										0, 
										'" . $newFileName . "'
									)";
					
					db_query($sql);

				}
			}
		}
	}

	//header("Location: showArticleList.php?behavior=$behavior");
	
	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	$title = "收至精華區";
	$content = "收藏成功";
	$content = $content . "<br><a href='showArticleList.php?behavior=$behavior'>返回討論區</a>";

	$tpl->assign("title", $title);
	$tpl->assign("content", $content);
	
	assignTemplate($tpl, "/discuss_area/message.tpl");
?>

<?
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");
	

	//取得SESSION的資料
	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼
	$discuss_cd = $_SESSION['discuss_cd'];				//取得討論區編號
	$discuss_content_cd = $_SESSION['discuss_content_cd'];	//取得文章編號
	$p_reply_content_cd = $_POST['reply_content_cd'];	//取得文章編號

	$behavior = $_POST['behavior'];						//取得行為
	$type = $_POST['type'];						        //是否為社群

	//取得Action
	$action = $_POST['action'];
	
	//設定檔案儲存路徑
	$FILE_PATH = $COURSE_FILE_PATH . $begin_course_cd . "/Discuss_Area/";
	if(is_dir($FILE_PATH) == FALSE){	createPath($FILE_PATH);	}
	
	if($action == "new")
	{
		//新的文章標題
		$reply_content_cd = 1;
		$reply_conten_parentcd = 0;
	}
	else if($action == "reply")
	{
		//回覆文章

		
		//從Table discuss_content中取得新的reply_content_cd
		$sql = "SELECT * FROM discuss_content 
						WHERE 
							begin_course_cd = $begin_course_cd AND 
							discuss_cd = $discuss_cd AND 
							discuss_content_cd = $discuss_content_cd";
        $res = db_query($sql);
			
		$replyNum = $res->numRows();
		
		$reply_content_cd_tmp = 0;
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{				
			if($row[reply_content_cd] > $reply_content_cd_tmp)	$reply_content_cd_tmp = $row[reply_content_cd];
		}		
		$reply_content_cd = $reply_content_cd_tmp + 1;
		
		
		//設定上一篇回覆文章的編號
		$reply_conten_parentcd = $p_reply_content_cd;
	}


	//title 跟 內文不可是空白
	$discuss_title = $_POST['discuss_title'];
	$discuss_title = $discuss_title;
	if(trim($discuss_title) == "")
	  	exit;

	$content_body = $_POST['content_body'];
	$content_body = $content_body;
	if(trim($content_body) == "")
		exit;

	//設定目前時間
	$currentTime = TIME_date(2) . " " . TIME_time(2);
	
	//新的文章標題
	if($action == "new")
	{
		//從Table discuss_subject取得新的discuss_content_cd
		$sql = "SELECT * FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd";
        $res = db_query($sql);
	
		$articleNum = $res->numRows();
		if($articleNum == 0)
		{
			$discuss_content_cd = 1;
		}
		else
		{
			$discuss_content_cd_tmp = 0;
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{				
				if($row[discuss_content_cd] > $discuss_content_cd_tmp)	
					$discuss_content_cd_tmp = $row[discuss_content_cd];
			}
		
			$discuss_content_cd = $discuss_content_cd_tmp + 1;
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
						$discuss_cd, 
						$discuss_content_cd, 
						'$discuss_title', 
						$personal_id, 
						0, 
						0, 
						'$currentTime', 
						'$currentTime'
					)";
		db_query($sql);
	
	
		//有檔案要上傳
		if($_FILES['file']['tmp_name'] != "")
		{
			//設定要上傳的資料
			$fileName = $_FILES['file']['name'];		//檔案名稱
			$ext = strrchr( $fileName, '.' );			//副檔名
			$newFileName = $begin_course_cd . "_" . $discuss_cd . "_" . $discuss_content_cd . "_" . "0" . $ext;	//新檔案名稱: 課程編號+討論區編號+文章編號+第幾個回覆者
			$fileUrl = $FILE_PATH . $newFileName;	//檔案的連結
			
			//上傳檔案到Server
			if( FILE_upload($_FILES['file']['tmp_name'], $FILE_PATH, $newFileName) == false)
			{	
				echo "FILE_upload fail";
			}
		}
	
		//新增資料到Table discuss_content
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
						$discuss_cd, 
						$discuss_content_cd, 
						$reply_content_cd, 
						$reply_conten_parentcd, 
						'$currentTime', 
						'$discuss_title', 
						$personal_id, 
						'$content_body', 
						0, 
						'$newFileName'
					)";
		db_query($sql);
	}//end if($action == "new")
	//回覆別人的文章
	else if($action == "reply")
	{	
	
		//從Table discuss_subject取得目前回覆的人數reply_count
		$sql = "SELECT * FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd AND discuss_content_cd=$discuss_content_cd";
        $res = db_query($sql);
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		$reply_count = $row[reply_count];
		
		$current_reply_count = $reply_count+1;
		
		//更新discuss_subject的資料
		$sql = "UPDATE 
					discuss_subject 
				SET 
					reply_count=$current_reply_count, 
					d_replied='$currentTime' 
				WHERE 
					begin_course_cd=$begin_course_cd AND 
					discuss_cd=$discuss_cd AND 
					discuss_content_cd=$discuss_content_cd
				";
		db_query($sql);
		
		//有檔案要上傳
		if($_FILES['file']['tmp_name'] != "")
		{
			//設定要上傳的資料
			$fileName = $_FILES['file']['name'];		//檔案名稱
			$ext = strrchr( $fileName, '.' );			//副檔名
			$newFileName = $begin_course_cd . "_" . $discuss_cd . "_" . $discuss_content_cd . "_" . $current_reply_count . $ext;	//新檔案名稱: 課程編號+討論區編號+文章編號+第幾個回覆者
			$fileUrl = $FILE_PATH . $newFileName;	//檔案的連結
			
			//上傳檔案到Server
			if( FILE_upload($_FILES['file']['tmp_name'], $FILE_PATH, $newFileName) == false)
			{	
				echo "FILE_upload fail";
			}
		}

		//新增資料到Table discuss_content
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
						$discuss_cd, 
						$discuss_content_cd, 
						$reply_content_cd, 
						$reply_conten_parentcd, 
						'$currentTime', 
						'$discuss_title', 
						$personal_id, 
						'$content_body', 
						0, 
						'$newFileName'
					)";
		db_query($sql);
		//新增資料到table discuss_content_viewed by Samuel
		$sql ="INSERT INTO discuss_content_viewed (
		  begin_course_cd ,
		  discuss_cd,
		  discuss_content_cd,
		  reply_content_cd,
		  personal_id) 
		  VALUES (
		    $begin_course_cd,
		    $discuss_cd,
		    $discuss_content_cd,
		    $reply_content_cd,
		    $personal_id
		  )";
		db_query($sql);

	}//end if($action == "reply")

	//學習追蹤-發表文章
	LEARNING_TRACKING_start(3, 1, $_SESSION['begin_course_cd'], $_SESSION['personal_id']);
	

	header("Location: ArticleList_intoArticle.php?behavior=$behavior&discuss_content_cd=$discuss_content_cd&reply_content_cd=$reply_content_cd&type=$type");
?>

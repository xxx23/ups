<?php
	/*author: lunsort
	 * date: 2007/11/16
	 * 這支程式的使用程式必定要include config.php
	 */


	function delete_survey($no){
		db_query("delete from `online_survey_setup` where survey_no=$no;");
		db_query("delete from `online_survey_content` where survey_no=$no;");
		db_query("delete from `survey_student` where survey_no=$no;");
		//要先取出response_no，並刪除response的資料，下方的兩行順序不能改變
		db_query("delete from `online_survey_response` where response_no in (select response_no from `online_survey` where survey_no=$no);");
		db_query("delete from `online_survey` where survey_no=$no;");
	}

	function delete_survey_by_course_cd($cd){
	  	global $COURSE_FILE_PATH;
		$tmp = array();
		$res = db_query("select survey_no from `online_survey_setup` where survey_target=$cd;");
		while($r = $res->fetchRow(DB_FETCHMODE_ASSOC))
			array_push($tmp, $r['survey_no']);
		for($i = 0 ; $i < count($tmp) ; $i++)
			delete_survey($tmp[$i]);
		SureRemoveDir($COURSE_FILE_PATH . $cd . "/survey");
	}

	//assignment是由begin_course_cd和homework_no組成的主鍵
	//此函式僅處理資料庫內容，並無處理相關檔案
	function delete_assignment($cd, $no){
		global $DB_CONN;
		$is_co_learn = $DB_CONN->getOne("select is_co_learn from `homework` where begin_course_cd=$cd and homework_no=$no;");
		if($is_co_learn == 1){
			db_query("delete from `projectwork` where begin_course_cd=$cd and homework_no=$no;");
			db_query("delete from `project_data` where begin_course_cd=$cd and homework_no=$no;");
			db_query("delete from `take_groups_score` where begin_course_cd=$cd and homework_no=$no;");
			db_query("delete from `take_student_score` where begin_course_cd=$cd and homework_no=$no;");
			db_query("delete from `groups_member` where begin_course_cd=$cd and homework_no=$no;");
			db_query("delete from `info_groups` where begin_course_cd=$cd and homework_no=$no;");
		}
		$number_id = $DB_CONN->getOne("select number_id from `course_percentage` where begin_course_cd=$cd and percentage_type=2 and percentage_num=$no;");
		db_query("delete from `homework` where begin_course_cd=$cd and homework_no=$no;");
		db_query("delete from `course_percentage` where begin_course_cd=$cd and percentage_type=2 and percentage_num=$no;");
		db_query("delete from `handin_homework` where begin_course_cd=$cd and homework_no=$no;");
		db_query("delete from `course_concent_grade` where begin_course_cd=$cd and number_id=$number_id;");
	}

	function delete_assignment_by_course_cd($cd){
	  	global $COURSE_FILE_PATH;
		$tmp = array();
		$res = db_query("select homework_no from `homework` where begin_course_cd=$cd;");
		while($r = $res->fetchRow(DB_FETCHMODE_ASSOC))
			array_push($tmp, $r['homework_no']);
		for($i = 0 ; $i < count($tmp) ; $i++){
			delete_assignment($cd , $tmp[$i]);
		}
		
		SureRemoveDir($COURSE_FILE_PATH . $cd . "/homework");
	}

	//examine是由begin_course_cd和test_no組成的主鍵
	//此函式僅處理資料庫內容，並無處理相關檔案
	function delete_examine($cd, $no){
		global $DB_CONN;
		db_query("delete from `test_course_ans` where begin_course_cd=$cd and test_no=$no;");
//print "select number_id from `course_percentage` where begin_course_cd=$cd and percentage_type=1 and percentage_num=$no;";
		$number_id = $DB_CONN->getOne("select number_id from `course_percentage` where begin_course_cd=$cd and percentage_type=1 and percentage_num=$no;");
		//學生的成績

		//modify by rja
		//若 $number_id 為空，代表是自我評量
		if (!empty($number_id)){
			//這應該是學期成績配分 
			db_query("delete from `course_percentage` where begin_course_cd=$cd and percentage_type=1 and percentage_num=$no and number_id=$number_id;");

			//課程中的成績
			db_query("delete from `course_concent_grade` where begin_course_cd=$cd and number_id=$number_id;");
		}
		//end of modify
		//試題內容
		db_query("delete from `test_course` where begin_course_cd=$cd and test_no=$no;");
		//測驗設定
		db_query("delete from `test_course_setup` where begin_course_cd=$cd and test_no=$no;");
	}

	function delete_examine_by_course_cd($cd){
	  	global $COURSE_FILE_PATH;
		$tmp = array();
		$res = db_query("select test_no from `test_course_setup` where begin_course_cd=$cd;");
		while($r = $res->fetchRow(DB_FETCHMODE_ASSOC))
			array_push($tmp, $r['test_no']);
		for($i = 0 ; $i < count($tmp) ; $tmp)
			delete_examine($cd , $tmp[$i]);
		SureRemoveDir($COURSE_FILE_PATH . $cd . "/examine");
	}

	//刪除教材資料
	function delete_textbook($cd){
	  //刪除教材與課程的關聯性
	  db_query("delete from `class_content_current` where begin_course_cd = '$cd'");  
	  //刪除教材學習追蹤資料
	  db_query("delete from student_learning where begin_course_cd = '$cd'");

	}
	//需要刪除教材時請呼叫這個並傳入$content_cd , 
	// 並請順便呼叫 sync_content_mediaStreaming_link 同步ftp可見的 教材與隨選視訊的link 
	function delete_content_mediaStreaming($content_cd) {
	  //取得教材相關lib ex: 從conetent_cd 拿到teacher_id
	  include('./content.php');
	  global $MEDIA_FILE_PATH;
	  db_query('delete from on_line where content_cd='.$content_cd);
	  
	  $teacher_id =  get_Teacher_id($content_cd);
	  $target_dir = $MEDIA_FILE_PATH.$teacher_id.'/'.$content_cd.'/' ;
	  SureRemoveDir($target_dir, false);
	}
	
	//刪除合作學習相關資料
	function delete_collaborative_homework($cd){
	  global $DB_CONN;
	  //刪除分組學生的成員資料
	  db_query("delete from groups_member where begin_course_cd = '$cd'");
	  //刪除組別資料
	  db_query("delete from info_groups where begin_course_cd = '$cd'");
	  //刪除專案題目內容資料
	  db_query("delete from projectwork where begin_course_cd = '$cd'");
	  //刪除專案屬性資料
	  db_query("delete from project_data where begin_course_cd = '$cd'");
	  //刪除組別互評成績
	  db_query("delete from take_groups_score where begin_course_cd = '$cd'");
	  //刪除學生互評成績
	  db_query("delete from take_student_score where begin_course_cd = '$cd'");
	}
	
	
	//刪除某課程所有公告資料
	function delete_course_news($begin_course_cd)
	{
		global $DB_CONN;
		
		//先取得此課程所有公告的new_cd
		$sql = "SELECT 
					* 
				FROM 
					news_target 
				WHERE 
					begin_course_cd=$begin_course_cd
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		if($res->numRows() <= 0)	return 0;	//該課程沒有公告,直接結束function
		
		$rowCounter = 0;			
		while( $res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{
			$newsList[$rowCounter++] = $row[news_cd];
		}

		
		foreach($newsList as $news_cd)
		{
			//判斷是否有上傳檔案在伺服器
			$sql = "SELECT * FROM news_upload WHERE news_cd=$news_cd AND if_url=0";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			
			$newsNum = $res->numRows();
			if($newsNum > 0)
			{
				$res->fetchInto($row, DB_FETCHMODE_ASSOC);
				$fileName = $row[file_url];
	
				//刪除檔案
				@unlink($fileName);
			}
			
			//從Table news_upload中刪除資料
			$sql = "DELETE FROM news_upload WHERE news_cd=$news_cd";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			
			//從Table news_target中刪除資料
			$sql = "DELETE FROM news_target WHERE news_cd=$news_cd";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			
			//從Table news中刪除資料
			$sql = "DELETE FROM news WHERE news_cd=$news_cd";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
		}
	}
	
	
	//刪除某課程所有學習追蹤資料
	function delete_course_learning_tracking($begin_course_cd)
	{
		global $DB_CONN;
		
		//刪除事件的統計
		$sql = "DELETE FROM event_statistics WHERE begin_course_cd=$begin_course_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		//刪除所有事件
		$sql = "DELETE FROM event WHERE begin_course_cd=$begin_course_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
	}
	
	
	//刪除某課程所有點名資料
	function delete_course_roll_book($begin_course_cd)
	{
		global $DB_CONN;
		
		 
		//刪除點名狀態配分
		$sql = "DELETE FROM roll_book_status_grade WHERE begin_course_cd=$begin_course_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		//刪除所有點名
		$sql = "DELETE FROM roll_book WHERE begin_course_cd=$begin_course_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
	}
	
	//刪除某課程所有成績資料
	function delete_course_grade($begin_course_cd)
	{
		global $DB_CONN;
				 
		//刪除分數轉換設定
		$sql = "DELETE FROM grade_convert WHERE begin_course_cd=$begin_course_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		//刪除成績是否顯示的設定
		$sql = "DELETE FROM course_grade_report WHERE begin_course_cd=$begin_course_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		//刪除所有學員的成績
		$sql = "DELETE FROM course_concent_grade WHERE begin_course_cd=$begin_course_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		//刪除所有的成績設定
		$sql = "DELETE FROM course_grade WHERE begin_course_cd=$begin_course_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
	}
	
	
	//刪除某課程所有討論區資料
	function delete_course_discuss_area($begin_course_cd)
	{
		global $DB_CONN, $COURSE_FILE_PATH;
				 
		//設定檔案路徑
		$FILE_PATH = $COURSE_FILE_PATH . $begin_course_cd . "/Discuss_Area/";
		
		//從Table discuss_hoarding刪除被收藏的文章
		$sql = "DELETE FROM discuss_hoarding WHERE begin_course_cd=$begin_course_cd";	
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		//刪除所有主題所有文章的檔案
		$sql = "SELECT * FROM discuss_content WHERE begin_course_cd=$begin_course_cd";	
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		$resultNum = $res->numRows();
		if($resultNum > 0)
		{
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{
				
				$fileName = $row[file_picture_name];

				//刪除檔案
				@unlink($FILE_PATH . $fileName);
			}
		}
		
		//從Table discuss_content刪除回覆的文章
		$sql = "DELETE FROM discuss_content WHERE begin_course_cd=$begin_course_cd";	
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
	
		//從Table discuss_subject刪除文章
		$sql = "DELETE FROM discuss_subject WHERE begin_course_cd=$begin_course_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		//從Table discuss_menber_groups刪除小組成員資料
		$sql = "DELETE FROM discuss_menber_groups WHERE begin_course_cd=$begin_course_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		//從Table discuss_groups刪除小組討論區的資料
		$sql = "DELETE FROM discuss_groups WHERE begin_course_cd=$begin_course_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		//從Table discuss_subscribe刪除被訂閱的討論區
		$sql = "DELETE FROM discuss_subscribe WHERE begin_course_cd=$begin_course_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		//從Table discuss_info刪除所有討論區
		$sql = "DELETE FROM discuss_info WHERE begin_course_cd=$begin_course_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
	}
	
	//刪除某課程所有電子報資料
	function delete_course_epaper($begin_course_cd)
	{
		global $DB_CONN, $COURSE_FILE_PATH;		
		
		$FILE_PATH = $COURSE_FILE_PATH . $begin_course_cd . "/EPaper/";

		//從Table person_epaper中刪個人訂閱的課程電子報
		$sql = "DELETE FROM person_epaper WHERE begin_course_cd=$begin_course_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		
		//刪除電子報檔案&取得所有電子報的編號
		$sql = "SELECT * FROM e_paper WHERE begin_course_no=$begin_course_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		$resultNum = $res->numRows();
		if($resultNum > 0)
		{
			$rowCounter = 0;
			
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{			
				$epaperList[$rowCounter++] = $row[epaper_cd];
				
				$fileName = $row[epaper_file_url];
			
				//刪除檔案
				@unlink($FILE_PATH . $fileName);
			}
		}
		
		foreach($epaperList as $epaper_cd)
		{
			//從Table course_epaper中刪除資料
			$sql = "DELETE FROM course_epaper WHERE epaper_cd=$epaper_cd";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
						
			//從Table e_paper中刪除資料
			$sql = "DELETE FROM e_paper WHERE epaper_cd=$epaper_cd";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
		}
	}
	
	//刪除某課程證書資料
	function delete_course_certificate($begin_course_cd)
	{
		global $DB_CONN, $COURSE_FILE_PATH;		
		
		$FILE_PATH = $COURSE_FILE_PATH . $begin_course_cd . "/EPaper/";		
		$credential_type_cd = 1;							//證書形式編號
		
		//刪除圖片檔案
		$sql = "SELECT * FROM credential_type WHERE begin_course_no=$begin_course_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		$resultNum = $res->numRows();
		if($resultNum > 0)
		{
			$rowCounter = 0;
			
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
				
			//刪除外框檔案
			$fileName = $row[sash_template_no];
			@unlink($fileName);
			
			//刪除中間浮水印檔案
			$fileName = $row[emboss_no2 ];
			@unlink($fileName);
		}
		
		//刪除證書內容Table credential_content
		$sql = "DELETE FROM credential_content WHERE credential_type_cd=$credential_type_cd AND begin_course_no=$begin_course_cd";	
		$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
		
		//刪除證書設定Table credential_type
		$sql = "DELETE FROM credential_type WHERE credential_type_cd=$credential_type_cd AND begin_course_no=$begin_course_cd";	
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
	}
?>

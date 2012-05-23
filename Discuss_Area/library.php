<?	
//只用由討論區的library

	//刪除一個討論區的所有資料
	function deleteOneDiscussArea($DB_CONN, $begin_course_cd, $discuss_cd, $COURSE_FILE_PATH)
	{
		//設定檔案路徑
		$FILE_PATH = $COURSE_FILE_PATH . $begin_course_cd . "/Discuss_Area/";
		
		//從Table discuss_hoarding刪除被收藏的文章
		$sql = "DELETE FROM discuss_hoarding WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd";	
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		//刪除所有主題所有文章的檔案
		$sql = "SELECT * FROM discuss_content WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd";	
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
		$sql = "DELETE FROM discuss_content WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd";	
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
	
		//從Table discuss_subject刪除文章
		$sql = "DELETE FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		//從Table discuss_menber_groups刪除小組成員資料
		$sql = "DELETE FROM discuss_menber_groups WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		//從Table discuss_groups刪除小組討論區的資料
		$sql = "DELETE FROM discuss_groups WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		//從Table discuss_subscribe刪除被訂閱的討論區
		$sql = "DELETE FROM discuss_subscribe WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		//從Table discuss_info刪除這個討論區
		$sql = "DELETE FROM discuss_info WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
	}


/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/
//讓合作學習使用的函式	
	function DiscussArea_newDiscussArea($DB_CONN, $begin_course_cd, $homework_no, $homework_group_no)
	{
		//小組討論區
			
		//設定存取權限is_public
		$is_public = 'n';
		
		//從Table discuss_groups中取得新的group_no
		$sql = "SELECT 
					* 
				FROM 
					discuss_groups 
				WHERE 
					begin_course_cd=$begin_course_cd 
				ORDER BY 
					group_no DESC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
			
		$resultNum = $res->numRows();
		if($resultNum == 0)
		{
			$group_no = 1;
		}
		else
		{			
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			
			$group_no = $row[group_no] + 1;
		}
		
		
		//從Table discuss_info中取得新的discuss_cd
		$sql = "SELECT 
					* 
				FROM 
					discuss_info 
				WHERE 
					begin_course_cd=$begin_course_cd 
				ORDER BY 
					discuss_cd DESC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
			
		$disscussAreaNum = $res->numRows();
		if($disscussAreaNum == 0)
		{
			$discuss_cd = 1;
		}
		else
		{
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		
			$discuss_cd = $row[discuss_cd] + 1;
		}
		
		
		//新增資料到Table discuss_info
		$discuss_name = "作業" . $homework_no . " - 第" . $homework_group_no . "組討論區";
		$discuss_title = "作業" . $homework_no . "討論區";
		$sql = "INSERT INTO discuss_info 
							(
								begin_course_cd, 
								discuss_cd, 
								discuss_name, 
								discuss_title
							) VALUES (
								$begin_course_cd, 
								$discuss_cd, 
								'$discuss_name', 
								'$discuss_title'
							)";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		//新增資料到Table discuss_groups
		$sql = "INSERT INTO discuss_groups 
							(
								begin_course_cd, 
								discuss_cd, 
								group_no,
								homework_group_no,
								homework_no, 
								is_public
							) VALUES (
								$begin_course_cd, 
								$discuss_cd, 
								$group_no, 
								$homework_group_no, 
								$homework_no, 
								'$is_public'
							)";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		return true;
	}


/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/
//讓合作學習使用的函式	
	function DiscussArea_deleteDiscussArea($DB_CONN, $begin_course_cd, $homework_no, $homework_group_no)
	{
		//從Table discuss_groups中取得discuss_cd
		if($homework_group_no == -1)
		{
			$sql = "SELECT 
						* 
					FROM 
						discuss_groups A 
					WHERE 
						A.begin_course_cd = $begin_course_cd AND 
						A.homework_no = $homework_no 
					";
		}
		else
		{
			$sql = "SELECT 
						* 
					FROM 
						discuss_groups A 
					WHERE 
						A.begin_course_cd = $begin_course_cd AND 
						A.homework_group_no = $homework_group_no AND 
						A.homework_no = $homework_no 
					";
		}
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		$resultNum = $res->numRows();
		if($resultNum > 0)
		{
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{	
				$discuss_cd = $row[discuss_cd];
			
				@deleteOneDiscussArea($DB_CONN, $begin_course_cd, $discuss_cd);
				//miss argument 4
			}
		}
		
		return true;
	}


/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/
//讓合作學習使用的函式		
	function DiscussArea_addUser($DB_CONN, $begin_course_cd, $homework_no, $homework_group_no, $student_id)
	{
		//從Table discuss_groups中取得discuss_cd, group_no
		$sql = "SELECT 
					* 
				FROM 
					discuss_groups A 
				WHERE 
					begin_course_cd = $begin_course_cd AND 
					homework_group_no = $homework_group_no AND 
					homework_no = $homework_no 
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		$resultNum = $res->numRows();
		if($resultNum > 0)
		{
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		
			$discuss_cd = $row[discuss_cd];
			$group_no = $row[group_no];
			
			
			//新增資料到Table discuss_menber_groups
			$sql = "INSERT INTO discuss_menber_groups 
								( 
									begin_course_cd, 
									discuss_cd, 
									group_no, 
									homework_group_no, 
									homework_no, 
									student_id 
								) VALUES ( 
									$begin_course_cd, 
									$discuss_cd, 
									$group_no, 
									$homework_group_no, 
									$homework_no, 
									$student_id 
								)";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			
			return true;
		}
	
		return false;
	}
	
/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/	
//讓合作學習使用的函式	
	function DiscussArea_deleteUser($DB_CONN, $begin_course_cd, $homework_no, $homework_group_no, $student_id)
	{
		//從Table discuss_menber_groups刪除小組成員資料
		if($homework_group_no == -1 && $student_id == -1)
		{
			$sql = "DELETE FROM discuss_menber_groups 
					WHERE 
						begin_course_cd=$begin_course_cd AND 
						homework_no=$homework_no
						";
		}
		elseif($student_id == -1)
		{
			$sql = "DELETE FROM discuss_menber_groups 
					WHERE 
						begin_course_cd=$begin_course_cd AND 
						homework_no=$homework_no AND 
						homework_group_no=$homework_group_no
					";
		}
		else
		{
			$sql = "DELETE FROM discuss_menber_groups 
					WHERE 
						begin_course_cd=$begin_course_cd AND 
						homework_no=$homework_no AND 
						homework_group_no=$homework_group_no AND 
						student_id=$student_id
					";
		}
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());		
	}
	
/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/	
//讓合作學習使用的函式	

	//usage
	//$behavior = "teacher";//teacher, student
	//echo "<a href=\"" . DiscussArea_getLinkIntoArticleList($DB_CONN, $HOMEURL, $begin_course_cd, $homework_no, $homework_group_no, $behavior) . "\">連結</a>";
	function DiscussArea_getLinkIntoArticleList($DB_CONN, $HOMEURL, $begin_course_cd, $homework_no, $homework_group_no, $behavior)
	{		
		//從Table discuss_groups中取得discuss_cd
		$sql = "SELECT 
					* 
				FROM 
					discuss_groups A 
				WHERE 
					begin_course_cd = $begin_course_cd AND 
					homework_group_no = $homework_group_no AND 
					homework_no = $homework_no 
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();
		if($resultNum > 0)
		{
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		
			$discuss_cd = $row[discuss_cd];
			
			$URL = "Discuss_Area/discussAreaList_intoArticleList.php?behavior=$behavior&ArticleList=DisableReturn&discuss_cd=$discuss_cd";
		}
		
		return $URL;	
	}	
?>

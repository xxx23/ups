<?
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");

	//從SESSION抓取資料
	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼

	$behavior = $_POST['behavior'];					//取得行為
	
	$discuss_cd = $_POST['discuss_cd'];					//取得討論區編號	
	
	$discuss_name = $_POST["discuss_name"];
	$discuss_title = $_POST["discuss_title"];
	//$discuss_type = $_POST["discuss_type"];
	$access = $_POST["access"];	
	
	//判斷討論區類型
    $new_discuss_name = $discuss_name;

    $is_public = 'n';
    $group_no = 0;

    $showType = "Course";
    $new_discuss_name = "社群_" . $new_discuss_name;
/*
	if($discuss_type == 0) 
	{
		//ㄧ般討論區
		
		$is_public = 'y';
		$group_no = 0;
		
		$showType = "Course";
	}
	else if($discuss_type == 1) 
	{
		//小組討論區
		
		//設定存取權限is_public
		if($access == 0)	$is_public = 'y';
		else				$is_public = 'n';
		
		//從Table discuss_groups中取得小組編號group_no
		$sql = "SELECT 
					* 
				FROM 
					discuss_groups 
				WHERE 
					begin_course_cd=$begin_course_cd AND 
					discuss_cd = $discuss_cd
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
			
		$resultNum = $res->numRows();
		if($resultNum > 0)		
		{			
			//原本就是小組討論區
			//使用原本的group_no
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			
			$group_no = $row[group_no];
			
			if($group_no == 0)
			{
				//從其他類型的討論區變成小組討論區
				//必須取得新的group_no
				
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
			}
		}
		else
		{
			echo "Error !!!!!!";return;			
		}
		
		$showType = "Group";
	}
	else if($discuss_type == 2) 
	{
		//精華區
		
		$new_discuss_name = "精華區_" . $new_discuss_name;
		
		$is_public = 'y';
		$group_no = 0;
		
		$showType = "Essence";
	}
 */
	//更新資料到Table discuss_info
	$sql = "UPDATE discuss_info 
					SET 
						discuss_name='$new_discuss_name', 
						discuss_title='$discuss_title' 
					WHERE 
						begin_course_cd=$begin_course_cd AND 
						discuss_cd=$discuss_cd";
	$sth = $DB_CONN->prepare($sql);
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	
	//更新資料到Table discuss_groups 
	$sql = "UPDATE discuss_groups  
					SET 
						group_no=$group_no, 
						is_public='$is_public' 
					WHERE 
						begin_course_cd=$begin_course_cd AND 
						discuss_cd=$discuss_cd";
	$sth = $DB_CONN->prepare($sql);
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	
    //更新Table discuss_menber_groups的資料
    /*
	if($discuss_type != 1) 
	{
		//非小組討論區
		
		//從Table discuss_menber_groups刪除小組成員資料
		$sql = "DELETE FROM discuss_menber_groups WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd";
		$sth = $DB_CONN->prepare($sql);		
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());
	}
	elseif($discuss_type == 1) 
	{
		//小組討論區
	
		//從Table discuss_menber_groups刪除小組成員資料
		$sql = "DELETE FROM discuss_menber_groups WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd";
		$sth = $DB_CONN->prepare($sql);		
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());	
		
		
		$studentNum = $_POST["studentNum"];	
			
		for($studentCounter=0; $studentCounter<$studentNum; $studentCounter++)
		{				
			if(isset($_POST["student_" . $studentCounter]) == true)
			{
				$student_id = $_POST["student_" . $studentCounter];
				
				//新增資料到Table discuss__menber_groups
				$sql = "INSERT INTO discuss_menber_groups 
									( 
										begin_course_cd, 
										discuss_cd, 
										group_no, 
										student_id 
									) VALUES ( 
										$begin_course_cd, 
										$discuss_cd, 
										$group_no, 
										$student_id 
									)";
				$sth = $DB_CONN->prepare($sql);
				$res = $DB_CONN->execute($sth);
				if (PEAR::isError($res))	die($res->getMessage());
			}
		}
	}
     */
	
	
	
	//導向到finishPage
	header("location: showGroupDiscussAreaList.php?behavior=$behavior&showType=$showType");

?>

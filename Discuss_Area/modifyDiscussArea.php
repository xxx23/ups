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
	$discuss_cd = $_GET['discuss_cd'];					//取得討論區編號

	$behavior = $_GET['behavior'];						//取得行為

	require_once($HOME_PATH . 'library/smarty_init.php');
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	$tpl->assign("discuss_cd", $discuss_cd);

	$tpl->assign("behavior", $behavior);


	if($behavior == "admin")//系統管理者
	{

	}
	else if($behavior == "teacher")//教師
	{

	}
	else if($behavior == "student")//學生
	{
		$tpl->assign("displayType", "onlyGroup");
		$tpl->assign("discuss_type", 1);
	}
	else//其它
	{
	
	}

	//從Table discuss_info, discuss_groups搜尋某個討論區
	$sql = "SELECT A.*, B.group_no, B.is_public FROM discuss_info A, discuss_groups B WHERE A.begin_course_cd=$begin_course_cd AND A.discuss_cd=$discuss_cd AND A.begin_course_cd=B.begin_course_cd AND A.discuss_cd=B.discuss_cd";
    $res = db_query($sql);
	$discussAreaNum = $res->numRows();
	if($discussAreaNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);

		$discuss_name = $row[discuss_name];
		if($row[group_no] == 0)
		{	
			if( strncmp($discuss_name, "精華區_", strlen("精華區_")) == 0)	
			{
				$discuss_type = 2;
				$discuss_name = str_replace("精華區_", "", $discuss_name);
			}
			else
			{
				$discuss_type = 0;
			}
		}
		else
		{					
			$discuss_type = 1;
		}
		
		$tpl->assign("discuss_name", $discuss_name);
		$tpl->assign("discuss_title", $row[discuss_title]);
		$tpl->assign("discuss_type", $discuss_type);
		
		if($row[is_public] == 'y')	$tpl->assign("access", 0);
		else						$tpl->assign("access", 1);
	}


	
	//從Table take_course取得課程學生名單	
	$sql = "SELECT 
				A.personal_id, 
				B.personal_name 
			FROM 
				take_course A, 
				personal_basic B 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.personal_id = B.personal_id 
			ORDER BY 
				A.personal_id ASC
			";
    $res = db_query($sql);
	$resultNum = $res->numRows();
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$studentList[$rowCounter][counter] = $rowCounter;
			$studentList[$rowCounter][student_name] = $row[personal_name];
			$studentList[$rowCounter][student_id] = $row[personal_id];
			$studentList[$rowCounter][isInGroup] = 0;
			
			$rowCounter++;
		}
		$studentNum = $rowCounter;
		$tpl->assign("studentNum", $studentNum);		
	}

	//設定有在小組的成員名單
	if($discuss_type == 1)
	{
		//小組討論區
		
		//從Table discuss_menber_groups取得小組成員名單
		$sql = "SELECT 
					A.student_id 
				FROM 
					discuss_menber_groups A 
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.discuss_cd = $discuss_cd 
				ORDER BY 
					A.student_id ASC
				";
        $res = db_query($sql);
		$resultNum = $res->numRows();
		if($resultNum > 0)
		{
			$studentListCounter = 0;
			
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{	
				$isError = 0;
				
				$new_student_id = $row[student_id];
				
				//判斷是哪個學生的
				while($studentList[$studentListCounter][student_id] != $new_student_id)
				{
					$studentListCounter++;
					
					if($studentListCounter >= $studentNum)
					{	
						$isError = 1;
						//echo "<font color='red'>error2</font><br>";
						break;
					}
				}
				if($isError == 1)
				{	
					$studentListCounter = 0;
					continue;
				}
				
				//echoData($studentList[$studentListCounter][student_name]);//for test
				
				$studentList[$studentListCounter][isInGroup] = 1;
			}
		}
	}

	//輸出課程學生清單
	$tpl->assign("studentList", $studentList);

	//目前的Action
	$tpl->assign("action", "modify");

	//目前的頁面
	$tpl->assign("currentPage", "modifyDiscussArea.php");
	
	assignTemplate($tpl, "/discuss_area/discussAreaInput.tpl");
?>

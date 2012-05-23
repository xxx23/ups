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

	$behavior = $_GET['behavior'];						//取得行為

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
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
	
	//輸出課程學生清單
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
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
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
			
			//學生在新增小組討論區時, 預設會將自己加入
			if($behavior == "student" && $studentList[$rowCounter][student_id] == $personal_id)//學生
			{
			 	$studentList[$rowCounter][isInGroup] = 1;
			}
			
			
			$rowCounter++;
		}
		$studentNum = $rowCounter;
		$tpl->assign("studentNum", $studentNum);
		$tpl->assign("studentList", $studentList);
	}

	//目前的Action
	$tpl->assign("action", "new");

	//目前的頁面
	$tpl->assign("currentPage", "newGroupDiscussArea.php");
	
	assignTemplate($tpl, "/discuss_area/groupDiscussAreaInput.tpl");
?>

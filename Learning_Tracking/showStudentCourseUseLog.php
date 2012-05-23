<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Learning_Tracking/";

	$begin_course_cd = $_SESSION['begin_course_cd'];		//取得課程代碼

	$tpl = new Smarty;
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
         
	//取得action
	$action = $_POST['action'];	
	if( isset($action) == false)	$action = "none";

	if($action == "showStudentLog")
	{
		$student_id = $_POST["student_id"];
		
		$tpl->assign("student_id", $student_id);
		
		$tpl->assign("content", "showStudentCourseUseLogAction.php?student_id=$student_id");
	}

	//取得課程的學生
	$sql = "SELECT 
				B.* 
			FROM 
				take_course A, 
				personal_basic B 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.personal_id = B.personal_id 
			ORDER BY B.personal_id ASC";	
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();
	
	if($resultNum > 0)
	{
		$rowCounter = 0;

		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{
			$studentList[$rowCounter] = 
					array(	
							"name" => $row[personal_name], 
							"personal_id" => $row[personal_id]
						);
			
			$rowCounter++;
		}
		$studentNum = $rowCounter;
		
		$tpl->assign("studentNum", $studentNum);
		$tpl->assign("studentList", $studentList);
	}

	//目前的頁面
	$tpl->assign("currentPage", "showStudentCourseUseLog.php");
	
	assignTemplate($tpl, "/learning_tracking/studentCourseUseLog.tpl");
?>

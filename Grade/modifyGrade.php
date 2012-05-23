<?
/*
DATE:   2007/06/26
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH . $CSS_VERSION_PATH;
	$absoluteURL = $HOMEURL . "Grade/";	

	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	$tpl->assign("isBackOn", 1);					//是否允許回上一頁
	$tpl->assign("isStudentInputOn", 1);			//是否允許輸入學生成績
	
	//輸出成績編號
	$number_id = $_GET['id'];							//取得number_id
	if( isset($number_id) == false)	$number_id = $_POST['id'];
	$tpl->assign("number_id", $number_id);
	
	//目前的Action
	$tpl->assign("action", "modify");
	
	//網頁標題
	$tpl->assign("title", "修改成績");
	
	$incomingPage = $_GET['currentPage'];
	if( isset($incomingPage) == false)	$incomingPage = $_POST['currentPage'];
	$tpl->assign("incomingPage", $incomingPage);	
	//從Table course_percentage搜尋這項成績所佔的百分比
	$sql = "SELECT 
				A.percentage 
			FROM 
				course_percentage A  
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.number_id = $number_id 
                ";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();

	if($resultNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		$percentage = $row[percentage];
		
		$tpl->assign("percentage", $percentage);
	}
	
	
	//從Table course_concent_grade搜尋這項成績的所有學生成績
	$sql = "SELECT 
				A.student_id, 
				A.concent_grade grade
			FROM 
				course_concent_grade A  
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.number_id = $number_id 
			ORDER BY 
            A.student_id ASC";
    $res = db_query($sql);
    $resultNum = $res->numRows();
	if($resultNum > 0)
	{	
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
        {
            //以student id作為index 做出 id -grade的對應表    
            $gradeTable["{$row['student_id']}"] = $row['grade'];

		}
		$gradeNum =$res->numRows();
	}

	//從Table take_course搜尋這堂課的所有學生
    $sql = "SELECT B.personal_id, B.personal_name
			FROM take_course A,personal_basic B 
            WHERE A.begin_course_cd = $begin_course_cd 
            AND	A.personal_id = B.personal_id
            AND  A.allow_course = 1
            AND A.status_student = 1
			ORDER BY B.personal_id ASC";
    $res = db_query($sql);
	$resultNum = $res->numRows();

	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
        {	
            $studentGrade = (int) $gradeTable["{$row['personal_id']}"];
            $studentList[$rowCounter] = 
					array(
							"counter" => $rowCounter+1, 
							"personal_id" => $row['personal_id'], 
							"personal_name" => $row['personal_name'], 
							"grade" => $studentGrade
							);
			$rowCounter++;
		}
		$studentNum = $res->numRows();
        		
		$tpl->assign("studentNum", $studentNum);
		$tpl->assign("studentList", $studentList);
	}
	
	assignTemplate($tpl, "/grade/gradeInput.tpl");
 
?>

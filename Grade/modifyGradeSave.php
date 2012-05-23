<?
/*
DATE:   2007/06/26
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
    require_once($RELEATED_PATH . "library/filter.php");
    $IMAGE_PATH = $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "Grade/";
	
	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼

	//取得成績資料
	$grade_name=$_POST['name'];
	$number_id = required_param('number_id',PARAM_TEXT);
	$percentage = required_param('percentage',PARAM_INT);
	
	//取得學生數目
	$studentNum = required_param('studentNum',PARAM_INT);
	
	//更新成績資料到Table course_percentage
	$sql = "UPDATE 
				course_percentage 
			SET 
				percentage=$percentage 
			WHERE 
				begin_course_cd = $begin_course_cd AND 
				number_id = $number_id
			";
	$sth = $DB_CONN->prepare($sql);
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());	

	
	//更新學生成績資料到Table course_concent_grade
	for($studentCounter = 0; $studentCounter<$studentNum; $studentCounter++)
	{
		$nameTmp = "id_" . ($studentCounter+1);		
		$student_id = $_POST[$nameTmp];	//取得personal_id
		
		$nameTmp = "grade_" . ($studentCounter+1);		
		$grade = $_POST[$nameTmp];	//取得成績
		
		//先判斷是否存在學生成績
		//從Table course_concent_grade搜尋這個學生的這項成績
		$sql = "SELECT 
					A.student_id, 
					A.concent_grade grade
				FROM 
					course_concent_grade A  
				WHERE 
					A.begin_course_cd = $begin_course_cd AND 
					A.number_id = $number_id AND 
					A.student_id = $student_id
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
	    $resultNum = $res->numRows();

		if($resultNum > 0)
		{
			//存在學生成績
			
			//更新成績資料到Table course_concent_grade
			$sql = "UPDATE 
						course_concent_grade 
					SET 
						concent_grade=$grade 
					WHERE 
						begin_course_cd = $begin_course_cd AND 
						number_id = $number_id AND 
						student_id = $student_id
                        ";
            
			$sth = $DB_CONN->prepare($sql);
			$res = $DB_CONN->execute($sth);
			if (PEAR::isError($res))	die($res->getMessage());	
        }
		else
		{
			//不存在學生成績
			
			//從Table course_percentage取得相關資料
			$sql = "SELECT 
						* 
					FROM 
						course_percentage A  
					WHERE 
						A.begin_course_cd = $begin_course_cd AND 
						A.number_id = $number_id
					";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			$percentage_type = $row[percentage_type];
			$percentage_num = $row[percentage_num];
		
			//新增學生成績到Table course_concent_grade
			$sql = "INSERT INTO course_concent_grade 
							(
								begin_course_cd, 
								number_id, 
								percentage_type,
								percentage_num,
								student_id, 
								concent_grade
							) VALUES (
								$begin_course_cd, 
								$number_id, 
								$percentage_type, 
								$percentage_num, 
								$student_id, 
								$grade
							)";
			$sth = $DB_CONN->prepare($sql);
			$res = $DB_CONN->execute($sth);
			if (PEAR::isError($res))	die($res->getMessage());
        }
	}

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	$title = "修改成績";
	$content = "修改成功";	
	$content = $content . "<br><a href='showGradeList.php'>返回 觀看成績</a>";

	$tpl->assign("title", $title);
	$tpl->assign("content", $content);
	
	assignTemplate($tpl, "/grade/message.tpl");
?>

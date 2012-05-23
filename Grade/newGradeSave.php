<?
/*
DATE:   2007/05/14
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "Grade/";
	
	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼

	//取得成績資料
	$grade_name = $_POST['name'];                           //取得成績名稱 
	$percentage_type = $_POST['percentage_type'];
	$percentage = $_POST['percentage'];


	//取得學生數目
	$studentNum = $_POST['studentNum'];

	$sql = "INSERT INTO `test_course_setup` (
			    `begin_course_cd` ,
			    `test_no` ,
			    `test_type` ,
			    `test_name` ,
			    `is_online` ,
			    `random` ,
			    `d_test_beg` ,
			    `d_test_end` ,
			    `d_test_public` ,
			    `percentage` ,
			    `grade_public` ,
			    `ans_public` ,
			    `remind` 
			  )
			  	
        VALUES ($begin_course_cd , NULL , $percentage_type , \"$grade_name\" ,0 , NULL , NULL , NULL , NULL , $percentage , '0', '0', '0')"; 
	
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	
	//從Table course_percentage取得新的number_id
/*
	$sql = "SELECT 
				* 
			FROM 
				course_percentage 
			WHERE 
				begin_course_cd=$begin_course_cd 
			ORDER BY 
				number_id DESC
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();
	
	if($resultNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
	
		$number_id = $row[number_id]+1;
	}
	else
	{
		$number_id = 1;
	}*/
	
	
	//從Table course_percentage取得新的percentage_num
	$sql = "SELECT 
				* 
			FROM 
				course_percentage 
			WHERE 
				begin_course_cd=$begin_course_cd AND 
				percentage_type='$percentage_type' 
			ORDER BY 
				percentage_num DESC
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();
	
	if($resultNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);	
	
		$percentage_num = $row[percentage_num]+1;
	}
	else
	{
		$percentage_num = 1;
	}
	
	//新增成績資料到Table course_percentage
	$sql = "INSERT INTO course_percentage 
					(
						begin_course_cd, 
						percentage_type,
						percentage_num,
						percentage
					) VALUES (
						$begin_course_cd, 
						$percentage_type, 
						$percentage_num, 
						$percentage
					)";
	$sth = $DB_CONN->prepare($sql);
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());

	$number_id = db_getOne("select number_id from `course_percentage` where begin_course_cd=$begin_course_cd and percentage_type=$percentage_type and percentage_num=$percentage_num;");
	
	//新增學生成績資料到Table course_concent_grade
	for($studentCounter = 0; $studentCounter<$studentNum; $studentCounter++)
	{
		$nameTmp = "id_" . ($studentCounter+1);		
		$student_id = $_POST[$nameTmp];	//取得personal_id
		
		$nameTmp = "grade_" . ($studentCounter+1);		
		$grade = $_POST[$nameTmp];	//取得成績
		
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
	
	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	$title = "新增成績";
	$content = "新增成功";	
	$content = $content . "<br><a href='newGrade.php'>繼續 新增成績</a>";

	$tpl->assign("title", $title);
	$tpl->assign("content", $content);
	
	assignTemplate($tpl, "/grade/message.tpl");
?>

<?
/*
DATE:   2007/06/29
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "Roll_Call/";
	
	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼

	//取得成績百分比
	$percentage = $_POST['percentage'];
	
	//取得學生數目
	$studentNum = $_POST['studentNum'];
	
	//從Table roll_book取得新的roll_id
	$sql = "SELECT 
				* 
			FROM 
				roll_book 
			WHERE 
				begin_course_cd=$begin_course_cd 
			ORDER BY roll_id DESC
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();
	
	if($resultNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
	
	
		$roll_id = $row[roll_id]+1;
	}
	else
	{
		$roll_id = 1;
	}
	
	
	//取得roll_date
	$roll_date = $_POST['year'] . $_POST['month'] . $_POST['day'] . "000000";

	//新增學生成績資料到Table roll_book
	for($studentCounter = 0; $studentCounter<$studentNum; $studentCounter++)
	{
		$nameTmp = "id_" . ($studentCounter+1);		
		$student_id = $_POST[$nameTmp];	//取得personal_id
		
		$nameTmp = "state_" . ($studentCounter+1);		
		$state = $_POST[$nameTmp];	//取得成績
		
		//新增學生成績到Table roll_book
		$sql = "INSERT INTO roll_book 
						(
							begin_course_cd, 
							roll_id, 
							personal_id,
							roll_date,
							state, 
							email_concent,
							if_email
						) VALUES (
							$begin_course_cd, 
							$roll_id, 
							$student_id, 
							$roll_date, 
							$state, 
							'', 
							''
						)";
		$sth = $DB_CONN->prepare($sql);
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());
	}
	
	
	
	//從Table course_percentage取得新的number_id
/*	$sql = "SELECT 
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

	//設定percentage_num
	$percentage_num = $roll_id;

	
	//新增點名成績資料到Table course_percentage
	$percentage_type = 3;
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
		
		$nameTmp = "state_" . ($studentCounter+1);		
		$state = $_POST[$nameTmp];	//取得成績
		
		//取得這個狀態的配分
		$sql = "SELECT 
					* 
				FROM 
					roll_book_status_grade 
				WHERE 
					begin_course_cd=$begin_course_cd AND 
					status_id=$state;
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		$ResultNum = $res->numRows();
		
		if($ResultNum == 0)	
		{
			switch($state)
			{
			case 0:	//出席
					$grade = 100;
					break;
			case 1:	//缺席
					$grade = 0;
					break;
			case 2:	//遲到
					$grade = 80;
					break;
			case 3:	//早退
					$grade = 80;
					break;
			case 4:	//請假
					$grade = 100;
					break;
			case 5:	//其他
					$grade = 100;
					break;
			}
		}
		else
		{
			//資料庫有設定點名狀態的分數時, 則使用者個分數
			
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			$grade = $row[status_grade];
		}
		
		
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

	$title = "新增點名";
	$content = "新增成功";	
	$content = $content . "<br><a href='newRollCall.php'>繼續 新增點名</a>";

	$tpl->assign("title", $title);
	$tpl->assign("content", $content);
	
	assignTemplate($tpl, "/roll_call/message.tpl");	
?>

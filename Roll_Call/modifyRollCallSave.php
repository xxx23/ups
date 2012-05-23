<?
/*
DATE:   2007/06/26
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

	
	//取得成績資料
	$roll_id = $_POST['roll_id'];
	$percentage = $_POST['percentage'];
	
	//取得學生數目
	$studentNum = $_POST['studentNum'];
	
	//取得roll_date
	$roll_date = $_POST['year'] . $_POST['month'] . $_POST['day'] . "000000";

	//更新學生成績資料到Table roll_book
	for($studentCounter = 0; $studentCounter<$studentNum; $studentCounter++)
	{
		$nameTmp = "id_" . ($studentCounter+1);		
		$student_id = $_POST[$nameTmp];	//取得personal_id
		
		$nameTmp = "state_" . ($studentCounter+1);		
		$state = $_POST[$nameTmp];	//取得成績
		
		$sql = "UPDATE 
					roll_book 
				SET 
					roll_date = '" . $roll_date . "', 
					state = $state 
				WHERE 
					begin_course_cd = $begin_course_cd AND 
					roll_id = $roll_id AND 
					personal_id = $student_id
				";
		$sth = $DB_CONN->prepare($sql);
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());
	}
	
	
	//更新成績資料到Table course_percentage
	$percentage_type = 3;
	$sql = "UPDATE 
				course_percentage 
			SET 
				percentage = $percentage 
			WHERE 
				begin_course_cd = $begin_course_cd AND 
				percentage_type = '" . $percentage_type . "' AND 
				percentage_num = $roll_id
			";
	$sth = $DB_CONN->prepare($sql);
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	//更新學生成績資料到Table course_concent_grade
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
		
		$sql = "UPDATE 
					course_concent_grade 
				SET 
					concent_grade = $grade 
				WHERE 
					begin_course_cd = $begin_course_cd AND 
					percentage_type = '" . $percentage_type . "' AND 
					percentage_num = $roll_id AND 
					student_id = $student_id
				";
		$sth = $DB_CONN->prepare($sql);
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());
	}
	
	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	$title = "修改成績";
	$content = "修改成功";	
	$content = $content . "<br><a href='showRollCallList.php'>返回 點名列表</a>";

	$tpl->assign("title", $title);
	$tpl->assign("content", $content);

	assignTemplate($tpl, "/roll_call/message.tpl");	
?>

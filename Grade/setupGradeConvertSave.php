<?
/*
DATE:   2007/07/14
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
	
	
	$grade_type_cd = $_POST["grade_type_cd"];			//取得成績類型
	
	$levelNum = $_POST["levelNum"];						//取得成績階級數
	
	//從Table grade_convert先刪除掉原本的設定
	if($grade_type_cd == 0)
	{
		$sql = "DELETE FROM grade_convert WHERE begin_course_cd=$begin_course_cd";
	}
	else
	{
		$sql = "DELETE FROM grade_convert WHERE begin_course_cd=$begin_course_cd AND grade_type_cd='$grade_type_cd'";
	}
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	//將設定新增到資料庫	
	for($levelCounter=1; $levelCounter<=$levelNum; $levelCounter++)
	{
		$nameTmp = "lv" . $levelCounter . "_bottom";
		$grade = $_POST[$nameTmp];		//取得成績區間
		
		$nameTmp = "lv" . $levelCounter . "_value";
		$grade_convert = $_POST[$nameTmp];	//取得轉換後的文字
	
		$number_id = $levelCounter;
		
		if($grade_type_cd == 0)
		{
			$gradeTypeList = array('0','1','2','3','4','5','9','99');
			
			foreach($gradeTypeList as $sql_grade_type_cd)
			{
				$sql = "INSERT INTO grade_convert 
								( 
									begin_course_cd, 
									grade_type_cd, 
									number_id, 
									grade, 
									grade_convert 
								) VALUES ( 
									$begin_course_cd, 
									'$sql_grade_type_cd', 
									$number_id, 
									$grade, 
									'$grade_convert'
								)";
				$sth = $DB_CONN->prepare($sql);
				$res = $DB_CONN->execute($sth);
				if (PEAR::isError($res))	die($res->getMessage());
			}
		}
		else
		{			
			//字串有'!'會出現DB Error: mismatch
			$grade_convert = str_replace("!", "", $grade_convert);
			
			$sql = "INSERT INTO grade_convert 
							( 
								begin_course_cd, 
								grade_type_cd, 
								number_id, 
								grade, 
								grade_convert 
							) VALUES ( 
								$begin_course_cd, 
								'$grade_type_cd', 
								$number_id, 
								$grade, 
								'$grade_convert'
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

	$title = "成績轉換設定";
	$content = "設定成功";	
	$content = $content . "<br><a href='showGradeTypeList.php'>返回 成績轉換設定</a>";

	$tpl->assign("title", $title);
	$tpl->assign("content", $content);
	
	assignTemplate($tpl, "/grade/message.tpl");
?>

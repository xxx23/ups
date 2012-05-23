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
	$absoluteURL = $HOMEURL . "Roll_Call/";

	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼
	
	
	
	for($i=1;$i<=6;$i++){
		if($_POST['grade_' . $i] != NULL)
			$status_grade[$i] =$_POST['grade_' . $i];
		else
			$status_grade[$i] = 0;
		
		$status_id = $i -1;
		$sql = "SELECT 
					* 
				FROM 
					roll_book_status_grade 
				WHERE 
					begin_course_cd=$begin_course_cd AND 
					status_id=$status_id;
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		$ResultNum = $res->numRows();
		
		if($ResultNum == 0){	
			//新增資料到Table discuss__menber_groups				
			
			$sql = "INSERT INTO roll_book_status_grade  
								(
									begin_course_cd, 
									status_id, 
									status_grade
								) VALUES (
									$begin_course_cd, 
									$status_id, 
									$status_grade[$i]
								)";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
		}else{
			//更新資料到Table discuss_info
			$sql = "UPDATE roll_book_status_grade 
							SET 
								status_grade=$status_grade[$i] 
							WHERE 
								begin_course_cd=$begin_course_cd AND 
								status_id=$status_id";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
		}
		
		
	}
	
	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	$title = "修改點名狀態配分";
	$content = "修改成功";	
	$content = $content . "<br><a href='setupRollCallGrade.php'>重新 修改配分</a>";

	$tpl->assign("title", $title);
	$tpl->assign("content", $content);
	
	assignTemplate($tpl, "/roll_call/message.tpl");	
?>
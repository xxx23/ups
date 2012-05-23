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
	
	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	
	$sql = "SELECT 
				*  
			FROM 
				roll_book_status_grade 
			WHERE 
				begin_course_cd=$begin_course_cd 
			";
	$res = db_query($sql);

	$resultNum = $res->numRows();

	//判斷資料庫裡有沒有這個課程的點名配分資料
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$statusList[$rowCounter] = 
					array(
							"status_id" => $row[status_id], 
							"status_grade" => $row[status_grade]  
							);
			
			$rowCounter++;
		}
		
		$tpl->assign("statusList", $statusList);
	}else{
		$rowCounter = 0;
		while ($rowCounter<6)
		{	
			$statusList[$rowCounter] = 
					array(
							"status_grade" => 0  
							);
			
			$rowCounter++;
		}
		
		$tpl->assign("statusList", $statusList);
	}
	
	
	assignTemplate($tpl, "/roll_call/RollCallGradeInput.tpl");	
?>
<?
/*
DATE:   2007/05/15
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
	
	$tpl->assign("isShowUnusualListLink", 1);	//是否允許觀看異常名單
	$tpl->assign("isModifyOn", 1);	//是否允許修改
	$tpl->assign("isDeleteOn", 1);	//是否允許刪除

	//3.所有點名成績
	//從Table roll_book搜尋這堂課的所有點名成績
	$percentage_type = 3;
	$sql = "SELECT 
				A.roll_id, 
				A.roll_date, 
				B.percentage 
			FROM 
				roll_book A, 
				course_percentage B 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.begin_course_cd = B.begin_course_cd AND 
				B.percentage_type = '" . $percentage_type . "' AND 
				A.roll_id = B.percentage_num 
			GROUP BY 
				A.roll_id 
			ORDER BY 
				A.roll_id ASC
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$rollCallList[$rowCounter] = 
					array(
							"roll_id" => $row[roll_id], 
							"name" => "第" . $row[roll_id] . "次點名", 
							"percentage" => $row[percentage], 
							"roll_date" => substr($row[roll_date],0, 10) 
							);
			
			$rowCounter++;
		}
		
		$rollNum = $rowCounter;
		$tpl->assign("rollNum", $rollNum);
	}

	//輸出所有成績
	$tpl->assign("rollCallList", $rollCallList);

	//目前的頁面
	$tpl->assign("currentPage", "showRollCallList.php");
	
	assignTemplate($tpl, "/roll_call/rollCallList.tpl");	
?>

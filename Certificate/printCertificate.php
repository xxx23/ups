<?
/*
DATE:   2007/07/19
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "Certificate/";

	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_GET['begin_course_cd'];		//取得課程編號

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	$tpl->assign("begin_course_cd", $begin_course_cd);

	$credential_type_cd = 1;
	$allowPrint = 0;									//是否允許列印									
	
	//檢查是否有設定證書, 有設定就允許列印
	//從Table credential_type取出資料
	$sql = "SELECT 
				* 
			FROM 
				credential_type 
			WHERE 
				credential_type_cd=$credential_type_cd AND 
				begin_course_no=$begin_course_cd
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	
	$resultNum = $res->numRows();
	
	if($resultNum > 0)
	{
		$allowPrint = 1;
	}

	if($allowPrint == 1)
	{
		//從Table take_course搜尋這堂課的所有學生
		$sql = "SELECT B.personal_id, B.personal_name  
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
								"counter" => $rowCounter+1, 
								"personal_id" => $row[personal_id], 
								"personal_name" => $row[personal_name], 
								"grade" => 0
								);
				
				$rowCounter++;
			}
			$studentNum = $rowCounter;
			
			$tpl->assign("studentNum", $studentNum);
			$tpl->assign("studentList", $studentList);
		}
	}

	//輸出是否允許列印
	$tpl->assign("allowPrint", $allowPrint);
	


	//目前的頁面
	$tpl->assign("currentPage", "printCertificate.php");
	
	assignTemplate($tpl, "/certificate/printCertificate.tpl");
?>

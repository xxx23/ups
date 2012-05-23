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

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	$tpl->assign("isBackOn", 1);					//是否允許回上一頁

	//輸出成績編號
	$roll_id = $_GET['roll_id'];							//取得roll_id
	if( isset($roll_id) == false)	$roll_id = $_POST['roll_id'];
	$tpl->assign("roll_id", $roll_id);

	//目前的Action
	$tpl->assign("action", "modify");

	//網頁標題
	$tpl->assign("title", "修改點名");
	
	$incomingPage = $_GET['currentPage'];
	if( isset($incomingPage) == false)	$incomingPage = $_POST['currentPage'];
	$tpl->assign("incomingPage", $incomingPage);
	
	
	//年的範圍
	$yearScopeStart = $SYSTEM_BEGIN_YEAR;
	$yearScopeEnd = TIME_year() + 5;
	
	$yearScopeCounter = 0;
	for($counter = $yearScopeStart; $counter <= $yearScopeEnd; $counter++)
	{
		$yearScope[$yearScopeCounter++] = $counter;
	}
	$tpl->assign("yearScope", $yearScope);
	
	//從Table roll_book取得點名日期
	$percentage_type = 3;
	$sql = "SELECT 
				A.roll_date  
			FROM 
				roll_book A 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.roll_id = '" . $roll_id . "' 
			GROUP BY 
				A.personal_id
			";
	$res = db_query($sql);

	$res->fetchInto($row, DB_FETCHMODE_ASSOC);
	$roll_date = $row[roll_date];	
	$tpl->assign("year", substr($roll_date, 0, 4));
	$tpl->assign("month", substr($roll_date, 5, 2));
	$tpl->assign("day", substr($roll_date, 8, 2));
	
	//從Table course_percentage取得所佔的百分比
	$percentage_type = 3;
	$sql = "SELECT 
				A.percentage  
			FROM 
				course_percentage A 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.percentage_type = '" . $percentage_type . "' AND 
				A.percentage_num = $roll_id 
			";
	$res = db_query($sql);

	$res->fetchInto($row, DB_FETCHMODE_ASSOC);
	$percentage = $row[percentage];	
	$tpl->assign("percentage", $percentage);
	
	
	//從Table take_course搜尋這堂課的所有學生
	$sql = "SELECT 
				B.personal_id, 
				B.personal_name, 
				C.state 
			FROM 
				take_course A, 
				personal_basic B, 
				roll_book C 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.personal_id = B.personal_id AND 
				A.begin_course_cd = C.begin_course_cd AND 
				C.roll_id = $roll_id AND 
				A.personal_id = C.personal_id 
			ORDER BY 
				B.personal_id ASC";
	$res = db_query($sql);

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
							"state" => $row[state]
							);
			
			$rowCounter++;
		}
		$studentNum = $rowCounter;
		
		$tpl->assign("studentNum", $studentNum);
		$tpl->assign("studentList", $studentList);
	}
	
	assignTemplate($tpl, "/roll_call/rollCallInput.tpl");
?>

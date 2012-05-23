<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");
    require_once('../library/content.php');
    require_once('./time_output_format.php');
    //require_once($HOME_PATH. 'library/smarty_init.php');
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Learning_Tracking/";

	$begin_course_cd = $_SESSION['begin_course_cd'];		//取得課程代碼

    
	$student_id = $_GET['student_id'];		//取得學生personal_id
    if(isset($student_id) == false)	$student_id = $_SESSION['personal_id'];;

	$tpl = new Smarty;
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);


	//1.取得學生姓名
	$sql = "SELECT 
				B.personal_name 
			FROM 
				personal_basic B 
			WHERE 
				B.personal_id = $student_id";
	$res = db_query($sql);
	$resultNum = $res->numRows();
	if($resultNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		
		$tpl->assign("name", $row[personal_name]);
	}

	//2.取得 課程登入次數 以及 時數
	$sql = "SELECT 
				A.function_occur_number, 
				A.function_hold_time 
			FROM 
				event_statistics A 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.system_id = 1 AND 
				A.function_id = 2 AND 
				A.personal_id = $student_id
			";
			$res = db_query($sql);
	$resultNum = $res->numRows();
	
	if($resultNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		
		$tpl->assign("LoginCourse", $row[function_occur_number]);
		//echo $row['function_hold_time'];
        $LoginCourseTime = time_output_format(convert_datetime($row['function_hold_time']));
			//只顯示到小數點以下兩位
		$tpl->assign("LoginCourseTime", $LoginCourseTime);
	}
	else
	{
		$tpl->assign("LoginCourse", "0");
        $tpl->assign("LoginCourseTime",  "0 秒");
	}
	
	//3.取得 課程最後登入時間
	/*$sql = "SELECT 
				A.function_occur_time 
			FROM 
				event A 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.system_id = 1 AND 
				A.function_id = 2 AND 
				A.personal_id = $student_id 
			ORDER BY A.function_occur_time DESC
            ";*/
    // Edit by carlcarl 這個SQL的語法 速度較快
	$sql = "SELECT 
				MAX(A.function_occur_time) as function_occur_time
			FROM 
				event A 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.system_id = 1 AND 
				A.function_id = 2 AND 
				A.personal_id = $student_id 
			";

	$res = db_query($sql);
	//$resultNum = $res->numRows();
	$res->fetchInto($row, DB_FETCHMODE_ASSOC);

	if($row['function_occur_time'] != NULL)
	{
		$tpl->assign("LastLoginCourseTime", $row[function_occur_time]);
	}
	else
	{
		$tpl->assign("LastLoginCourseTime", "尚未登入過");
	}
	
	
	//4.取得 討論區發表文章 次數
	$sql = "SELECT 
				A.function_occur_number 
			FROM 
				event_statistics A 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.system_id = 3 AND 
				A.function_id = 1 AND 
				A.personal_id = $student_id
			";
	$res = db_query($sql);
	$resultNum = $res->numRows();
	
	if($resultNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		
		$tpl->assign("DisscussAreaPost", $row[function_occur_number]);
	}
	else
	{
		$tpl->assign("DisscussAreaPost", "0");
	}

	//5.取得 觀看教材次數 以及 時數
	$sql = "SELECT 
				sum(A.event_happen_number) as event_hp_time,
				sum(TIME_TO_SEC(A.event_hold_time)) as event_hold_time  
			FROM 
				student_learning A 
			WHERE 
				A.begin_course_cd = '$begin_course_cd' AND 
				A.content_cd = '".get_Content_cd($begin_course_cd)."' AND 
				A.personal_id = '$student_id'
			";
	$res = db_query($sql);
	$resultNum = $res->numRows();
	
	if($resultNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		$tpl->assign("ReadText", $row['event_hp_time']);	
        $ReadTextTime = time_output_format($row['event_hold_time']);
        //intval(intval($row['event_hold_time'])/3600) .':' .intval((intval($row['event_hold_time'])%3600)/60) .' (H:M)';

		$tpl->assign("ReadTextTime", $ReadTextTime);
	}
	else
	{
		$tpl->assign("ReadText", "0");
		$tpl->assign("ReadTextTime",  "0秒");
	}

	//輸出教材學習追蹤
	$tpl->assign("TeachingMaterial",  "../Teaching_Material/personal_tracking.php?begin_course_cd=$begin_course_cd&personal_id=$student_id");

	//目前的頁面
	$tpl->assign("currentPage", "showStudentCourseUseRankAction.php");
	
	assignTemplate($tpl, "/learning_tracking/studentCourseUseLogAction.tpl");
?>

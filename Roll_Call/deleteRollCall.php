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

	$roll_id = $_GET['roll_id'];						//取得roll_id
	if( isset($roll_id) == false)	$roll_id = $_POST['roll_id'];
	
	//從Table roll_book中刪除學員點名資料
	$sql = "DELETE 
			FROM 
				roll_book  
			WHERE 
				begin_course_cd=$begin_course_cd AND 
				roll_id=$roll_id
			";
	db_query($sql);

	//從Table course_concent_grade中刪除學員成績資料
	$percentage_type = 3;
	$sql = "DELETE 
			FROM 
				course_concent_grade 
			WHERE 
				begin_course_cd = $begin_course_cd AND 
				percentage_type = '" . $percentage_type . "' AND 
				percentage_num = $roll_id
			";
	db_query($sql);
	
	//從Table course_percentage中刪除成績資料
	$sql = "DELETE 
			FROM 
				course_percentage 
			WHERE 
				begin_course_cd = $begin_course_cd AND 
				percentage_type = '" . $percentage_type . "' AND 
				percentage_num = $roll_id
			";
	db_query($sql);
	
	
	header("location: showRollCallList.php");
?>

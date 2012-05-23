<?
	require_once("../config.php");	
	require_once("../session.php");

	require_once("../library/account.php");

	$begin_course_cd = $_GET['begin_course_cd'];

	//註冊begin_course_cd到SESSION
	$_SESSION['begin_course_cd'] = $begin_course_cd;
	$result = db_query("select course_cd , attribute from `begin_course` where begin_course_cd=$begin_course_cd;");
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	$_SESSION['course_cd'] = $row['course_cd'];
	$_SESSION['attribute'] = $row['attribute'];
	$_SESSION['template'] = setCourseStyle();	
	//學習追蹤-登入課程

  	header("Location: ../Teaching_Material/textbook_manage.php");
	

	function setCourseStyle(){
		$pid = $_SESSION['personal_id'];

		$style = db_getOne("select course_style from `personal_basic` where personal_id=$pid;");
		if(empty($style)){
			$style = get_style($pid, "course_style");
			db_query("update `personal_basic` set course_style='$style' where personal_id=$pid;");
		}
		return $style;
	}
?>

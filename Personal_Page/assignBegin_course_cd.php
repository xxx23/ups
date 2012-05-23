<?
	require_once("../config.php");	
	require_once("../session.php");
    require_once("../library/filter.php");

    $_SESSION['begin_course_cd'] = required_param("course",PARAM_INT);
    header('location:../Discuss_Area/showGroupDiscussAreaList.php?behavior=teacher&showType=Course');
?>

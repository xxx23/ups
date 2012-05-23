<?
/*
 * author: carlcarl
 */
	require_once("../config.php");
	require_once("../session.php");
    require_once("../library/common.php");
    require_once("../library/Pager.class.php");
	require_once('../library/filter.php') ;

    $tpl = new Smarty();

    if( !isset($_SESSION['personal_id']) || $_SESSION['personal_id'] == NULL)
        header("location: ../identification_error.html");

    $pid = $_SESSION['personal_id'];
    $tpl->assign("pid", $pid);

    //echo $pid;
    //$tpl->assign("pid", $pid);
    $role = $_SESSION['role_cd'];
    //$begin_course_cd = $_SESSION['begin_course_cd'];
    $begin_course_cd = required_param("course", PARAM_INT);
    $tpl->assign("begin_course_cd", $begin_course_cd);
    $begin_course_name = required_param("name", PARAM_TEXT);
    $tpl->assign("begin_course_name", $begin_course_name);



    assignTemplate($tpl, "/personal_page/inputReason.tpl");
?>

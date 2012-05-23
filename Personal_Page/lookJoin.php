<?
/*
 * author: carlcarl
 */
	require_once("../config.php");
	require_once("../session.php");
    require_once("../library/common.php");
	require_once('../library/filter.php') ;

    $tpl = new Smarty();

    if( !isset($_SESSION['personal_id']) || $_SESSION['personal_id'] == NULL)
        header("location: ../identification_error.html");

    $begin_course_cd = required_param("course", PARAM_INT);
    $tpl->assign("begin_course_cd", $begin_course_cd);
//    echo $begin_course_cd;
    $begin_course_name = required_param("name", PARAM_TEXT);
//    echo $begin_course_name;
    $tpl->assign("begin_course_name", $begin_course_name);
    $result = db_query("select teacher_cd, join_reason, not_pass_reason from group_discuss_join where begin_course_cd=$begin_course_cd");
    while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false)
    {
        $teacher_cd = $row['teacher_cd'];
        $name_result = db_query("select personal_name from personal_basic where personal_id = $teacher_cd");
        $name = $name_result->fetchRow(DB_FETCHMODE_ASSOC); 
        $row['name'] = $name['personal_name'];
        //print_r($row);
        $tpl->append("wantJoinList", $row);
    }

    assignTemplate($tpl, "/personal_page/lookJoin.tpl");

?>

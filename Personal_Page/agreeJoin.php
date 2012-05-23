<?
/*
 * author: carlcarl
 */
	require_once("../config.php");
	require_once("../session.php");
    require_once("../library/common.php");
    require_once('../library/filter.php');
    require_once('../library/mail.php');


    $tpl = new Smarty();

    if( !isset($_SESSION['personal_id']) || $_SESSION['personal_id'] == NULL)
        header("location: ../identification_error.html");
    
    $begin_course_cd = required_param("course", PARAM_INT);
    $teacher_cd = required_param("teacher", PARAM_INT);

    $sql = "insert into teach_begin_course (teacher_cd, begin_course_cd, course_master) values($teacher_cd, $begin_course_cd, '0')";
    $res = db_query($sql);
    $sql = "delete from group_discuss_join where begin_course_cd=$begin_course_cd and teacher_cd=$teacher_cd";
    $res = db_query($sql);

    //查要求加入的老師email
    $sql = "select personal_name, email from personal_basic
        where personal_id=$teacher_cd";
    $result = db_getRow($sql);
    $teacher_name = $result['personal_name'];
    $teacher_email = $result['email'];
    //查社群課程名稱
    $sql = "select begin_course_name from begin_course
        where begin_course_cd=$begin_course_cd";
    $result = db_getRow($sql);
    $begin_course_name = $result['begin_course_name'];

    //寄信
    //$subject = "你在社群 $begin_course_name 的加入要求已被允許";
    $subject = 'UPS - 社群新成員申請結果通知';
    $content = "$teacher_name  先生/小姐您好，<br />
        您於本平台欲申請參與社群 - 「 $begin_course_name 」，經課程主持人審核後您 已可 參與社群活動。
        <br /><br />
        祝<br />
        &nbsp;&nbsp;順心<br /><br />
        &nbsp;&nbsp;&nbsp;&nbsp;數位教學服務平台團隊&nbsp;敬上";
    if(mailto(null, null, $teacher_email, $subject, $content) == false)
    {
        die('信件寄送失敗. 收信人email: ' . $teacher_email);
    }

    //$begin_course_cd = required_param("course", PARAM_INT);
    $tpl->assign("begin_course_cd", $begin_course_cd);
    $begin_course_name = required_param("name", PARAM_TEXT);
    $tpl->assign("begin_course_name", $begin_course_name);
   
    assignTemplate($tpl, "/personal_page/agreeJoin.tpl");

?>


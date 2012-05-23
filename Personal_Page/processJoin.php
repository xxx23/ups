<?		
 	require_once("../config.php");
	require_once("../session.php");
    require_once("../library/common.php");
    require_once("../library/Pager.class.php");
	require_once('../library/filter.php') ;
    require_once('../library/mail.php') ;

    $tpl = new Smarty();

    if( !isset($_SESSION['personal_id']) || $_SESSION['personal_id'] == NULL)
        header("location: ../identification_error.html");
    $pid = $_SESSION['personal_id'];

    $begin_course_cd = required_param("course", PARAM_INT );
    $join_reason = optional_param("reason", 0, PARAM_TEXT );
    $begin_course_name = required_param("name", PARAM_TEXT );

    $sql = "delete from group_discuss_join where begin_course_cd=$begin_course_cd and teacher_cd=$pid";
    $res = db_query($sql);

    //echo $begin_course_cd . " " . $teacher_cd . " " . $join_reason;
    $sql = "insert into group_discuss_join
        (
            begin_course_cd, 
            teacher_cd, 
            join_reason
        ) 
        values
        (
            $begin_course_cd, 
            $pid, 
            '$join_reason'
        );"; //字串要用' '夾起來

    $res = db_query($sql);


    //查課程主持人的姓名和email
    $sql = "select B.personal_name, B.email
        from `teach_begin_course` A, `personal_basic` B
        where A.begin_course_cd=$begin_course_cd
        and A.course_master=1
        and A.teacher_cd=B.personal_id";
    $result = db_getRow($sql);

    //查自己的名字和email
    $sql = "select personal_name, email
        from personal_basic
        where personal_id=$pid";
    $self = db_getRow($sql);

    if(emailValidate($result['email']) == FALSE)
    {
        die("email 格式錯誤");
    }

    $personal_name = $self['personal_name'];
    //$subject = "$personal_name 想要加入你的社群 $begin_course_name";
    $subject = 'UPS - 社群新成員申請加入通知';
    $join_date = date('Y 年 m 月 d 日');
    $content = "課程主持人您好，<br />
        您於本平台所主持之社群 - 「 $begin_course_name 」，於 $join_date 平台使用者 $personal_name 欲申請加入您的社群，
        請您撥空至 數位學習服務平台 進行審核，謝謝。<br /><br /> 祝<br />&nbsp;&nbsp;順心<br /><br />
        &nbsp;&nbsp;&nbsp;&nbsp;數位教學服務平台團隊&nbsp;敬上";

    if(mailto($MAIL_ADMIN_EMAIL, $MAIL_ADMIN_EMAIL_NICK, $result['email'], $subject, $content) == false)
    {
        die("送信失敗! 收信人: " .  $result['personal_name']);
    }

    assignTemplate($tpl, "/personal_page/processJoin.tpl");

?>


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
    //echo $pid;
    $tpl->assign("pid", $pid);
    $role = $_SESSION['role_cd'];
    $begin_course_cd = $_SESSION['begin_course_cd'];
    $tpl->assign("begin_course_cd", $begin_course_cd);

    $page = optional_param("page",1,PARAM_INT);


    // 我的課程 這邊原本是不需要加上搜尋老師自己的課程的
    // 是因為要抓出自己主持的課 用來後面篩掉
    $result = db_query("select B.begin_course_cd, B.begin_course_name, A.course_master from `teach_begin_course` A, `begin_course` B, `lrtunit_basic_` C
                        where B.begin_course_cd=A.begin_course_cd 
                        and A.teacher_cd=$pid
                        and C.unit_cd=B.begin_unit_cd 
                        and B.note IS NOT NULL
                        and (select count(*) from `discuss_info` D        
                        where D.begin_course_cd=B.begin_course_cd 
                        and D.discuss_name like '社群\_%')<>0
                        order by A.course_master desc");

    //因為有老師希望把助教弄得跟他權限一樣大 
    //後來改了 導致可以選的社群內也有他的(因為會抓到助教的課 master=1)
    //所以先把自己主持的課存起來  後面拿來篩掉
    $begin_course_cd_array = array();

    while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false)
    {
        $begin_course_cd_array[] = $row['begin_course_cd'];
    }
    $begin_course_cd_array[] = 0;
    $master_courses = implode(',', $begin_course_cd_array);

    $searchWord = '%' . optional_param("keyword", 1, PARAM_TEXT) . '%';
    // 其他課程 這個更動的話 下面的sql也要更動
    $sql = "select count(*) from `teach_begin_course` A, `begin_course` B, `lrtunit_basic_` C 
        where B.begin_course_name like '$searchWord'
        and B.begin_course_cd=A.begin_course_cd 
        and A.teacher_cd<>$pid 
        and A.begin_course_cd not in ($master_courses)
        and A.course_master=1
        and C.unit_cd=B.begin_unit_cd 
        and B.note IS NOT NULL
        and (select count(*) from `teach_begin_course` E
        where E.begin_course_cd=B.begin_course_cd 
        and E.teacher_cd=$pid
        and E.course_master=0)=0
        and (select count(*) from `discuss_info` D        
        where D.begin_course_cd=B.begin_course_cd 
        and D.discuss_name like '社群\_%')<>0";

    $total = db_getOne($sql);
    $meta = array("page"=>$page,"per_page"=>10,"data_cnt"=>$total);
    $pager = new Pager($meta);
    $pagerOpt = $pager->getSmartyHtmlOptions();
    $result = db_query("select B.begin_course_cd, B.begin_course_name from `teach_begin_course` A, `begin_course` B, `lrtunit_basic_` C
        where B.begin_course_name like '$searchWord'
        and B.begin_course_cd=A.begin_course_cd 
        and A.teacher_cd<>$pid 
        and A.begin_course_cd not in ($master_courses)
        and A.course_master=1
        and C.unit_cd=B.begin_unit_cd 
        and B.note IS NOT NULL
        and (select count(*) from `teach_begin_course` E
        where E.begin_course_cd=B.begin_course_cd 
        and E.teacher_cd=$pid
        and E.course_master=0)=0
        and (select count(*) from `discuss_info` D        
        where D.begin_course_cd=B.begin_course_cd 
        and D.discuss_name like '社群\_%')<>0
        {$pager->getSqlLimit()}");

    //$result = db_query("select begin_course_cd, begin_course_name from `begin_course` where teacher_cd<>$pid {$pager->getSqlLimit()}");

    while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false)
    {
        $temp_course_cd = $row['begin_course_cd'];
        $discuss = db_query("select count(*) as discuss_count from discuss_info 
            where begin_course_cd=$temp_course_cd
            and discuss_name like '社群\_%'");

        $num = $discuss->fetchRow(DB_FETCHMODE_ASSOC);
        $row['discuss_num'] = $num['discuss_count'];

        $state = db_query("select not_pass_reason from group_discuss_join where begin_course_cd=$temp_course_cd and teacher_cd=$pid");
        if(($row2 = $state->fetchRow(DB_FETCHMODE_ASSOC)) != false)
        {
            if($row2['not_pass_reason'] == NULL)
            {
                //echo $temp_course_cd . " " . $pid . " " . $row2['begin_course_cd'];
                $row['state'] = 2;
            }
            else
            {
                $row['state'] = 3;
                $row['not_pass_reason'] = $row2['not_pass_reason'];
            }
        }
        else
        {
            $row['state'] = 1;
        }

		$tpl->append("all_course", $row);
    }

    $tpl->assign("page_ids",$pagerOpt['page_ids']);
    $tpl->assign("page_names",$pagerOpt['page_names']);
    $tpl->assign("page_sel",$pagerOpt['page_sel']);
    $tpl->assign("page_cnt",$pager->getPageCnt());
    $tpl->assign("previous_page",$pager->previousPage());
    $tpl->assign("next_page",$pager->nextPage());

    assignTemplate($tpl, "/personal_page/groupSearch.tpl");
?>


<?php

/*
 * author：Samuel
 * Add date：2009/08/15
 * 程式目的：用來show出目前的平台最熱門的10門課程
 *
 * modify by Samuel @ 2009/10/01
 * 新增在會員的部份 有選課的功能
 *
 * modify by carlcarl @ 2011/12/09
 * 拿掉不要的功能，修改query效率
*/
	
	include_once("config.php");
	include_once("library/common.php");
	include_once("session.php");	
	$tpl = new Smarty();

	// 要show出幾門熱門的課程
	$role_cd = $_SESSION['role_cd'];	
    $personal_id = $_SESSION['personal_id'];
    $show_course = 10 ;
    $three_month_ago = date("Y-m-d",time()-3600*24*30*3);

    $sql = "SELECT t.begin_course_cd, count(*) as people_number, bc.begin_course_name,bc.course_cd
        FROM take_course t , begin_course bc
        WHERE t.begin_course_cd = bc.begin_course_cd
        AND t.allow_course = 1
        AND (t.course_begin > '{$three_month_ago}' or t.course_begin IS NULL)
        GROUP BY begin_course_cd
        ORDER BY count(*) DESC limit 0,{$show_course}";
    $tpl->assign("role_cd", $role_cd);
    $hot_course = db_getAll($sql);
    $tpl->assign("popular_course",$hot_course);

    $normal_course = get_popular_course(0,$show_course);
    $elementary_course = get_popular_course(1,$show_course);
    $high_course = get_popular_course(2,$show_course);
    $college_course = get_popular_course(3,$show_course);

    $tpl->assign("normal_course",$normal_course);
    $tpl->assign("elementary_course",$elementary_course);
    $tpl->assign("high_course",$high_course);
    $tpl->assign("college_course",$college_course);

    $tpl->display("front_popular_course.tpl");
    
    function get_popular_course($type,$limit)
    {
        $today_3_month_ago = date("Y-m-d",time()-3600*24*30*3);

        $sql = "select count(*) as people_number , BC.begin_course_cd, BC.begin_unit_cd , BC.begin_course_name,BC.course_cd
            from begin_course BC, take_course TC, lrtunit_basic_ LB
            where BC.begin_unit_cd = LB.unit_cd
                    and LB.department={$type} 
                    and BC.begin_course_cd = TC.begin_course_cd
                    and TC.allow_course = 1
                    and (TC.course_begin > '{$today_3_month_ago}' or TC.course_begin IS NULL)
            Group BY BC.begin_course_cd 
            ORDER BY people_number DESC limit 0,{$limit}";
        return db_getAll($sql);
    }

    
?>

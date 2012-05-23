<?php
/***
FILE:
DATE:
AUTHOR: zqq
**/
	require_once("../config.php");
	require_once("../session.php");
    //aeil
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "library/Pager.class.php");
	require_once($RELEATED_PATH . 'library/filter.php') ;
    //end
	checkAdminAcademic();
	//new smarty
	require_once($HOME_PATH . 'library/smarty_init.php');
    //搜尋

    ////////////////by carlcarl 
    $all_check = 0;
    $name_check = 0;
    $unit_check = 0;
    $teacher_check = 0;
    ///////////////

    if(array_key_exists('search', $_GET) && $_GET['search'] == 'yes')
    {
        $tpl->assign("show_search", "1");

        //////////////by carlcarl
        $begin_course_name_input = $_GET['begin_course_name_input'];
        $unit_input = $_GET['unit_input'];
        $teacher_input = $_GET['teacher_input'];
        //////////////

        if(count($_GET['query'])>0)
        {
            $patten = "";
			for($i=0; $i < count($_GET['query']); $i++){
				if($_GET['query'][$i]== 0){	//查出所有的課程
					$sql = "SELECT DISTINCT bc.attribute,bc.begin_course_cd, bc.begin_course_name, bc.inner_course_cd, u.unit_name  FROM begin_course bc, lrtunit_basic_ u WHERE bc.begin_unit_cd=u.unit_cd  ORDER BY bc.begin_course_cd ASC";
					//$sql = "SELECT DISTINCT bc.begin_course_cd, bc.begin_course_name, bc.inner_course_cd, u.unit_name  FROM begin_course bc, lrtunit_basic_ u WHERE bc.begin_unit_cd=u.unit_cd  ORDER BY bc.begin_course_cd ASC";
					//echo $sql;
				}
				else{
                    if($_GET['query'][$i] == 1) //開課名稱
                    {
						//$sql = "SELECT DISTINCT bc.begin_course_cd, bc.begin_course_name, bc.inner_course_cd, u.unit_name  FROM begin_course bc, lrtunit_basic_ u  WHERE bc.begin_course_name like '%".$_GET[begin_course_name_input]."%'  and bc.begin_unit_cd=u.unit_cd  ORDER BY bc.begin_course_cd ASC";
                        $patten .= "bc.begin_course_name like '%".$_GET[begin_course_name_input]."%' and ";
                        $name_check = 1;
                    }
                    if($_GET['query'][$i] == 2) //開課單位
                    {
						//$sql = "SELECT DISTINCT bc.begin_course_cd, bc.begin_course_name, bc.inner_course_cd, u.unit_name  FROM begin_course bc, lrtunit_basic_ u  WHERE u.unit_name='".$_GET[unit_input]."' and  bc.begin_unit_cd=u.unit_cd  ORDER BY bc.begin_course_cd ASC";
                        $patten .= "u.unit_name like'%".$_GET[unit_input]."%' and ";
                        $unit_check = 1;
                    }
                    if($_GET['query'][$i] == 3) //授課教師
                    {
						//$sql = "SELECT DISTINCT bc.begin_course_cd, bc.begin_course_name, bc.inner_course_cd, u.unit_name, p.personal_name  FROM begin_course bc, lrtunit_basic_ u, teach_begin_course tc, personal_basic p WHERE bc.begin_unit_cd=u.unit_cd and tc.begin_course_cd=bc.begin_course_cd and tc.teacher_cd=p.personal_id and p.personal_name='".$_GET[teacher_input]."' ORDER BY bc.begin_course_cd ASC";
                        $patten .= "p.personal_name like '%".$_GET[teacher_input]."%' and ";
                        $teacher_check = 1;
                    }
				}
			}
			if($patten != "")
			{
                $sql = "SELECT DISTINCT bc.attribute, bc.begin_course_cd, bc.begin_course_name, bc.inner_course_cd, u.unit_name  
                    FROM begin_course bc, lrtunit_basic_ u, teach_begin_course tc, personal_basic p 
                    WHERE ".$patten." bc.begin_unit_cd=u.unit_cd and tc.begin_course_cd=bc.begin_course_cd and tc.teacher_cd=p.personal_id 
                    ORDER BY bc.begin_course_cd ASC";
			}

            //add by aeil
            $page = optional_param("page",1,PARAM_INT);
            //$total = db_getOne(str_ireplace("DISTINCT","COUNT(*) DISTINCT",$sql));
            $total = mysql_num_rows(mysql_query($sql));
            $meta = array("page"=>$page,"per_page"=>10,"data_cnt"=>$total);
            $pager = new Pager($meta);
            $pagerOpt = $pager->getSmartyHtmlOptions();
            //print_r($pagerOpt);
            $tpl->assign("page_ids",$pagerOpt['page_ids']);
            $tpl->assign("page_names",$pagerOpt['page_names']);
            $tpl->assign("page_sel",$pagerOpt['page_sel']);
            $tpl->assign("page_cnt",$pager->getPageCnt());
            //echo $pager->getPageCnt() . "EE"; 
            $tpl->assign("previous_page",$pager->previousPage());
            $tpl->assign("next_page",$pager->nextPage());
            $tpl->assign("search",$_POST['search']);
            $sql .= $pager->getSqlLimit();
            //echo $sql;
            //end
			$result = db_query($sql);
			$num = 0;
			//if($_GET['query'][$i-1]!=3){
				while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
					//查出授課教師
					$sql = "SELECT p.personal_name FROM teach_begin_course tc, personal_basic p WHERE  tc.begin_course_cd='".$row['begin_course_cd']."' and tc.teacher_cd=p.personal_id";
					$res_tch = db_query($sql);
					if($res_tch->numRows()){//有教師
						$row['personal_name'] = '';
						while($tmp_row = $res_tch->fetchRow(DB_FETCHMODE_ASSOC)){
							$row['personal_name'] .= $tmp_row['personal_name']."<br>";
						}
					}
					else{// 沒教師
						$row['personal_name'] = "<font color=red>教師未定</font>";
					}

					$row['num'] = $num++;
					$tpl->append('course_data', $row);
				}
			//}
			//else{
			//	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
			//		$row['num'] = $num++;
			//		$tpl->append('course_data', $row);
			//	}
			//}
		}
    }

    ////////////////////////by carlcarl
    $tpl->assign("begin_course_name_input", $begin_course_name_input);
    $tpl->assign("unit_input", $unit_input);    
    $tpl->assign("teacher_input", $teacher_input);

    $tpl->assign("all_check", $all_check);
    $tpl->assign("name_check", $name_check);
    $tpl->assign("unit_check", $unit_check);
    $tpl->assign("teacher_check", $teacher_check);


    ////////////////////////

	//輸出頁面
	assignTemplate($tpl, "/course_admin/show_all_begin_course.tpl");
?>

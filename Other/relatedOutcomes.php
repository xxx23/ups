<?php
	//fileName : courseSearch.php
	//fucntion : search the course in database
	//createBy : q110185
	//create date: 20090930

	//[[require library in cyber]]
	require_once("../config.php");
	require_once("../session.php");
	require_once("../library/Pager.class.php");
	require_once($HOME_PATH . 'library/filter.php') ;
    require_once("../Personal_Page/lib_take_course.php");
    //[[GET AND FILTER INPUT]]
 
	if(isset($_SESSION['role_cd']))
		$role_cd = $_SESSION['role_cd'];
	else
		$role_cd = 4;
    
    $personal_id = $_SESSION['personal_id'];
    if($role_cd != 4)
    {
        $dist_cd = getDistCD($personal_id);
    }

    $default_search_type = -1;
    $default_sub_type = -1;
    /*if($role_cd == 3)
    {
        $default_search_type = 0;
        $default_sub_type = $dist_cd;
    }*/

	$action = optional_param("action",'search');
	//$search_type = optional_param("search_type",$default_search_type, PARAM_INT );
    $sub_type = optional_param("sub_type",$default_sub_type, PARAM_INT );
    $sub_type_sel = $sub_type;
	$course_name =  optional_param("course_name", '',PARAM_CLEAN );
    $page = optional_param("page",1,PARAM_INT);
    $course_year = optional_param('course_year', '', PARAM_CLEAN);

    $take_message = 0;
	if($action == 'take'){
	
		$begin_course_cd = required_param("begin_course_cd",PARAM_INT);
		take_course($begin_course_cd,$personal_id);
		$take_message = 1;
	}
    if($action == 'search')
    {	
		//[[JUDGE SEARCH CONDITIONS]]
		$search_conditions = '';
        
        //有指定學年度的話
        if($course_year != '')
        {
            $search_conditions .= " AND b.course_year='{$course_year}'";
        }
        if($sub_type != -1)
        {
            $search_conditions .= " AND b.begin_unit_cd='{$sub_type}'";
        }
		
		//[[PAGER]]
		$sql = "SELECT COUNT(*) 
				FROM begin_course b, lrtunit_basic_ l
				WHERE b.begin_course_name LIKE '%{$course_name}%'
                AND b.begin_coursestate = 1
                AND b.attribute = 0
                AND b.begin_unit_cd = l.unit_cd
                AND l.department = 4
                    {$search_conditions}
					  "; 
		$total = db_getOne($sql);
		$meta = array("page"=>$page,"per_page"=>10,"data_cnt"=>$total);
		$pager = new Pager($meta);
		$pagerOpt = $pager->getSmartyHtmlOptions();
		
		//[[DO SEARCH]]
		$unitTable = getUnitTable();
		$unit_cd = 0;
		$courseList = null;
		$sql = "SELECT b.begin_course_cd, 
					   b.begin_unit_cd,
					   b.begin_course_name,
                       b.course_property,
                       b.guest_allowed,
                       b.course_year
				FROM begin_course b, lrtunit_basic_ l
                WHERE b.begin_course_name LIKE '%{$course_name}%'
                AND b.begin_coursestate = 1
                AND b.attribute = 0
                AND b.begin_unit_cd = l.unit_cd
                AND l.department = 4
					  {$search_conditions}
					  {$pager->getSqlLimit()}
					  "; 
		$result = db_query($sql);
		if($result->numRows())
		{
			while($course = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
                $course['unit'] = $unitTable["{$course['begin_unit_cd']}"]['unit_name'];
				$courseList[]=$course;
			}
		}
    }

    //確認相關成果類別本身在不在
    $sql = 'SELECT unit_cd FROM lrtunit_basic_ WHERE department=-1 AND unit_cd=4';
    $unit_cd = db_getOne($sql);
    if($unit_cd == NULL) //不在的話就幫insert
    {
        $sql = "INSERT INTO lrtunit_basic_ (unit_cd, unit_name, department) VALUES(4, '相關成果', -1)";
        db_query($sql);
    }

    // 拿出相關成果類別下的子類別(相關成果類別是4)
    $sql = 'SELECT unit_cd, unit_name FROM lrtunit_basic_ WHERE department=4';
    $typeList = db_getAll($sql);

    //預設子類別名單
    $sub_type_ids =array(-1);
    $sub_type_names =array("（全部）");

    foreach($typeList as $row)
    {
        $sub_type_ids[] = $row['unit_cd'];
        $sub_type_names[] = $row['unit_name'];
    }

	//[[SHOW]] 
	require_once($HOME_PATH . 'library/smarty_init.php');

	$tpl->assign("role_cd",$role_cd);

	
	$tpl->assign("sub_type_ids",$sub_type_ids);
	$tpl->assign("sub_type_names",$sub_type_names);
	$tpl->assign("sub_type_sel",$sub_type_sel);

    $tpl->assign("course_name",$course_name);
    $tpl->assign('course_year', $course_year);
	if($action == 'search'){
		$tpl->assign("page_ids",$pagerOpt['page_ids']);
		$tpl->assign("page_names",$pagerOpt['page_names']);
		$tpl->assign("page_sel",$pagerOpt['page_sel']);
		$tpl->assign("page_cnt",$pager->getPageCnt());
		$tpl->assign("previous_page",$pager->previousPage());
		$tpl->assign("next_page",$pager->nextPage());
	}
	$tpl->assign("take_message",$take_message);
	$tpl->assign("action",$action);
	$tpl->assign("courseList",$courseList);
	
	assignTemplate($tpl, '/other/relatedOutcomes.tpl');
	
//------------------------------------------------------------------------------------
	function getUnitTable()
	{
		$sql = 'SELECT u.unit_cd, 
					   u.unit_name, 
					   u.department 
				FROM lrtunit_basic_ u 
				WHERE 1';
		$result = db_query($sql);
		if($result->numRows())
		{
			while($unit = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
				$unitTable[ "{$unit['unit_cd']}"] = $unit;
			}
		}
		return $unitTable;
	}
//----------------------------------------------------------------------------------------------	

    //------------------------------------------------------------------------------
    //-----------------------------------------------
	// 	FUNCTION : getDistCD
	//  input :$cd -begin_course_cd 課程代碼abs
	//	output: 使用者的腳色編號
	//-----------------------------------------------
	function getDistCD($personal_id)
	{
		$sql = "SELECT pb.dist_cd
				FROM personal_basic pb
				WHERE pb.personal_id=$personal_id";
		$data = db_getOne($sql);
		return $data;
	}

?>

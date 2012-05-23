<?php
	//fileName : courseSearch.php
	//fucntion : search the course in database
	//createBy : q110185
	//create date: 20091101

	//[[require library in cyber]]
	require_once("./config.php");
	require_once("./library/Pager.class.php");
	require_once('./library/filter.php') ;
	require_once('./session.php');
    //require_once("lib_take_course.php");
    //[[GET AND FILTER INPUT]]
 
	$role_cd = 4;
    
	
	$personal_id = db_getOne("SELECT personal_id FROM register_basic WHERE login_id='guest'; ");
	$default_search_type = -1;
    $default_sub_type = -1;


	$action = optional_param("action",'search');
	$search_type = optional_param("search_type",$default_search_type, PARAM_INT );
	$sub_type = optional_param("sub_type",$default_sub_type, PARAM_INT );
	$attribute = optional_param("attribute",-1, PARAM_INT );
	$course_name =  optional_param("course_name", '',PARAM_CLEAN );
    $page = optional_param("page",1,PARAM_INT);

    $take_message = 0;
	
	if($action == 'search'){	
		//[[JUDGE SEARCH CONDITIONS]]
		$search_conditions = '';
		switch($search_type)
		{
		case -1://全部課程
			$search_conditions .= ""; 
			break;
		case 0: //依身分類別
			$search_conditions .= getCourseSearchConditionByRole($sub_type); 
			break;
		case 1: //依課程性質
			$search_conditions .= getCourseSearchConditionByType($sub_type); 
			break;
		}
		if($attribute != -1)   
			$search_conditions.=" AND b.attribute='{$attribute}'";
//		if($role_cd == 4)
//			 $search_conditions.=" AND b.guest_allowed=1";
		
        //[[PAGER]]
        //4是相關成果課程，要濾掉
		$sql = "SELECT COUNT(*) 
				FROM begin_course b, lrtunit_basic_ l
                WHERE b.begin_course_name LIKE '%{$course_name}%'
                AND b.begin_coursestate = 1
                AND b.begin_unit_cd = l.unit_cd
                AND l.department <> 4
					  {$search_conditions}
					  "; 
		$total = db_getOne($sql);
		$meta = array("page"=>$page,"per_page"=>10,"data_cnt"=>$total);
		$pager = new Pager($meta);
		$pagerOpt = $pager->getSmartyHtmlOptions();
		
		//well_print($pagerOpt);
		//[[DO SEARCH]]
		$unitTable = getUnitTable();
		$unit_cd = 0;
        $courseList = null;
        
        //4是相關成果課程，要濾掉
		$sql = "SELECT b.begin_course_cd, 
					   b.inner_course_cd,
					   b.begin_unit_cd,
					   b.begin_course_name,
					   b.attribute,
					   b.d_course_begin,
					   b.d_course_end,
					   b.d_select_begin,
					   b.d_select_end,
					   b.certify,
                       b.course_property,
                       b.guest_allowed,
                       b.criteria_content_hour
				FROM begin_course b, lrtunit_basic_ l
                WHERE b.begin_course_name LIKE '%{$course_name}%'
                AND b.begin_coursestate = 1
                AND b.begin_unit_cd = l.unit_cd
                AND l.department <> 4
					  {$search_conditions}
					  {$pager->getSqlLimit()}
					  "; 
		$result = db_query($sql);
		if($result->numRows())
		{
			while($course = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
				$teacherName = getCourseTeacherName($course['begin_course_cd']);
				
				$course['teacher_name'] = $teacherName!='' ? $teacherName : '---'; 
				if($course['attribute']==0)
                {
                    $course['teacher_name'] = '---';
					$course['select_time'] = '不限';
                    $course['listen_time'] = '不限';
				}else{
					$course['select_time'] = substr($course['d_select_begin'],0,10)."<br/>~<br/>".substr($course['d_select_end'],0,10);
					$course['listen_time'] = substr($course['d_course_begin'],0,10)."<br/>~<br/>".substr($course['d_course_end'],0,10);
				}
				if($search_type == 0){
					$department = $unitTable["{$course['begin_unit_cd']}"]['department'];
					$course['unit'] = $unitTable["{$department}"]["unit_name"];
				}
				else{
					$course_properties = getCourseProperties();
					$course['unit'] = $course_properties['names'][$course['course_property']+1];   
				}
				if($role_cd == 3)
					$course['checkSelect'] = check_course_state($course['begin_course_cd'],$personal_id);
				$courseList[]=$course;
			}
		}
    }
	//well_print($courseList);
	
	//[[OPTION SETUP]]
	$search_type_ids = array(-1,0,1);
	$search_type_names = array("（所有課程）","依身份類別","依課程性質");
	$search_type_sel = $search_type;
	
	switch($search_type_sel)
	{
	 case 0:
         $sub_type_ids =array(-1,0,1,2,3);
         $sub_type_names =array("（全部）","一般民眾","中小學教師","高中職教師","大專院校師生");
		$sub_type_sel = $sub_type;
		break;
    case 1:
        if(!$course_properties)
		    $course_properties = getCourseProperties();
		$sub_type_ids =  $course_properties['ids'];
		$sub_type_names = $course_properties['names'];
		$sub_type_sel = $sub_type;
		break;
	default:
		$sub_type_ids =array(-1);
		$sub_type_names =array("（全部）");
		$sub_type_sel = -1;
		break;
	}
	
	$attribute_ids =array(-1,0,1);
	$attribute_names =array("（全部）","自學課程","教導課程");
	$attribute_sel= $attribute;
	
	
	//[[SHOW]] 
	$tpl = new Smarty();

	$tpl->assign("role_cd",$role_cd);

	$tpl->assign("search_type_ids",$search_type_ids);
	$tpl->assign("search_type_names",$search_type_names);
	$tpl->assign("search_type_sel",$search_type_sel);
	
	$tpl->assign("sub_type_ids",$sub_type_ids);
	$tpl->assign("sub_type_names",$sub_type_names);
	$tpl->assign("sub_type_sel",$sub_type_sel);
	
	$tpl->assign("attribute_ids",$attribute_ids);
	$tpl->assign("attribute_names",$attribute_names);
	$tpl->assign("attribute_sel",$attribute_sel);
	
	$tpl->assign("course_name",$course_name);
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
	$tpl->display("courseSearch.tpl");
	//assignTemplate($tpl, '/personal_page/courseSearch.tpl');
	
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
	function getCourseTeacherName($begin_course_cd)
	{
		if($begin_course_cd){
			$sql="SELECT p.personal_name
				  FROM teach_begin_course t, personal_basic p
				  WHERE t.teacher_cd = p.personal_id AND
						t.begin_course_cd = {$begin_course_cd}
					";
			$teacherName = db_getOne($sql);
		
			return $teacherName;
		}
		else {
			return '';
		}
	}
//*-------------------------------------------------------------------------------------------------
function getCourseProperties()
	{
		$courseProperties['ids'][] =-1;
		$courseProperties['names'][] ="（全部）";
		$sql="SELECT *
			  FROM course_property
              WHERE 1
              ORDER BY property_cd ASC
			";
		$result = db_query($sql);
		if($result->numRows())
		{
			while($cp = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
				$courseProperties['ids'][] = $cp['property_cd'];
				$courseProperties['names'][] = $cp['property_name'];
			}
		}
		
		return $courseProperties;
		
    }

    function getCourseSearchConditionByRole($role_type)
    {
		if($role_type == -1)
			$conditionSql = "";
		else
			$conditionSql = " AND b.begin_unit_cd IN (SELECT unit_cd FROM lrtunit_basic_ WHERE department='{$role_type}')";
		return $conditionSql;
    }

    function getCourseSearchConditionByType($course_type)
    {
		if($course_type == -1)return '';
		else $conditionSql = "AND  b.course_property='{$course_type}'";
		return $conditionSql;
    }
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

<?php

/*
 * author：Samuel
 * Add date：2009/08/15
 * 程式目的：用來show出目前的平台最熱門的10門課程 
*/
	
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH."library/common.php");
	
	$tpl = new Smarty();
	
	$seven_day_before = date("Y-m-d",time()-7*24*3600);

	$sql = "SELECT case when A.course_property is null then 0 else count(*) end as new,B.property_cd, B.property_name
	  FROM begin_course A right join course_property B
	  on A.course_property = B.property_cd
	  And A.d_course_begin > '{$seven_day_before}'
	  Group by A.course_property, B.property_name
	  ORDER by B.property_cd";

	$all_course = db_getAll($sql);
	$array_rows = count($all_course);
	
	$sql = "SELECT count(*) as course_num , course_property
	  FROM begin_course 
	  GROUP BY course_property
	  ORDER BY course_property";

	$course_number = db_getAll($sql);

	//把課程數和類別的資訊合在同一個array
	//好吧 我知道這個方法很爛 囧
	//modify by Samuel @ 2009/09/26
	$i = 0 ;
	while($all_course[$i] != NULL)
	{
	  	$j = 0 ;
		while($j < $array_rows)
		{
		  	if($all_course[$i]['property_cd'] == $course_number[$j]['course_property']){
			  	$all_course[$i]['course_number'] = $course_number[$j]['course_num'];
				break;
			}
			$j++;
		}
		if($all_course[$i]['course_number'] == NULL)
		  	$all_course[$i]['course_number'] = 0 ;
		$i++;
	}
	$tpl->assign("popular_course",$all_course);

	$tpl->display("popular_course2.tpl");
?>

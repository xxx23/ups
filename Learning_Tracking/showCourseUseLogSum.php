<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");
	require_once($RELEATED_PATH . "library/content.php");
	require_once("./time_output_format.php");
	echo str_pad('',1024); 
	//require_once($RELEATED_PATH . "session.php");
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Learning_Tracking/";

	$begin_course_cd = $_SESSION['begin_course_cd'];		//取得課程代碼

	$tpl = new Smarty;
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	//取得課堂學生的資料並加總
	$sql = "SELECT 
				* 
			FROM 
				event_statistics A 
			WHERE 
				A.begin_course_cd = $begin_course_cd
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();

	$DisscussAreaPost = 0;
	$LoginCourse = 0;
	$LoginCourseTime = 0;
	$ReadText = 0;
	$ReadTextTime = 0;
	
	if($resultNum > 0)
	{
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{
			switch($row[system_id])
			{
			case 1:	//系統
					if($row[function_id] == 2)
					{
						//登入課程
						$LoginCourse += $row[function_occur_number];
						//echo "[Trace] ".$row[function_hold_time];
					    $LoginCourseTimeT = convert_datetime($row[function_hold_time]);
						$LoginCourseTime+= $LoginCourseTimeT;
					}
					
					
					break;
					
			case 2:	//公告
					
					break;
					
			case 3:	//討論區
					if($row[function_id] == 1)
					{
						$DisscussAreaPost += $row[function_occur_number];
					}
					break;
					
				      case 4:	//教材
					/*
					if($row[function_id] == 1)
					{
						$ReadText += $row[function_occur_number];
						
						$ReadTextTimeT = substr($row[function_hold_time],0,4)*12*31*24 + 
										substr($row[function_hold_time],5,2)*31*24 + 
										substr($row[function_hold_time],8,2)*24 + 
										substr($row[function_hold_time],11,2) + 
										substr($row[function_hold_time],14,2)/60;
						$ReadTextTimeT = round($ReadTextTimeT, 2) . " h";	//只顯示到小數點以下兩位
						$ReadTextTime += $ReadTextTimeT;
					}*/
					break;
					
			default:
					break;
			}
		}
	}
	
	$sql = "SELECT 
			sum(A.event_happen_number) as event_hp_time,
			sum(TIME_TO_SEC(A.event_hold_time)) as event_hold_time  
		FROM 
			student_learning A 
		WHERE 
			A.begin_course_cd = '$begin_course_cd' AND
	       		A.content_cd = '".get_Content_cd($begin_course_cd)."'
			";
	//ech $sql;
	
	$res = db_query($sql);
	$resultNum = $res->numRows();

	//echo '<br/>'.$resultNum.'<br/>';
  	  
	if($resultNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		
		//var_dump($row);

		$ReadText=$row['event_hp_time'] ? $row['event_hp_time']:0;
		$ReadTextTime = time_output_format($row['event_hold_time'] ? $row['event_hold_time'] : 0);	

	}
	else
	{
		$ReadText = "0";
		$ReadTextTime = "0.0 秒";
	}
	$LoginCourseTime=time_output_format($LoginCourseTime);
	$tpl->assign("DisscussAreaPost", $DisscussAreaPost);
	$tpl->assign("LoginCourse", $LoginCourse);
	$tpl->assign("LoginCourseTime", $LoginCourseTime);
	$tpl->assign("ReadText", $ReadText);
	$tpl->assign("ReadTextTime", $ReadTextTime);
	
	$tpl->assign("TeachingMaterial",  "../Teaching_Material/course_tracking.php?begin_course_cd=$begin_course_cd");
	
	assignTemplate($tpl, "/learning_tracking/showCourseUseLogSum.tpl");

?>

<?php


if($_SERVER['REMOTE_ADDR']=='140.123.101.194' || $_SERVER['REMOTE_ADDR']=='140.123.101.212' || $_SERVER['REMOTE_ADDR']=='140.123.105.190' || $_SERVER['REMOTE_ADDR']=='140.111.2.67')
{
//    echo("功能測試中...");
}else{
//    echo("平台功能測試中...");
//    exit();
}


//joyce 20110512 modify from courseSearch.php(qwewe)

	//[[require library in cyber]]
	require_once("../config.php");
	require_once("../session.php");
	require_once("../library/Pager.class.php");
	require_once($HOME_PATH . 'library/filter.php') ;
    //[[GET AND FILTER INPUT]]
	//require_once($HOME_PATH . 'library/smarty_init.php');
	$tpl = new Smarty;
	
	$role_cd = $_SESSION['role_cd'];
    $personal_id = $_SESSION['personal_id'];
    $dist_cd = getDistCD($personal_id);//身分類別
	
	//2平台教師,3研習學員(大專院),4研習學員(國中小)
		$status = 0;
			if($role_cd == 1)//平台教師
					$status = 2;
			else if($role_cd == 3 && $dist_cd ==1)//研習學員(國中小)
					$status = 4;
			else if($role_cd == 3 && $dist_cd ==4)//研習學員(大專院)
					$status = 3;
	//echo "status [ 2平台教師,3研習學員(大專院),4研習學員(國中小) ] =".$status;				


	$action = optional_param("action",'search');

	$content_name =  optional_param("content_name", '',PARAM_CLEAN );
    $page = optional_param("page",1,PARAM_INT);

	if($action == 'search'){	

		$sql = "SELECT COUNT( * ) 
				FROM course_content t 
				RIGHT JOIN content_download p 
				ON t.`content_cd` = p.`content_cd` 
				WHERE t.content_name LIKE '%{$content_name}%' 
				AND p.is_download = '1' 
				AND (p.download_role LIKE '%1%' OR p.download_role LIKE '%$status%')
				";
		//[[PAGER]]	
		$total = db_getOne($sql);
		$meta = array("page"=>$page,"per_page"=>10,"data_cnt"=>$total);
		$pager = new Pager($meta);
		$pagerOpt = $pager->getSmartyHtmlOptions();
		
		$courseList = null;

		$sql = "SELECT t.`content_cd` , t.`content_name` , t.`teacher_cd` , p . *  
				FROM course_content t
				RIGHT JOIN content_download p 
				ON t.`content_cd` = p.`content_cd` 
				WHERE t.content_name LIKE '%{$content_name}%'
				AND p.is_download = '1'
				AND (p.download_role LIKE '%1%' OR p.download_role LIKE '%$status%')
				ORDER BY t.`content_cd` ASC 
					  {$pager->getSqlLimit()}
				";	
			
		$result = db_query($sql);
//echo $sql;

		if($result->numRows())
		{
			while($course = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
				
				$Content_cd = $course['content_cd'];
				
				$course_info = getContent_info($course['packet_type'], $course['license']);

					$course['content_pad_cd'] = sprintf("%07d", $Content_cd);
					$course['teacher_name'] = getCourseTeacherName($course['teacher_cd']);//授課教師
					$course['course_name'] = getCourseName($Content_cd);//歸屬課程
					$course['content_type'] = $course_info['packet_type'];//下載格式
					$course['content_license'] = $course_info['license'];//授權型態
					$course['download_role'] = "<img src=\"".createTPLPath()."/images/icon/download.gif\">";

				$courseList[]=$course;
			}
		}
    }
	//well_print($courseList);
	//[[OPTION SETUP]]


	//[[SHOW]] 
	
	$tpl->assign("role_cd",$role_cd);
	$tpl->assign("dist_cd",$dist_cd);

	
	$tpl->assign("content_name",$content_name);
	if($action == 'search'){
		$tpl->assign("page_ids",$pagerOpt['page_ids']);
		$tpl->assign("page_names",$pagerOpt['page_names']);
		$tpl->assign("page_sel",$pagerOpt['page_sel']);
		$tpl->assign("page_cnt",$pager->getPageCnt());
		$tpl->assign("previous_page",$pager->previousPage());
		$tpl->assign("next_page",$pager->nextPage());
	}
	$tpl->assign("courseList",$courseList);
	assignTemplate($tpl, '/teaching_material/textbook_general_download.tpl');
//------------------------------------------------------------------------------------	add by joyce
	function getCourseName($Content_cd)
	{
		if($Content_cd){
		$sql="SELECT p.begin_course_name
				  FROM class_content_current t, begin_course p
				  WHERE t.begin_course_cd = p.begin_course_cd AND
						t.content_cd = $Content_cd
					";
		$courseName = db_getOne($sql);
		}
		$courseName = $courseName!='' ? $courseName : '無'; 
		return $courseName;
	}

	//------------------------------------------------------------------------------------	add by joyce	
	function getContent_info($packet_type,$license)
	{
		switch($packet_type)
		{
			case 0:
            case 1:
            case 2:
				$row['packet_type'] = "平台格式";
			break;
            case 3:
            case 4: 
				$row['packet_type'] = "SCORM(*.zip)";
			break;
			default:
				$row['packet_type'] = "其他";
			break;
		}
			
		switch($license)
		{
			case 0: 
				$row['license'] = "未指定授權";
			break;
			case 1: 
				$row['license'] = "開放自由使用";
			break;
			case 3: 
				$row['license'] = "<a href='http://creativecommons.org/licenses/by/3.0/tw' target=_blank><img src='../images/download_cc/cc1.png' alt='姓名標示' border='0' /></a>";
			break;
			case 4: 
				$row['license'] = "<a href='http://creativecommons.org/licenses/by-nc/3.0/tw/' target=_blank><img src='../images/download_cc/cc2.png' alt='姓名標示─非商業性' border='0' />";
			break;
			case 5: 
				$row['license'] = "<a href='http://creativecommons.org/licenses/by-nc-sa/3.0/tw' target=_blank><img src='../images/download_cc/cc3.png' alt='姓名標示─非商業性─相同方式分享' border='0' />";
			break;
			case 6: 
				$row['license'] = "<a href='http://creativecommons.org/licenses/by-nd/3.0/tw' target=_blank><img src='../images/download_cc/cc4.png' alt='姓名標示─禁止改作' border='0' />";
			break;
			case 7: 
				$row['license'] = "<a href='http://creativecommons.org/licenses/by-nc-nd/3.0/tw' target=_blank><img src='../images/download_cc/cc5.png' alt='姓名標示─非商業性─禁止改作' border='0' />";
			break;
			case 8: 
				$row['license'] = "<a href='http://creativecommons.org/licenses/by-sa/3.0/tw' target=_blank><img src='../images/download_cc/cc6.png' alt='姓名標示─相同方式分享' border='0' />";
			break;
			case 9: 
				$row['license'] = "教育部聲明格式";
			break;
		}	
		return $row;
	}

//---------------------------------------------------------------------------------------------- mofify by joyce	
	function getCourseTeacherName($teacher_cd)
	{
		if($teacher_cd){
			$sql="SELECT personal_name
				  FROM personal_basic
				  WHERE personal_id = $teacher_cd
					";
			$teacherName = db_getOne($sql);
			$teacherName = $teacherName!='' ? $teacherName : '無'; 
			return $teacherName;
		}
		else {
			return '無';
		}
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

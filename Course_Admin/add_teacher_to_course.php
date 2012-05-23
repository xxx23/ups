<?php
/***
FILE:   
DATE:   
AUTHOR: zqq
**/
$RELEATED_PATH = "../";
require_once($RELEATED_PATH . "config.php");
require_once($RELEATED_PATH . "session.php");
require_once($RELEATED_PATH . "library/filter.php");

//update_status ( "確認開課中" );
	checkAdmin();
	
	//new smarty	
	require_once($HOME_PATH . 'library/smarty_init.php');

//語言
if(!isset($_SESSION["lang"]))
    $_SESSION["lang"] = "zh_tw";

$lang = $_SESSION["lang"];


    if(isset($_GET[begin_course_cd])){
	  	$_SESSION[begin_course_cd]=$_GET[begin_course_cd];
		$begin_course_cd = $_SESSION['begin_course_cd'];
	}
	//顯示剛輸入的課程資訊
	$sql = "SELECT * FROM begin_course WHERE begin_course_cd='".$_SESSION[begin_course_cd]."'";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
	$tpl->assign("begin_course_name",	$row[begin_course_name]);
	$tpl->assign("begin_unit_cd",	getUnitNameByUnitCd($DB_CONN, $row[begin_unit_cd]));
	$tpl->assign("inner_course_cd",	$row[inner_course_cd]);
	$tpl->assign("d_course_begin",	$row[d_course_begin]);
	$tpl->assign("d_course_end",	$row[d_course_end]);
	$tpl->assign("d_public_day",	$row[d_public_day]);
	$tpl->assign("d_select_begin",	$row[d_select_begin]);
	$tpl->assign("d_select_end",	$row[d_select_end]);
	$tpl->assign("course_year",		$row[course_year]);
	$tpl->assign("course_session",	$row[course_session]);
	$tpl->assign("course_cd",		$row[course_cd]);
	$tpl->assign("begin_course_cd",	$row[begin_course_cd]);		
        $tpl->assign("attribute",$row['attribute']);
	$attribute = $row['attribute'];

	//add by Samuel @ 09/07/26
	//新增課程性質和修課期限
	
	//修課期限 = course_duration
	$course_duration = $row['course_duration'];
	
    if($lang == "zh_tw")
        $month = $course_duration."個月";
    else
        $month = $course_duration."month(s)";
	$tpl->assign("month",$month);
	
	//課程屬性 = course_property 
	//利用 course_property 去course_property 這個資料表查名稱
	// modify by Samuel @ 2009/08/01
	$course_property = $row['course_property'];
	$sql = " SELECT property_name FROM course_property where property_cd={$course_property}";
	$property_name = db_getOne($sql);
	
	$tpl->assign("property_name",$property_name);

	//add by Samuel @ 09/07/24
	//新增加自學式的資料
	
	$tpl->assign("take_hour",$row['take_hour']);
	$tpl->assign("certify",$row['certify']);
	$tpl->assign("charge",$row['charge']);
	$tpl->assign("charge_discount",$row['charge_discount']);
	$tpl->assign("criteria_total",$row['criteria_total']);
	$tpl->assign("criteria_content_hour",$row['criteria_content_hour']);

	// add by Samuel @ 09/07/24
	// 如果是自學式的課程 會直接開好課程
	// 設定 begin_course 裡面的 begin_coursestate = 1即可
	// 
	// 因為開設課程需要判斷 begin_course 裡面的 note是否為NULL
	// 所以在這裡將 note 加入日期

    //教導也要設定 指定老師後就開課 by carlcarl
	if($attribute == 0 || $attribute == 1) //自學式
	{
	  	$sql = "UPDATE begin_course SET begin_coursestate = '1',
		  note = '".getCurTime()."'
		  WHERE begin_course_cd = {$begin_course_cd}";
		$res = $DB_CONN->query($sql);

	}
	

	//判斷是否要新增 if action = addTeacher
	if($_GET[action] == 'addTeacher'){
		if(!addTeacher($DB_CONN, $_POST[begin_course_cd], $_POST[teacher_cd], $_POST[course_master])){
            if($lang == "zh_tw")
    			$tpl->assign( "err_message","教師已經存在");
            else
                $tpl->assign( "err_message","Teacher already exsits.");
		}
		else{
            if($lang=="zh_tw")
    			$tpl->assign( "err_message","新增成功");		
            else
                $tpl->assign( "err_message","Add successfully");
		}	
	}
	else if($_GET[action] == 'deleteTeacher'){
		$sql = "DELETE FROM teach_begin_course WHERE begin_course_cd='".$_GET[begin_course_cd]."' and teacher_cd='".$_GET[teacher_cd]."'";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
	}		
	/*if($_GET[action] == 'addTeacher'){
		if(!addTeacher($DB_CONN, $_SESSION[begin_course_cd], $_POST[teacher_cd], $_POST[course_master], $row[begin_course_name])){
			$tpl->assign( "err_message","教師已經存在");
		}
		else{
			$tpl->assign( "err_message","新增成功");		
		}	
	}*/
	
	//顯示這門課的教師
	$sql = "SELECT p.personal_id, r.login_id, p.personal_name, t.course_master FROM teach_begin_course t, personal_basic p, register_basic r WHERE t.begin_course_cd='".$_SESSION[begin_course_cd]."'  and t.teacher_cd=p.personal_id and p.personal_id=r.personal_id";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$course_master = false;	
	while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){		
		if($row[course_master]){
			$row[course_master]='Yes';
			$course_master = true;
		}
		else
			$row[course_master]='No';	
		$tpl->append('teacher_data', $row);	
	}	
	
	//顯示新增教師的地方
	//查出所有的教師
    $sql = "SELECT p.personal_id, p.personal_name, r.login_id FROM personal_basic p, register_basic r WHERE p.personal_id=r.personal_id and r.role_cd='1'";

    // ajax讀取老師清單的部份, 只有在搜尋的時候會用到
    $search_type = optional_param('search', NULL, PARAM_ALPHA);
    if(!is_null($search_type))
    {
        if($search_type === 'all')
        {
            // do nothing
        }
        else if($search_type === 'name')
        {
            $value = optional_param('value', '', PARAM_TEXT);
            $sql .= " and p.personal_name like '%$value%'";
        }
        else if($search_type === 'account')
        {
            $value = optional_param('value', '', PARAM_TEXT);
            $sql .= " and r.login_id like '%$value%'";
        }
        else
        {
            // do nothing
        }
    }
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());	
	$teacher_num = $res->numRows();
	for($i=0; $i< $teacher_num; $i++){
		$teacher_data = $res->fetchRow(DB_FETCHMODE_ASSOC);
		$teacher_names[$i] = $teacher_data[personal_name]." (".$teacher_data[login_id].")";
		$teacher_ids[$i] = $teacher_data[personal_id];
	}	
	$tpl->assign("teacher_ids",	$teacher_ids );
	$tpl->assign("teacher_id",	$teacher_ids[0] );
	$tpl->assign("teacher_names", $teacher_names );	
	//是否為主要填寫者
	if(!$course_master){
		$tpl->assign("course_master_ids", array(0, 1));
		$tpl->assign("course_master_id",1);
		$tpl->assign("course_master_names", array('No', 'Yes'));	
	}
	else{
		$tpl->assign("course_master_ids", array(0));
		$tpl->assign("course_master_id",0);
		$tpl->assign("course_master_names", array('No'));
        if($lang == "zh_tw")
    		$tpl->assign("message", "已經有主要填寫者");		
        else
            $tpl->assign("message", "Main completer already exsits");
	}
	//輸出頁面
	
	assignTemplate($tpl, "/course_admin/add_teacher_to_course.tpl");
			
//------function area---------
function getUnitNameByUnitCd($DB, $unit_cd){
	$sql = "SELECT unit_name FROM lrtunit_basic_ WHERE unit_cd='$unit_cd'";
	return $DB->getOne($sql);
}

function addTeacher($DB, $begin_course_cd, $teacher_cd, $course_master){
	//global $DATA_FILE_PATH;
	//先查詢是否存在
	$sql = "SELECT count(*) FROM teach_begin_course WHERE begin_course_cd='$begin_course_cd' and teacher_cd='$teacher_cd'";
	$count = $DB->getOne($sql);
	if($count != 0)
		return false;
	else{
		$sql = "INSERT INTO teach_begin_course (begin_course_cd, teacher_cd, course_master) VALUES ( '$begin_course_cd', '$teacher_cd', '$course_master')";
		$res = $DB->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		//新增相關資料夾
		/*$export_data_dir= $DATA_FILE_PATH . $teacher_cd . "/export_data/";
		$test_bank_dir	= $DATA_FILE_PATH . $teacher_cd . "/test_bank/";
		$textbook_dir	= $DATA_FILE_PATH . $teacher_cd . "/textbook/";
		make_teacher_dir($export_data_dir);
		make_teacher_dir($test_bank_dir);
		make_teacher_dir($textbook_dir);*/
	}
	return true;
}

?>

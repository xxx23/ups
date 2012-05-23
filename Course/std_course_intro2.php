<?php
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	require_once($RELEATED_PATH."library/common.php");
    require_once($RELEATED_PATH."library/filter.php");
	//update_status ( "編輯課程大綱" );
	//new smarty	
	$tpl = new Smarty();
    
    //$_GET['begin_course_cd'] = required_param("begin_course_cd",PARAM_INT);

	//讀取課程編號
	if(isset($_GET["begin_course_cd"]))
	{
		$cur_begin_course_cd = $_GET["begin_course_cd"];
	}
	else
	{
		$cur_begin_course_cd = $_SESSION['begin_course_cd'];
	}
    
    // modify by Samuel @ 2009/11/01
    // 因為選課需知新增了一些欄位，所以要把缺少的部份加進去
    // 其中包含 課程名稱、課程屬性、課程性質 課程的修課通過資訊。

    $sql = "SELECT * FROM begin_course where begin_course_cd = {$cur_begin_course_cd}";
    $result = db_getRow($sql);
    $tpl->assign("begin_course_name",$result['begin_course_name']);
    //找出課程性質
    $property_name = db_getOne("SELECT property_name FROM course_property where property_cd = {$result['course_property']}");
    $tpl->assign("course_property",$property_name);
    //找出課程屬性
    if($result['attribute'] == 1)
        $attribute = "教導";
    else
        $attribute = "自學";
    $tpl->assign("attribute",$attribute);
    $criteria_time = explode(":",$result['criteria_content_hour']);
    $tpl->assign("criteria_content_hour",$criteria_time[0]);
    $tpl->assign("criteria_content_minute",$criteria_time[1]);
    $tpl->assign("criteria_total",$result['criteria_total']);
    // end modification here. @ 2009/11/01

	$cur_course_cd = db_getOne("SELECT course_cd FROM begin_course WHERE begin_course_cd=$cur_begin_course_cd");
	if($cur_course_cd == null)
	{
		echo "無相關選課資訊。";
		exit(0);
	}

    //查出課程資料
	$sql = "SELECT * FROM course_basic WHERE course_cd='".$cur_course_cd."'";
	$res = $DB_CONN->query($sql);
	if($res->numRows() != 0){
		$course_data = $res->fetchRow(DB_FETCHMODE_ASSOC);
		$tpl->assign("audience", $course_data['audience']);
		$tpl->assign("prepare_course", $course_data['prepare_course']);
		$tpl->assign("mster_book", $course_data['mster_book']);
		$tpl->assign("ref_book", $course_data['ref_book']);
        $tpl->assign("ref_url", $course_data['ref_url']);
        $tpl->assign("goal",$course_data['goal']);
        $tpl->assign("introduction",$course_data['introduction']);
        $tpl->assign("outline",$course_data['outline']);
        $tpl->assign("note",$course_data['note']);
	}

	$editable = false;
	$tpl->assign("editable",$editable);
    $tpl->assign("role_cd",$_SESSION['role_cd']);
	assignTemplate($tpl, "/course/course_intro2.tpl");
	
//--------function area-------------
?>

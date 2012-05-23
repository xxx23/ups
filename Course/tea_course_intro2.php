<?php
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	//update_status ( "編輯課程大綱" );
	//new smarty	
	$tpl = new Smarty();
    //die $_SESSION['role_cd'];
	$cur_course_cd = "";
	//讀取課程編號
	if(isset($_GET['course_cd']))
	  	$cur_course_cd = $_GET['course_cd'];
	else if(isset($_POST['course_cd']))
	  	$cur_course_cd = $_POST['course_cd'];
	else
  		$cur_course_cd = db_getOne("SELECT course_cd FROM begin_course WHERE begin_course_cd=".$_SESSION['begin_course_cd']);

	if($cur_course_cd == null)
    {
	  	echo "教師尚未設定課程。";
		if(isset($_SESSION['role_cd']) && $_SESSION['role_cd'] == '1')
		{
			echo "<br>請到<a href=\"course_manage.php\">課程管理</a>中掛載課程。";
		}
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
        $tpl->assign("introduction",$course_data['introduction']);
        $tpl->assign("outline",$course_data['outline']);
        $tpl->assign("goal",$course_data['goal']);
        $tpl->assign("note",$course_data['note']);
    }
  // echo "dd"; 
    //如session無begin_course_cd則先查出來
     if(!isset($_SESSION['begin_course_cd'])){
       //先取出begin_course_cd
       $sql = "select * from begin_course where course_cd='{$cur_course_cd}'";
       $result = db_getRow($sql);
       $_SESSION['begin_course_cd'] = $result['begin_course_cd'];
     } 
   
    //echo $_SESSION['role_cd']."<==role_cd";
    
    if($_SESSION['role_cd']==3||$_SESSION['role_cd']==4){
    // 查出課程名稱
    $sql = "SELECT * from begin_course where begin_course_cd={$_SESSION['begin_course_cd']}";

    $result = db_getRow($sql);
    
    $tpl->assign("begin_course_name",$result['begin_course_name']);
    $property_name = db_getOne("select property_name from course_property where property_cd = {$result['course_property']}");
    $tpl->assign("course_property",$property_name);

    if($result['attribute'] == 0)
        $attribute = "自學";
    else
        $attribute = "教導";
    $tpl->assign("attribute",$attribute);
    //把課程的通過時間切割成小時和幾分。
    $criteria_time = explode(":",$result['criteria_content_hour']);
    $tpl->assign("criteria_content_hour",$criteria_time[0]);
    $tpl->assign("criteria_content_minute",$criteria_time[1]);
    $tpl->assign("criteria_total",$result['criteria_total']);
    //end modify @ 2009/11/01
    }

    $tpl->assign("role_cd",$_SESSION["role_cd"]);
    //判斷角色權限
	if(($_SESSION["role_cd"] == 0) || ($_SESSION["role_cd"] == 1) || ($_SESSION["role_cd"] == 2))
	  $editable = true;
	else
	  $editable = false;
	$tpl->assign("editable",$editable);

	if($editable && isset($_POST["updatetext"]) && isset($_POST["updatefield"]))
	{
		doupdate($_POST["updatetext"],$_POST["updatefield"],$cur_course_cd);
	}else{
	  
	  
		assignTemplate($tpl, "/course/course_intro2.tpl");
	}
	
//--------function area-------------
	function doupdate( $text , $field , $course_cd)
	{
	global $DB_CONN;
	  $sql = "UPDATE course_basic SET ".$field." = '".$text."' WHERE course_cd='".$course_cd."'";
	
	$res = $DB_CONN->query($sql);
	  if (PEAR::isError($res))
	  {
	    die($res->getMessage());
	    return false;
	  }
	  else
	  {
	    return true;
	  }
	}
?>

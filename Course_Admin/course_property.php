<?php

// add by Samuel @ 2009/07/31
// 這一支程式是用來建立與刪除 課程性質 (如語言類、電腦類、音樂類等)

	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH."config.php");
	require_once($RELEATED_PATH."session.php");
	require_once("../library/common.php");
    require_once("../library/filter.php");
    checkAdminAcademic();
    $_GET['action'] = optional_param("action",NULL,PARAM_TEXT);
    $_REQUEST['property_cd'] = optional_param("property_cd",-1,PARAM_INT);
    $_POST['property_new_name'] = optional_param("property_new_name",NULL,PARAM_TEXT);
    $action = $_GET['action'];
	$property_cd = $_REQUEST['property_cd'];
	if(isset($_POST['property_new_name']))
		$new_course_property=$_POST['property_new_name']."類";
	
	$tpl = new Smarty();

	//要刪除課程性質 補充說明：temp_number 是用來判斷目前應該要顯示什麼介面
	//所以如果是修改的話，temp_number = 1 ; assign到tpl檔後，就會顯示修改的介面。
	//如果是delete、new_property的話，就會顯示最原始的版本
	if($action == "delete")
	{
	  	if(isset($property_cd))
 		{
	    		$sql = "DELETE FROM course_property where property_cd = {$property_cd}";
	   		$res = $DB_CONN->query($sql);
		}
		$temp_number = 0 ;
		$tpl->assign("temp_number",$temp_number);
	}
	elseif( $action == "modify")
	{
	  	$temp_number = 1; 
		$tpl->assign('temp_number',$temp_number);
		$sql = "SELECT property_name FROM course_property WHERE property_cd = {$property_cd}";
		$property_name = db_getOne($sql);
		$tpl->assign("old_name",$property_name);
		$tpl->assign("property_cd",$property_cd);
	}
	elseif( $action == "new_property")
	{
	  	$temp_number = 0; 
	  	//取得目前最大的編號
		$sql = "SELECT max(property_cd) FROM course_property";
		$number = db_getOne($sql) + 1;

		if(isset($new_course_property))
		  $sql = "INSERT course_property ( property_cd , property_name) 
		  VALUES ('{$number}','{$new_course_property}')";
		$res = $DB_CONN->query($sql);
		$tpl->assign("temp_number",$temp_number);
	}
	elseif( $action == "after_modify")
	{
	  	$temp_number = 0 ;
		if(isset($new_course_property) && isset($property_cd)){
		  	$sql = "UPDATE course_property SET property_name = '{$new_course_property}' 
			  WHERE property_cd = {$property_cd}";
			$DB_CONN->query($sql);
		}
		$tpl->assign("temp_number",$temp_number);
	}

	//把所有的課程都顯示出來
	$sql = "SELECT * FROM course_property ORDER by property_cd" ;
	$course_property = db_getAll($sql);
	$tpl->assign("course_property",$course_property);

	assignTemplate($tpl,"/course_admin/course_property.tpl");
?>

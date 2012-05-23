<?
/*
DATE:   2007/04/04
AUTHOR: tkraha
 */
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH . $CSS_VERSION_PATH;
	$absoluteURL = $HOMEURL . "EPaper/";

	$personal_id = $_SESSION['personal_id'];				//取得個人編號
	$role_cd = $_SESSION['role_cd'];						//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];		//取得課程代碼
	
	$title = "訂閱電子報";
	
	$content = "訂閱成功";

	//判斷是否為正常的讀取
	if(!checkTeacherCD($personal_id,$begin_course_cd))
	{
		$content = "對不起，您不是這門課的教師";
	}
	else
	{
		$sql =  "SELECT * FROM take_course WHERE begin_course_cd=$begin_course_cd";
		$rows = db_getAll($sql);
		foreach($rows as $value)
		{
		  	//判斷是否已訂閱
		  	$sql = "SELECT personal_id FROM person_epaper WHERE personal_id=$value[personal_id] and begin_course_cd=$begin_course_cd and if_subscription='Y'";
			$result = db_query($sql);
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			if(count($row) > 0)
				continue;

			$sql = "INSERT INTO person_epaper 
									(
										personal_id, 
										begin_course_cd, 
										if_subscription
									) VALUES (
										$value[personal_id], 
										$begin_course_cd,
										'Y'
									)";
			db_query($sql);
		}
	}
	
	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	$tpl->assign("title", $title);
	$tpl->assign("content", $content);
	
	assignTemplate($tpl, "/epaper/message.tpl");


	//檢查personal_id是否為這門課的授課教師
	//return true:如果使用者是這門課的教師
	//return false:如果使用者不是這門課的教師
	function checkTeacherCD($teacher_cd,$begin_course_cd)
	{
	  	//檢查參數是否都正確
	  	if($teacher_cd == "" || $begin_course_cd == "")
		  return false;

		$sql = "select teacher_cd from teach_begin_course where teacher_cd=$teacher_cd and begin_course_cd=$begin_course_cd";
		$row = db_getRow($sql);
		if(count($row) > 0)
	  		return true;
      		else
  			return false;		  
	}
?>

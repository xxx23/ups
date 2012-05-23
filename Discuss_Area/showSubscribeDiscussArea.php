<?
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "Discuss_Area/";
	
	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	if($role_cd == 0)//系統管理者
	{
		$tpl->assign("behavior", "admin");
	}
	elseif($role_cd == 1)//老師
	{
		$tpl->assign("behavior", "teacher");
	}
	elseif($role_cd == 3)//學生
	{
		$tpl->assign("behavior", "student");
	}
	else//其它
	{
		$tpl->assign("behavior", "");
	}
	
	$tpl->assign("isDeleteOn", 1);	//是否允許刪除
	
	//從Table discuss_subscribe搜尋個人訂閱的討論區
	$sql = "SELECT A.*, B.begin_course_name, C.discuss_name, C.discuss_title 
					FROM 
						discuss_subscribe A, 
						begin_course B, 
						discuss_info C 
					WHERE 
						A.personal_id = $personal_id AND 
						A.begin_course_cd = B.begin_course_cd AND 
						A.begin_course_cd = C.begin_course_cd AND 
						A.discuss_cd = C.discuss_cd
					";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	
	$disscussAreaNum = $res->numRows();
	$tpl->assign("disscussAreaNum", $disscussAreaNum);
	
	if($disscussAreaNum > 0)
	{
		$rowCounter = 0;
	
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			
			//設定討論區類型以及討論區名稱
			$discuss_name = $row[discuss_name];
			if($row[group_no] == 0)
			{	
				if( strncmp($discuss_name, "精華區_", strlen("精華區_")) == 0)	
				{
					$discuss_type = "課程精華區";
					$discuss_name = str_replace("精華區_", "", $discuss_name);
				}
				else
					$discuss_type = "課程討論區";
			}
			else
			{					
				$discuss_type = "小組討論區";
			}
			
			//將資料填入disscussAreaList中
			$disscussAreaList[$rowCounter] = 
					array(
							"begin_course_cd" => $row[begin_course_cd], 
							"discuss_cd" => $row[discuss_cd], 
							"discuss_name" => $discuss_name, 
							"discuss_title" => $row[discuss_title], 
							"discuss_type" => $discuss_type, 
							"begin_course_name" => $row[begin_course_name]
							);
			
			$rowCounter++;
		}
		
		$tpl->assign("disscussAreaList", $disscussAreaList);
	}
	
	//目前的頁面
	$tpl->assign("currentPage", "showSubscribeDiscussArea.php");
	
	if(isset($isShowSmartyTemplate) == 0)	$isShowSmartyTemplate = 1;
	if($isShowSmartyTemplate == 1)
	{
		assignTemplate($tpl, "/discuss_area/subscribeDiscussAreaList.tpl");
	}
?>

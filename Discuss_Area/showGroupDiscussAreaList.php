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
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼
	
	$showType = $_GET['showType'];						//取得要顯示的討論區類型
	if( isset($showType) == false)	$showType = $_SESSION['showType'];
	$_SESSION['showType'] = $showType;


	$behavior = $_GET['behavior'];						//取得行為


	$hw_no = $_GET['hw_no'];							//如果是作業分組, 會傳入此參數
	if( isset($showType) == false)	$hw_no = -1;

    require_once($HOME_PATH . 'library/smarty_init.php');
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	$tpl->assign("behavior", $behavior);
	
	if($behavior == "admin")//系統管理者
	{
		$isModifyOn = 1;
		$tpl->assign("isModifyOn", $isModifyOn);	//是否允許修改討論區
		$modifyPolicy = "All";
		$tpl->assign("isDeleteOn", 1);	//是否允許刪除討論區
		$tpl->assign("isBackupOn", 1);	//是否允許備份討論區
		$tpl->assign("isSubscribeOn", 1);//是否允許訂閱討論區
		$isShowPrivate = 1;				//是否顯示所有討論區
	}
	else if($behavior == "teacher")//教師
	{
		$isModifyOn = 1;
		$tpl->assign("isModifyOn", $isModifyOn);
		$modifyPolicy = "All";
		$tpl->assign("isDeleteOn", 1);
		$tpl->assign("isBackupOn", 1);	
		$tpl->assign("isSubscribeOn", 1);
		$isShowPrivate = 1;	
	}
	else if($behavior == "student")//學生
	{
		$isModifyOn = 1;
		$tpl->assign("isModifyOn", $isModifyOn);
		$modifyPolicy = "Group";
		$tpl->assign("isDeleteOn", 0);
		$tpl->assign("isBackupOn", 0);
		$tpl->assign("isSubscribeOn", 1);
		$isShowPrivate = 0;	
	}
	else//其它
	{
		$isModifyOn = 0;
		$tpl->assign("isModifyOn", $isModifyOn);
		$modifyPolicy = "None";
		$tpl->assign("isDeleteOn", 0);
		$tpl->assign("isBackupOn", 0);
		$tpl->assign("isSubscribeOn", 0);
		$isShowPrivate = 0;	
	}
	
	//從Table discuss_info搜尋所有的課程討論區
	$sql = "SELECT A.*, B.group_no, B.is_public, B.homework_no  
					FROM 
						discuss_info A, 
						discuss_groups B 
					WHERE 
						A.begin_course_cd = $begin_course_cd AND 
						A.begin_course_cd = B.begin_course_cd AND 
						A.discuss_cd = B.discuss_cd 
					ORDER BY A.discuss_cd ASC";
    $res = db_query($sql);
	
	$discussAreaNum = $res->numRows();	

	if($discussAreaNum > 0)
	{
		$rowCounter = 0;

		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{			
			$discuss_cd[$rowCounter] = $row[discuss_cd];
			$discuss_name[$rowCounter] = $row[discuss_name];
			$discuss_title[$rowCounter] = $row[discuss_title];
			$group_no[$rowCounter] = $row[group_no];
			$is_public[$rowCounter] = $row[is_public];
			$homework_no[$rowCounter] = $row[homework_no];
			
			$rowCounter++;
		}
		$rowNum = $rowCounter;
		
		$discussAreaListCounter = 0;
		for($rowCounter=0; $rowCounter<$rowNum; $rowCounter++)
		{
			//設定討論區類型以及討論區名稱		
			if($group_no[$rowCounter] == 0)
			{	
				if( strncmp($discuss_name[$rowCounter], "社群_", strlen("社群_")) == 0)	
				{
					$discuss_type = "社群分享區";
					$discuss_name[$rowCounter] = str_replace("社群_", "", $discuss_name[$rowCounter]);
				}
				else
					$discuss_type = "課程討論區";
			}
			else
			{					
				$discuss_type = "小組討論區";
			}
			
			//設定是否允許修改討論區
			$isOneDiscussAreaModifyOn = 0;
			if($isModifyOn == 1)
			{
				switch($modifyPolicy){
				case "All":		$isOneDiscussAreaModifyOn = 1;	break;
				case "Group":	if($discuss_type == "小組討論區")	$isOneDiscussAreaModifyOn = 1;	break;
				case "None":	$isOneDiscussAreaModifyOn = 0;	break;
				default:		$isOneDiscussAreaModifyOn = 0;	break;
				}
			}
			
			//過濾掉其他不顯示的討論區類型
			if($showType == "Course"  && $discuss_type != "社群分享區")	continue;
			
			$discussAreaList[$discussAreaListCounter] = 
					array(
							"discuss_cd" => $discuss_cd[$rowCounter], 
							"discuss_name" => $discuss_name[$rowCounter], 
							"discuss_title" => $discuss_title[$rowCounter],
							"discuss_type" => $discuss_type,							
							"subscribe" => $subscribe, 
							"isOneDiscussAreaModifyOn" => $isOneDiscussAreaModifyOn
							);
			
			$discussAreaListCounter++;
		}
		$tpl->assign("discussAreaNum", $discussAreaListCounter);
		$tpl->assign("discussAreaList", $discussAreaList);
	}
    //次要教師 限制只能參與 by carlcarl
    $sql = "select course_master from teach_begin_course 
        where teacher_cd=$personal_id and begin_course_cd=$begin_course_cd";
    $isCourseMaster = db_getOne($sql);

    $tpl->assign("isCourseMaster", $isCourseMaster);

	//目前的頁面
	$tpl->assign("currentPage", "showGroupDiscussAreaList.php");
	
	if(isset($isShowSmartyTemplate) == false)	$isShowSmartyTemplate = 1;
	
	if($isShowSmartyTemplate == 1)
	{	
		assignTemplate($tpl, "/discuss_area/groupDiscussAreaList.tpl");
	}
?>

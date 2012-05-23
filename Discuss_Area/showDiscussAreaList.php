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

	$tpl = new Smarty;
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
	
	
	//從Table discuss_subscribe搜尋這堂課的個人訂閱
	$sql = "SELECT * FROM discuss_subscribe 
					WHERE 
						begin_course_cd = $begin_course_cd AND 
						personal_id = $personal_id 
					ORDER BY discuss_cd ASC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$subscribeNum = $res->numRows();
	
	if($subscribeNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$subscribeData[$rowCounter] = $row;
			
			$rowCounter++;
		}
	}
	
	//從Table discuss_info搜尋所有的課程討論區
	$sql = "SELECT A.*, B.group_no, B.is_public, B.homework_no  
					FROM 
						discuss_info A, 
						discuss_groups B 
					WHERE 
						A.begin_course_cd = $begin_course_cd AND 
						A.begin_course_cd = B.begin_course_cd AND 
                        A.discuss_cd = B.discuss_cd AND
                        A.discuss_name not like '社群\_%'
					ORDER BY A.discuss_cd ASC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	
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
		
		$subscribeDataCounter = 0;
		$discussAreaListCounter = 0;
		for($rowCounter=0; $rowCounter<$rowNum; $rowCounter++)
		{
			//判斷是否有訂閱討論區
			if($subscribeData[$subscribeDataCounter][discuss_cd] == $discuss_cd[$rowCounter])
			{
				$subscribe = 1;
					
				$subscribeDataCounter++;
			}
			else
			{
				$subscribe = 0;
			}


			//過濾掉不能觀看的討論區
			if( $isShowPrivate == 0)
			{
				if($group_no[$rowCounter] != 0 && $is_public[$rowCounter] != 'y')
				{
					//私人小組討論區
					
					//看目前的使用者有沒有在此小組裡面
					
					$sql = "SELECT 
								* 
							FROM 
								discuss_menber_groups A 
							WHERE 
								A.begin_course_cd = $begin_course_cd AND 
								A.discuss_cd = $discuss_cd[$rowCounter] AND 
								A.group_no = $group_no[$rowCounter] AND 
								A.student_id = $personal_id
							";
					$res = $DB_CONN->query($sql);
					if (PEAR::isError($res))	die($res->getMessage());
					$resultNum = $res->numRows();	
					
					if($resultNum <= 0){	continue;	}					
				}
			}
			
			
			//設定討論區類型以及討論區名稱		
			if($group_no[$rowCounter] == 0)
			{	
				if( strncmp($discuss_name[$rowCounter], "精華區_", strlen("精華區_")) == 0)	
				{
					$discuss_type = "課程精華區";
					$discuss_name[$rowCounter] = str_replace("精華區_", "", $discuss_name[$rowCounter]);
				}
				else
					$discuss_type = "課程討論區";
			}
			else
			{					
				$discuss_type = "小組討論區";
				$isOneDiscussAreaModifyOn = 1;
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
			if($showType == "Course"  && $discuss_type != "課程討論區")	continue;
			if($showType == "Group"   && $discuss_type != "小組討論區")	continue;
			if($showType == "Essence" && $discuss_type != "課程精華區")	continue;
			
			//作業小組討論區時, 過濾掉其他不是本次作業的討論區
			/*if($showType == "Group" && $hw_no != -1)
			{
				if($homework_no[$rowCounter] != $hw_no)		continue;
			}*/
			
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

	//目前的頁面
	$tpl->assign("currentPage", "showDiscussAreaList.php");
	
	if(isset($isShowSmartyTemplate) == false)	$isShowSmartyTemplate = 1;
	
	if($isShowSmartyTemplate == 1)
	{	
		assignTemplate($tpl, "/discuss_area/discussAreaList.tpl");
	}
?>

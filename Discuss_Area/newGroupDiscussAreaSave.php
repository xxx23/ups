<?
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
    require_once('../config.php');
    require_once($RELEATED_PATH . 'library/filter.php');

    $IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "Discuss_Area/";

	//從SESSION抓取資料
	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼
	
	$behavior = $_POST["behavior"];						//取得行為
	
	$action = $_POST["action"];
	
	$amount = $_POST["amount"];
	$discuss_name = $_POST["discuss_name"];
     $discuss_name = optional_param("discuss_name", 0, PARAM_NOTAGS );
    $discuss_title = $_POST["discuss_title"];

     $discuss_title = optional_param("discuss_title", 0, PARAM_NOTAGS );
	//$discuss_type = $_POST["discuss_type"]; delete by carlcarl
	$access = $_POST["access"];	
	
	
	//設定要建立的討論區數量
   
    if(isset($amount) == false)	$amount = 1;
    
	for( $amountCounter=1; $amountCounter<=$amount; $amountCounter++)
	{
		if($action == "new")
		{
			$new_discuss_name = $discuss_name;
		}
		else if($action == "batch")
		{
			$new_discuss_name = str_replace("%d", "$amountCounter", $discuss_name);
		}

		//判斷討論區類型 delete by carlcarl
		/*if($discuss_type == 0) 
		{
			//ㄧ般討論區
			
			$is_public = 'y';
			$group_no = 0;
		}
		else if($discuss_type == 1) 
		{
			//小組討論區
			
			//設定存取權限is_public
			if($access == 0)	$is_public = 'y';
			else				$is_public = 'n';
			
			//從Table discuss_groups中取得新的group_no
			$sql = "SELECT 
						* 
					FROM 
						discuss_groups 
					WHERE 
						begin_course_cd=$begin_course_cd 
					ORDER BY 
						group_no DESC
					";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
				
			$resultNum = $res->numRows();
			if($resultNum == 0)
			{
				$group_no = 1;
			}
			else
			{			
				$res->fetchInto($row, DB_FETCHMODE_ASSOC);
				
				$group_no = $row[group_no] + 1;
			}
			
		}
		else if($discuss_type == 2) 
		{
			//精華區
			
			$new_discuss_name = "精華區_" . $new_discuss_name;
			
			$is_public = 'y';
			$group_no = 0;
        }*/

        //add by carlcarl
        $new_discuss_name = "社群_" . $new_discuss_name;
        $is_public = 'n';
        $group_no = 0;

	
		//從Table discuss_info中取得新的discuss_cd
		$sql = "SELECT 
					* 
				FROM 
					discuss_info 
				WHERE 
					begin_course_cd=$begin_course_cd 
				ORDER BY 
					discuss_cd DESC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
			
		$disscussAreaNum = $res->numRows();
		if($disscussAreaNum == 0)
		{
			$discuss_cd = 1;
		}
		else
		{
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		
			$discuss_cd = $row[discuss_cd] + 1;
		}
		
		//新增資料到Table discuss_info
		$sql = "INSERT INTO discuss_info 
							(
								begin_course_cd, 
								discuss_cd, 
								discuss_name, 
								discuss_title
							) VALUES (
								$begin_course_cd, 
								$discuss_cd, 
								'$new_discuss_name', 
								'$discuss_title'
							)";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		
		//新增資料到Table discuss_groups
		$sql = "INSERT INTO discuss_groups 
							(
								begin_course_cd, 
								discuss_cd, 
								group_no, 
								is_public
							) VALUES (
								$begin_course_cd, 
								$discuss_cd, 
								$group_no, 
								'$is_public'
							)";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		/* delete by carlcarl
		//設定小組成員
		if($discuss_type == 1) 
		{
			//小組討論區
						
			$studentNum = $_POST["studentNum"];	
			
			for($studentCounter=0; $studentCounter<$studentNum; $studentCounter++)
			{				
				if(isset($_POST["student_" . $studentCounter]) == true)
				{
					$student_id = $_POST["student_" . $studentCounter];
					
					//新增資料到Table discuss__menber_groups
					$sql = "INSERT INTO discuss_menber_groups 
										( 
											begin_course_cd, 
											discuss_cd, 
											group_no, 
											student_id 
										) VALUES ( 
											$begin_course_cd, 
											$discuss_cd, 
											$group_no, 
											$student_id 
										)";
					$res = $DB_CONN->query($sql);
					if (PEAR::isError($res))	die($res->getMessage());
				}
			}
        }*/

	}
    
    
	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	$title = "新增社群討論區";
	$content = "新增成功";
    $content = $content . "<br><a href='newGroupDiscussArea.php?behavior=$behavior'>繼續 新增社群討論區</a>"
        . "　<a href='showGroupDiscussAreaList.php?behavior=$behavior&showType=Course'>回社群討論區列表</a>";

	$tpl->assign("title", $title);
	$tpl->assign("content", $content);
	
	assignTemplate($tpl, "/discuss_area/message.tpl");
    
?>

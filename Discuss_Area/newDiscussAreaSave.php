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
	
    $behavior = optional_param('behavior', 0, PARAM_ALPHA);//取得行為
	$action = optional_param('action', 0, PARAM_ALPHA);
	$amount = optional_param('amount', 1, PARAM_INT);
    $discuss_name = optional_param("discuss_name", 0, PARAM_NOTAGS );
    $discuss_title = optional_param("discuss_title", 0, PARAM_NOTAGS );
    $discuss_type = required_param('discuss_type', PARAM_INT);	
    $access = optional_param('access', 0, PARAM_INT);

    //檢查小組討論區是不是私人, 而且一個人都沒有選
    //這裡要避免幽靈討論區
    if($discuss_type == 1 && $access != 0) 
    {
        $ghostGroup = true;
        $studentNum = required_param('studentNum', PARAM_INT);

        for($studentCounter=0; $studentCounter<$studentNum; $studentCounter++)
        {
            //有選任何一個人就表示不是幽靈私人小組討論區            
            if(isset($_POST["student_" . $studentCounter]) == true)
            {
                $ghostGroup = false;
                break;
            }
        }
        if($ghostGroup == true)
        {
            if(!isset($_SESSION['lang']) || $_SESSION['lang'] == 'zh_tw')
                die('私人小組討論區: 請至少選一個組員');
            else
                die('Private group forum: Please select at least one person');
        }
    }




	//設定要建立的討論區數量
    
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
        else //有其他奇怪的action就導到錯誤頁面
        {
            header("Location:".$WEBROOT."error.html");
            return;
        }

		//判斷討論區類型
		if($discuss_type == 0) 
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
            $res = db_query($sql);
				
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
		}

	
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
        $res = db_query($sql);
			
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
        $res = db_query($sql);
		
		
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
        $res = db_query($sql);
		
		
		//設定小組成員
		if($discuss_type == 1) 
		{
			//小組討論區
						
			$studentNum = required_param('studentNum', PARAM_INT);
			
			for($studentCounter=0; $studentCounter<$studentNum; $studentCounter++)
			{				
				if(isset($_POST["student_" . $studentCounter]) == true)
				{
					$student_id = required_param('student_' . $studentCounter, PARAM_TEXT);
					
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
                    $res = db_query($sql);
				}
			}
        }

	}
    
    
	require_once($HOME_PATH . 'library/smarty_init.php'); 
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

    if(!isset($_SESSION['lang']) || $_SESSION['lang'] == 'zh_tw') 
    {
        $title = "新增討論區";
        $content = "新增成功";
        $content = $content . "<br><a href='newDiscussArea.php?behavior=$behavior'>繼續 新增討論區</a>";
    }
    else 
    {
        $title = "Add Forums";
        $content = "Add successfully";
        $content = $content . "<br><a href='newDiscussArea.php?behavior=$behavior'>Continue to add forums</a>";
    }

	$tpl->assign("title", $title);
	$tpl->assign("content", $content);
	
	assignTemplate($tpl, "/discuss_area/message.tpl");
    
?>

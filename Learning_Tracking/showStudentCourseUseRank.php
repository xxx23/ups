<?php
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");
	require_once($RELEATED_PATH . "library/content.php");
    require_once($HOME_PATH . 'library/filter.php') ; 
    require_once("./time_output_format.php");
    //require_once($HOME_PATH. 'library/smarty_init.php');
    $CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Learning_Tracking/";

	$tpl = new Smarty;
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

    //取得action
	$action = $_POST['action'];	
	if( isset($action) == false)	$action = "none";

	if($action == "none")
	{
		$tpl->assign("rank_type", "DEFAULT");
		
		$tpl->assign("isShowDayNum", 0);
		$tpl->assign("dayNum", 10);
		
		$tpl->assign("isShowShowNum", 1);
		$tpl->assign("showNum", 10);
		
		$tpl->assign("isShowOrder", 1);
		$tpl->assign("order", "DEFAULT");
	}
	else if($action == "showRank")
	{
		
        $rank_type = $_POST["rank_type"];
		$tpl->assign("rank_type", $rank_type);

		
		if($rank_type == 'NotLoginCourse')	$tpl->assign("isShowDayNum", 1);
		else								$tpl->assign("isShowDayNum", 0);
		$dayNum = $_POST["dayNum"];
		$tpl->assign("dayNum", $dayNum);

		if($rank_type == 'NotLoginCourse')	$tpl->assign("isShowShowNum", 0);
		else								$tpl->assign("isShowShowNum", 1);
        $showNum = $_POST["showNum"];
        $showNum= optional_param("$showNum", 0, PARAM_INT );

		$tpl->assign("showNum", $showNum);
		
		if($rank_type == 'NotLoginCourse')	$tpl->assign("isShowOrder", 0);
		else								$tpl->assign("isShowOrder", 1);
		$order = $_POST["order"];
		$tpl->assign("order", $order);
		$begin_course_cd = $_SESSION['begin_course_cd'];		//取得課程代碼


		//get from showStudentCourseUseRank by include global variable reffernce 
		//
		//$rank_type = $_GET['rank_type'];	//取得要顯示的項目
		//$dayNum = $_GET['dayNum'];		//取得天數
		//$showNum = $_GET['showNum'];		//取得顯示比數
		//$order = $_GET['order'];			//取得排列方式

		
		//特別的rank_type
		if($rank_type == "NotLoginCourse")
		{
			$tpl->assign("rankTypeName", "最後登入時間");
			
			//從Table take_course取得課程學生名單	
			$sql = "SELECT 
						A.personal_id, 
						B.personal_name,
						B.email	
					FROM 
						take_course A, 
						personal_basic B 
					WHERE 
						A.begin_course_cd = $begin_course_cd AND 
						A.personal_id = B.personal_id 
					ORDER BY 
						A.personal_id ASC
					";
			$res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			$resultNum = $res->numRows();
		
			if($resultNum > 0)
			{
				$rowCounter = 0;
			
				while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
				{	
					$studentList[$rowCounter]['isLoginInTime'] = 0;
					$studentList[$rowCounter]['personal_name'] = $row['personal_name'];
					$studentList[$rowCounter]['email'] = $row['email'];
					$studentList[$rowCounter]['student_id'] = $row['personal_id'];
					$studentList[$rowCounter]['function_occur_time'] = 0;
					
					$rowCounter++;
				}
				$studentNum = $rowCounter;
				$tpl->assign("studentNum", $studentNum);
				
				//搜尋在n天內有登入課程的學生
				if($dayNum > 0)	$loginTimeLine = substr(shell_exec("date -v-" . $dayNum . "d \"+%Y-%m-%d\""), 0, 10) . " 23:59:59";
				else			$loginTimeLine = TIME_date(2) . " 23:59:59";
				
				$sql = "SELECT 
							A.personal_id
						FROM 
							event A
						WHERE 
							A.begin_course_cd = $begin_course_cd AND 
							A.system_id = 1 AND 
							A.function_id = 2 AND 
							A.function_occur_time > '$loginTimeLine'	
						GROUP BY 
							A.personal_id 
						ORDER BY 
							A.personal_id ASC
						";
				$res = $DB_CONN->query($sql);
				if (PEAR::isError($res))	die($res->getMessage());
				$resultNum = $res->numRows();
				if($resultNum > 0)
				{
					$studentListCounter = 0;
					
					
					while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
					{
						$isError = 0;
						
						//判斷是哪一個學生
						while($row[personal_id] != $studentList[$studentListCounter][student_id])
						{
							$studentListCounter++;
						
							//錯誤的資料
							if($studentListCounter >= $studentNum)
							{
								$studentListCounter = 0;
								$isError = 1;
								break;
							}
						}
						if($isError == 1)	continue;

						$studentList[$studentListCounter]['isLoginInTime'] = 1;				
					}
				}
				
				
				//對於沒有在n天內登入的學生則搜尋最後登入時間
				$dataNum = 0;
				for($studentListCounter=0; $studentListCounter<$studentNum; $studentListCounter++)
				{
					if($studentList[$studentListCounter][isLoginInTime] == 0)
					{
						/*$sql = "SELECT 
									A.function_occur_time 
								FROM 
										event A,
											personal_basic B					
								WHERE 
									A.begin_course_cd = $begin_course_cd AND 
									A.system_id = 1 AND 
									A.function_id = 2 AND 
									A.personal_id = " . $studentList[$studentListCounter][student_id] . " AND 
										A.personal_id = B.personal_id	
								ORDER BY 
									A.function_occur_time DESC
                                    ";*/
                        //Edit by carlcarl 這個版本的SQL語法比較快
                        $sql = "SELECT 
									MAX(A.function_occur_time) as function_occur_time
								FROM 
										event A,
											personal_basic B					
								WHERE 
									A.begin_course_cd = $begin_course_cd AND 
									A.system_id = 1 AND 
									A.function_id = 2 AND 
									A.personal_id = " . $studentList[$studentListCounter][student_id] . " AND 
										A.personal_id = B.personal_id
								";

						$res = $DB_CONN->query($sql);
						if (PEAR::isError($res))	die($res->getMessage());
						//$resultNum = $res->numRows();
						$res->fetchInto($row, DB_FETCHMODE_ASSOC);

						if($row['function_occur_time'] == NULL)
						{
							$studentList[$studentListCounter]['function_occur_time'] = "尚未登入課程過";
						}
						else
						{
							//$res->fetchInto($row, DB_FETCHMODE_ASSOC);
							$studentList[$studentListCounter]['function_occur_time'] = $row['function_occur_time'];
						}
						
						
						$dataList[$dataNum] = 
									array(	"rank" => $dataNum+1, 
											"name" => $studentList[$studentListCounter]['personal_name'], 
											"data" => $studentList[$studentListCounter]['function_occur_time'],
												"email" =>$studentList[$studentListCounter]['email'] 
											  );
						$dataNum++;
					}
					
				}
			}
		}
		else
		{	
			//其它的rank_type
		
			if($order == "top")	{	$sqlOrder = "DESC";	}
			else				{	$sqlOrder = "ASC";	}
			
			switch($rank_type)
			{
			case 'LoginCourse':
				$tpl->assign("rankTypeName", "課程登入次數");
				//找出修這堂課的學生名單	
				$sql ="create temporary table take_course_students ENGINE = MEMORY
				       Select P.email , P.personal_name , P.personal_id , T.begin_course_cd
				       From personal_basic P ,  take_course T
				       Where T.begin_course_cd = $begin_course_cd and T.personal_id = P.personal_id ";
				db_query($sql);
				//取出事件的統計資料
				$sql = "Create temporary table course_statistic ENGINE = MEMORY
				        Select E.begin_course_cd,E.function_occur_number , E.personal_id 
					From event_statistics E
				 	Where E.begin_course_cd = $begin_course_cd and E.system_id = 1 and E.function_id = 2";
				db_query($sql);
				//再將上面兩個table left join起來，如果有欄位值為null則代表沒登入過
				$sql = "Select tcs.email,tcs.personal_name, cs.function_occur_number data
					From   take_course_students tcs left join course_statistic cs on
					tcs.personal_id = cs.personal_id
					ORDER BY cs.function_occur_number $sqlOrder";
						
				/*

					$sql = "SELECT 
							A.function_occur_number data, 
							B.personal_name ,
							B.email
						FROM 
							event_statistics A, 
							personal_basic B, 
							take_course C 
						WHERE 
							A.begin_course_cd = $begin_course_cd AND 
							A.system_id = 1 AND 
							A.function_id = 2 AND 
							A.personal_id = B.personal_id AND 
							A.begin_course_cd = C.begin_course_cd AND 
							A.personal_id = C.personal_id 
						ORDER BY 
						A.function_occur_number $sqlOrder";
				 */
		
				break;
			case 'LoginCourseTime':
			

			        $tpl->assign("rankTypeName", "課程使用時數");
				//找出修這堂課的學生名單	
				$sql ="create temporary table take_course_students ENGINE = MEMORY
				       Select P.email , P.personal_name , P.personal_id , T.begin_course_cd
				       From personal_basic P ,  take_course T
				       Where T.begin_course_cd = $begin_course_cd and T.personal_id = P.personal_id ";
				db_query($sql);
				//取出事件的統計資料
				$sql = "Create temporary table course_statistic ENGINE = MEMORY
				        Select E.begin_course_cd,E.function_hold_time , E.personal_id 
					From event_statistics E
				 	Where E.begin_course_cd = $begin_course_cd and E.system_id = 1 and E.function_id = 2";
				db_query($sql);
				//再將上面兩個table left join起來，如果有欄位值為null則代表沒登入過
				$sql = "Select tcs.email,tcs.personal_name, cs.function_hold_time data
					From   take_course_students tcs left join course_statistic cs on
					tcs.personal_id = cs.personal_id
					ORDER BY cs.function_hold_time $sqlOrder";
						






			/*	$tpl->assign("rankTypeName", "課程使用時數");
				
				$sql = "SELECT 
							A.function_hold_time data, 
							B.personal_name ,
							B.email
							
						FROM 
							event_statistics A, 
							personal_basic B, 
							take_course C 
						WHERE 
							A.begin_course_cd = $begin_course_cd AND 
							A.system_id = 1 AND 
							A.function_id = 2 AND 
							A.personal_id = B.personal_id AND 
							A.begin_course_cd = C.begin_course_cd AND 
							A.personal_id = C.personal_id 
						ORDER BY 
							A.function_hold_time $sqlOrder";
				
			 */	break;
			case 'DisscussAreaPost':
				$tpl->assign("rankTypeName", "討論區文章發表次數");
					
				//找出修這堂課的學生名單	
				$sql ="create temporary table take_course_students ENGINE = MEMORY
				       Select P.email , P.personal_name , P.personal_id , T.begin_course_cd  
				       From personal_basic P ,  take_course T
				       Where T.begin_course_cd = $begin_course_cd and
				       T.personal_id = P.personal_id ";
				db_query($sql);

				//取出事件的統計資料
				$sql = "Create temporary table course_statistic ENGINE = MEMORY
				        Select E.begin_course_cd,E.function_occur_number , E.personal_id
					From event_statistics E
					Where E.begin_course_cd = $begin_course_cd and
					      E.system_id = 3 and E.function_id = 1";
				db_query($sql);
 	 
				//再將上面兩個table left join起來，如果有欄位值為null則代表沒POST過
				$sql = "Select tcs.email,
				  	       tcs.personal_name,
				        cs.function_occur_number data 
				        From   take_course_students tcs left join course_statistic cs on  
					tcs.personal_id = cs.personal_id
					ORDER BY cs.function_occur_number $sqlOrder";
	 	 
   				/*
				$sql = "SELECT 
							A.function_occur_number data, 
							B.personal_name ,
							B.email

						FROM 
							event_statistics A, 
							personal_basic B, 
							take_course C 
						WHERE 
							A.begin_course_cd = $begin_course_cd AND 
							A.system_id = 3 AND 
							A.function_id = 1 AND 
							A.personal_id = B.personal_id AND 
							A.begin_course_cd = C.begin_course_cd AND 
							A.personal_id = C.personal_id 
						ORDER BY 
							A.function_occur_number $sqlOrder";
				 */
				break;
			case 'ReadText':
	  
			        $tpl->assign("rankTypeName", "學生瀏覽教材次數");
	
				//找出修這堂課的學生名單	
				$sql ="create temporary table take_course_students ENGINE = MEMORY
				       Select P.email , P.personal_name , P.personal_id , T.begin_course_cd
				       From personal_basic P ,  take_course T
				       Where T.begin_course_cd = $begin_course_cd and T.personal_id = P.personal_id ";
				db_query($sql);
				//取出事件的統計資料
				$sql = "Create temporary table course_statistic ENGINE = MEMORY
				        Select E.begin_course_cd,SUM(E.event_happen_number) AS function_occur_number , E.personal_id 
					From student_learning E
				 	Where E.begin_course_cd = $begin_course_cd 
					GROUP BY personal_id";
				db_query($sql);
				//再將上面兩個table left join起來，如果有欄位值為null則代表沒登入過
				$sql = "Select tcs.email,tcs.personal_name, cs.function_occur_number data
					From   take_course_students tcs left join course_statistic cs on
					tcs.personal_id = cs.personal_id
					ORDER BY cs.function_occur_number $sqlOrder";
	
	
	
	
		/*		
				$sql = "SELECT 
							A.function_occur_number data, 
							B.personal_name, 
							B.email
						FROM 
							event_statistics A, 
							personal_basic B, 
							take_course C 
						WHERE 
							A.begin_course_cd = $begin_course_cd AND 
							A.system_id = 4 AND 
							A.function_id = 1 AND 
							A.personal_id = B.personal_id AND 
							A.begin_course_cd = C.begin_course_cd AND 
							A.personal_id = C.personal_id 
						ORDER BY 
							A.function_occur_number $sqlOrder";
		 */		
				break;
			case 'ReadTextTime':
				$tpl->assign("rankTypeName", "學生瀏覽教材總時數");
				//找出修這堂課的學生名單	
				$sql ="create temporary table take_course_students ENGINE = MEMORY
				       Select P.email , P.personal_name , P.personal_id , T.begin_course_cd 
				       From personal_basic P ,  take_course T
				       Where T.begin_course_cd = $begin_course_cd and
				       T.personal_id = P.personal_id ";
                db_query($sql);
    
				//取出事件的統計資料
			    $sql = "Create temporary table course_statistic ENGINE = MEMORY
				        Select E.begin_course_cd,SUM(TIME_TO_SEC(E.event_hold_time))AS function_hold_time , E.personal_id
					From student_learning E
					Where E.begin_course_cd = $begin_course_cd and E.content_cd = ".get_Content_cd($begin_course_cd)."
					GROUP BY personal_id";
                db_query($sql);
 	 
				//再將上面兩個table left join起來，如果有欄位值為null則代表沒POST過
			    $sql = "Select tcs.email,
				  	       tcs.personal_name,
				        cs.function_hold_time data 
				        From   take_course_students tcs left join course_statistic cs on  
					tcs.personal_id = cs.personal_id
                    ORDER BY cs.function_hold_time $sqlOrder";


	/*			$sql = "SELECT 
							A.function_hold_time data, 
							B.personal_name,
								B.email	
						FROM 
							event_statistics A, 
							personal_basic B, 
							take_course C 
						WHERE 
							A.begin_course_cd = $begin_course_cd AND 
							A.system_id = 4 AND 
							A.function_id = 1 AND 
							A.personal_id = B.personal_id AND 
							A.begin_course_cd = C.begin_course_cd AND 
							A.personal_id = C.personal_id 
						ORDER BY 
							A.function_hold_time $sqlOrder";
	 */			
			break;
			default:	return;
			}
		
			//從Table event_statistics搜尋記錄
            $res = $DB_CONN->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			$resultNum = $res->numRows();
			
			if($resultNum > 0)
			{
                $rowCounter = 0;
				while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
                {
					switch($rank_type)
					{
                             
                    case 'LoginCourseTime':
                    case 'ReadTextTime':
							   $data = time_output_format((int)$row[data]);	//只顯示到小數點以下兩位
                               break;
					default:
							if($row[data] == '')
							   $row[data]='0';

							$data =  $row[data];
							break;
					}
					//用來計算使否增加Rank
					if($data != $pre_data)
					{
					  $i++;
					  $pre_data = $data;
					}
					$dataList[$rowCounter] = 
							array(		"rank" => $i, 
									"name" => $row[personal_name], 
									"data" => $data,
									"email" => $row[email]
								);
					
					$rowCounter++;
					
					if($rowCounter == $showNum)	break;
				}
				$dataNum = $rowCounter;
			}
        }
        
        /*dataNum:有幾列*/
		$tpl->assign("dataNum", $dataNum);
		$tpl->assign("dataList", $dataList);
		//$tpl->assign("content", "showStudentCourseUseRankAction.php?rank_type=$rank_type&dayNum=$dayNum&showNum=$showNum&order=$order");
	}


	//目前的頁面
	$tpl->assign("currentPage", "showStudentCourseUseRank.php");
	
	assignTemplate($tpl, "/learning_tracking/studentCourseUseRank.tpl");
?>

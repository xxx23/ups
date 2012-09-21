<?php
/***
FILE:   history_course_list.php
DATE:   2009/07-31
AUTHOR:q110185
**/

	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	require_once($RELEATED_PATH . "library/date.php");
	require_once('../library/content.php');
    require_once('../library/filter.php');
    require_once('../library/course.php');

	// get personal id from session
	$pid = $_SESSION['personal_id'];    
	$dist_cd = getDistCD($pid);

    $showType = optional_param('showType',-1,PARAM_INT);
    $date_start = optional_param('date_start','');
    $date_end = optional_param('date_end',"");
    $course_search_name = optional_param('course_search_name','');
    $isPass = optional_param('isPass',-1,PARAM_INT);

    //   echo "DATE : $date_start ~ $date_end";
    //	echo "dist_cd : ". $dist_cd."<br/>";
	
	//new smarty	
	require_once($HOME_PATH . 'library/smarty_init.php');
	$debug =0;

    //退選
    if ($_GET['action'] == 'drop' && isset($_GET['begin_course_cd']))
    {
        //把某一門課退遠 是把這一筆資料由take_course中刪除
        quit_course($_GET['begin_course_cd'], $pid);
    }

	//設定列表方式	
	if( $showType == -1 ){
		$tpl->assign('selfFlag','1');
		$tpl->assign('teachFlag','1');
        $showType_sel = 0;
    }
	else if($showType == 0){
		$tpl->assign('selfFlag','1');
		$tpl->assign('teachFlag','1');
        $showType_sel = 0;
    }
	else if($showType == 1){
		$tpl->assign('selfFlag','1');
        $tpl->assign('teachFlag','0');
        $showType_sel = 1;
	}
	else if($showType==2){
		$tpl->assign('selfFlag','0');
        $tpl->assign('teachFlag','1');
        $showType_sel = 2;
    }
    $showType_ids=array(0,1,2);
    $showType_names=array("(全部)","自學課程","教導課程");
    $tpl->assign("showType_ids",$showType_ids);
    $tpl->assign("showType_names",$showType_names);
    $tpl->assign("showType_sel",$showType_sel);
    
    //判斷腳色為高中職或中小學老師show出送高師大時間
	if($dist_cd==1||$dist_cd==2)
	{
		$tpl->assign('sendTimeFlag','1');
	}
	else
	{
		$tpl->assign('sendTimeFlag','0');
	}
	
	//  取出修課時限已過之自學式課程
	//$sql = "SELECT b.begin_course_cd, b.certify, b.begin_course_name, b.criteria_total, b.take_hour,t.pass
	//		FROM begin_course b, take_course t
	//		WHERE t.personal_id=$pid AND t.course_end < NOW() AND b.begin_course_cd=t.begin_course_cd AND b.attribute='0'";
	
	
	
	//-----------[取出修課自學式課程]---------------
	$sql = "SELECT b.begin_course_cd, b.inner_course_cd, b.certify, b.begin_course_name, b.criteria_total, b.criteria_content_hour, t.pass, t.send2nknu_time
			FROM begin_course b, take_course t
            WHERE t.personal_id=$pid  
            AND b.begin_course_cd=t.begin_course_cd 
            AND b.attribute='0'
            AND b.begin_course_name LIKE '%{$course_search_name}%'";
    if($date_start !='' && $date_end != '')      
       $sql .= " AND t.course_begin > '$date_start'
                 AND t.course_begin < '$date_end'";
    if($isPass != -1)
        $sql .= " AND pass=$isPass";    
	if($debug==1)echo $sql;
	$result = $DB_CONN->query($sql);
	if($result->numRows())
	{
		$selfTotalCertify=0;
		while($data_row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{	
			$data_row['readTime'] = getReadHour($data_row['begin_course_cd'],$pid);
			$data_row['score'] = getScore($data_row['begin_course_cd'],$pid,0);
			if($data_row['pass']=='1')
				$data_row['ifpass'] = "通過";
			else if($data_row['pass']=='0')
				$data_row['ifpass'] = "未通過";
			else
				$data_row['ifpass'] = "---";
			//echo $data_row['criteria_content_hour'];
			//$time = split(':',$data_row['criteria_content_hour']);
			//$data_row['criteria_content_hour'] = ;
			if($data_row['pass']=='1')$selfTotalCertify += $data_row['certify'];
			$nknu_time = ($data_row['send2nknu_time']!='0000-00-00')?$data_row['send2nknu_time']:'未送出';
			$data_row['sendTime'] =($data_row['pass']=='1')?$nknu_time:"---";//送高師大時間
			$tpl->append('selfCourseList',$data_row);
		}
	}
	//-----------[取出修課時限已過之教導式課程]---------------
	$sql = "SELECT b.begin_course_cd, b.inner_course_cd, b.certify, b.begin_course_name, b.criteria_total,t.send2nknu_time
			FROM begin_course b, take_course t
            WHERE t.personal_id=$pid 
            AND b.d_course_end < NOW() 
            AND b.begin_course_cd=t.begin_course_cd 
            AND b.attribute='1' 
            AND b.begin_course_name LIKE '%{$course_search_name}%'";
    if($data_start != '' && $date_end != '')
        $sql .= "AND b.d_course_begin > '$date_start'
                 AND b.d_course_begin < '$date_end'";
    if($isPass != -1)
        $sql .= " AND t.pass=$isPass";

	if($debug==1)echo $sql;
	$result = db_query($sql);
	if($result->numRows())
	{	
		$teachTotalCertify = 0;
		while($data_row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{ 
			$data_row['readTime'] = getReadHour($data_row['begin_course_cd'],$pid);
			$data_row['score'] = getScore($data_row['begin_course_cd'],$pid,1);
			$data_row['ifpass'] =($data_row['score'] >= $data_row['criteria_total']) ? "通過" : "--";
		    $nknu_time = ($data_row['send2nknu_time']!='0000-00-00')?$data_row['send2nknu_time']:'未送出';

			$data_row['sendTime'] = ($data_row['ifpass']=="通過")?$nknu_time:'---';//送高師大時間
			if($data_row['ifpass']=='通過')$teachTotalCertify += $data_row['certify'];
			$tpl->append('teachCourseList',$data_row);
		}
	}
    if($debug==1)echo "ttt1";
    $tpl->assign('isPass_ids',array(-1,0,1));
    $tpl->assign('isPass_names',array("(全部)","未通過","已通過"));
    $tpl->assign('isPass_sel',$isPass);
    $tpl->assign('date_start',$date_start);
    $tpl->assign('date_end',$date_end);    
    $tpl->assign('course_search_name',$course_search_name);
    $tpl->assign('selfTotalCertify',$selfTotalCertify);
	$tpl->assign('teachTotalCertify',$teachTotalCertify);
	
	if($debug==1)echo "ttt2";
	
	assignTemplate($tpl, "/personal_page/history_course_list.tpl");
	
	if($debug==1)echo "ttt3";
	
	//-----------------------------------------------
	// 	FUNCTION : getDistCD
	//  input :$cd -begin_course_cd 課程代碼abs
	//	output: 使用者的腳色編號
	//-----------------------------------------------
	function getDistCD($personal_id)
	{
		$sql = "SELECT pb.dist_cd
				FROM personal_basic pb
				WHERE pb.personal_id=$personal_id";
		$data = db_getOne($sql);
		return $data;
	}
	
	//-----------------------------------------------
	// 	FUNCTION : getReadHour
	//  input :$cd -begin_course_cd 課程代碼abs
	//		   $personal_id - 使用者代碼
	//	output: 此學生該課程閱讀時數
	//-----------------------------------------------
	function getReadHour($cd,$personal_id)
	{
		global $USE_MYSQL, $USE_MONGODB, $db;
		if($USE_MYSQL)
		{
			$sql = "SELECT 
					sum(A.event_happen_number) as event_hp_time,
					sum(TIME_TO_SEC(A.event_hold_time)) as event_hold_time  
				FROM 
					student_learning A 
				WHERE 
					A.begin_course_cd = '$cd' AND 
					A.content_cd = '".get_Content_cd($cd)."' AND 
					A.personal_id = '$personal_id'
				";
			$res = db_query($sql);
			$resultNum = $res->numRows();
			
			if($resultNum > 0)
			{	
				$res->fetchInto($row, DB_FETCHMODE_ASSOC);
				$hour = intval(intval($row['event_hold_time'])/3600) ;
				$min = intval((intval($row['event_hold_time'])%3600)/60);
				$sec = intval((intval($row['event_hold_time'])%3600)%60);
				
				$hour = ($hour < 10) ? "0".$hour : $hour;
				$min = ($min <10) ? "0".$min:$min;
				$sec = ($sec <10) ? "0".$sec:$sec;
				$ReadTextTime = $hour.":".$min.":".$sec;
				return $ReadTextTime;
			}
			else
			{
				return   "00:00:00 (H:M)";
			}
		}
		else if($USE_MONGODB)
		{
			$res = $db->command(array('aggregate' => 'student_learning', 'pipeline' => array(array('$match' => array('bcd' => intval($cd), 'ccd' => intval(get_Content_cd($cd)), 'pid' => intval($personal_id))), array('$group' => array('_id' => '$pid', 'event_hp_time' => array('$sum' => '$ehn'), 'event_hold_time' => array('$sum' => '$eht'))))));
			$resultNum = count($res);

			if($resultNum > 0)
			{
				$row = $res['result'][0];
				$hour = intval(intval($row['event_hold_time'])/3600) ;
				$min = intval((intval($row['event_hold_time'])%3600)/60);
				$sec = intval((intval($row['event_hold_time'])%3600)%60);
				
				$hour = ($hour < 10) ? "0".$hour : $hour;
				$min = ($min <10) ? "0".$min:$min;
				$sec = ($sec <10) ? "0".$sec:$sec;
				$ReadTextTime = $hour.":".$min.":".$sec;
				return $ReadTextTime;
			}
			else
			{
				return   "00:00:00 (H:M)";
			}
		}
	}
	//-----------------------------------------------
	// 	FUNCTION : getScore
	//  input :$cd -begin_course_cd 課程代碼abs
	//		   $personal_id - 使用者代碼
	//         $course_type - 1:教導式 ,0:自學式
	//	output: 此學生該課程分數
	//-----------------------------------------------
	function getScore($cd,$personal_id,$course_type)
	{
		$total_grade = 0.0;//總成績
		if($course_type == 0){//自學式 
			$sql = "SELECT cg.number_id, cg.concent_grade 
					FROM course_concent_grade cg
					WHERE cg.begin_course_cd=$cd AND cg.student_id=$personal_id AND cg.percentage_type=1 AND cg.percentage_num=1";
			//echo $sql;
			$result= db_query($sql);
			if($result->numRows())
			{
				while($dataRow = $result->fetchRow(DB_FETCHMODE_ASSOC))
				{
					$total_grade =$dataRow['concent_grade'];
				}
			}else $total_grade = '-' ;
		}
		else if($course_type==1){//教導式
			//Step1.取出該課程所有成績百分比對應表
			$sql = "SELECT cp.number_id, cp.percentage_type, cp.percentage, cp.percentage_num
					FROM course_percentage cp
					WHERE cp.begin_course_cd=$cd";
			//echo $sql;
			$result = db_query($sql);
			
			//$percentageTable;//對應表變數
			if($result->numRows())
			{
				while($dataRow = $result->fetchRow(DB_FETCHMODE_ASSOC))
				{
					$percentageTable[ $dataRow['percentage_type'] ][ $dataRow['percentage_num'] ]['percentage'] = $dataRow['percentage'];
					$percentageTable[ $dataRow['percentage_type'] ][ $dataRow['percentage_num'] ]['number_id'] = $dataRow['number_id'];
				}
			}
			//Step2.取出該生該課程所有原始成績 並查成績百分比對應表 算出總成績
			$sql = "SELECT cg.number_id, cg.percentage_num, cg.concent_grade, cg.percentage_type
					FROM course_concent_grade cg
					WHERE cg.begin_course_cd=$cd AND cg.student_id=$personal_id";
		
			//echo $sql;
			$result = db_query($sql);
		
			if($result->numRows())
			{
				while($dataRow = $result->fetchRow(DB_FETCHMODE_ASSOC))
				{
					$percentage = $percentageTable[ $dataRow['percentage_type'] ][ $dataRow['percentage_num'] ]['percentage'];
					if($percentage != null && $percentage!= 0)
						$total_grade += $dataRow['concent_grade'] * $percentage/100;
				}
			}
		}
		return $total_grade;
	}	
	
?>

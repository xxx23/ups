<?php
    /** 
     *
     * @file library/lib_course_pass.php
     *
     * @author unknown
	 * @date unknown
     */


	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH .'config.php');
	require_once('content.php');

    /**
     *	@brief 設定此自學士課程該生通過
	 *	設定此自學士課程該生通過
	 *  @param cd begin_course_cd，課程代碼
	 *  @param personal_id 使用者代碼
	 */
	function setSelfCoursePass($cd,$personal_id)
	{
		$sql = "UPDATE `take_course` 
				SET  `pass` =  '1', `pass_time`=NOW() 
				WHERE  `take_course`.`begin_course_cd` =$cd AND  `take_course`.`personal_id` =$personal_id ;";
		//echo $sql."\n\n";
		db_query($sql);
    }


	/**
     *	@brief 設定此自學士課程該生未通過
	 *	設定此自學士課程該生未通過
	 *  @param cd begin_course_cd，課程代碼
	 *  @param personal_id 使用者代碼
	 */

	function setSelfCourseFire($cd,$personal_id)
	{
		$sql = "UPDATE `take_course` 
				SET  `pass` =  '0' 
				WHERE  `take_course`.`begin_course_cd` =$cd AND  `take_course`.`personal_id` =$personal_id ;";
		//echo $sql."\n\n";
		db_query($sql);
	}
	
    
    /**
     *	@brief 取得此學生課程閱讀秒數
	 *	取得此學生課程閱讀秒數
	 *  @param cd begin_course_cd，課程代碼
	 *  @param personal_id 使用者代碼
     *	@return 此學生該課程閱讀秒數	 
     */
	function getReadSecond($cd,$personal_id)
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
			//echo $sql."\n\n";
			$res = db_query($sql);
			$resultNum = $res->numRows();
			
			if($resultNum > 0)
			{	
				$res->fetchInto($row, DB_FETCHMODE_ASSOC);
				$ReadTextTime = $row['event_hold_time'];
				if(empty($ReadTextTime))
					return 0;
				return $ReadTextTime;
			}
			else
			{
				return   0;
			}
		}
		else if($USE_MONGODB)
		{
			$res = $db->command(array('aggregate' => 'student_learning', 'pipeline' => array(array('$match' => array('bcd' => intval($cd), 'ccd' => intval(get_Content_cd($cd)), 'pid' => intval($personal_id))), array('$group' => array('_id' => '$pid', 'event_hp_time' => array('$sum' => '$ehn'), 'event_hold_time' => array('$sum' => '$eht'))))));
			$resultNum = count($res);

			if($resultNum > 0)
			{
				$row = $res['result'][0];
				$ReadTextTime = $row['event_hold_time'];
				if(empty($ReadTextTime))
					return 0;
				return $ReadTextTime;
			}
			else
			{
				return   0;
			}
		}
    }
    
    /**
     *  @author carlcarl
     *	@brief 判斷是否閱讀教材時間已足夠
	 *  @param begin_course_cd 課程代碼
     *  @param personal_id 使用者代碼
     *
     *	@retval true 通過
     *	@retval false 不通過 
     */
	function isReadTimeEnough($begin_course_cd, $personal_id)
	{
		$sql = "SELECT TIME_TO_SEC(criteria_content_hour) 
				FROM begin_course
				WHERE begin_course_cd = {$begin_course_cd}";
		$read_time_limit = db_getOne($sql);
		
        $read_time = getReadSecond($begin_course_cd,$personal_id);

		if($read_time >= $read_time_limit)
			return true;
		else 
			return false;
	}	

	
    /**
     *	@brief 取得此學生該課程分數
	 *	取得此學生該課程分數
	 *  @param cd begin_course_cd，課程代碼
     *  @param personal_id 使用者代碼
     *  @param course_type 0:教導式，1:自學式
     *	@return 此學生該課程分數	 
     */
	function getScore($cd,$personal_id,$course_type)
	{
		$total_grade = 0.0;//總成績
		if($course_type == 0){//自學式 
			$sql = "SELECT cg.number_id, cg.concent_grade 
					FROM course_concent_grade cg
					WHERE cg.begin_course_cd=$cd AND cg.student_id=$personal_id AND cg.percentage_type=1 AND cg.percentage_num=1";
			//echo $sql."\n\n";
			$result= db_query($sql);
			if($result->numRows())
			{
				while($dataRow = $result->fetchRow(DB_FETCHMODE_ASSOC))
				{
					$total_grade =(int) $dataRow['concent_grade'];
				}
			}
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
					else
						echo "no percentag";
				}
			}
		}
		return $total_grade;
	}	 
?>

<?php
	//error_reporting(E_ALL) ;
    $RELEATED_PATH = '../';
	require_once($RELEATED_PATH . 'config.php');
    require_once($RELEATED_PATH . 'session.php');
	require_once($RELEATED_PATH . "library/date.php");
	require_once($RELEATED_PATH . "library/common.php");
	
    define('TAKE_COURSE_STATE_ERROR',-1);//出現錯誤
    define('TAKE_COURSE_STATE_SELECT',0);//課程未選可選
    define('TAKE_COURSE_STATE_VERIFYING',1);//課程已選待審核
    define('TAKE_COURSE_STATE_PASS',2);//課程已通過
    define('TAKE_COURSE_STATE_STUDYING',3);//課程已選 修課中
    define('TAKE_COURSE_STATE_NOTSELECTTIME',4);//課程未在選課時間內(教導)
        
    function check_course_state($begin_course_cd, $personal_id)
    {
        //argument check
        if(  $begin_course_cd ==null ||
             $personal_id == null)
           return TAKE_COURSE_STATE_ERROR;

       $sql = "SELECT attribute,auto_admission,d_course_begin,d_course_end
                FROM   begin_course
                WHERE begin_course_cd={$begin_course_cd};
        ";
        $rel = db_query($sql);
        if($rel->numRows()==0)
            return TAKE_COURSE_STATE_ERROR;
        
        $courseData = $rel->fetchRow(DB_FETCHMODE_ASSOC);
       
        //判斷教導課程是否為選課期間
        if($courseData['attribute']==1){
            $sql = "SELECT begin_course_cd FROM begin_course WHERE begin_course_cd = {$begin_course_cd} AND NOW() BETWEEN d_select_begin AND d_select_end"; 
            $rel = db_query($sql);
            if($rel->numRows()==0)
                return TAKE_COURSE_STATE_NOTSELECTTIME;
        }
       
		
        //判斷課程有無選過
        $sql = "SELECT * 
                FROM take_course
                WHERE begin_course_cd={$begin_course_cd} AND
                      personal_id={$personal_id};";
        $rel = db_query($sql);
        if($rel->numRows()==0)
            return TAKE_COURSE_STATE_SELECT;
			
		$data = $rel->fetchRow(DB_FETCHMODE_ASSOC);
        //判斷課程是否通過
        if($data['pass'] == 1)
            return TAKE_COURSE_STATE_PASS;
        
        //判斷以選課程審核是否通過
        if($data['allow_course'] == 0)
            return TAKE_COURSE_STATE_VERIFYING;

         //判斷課程是否修課中
        if($courseData['attribute']==0)
            $sql = "SELECT begin_course_cd FROM take_course WHERE  personal_id = {$personal_id} AND NOW() BETWEEN course_begin AND course_end";
        else
            $sql = "SELECT begin_course_cd FROM begin_course WHERE  NOW() BETWEEN d_course_begin AND d_course_end";
        $rel = db_query($sql);

        if($rel->numRows()!=0)
            return TAKE_COURSE_STATE_STUDYING;

        return TAKE_COURSE_STATE_ERROR;
    }
    
    function take_course($begin_course_cd,$personal_id)
    {
        //argument check
        if(  $begin_course_cd==null ||
             $personal_id==null)
           return TAKE_COURSE_STATE_ERROR;
		   
		$sql = "SELECT attribute, course_duration, auto_admission, d_course_begin, d_course_end
                FROM   begin_course
                WHERE begin_course_cd={$begin_course_cd};
        ";
        $rel = db_query($sql);
        if($rel->numRows()==0)
            return TAKE_COURSE_STATE_ERROR;

        $courseData = $rel->fetchRow(DB_FETCHMODE_ASSOC);
		
		//把選課時間 以及課程結束時間紀錄起來
		//ADD by Samuel @ 09/07/29
		$today = date("Y-m-d");
	
		$class_end = date("Y-m-d",time()+$courseData['course_duration']*30*86400);


		if($courseData['auto_admission'] == 1) // 屬性等於1表示課程不需審查 可以直接把allow course設成1 自學式課程也可以做同樣的動作
		{
			if($courseData['attribute'] == 0){
				
				$sql = "INSERT INTO take_course ( 
				  begin_course_cd, 
				  personal_id, 
				  allow_course, 
				  status_student,
				  course_begin,
				  course_end)
				  VALUES ( 
					'{$begin_course_cd}',
					'{$personal_id}',
					'1',
					'1',
					'{$today}',
					'{$class_end}'
						)";
				$res = db_query($sql);
				sync_stu_course_data($begin_course_cd,$personal_id);
				
			}
			elseif($courseData['attribute'] == 1) // 表示是教導式課程
			{
				
				$sql = "INSERT INTO take_course(
				  begin_course_cd,
				  personal_id,
				  allow_course,
				  status_student,
				  course_begin,
				  course_end)
				  VALUES(
					'{$begin_course_cd}',
					'{$personal_id}',
					'1',
					'0',
					'{$courseData['d_course_begin']}',
					'{$courseData['d_course_end']}'
				  )";
				$res = db_query($sql);
				sync_stu_course_data($begin_course_cd,$personal_id);
			}
		}
		else // 
		{		  
			$sql = "INSERT INTO take_course ( begin_course_cd, personal_id, allow_course, status_student) 
					VALUE ('". $begin_course_cd."','".$personal_id."','0','0')";
			$res = db_query($sql);		
			sync_stu_course_data($begin_course_cd,$personal_id);
		}
    }
	
    function drop_course($begin_course_cd ,$personal_id)
    {
		  	//判斷是否真的可以退選
	  	$sql = "SELECT * FROM begin_course WHERE begin_course_cd='".$begin_course_cd."'
	  	 	and (d_select_begin > '".get_now_time_str()."' or d_select_end <= '".get_now_time_str()."') and note is not null and begin_coursestate='1'";
	  	$res_tmp = $DB_CONN->query($sql);
	  	if($res_tmp->numRows() == 0)
	  	{
			$sql = "DELETE FROM take_course WHERE begin_course_cd='".$begin_course_cd."' and personal_id='".$personal_id."' ";
			$res = $DB_CONN->query($sql);
			sync_stu_course_data($begin_course_cd,$personal_id);

			/*	
			// modify by Samuel @ 2009/08/02
			// 刪除學生的學習紀錄
			$sql = "DELETE FORM student_learning sl 
				WHERE sl.begin_course_cd={$begin_course_cd} AND
				sl.personal_id= {$personal_id}";	
			db_query($sql);
			
			// 刪除學生的成績
			
			$sql = "DELETE FORM course_concent_grade c 
				WHERE c.begin_course_cd={$begin_course_cd} AND
				c.student_id={$personal_id}";
			
			db_query($sql);
			 */
		}
	}
    

?>

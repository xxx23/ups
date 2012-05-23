<?php
    /** 
     *
     * @file library/course.php
     *
     * @author carlcarl
	 * @date 2011/08/02
     */


    /**
     * @brief 退選某個課程
     * 刪掉在某門課中的紀錄
     *
     * @param begin_course_cd 課程編號
     * @param pid 個人編號
     *
     */
    function quit_course($begin_course_cd, $pid)
    {
        $sql = "DELETE from take_course
            where begin_course_cd = {$begin_course_cd} 
            and personal_id = {$pid}";
        $res = db_query($sql);
        //退選後清除該學生在課程中的紀錄
        clear_student_learning($begin_course_cd,$pid);
        clear_student_score($begin_course_cd,$pid);

    }

    /*
     * @brief 刪除課程中學生的閱讀教材紀錄
     * 刪掉在student_learning和event_statistics table中的紀錄
     *
     * @param begin_course_cd 課程編號
     * @param personal_id 個人編號
     *
     */
    function clear_student_learning($begin_course_cd, $personal_id)
    {   
        if( ($begin_course_cd != null) && ($personal_id != null) ){     
            $sql = "DELETE FROM student_learning
                WHERE begin_course_cd=$begin_course_cd AND
                personal_id=$personal_id ;";
            //echo $sql;
            db_query($sql);

            $sql = "DELETE FROM event_statistics
                WHERE begin_course_cd='$begin_course_cd' AND
                personal_id='$personal_id';";
            db_query($sql);
        }
    }

    /*
     * @brief 刪除課程中學生的分數紀錄
     *
     * @param begin_course_cd 開課編號
     * @param personal_id 個人編號
     *
     */
    function clear_student_score($begin_course_cd, $personal_id)
    {   
        if( ($begin_course_cd != null) && ($personal_id != null) ){
            $sql = "DELETE FROM course_concent_grade 
                WHERE begin_course_cd='$begin_course_cd' AND
                student_id='$personal_id' ;";
            db_query($sql);
        }
    }
    
    /*
     * @brief 取得course的性質(0->自學, 1->教導)
     *
     * @param begin_course_cd 開課編號
     * @param personal_id 個人編號
     *
     */
	function get_course_attribute($begin_course_cd)
	{
		if(empty($begin_course_cd))
			return -1;
		$sql= "SELECT attribute FROM begin_course WHERE begin_course_cd={$begin_course_cd}";
		return db_getOne($sql);
	}

  
?>

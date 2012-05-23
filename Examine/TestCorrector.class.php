<?php
//author: q110185
//function : corects tests
require_once '../config.php';

class TestCorrector
{
    private $_answerTable = array();

    public function __construct()
    {
    }

    /*批改測驗*/
    public static function correctExam($begin_course_cd,$test_no)
    {
        $this->_retriveAnswer($begin_corse_cd,$test_no);
        //get all student test record
        $student_tsets = db_getAll("SELECT * 
                                    FROM test_course_ans
                                    WHERE test_bankno = $test_bankno;");
    
    }

    /*修正題庫答案後須重新批改此題的答案*/
    public function correctTestBankGrade($test_bankno)
    {
        $setup = $this->_retriveTestSetup($test_bankno);
        
        $student_tests = db_getAll("SELECT * 
                                    FROM test_course_ans
                                    WHERE test_bankno = $test_bankno;");
        $this->_correctTestAns($test_bankno,$setup['answer']);
        foreach($student_tests as $test)
        {
            $grade = 0;
            switch($setup['test_type'])
            {
            case 1:
                if($setup['is_multiple']==0)
                    $grade = $this->_correctSingle($test['answer'],$setup);
                else
                    $grade = $this->_correctMultiple($test['answer'],$setup);
                break;
            case 2:
                $grade = $this->_correctSingle($test['answer'],$setup);
                break;
            case 3:
                $grade = $this->_correctStuff($test['answer'],$setup);
                break;
            case 5:
                break;
            default:
                break;
            }
            if($setup['test_type']!=5)
                $this->_updateStudentGrade($test['begin_course_cd'],$test['test_no'],$test['personal_id'],$test_bankno,$grade);
            
            $total_grade = $this->getTestGrade($test['begin_course_cd'],$test['test_no'],$test['personal_id']);
            echo "total grade :$total_grade";
            $this->_updateStudentTestGrade($test['begin_course_cd'],$test['test_no'],$test['personal_id'],$total_grade);


        }
    }
    /*更正該測驗的解答*/
    private function _correctTestAns($test_bankno,$answer)
    {
        db_query("UPDATE test_coruse
                  SET answer = $answer
                  WHERE test_bankno = $test_bankno");
    } 

    /*取得解答*/
    private function _retriveAnswer($begin_course_cd,$test_no)
    {
        $result = db_query("SELECT * from test_course 
                            WHERE begin_course_cd = {$begin_course_cd}
                            AND test_no = {$test_no}
                            ORDER BY sequence;");
        while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
        {
            $this->_answerTable[$row['test_bankno']][]=$row;
        }
    }
    /*取得批改測驗的資料*/
    private function _retriveTestSetup($test_bankno)
    {
        $setup = db_getAll("SELECT TB.test_type,TB.is_multiple,TB.answer,TB.selection_no,TB.if_ans_seq,TB.selection1,TB.selection2,TB.selection3,TB.selection4,TB.selection5,TB.selection6,TC.grade
                             FROM test_bank TB,test_course TC
                             WHERE TB.test_bankno = $test_bankno
                             AND TB.test_bankno = TC.test_bankno;");
        return $setup[0];
    }

    /*修改學生該題目的成績*/
    private function _updateStudentGrade($course_cd,$test_no,$pid,$test_bankno,$grade)
    {
        db_query("UPDATE`test_course_ans` 
                    SET grade='$grade' 
                    WHERE begin_course_cd=$course_cd 
                    AND test_no = $test_no 
                    AND personal_id = $pid 
                    AND test_bankno={$test_bankno};");
    
    }
    /*建立某生的答案*/
    private function _updateStudentAnswer($course_cd,$test_no,$pid,$answer,$test_bankno)
    {
        //update answer
        $sql="SELECT COUNT(*) FROM test_course_ans WHERE begin_course_cd=$course_cd  AND test_no = $test_no AND personal_id = $pid AND test_bankno=$row[test_bankno] ;";
		$hasAns = db_getOne($sql);
			
		if($hasAns==0)
			db_query("insert into `test_course_ans` (answer, grade, begin_course_cd, test_no, personal_id, test_bankno) values ('$answer', '$grade', $course_cd, $test_no, $pid, {$row['test_bankno']});");
		else
			db_query("UPDATE`test_course_ans` SET answer='$answer',grade='$grade' WHERE begin_course_cd=$course_cd AND test_no = $test_no AND personal_id = $pid AND test_bankno={$row['test_bankno']};");
    }

    public function getTestGrade($begin_course_cd,$test_no,$pid)
    {
        return db_getOne("select sum(grade) from `test_course_ans` where begin_course_cd=$begin_course_cd and test_no=$test_no and personal_id=$pid;");
    }

    public function _updateStudentTestGrade($begin_course_cd,$test_no,$pid,$grade)
    {
        $number_id = db_getOne("select number_id from `course_percentage` where begin_course_cd=$begin_course_cd and percentage_type=1 and percentage_num=$test_no;");
        db_query("UPDATE  `course_concent_grade` SET concent_grade=$grade WHERE begin_course_cd=$begin_course_cd AND number_id=$number_id AND percentage_type=1 AND percentage_num=$test_no AND student_id=$pid;");
    }
     
	/*author: lunsrot
	 * date: 2007/07/01
	 * 單選題和是非題的閱卷方式相同
	 */
    private function _correctSingle($stu_ans,$setup)
    {
        //well_print($setup);
        if($setup['answer'] == $stu_ans)
            return $setup['grade'];
        else return 0;
			
	}
    
	/*author: lunsrot
	 * date: 2007/07/03
	 * 複選題
	 */
	private function _correctMultiple($stu_ans,$setup){
		$grade = 0;
        
        $ans = explode(";", $setup['answer']);
        $stu_ans = explode(";",$stu_ans);

        $union = array_unique(array_merge($stu_ans, $ans));
		$intersect = array_intersect($stu_ans, $ans);
		//row['selection_no']表示回答總數，
		//減去聯集個數表示不該勾選，而學生也的確沒有勾選，加上交集表示需勾選而學生也有勾選
		$right = $setup['selection_no'] - count($union) + count($intersect);
		if($setup['selection_no'] > 0)
			$grade = round(($right * $setup['grade']) / $setup['selection_no']);
        
        return $grade;
    }

	/*author: lunsrot
	 * date: 2007/07/03
	 * 電腦閱卷的填充題部份
	 */
	private function _correctStuff($stu_ans, $setup){
		$grade = 0;
		$right = 0;
        $stu_ans = explode(';',$stu_ans);
        $ans = explode(';',$setup['answer']);

		if($setup['if_ans_seq'] == 1){
			for($i = 1 ; $i <= $setup['selection_no'] ; $i++)
				if($setup['selection' . $i] == $ans[$i - 1])
					$right = $right + 1;
		}else{
			$tmp = array();
			for($i = 1 ; $i <= $setup['selection_no'] ; $i++)
				$tmp[$i - 1] = $setup['selection' . $i];
			$tmp = array_intersect($tmp, $stu_ans);
			$right = count($tmp);
		}

		if($setup['selection_no'] > 0)
			$grade = round(($right * $setup['grade']) / $setup['selection_no']);
        return $grade;
    }
}

//End of TestCorrector.class.php


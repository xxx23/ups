<?php
/***
FILE:   
DATE:   
AUTHOR: zqq

驗證開課的物件
**/
require_once ('../config.php');
require_once('../library/common.php');
//add by aeil
require_once("../library/filter.php");
//session_start();
class ValidateBeginCourse
{
	//DataBase
	private $pearDB;
	private $errorMsg; //for AJAX
	function __construct($DB_CONN)
	{
		$this->pearDB = $DB_CONN;
		$this->errorMsg ='';
	}
	
	function __destruct()
	{
		//$this->pearDB->disconnect();
	}
	
	public function ValidateAJAX ( $inputValue, $fieldID )
    {
		switch( $fieldID )
		{
			case	'begin_course_name':
				return $this->ValidateBeginCourseName($inputValue);
                break;	
            case    'director_name':
                return $this->Validatedirector_name($inputValue);
                break;
			case 	'inner_course_cd':
				return $this->Validateinner_course_cd($inputValue);
			  	break;
			case 	'quantity':
				return $this->Validatequantity($inputValue);
			  	break;
			case	'class_city':
			  	return $this->Validateclass_city($inputValue);
			  	break;
			case	'class_place':
                return $this->Validateclass_place($inputValue);
                break;
			case	'certify':
                return $this->ValidateCertify($inputValue);
				break;
			case	'director_email':
                return $this->ValidateDirector_Email($inputValue);
				break;
			case	'criteria_total':
                return $this->ValidateCriteria_Total($inputValue);
                break;
			case	'course_property':
                return $this->ValidateCourse_Property($inputValue);
                break;
			case	'article_number':
                return $this->ValidateArticle_Number($inputValue);
                break;
			case	'career_stage':
                return $this->ValidateCareer_Stage($inputValue);
                break;
            case	'course_duration':
                return $this->ValidateCourse_Duration($inputValue);
                break;
            case	'begin_unit_cd':
                return $this->ValidateBegin_Unit_Cd($inputValue);
                break;
            case	'course_stage_option1':
                return $this->ValidateCourse_Stage_update_session($inputValue, $_SESSION['values']['course_stage_option2'],$_SESSION['values']['course_stage_option3'],$_SESSION['values']['course_stage_option4']);
                break;
            case	'course_stage_option2':
                return $this->ValidateCourse_Stage_update_session($_SESSION['values']['course_stage_option1'],$inputValue,$_SESSION['values']['course_stage_option3'],$_SESSION['values']['course_stage_option4']);
                break;
            case	'course_stage_option3':
                return $this->ValidateCourse_Stage_update_session($_SESSION['values']['course_stage_option1'],$_SESSION['values']['course_stage_option2'],$inputValue,$_SESSION['values']['course_stage_option4']);
                break;
            case	'course_stage_option4':
                return $this->ValidateCourse_Stage_update_session($_SESSION['values']['course_stage_option1'],$_SESSION['values']['course_stage_option2'],$_SESSION['values']['course_stage_option3'],$inputValue);
                break;
            case    'criteria_content_hour_1':
                return $this->ValidateCriteria_content_hour_1($inputValue);
                break;
            case    'criteria_content_hour_2':
                return $this->ValidateCriteria_content_hour_2($inputValue);
				break ;
            case    'teacher':
                return $this->Validateclass_teacherAccount($inputValue);
                break;
        }
	}	

	public function ValidatePHP($attribute)
    {
		global $COURSE_FILE_PATH,$MEDIA_FILE_PATH; //sad!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!		
		$errorsExist = 0;

        if(isset($_SESSION['errors']))
            unset($_SESSION['errors']);

        $_SESSION['errors']['course_property']      = 'hidden';
        $_SESSION['errors']['begin_course_name']    = 'hidden';
        $_SESSION['errors']['article_number']       = 'hidden';
        $_SESSION['errors']['course_stage']         = 'hidden';
        $_SESSION['errors']['career_stage']         = 'hidden';
        $_SESSION['errors']['take_hour']            = 'hidden';
        $_SESSION['errors']['certify']              = 'hidden';
        $_SESSION['errors']['course_unit']          = 'hidden';
        $_SESSION['errors']['begin_unit_cd']        = 'hidden';
        $_SESSION['errors']['course_duration']      = 'hidden';
        $_SESSION['errors']['criteria_content_hour'] = 'hidden';
        $_SESSION['errors']['criteria_total']       = 'hidden';
        $_SESSION['errors']['director_tel']         = 'hidden';
        $_SESSION['errors']['director_name']        = 'hidden';
        $_SESSION['errors']['director_email']       = 'hidden';
        $_SESSION['errors']['criteria_content_hour_1'] = 'hidden';
        $_SESSION['errors']['criteria_content_hour_2'] = 'hidden';
        $_SESSION['errors']['teacher'] = 'hidden';

		
        if($_POST['attribute'] == 0 || $_POST['attribute'] == 1)
        {
              /* 驗証課程性質 */
			if( !$this->ValidateCourse_Property($_POST['course_property'])) {
				$_SESSION['errors']['course_property'] = 'error';
				$errorsExist = 1;
			}
            //驗證name
            if( !$this->ValidateBeginCourseName($_POST['begin_course_name'])) {
                $_SESSION['errors']['begin_course_name'] = 'error';
                $errorsExist = 1;
            }
            /* 驗証依據文號，且需要傳送高師大的時候，才需要做判斷 */
            if($_POST['deliver'] == 1)
            {
                if( !$this->ValidateArticle_Number($_POST['article_number']))
                {
                    $_SESSION['errors']['article_number'] = 'error';
                    $errorsExist = 1;
                }
            }
             /* 驗証課程類別 */
            if( !$this->ValidateCourse_Unit($_POST['course_unit']))
            {
                $_SESSION['errors']['course_unit'] = 'error';
                $errorsExist = 1;
            }
            /* 驗証課程子類別 課程類別如有作出選擇，再繼續驗証即可 */
            if($_POST['course_unit'] != -1)
            {
                if( !$this->ValidateBegin_Unit_Cd($_POST['begin_unit_cd']))
                {
                    $_SESSION['errors']['begin_unit_cd'] = 'error';
                    $errorsExist = 1;
                }
            }
            /* 驗証評量標準總分 不能超過100 */
            if( !$this->ValidateCriteria_Total($_POST['criteria_total']))
            {
                $_SESSION['errors']['criteria_total'] = 'error';
                $errorsExist = 1;
            }
             /* 驗証承辦人姓名 */
            if( !$this->Validatedirector_name($_POST['director_name']))
            {
                $_SESSION['errors']['director_name'] = 'error';
                $errorsExist = 1;
            }
            /* 驗証承辦人tel 電話至少要有區碼加上後面七碼或是八碼才行 */
            if( !$this->ValidateDirector_Tel($_POST['director_tel_area'],$_POST['director_tel_left']))
            {
                $_SESSION['errors']['director_tel'] = 'error';
                $errorsExist = 1;
            }
            /* 驗証承辦人email */
            if( !$this->ValidateDirector_Email($_POST['director_email']))
            {
                $_SESSION['errors']['director_email'] = 'error';
                $errorsExist = 1;
            }
            /* 驗証課程階段別，且需要傳送高師大的時候，才需要做判斷 */
            if($_POST['deliver'] == 1)
            {
                if(!$this->ValidateCourse_Stage($_POST['course_stage_option1'],$_POST['course_stage_option2'],$_POST['course_stage_option3'],$_POST['course_stage_option4']))
                {
                    //每個欄位都要填到才可以
                    $_SESSION['errors']['course_stage'] = 'error';
                    $errorsExist = 1;
                }
            }
            /* 驗証職業階段別，且需要傳送高師大的時候，才需要做判斷 */
            if($_POST['deliver'] == 1)
            {
                if( !$this->ValidateCareer_Stage($_POST['career_stage']))
                {
                    $_SESSION['errors']['career_stage'] = 'error';
                    $errorsExist = 1;
                }
            }
        }
		
		//課程屬性 : 0 - 自學式 , 1 - 教導式
        if($_POST['attribute'] == 0){
            /* 驗証認証時數 */
            if( !$this->ValidateCertify($_POST['certify']))
            {
                $_SESSION['errors']['certify'] = 'error';
                $errorsExist = 1;
            }
            /* 驗証修課期限 */
            if( !$this->ValidateCourse_Duration($_POST['course_duration']))
            {
                $_SESSION['errors']['course_duration'] = 'error';
                $errorsExist = 1;
            }
             
            /* 驗証教材閱時數 */
            /*
            if( !$this->ValidateCriteria_Content_Hour($_POST['criteria_content_hour_1'],$_POST['criteria_content_hour_2']))
            {
                $_SESSION['errors']['criteria_content_hour'] = 'error';
                $errorsExist = 1;
            }
             */
            /* 驗証教材閱讀時數 - 時*/
            if(!$this->ValidateCriteria_content_hour_1($_POST['criteria_content_hour_1']))
            {
                $_SESSION['errors']['criteria_content_hour_1'] = 'error';
                $errorsExist = 1;
            }
            /* 驗証教材閱讀時數 - 分*/
            if(!$this->ValidateCriteria_content_hour_2($_POST['criteria_content_hour_2']))
            {
                $_SESSION['errors']['criteria_content_hour_2'] = 'error';
                $errorsExist = 1;
            }

			
        }

		
		if( !$this->Validateclass_teacherAccount($_POST['teacher']) ) {
		
			$_SESSION['errors']['teacher'] = 'error'  ; 
			$errorsExist = 1 ; 
		}
		
		
        // 如果是自學式指開放課程開始、結束、公開日期
        // add by Samuel @ 2009/07/25

	  	$d_course_begin = $_POST['d_course_begin'];
		$d_course_end = $_POST['d_course_end'];
		$d_public_day = $_POST['d_public_day'];
		
        if( $attribute == 0){ // 自學式
        
            //把自學式的課程開始期間訂為開課的時間：
            //因為要一直可以選課 所以課程結束時間 設定成100年後
            $today = date("Y-m-d");
            $timestamp = time(); //到目前為止的秒數
            $class_end = date("Y-m-d",$timestamp+15*365*86400); // timestamp + 20年的時間 (使用100年的話會有奇怪的事情發生)
        
			$d_select_begin = $today;
			$d_select_end = $class_end;
			
			//自動審查要 = 1
			$auto_admission = 1 ;
		}
		else {

			$d_select_begin = $_POST['d_select_begin'];
			$d_select_end = $_POST['d_select_end'];
			$auto_admission = $_POST['auto_admission'];
		}
        //驗證通過
		if ( $errorsExist == 0){
		  	//先rand  出一筆亂數
			$validateKey = $this->randString(60);											
			//寫入begin_course course_cd, 並且在node 塞入 validateKey		
			
			//add by Samuel @ 2009/08/02
			//計算認証時數 (criteria_content_hour) 由使用者輸入的數字 轉換成時間格式

			$hour_ = $_POST['criteria_content_hour_1'];
            $minute_ = $_POST['criteria_content_hour_2'];
            /*處理minute使之符合時間的格式*/
            if($minute_ == 0)
                $criteria_content_hour = $hour_.":"."00:00";
            elseif($minute > 0 && $minute_ < 10)
                $criteria_content_hour = $hour_.":0".$minute_.":00";
            else
			    $criteria_content_hour = $hour_.":".$minute_.":00";
    
            // modify by Samuel @ 2009/11/22
            // 傳送高師大的電話欄位有一定格式，必須要重新修改。
            $director_tel = $_POST['director_tel_area']."-".$_POST['director_tel_left'];
            if($_POST['director_tel_ext'] != NULL)
                $director_tel .= "#".$_POST['director_tel_ext'];
            // end of modification @ 2009/11/22

			//add by Samuel @ 2009/08/16
			$inner_course_cd = $this->get_inner_course($_POST['course_property']);

            // add by Samuel @ 2009/10/30
            // 修改傳送course_stage 要改成複選。
            // 因為要改成複選，所以利用每一個course_stage_option來完成。並且call function去得到一個字串，寫回資料庫。
            if($_POST['course_stage_option1'] != NULL)
                $course_stage_array1 = 1;
            else
                $course_stage_array1 = 0;
            if($_POST['course_stage_option2'] != NULL)
                $course_stage_array2 = 1;
            else
                $course_stage_array2 = 0;
            if($_POST['course_stage_option3'] != NULL)
                $course_stage_array3 = 1;
            else
                $course_stage_array3 = 0;
            if($_POST['course_stage_option4'] != NULL)
                $course_stage_array4 = 1;
            else
                $course_stage_array4 = 0;

            $course_stage = $course_stage_array1.$course_stage_array2.$course_stage_array3.$course_stage_array4;
            //end modify @ 2009/10/30
            //add by aeil
            foreach($_POST as $k=>$v)
            {
              $_POST[$k] = required_param($k,PARAM_TEXT);
            }
            //end

			$sql  = "INSERT INTO 
			  begin_course 
			  ( 
			  inner_course_cd, 
			  begin_unit_cd, 
			  begin_course_name, 
			  d_course_begin, 
			  d_course_end, 
			  d_public_day, 
			  d_select_begin, 
			  d_select_end, 
			  course_year, 
			  course_session, 
			  note,
			  take_hour,
			  certify,
			  is_preview,
			  quantity,
			  charge,
			  charge_discount,
			  class_city,
			  class_place,
			  criteria_total,
			  criteria_score,
			  criteria_score_pstg,
			  criteria_tea_score,
			  criteria_tea_score_pstg,
			  criteria_content_hour,
			  criteria_finish_survey,
			  attribute,
			  director_name,
			  director_tel,
			  director_email,
			  director_fax,
			  auto_admission,
			  course_property,
			  course_duration,
			  course_stage,
			  career_stage,
			  deliver,
              article_number,
              guest_allowed,
			  applycourse_no
			)";
			$sql .= "VALUES ( 
			  '{$inner_course_cd}',
			  '".$_POST['begin_unit_cd']."',
			  '".$_POST['begin_course_name']."',
			  '{$d_course_begin}',
			  '{$d_course_end}',
			  '{$d_public_day}',
			  '{$d_select_begin}',
			  '{$d_select_end}',
			  '".$_POST['course_year']."',
			  '".$_POST['course_session']."',
			  '$validateKey',
			  '".$_POST['take_hour']."',
			  '".round($_POST['certify'],1)."',
			  '".$_POST['is_preview']."',
			  '".$_POST['quantity']."',
			  '".$_POST['charge']."',
			  '".$_POST['charge_discount']."',
			  '".$_POST['class_city']."',
			  '".$_POST['class_place']."',
			  '".$_POST['criteria_total']."',
			  '".$_POST['criteria_score']."',
			  '".$_POST['criteria_score_pstg']."',
			  '".$_POST['criteria_tea_score']."',
			  '".$_POST['criteria_tea_score_pstg']."',
			  '$criteria_content_hour',
			  '".$_POST['criteria_finish_survey']."',
			  '$attribute',
			  '".$_POST['director_name']."',
			  '{$director_tel}',
			  '".$_POST['director_email']."',
			  '".$_POST['director_fax']."',
			  '{$auto_admission}',
			  '".$_POST['course_property']."',
			  '".$_POST['course_duration']."',
			  '{$course_stage}',
			  '".$_POST['career_stage']."',
			  '".$_POST['deliver']."',
              '".$_POST['article_number']."',
              '".$_POST['guest_allowed']."',
			  {$_SESSION['no']}
			  )";
			$res = $this->pearDB->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());	
			//查出剛剛insert的 begin_course_cd
			$sql = "SELECT begin_course_cd FROM begin_course WHERE begin_course_name='".$_POST['begin_course_name']."' and note='$validateKey' ORDER BY begin_course_cd DESC";
			$begin_course_cd = $this->pearDB->getOne($sql);			
			if (PEAR::isError($res))	die($res->getMessage());
			
			//輔導團隊新增課程，需指定doc
			if($_SESSION['category'] == 3) {
				$sql = " update begin_course set applycourse_doc={$_POST['doc']} where begin_course_cd='$begin_course_cd' ";
				db_query($sql); 
			}
			
			//清除剛剛塞入的validateKey
			$sql = "UPDATE begin_course SET note=NOW() , begin_coursestate='0', course_type='0' WHERE  begin_course_cd='$begin_course_cd'";
			$res = $this->pearDB->query($sql);
			
			if (PEAR::isError($res))	die($res->getMessage());
			//在 /home/CourseFile 與 /home/StreamingFile 裡面建立資料夾 0775
			$courseDir = $COURSE_FILE_PATH . $begin_course_cd;
			$streamingDir = $MEDIA_FILE_PATH . $begin_course_cd;
			//$testbankDir = "/home/WWW/DataFile/"; 
			
//			
//echo $courseDir ; 
//echo $streamingDir ;
			/*訪客入侵修課*/
			$guest_pid = db_getOne("select personal_id from register_basic where login_id='guest'");
			if($attribute == '0')
			{
				$take_course = db_getOne("select begin_course_cd from take_course where begin_course_cd = $begin_course_cd and personal_id = $guest_pid");
				if($guest_pid != NULL && $take_course == NULL)
  					db_query("insert into take_course (begin_course_cd, personal_id, allow_course, status_student) values ($begin_course_cd, $guest_pid, '1', '0')");
			}
			else
			  	db_query("delete from take_course where begin_course_cd = $begin_course_cd and personal_id = $guest_pid");

			$this->createDIR($courseDir);
			$this->createDIR($streamingDir);		

			//begin 設定修課教師 - ( 先依登入帳號找出教師 id , 再指定修課教師 ) //能到這邊一定是有教師帳號
			$sql_get_teacher_cd = " SELECT personal_id FROM register_basic WHERE login_id ='{$_POST['teacher']}'"; 
			well_print($sql_get_teacher_cd) ;
			$teacher_cd = db_getOne($sql_get_teacher_cd); 
						
			$set_course_teacher = " INSERT INTO teach_begin_course VALUES ($teacher_cd, $begin_course_cd, 1); "; 
			db_query( $set_course_teacher ); 
			//end 設定修課教師
			

			$_SESSION['values'] = array(); 
			$_SESSION['errors'] = array(); 
			$_SESSION['is_load'] = null ;
			unset($_SESSION['values']);
			unset($_SESSION['errors']);
		    unset($_SESSION['is_load']);	
			//echo "begin course = ".$begin_course_cd."<br/>";			
			//return "add_teacher_to_course.php?begin_course_cd=" . $begin_course_cd;			
			return "begin_course_list.php";			
		}		
		//驗證有錯誤
        else{
            unset($_SESSION['values']);
			foreach( $_POST as $key => $value){
				$_SESSION['values'][$key] = $_POST[$key];
            }
            $_SESSION['is_load'] = 1 ; 
            return 'begin_course.php?s=true';
		}		
	}
		
	private function ValidateCourse_Property($value)
	{
		$value = trim($value);
		if($value != -1){
			return 1; //valid
		}	
		else{
			$this->setErrorMsg("課程性質尚未選擇");
			return 0; //not valid	
		}	
	}
	
	private function ValidateBeginCourseName($value)
	{
		$value = trim($value);
		if( !empty($value)) {
			return 1; //valid
		}	
		else{
			$this->setErrorMsg("課程名稱尚未填入");
			return 0; //not valid	
		}	
	}

    private function Validatedirector_name($value)
    {
        $value=trim($value);
        if($value){
            return 1;
        }
        else
        {
            $this->setErrorMsg("承辦人姓名尚未填入");
            return 0 ;
        }
    }
    
    private function ValidateArticle_Number($value)
    {
        $value=trim($value);
        if($value){
            return 1;
        }
        else
        {
            $this->setErrorMsg("依據文號尚未填入或是格式錯誤。");
            return 0 ;
        }
    }

    private function ValidateCourse_Stage($value1, $value1, $value3, $value4)
    {
        $value=trim($value);
        if(($value1!= NULL) || ($value2!= NULL) || ($value3 != NULL)  || ($value4 != NULL)){
            return 1;
        }
        else
        {
            $this->setErrorMsg("請至少選擇一個選項");
            return 0 ;
        }
    }
    
    private function ValidateCareer_Stage($value)
    {
        $value=trim($value);
        if($value != -1){
            return 1;
        }
        else
        {
            $this->setErrorMsg("課程研習對象身分尚未選擇");
            return 0 ;
        }
    }

    private function ValidateCertify($value)
    {
        $value=trim($value);
        if(strlen($value)>0){
            //判斷是否為數字
            $value = round($value,1);
            if( ($value*10 %5) != 0 )
            {
                $this->setErrorMsg("認證時數必須為0.5的倍數");
                return 0;
            } 
            if($value < 0)
            {   
                $this->setErrorMsg("認證時數空白或是格式錯誤。");
                return 0;
            }
            else
                return 1;
        }
        else
        {
            $this->setErrorMsg("認證時數空白或是格式錯誤。");
            return 0 ;
        }
    }

    private function ValidateCourse_Unit($value)
    {
        $value=trim($value);
        if($value != -1){
            return 1;
        }
        else
        {
            $this->setErrorMsg("課程類別尚未選擇。");
            return 0 ;
        }
    }

    private function ValidateBegin_Unit_Cd($value)
    {
        $value=trim($value);
        if($value != -1){
            return 1;
        }
        else
        {
            $this->setErrorMsg("課程子類別尚未選擇。");
            return 0 ;
        }
    }

    /* 把四個值丟進來判斷是否有值 如果有值的話 再更改session的值就行了 */ 
    private function ValidateCourse_Stage_update_session($value1, $value2, $value3, $value4)
    {
        /* 把四個值都存到session裡面 不論勾選哪一個值都可以正確的顯示 */
        if($value1 != NULL)
            $_SESSION['values']['course_stage_option1'] = 10 ;
        else
            unset($_SESSION['values']['course_stage_option1']);
        
        if($value2 != NULL)
            $_SESSION['values']['course_stage_option2'] = 20 ;
        else
            unset($_SESSION['values']['course_stage_option2']);
        
        if($value3 != NULL)
            $_SESSION['values']['course_stage_option1'] = 30 ;
        else
            unset($_SESSION['values']['course_stage_option3']);
        
        if($value4 != NULL)
            $_SESSION['values']['course_stage_option1'] = 40 ;
        else
            unset($_SESSION['values']['course_stage_option4']);

        if(isset($_SESSION['values']['course_stage_option1']) || isset($_SESSION['values']['course_stage_option2'])|| isset($_SESSION['values']['course_stage_option3'])||isset($_SESSION['values']['course_stage_option4']))
            return 1;
        else
        {
            $this->setErrorMsg("課程階段屬性欄位不可為空白");
            return 0;
        }
    }

    private function ValidateCourse_Duration($value)
    {
        $value=trim($value);
        if($value != 0){
            return 1;
        }
        else
        {
            $this->setErrorMsg("修課期限尚未選擇。");
            return 0 ;
        }
    }
    
    // return 0 記得設定錯誤訊息= =
    private function ValidateCriteria_Total($value)     
    {
        $value=trim($value);
        if(!is_null($value))
        {
            if(is_numeric($value))
            {
                if($value>100)
                {
                    $this->setErrorMsg("評量標準(總分)尚未填寫或是格式錯誤");
                    return 0 ;
                }
                elseif($value<0)
                {
                    $this->setErrorMsg("評量標準(總分)尚未填寫或是格式錯誤");
                    return 0 ;
                }
                else
                    return 1;
            }
            else
            {
                $this->setErrorMsg("評量標準(總分)尚未填寫或是格式錯誤");
                return 0;
            }
        }
        else
        {
            $this->setErrorMsg("評量標準(總分)尚未填寫或是格式錯誤");
            return 0 ;
        }
    }

    //判斷使用者輸入的是不是數字
    private function ValidateCriteria_content_hour_1($criteria_content_hour_1)
    {
        $value = trim($criteria_content_hour_1);
        if(is_numeric($value)){
            if($value == 0)
                return 1;
            elseif($value > 0)
                return 1;
            else{
                $this->setErrorMsg("時間格式錯誤");
                return 0;
            }
        }
        else
        {
            $this->setErrorMsg("時間格式錯誤。");
            return 0 ;
        }
    }
    //同1
    private function ValidateCriteria_content_hour_2($criteria_content_hour_2)
    {
        $value = trim($criteria_content_hour_2);
        if(is_numeric($value)){
            if($value == 0)
                return 1;
            elseif($value > 0 && $value < 60)
                return 1;
            else
            {
                $this->setErrorMsg("時間格式錯誤");
                return 0;
            }
        }
        else
        {
            $this->setErrorMsg("時間格式錯誤");
            return 0 ;
        }
    }
    
    private function ValidateCriteria_Content_Hour($value1,$value2)
    {
        $value=trim($value);
        if($value1 != -1 && $value2 != -1){
            return 1;
        }
        else
        {
            $this->setErrorMsg("");
            return 0 ;
        }
    }
    
    private function ValidateDirector_Tel($value1,$value2)
    {
        $value=trim($value);
        if($value1 && $value2){
            if(is_numeric($value1) && is_numeric($value2))
                return 1;
            else 
                return 0;
        }
        else
        {
            $this->setErrorMsg("承辦人電話尚未填入或是格式錯誤。");
            return 0 ;
        }
    }
    

    private function ValidateDirector_Email($value)
    {
        $value=trim($value);
        if(eregi("^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}$",$value))
            return 1;
        else
        {
            $this->setErrorMsg("承辦人電子信箱尚未填入或是格式錯誤。");
            return 0 ;
        }
    }

	private function Validateinner_course_cd($value)
	{
		$value = trim($value);
		if($value){
			return 1; //valid
		}	
		else{
			$this->setErrorMsg("課程編號尚未填入");
			return 0; //not valid	
		}	
	}

	private function Validatequantity($value)
	{
		$value = trim($value);
		if($value){
			return 1; //valid
		}	
		else{
			$this->setErrorMsg("修課名額尚未填入");
			return 0; //not valid	
		}	
	}

	private function Validateclass_city($value)
	{
		$value = trim($value);
		if($value){
			return 1; //valid
		}	
		else{
			$this->setErrorMsg("上課縣市尚未填入");
			return 0; //not valid	
		}	
	}
	
	//驗證教師帳號是否正確
	private function Validateclass_teacherAccount($value) 
	{
		$check_account_exist = " SELECT count(*) FROM register_basic A, personal_basic B WHERE login_id='$value' AND A.personal_id=B.personal_id "; 
		$num_record = db_getOne($check_account_exist ) ; 
		
		if( $num_record == 1)  {
			$this->setErrorMsg("此教師ok!"); 
			return 1;
		}else {
			$this->setErrorMsg("此教師帳號不存在") ; 
			return 0 ;
		}
	
	
	}
	
	
	private function Validateclass_place($value)
	{
		$value = trim($value);
		if($value){
			return 1; //valid
		}	
		else{
			$this->setErrorMsg("上課地點尚未填入");
			return 0; //not valid	
		}	
	}

	private function ValidateSelectDate($input)
	{
	  	// 判斷選課開始結束是否正確
		$b = split("-", $input['d_select_begin']);
		$e = split("-", $input['d_select_end']);
		//if($b[0] < $e[0] || $b[1] < $e[1] || $b[2] < $e[2])
		//	return 1;
        if($b[0]<$e[0]) // 選課結束時間比選課開始時間的年份較晚 當然okay
            return 1;
		else if(($b[0] == $e[0]) &&($b[1]<$e[1])) // 如果年份相同，月份較小者
            return 1 ;
		else if(($b[0]==$e[0]) && ($b[1]==$e[1]) && ($b[2]<$e[2]))//年月相同，但是日期較小
            return 1 ;
        else
            return 0;		
	}
			
			
	private function ValidateCourseDate($input)
	{
	  	// 判斷選課開始結束是否正確
		$b = split("-", $input['d_course_begin']);
		$e = split("-", $input['d_course_end']);
		
		if($b[0]<$e[0]) // 選課結束時間比選課開始時間的年份較晚 當然okay
		  return 1;
		else if(($b[0] == $e[0]) &&($b[1]<$e[1])) // 如果年份相同，月份較小者
		  return 1 ;
		else if(($b[0]==$e[0]) && ($b[1]==$e[1]) && ($b[2]<$e[2]))//年月相同，但是日期較小
		  return 1 ;
		else
		  return 0;		
	}

	private function setErrorMsg($msg)
	{
		$this->errorMsg = $msg;
	}
	
	public function getErrorMsg()
	{
		return $this->errorMsg;
	}

	private function randString($len, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789')
	{
    	$string = '';
    	for ($i = 0; $i < $len; $i++)
    	{
        	$pos = rand(0, strlen($chars)-1);
     		$string .= $chars{$pos};
    	}
	return $string;
	}
	
	private function createDIR($path){

		if( $path[strlen($path)-1] == '/');
		else
			$path = $path.'/';
					
		$old_umask = umask(0);
		mkdir($path, 0775);
		umask($old_umask);
	}
    

	private function get_inner_course($property_number){
	  
	  	// property 傳入之後 是由00 ~ 05 開始
		// 產生流程為 先找出是哪一種屬性的課程
	  	// 再把該屬性的課程的最大值的課程數字找出
	  	// +1 之後 便是新的數字
			  
	  	$sql = "SELECT max(course_number) as course_maxi 
	    	FROM generate_inner_course_cd 
		WHERE property_type ={$property_number}";

		if( db_getOne($sql) == NULL) //表示該屬性還沒有開過課程
		  	$max_course_number = 1 ;
		else{
			$max_course_number = db_getOne($sql); // 下一筆資料的課程號碼
			$max_course_number ++ ;
		}

		//判斷開設課程之後的課程編號是多少

		$property=$property_number + 1 ; 
		if($max_course_number < 10)
			$inner_course_cd_1 = "010".$property."000".$max_course_number;
		elseif($max_course_number >= 10 && $max_course_number < 100) // 10~99
		  	$inner_course_cd_1 = "010".$property."00".$max_course_number;
		elseif($max_course_number >= 100 && $max_course_number < 1000) // 100~999
		  	$inner_course_cd_1 = "010".$property."0".$max_course_number;
		else // 大於1000 有四個數字
			$inner_course_cd_1 = "010".$property."".$max_course_number;
			
		if($max_course_number == 1) //表示都還沒有開過課程，把這筆新的資料 再寫回這個資料表
		{
			$sql = "INSERT INTO generate_inner_course_cd 
			  (
			    course_type,
			    property_type,
			    course_number
			  ) VALUES
			  (
			    '1',
			    '{$property_number}',
			    '{$max_course_number}'
			    )";
			db_query($sql);
		}
		else // 即表示那個屬性 原本已經就有課程了 直接更新成最大值就好了
		{
		  	$sql = "UPDATE generate_inner_course_cd 
		    	SET course_number ='{$max_course_number}' 
			WHERE property_type = {$property_number}";
			db_query($sql);
		}
		return $inner_course_cd_1 ; 
	}
}
?>

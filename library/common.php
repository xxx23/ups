<?php
    /** 
     *
     * @file library/common.php
     *
     * @author unknown
	 * @date unknown
     */

    /**
     * @brief 印出資料並加上html換行
     * 
     * @param data 要印出的資料
     */
	function echoData($data)
	{
		echo $data . "<br>";
	}

    /**
     * @brief 印出資料並保留格式
     * 
     * @param data 要印出的資料
     */
	function well_print($input){
		echo "<pre>";
		print_r($input);
		echo "</pre>";
	}

    /**
     * @brief 拿到tpl風格主題的網頁路徑
     * 例如 "/themes/IE2"
     */
	function createTPLPath()
	{
		global $THEME_PATH , $WEBROOT;

		//require_once('../session.php');

		return $WEBROOT . $THEME_PATH . "IE2";
	}

    /**
     * $brief 取得template檔案
     * 不曉得實際用途
     *
     * @param tpl smarty的變數
     * @param location tpl檔的路徑
     *
     * @return 我也不知道(待補充)
     */
	function fetchTemplate($tpl, $location)
	{
		global $HOME_PATH, $THEME_PATH;

		$tpl->assign("tpl_path", createTPLPath() );
		//目前強制使用IE2...
		return $tpl->fetch($HOME_PATH . $THEME_PATH . "IE2" . $location);
	}
    
    /**
     * $brief 指定smarty要用的template檔(常用)
     *
     * @param tpl smarty的變數
     * @param location tpl檔的路徑
     *
     */
	function assignTemplate($tpl, $location){
		global $HOME_PATH, $THEME_PATH, $WEBROOT;
		$tpl->assign("tpl_path", createTPLPath() );
		$tpl->assign("webroot", $WEBROOT);
		$tpl->display($HOME_PATH . $THEME_PATH . "IE2" . $location);
	}
	/*
	 * 這裡放一些可以拿到一些課程 info 的 API
	 * by rja
	 */

    /** 
     * @author rja
	 * 回傳課程名稱
     * 有給 begin_course_cd 就查該門課，沒給就自己拿 session 裡的 begin_course_cd
     * 
     * @param begin_cd 開課編號
     *
     * @return 課程名稱
	 */
	function db_getCourseName($begin_cd= null){
		if (empty($begin_cd)){
			$begin_cd = $_SESSION['begin_course_cd'] ;
		}
	    $find_course_name_sql = "select begin_course_name from begin_course where begin_course_cd = $begin_cd; ";
		$courseName = db_getOne($find_course_name_sql);
		return $courseName;
	}

    /** 
     * @author rja
	 * 回傳使用者姓名 personal_name
     * 有給 personal_id 就查該人姓名，沒給就自己拿 session 裡的 personal_id
     *
     * @param personal_id 個人編號
     *
     * @return 使用者名稱
	 */
	function db_getPersonalName($personal_id= null){
		if (empty($personal_id)){
			$personal_id = $_SESSION['personal_id'] ;
		}
	    $Q1 = "select personal_name from personal_basic where personal_id = $personal_id; ";
		$personalName = db_getOne($Q1);
		return $personalName;
	}
    /* 
     * @author rja
	 * 回傳 personal_basic 裡某欄位
     * 有給 personal_id 就查該人姓名，沒給就自己拿 session 裡的 personal_id
     *
     * @param personal_id 個人編號
     * @param column 要拿的personal_basic 欄位
     *
     * @return 欄位資料
	 */
	function db_getPersonalBasic($personal_id = null, $column= null){
		if (empty($column)) print 'db_getPersonalBasic: no column name ';
		if (empty($personal_id)){
			$personal_id = $_SESSION['personal_id'] ;
		}
		
	    $Q1 = "select $column from personal_basic where personal_id = $personal_id; ";
		$thisColumn = db_getOne($Q1);
		return $thisColumn;
	}

    /**
     * @author rja
     * 回傳 該課程裡的老師及助教資料
     *
     * @param begin_cd 開課編號
     *
     * @return 該課程裡的老師及助教資料
     *
	 */
	function db_getTeacherAndTAList($begin_cd=null){
		if (empty($begin_cd)){
			$begin_cd = $_SESSION['begin_course_cd'] ;
		}

		$list_tea_And_TA = "select p.personal_id, p.personal_name,p.photo, p.email, p.tel, r.login_id, r.role_cd 
			from personal_basic p, register_basic  r 
			where p.personal_id=r.personal_id
			and r.personal_id in 
			( select teacher_cd 
			from teach_begin_course 
			where begin_course_cd={$begin_cd}) 
			";

		
		$result = db_getAll($list_tea_And_TA);
		return $result;
	}

    /** 
     * @author rja
     * 回傳 該課程裡全部修課學生的資料
     *
     * @param begin_cd 開課編號
     * 
     * @return 該課程裡全部修課學生的資料
	 */
	function db_getAllStudentInfo($begin_cd = null){
		if (empty($begin_cd)){
			$begin_cd = $_SESSION['begin_course_cd'] ;
		}

		$Q1 = "SELECT * 
			FROM register_basic r, personal_basic p, take_course t 
			WHERE t.begin_course_cd='".$_SESSION[begin_course_cd]."' and  t.personal_id=r.personal_id  and 
			r.personal_id = p.personal_id and r.role_cd='3'";

		$result = db_getAll($Q1);
		return $result;
	}

    /**
     * @author lunsrot
     * @date 2007/02/10
     * @brief 平台主要用的query function
     * 像是insert, update, delete這些都可以用這個function，
     * select也可以，不過比較沒那麼好用。
     * 另外，如果語法錯誤的話，會發生錯誤而自動導向首頁。
     *
     * $param sql query語法
     *
     * @return query的結果
	 */
	function db_query($sql){
		global $DB_CONN;
		global $DB_DEBUG;
                global $WEBROOT;
		$r = $DB_CONN->query($sql);
        
        if(PEAR::isError($r))
        {
            if($DB_DEBUG)
                die($_SERVER['PHP_SELF'] . ': '.$r->getDebugInfo());
            else
                header("Location:".$WEBROOT."error.html");
        }
		return $r;
	}
        
    /**
     * @author lunsrot
     * @date 2007/11/29
     * @brief query拿一欄的資料
     * 通常用來拿count(*)的值，如果資料只有一筆且只取某個欄位的話也可以用
     * 
     * @param query語法
     *
     * @return 某個欄位的資料，拿了就可以直接用
	 */
    function db_getOne($sql){

		global $DB_CONN;
		global $DB_DEBUG;
                global $WEBROOT;
		$r = $DB_CONN->getOne($sql);
		if(PEAR::isError($r))
        {
            if($DB_DEBUG)
                die($_SERVER['PHP_SELF'] . ': '.$r->getDebugInfo());
            else
                header("Location:".$WEBROOT."error.html");
        }
        return $r;
	}

    /*
     * @author lunsrot
     * @date 2007/11/29
     * @brief query 拿一行的資料
     * 通常就真的是用來拿只會有一行的資料，像是用primary key取得的
     *
     * @param query語法
     *
     * @return 一行的資料，假如用row來接的話, 之後可以用row['欄位名稱']來拿到想要的欄位
	 */
	function db_getRow($sql){
	  	global $DB_CONN;
		global $DB_DEBUG;
                global $WEBROOT;
		$r = $DB_CONN->getRow($sql, DB_FETCHMODE_ASSOC);
		if(PEAR::isError($r))
        {
            if($DB_DEBUG)
                die($_SERVER['PHP_SELF'] . ': '.$r->getDebugInfo());
            else
                header("Location:".$WEBROOT."error.html");
        }
        return $r;
	}

    /**
     * @author rja
     * @date 2008/3/10
     * @brief query拿所有的資料
     *
     * @param query語法
     *
     * @return 二維陣列, 可用for迴圈加指定欄位來拿資料
	 */
	function db_getAll($sql){
		global $DB_CONN;
		global $DB_DEBUG;
                global $WEBROOT;
		$r=Array();
		$r = $DB_CONN->getAll($sql, null, DB_FETCHMODE_ASSOC) ;
		if(PEAR::isError($r))
        {
            if($DB_DEBUG)
                die($_SERVER['PHP_SELF'] . ': '.$r->getDebugInfo());
            else
                header("Location:".$WEBROOT."error.html");
        }
		return $r;
	}



    /*
     * @author rja
     * @date 2008/3/10
     * @brief 將二維陣列轉為一維陣列
     *
     * @param 二維陣列
     *
     * @return 一維陣列
	 */
	function flatArray ($arr)
	{
		$returnArray = Array();
		foreach( $arr as $key => $value ) {
			foreach( $value as $innerKey => $innerValue ) {
				$returnArray[] =  $innerValue ;
			}
		}
		return $returnArray;
	}


    /**
     * @author lunsrot
     * @date 2007/04/30
     * @brief 取得現在的時間
     * 
     * @return 年-月-日 時:分:秒
	 */
	function getCurTime(){
		$tmp = gettimeofday();
		$time = getdate($tmp['sec']);
		$date = $time['year']."-".$time['mon']."-".$time['mday']." ".$time['hours'].":".$time['minutes'].":".$time['seconds'];
		return $date;
	}

    /**
     * @author lunsrot
     * @date 2007/06/19
     * @brief 遞迴建立目錄
     * 非常重要的函式，處理了遞迴和umask權限問題
     * 如目錄要775權限，請盡量使用此函式
     *
     * @param path 路徑(結尾要不要/都可以)
     *
	 */
	function createPath($path){

		$old_mask = umask(0);
		if($path[ strlen($path) - 1 ] == '/')
			$path[ strlen($path) - 1 ] = "\0";
		$tmp = explode("/", $path);
		$target = "";
		for($i = 0 ; $i < count($tmp) ; $i++){
			$target .= $tmp[$i] . "/";
			if(!is_dir($target))
			  mkdir($target, 0775);
			 
		}
		umask($old_mask);
	}

    /*
     * @author lunsrot
     * @date 2007/09/06
     * @brief 取得老師編號
     * 從session取得老師編號，假如取得的不是數字就導向錯誤頁面
     *
     * @return 老師編號
	 */
	function getTeacherId(){
		global $DB_CONN;
		if($_SESSION['role_cd'] == 1)
			return $_SESSION['personal_id'];
		$id = $DB_CONN->getOne("select teacher_cd from `teach_aid` where if_aid_teacher_cd=$_SESSION[personal_id]");
		if(!is_numeric($id)){
			header("location:../identification_error.html");
			exit(0);
		}
		return $id;
	}


    /**
     * @author sad man
     * @date sad time
     * @brief 更新使用者的線上狀況
     * 從online_number這個table去取得資料，如果有的話就做更新
     *
     * @param status_now 現在使用者的狀態
	 */	
	function update_status ( $status_now ) 
	{
		global $USE_MONGODB, $USE_MYSQL, $db;
		// $status_now = addslashes( $status_now );
		//問卷
		if($USE_MYSQL)
		{
			$sql = "UPDATE online_number SET status='". $status_now  ."' WHERE online_cd='".$_SESSION['online_cd']."'";
			$res = db_query($sql);
		}
		else if($USE_MONGODB)
		{
			$online_number = $db->online_number;
			$online_number->update(array('_id' => new MongoId($_SESSION['online_cd'])), array('$set' => array('ss' => $status_now, 'idle' => new MongoDate())));
		}
		// $sql = "SELECT online_cd FROM online_number WHERE personal_id='".$_SESSION['personal_id']."' and host='".$_SESSION['personal_ip']."'";

		// $res = db_query($sql);
		// $count = $res->numRows();		
		// if($count != 0)
		// {
		// 	$row_online = $res->fetchRow(DB_FETCHMODE_ASSOC);
		// 	$sql = "UPDATE online_number SET status='". $status_now  ."' WHERE online_cd='".$row_online['online_cd']."'";
		// 	$res = db_query($sql);
		// }							
	}

    //function content by rja
    /*
     * @author rja
     * @brief 作業, 問卷, 點名同步
     * 不知道什麼時候會用到，待補完
     *
     * @param begin_course_cd 開課編號
     * @param personal_id 個人編號
     *
     * @return 
     */
	function sync_stu_course_data( $begin_course_cd , $personal_id )
	{
		//作業同步
		$homework_no =  db_getAll(" select homework_no from homework where begin_course_cd = $begin_course_cd ;");

		foreach ( $homework_no as $value){

			$sql = " insert ignore into handin_homework (begin_course_cd, homework_no, personal_id) 
				values ($begin_course_cd, {$value['homework_no']}, $personal_id ); ";
			db_query($sql);

			$number_id =  db_getOne(" select number_id from course_percentage where begin_course_cd = $begin_course_cd and  percentage_type= 2 and percentage_num  = {$value['homework_no']} ;");

			$sql2 = " insert ignore into course_concent_grade (begin_course_cd, number_id, percentage_type, percentage_num, student_id, concent_grade )
				values ($begin_course_cd,  $number_id , 2,  {$value['homework_no']}, $personal_id, 0 );";
			db_query($sql2);
		}
		//end of 作業同步



		//問卷同步
		$survey_no =  db_getAll("select survey_no from online_survey_setup where survey_target = $begin_course_cd ;");

		foreach ( $survey_no as $value){
			$sql = " insert ignore into survey_student (survey_no, personal_id)
				values ( {$value['survey_no']}, $personal_id );";
			db_query($sql);
		}
		//end of 問卷同步


		//點名同步 

		$roll_no =  db_getAll("select *  from roll_book  where begin_course_cd = $begin_course_cd group by roll_id;");


		//需要 roll_book_status_grade 裡，查各種出席狀態代表的分數，例如出席100分
		$roll_book_status_grade =  db_getAll("select * from roll_book_status_grade  where begin_course_cd = $begin_course_cd ;");
		//如果老師沒設出席狀態所代表的分數，就用預設值
		//依照 ../Roll_Call/newRollCallSave.php 的規定所訂
		if(empty($roll_book_status_grade)){
			$roll_book_status_grade[] = Array('status_id' => 0, 'status_grade' => 100 ); 
			$roll_book_status_grade[] = Array('status_id' => 1, 'status_grade' => 0 ); 
			$roll_book_status_grade[] = Array('status_id' => 2, 'status_grade' => 80 ); 
			$roll_book_status_grade[] = Array('status_id' => 3, 'status_grade' => 80 ); 
			$roll_book_status_grade[] = Array('status_id' => 4, 'status_grade' => 100 ); 
			$roll_book_status_grade[] = Array('status_id' => 5, 'status_grade' => 100 ); 
		}

		foreach ( $roll_no as $value){
			$sql = " insert ignore into roll_book (begin_course_cd, personal_id, roll_id, roll_date,state)
				values ($begin_course_cd, $personal_id, {$value['roll_id']},'{$value['roll_date']}', 5 );";
			db_query($sql);
			//print $sql . "\n";
			// 5 是代表其它類 (還沒決定預設值，0是出席，1是缺席)
			$this_state =  5 ;
			$this_concent_grade = $roll_book_status_grade["$this_state"]['status_grade'];

			$number_id =  db_getOne(" select number_id from course_percentage where begin_course_cd = $begin_course_cd and  percentage_type = 3 and percentage_num  = {$value['roll_id']} ;");


			$sql2 = " insert ignore into course_concent_grade (begin_course_cd, number_id, percentage_type, percentage_num, student_id, concent_grade )
				values ($begin_course_cd,  $number_id , 3,  {$value['roll_id']}, $personal_id, $this_concent_grade );";
			db_query($sql2);
			//print $sql2 . "\n";
		}

		//end of 點名同步 

	}	  

    /**
     * @author  Samuel
     * @date 2009/11/02 
     * @brief 取得課程階段碼(看不太懂)
     * 因為調整資料庫中begin_course的欄位 = course_stage
     * 所以要把資料還原成原本的資料 
     * 其中 一共有四個bit 第一個bit指的是高中(10)、第二個bit為高職(23)、第三個bit為國中(30)、第四個bit為國小(40)
     *
     * @param begin_course_cd 課程編號
     *
     * @return 課程階段碼
     */
    function course_stage_decode($begin_course_cd)
    {
        $sql = "SELECT course_stage FROM begin_course WHERE begin_course_cd={$begin_course_cd}";
        $course_stage_string = db_getOne($sql);

        $course_stage = array(); 
        if($course_stage_string[0] == 1)
            $course_stage[] = 10;

        if($course_stage_string[1] == 1)
            $course_stage[] = 20;

        if($course_stage_string[2] == 1)
            $course_stage[] = 30;

        if($course_stage_string[3] == 1)
            $course_stage[] = 40;

        return $course_stage;
    }
	
    /**
     * @author q110185
     * @date 2009/11/20
     * @brief 取得課程階段碼(看不太懂)
     * 因為高師大欄位的轉換需要
     * 所以要把資料還原成原本的資料 
     * 其中 一共有四個bit 第一個bit指的是高中(10)、第二個bit為高職(23)、第三個bit為國中(30)、第四個bit為國小(40)
     *
     * @param course_stage_string 課程階段字串
     *
     * @return 課程階段碼
     */
	 function course_stage_decode_str($course_stage_string='0000')
    {
        $course_stage = array(); 
        if($course_stage_string[0] == 1)
            $course_stage[] = 10;

        if($course_stage_string[1] == 1)
            $course_stage[] = 20;

        if($course_stage_string[2] == 1)
            $course_stage[] = 30;

        if($course_stage_string[3] == 1)
            $course_stage[] = 40;

        return $course_stage;
    }
    
    /*
     * @author carlcarl
     * @date 2011/09/24
     * @brief 取得個人編號
     *
     * @return 個人編號
	 */
    function getPersonalId($login_id)
    {
        $sql = "SELECT personal_id FROM register_basic WHERE login_id = {$login_id}";
        $pid = db_getOne($sql);
		return $pid;
    }

    /**
     * @author carlcarl
     * @date 2011/09/24
     * @brief 取得個人編號的第一層分類編號
     *
     * @param pid 個人編號
     *
     * @return 個人編號的第一層分類編號
     */
	 function getPersonalLevel($pid)
     {
         $pid = (int)$pid;
         $num = (int)($pid / 10000) + 1;
         return $num;
     }

    /**
     * @author carlcarl
     * @date 2011/09/24
     * @brief 取得個人檔案路徑
     * 輸入個人編號 取得個人檔案路徑
     *
     * @param pid 個人編號
     *
     * @return 個人檔案路徑
     */
	 function getPersonalPath($pid)
     {
         global $PERSONAL_PATH;
         $num = getPersonalLevel($pid);
         $path = $PERSONAL_PATH . $num . '/';
         if(!is_dir($path))
         {
             createPath($path);
         }

         $path = $path . $pid;
         if(!is_dir($path))
         {
             createPath($path);
         }

         return $path;
     }
     
    /**
     * @author carlcarl
     * @date 2011/11/14
     * @brief 取得個人檔案web路徑
     * 輸入個人編號 取得個人web檔案路徑
     *
     * @param pid 個人編號
     *
     * @return 個人檔案web路徑
     */
	 function getPersonalWebPath($pid)
     {
         global $PERSONAL_PATH, $WEBROOT;
         $num = getPersonalLevel($pid);
         $path = $PERSONAL_PATH . $num . '/';
         if(!is_dir($path))
         {
             createPath($path);
         }

         $path = $path . $pid;
         if(!is_dir($path))
         {
             createPath($path);
         }

         $webPath = $WEBROOT . 'Personal_File/' . $num . '/' . $pid . '/';
         return $webPath;
     }

    /**
     * @author carlcarl
     * @date 2011/12/14
     * @brief 記錄系統指令log
     * 記錄指令、本身的php, personal_id和時間
     *
     * @param cmd 下的系統指令
     * @param fileName 執行系統指令的檔名
     *
     */
     function system_log($cmd)
     {
         $log = '/tmp/ups_system.log';
         $handle = fopen($log, 'a');
         $date = date('Y-m-d H:i:s');
         $pid = (int)$_SESSION['personal_id'];
         $content = $date . ' ' . $_SERVER['PHP_SELF'] . ' ' . $pid . ' ' . $cmd . "\n";
         fwrite($handle, $content);
     }


?>

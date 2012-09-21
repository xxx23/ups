<?
//  以時間 作為判斷此使用者是否在線上的依據
//  每分鐘此php會reload一次, 此時會將超過一分半未回應的使用者消掉
//  檔案格式為   $user_id, date("U") ,$course_id
//  會使用到session中的$time.

	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
    require_once($RELEATED_PATH . "library/date.php");
	//開啟session
	session_start();	

	global $USE_MONGODB, $USE_MYSQL, $db;

	if(isset($_SESSION['begin_course_cd']))
		$begin_course_cd = $_SESSION['begin_course_cd'];
	
	//先查詢是否在 online_number
	if($USE_MYSQL)
	{
		$sql = "SELECT COUNT(*) FROM online_number WHERE online_cd='".$_SESSION['online_cd']."'";
		$isHave = db_getOne($sql);
	}
	else if($USE_MONGODB)
	{
		$online_number = $db->online_number;
		$isHave = $online_number->count(array('_id' => new MongoId($_SESSION['online_cd'])));
	}

	// 如果已經在裏面的話 就更新資料
	if($isHave)
	{
		if($USE_MYSQL)
		{
			$sql = "UPDATE online_number SET begin_course_cd='".$_SESSION['begin_course_cd']."', status='觀看公告', idle='" . date('U')."' WHERE online_cd='".$_SESSION['online_cd']."'";
			$res = db_query($sql);
		}
		else if($USE_MONGODB)
		{
			$online_number->update(array('_id' => new MongoId($_SESSION['online_cd'])), array('$set' => array('bcd' => intval($_SESSION['begin_course_cd']), 'idle' => new MongoDate, 'ss' => '觀看公告')));
		}
	}
	else
	{
		if($USE_MYSQL)
		{
			$sql = "INSERT INTO online_number (personal_id, host, time, idle, status, begin_course_cd) 
					VALUES ('".$_SESSION['personal_id']."','".$_SESSION['personal_ip']."','".date('U')."','".date('U')."','觀看公告','".$_SESSION['begin_course_cd']."')";
			//add by aeil
			if(!is_null($_SESSION['personal_id']) || !empty($_SESSION['personal_id']))
			{
				$res = db_query($sql);
			}
			$sql = "SELECT online_cd FROM online_number WHERE personal_id='".$_SESSION['personal_id']."' and host='".$_SESSION['personal_ip']."'";
			$online_cd = db_getOne($sql);
			$_SESSION['online_cd'] =	 $online_cd;			
		}
		else if($USE_MONGODB)
		{
			$mid = new MongoId();
			$online_number->insert(array('_id' => $mid, 'pid' => intval($_SESSION['personal_id']), 'h' => $_SESSION['personal_ip'], 't' => new MongoDate(), 'idle' => new MongoDate(), 'ss' => '觀看公告', 'bcd' => intval($_SESSION['begin_course_cd'])));
			$_SESSION['online_cd'] = $mid;
		}
	}	
	//刪除 idle過久的
	// 這邊query寫法感覺可以再改進 by carlcarl
    $refreshmin = 10; //
    $refreshsec = $refreshmin * 60;
	if($USE_MYSQL)
	{
		$sql = "DELETE from online_number WHERE idle < (" . date("U") . " - $refreshsec)";
		$res = db_query($sql);
	}
	else if($USE_MONGODB)
	{
		$d = new MongoDate();
		$d->sec -= $refreshsec;
		$online_number->remove(array('idle' => array('$lt' => $d)));
	}

//------------- display	---------------------
	//查出系統上的人數 與 姓名 狀態
	//查出這堂課的人數 與 姓名 狀態
	$system_num = 0;
	$course_num = 0;			
	$friend_num = 0;			

	if($USE_MYSQL)
	{
		$sql = "SELECT COUNT(*) FROM online_number";
		$system_num = db_getOne($sql);
	
		$sql = "SELECT COUNT(*) FROM online_number WHERE begin_course_cd = " .  
			$_SESSION['begin_course_cd'] . " AND online_cd <> " . $_SESSION['online_cd'];
		$course_num = db_getOne($sql);
	}
	else if($USE_MONGODB)
	{
		$system_num = $online_number->count();
		$course_num = $online_number->count(array('bcd' => intval($_SESSION['begin_course_cd']), '_id' => array('$ne' => new MongoId($_SESSION['online_cd']))));
	}

    //--update add by q110185
        update_course_tracking();
    //--update end
	echo $system_num . ',' . $course_num;
	
//----------------function area ------------------

function update_course_tracking($action='update')
{
    global $DB_CONN;
   
    $begin_course_cd = $_SESSION['begin_course_cd'];
    $personal_id = $_SESSION['personal_id'];
    if($action =='update')
    {
        //echo "update";
		if(!empty($personal_id) && !empty($begin_course_cd));
		//    LEARNING_TRACKING_update_event_statistics($DB_CONN, 1, 2, $begin_course_cd, $personal_id);
    }
    if($action== 'stop')
    {
        if(!empty($personal_id) && !empty($begin_course_cd)){
            LEARNING_TRACKING_update_event_statistics($DB_CONN, 1, 2, $begin_course_cd, $personal_id);
            LEARNING_TRACKING_stop(1, 2, $begin_course_cd, $personal_id);
        }
    }
}

?>

<?
//  以時間 作為判斷此使用者是否在線上的依據
//  每分鐘此php會reload一次, 此時會將超過一分半未回應的使用者消掉
//  檔案格式為   $user_id, date("U") ,$course_id
//  會使用到session中的$time.

$MONGO_ONLY = true;
$MONGOS = false;
$DE = false;
$TIME = false;
$RELEATED_PATH = "../";
require_once($HOME_PATH . "config.php");
require($HOME_PATH . 'DB.php');
// require_once($RELEATED_PATH . "session.php");
require_once($HOME_PATH . "library/date.php");
// session_start();

global $USE_MONGODB, $USE_MYSQL, $db;
$safe = false;

if(isset($_SESSION['begin_course_cd']))
	$begin_course_cd = $_SESSION['begin_course_cd'];
if(isset($_SESSION['online_cd']))
	$online_cd = $_SESSION['online_cd'];
if(isset($_SESSION['personal_id']))
	$personal_id = $_SESSION['personal_id'];
if(isset($_SESSION['personal_ip']))
	$personal_ip = $_SESSION['personal_ip'];

$limit = 100;
// if($USE_MONGODB)
// {
// 	$list = array();
// 	for($i = 0; $i < ($limit / 10); $i++)
// 	{
// 		$list[] = new MongoId();
// 	}
// }

if($TIME)
{
	$start=microtime();
	$start=explode(" ",$start);
	$start=$start[1]+$start[0]; 
}
$begin_course_cd = mt_rand(1, 20);
$_SESSION['begin_course_cd'] = $begin_course_cd;
if($personal_id == NULL)
	$personal_id = mt_rand(1, 10000);
$online_cd = mt_rand(1, 10000);
if($USE_MONGODB)
{
	// $online_cd = (string)$list[$online_cd - 1];
	$online_cd = (string)(new MongoId());
}
$_SESSION['online_cd'] = $online_cd;
$personal_ip = mt_rand(1, 1000000);

for($i = 0; $i < $limit; $i++)
{
	// $begin_course_cd = mt_rand(1, 20);
	// $_SESSION['begin_course_cd'] = $begin_course_cd;
	// $personal_id = mt_rand(1, $limit / 10);
	// $online_cd = mt_rand(1, $limit / 10);
	// if($personal_id == NULL)
	// 	$personal_id = mt_rand(1, 10000);
	// $online_cd = mt_rand(1, 10000);
	// if($USE_MONGODB)
	// {
	// 	// $online_cd = (string)$list[$online_cd - 1];
	// 	$online_cd = (string)(new MongoId());
	// }
	// $_SESSION['online_cd'] = $online_cd;
	// $personal_ip = mt_rand(1, 1000000);


	//先查詢是否在 online_number
	if($USE_MYSQL)
	{
		$sql = "SELECT COUNT(*) FROM online_number WHERE online_cd='$online_cd'";
		$isHave = db_getOne($sql);
	}
	else if($USE_MONGODB)
	{
		$online_number = $db->online_number;
		$isHave = $online_number->count(array('_id' => new MongoId("$online_cd")));
	}

	// 如果已經在裏面的話 就更新資料
	if($isHave)
	{
		if($USE_MYSQL)
		{
			$sql = "UPDATE online_number SET begin_course_cd='$begin_course_cd', status='觀看公告', idle='" . date('U')."' WHERE online_cd='$online_cd'";
			$res = db_query($sql);
		}
		else if($USE_MONGODB)
		{
			$online_number->update(array('_id' => new MongoId($online_cd)), array('$set' => array('b' => intval($begin_course_cd), 'i' => new MongoDate(), 's' => '觀看公告')), array('safe' => $safe));
		}
	}
	else
	{
		if($USE_MYSQL)
		{
			global $DB_CONN;
			$sql = "INSERT INTO online_number (online_cd, personal_id, host, time, idle, status, begin_course_cd) 
				VALUES ($online_cd, '$personal_id','$personal_ip','".date('U')."','".date('U')."','觀看公告','$begin_course_cd')";
			$r = $DB_CONN->query($sql);
			$_SESSION['online_cd'] = $DB_CONN->insert_id;;			
		}
		else if($USE_MONGODB)
		{
			$mid = new MongoId($online_cd);
			$online_number->insert(array('_id' => $mid, 'p' => intval($personal_id), 'h' => $personal_ip, 't' => new MongoDate(), 'i' => new MongoDate(), 's' => '觀看公告', 'b' => intval($begin_course_cd)), array('safe' => $safe));
			$_SESSION['online_cd'] = $mid;
			if($DE)
			{
				$meta = $db->meta;
				$meta->update(array('_id' => 'online'), array('$inc' => array('n' => 1)), array('upsert' => true, 'safe' => $safe));
			}
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
		$online_number->remove(array('i' => array('$lt' => $d)), array('safe' => $safe));
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
			$begin_course_cd . " AND online_cd <> " . $online_cd;
		// $sql = "SELECT COUNT(*) FROM online_number WHERE begin_course_cd = " .  
		// 	$begin_course_cd;
		$course_num = db_getOne($sql);
	}
	else if($USE_MONGODB)
	{
		if($DE)
		{
			$system_num = $meta->findOne(array('_id' => 'online'), array('_id' => 0));
			$system_num = $system_num['n'];
		}
		else
			$system_num = $online_number->count();
		$course_num = $online_number->count(array('b' => intval($begin_course_cd), '_id' => array('$ne' => new MongoId($online_cd))));
		// $course_num = $online_number->count(array('b' => intval($begin_course_cd)));
	}

}

if($TIME)
{
	$end=microtime();
	$end=explode(" ",$end);
	$end=$end[1]+$end[0];
	printf("%f\n",$end-$start);
	//--update add by q110185
	// update_course_tracking();
	//--update end
	echo $system_num . ',' . $course_num . "\n";
}

//----------------function area ------------------

// function update_course_tracking($action='update')
// {
//     global $DB_CONN;
//    
//     $begin_course_cd = $_SESSION['begin_course_cd'];
//     $personal_id = $_SESSION['personal_id'];
//     if($action =='update')
//     {
//         //echo "update";
// 		if(!empty($personal_id) && !empty($begin_course_cd));
// 		//    LEARNING_TRACKING_update_event_statistics($DB_CONN, 1, 2, $begin_course_cd, $personal_id);
//     }
//     if($action== 'stop')
//     {
//         if(!empty($personal_id) && !empty($begin_course_cd)){
//             LEARNING_TRACKING_update_event_statistics($DB_CONN, 1, 2, $begin_course_cd, $personal_id);
//             LEARNING_TRACKING_stop(1, 2, $begin_course_cd, $personal_id);
//         }
//     }
// }

?>

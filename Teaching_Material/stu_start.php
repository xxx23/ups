<?php
/***********************************************************/
/* id: stu_start.php 2007/8/23 by hushpuppy Exp.		   */
/* function: 教材導覽 學生頁面							   */
/***********************************************************/
$MONGO_ONLY = true;
$MONGOS = true;
$MENU = false; // 要不要查menu的function
require_once($HOME_PATH.'config.php');
require($HOME_PATH.'DB.php');
// require_once("../session.php");
if($MENU)
	require_once($HOME_PATH."Teaching_Material/lib/textbook_func.inc");
require_once($HOME_PATH."Teaching_Material/lib/learning_record.php");
// require_once('../library/content.php');
require_once($HOME_PATH.'Learning_Tracking/time_output_format.php');

$TIME = false;
$limit = 100;

// 加了下面這段會有奇怪的bug ors insert會出現duplicate key 而且是login_log的 怪怪
// global $USE_MYSQL, $USE_MONGODB, $db;

$Begin_course_cd = $_SESSION['begin_course_cd'];
// $Content_cd = $_GET['content_cd'];
$Personal_id = $_SESSION['personal_id'] ; 
if($MENU)
	$Menu_id = returnContent_cdRootMenuId($Content_cd);  
//$Begin_course_cd = 48;
// $Content_cd = 13021;
// $Personal_id = 1297; 
// $Menu_id = 423;
// $Begin_course_cd = mt_rand(1, 5);
// $Content_cd = 1;
// $Personal_id = mt_rand(1, 1000); 
// $Menu_id = mt_rand(1, 10);

if($TIME)
{
	$start=microtime();
	$start=explode(" ",$start);
	$start=$start[1]+$start[0]; 
}

for($i = 0; $i < $limit; $i++)
{
	// $Begin_course_cd = mt_rand(1, 5);
	$Content_cd = 1;
	// $Personal_id = mt_rand(1, 1000); 
	$Menu_id = mt_rand(1, 10);
	// $Menu_id = returnContent_cdRootMenuId($Content_cd);  
	if(isset($Content_cd) && isset($Menu_id)){  //按下樹狀結構時，以得到的值向session註冊
		learning_status($Begin_course_cd, $Content_cd, $Menu_id, $Personal_id);
		// $_SESSION['content_cd'] = $Content_cd;
		// $_SESSION['menu_id'] = $Menu_id;
	}
	
	// $content_file_name = returnContentFileName($Content_cd);
	// $smtpl = new Smarty;
	// //取得這一門課所使用的教材它的老師的id
	// $Teacher_cd = textbook($Begin_course_cd);
	// $path = $DATA_FILE_PATH.$Teacher_cd."/textbook/";
	// $path .= $content_file_name."/";
	// show($smtpl, $path);
	// $new_path = str_replace($HOME_PATH, "/", $path);
	// $new_path = encodePATH($new_path);
	// $new_path = ltrim($new_path,'/');	//必免跟WEBROOT結合產生  '//'
	
	//echo "root current_path: $path <br>";
	// $smtpl->assign("current_path",rtrim($WEBROOT.$new_path,'/'));
	// $smtpl->assign("content_cd",$Content_cd);
	// $smtpl->assign("Menu_id", $Menu_id); 
	// $smtpl->assign("Begin_course_cd", $Begin_course_cd);
	// $smtpl->assign("Personal_id", $Personal_id);
	// $Frame = $_GET['frame'];
	// $smtpl->assign("Frame",$Frame);
	
	//--------0308 joyce edit-------
	if($USE_MYSQL)
	{
		$sql = "SELECT
				 sum(TIME_TO_SEC(A.event_hold_time)) as event_hold_time
				FROM
				 student_learning A
				WHERE
				 A.begin_course_cd = '$Begin_course_cd' AND
				 A.content_cd = '$Content_cd' AND
				 A.personal_id = '$Personal_id'
				 ";
		
		$res = db_query($sql);
		$resultNum = $res->num_rows;
		
		if($resultNum > 0)
		{
			// $res->fetchInto($row, DB_FETCHMODE_ASSOC);
			$row = $res->fetch_assoc();
			$ReadTextTime = time_output_format($row['event_hold_time']);
			// $smtpl->assign("ReadTextTime", $ReadTextTime);
		}
	}
	else if($USE_MONGODB)
	{
		$res = $db->command(array('aggregate' => 'student_learning', 'pipeline' => array(array('$match' => array('b' => intval($Begin_course_cd), 'c' => intval($Content_cd), 'p' => intval($Personal_id))), array('$group' => array('_id' => '$p', 'event_hold_time' => array('$sum' => '$eht'))))));
		$resultNum = count($res['result']);
	
		if($resultNum > 0)
		{
			$row = $res['result'][0];
			$ReadTextTime = time_output_format($row['event_hold_time']);
			// $smtpl->assign("ReadTextTime", $ReadTextTime);
		}
	}
}

// printf($ReadTextTime . "\n");

if($TIME)
{
	$end=microtime();
	$end=explode(" ",$end);
	$end=$end[1]+$end[0];
	printf("%f\n",$end-$start);
}

//-------------------------------

/* assignTemplate( $smtpl,"/teaching_material/stu_start.tpl"); */


// function show($smtpl, $path)
// {
//      $file_path1 = $path."index.html";
//      $file_path2 = $path."index.htm";
//      $file_path3 = $path."index.swf";
// 
//      $index_exist1 = false;
//      $index_exist2 = false;
//      $index_exist3 = false;
// 
//      if(file_exists($file_path1))
//             $index_exist1 = true;
//      if(file_exists($file_path2))
// 	    $index_exist2 = true;
//      if(file_exists($file_path3))
// 	    $index_exist3 = true;
//      
//      if($index_exist1 == false && $index_exist2 == false && $index_exist3 == false)
//         $smtpl->assign("index_show",0); //預覽時顯示檔案list
//      else{
//         if($index_exist1 == true){
//             $handle = fopen($file_path1, "r");  //開啟index.html並將內容塞回textarea
//             $smtpl->assign("index_show",1);     //預覽時顯示index.html
//         }
//         else if($index_exist2 == true){
//             $handle = fopen($file_path2, "r");
//             $smtpl->assign("index_show",2);     //預覽時顯示index.htm
//         }
// 	else if($index_exist3 == true){	
//             $handle = fopen($file_path3, "r");
//             $smtpl->assign("index_show",3);     //預覽時顯示index.swf
// 	}
//         $index_content = fread($handle, 65535);
//         $smtpl->assign("index_content",$index_content);
// 	}
// }

// function encodePATH($Path)
// {
//     $tok = strtok($Path, "/");
//       $string = "/";
//       while ($tok !== false) {
// 		if(strstr($tok," ") != false)
// 			$str = $tok;
// 		else
//             $str = URLENCODE($tok);
//                 $tok = strtok("/");
//                 $string = $string.$str."/";
//       }
//         return $string;
// }
?>

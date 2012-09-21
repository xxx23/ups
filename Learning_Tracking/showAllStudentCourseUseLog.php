<?
$RELEATED_PATH = "../";

require_once($RELEATED_PATH . "config.php");	
require_once($RELEATED_PATH . "session.php");
require_once($RELEATED_PATH . "library/content.php");
require_once("./time_output_format.php");
//require_once($HOME_PATH. 'library/smarty_init.php');
echo str_pad('',1024); 
//require_once($RELEATED_PATH . "session.php");
$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
$absoluteURL = $HOMEURL . "Learning_Tracking/";

$begin_course_cd = $_SESSION['begin_course_cd'];		//取得課程代碼

global $USE_MYSQL, $USE_MONGODB, $db;

$tpl = new Smarty;
$tpl->assign("cssPath", $CSS_PATH);
$tpl->assign("imagePath", $IMAGE_PATH);
$tpl->assign("absoluteURL", $absoluteURL);

//從Table take_course取得課程學生名單	
$sql = "SELECT 
	A.personal_id, 
	B.personal_name 
	FROM 
	take_course A, 
	personal_basic B 
	WHERE 
	A.begin_course_cd = $begin_course_cd AND 
	A.personal_id = B.personal_id 
	ORDER BY 
	A.personal_id ASC
	";
$res = db_query($sql);
$resultNum = $res->numRows();

if($resultNum > 0)
{
	$rowCounter = 0;

	while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
	{	
		$studentList[$rowCounter]['student_id'] = $row['personal_id'];
		$studentList[$rowCounter]['name'] = $row['personal_name'];
		$studentList[$rowCounter]['LoginCourse'] = "0";
		$studentList[$rowCounter]['LoginCourseTime'] = "0 秒";
		$studentList[$rowCounter]['LastLoginCourseTime'] = "尚未登入過";
		$studentList[$rowCounter]['DisscussAreaPost'] = "0";
		$studentList[$rowCounter]['ReadText'] = "0";
		$studentList[$rowCounter]['ReadTextTime'] = "0 秒";

		$rowCounter++;
	}
	$studentNum = $rowCounter;
	$tpl->assign("studentNum", $studentNum);
}
//取得每個學生的資料
for($studentListCounter = 0; $studentListCounter<$studentNum; $studentListCounter++)
{
	$sql = "SELECT 
		* 
		FROM 
		event_statistics A 
		WHERE 
		A.begin_course_cd = $begin_course_cd AND 
		A.personal_id = " . $studentList[$studentListCounter]['student_id'] . "
		";
	$res = db_query($sql);
	$resultNum = $res->numRows();

	if($resultNum > 0)
	{
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{
			switch($row['system_id'])
			{
			case 1:	//系統
				if($row['function_id'] == 2)
				{
					//登入課程
					$studentList[$studentListCounter]['LoginCourse'] = $row['function_occur_number'];

					$LoginCourseTime = 	time_output_format(convert_datetime($row['function_hold_time']));
					//$LoginCourseTime = round($LoginCourseTime, 2) . " h";	//只顯示到小數點以下兩位
					$studentList[$studentListCounter]['LoginCourseTime'] = $LoginCourseTime;
				}


				break;

			case 2:	//公告

				break;

			case 3:	//討論區
				if($row[function_id] == 1)
				{
					$studentList[$studentListCounter][DisscussAreaPost] = $row[function_occur_number];
				}
				break;

			case 4:	//教材
						/****if($row[function_id] == 1)
						{
							$studentList[$studentListCounter][ReadText] = $row[function_occur_number];

							$ReadTextTime = substr($row[function_hold_time],0,4)*12*31*24 + 
											substr($row[function_hold_time],5,2)*31*24 + 
											substr($row[function_hold_time],8,2)*24 + 
											substr($row[function_hold_time],11,2) + 
											substr($row[function_hold_time],14,2)/60;
							$ReadTextTime = round($ReadTextTime, 2) . " h";	//只顯示到小數點以下兩位
							$studentList[$studentListCounter][ReadTextTime] = $ReadTextTime;
						}
						break;*/

			default:
				break;
			}
		}		
		//5.取得 觀看教材次數 以及 時數
		if($USE_MYSQL)
		{
			$sql = "SELECT 
				sum(A.event_happen_number) as event_hp_time,
					sum(TIME_TO_SEC(A.event_hold_time)) as event_hold_time  
					FROM 
					student_learning A 
					WHERE 
					A.begin_course_cd = '$begin_course_cd' AND 
					A.content_cd = '".get_Content_cd($begin_course_cd)."' AND 
					A.personal_id = '{$studentList[$studentListCounter]['student_id']}'
					";
	
			$res = db_query($sql);
			$resultNum = $res->numRows();

			if($resultNum > 0)
			{
				$res->fetchInto($row, DB_FETCHMODE_ASSOC);
				$studentList[$studentListCounter]['ReadText'] = $row['event_hp_time'];
				// var_dump($begin_course_cd . '<br />');
				// var_dump(get_Content_cd($begin_course_cd) . '<br />');
				// var_dump($studentList[$studentListCounter]['student_id'] . '<br />');
				$ReadTextTime = time_output_format($row['event_hold_time']);
				$studentList[$studentListCounter]['ReadTextTime']=$ReadTextTime;

			}
			else
			{
				$studentList[$studentListCounter]['ReadText'] = "0";
				$studentList[$studentListCounter]['ReadTextTime'] = "0秒";
			}
		}
		else if($USE_MONGODB)
		{
			$res = $db->command(array('aggregate' => 'student_learning', 'pipeline' => array(array('$match' => array('bcd' => intval($begin_course_cd), 'ccd' => intval(get_Content_cd($begin_course_cd)), 'pid' => intval($studentList[$studentListCounter]['student_id']))), array('$group' => array('_id' => '$pid', 'event_hp_time' => array('$sum' => '$ehn'), 'event_hold_time' => array('$sum' => '$eht'))))));
			$resultNum = count($res);

			if($resultNum > 0)
			{
				$row = $res['result'][0];
				$studentList[$studentListCounter]['ReadText'] = $row['event_hp_time'];
				$ReadTextTime = time_output_format($row['event_hold_time']);
				$studentList[$studentListCounter]['ReadTextTime']=$ReadTextTime;

			}
			else
			{
				$studentList[$studentListCounter]['ReadText'] = "0";
				$studentList[$studentListCounter]['ReadTextTime'] = "0秒";
			}
		}

	}
	// Edit by carlcarl 這個SQL的語法 速度較快
	$sql = "SELECT 
		MAX(A.function_occur_time) as function_occur_time
		FROM 
		event A 
		WHERE 
		A.begin_course_cd = $begin_course_cd AND 
		A.system_id = 1 AND 
		A.function_id = 2 AND 
		A.personal_id = " . $studentList[$studentListCounter]['student_id'] . " 
		";

	$res = db_query($sql);
	$res->fetchInto($row, DB_FETCHMODE_ASSOC);

	if($row['function_occur_time'] == NULL)
	{
		$studentList[$studentListCounter]['LastLoginCourseTime'] = "尚未登入課程過";
	}
	else
	{
		$studentList[$studentListCounter]['LastLoginCourseTime'] = $row['function_occur_time'];
	}
}
$tpl->assign("studentList", $studentList);

assignTemplate($tpl, "/learning_tracking/allStudentCourseUseLog.tpl");

ob_flush();
flush();
sleep(1);
?>

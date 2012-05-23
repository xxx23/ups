<?php
// File Name : course_end_alert_mail.php
// Function: 課程結束日期七天前eamil提醒
// Modify date: 20090816
// Modify by : q110185

$env = php_sapi_name();
if($env == 'apache2handler' && $env != 'cli')
{
    die('Do not execute on browser!');
}

chdir(dirname($_SERVER['PHP_SELF']) );
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "library/common.php");
	require_once($RELEATED_PATH . "library/mail.php");
	//計算七天後
	
	$sevenDaysAfter = date("Y-m-d",time()+7*24*60*60);
	//----------for test---------
	//	if(isset($_GET['d']))
	//		$sevenDaysAfter = $_GET['d'];
	//	echo $sevenDaysAfter;
	//----------------------------
	
	//取出七天後所有到期課程資訊
	echo $sql = "SELECT p.personal_id, p.personal_name, p.email, b.begin_course_name,t.course_end
			FROM (SELECT begin_course_cd, personal_id, course_end
				  FROM take_course
                  WHERE course_end = '{$sevenDaysAfter}' AND
						allow_course=1 )AS t,
				  begin_course b,
				  personal_basic p
			WHERE b.begin_course_cd=t.begin_course_cd AND
				  t.personal_id=p.personal_id";
				  
	$result = db_query($sql);
	if($result->numRows()){
		while($data = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$str = "".$data['personal_id'];
			$mailData[$str]['name'] = $data['personal_name'];
			$mailData[$str]['email'] = $data['email'];
			$mailData[$str]['course_list'] .= $data['begin_course_name'].'<br/>';
			//----------for test---------
			//	my_var_dump($data);
			//	echo "-----------------------------<br/>\n";
			//--------------------------
		}
	}
	//發出mail
	foreach($mailData as $value)
	{
		if(!empty($value['email'])){
		mailto("admin@ups.moe.edu.tw",
				   "[教育部數位學習服務平台-管理者]",
				   $value['email'],
				   "[提醒]課程即將結束",
				   $value['name']." 您好!<br/>您以下課程將在七天後到達修課期限<br/>====================<br/>".$value['course_list']."====================<br/>請注意!!<br/><br/>信件由系統自動寄出無需回覆<br/>"
               );
		}
	}
	
	function my_var_dump($arr)
	{
		echo "\n<pre>";
		echo var_dump($arr);
		echo "\n</pre>";
	}
?>

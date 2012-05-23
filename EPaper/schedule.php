<?php

$env = php_sapi_name();
if($env == 'apache2handler' && $env != 'cli')
{
    die('Do not execute on browser!');
}

	require_once("../config.php");
	include("../library/mail.php"); // 使用mail library
	
	//利用linux的排程，必須先切換到程式的資料夾下
	chdir($HOME_PATH . "EPaper/");
	
	//取得昨天的日期
	$yesterday = substr(shell_exec("date -v-1d \"+%Y%m%d\""), 0, 8) . "000000";
	
	//從Table e_paper, course_epaper, person_epaper, personal_basic, begin_course
	$sql = 		"SELECT  
						A.epaper_file_url, 
						D.personal_name, 
						D.email, 
						E.begin_course_name 
				FROM 
						e_paper A, 
						person_epaper C, 
						personal_basic D, 
						begin_course E 
				WHERE 
						A.d_public_day = '$yesterday' AND 
						A.begin_course_no = C.begin_course_cd AND 
						C.if_subscription = 'Y' AND 
						C.personal_id = D.personal_id AND 
						A.begin_course_no = E.begin_course_cd
					";
	$res = db_query($sql);

	$epaperNum = $res->numRows();
	
	if($epaperNum > 0) {
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) ) {					
			$from_name = $row['begin_course_name'];	//送信者名稱
			$from_mail = ""; //送信者E-mail位址
			$to_name = $row['personal_name']; //收信者名稱
			$to_mail = $row['email']; //收信者E-mail位址
			$subject = "[{$row['begin_course_name']}]-課程電子報";//信件標題
			
			//信件內容
			$filename = $row['epaper_file_url'];
			$file = fopen($filename, "r");
			$content = fread($file, filesize($filename));
			fclose($file);
			$message = $content;
			
			//送出信件
			mailto($from_name, "", $to_mail, $subject, $message);	
		}
	}
?>

<?php
/*
	author: rja
	這支程式是拿來開 mmc 即時會議用的，不知道還有沒有用
*/
require_once 'common.php';
require_once 'fadmin.php';

//這支程式應該是學生進入網路辦公室 mmc 時用的

global $course_id;
global $user_id;
global $DB_SERVER, $DB_LOGIN, $DB, $DB_PASSWORD;


if ( !($link = mysql_pconnect($DB_SERVER,$DB_LOGIN,$DB_PASSWORD)) ) {
	echo( "資料庫連結錯誤!!" );
	exit;
}

//目前不考慮一個課程有二個以上的老師的情況，如果日後要考慮這種情況，就是把不同老師的姓名列出來，傳給 mmc，mmc 上另一支程式再判斷哪個老師有開即時會議中
$Q1 = "select name from teach_course as t1, user as t2 where course_id= '$course_id' and  t1.teacher_id = t2.a_id and authorization = 1 and t2.name !='name' ;  ";
$teacher_name=query_db($Q1, 'name');



$teacher_name_encode = urlencode($teacher_name);
//find meetingId from remote mmc
$teacher_id=file_get_contents("http://ups.moe.edu.tw/mmc/get_joinnet.php?teacher_name=$teacher_name_encode");

//print "select name from teach_course as t1, user as t2 where course_id= '20331' and  t1.teacher_id = t2.a_id and authorization = 1 and t2.name !='name' and t2.name !=null";
//var_dump($meetingid);
//print_r($meetingid);
if (!is_numeric($teacher_id) ) 
{
	echo("some thing wrong: return value is not numeric. <b>Debug code: $teacher_id, $teacher_name</b>");
}

/* 下面這個部份，保留給如果在學生進入 mmc 即時會議時，是否可以選擇自填姓名
   mark 掉的這段，是自動幫學生填姓名
   目前預設是讓學生自己填
*/

/*
//query this student 
$Q3 = "select * from user where id= '$user_id' ";
$this_user_name=query_db($Q3, 'name');
//print 'here'.$this_user_name;



//$this_user_name = iconv('big5', 'utf-8', $this_user_name);
$this_user_name = urlencode($this_user_name);

//header("Location: http://140.123.23.78/gotomeeting.php?u=$meetingid&c=visit&name=$this_user_name");
*/

header("Location: http://140.123.23.78/gotomeeting.php?u=$teacher_id&c=visit");

function query_db($query, $column) {

	global $DB;
	if ( $result1 = mysql_db_query( $DB, $query) ) {

		if ( mysql_num_rows( $result1 ) != 0 ) {
			$row_result= mysql_fetch_array( $result1 );
			if ( is_null($row_result["$column"]))echo "server4: some thing wrong. Query result is null?!";

			return  $row_result["$column"];
		}
		else echo "some thing wrong. Query result is null?";
	}
	else echo "some thing wrong. Can't Query?";
}



?>

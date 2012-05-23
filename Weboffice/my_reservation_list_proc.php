<?PHP
//error_reporting(1);    
require_once("../config.php");
require_once("../session.php");
#require_once 'passwd_encryption.php';

#error_reporting(256);

global $begin_course_cd;
 $personal_id = $_SESSION['personal_id'];

#$query_this_semeter = "SELECT * FROM this_semester";
#$this_semeter = flatArray(query_db_to_array($query_this_semeter));
#$this_year = $this_semeter[0];
#$this_term = $this_semeter[1];

//$Q1 = "SELECT a_id FROM user where id = '$personal_id'";
//$teacher_account = query_db_to_value($Q1);

/* 
這裡需要分辨老師與學生的不同
老師是所授的課程列表
學生是所修的課程列表
*/

if(isTeacher($personal_id)){
//different with ecourse, cyberccu不知道為什麼，不用看 year 及 term 
	//$Q1_ecourse_backup_sql = "select c.name AS courseName FROM course c, teach_course tc, user u where u.id = '$personal_id' and tc.teacher_id = u.a_id and c.a_id = tc.course_id and tc.year = $this_year and tc.term = $this_term order by c.a_id ASC";
	$Q1 = "select B.begin_course_cd, B.begin_course_name
		from `teach_begin_course` A, `begin_course` B where A.teacher_cd=$personal_id and B.begin_course_cd=A.begin_course_cd;";
	//$Q1 = "select c.name AS courseName FROM course c, teach_course tc, user u where u.id = '$personal_id' and tc.teacher_id = u.a_id and c.a_id = tc.course_id order by c.a_id ASC";
	//echo $Q1;
}else {
//different with ecourse, cyberccu不知道為什麼，不用看 year 及 term 

	//$Q1 = "SELECT c.name as courseName FROM user u, take_course t, course c where u.id= '{$personal_id}'and  t.student_id = u.a_id and c.a_id = t.course_id and (( t.credit = '0' and c.validated%2 != '1') or t.credit = '1') order by  c.group_id ,c.a_id";
	//$Q1_ecourse_backup_sql = "select c.name AS courseName FROM course c, take_course tc, user u where u.id = '$personal_id' and tc.student_id = u.a_id and c.a_id = tc.course_id and tc.year = $this_year and tc.term = $this_term order by c.a_id ASC";
	
	$Q1 = "select A.begin_course_cd, B.begin_course_name
		        from `take_course` A, `begin_course` B where A.personal_id=$personal_id and B.begin_course_cd=A.begin_course_cd;";
	//echo $Q1;
}


//$query_course_name_sql = "SELECT c.name as course_name FROM teach_course as tc, course as c WHERE tc.course_id = c.a_id and tc.teacher_id = {$teacher_account}";

#print $query_course_name_sql;
// $course_name_list  應該要從 ecdemo 那邊傳來，這支程式 "my_reservation_list.php" 應該要被 ecdemo 的程式 require 

$course_name_list = flatArray(db_getAll($Q1));
#$course_name_list[]='嚇嚇a';
//var_dump($course_name_list);

if(empty($course_name_list))return;
$format_course_name = formatCourseName($course_name_list);
$format_course_name = urlencode($format_course_name);



$start_time = date("Ymd");
//在 mmc 上，30分鐘為一時段，一天有 48 個時段
//這裡先查個今天開始一年內
$end_interval = 48*356;
$action = 'reservationLookupByCourseNameTime';

$reservation_url = "http://ups.moe.edu.tw/mmc/my_get_mmc_info.php?action=$action&courseNameList=$format_course_name&t=$start_time&s=0&i=$end_interval";


//this
$reservation_list = file_get_contents($reservation_url);
$reservation_list = explode("\n", $reservation_list );
array_pop($reservation_list) ;

$reservation_meeting = array();
//next: 用 foreach 每一行 ，用一個陣列接住傳回來的變數 (已用 | 隔開)，預期別人 require 這支程式，就會拿到這個陣列
foreach($reservation_list as $key => $value){
 if (@@iconv('utf-8', 'utf-8', $value) != $value) {
                        $value = iconv("big5", "utf-8", $value);
                }

	list (
			$reservation_meeting[$key]['meetingId'],
			$reservation_meeting[$key]['teacherName'],
			$reservation_meeting[$key]['teacherIdNum'],
			$reservation_meeting[$key]['courseName'],
			$reservation_meeting[$key]['title'],
			$reservation_meeting[$key]['startTime'],
			$reservation_meeting[$key]['endTime'],
			$reservation_meeting[$key]['isOnline'],
			$reservation_meeting[$key]['maxNumAttendee'],
			$reservation_meeting[$key]['recording'],
			$reservation_meeting[$key]['finished'],
	     ) = split("\|@" , $value);

#sample
	//echo "{$meeting_value->meetingId}|{$teacher_name}|{$course_name}|{$meeting_value->title}|{$meeting_value->startTime}|{$isOnline}|{$meeting_value->maxNumAttendee}|{$meeting_value->recording}\n";
}

//var_dump( $reservation_meeting);

?>
<?PHP
function isTeacher($personal_id){
	/*
         *   這張 table 應該 cyberccu 跟 cyberccu2 的一樣吧
	 * 	4 	旁聽人員
	 * 	2 	助教
	 * 	0 	管理者
	 * 	1 	教師
	 * 	3 	學生
	 * 	5 	測試人員
	 */




	if (($_SESSION['role_cd'] == '1') || ($_SESSION['role_cd'] == '2')){
		return true;
	}
	else return false;

}

function formatCourseName($course_name_list){
	$return_string = '';
	if(empty($course_name_list))
		print "my_reservation_list_proc.php say: empty array.";

	foreach ($course_name_list as $value){
		$return_string .= ($value . '|'); 

	}
	return rtrim($return_string , '|');
}

/*
   function reservation(){
   global $course_id;
   global $personal_id;
   global $action;
   $Q1 = "select email from user where id= '$personal_id' ";
   $teacher_email=query_db_to_value($Q1);
   $Q2 = "select pass from user where id= '$personal_id' ";
   $encrypted_passwd=query_db_to_value($Q2);
   $teacher_pass=passwd_decrypt($encrypted_passwd);

   $find_course_name_sql = "select name from course where a_id = $course_id; ";
   $course_name = query_db_to_value($find_course_name_sql);
   $course_name = urlencode($course_name);

   header("Location: http://ups.moe.edu.tw/mmc/t_get_joinnet.php?action=$action&email=$teacher_email&password=$teacher_pass&course_name=$course_name");

   }
 */



?>

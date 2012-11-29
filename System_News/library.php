<?php
/*author: lunsrot
 * date: 2008/02/20
 */
global $news_course_types;
$news_course_types = array(
	'系統' => array( 0 =>'系統公告'),
    '課程' => array( 
        6 =>'課程公告',
        1 =>'一般民眾課程',
		2 =>'中小學教師課程',
        ///* 3=>'高中職課程', 他們說不要 所以改改改掉 */
		4 =>'大專院校課程'
	),
	'其他' => array( 5 => '其他公告')
);

function get_news_type_where_sql ($news_type) {
	switch ($news_type) {
		case 'system' : return ' AND course_type=0 ';
		case 'course-all': return ' AND (course_type=1 OR course_type=2 OR course_type=3 OR course_type=4 OR course_type=6 ) '; 
		case 'course-1': return ' AND course_type=1 ';
		case 'course-2': return ' AND course_type=2 ';
		case 'course-3': return ' AND course_type=3 ';
		case 'course-4': return ' AND course_type=4 ';
		case 'course-6': return ' AND course_type=6 ';
		case 'other': return ' And course_type=5 ';
		default : return '';
	}
}
 
function gen_system_news_path($personal_id) {
	global $HOME_PATH;
	global $DATA_FILE_PATH; 
	//系統公告
	//設定檔案儲存路徑
	$check_system_news_path = basename($DATA_FILE_PATH)
		.'/'.$personal_id.'/System_News/';
	
	createPath( $HOME_PATH .$check_system_news_path);
	return $check_system_news_path ;
}

function gen_course_news_path($begin_course_cd) {
	global $HOME_PATH;
	global $COURSE_FILE_PATH; 
	//課程公告
	//設定檔案儲存路徑
	$check_course_news_path  = basename($COURSE_FILE_PATH)
		.'/'.$begin_course_cd.'/System_News/';
		
	createPath($HOME_PATH . $check_course_news_path);	
	return $check_course_news_path ; 
}

function get_publish_name($pid){
	global $m, $USE_MONGODB, $USE_MYSQL;
	if($USE_MONGODB)
	{
		$db = $m->elearning;
		$personal_basic = $db->personal_basic;
		$result = $personal_basic->findOne(array('p' => $pid));
		if($result == NULL)
			return "Unknow";
		else
			return "Unknow";
	}
	else
	{
		$num = db_getOne("SELECT count(*) FROM `personal_basic` WHERE personal_id=$pid;");
		if($num != 1)
			return "Unknow";
		return db_getOne("SELECT personal_name FROM `personal_basic` WHERE personal_id=$pid;");
	}
}

//處理important	
function convert_important($level_value){ 	
	if($level_value == 0)	$level = "最低";
	else if($level_value == 1)	$level = "中等";
	else if($level_value == 2)	$level = "最高";
	else	$level = "其它等級";
	return $level;
}

function convert_date($date_row){
		//處理date
	$date = str_replace('-', '/', $date_row);
	$date = substr($date, 0, 10);
	return $date ;
}
?>

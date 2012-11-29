<?php

/*
 * Import mysql news 相關資料表到mongodb 的 new 資料表(正規化)
 */

$DB_TYPE = "mysql";
$DB_HOST = "mysql1";
$DB_NAME = "elearning";
$DB_USERNAME = "hsng";
$DB_USERPASSWORD = "ringline";

// $DB_HOST = 'mysql-proxy';
$DB_CONN = new mysqli($DB_HOST, $DB_USERNAME, $DB_USERPASSWORD, $DB_NAME);
if($DB_CONN->connect_errno) 
{
	printf("Connect failed: %s\n", $DB_CONN->connect_error);
	die();
}

//appended by puppy for avoiding encoding problem
if ($DB_TYPE == "mysql")
	$DB_CONN->query("SET NAMES 'utf8'");

$sql = "select * from news A, news_target B where A.news_cd = B.news_cd";

$all_news = db_getAll($sql);

MongoCursor::$timeout = -1;
$m = new Mongo();
$db = $m->elearning;
$news = $db->news2;
$news_target = $db->news_target;
$news_upload = $db->news_upload;

foreach($all_news as &$row)
{

	$data = array(
		's' => $row['subject'],
		'p' => intval($row['personal_id']),
		'db' => new MongoDate(strtotime($row['d_news_begin'])),
		'c' => $row['content'],
		'i' => intval($row['important']),
		'f' => intval($row['frequency']),
		'h' => $row['handle'],
		'm' => new MongoDate(strtotime($row['mtime'])),
		'in' => $row['if_news']
	);
	if($row['d_news_end'] != '0000-00-00 00:00:00')
	{
		$data['de'] = new MongoDate(strtotime($row['d_news_end']));
	}
	if($row['d_cycle'] != '')
	{
		$data['dc'] = $row['d_cycle'];
	}
	if($row['week_cycle'] != '')
	{
		$data['wc'] = $row['week_cycle'];
	}
	$news->insert($data);

	// target
	$data2 = array(
		'i' => $data['_id'],
		'r' => intval($row['role_cd']),
		'ct' => intval($row['course_type'])
	);
	if($row['begin_course_cd'] != NULL)
	{
		$data2['b'] = intval($row['begin_course_cd']);
	}
	$news_target->insert($data2);

	// file
	$sql = "SELECT * FROM news_upload WHERE news_cd={$row['news_cd']}";
	$uploads = db_getAll($sql);
	foreach($uploads as &$upload)
	{
		$tmp = array(
			'i' => $data['_id'],
			't' => intval($upload['file_type']),
			'u' => $upload['file_url'],
			'iu' => $upload['if_url']
		);
		if($upload['file_name'] != '')
		{
			$tmp['n'] = $upload['file_name'];
		}
		if($upload['news_file'] != '')
		{
			$tmp['f'] = $upload['news_file'];
		}
		$news_upload->insert($tmp);
	}
}


function db_getAll($sql){
	global $DB_CONN;
	global $DB_DEBUG;
	global $WEBROOT;
	$r = $DB_CONN->query($sql);

	if(!$r)
	{
		if($DB_DEBUG)
			die($_SERVER['PHP_SELF'] . ': '.$DB_CONN->error);
		else
			header("Location:".$WEBROOT."error.html");
	}
	$ret = array();
	while($row = $r->fetch_assoc())
	{
		$ret[] = $row;
	}
	return $ret;
	// $r=Array();
	// $r = $DB_CONN->getAll($sql, null, DB_FETCHMODE_ASSOC) ;
	// if(PEAR::isError($r))
	// {
	//     if($DB_DEBUG)
	//         die($_SERVER['PHP_SELF'] . ': '.$r->getDebugInfo());
	//     else
	//         header("Location:".$WEBROOT."error.html");
	// }
	// return $r;
}
?>

<?php

/*
 * Import mysql news 相關資料表到mongodb 的 new 資料表
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

$sql = "select A.*, B.* from news A, news_target B where A.news_cd=B.news_cd";

$all_news = db_getAll($sql);

MongoCursor::$timeout = -1;
$m = new Mongo();
$db = $m->elearning;
$news = $db->news;

foreach($all_news as &$row)
{
	$sql = "SELECT * FROM news_upload WHERE news_cd={$row['news_cd']}";
	$uploads = db_getAll($sql);
	$u = array();
	foreach($uploads as &$upload)
	{
		$tmp = array(
			/* 'n' => $upload['file_name'], */
			't' => intval($upload['file_type']),
			/* 'f' => $upload['news_file'], */
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
		$u[] = $tmp;
	}
	$data = array(
		's' => $row['subject'],
		'p' => intval($row['personal_id']),
		'db' => new MongoDate(strtotime($row['d_news_begin'])),
		// 'de' => new MongoDate(strtotime($row['d_news_end'])),
		'c' => $row['content'],
		'i' => intval($row['important']),
		'f' => intval($row['frequency']),
		/* 'dc' => $row['d_cycle'], */
		/* 'wc' => $row['week_cycle'], */
		'h' => $row['handle'],
		'm' => new MongoDate(strtotime($row['mtime'])),
		'in' => $row['if_news'],

		'r' => intval($row['role_cd']),
		/* 'b' => intval($row['begin_course_cd']), */
		'ct' => intval($row['course_type']),
		'u' => $u
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
	if($row['begin_course_cd'] != NULL)
	{
		$data['b'] = intval($row['begin_course_cd']);
	}
	$news->insert($data);
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

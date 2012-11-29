<?php

$host = gethostname();
$n = substr($host, -1);

MongoCursor::$timeout = -1;
$m = new Mongo();
$db = $m->elearning;
$login_log = $db->login_log;

$ip = '140.123.230.133';
$limit = 100;
$limit2 = 10000;
$s = (intval($n) - 1) * $limit;
$safe = false;
$TIME = false;

if($TIME)
{
	$start=microtime();
	$start=explode(" ",$start);
	$start=$start[1]+$start[0]; 
}

$pid = mt_rand($s + 1, $s + $limit2);
if(!isset($_SESSION))
	session_start();
$_SESSION['personal_id'] = $pid;
// $id = md5((string)new MongoId());
for($i = 0; $i < $limit; $i++)
{
	// $pid = mt_rand($s + 1, $s + $limit2);
	// if(!isset($_SESSION))
	// 	session_start();
	// $_SESSION['personal_id'] = $pid;
	$id = md5((string)new MongoId());
	$login_log->insert(array('_id' => $id, 'p' => intval($pid), 'l' => new MongoDate(), 'i' => $ip), array('safe' => $safe));
	// $login_log->insert(array('p' => intval($pid), 'l' => new MongoDate(), 'i' => $ip), array('safe' => $safe));
	// $login_log->insert(array('p' => md5($pid), 'l' => new MongoDate(), 'i' => $ip), array('safe' => $safe));
}

if($TIME)
{
	$end=microtime();
	$end=explode(" ",$end);
	$end=$end[1]+$end[0];
	
	printf("%f\n",$end-$start);
}


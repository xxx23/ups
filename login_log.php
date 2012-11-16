<?php


MongoCursor::$timeout = -1;
$m = new Mongo();
$db = $m->elearning;
$login_log = $db->login_log;

$ip = '140.123.230.133';
$limit = 100000;
$start=microtime();
$start=explode(" ",$start);
$start=$start[1]+$start[0]; 

for($i = 0; $i < $limit; $i++)
{
	$pid = mt_rand(1, $limit);
	$login_log->insert(array('p' => intval($pid), 'l' => new MongoDate(), 'i' => $ip));
}

$end=microtime();
$end=explode(" ",$end);
$end=$end[1]+$end[0];

printf("%f\n",$end-$start);


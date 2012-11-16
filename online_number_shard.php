<?php

MongoCursor::$timeout = -1;

$m = new Mongo();
$db = $m->elearning;
$online_number_s = $db->online_number_s;
$list = array();

$limit = 300000;
$index = $limit;
$fd = fopen("/tmp/randomData", "r");
for($i = 0; $i < $limit; $i++)
{
	$list[] = intval(fgets($fd, 1024));
}
if($argc == 2 && $argv[1] == '-s')
{
	$isSafe = true;
}
else
{
	$isSafe = false;
}

$start=microtime();
$start=explode(" ",$start);
$start=$start[1]+$start[0]; 
for($i = 0; $i < $limit; $i++)
{
	$id = $list[$i];
	// $mid = (string)$id . $mid;
	$data = array(
		'_id' => $id,
		'pid' => $id,
		'h' => '127.0.0.1',
		't' => new MongoDate(),
		'idle' => new MongoDate(),
		'ss' => '登入系統'
	);
	$online_number_s->insert($data, $isSafe);
}
$_limit = $limit * 3;
while($online_number_s->count() != $_limit)
{
	sleep(1);
}
sleep(5); // The balancer may delay
while($online_number_s->count() != $_limit)
{
	sleep(1);
}
$end=microtime();
$end=explode(" ",$end);
$end=$end[1]+$end[0];

printf("%f\n",$end - $start - 5);


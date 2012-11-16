<?php

$DB_USERNAME = "hsng";
$DB_USERPASSWORD = "ringline";

$m = new Mongo("mongodb://${DB_USERNAME}:${DB_USERPASSWORD}@localhost/elearning");

// $m = new Mongo("mongodb://localhost:27017");
$db = $m->elearning;
$online_number = $db->online_number;
$list = array();

$limit = 1000000;
$index = $limit;
for($i = 1; $i <= $limit; $i++)
{
	$list[$i] = $i;
}
$start=microtime();
$start=explode(" ",$start);
$start=$start[1]+$start[0]; 
for($i = 0; $i < $limit; $i++)
{
	$tmp = intval(rand(1,$index));
	$id = $list[$tmp];
	$list[$tmp] = $list[$index];
	$index--;
	// $mid = new MongoId();
	$online_number->insert(array('_id' => intval($id), 'pid' => intval($id), 'h' => '127.0.0.1', 't' => new MongoDate(), 'idle' => new MongoDate(), 'ss' => '登入系統'));
	// $id = intval(rand(1,10000000));
	// $online_number->insert(array('_id' => $id, 'pid' => $id, 'h' => '127.0.0.1', 't' => new MongoDate(), 'idle' => new MongoDate(), 'ss' => '登入系統'));
}
$end=microtime();
$end=explode(" ",$end);
$end=$end[1]+$end[0];

printf("%f seconds\n",$end-$start);


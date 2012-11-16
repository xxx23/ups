<?php

$DB_USERNAME = "hsng";
$DB_USERPASSWORD = "ringline";

$m = new Mongo("mongodb://${DB_USERNAME}:${DB_USERPASSWORD}@localhost/elearning");

// $m = new Mongo("mongodb://localhost:27017");
$db = $m->elearning;
$online_number = $db->online_number;
$start=microtime();
$start=explode(" ",$start);
$start=$start[1]+$start[0]; 
for($i = 0; $i < 10; $i++)
{
	//$online_number->find(array('_id' => new MongoId('506c6931b0a3a4a214000002')));
	$c = $online_number->find(array('_id' => intval(rand(1,2000000))));
	// $c->getNext();
	foreach($c as $r)
	{

	}
}
$end=microtime();
$end=explode(" ",$end);
$end=$end[1]+$end[0];

// printf("one shard: %f seconds\n",$end-$start);

// $online_number_s = $db->online_number_s;
// $start=microtime();
// $start=explode(" ",$start);
// $start=$start[1]+$start[0]; 
// for($i = 0; $i < 100000; $i++)
// {
// 	//$online_number_shard->find(array('_id' => new MongoId('506c6876b0a3a42a14000008')));
// 	$c = $online_number_s->find(array('_id' => intval(rand(1,2000000))));
// 	// $c->getNext();
// 	foreach($c as $r)
// 	{
// 
// 	}
// }
// $end=microtime();
// $end=explode(" ",$end);
// $end=$end[1]+$end[0];
// 
// printf("three shards: %f seconds\n",$end-$start);


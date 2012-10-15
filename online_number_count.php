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
for($i = 0; $i < 100000; $i++)
{
	$online_number->count();
}
$end=microtime();
$end=explode(" ",$end);
$end=$end[1]+$end[0];

printf("one shard %f seconds\n",$end-$start);

$online_number_s = $db->online_number_s;
$start=microtime();
$start=explode(" ",$start);
$start=$start[1]+$start[0]; 
for($i = 0; $i < 100000; $i++)
{
	$online_number_s->count();
}
$end=microtime();
$end=explode(" ",$end);
$end=$end[1]+$end[0];

printf("three shards %f seconds\n",$end-$start);


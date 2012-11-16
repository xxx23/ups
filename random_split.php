<?php
/*
 * 用來將90萬筆資料切開成chunk用的程式
 *
 */

MongoCursor::$timeout = -1;
$DB_USERNAME = "hsng";
$DB_USERPASSWORD = "ringline";

$m = new Mongo("mongodb://localhost/elearning");
$admin = $m->admin;
$db = $m->elearning;
$limit = 900000;

$tableList = $db->listCollections();
if(in_array('elearning.online_number_s', $tableList)) // If exist, then drop it
{
	$online_number_s = $db->online_number_s;
	$res = $online_number_s->drop();
	while($res['ok'] != 1)
	{
		sleep(5);
		$res = $online_number_s->drop();
	}
	sleep(1);
}

//////////////////////////

$cmd = array(
	'shardCollection'=> 'elearning.online_number_s',
	'key'=> array('_id'=> 1)
);
$res = $admin->command($cmd);
if($res['ok'] != 1)
{
	var_dump($res);
	die("shard collection fail\n");
}
sleep(1);

//////////////////////////

if($argc == 2 && $argv[1] == '-c')
{
	$range = $limit / 9;
	for($i = 0; $i < 8; $i++)
	{
		$split = array(
			'split' => 'elearning.online_number_s',
			'middle' => array('_id' => ($i + 1) * $range)
		);
		$admin->command($split);
	
		$shardName = 'shard000' . strval(intval($i / 3));
		$move = array(
			'moveChunk' => 'elearning.online_number_s',
			'find' => array('_id' => ($i + 1) * $range),
			'to' => $shardName
		);
		$admin->command($move);
	}
}
echo "finish\n";

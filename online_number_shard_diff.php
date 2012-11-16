<?php
/*
 * 用來比較insert有沒有presplit和safe的差別
 *
 */
MongoCursor::$timeout = -1;
$DB_USERNAME = "hsng";
$DB_USERPASSWORD = "ringline";
$list = array();
$_list = array(); // Store first random select result
$limit = 1000000;
$index = $limit;

//$m = new Mongo("mongodb://${DB_USERNAME}:${DB_USERPASSWORD}@localhost/elearning");
$m = new Mongo("mongodb://localhost/elearning");

for($i = 1; $i <= $limit; $i++)
{
	$list[$i] = $i;
}
for($i = 0; $i < $limit; $i++)
{
	$tmp = intval(mt_rand(1,$index));
	$_list[$i] = $list[$tmp];
	$list[$tmp] = $list[$index];
	$index--;
}
// $m = new Mongo("mongodb://localhost:27017");
for($ii = 0; $ii < 20; $ii++)
{
	$db = $m->elearning;
	$admin = $m->admin;
	$online_number_s = $db->online_number_s;

	mDrop($db);
	// printf("\nafter drop\n");
	sleep(5);
	mShard($admin);
	sleep(5);
	while($online_number_s->count() != 0)
	{
		sleep(1);
	}
	// printf("\n0 now\n");
	$r1 = mInsert($online_number_s, $_list, $limit, false);
	printf("%f", $r1);
	sleep(10);

	/////////////////////////////////////////////
	mDrop($db);
	// printf("\nafter drop\n");
	sleep(5);
	mShard($admin);
	sleep(5);
	mSplit($admin, $limit);
	sleep(5);
	while($online_number_s->count() != 0)
	{
		sleep(1);
	}
	// printf("\n0 now\n");
	$r2 = mInsert($online_number_s, $_list, $limit, false);
	printf(",%f", $r2);
	sleep(10);

	//////////////////////////////////////////////
	
	mDrop($db);
	sleep(5);
	mShard($admin);
	sleep(5);
	while($online_number_s->count() != 0)
	{
		sleep(1);
	}
	$r1 = mInsert($online_number_s, $_list, $limit, true);
	printf(",%f", $r1);
	sleep(10);

	// /////////////////////////////////////////////

	mDrop($db);
	sleep(5);
	mShard($admin);
	sleep(5);
	mSplit($admin, $limit);
	sleep(5);
	while($online_number_s->count() != 0)
	{
		sleep(1);
	}
	$r2 = mInsert($online_number_s, $_list, $limit, true);
	printf(",%f", $r2);
	sleep(10);

	printf("\n");
}

function mDrop($db)
{
	$tableList = $db->listCollections();
	if(in_array('elearning.online_number_s', $tableList)) // If exist, then drop it
	{
		$online_number_s = $db->online_number_s;
		$res = $online_number_s->drop();
		while($res['ok'] != 1)
		{
			sleep(5);
			$res = $online_number_s->drop();
			// var_dump($res);
			// die("drop collection: online_number_s fail\n");
		}
		sleep(1);
	}
}

function mShard($admin)
{
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
}

function mInsert($online_number_s, $_list, $limit, $safe)
{
	$start=microtime();
	$start=explode(" ",$start);
	$start=$start[1]+$start[0]; 
	for($i = 0; $i < $limit; $i++)
	{
		$data = array(
			'_id' => $_list[$i],
			'pid' => $_list[$i],
			'h' => '127.0.0.1',
			't' => new MongoDate(),
			'idle' => new MongoDate(),
			'ss' => '登入系統'
		);
		($safe == false) ? $online_number_s->insert($data): $online_number_s->insert($data, true);
	}
	while($online_number_s->count() != $limit)
	{
		sleep(1);
	}
	sleep(5); // The balancer may delay
	while($online_number_s->count() != $limit)
	{
		sleep(1);
	}
	$end=microtime();
	$end=explode(" ",$end);
	$end=$end[1]+$end[0];
	$r1 = $end - $start - 5;

	return $r1;
}

function mSplit($admin, $limit)
{
	$range = $limit / 10;
	for($i = 0; $i < 9; $i++)
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

function mRemove($online_number_s)
{
	$res = $online_number_s->remove(array(), array('safe' => true));
	if($res['ok'] != 1)
	{
		var_dump($res);
		die("online_number_s remove fail\n");
	}
}


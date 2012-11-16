<?
$DB_USERNAME = "hsng";
$DB_USERPASSWORD = "ringline";

$m = new Mongo("mongodb://${DB_USERNAME}:${DB_USERPASSWORD}@localhost/elearning");

$admin = $m->admin;
$range = 100000;
for($i = 0; $i < 9; $i++)
{
	$split = array(
		'split' => 'elearning.online_number_s',
		'middle' => array('_id' => ($i + 1) * $range)
	);
	$res = $admin->command($split);

	$shardName = 'shard000' . strval(intval($i / 3));
	$move = array(
		'moveChunk' => 'elearning.online_number_s',
		'find' => array('_id' => ($i + 1) * $range),
		'to' => $shardName
	);
	$res = $admin->command($move);
}


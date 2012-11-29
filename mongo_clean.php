<?php

$m = new Mongo();
$admin = $m->admin;
$db = $m->elearning;

$popularity_noip = $db->popularity_noip;
$popularity_noip->remove();

$login_log = $db->login_log;
$login_log->drop();
$cmd = array(
	'shardCollection'=> 'elearning.login_log',
	'key'=> array('_id'=> 1)
);
$res = $admin->command($cmd);
if($res['ok'] != 1)
{
	var_dump($res);
	die("shard collection login_log fail\n");
}
sleep(1);

$online_number = $db->online_number;
$online_number->remove();

$student_learning = $db->student_learning;
$student_learning->drop();
$cmd = array(
	'shardCollection'=> 'elearning.student_learning',
	'key'=> array('b'=> 1, 'c'=>1, 'p'=>1, 'm'=>1)
);
$res = $admin->command($cmd);
if($res['ok'] != 1)
{
	var_dump($res);
	die("shard collection student_learning fail\n");
}
echo "OK\n";

?>

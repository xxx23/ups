<?php


$DB_TYPE = "mysql";
$DB_HOST = "mysql1";
$DB_NAME = "elearning";
$DB_USERNAME = "hsng";
$DB_USERPASSWORD = "ringline";

$DB_HOST = 'mysql-proxy';
$DB_CONN = new mysqli($DB_HOST, $DB_USERNAME, $DB_USERPASSWORD, $DB_NAME, 4040);
if($DB_CONN->connect_errno) 
{
	printf("Connect failed: %s\n", $DB_CONN->connect_error);
	die();
}

$ip = '140.123.230.133';
$limit = 100;
$limit2 = 10000;
$TIME = false;

if($TIME)
{
	$start=microtime();
	$start=explode(" ",$start);
	$start=$start[1]+$start[0]; 
}

$pid = mt_rand(1, $limit2);
if(!isset($_SESSION))
	session_start();
$_SESSION['personal_id'] = $pid;
for($i = 0; $i < $limit; $i++)
{
	// $pid = mt_rand(1, $limit2);
	// if(!isset($_SESSION))
	// 	session_start();
	// $_SESSION['personal_id'] = $pid;
	$sql = "INSERT INTO `login_log` (`pid`, `login_time`, ` ip`) VALUES ('$pid', CURRENT_TIMESTAMP, '$ip');";
	$r = $DB_CONN->query($sql);
}

if($TIME)
{
	$end=microtime();
	$end=explode(" ",$end);
	$end=$end[1]+$end[0];
	
	printf("%f\n",$end-$start);
	
}

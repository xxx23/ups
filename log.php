<?php

$file = "/tmp/action.log";
if(!$fd = fopen($file, "a"))
{
	echo "Cannot open file ($file)";
	exit(1);
}
session_start();
$sid = $_SESSION['personal_id'];
if($sid == NULL) $sid = 0;
//$sid = session_id();
//$sid = SID;
$ip = $_SERVER['REMOTE_ADDR'];
$url = $_SERVER['REQUEST_URI'];
$s = sprintf("%s %s %s\n", $sid, $ip, $url);
if(fwrite($fd, $s) == false)
{
	echo "Cannot write to file ($file)";
}
fclose($fd);


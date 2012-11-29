<?php
$DB_TYPE = "mysql";
$DB_HOST = "mysql1";
$DB_NAME = "elearning";
$DB_USERNAME = "hsng";
$DB_USERPASSWORD = "ringline";

$DB_HOST = '10.1.1.205';
$DB_CONN = new mysqli($DB_HOST, $DB_USERNAME, $DB_USERPASSWORD, $DB_NAME, 4040);
if($DB_CONN->connect_errno) 
{
	printf("Connect failed: %s\n", $DB_CONN->connect_error);
	die();
}

$sql = "delete from popularity_noip";
$DB_CONN->query($sql);

$sql = "delete from login_log";
$DB_CONN->query($sql);

$sql = "delete from online_number";
$DB_CONN->query($sql);

$sql = "delete from student_learning";
$DB_CONN->query($sql);

echo "ok\n";
?>

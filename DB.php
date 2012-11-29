<?php

$hostname = gethostname();
if(strstr($hostname, 'mongo') != false)
{
	$USE_MYSQL = false;
}
else
{
	$USE_MYSQL = true;
}

$USE_MONGODB = !$USE_MYSQL;

$DB_TYPE = "mysql";
$DB_HOST = "mysql1";
$DB_NAME = "elearning";
$DB_USERNAME = "hsng";
$DB_USERPASSWORD = "ringline";


if($USE_MYSQL)
{
	// $DB_HOST = 'mysql-proxy';
	$DB_HOST = '10.1.1.205';
	$DB_CONN = new mysqli($DB_HOST, $DB_USERNAME, $DB_USERPASSWORD, $DB_NAME, 4040);
	if($DB_CONN->connect_errno) 
	{
		printf("Connect failed: %s\n", $DB_CONN->connect_error);
		die();
	}
}
else if($USE_MONGODB)
{
	if(isset($MONGO_ONLY) && $MONGO_ONLY != true)
	{
		$DB_HOST = '10.1.1.205';
		// var_dump(gethostname());
		$DB_CONN = new mysqli($DB_HOST, $DB_USERNAME, $DB_USERPASSWORD, $DB_NAME, 4040);
		if($DB_CONN->connect_errno) 
		{
			printf("Connect failed: %s\n", $DB_CONN->connect_error);
			die();
		}
	}
	MongoCursor::$timeout = -1;
	if(!isset($MONGOS) || $MONGOS)
	{
		$m = new Mongo();
	}
	else
	{
		$m = new Mongo("mongodb://10.1.1.3:27018", array('timeout' => 2000));
	}
	// $m = new Mongo("mongodb://localhost:27017", array('timeout' => 2000));
	// $m = new Mongo("mongodb://127.0.0.1:27017", array('timeout' => 2000));
	//$m = new Mongo("mongodb://mongo1:27018", array('timeout' => 2000));
	$db = $m->elearning;
	// $db->authenticate($DB_USERNAME, $DB_USERPASSWORD);
}

?>

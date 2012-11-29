<?php
/*
 * 最後整合測試！！
 */

// $start=microtime();
// $start=explode(" ",$start);
// $start=$start[1]+$start[0]; 
$hostname = gethostname();
if(strstr($hostname, 'mongo') != false)
{
	$USE_MYSQL = false;
}
else
{
	$USE_MYSQL = true;
}

for($zz = 0; $zz < 1; $zz++)
{

	require('index.php');
	
	if($USE_MYSQL == false)
	{
		require('login_log.php');
	}
	else
	{
		require('login_log2.php');
	}
	
	require('Online/online2_test.php');
	
	require('System_News/systemNews_homeShowList.php');
	
	require('Teaching_Material/stu_start.php');

	require('Online/online2_test.php');
	
}

// $end=microtime();
// $end=explode(" ",$end);
// $end=$end[1]+$end[0];
// printf("%f\n",$end-$start);

?>

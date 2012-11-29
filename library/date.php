<?php
	//將字串格式的字串轉成秒數 zqq
	//用來比較時間
	function str_to_time($str_time)
	{
		$year	=0+substr($str_time,0,4);
		$month	=0+substr($str_time,5,2);
		$day	=0+substr($str_time,8,2);
		$hour	=0+substr($str_time,11,2);
		$min	=0+substr($str_time,14,2);
		$sec	=0+substr($str_time,17,2);	
		return mktime($hour,$min,$sec,$month,$day,$year);	
	}
	//取得現在的時間並將其轉為秒數回傳 zqq
	function get_now_time_total_second()
	{
		$date_n	= getdate();
		$year	= $date_n['year'];
		$month	= $date_n['mon'];
		$day	= $date_n['mday'];
		$hour	= $date_n['hours'];
		$min	= $date_n['minutes'];
		$sec	= $date_n['seconds'];			
		return mktime($hour,$min,$sec,$month,$day,$year);
	}

	//取得現在時間 轉成 字串 zqq
	function get_now_time_str()
	{
		$date_n	= getdate();
		$year	= $date_n['year'];
		$month	= $date_n['mon'];
		$day	= $date_n['mday'];
		$hour	= $date_n['hours'];
		$min	= $date_n['minutes'];
		$sec	= $date_n['seconds'];			
		return date("Y-m-d H:i:s",mktime($hour,$min,$sec,$month,$day,$year));
	}
?>

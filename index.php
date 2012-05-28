<?php

/*! @mainpage
 *
 * 教育部數位學習平台 2.0版
 */

       if(!file_exists('config.php') ||  filesize('config.php') == 0 ){
		header('location: Install/install1.php');
		return ;
	}

	include("config.php");

    //只要有人連到首頁 計數器+1
    
    //取得系統時間
    $date = date("Y-m-d");
    $month = date("Y-m");

	if($USE_MYSQL)
	{
		$Q1 = "select * from popularity_noip where date = '$date'";
		$result = mysql_db_query ($DB_NAME, $Q1);
		$row = mysql_fetch_array ($result);
		$p_today = $row["num"];

		//本日人氣
		if($p_today == 0)
		{
			$Q2 = "insert into popularity_noip (date, num) values ('$date', '1')";
			$res = db_query($Q2);
			$p_today++;
		}
		else
		{
			$p_today++;
			$Q2 = "update popularity_noip set num = '$p_today' where date = '$date'";
			$res = db_query($Q2);
		}

		//本月人氣
		$Q3 = "SELECT SUM(num) from popularity_noip where date like '$month%'";
		$p_month = db_getOne($Q3);

		//總人氣
		$Q4 = "SELECT sum(num) FROM popularity_noip";
		$p_total = db_getOne($Q4);

	}
	else if($USE_MONGODB)
	{
		$popularity_noip = $db->popularity_noip;
		$row = $popularity_noip->findOne(array("date" => $date));
		$p_today = $row["num"];

		if($p_today == 0)
		{
			$popularity_noip->insert(array("date" => $date, "num" => "1"));
			$p_today++;
		}
		else
		{
			$p_today++;
			// TODO use mongo query
			//$popularity_noip->update(array("date" => $date), array())
			$Q2 = "update popularity_noip set num = '$p_today' where date = '$date'";
			$res = db_query($Q2);
		}

		//本月人氣
		// TODO use mongo query
		$Q3 = "SELECT SUM(num) from popularity_noip where date like '$month%'";
		$p_month = db_getOne($Q3);

		//總人氣
		// TODO use mongo query
		$Q4 = "SELECT sum(num) FROM popularity_noip";
		$p_total = db_getOne($Q4);
	}

    $tpl = new Smarty();
    $tpl->assign("UPS_ONLY", $UPS_ONLY);
	$tpl->assign("p_today", $p_today);
	$tpl->assign("p_month", $p_month);
	$tpl->assign("p_total", $p_total);
    $tpl->assign("HOST",$HOST);
    $tpl->display("index.tpl");


?>

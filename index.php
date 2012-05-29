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


		// 1. lock version
		$Q2 = "INSERT INTO popularity_noip (date, num) VALUES ('$date', '1') ON DUPLICATE KEY UPDATE num=num+1";
		db_query($Q2);

		// 2. without lock version
		// //本日人氣
		// if($p_today == 0)
		// {
		// 	$Q2 = "insert into popularity_noip (date, num) values ('$date', '1')";
		// 	$res = db_query($Q2);
		// 	$p_today++;
		// }
		// else
		// {
		// 	$p_today++;
		// 	$Q2 = "update popularity_noip set num = '$p_today' where date = '$date'";
		// 	$res = db_query($Q2);
		// }

		///////////////////////////////////

		//本月人氣
		$Q3 = "SELECT SUM(num) from popularity_noip where date like '$month%'";
		$p_month = db_getOne($Q3);

		//總人氣
		$Q4 = "SELECT sum(num) FROM popularity_noip";
		$p_total = db_getOne($Q4);

	}
	else if($USE_MONGODB)
	{
		// 1. lock version
		$popularity_noip = $db->popularity_noip;

		$row = $popularity_noip->findOne(array('date' => $date));
		$p_today = $row['num'];

		$p = $popularity_noip->update(array('date' => $date), array('$inc' => array('num' => 1)), true);


		// 2. without lock version
		// $row = $popularity_noip->findOne(array('date' => $date));
		// $p_today = $row['num'];
		// if($p_today == 0)
		// {
		// 	$popularity_noip->insert(array('date' => $date, 'num' => '1'));
		// 	$p_today++;
		// }
		// else
		// {
		// 	$p_today++;
		// 	$popularity_noip->update(array('date' => $date), array('$set' => array('num' => $p_today)));
		// }

		//////////////////

		$map = new MongoCode('function(){emit("total", this.num);}');
		$reduce = new MongoCode('function(key, values){var sum = 0; values.forEach(function(value){sum+=value;});return sum;}');

		//本月人氣
		$query = new MongoRegex("/^$month/");
		$Q3 = array(
			'mapreduce' => 'popularity_noip',
			'map' => $map,
			'reduce' => $reduce,
			'query' => array('date' => $query),
			'out' => array('inline' => '1'),
		);
		$p = $db->command($Q3);
		$p_month = $p['results'][0]['value'];

		// //總人氣
		$Q4 = array(
			'mapreduce' => 'popularity_noip',
			'map' => $map,
			'reduce' => $reduce,
			'out' => array('inline' => '1'),
		);
		$p = $db->command($Q4);
		$p_total = $p['results'][0]['value'];
	}

    $tpl = new Smarty();
    $tpl->assign("UPS_ONLY", $UPS_ONLY);
	$tpl->assign("p_today", $p_today);
	$tpl->assign("p_month", $p_month);
	$tpl->assign("p_total", $p_total);
    $tpl->assign("HOST",$HOST);
    $tpl->display("index.tpl");


?>

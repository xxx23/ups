<?php

$MONGO_ONLY = true;
$MONGOS = false;

if(!file_exists('config.php') ||  filesize('config.php') == 0 ){
	header('location: Install/install1.php');
	return ;
}

$TIME = false;
$limit = 100;

require_once("config.php");
require('DB.php');

//只要有人連到首頁 計數器+1

//取得系統時間
$date = date("Y-m-d");
$month = date("Y-m");

if($TIME)
{
	$start=microtime();
	$start=explode(" ",$start);
	$start=$start[1]+$start[0]; 
}
for($i = 0; $i < $limit; $i++)
{

	if($USE_MYSQL)
	{
	
		// 1. lock version
		$Q2 = "INSERT INTO popularity_noip (date, num) VALUES ('$date', '1') ON DUPLICATE KEY UPDATE num=num+1";
		db_query($Q2);
	
		$Q1 = "select num from popularity_noip where date = '$date'";
		$p_today = db_getOne($Q1);
		// 2. without lock version
		// //本日人氣
		// if($p_today == 0)
		// {
		//	 $Q2 = "insert into popularity_noip (date, num) values ('$date', '1')";
		//	 $res = db_query($Q2);
		//	 $p_today++;
		// }
		// else
		// {
		//	 $p_today++;
		//	 $Q2 = "update popularity_noip set num = '$p_today' where date = '$date'";
		//	 $res = db_query($Q2);
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
	
	
		$p = $popularity_noip->update(array('_id' => $date), array('$inc' => array('n' => 1)), array('upsert' => true, 'safe' => false));
		$row = $popularity_noip->findOne(array('_id' => $date), array('n'));
		$p_today = $row['n'];
	
		// 2. without lock version
		// $row = $popularity_noip->findOne(array('_id' => $date));
		// $p_today = $row['n'];
		// if($p_today == 0)
		// {
		//	 $popularity_noip->insert(array('_id' => $date, 'n' => '1'));
		//	 $p_today++;
		// }
		// else
		// {
		//	 $p_today++;
		//	 $popularity_noip->update(array('_id' => $date), array('$set' => array('n' => $p_today)));
		// }
	
		//////////////////
	
		// $map = new MongoCode('function(){emit("total", this.num);}');
		// $reduce = new MongoCode('function(key, values){var sum = 0; values.forEach(function(value){sum+=value;});return sum;}');
	
		// //本月人氣
		// $regex = new MongoRegex("/^$month/");
		$Q3 = array(
			array('$match' => array('_id' => array('$regex' => "$month"))),
			array('$group' => array('_id' => null, 'count' => array('$sum' => '$n')))
		);
		$result = $db->command(
			array(
				'aggregate' => 'popularity_noip',
				'pipeline' => $Q3
			)
		);
		$p_month = $result['result'][0]['count'];
		// $query = new MongoRegex("/^$month/");
		// $Q3 = array(
		//	 'mapreduce' => 'popularity_noip',
		//	 'map' => $map,
		//	 'reduce' => $reduce,
		//	 'query' => array('date' => $query),
		//	 'out' => array('inline' => '1'),
		// );
		// $p = $db->command($Q3);
		// $p_month = $p['results'][0]['value'];
	
		// // //總人氣
		$Q4 = array(
			array('$group' => array('_id' => null, 'count' => array('$sum' => '$n')))
		);
		$result = $db->command(
			array(
				'aggregate' => 'popularity_noip',
				'pipeline' => $Q3
			)
		);
		$p_total = $result['result'][0]['count'];
		// $Q4 = array(
		//	 'mapreduce' => 'popularity_noip',
		//	 'map' => $map,
		//	 'reduce' => $reduce,
		//	 'out' => array('inline' => '1'),
		// );
		// $p = $db->command($Q4);
		// $p_total = $p['results'][0]['value'];
	
	}
}
if($TIME)
{
	$end=microtime();
	$end=explode(" ",$end);
	$end=$end[1]+$end[0];
	printf("%f\n",$end-$start);
}
// $tpl = new Smarty();
// $tpl->assign("UPS_ONLY", $UPS_ONLY);
// $tpl->assign("p_today", $p_today);
// $tpl->assign("p_month", $p_month);
// $tpl->assign("p_total", $p_total);
// $tpl->assign("HOST",$HOST);
// $tpl->display("index.tpl");


?>

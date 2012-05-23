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

	/***************************************/
	/* Author :   w60292                   */
	/* Function : Calculate the popularity */
	/* Date :     2009.09.27               */
	/***************************************/

    /*
    //根據IP位址來計數
	$Q1 = "select * from popularity";
	$res = $DB_CONN->query($Q1);
	if (PEAR::isError($res))        die($res->getMessage());
	$resultNum = $res->numRows();

	//取得上線ip
	$ip = getenv("REMOTE_ADDR");
	if ( $ip == "" )
	  $ip = $HTTP_X_FORWARDED_FOR;
	if ( $ip == "" )
	  $ip = $REMOTE_ADDR;

	//取得系統時間
	$date = date("Y-m-d");
	$month = date("Y-m");

	if($resultNum == 0)
	{
	  $Q2 = "insert into popularity (ip_addr, date) values ('$ip', '$date')";
	  $res = $DB_CONN->query($Q2);
	  if (PEAR::isError($res))        die($res->getMessage());
	}
	else if($resultNum > 0)
	{
	  $Q3 = "select * from popularity where ip_addr = '$ip' and date = '$date'";
	  $res = $DB_CONN->query($Q3);
	  if (PEAR::isError($res))        die($res->getMessage());
	  $todayNum = $res->numRows();
	  if($todayNum == 0)
	  {
	    $Q4 = "insert into popularity (ip_addr, date) values ('$ip', '$date')";
	    $res = $DB_CONN->query($Q4);
	    if (PEAR::isError($res))        die($res->getMessage());
	  }
	}
 
	//總人氣
	$Q5 = "select MAX(sid) as MAX_sid from popularity";
	mysql_connect($DB_HOST, $DB_USERNAME, $DB_USERPASSWORD);
	$result = mysql_db_query ($DB_NAME, $Q5);
	$row = mysql_fetch_array ($result);
	$p_total = $row["MAX_sid"];
	
	//本日人氣
	$Q6 = "select count(*) as today from popularity where date = '$date'";
	$result1 = mysql_db_query ($DB_NAME, $Q6);
	$row1 = mysql_fetch_array ($result1);
	$p_today = $row1["today"];

	//本月人氣
	$Q7 = "select count(*) as month from popularity where date like '$month%'";
        $result2 = mysql_db_query ($DB_NAME, $Q7);
        $row2 = mysql_fetch_array ($result2);
        $p_month = $row2["month"];
    */

    //只要有人連到首頁 計數器+1
    
    //取得系統時間
    $date = date("Y-m-d");
    $month = date("Y-m");

    //mysql_connect($DB_HOST, $DB_USERNAME, $DB_USERPASSWORD);

    $Q1 = "select * from popularity_noip where date = '$date'";
    $result = mysql_db_query ($DB_NAME, $Q1);
    $row = mysql_fetch_array ($result);
    $p_today = $row["num"];

    //本日人氣
    if($p_today == 0)
    {
        $Q2 = "insert into popularity_noip (date, num) values ('$date', '1')";
        $res = $DB_CONN->query($Q2);
        if (PEAR::isError($res))        die($res->getMessage());
        $p_today++;
    }
    else
    {
        $p_today++;
        $Q2 = "update popularity_noip set num = '$p_today' where date = '$date'";
        $res = $DB_CONN->query($Q2);
        if (PEAR::isError($res))        die($res->getMessage());
    }

    //本月人氣
    $Q3 = "SELECT SUM(num) from popularity_noip where date like '$month%'";
    $p_month = db_getOne($Q3);

    //總人氣
    $Q4 = "SELECT sum(num) FROM popularity_noip";
    $p_total = db_getOne($Q4);

    $tpl = new Smarty();
    $tpl->assign("UPS_ONLY", $UPS_ONLY);
	$tpl->assign("p_today", $p_today);
	$tpl->assign("p_month", $p_month);
	$tpl->assign("p_total", $p_total);
    $tpl->assign("HOST",$HOST);
    $tpl->display("index.tpl");


?>

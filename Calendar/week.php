<?php
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");

	//new smarty
	$tpl = new Smarty();

	$selectedYear = "";
	$this_week = ""; 
	if(isset($_GET['action']) && isset($_GET['valueW'])){
		$selectedYear = $_GET['valueY'];
		if( "add" == $_GET['action'])
			$this_week = $_GET['valueW'] + 1;
		else
			$this_week = $_GET['valueW'] - 1;
	}
	else{
		//取得今天的日期
		$selectedDay = date('d');
		$selectedMonth = date('m');
		$selectedYear = date('Y');
		$which_day = date('z',mktime(0,0,0,$selectedMonth, $selectedDay, $selectedYear ) );	
		//選定的是第幾週
		$this_week = ceil(($which_day + $_1_1_week) / 7);
	}
	//一年第一天是星期幾
	$_1_1_week = date('w',mktime(0, 0, 0, 1, 1, $selectedYear ) );
	//這週的第一天 是一年中的第幾天
	$sunday = ( $this_week - 1 ) * 7 - $_1_1_week;

	//輸出 年月 週
	$tpl->assign("year", $selectedYear);
	$tpl->assign("week", $this_week);

	//輸出
	for($i=0; $i<7; $i++){
		$month = date('m',mktime(0, 0, 0, 1, 1 + $sunday+$i, $selectedYear ) );
		$day = date('j',mktime(0, 0, 0, 1, 1 + $sunday+$i, $selectedYear ) );
		$date = $month . "/" .$day;
		$data[$i] =  $date;
	}
	$tpl->append('data', $data);

	//輸出頁面
	assignTemplate($tpl, "/calendar/week.tpl");	

	//library
	function returnSunday(){
		global $selectedYear, $this_week;
	}
?>

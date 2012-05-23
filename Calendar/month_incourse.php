<?php
/*

不確定這支程式到底有沒有在用，原本以為是個人行事曆(左邊的小行事曆)
不過個人小行事曆應該是 calendar.php


*/
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	//new smarty
	$tpl = new Smarty();
	
	if(isset($_GET[action]) && isset($_GET[target]) && isset($_GET[valueY]) && isset($_GET[valueM]) ){
		//取得選取的日期
		if("year" == $_GET[target]){
			if( "add" == $_GET[action]){
				$selectedMonth = $_GET[valueM];
				$selectedYear = $_GET[valueY]+1;				
			}
			else{
				$selectedMonth = $_GET[valueM];
				$selectedYear = $_GET[valueY]-1;				
			}
				
		}else{
			if( "add" == $_GET[action]){
				if( $_GET[valueM]+1 > 12){
					$selectedMonth = 1;
					$selectedYear = $_GET[valueY]+1;					
				}
				else{
					$selectedMonth = $_GET[valueM]+1;
					$selectedYear = $_GET[valueY];				
				}
			}
			else{
				if( $_GET[valueM]-1 < 1){
					$selectedMonth = 12;
					$selectedYear = $_GET[valueY]-1;					
				}
				else{
					$selectedMonth = $_GET[valueM]-1;
					$selectedYear = $_GET[valueY];				
				}	
			}					
		}	
	}
	else if(!isset($_GET[action]) && !isset($_GET[target]) && isset($_GET[sel_year]) && isset($_GET[sel_month]) && isset($_GET[sel_day])){
		$selectedDay = $_GET[sel_day];
		$selectedMonth = $_GET[sel_month];
		$selectedYear = $_GET[sel_year];	
	}
	else{	
		//取得今天的日期
		$selectedDay = date('j');
		$selectedMonth = date('m');
		$selectedYear = date('Y');
	}
	//今天
	if( $selectedYear == date('Y') && $selectedMonth == date('m')){
		$today = date('j');
		if($selectedDay == '')	$selectedDay = $today;		
	}	
		
	$todayMonth = date('m');
	$todayYear = date('Y'); 
	//輸出 年月
	$selectedMonth = sprintf("%d",$selectedMonth);
	$selectedYear = sprintf("%d",$selectedYear);
	$tpl->assign("year", $selectedYear);
	$tpl->assign("month", $selectedMonth);	
	//取得當月的第一天是星期幾
	$firstday = date('w',mktime(0,0,0,$selectedMonth,1,$selectedYear));
	//取得當月的最後一天
	$lastday = 31;
	do{
		$monthOrig = date('m',mktime(0,0,0,$selectedMonth,1,$selectedYear));
		$monthTest = date('m',mktime(0,0,0,$selectedMonth,$lastday,$selectedYear));
		if($monthTest != $monthOrig){$lastday -= 1;}
	}while($monthTest != $monthOrig);
	$dayRow = 0;
	$day = 0;
	$week;
	while(true){
		
		if(($dayRow % 7) == 0){
			$count = 0;
			$tpl->append('week', $week);
			if($day >= $lastday)
				break;
		}
		if($dayRow < $firstday){
			$week[$count] = "<td class=\"previous\" >&nbsp;</td>";
		}
		else if( $day >= $lastday){
			$week[$count] = "<td class=\"next\" >&nbsp;</td>";
		}	
		else{			//onclick=\"setNote(this,".$selectedYear.",".$selectedMonth.",".$adjusted_day." , '0');\" 
			$adjusted_day = $day + 1;
			//查出有紀錄的

			/* 
			 * 以下是在 "個人頁面" (左邊的小行事曆) (在課程以外)
			 *
			 */
				//在"個人頁面"的行事曆，因為不是在課程中看的行事曆，所以沒有與課程有關的 event
				// ***(20080817 update:現在要改成個人全部的課程都要在裡面也有) ***
				//利用有沒有 $_SESSION['begin_course_cd'] 來判斷
			
				//先查該名老師所開的全部的課程
				//update 20080917:好像用不到了 
				//$sql0 = " SELECT begin_course_cd FROM teach_begin_course  WHERE personal_id='{$_SESSION['personal_id']}' ";

				$sql0 = "drop table if exists temptable;";
				db_query($sql0);

			$sql1 = "CREATE TEMPORARY TABLE temptable
				SELECT * FROM calendar WHERE personal_id='{$_SESSION['personal_id']}'
				AND year='".$selectedYear."' 
				AND month='".$selectedMonth."' 
				AND day='".$adjusted_day."'";
			db_query($sql1);

				//應該是插入作業用的部份
				//mtime 的部份應該用不到，先隨便給一個值
				//需要一個 unique id 做為 calendar_id ，在顯示日曆時會用得到這個 id (須為唯一的)
				//考慮了幾種做法，最後決定用亂數產生的較佳
				iiii
			$sql2 = " INSERT INTO temptable 
				SELECT RAND()*10000 as calendar_id,
				$_SESSION[personal_id] as personal_id,
				year(d_dueday) as year, month(d_dueday) as month, day(d_dueday) as day,
				homework_name   as content,
				date(d_dueday) as notify,
				2 as notify_num,
				now() as mtime

				FROM homework as t1
				where year(d_dueday) ='$selectedYear'
				and	month(d_dueday) = '$selectedMonth'
				and day(d_dueday) = '$adjusted_day' 
				and public = 2 ;";

			db_query($sql2);

				//應該是插入測驗用的部份
				//需要一個 unique id 做為 calendar_id ，在顯示日曆時會用得到這個 id (須為唯一的)
				//考慮了幾種做法，最後決定用亂數產生的較佳
			$sql3 = " INSERT INTO temptable 
				SELECT RAND()*10000  as calendar_id,
				$_SESSION[personal_id] as personal_id,
				year(d_test_beg) as year, month(d_test_beg) as month, day(d_test_beg) as day,
				test_name as content,
				date(d_test_beg) as notify,
				2 as notify_num,
				now() as mtime

				from test_course_setup as t1
				where year(d_test_beg) ='$selectedYear'
				and	month(d_test_beg) = '$selectedMonth'
				and day(d_test_beg) = '$adjusted_day' ;";

			db_query($sql3);

				//插入問卷用的部份
				//需要一個 unique id 做為 calendar_id ，在顯示日曆時會用得到這個 id (須為唯一的)
				//考慮了幾種做法，最後決定用亂數產生的較佳
			$sql4 = " INSERT INTO temptable 
				SELECT RAND()*10000  as calendar_id,
				$_SESSION[personal_id] as personal_id,
				year(d_survey_beg) as year, month(d_survey_beg) as month, day(d_survey_beg) as day,
				survey_name as content,
				date(d_survey_beg) as notify,
				2 as notify_num,
				now() as mtime

				from online_survey_setup as t1
				where year(d_survey_beg) ='$selectedYear'
				and	month(d_survey_beg) = '$selectedMonth'
				and day(d_survey_beg) = '$adjusted_day' ;";


			db_query($sql4);

			$sqlFinal = " select * from temptable; ";
			$res = db_query($sqlFinal);



			//原作者的 code 備份
			//$sql = "SELECT * FROM calendar WHERE personal_id='".$_SESSION[personal_id]."' and year='".$selectedYear."' and month='".$selectedMonth."' and day='".$adjusted_day."'";
			//$res = $DB_CONN->query($sql);

			/*
			 * end of modification of rja
			 */

			if(PEAR::isError($res))	die($res->getMessage());
			$isHave = $res->numRows();
			$content = getAllContent($res ,$selectedYear, $selectedMonth, $adjusted_day);
			$today_week = checkWeek( $adjusted_day, $selectedMonth, $selectedYear); 
			if($adjusted_day == $today){ //今天
				if($isHave)
					$week[$count] = "<td class=\"today\" class=\"active\" class=\"".$today_week."\" onmouseOver=\"setFocus(this)\" onmouseOut=\"unsetFocus(this)\"> <div onclick=\"setNote(this,".$selectedYear.",".$selectedMonth.",".$adjusted_day." , '0');\"  >$adjusted_day</div> $content </td>";
				else
					$week[$count] = "<td class=\"today\" class=\"".$today_week."\" onmouseOver=\"setFocus(this)\" onmouseOut=\"unsetFocus(this)\"> <div onclick=\"setNote(this,".$selectedYear.",".$selectedMonth.",".$adjusted_day." , '0');\"  >$adjusted_day</div> </td>";			
			}			
			else if($adjusted_day == $selectedDay){//被選擇的
				if($isHave)
					$week[$count] = "<td class=\"active\" class=\"".$today_week."\"  onmouseOver=\"setFocus(this)\" onmouseOut=\"unsetFocus(this)\"><div onclick=\"setNote(this,".$selectedYear.",".$selectedMonth.",".$adjusted_day." , '0');\"  >$adjusted_day</div> $content </td>";
				else
					$week[$count] = "<td class=\"".$today_week."\" onmouseOver=\"setFocus(this)\" onmouseOut=\"unsetFocus(this)\"> <div onclick=\"setNote(this,".$selectedYear.",".$selectedMonth.",".$adjusted_day." , '0');\"  >$adjusted_day</div> </td>";
			}
			else {
				if($isHave)
					$week[$count] = "<td class=\"active\" class=\"".$today_week."\" onmouseOver=\"setFocus(this)\" onmouseOut=\"unsetFocus(this)\"><div onclick=\"setNote(this,".$selectedYear.",".$selectedMonth.",".$adjusted_day." , '0');\"  >$adjusted_day</div> $content</td>";
				else
					$week[$count] = "<td class=\"".$today_week."\" onmouseOver=\"setFocus(this)\" onmouseOut=\"unsetFocus(this)\" ><div onclick=\"setNote(this,".$selectedYear.",".$selectedMonth.",".$adjusted_day." , '0');\"  >$adjusted_day</div></td>";
			}
			$day++;			
		}
		$dayRow++;
		$count++;
	}

	//產生日期選單
	setDateBar($tpl, $selectedYear, $selectedMonth, $selectedDay);
	//personal_name
	$tpl->assign("personal_name", getPersonalNameByPersonalId($DB_CONN, $_SESSION[personal_id] ));
	//輸出頁面
	assignTemplate($tpl, "/calendar/month.tpl");	
				
	
//----------------function area ------------------
function setDateBar($tpl, $year, $month, $day){
	//year
	$range = 5;
	for($i=0; $i < 10; $i++){
		$tmp = $year - $range + $i;
		if($tmp == $year)
			$year_bar .= "<option value=\"$tmp\" selected>$tmp</option>";
		else
			$year_bar .= "<option value=\"$tmp\">$tmp</option>";
	}
	$tpl->assign("sel_year", $year_bar);
	//month
	for($i=1; $i <= 12; $i++){
		if($i == $month)
			$month_bar .= "<option value=\"$i\" selected>$i</option>";
		else
			$month_bar .= "<option value=\"$i\">$i</option>";
	}	 
	$tpl->assign("sel_month", $month_bar);
	//day
	/*$all_days = date('t',mktime(0,0,0,$month,1,$year));
	for($i=1; $i <= $all_days; $i++){
		if($i == $day)
			$day_bar .= "<option value=\"$i\" selected>$i</option>";
		else
			$day_bar .= "<option value=\"$i\">$i</option>";	
	}*/
	//先固定31天 以後有時間用AJAX改動態
	for($i=1; $i <= 31; $i++){
		if($i == $day)
			$day_bar .= "<option value=\"$i\" selected>$i</option>";
		else
			$day_bar .= "<option value=\"$i\">$i</option>";
	}	  
	$tpl->assign("sel_day", $day_bar);
}

function getPersonalNameByPersonalId( $DB, $personal_id ){
	$sql = "SELECT personal_name FROM personal_basic WHERE personal_id='".$personal_id."'";
	return $DB->getOne($sql);
}

function getAllContent($res, $year, $month, $day){
	$content = "<ul>";
	while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
		$content .= "<li onclick=\"showModifyNote(this,".$year.",".$month.",".$day.", ".$row[calendar_cd].");\"  onmouseOver='showMessage(this, \"".$row[calendar_cd]."\");' onmouseOut='hideMessage(this, \"".$row[calendar_cd]."\");' >";
		$content .= cuttingstr($row[content], 6);
		$content .= "<div id='".$row[calendar_cd]."' style='display:none;position:absolute;width:100%;' class='form' >".$row[content]."</div>";
		$content .= "</li>";
	}
	$content .= "</ul>";
	return $content ;
}

function cuttingstr($str, $ct){ 
	if(strlen($str) > $ct) { 
		for($i = 0; $i < $ct; $i++){ 
			$ch = substr($str, $i, 1); 
			if( ord( $ch ) > 127 ) $i++; 
		} 
		$str = substr($str, 0, $i);
		$str = sprintf ("%s ...", $str);
	} 
	return $str; 
} 

function checkWeek($day, $month, $year){
	$w = date('w',mktime(0,0,0,$month,$day,$year));
	switch($w){
		case '1': case '2': case '3': case '4': case '5': $week = ""; break;
		case '0': $week="sun"; break;
		case '6': $week="sat"; break;
	}
	return $week;	
} 
?>

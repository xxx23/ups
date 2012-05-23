<?php
/*
	這支程式應該是右邊的小行事曆 (應該是進入課程後才會有)

*/
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");

	//用來記錄目前行事曆是在"個人頁面"的行事曆，還是"課程"裡的行事曆
	//"個人頁面"的行事曆顯示擁有的全部課程的行事曆
	// $_SESSION['in_class'] 若為 1 ，即是在課程中
    $_SESSION['in_class'] = 1 ;

	//new smarty
	$tpl = new Smarty();	
		
	if(isset($_GET[action]) && isset($_GET[target]) && isset($_GET[valueY]) && isset($_GET[valueM]) ){
		//取得選取的日期
		/*if("year" == $_GET[target]){
			if( "add" == $_GET[action]){
				$selectedMonth = $_GET[valueM];
				$selectedYear = $_GET[valueY]+1;				
			}
			else{
				$selectedMonth = $_GET[valueM];
				$selectedYear = $_GET[valueY]-1;				
			}
				
		}else{*/
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
		//}
	}
	else if($_GET[action] == 'change'){
		$selectedMonth = $_GET[valueM];
		$selectedYear = $_GET[valueY];		
	}
	else{	
		//取得今天的日期
		$selectedDay = date('j');
		$selectedMonth = date('n');
		$selectedYear = date('Y');
	}
	//今天
	if( $selectedYear == date('Y') && $selectedMonth == date('n')){
		$today = date('j');	
		if($selectedDay == '')	$selectedDay = $today;	
	}
	//輸出 年月
	$tpl->assign("year", $selectedYear);
	$tpl->assign("month", $selectedMonth);	
	//取得當月的第一天是星期幾
	$firstday = date('w',mktime(0,0,0,$selectedMonth,1,$selectedYear));
	//取得當月的最後一天
	$lastday = 31;
	do{
		$monthOrig = date('n',mktime(0,0,0,$selectedMonth, 1, $selectedYear));
		$monthTest = date('n',mktime(0,0,0,$selectedMonth, $lastday, $selectedYear));
		if($monthTest != $monthOrig){$lastday -= 1;}
	}while($monthTest != $monthOrig);
	//取得當月的英文名
	//$monthName = date('F',mktime(0,0,0,$selectedMonth,1,$selectedYear));
	$dayRow = 0;
	$nextMonthDay=1;
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
			$week[$count] = "<td class =\"previous\">" . date('j',mktime(0,0,0,$selectedMonth,1 - ($firstday - $dayRow),$selectedYear)) . "</td>";
		}
		else if( $day >= $lastday){
			$week[$count] = "<td class =\"next\">" . date('j',mktime(0,0,0,$selectedMonth ,$nextMonthDay++,$selectedYear)) . "</td>";
		}	
		else{			
			$adjusted_day = $day + 1;


/*

	modify by rja

 */
			/*
			 * modify by rja
			 * 原本的作法是在顯示行事曆時，去 query calendar table 
			 * 為了讓作業 event 也可以顯示在行事曆上，於是在顯示行事曆時，
			 * 順便去 query homework table 。
			 *
			 * 為了盡量不改原本的 code ，這裡用了一點小 trick ，方便修改 code 的彈性。
			 * 先照原本的 code 作法，把 calendar 的資料 select 出來，不過卻是利用了
			 * sql 的語法: CREATE TEMPORARY TABLE，放在一個暫存的 table ，這個 table
			 * 在這隻 php 結束時，就會自動消失 ( I hope so. )；後來也發現原本的程式作法
			 * 是採用 loop 近乎 30 次的作法，所以在我新增的code的尾端，我有再 drop if exist 
			 * 一次，以確定每次 loop 時，都會 drop 掉這個 table。
			 *
			 * 利用這個暫存的 table 存原本的 calendar table 的資料，再另外 query 出
			 * homework 裡，屬於這門課的 homework 的 due day ，再放到這個暫存的 table 。
			 *
			 * 這個暫存 table 會長得跟 table calendar 很像，最後再把這個暫存 table 送給
			 * 原本的程式。
			 * 
			 * 測驗用的 test_course_setup 也是同理，與 homework 作法相同。
			 */

/* 
	這個小行事曆是"全部課程行事曆"，應該要包括全部課程的 event ，包括留言、測驗問卷作業
 */
			//不知道為什麼會告訴我 temptable 已經存在，反正先 drop 掉  if exists
			$sql0 = "drop table if exists temptable";
			db_query($sql0);
			$sql1 = "CREATE TEMPORARY  TABLE temptable
				SELECT * FROM calendar WHERE personal_id='".$_SESSION[personal_id]."'
				AND year='".$selectedYear."' 
				AND month='".$selectedMonth."' 
				AND day='".$adjusted_day."'";
			db_query($sql1);



			//應該是插入作業用的部份
			//mtime 的部份應該用不到，先隨便給一個值
			//需要一個 unique id 做為 calendar_id ，在顯示日曆時會用得到這個 id (須為唯一的)
			//考慮了幾種做法，最後決定用亂數產生的較佳
			$sql2 = " INSERT INTO temptable 
				SELECT RAND()*10000   as calendar_id,
				$_SESSION[personal_id] as personal_id,
				year(d_dueday) as year, month(d_dueday) as month, day(d_dueday) as day,
				concat('作業:' ,homework_name) as content,
				date(d_dueday) as notify,
				2 as notify_num,
				now() as mtime

				from homework 
				where begin_course_cd = {$_SESSION['begin_course_cd']}
				and year(d_dueday) ='$selectedYear'
				and	month(d_dueday) = '$selectedMonth'
				and day(d_dueday) = '$adjusted_day' 
				and public = 2 ;";

			db_query($sql2);

				//應該是插入測驗用的部份
			$sql3 = " INSERT INTO temptable 
				SELECT RAND()*10000  as calendar_id,
				$_SESSION[personal_id] as personal_id,
				year(d_test_beg) as year, month(d_test_beg) as month, day(d_test_beg) as day,
				concat('測驗:',test_name) as content,
				date(d_test_beg) as notify,
				2 as notify_num,
				now() as mtime

				from test_course_setup 
				where begin_course_cd = {$_SESSION['begin_course_cd']}
				and year(d_test_beg) ='$selectedYear'
				and	month(d_test_beg) = '$selectedMonth'
				and day(d_test_beg) = '$adjusted_day' ;";

			db_query($sql3);
				//print $sql3;


				//插入問卷用的部份
				//需要一個 unique id 做為 calendar_id ，在顯示日曆時會用得到這個 id (須為唯一的)
				//考慮了幾種做法，最後決定用亂數產生的較佳
			$sql4 = " INSERT INTO temptable 
				SELECT RAND()*10000  as calendar_id,
				$_SESSION[personal_id] as personal_id,
				year(d_survey_beg) as year, month(d_survey_beg) as month, day(d_survey_beg) as day,
				concat('問卷:',survey_name) as content,
				date(d_survey_beg) as notify,
				2 as notify_num,
				now() as mtime

				FROM online_survey_setup as t1, teach_begin_course as t2 
				where begin_course_cd = {$_SESSION['begin_course_cd']}
				and  t1.survey_target = t2.begin_course_cd 
				and year(d_survey_beg) ='$selectedYear'
				and	month(d_survey_beg) = '$selectedMonth'
				and day(d_survey_beg) = '$adjusted_day' ;";

				//print_r($sql4);

			db_query($sql4);


			$sql = " select * from temptable; ";
			$res = db_query($sql);




/*備份原來作者的 code 

			
			//查出有紀錄的
			$sql = "SELECT content FROM calendar WHERE personal_id='".$_SESSION[personal_id]."' and year='".$selectedYear."' and month='".$selectedMonth."' and day='".$adjusted_day."'";
*/
			$res = $DB_CONN->query($sql);



			if(PEAR::isError($res))	die($res->getMessage());
			$isHave = $res->numRows();
			//echo $sql;
			//當天用红色表示
			if($adjusted_day == $today){ //今天
				//if($isHave)
					$week[$count] = "<td class =\"active\" onmouseOver=\"setFocus(this)\" onmouseOut=\"unsetFocus(this)\" onclick=\"goto(this,".$selectedYear.",".$selectedMonth.",".$adjusted_day.");\" ><font color=red>$adjusted_day</font></td>";
				//else
					//$week[$count] = "<td class =\"active\" onmouseOver=\"setFocus(this)\" onmouseOut=\"unsetFocus(this)\" onclick=\"goto(this,".$selectedYear.",".$selectedMonth.",".$adjusted_day.");\" ><font color=red>$adjusted_day</font></td>";			
			}
			else if($adjusted_day == $selectedDay){
				if($isHave)
					$week[$count] = "<td class =\"active\" onmouseOver=\"setFocus(this)\" onmouseOut=\"unsetFocus(this)\" onclick=\"goto(this,".$selectedYear.",".$selectedMonth.",".$adjusted_day.");\" >$adjusted_day</td>";
				else
					$week[$count] = "<td onmouseOver=\"setFocus(this)\" onmouseOut=\"unsetFocus(this)\" onclick=\"goto(this,".$selectedYear.",".$selectedMonth.",".$adjusted_day.");\" >$adjusted_day</td>";
			}
			else {
				if($isHave)
					$week[$count] = "<td class =\"active\" onmouseOver=\"setFocus(this)\" onmouseOut=\"unsetFocus(this)\" onclick=\"goto(this,".$selectedYear.",".$selectedMonth.",".$adjusted_day.");\" >$adjusted_day</td>";
				else
					$week[$count] = "<td onmouseOver=\"setFocus(this)\" onmouseOut=\"unsetFocus(this)\" onclick=\"goto(this,".$selectedYear.",".$selectedMonth.",".$adjusted_day.");\" >$adjusted_day</td>";
			}
			$day++;			
		}
		$dayRow++;
		$count++;
	}
	//year
	$range = 4;
	for($i=0; $i < 9; $i++){
		$tmp =$selectedYear - $range + $i;
		if($tmp == $selectedYear)
			$year_bar .= "<option value=\"$tmp\" selected>$tmp</option>";
		else
			$year_bar .= "<option value=\"$tmp\">$tmp</option>";
	}
	$tpl->assign("sel_year", $year_bar);
	//month
	$month_str = array("","一月", "二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月",);
	for($i=1; $i <= 12; $i++){
		if($i == $selectedMonth)
			$month_bar .= "<option value=\"$i\" selected>$month_str[$i]</option>";
		else
			$month_bar .= "<option value=\"$i\">$month_str[$i]</option>";
	}	 
	$tpl->assign("sel_month", $month_bar);	
	
	
	//輸出頁面
	assignTemplate($tpl,"/calendar/calendar_incourse.tpl");	
	
	//----------------function area ------------------
?>

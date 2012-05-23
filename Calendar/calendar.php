<?php
/*
 *
 * 這支程式應該是"個人頁面"用的小行事曆 (不在課程內的行事曆) (update: 應該是左邊的小行事曆)
 *
 */


	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");


	//用來記錄目前行事曆是在"個人頁面"的行事曆，還是"課程"裡的行事曆
	//"個人頁面"的行事曆顯示擁有的全部課程的行事曆
	// $_SESSION['in_class'] 若為 0 ，即是在課程外
	$_SESSION['in_class']=0;

	//new smarty
	$template = $_SESSION['template_path'] . $_SESSION['template'];
	$tpl = new Smarty();

	if(isset($_GET['action']) && isset($_GET['target']) && isset($_GET['valueY']) && isset($_GET['valueM']) ){
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
	else if(array_key_exists('action', $_GET) && $_GET['action'] == 'change'){
		$selectedMonth = $_GET['valueM'];
		$selectedYear = $_GET['valueY'];
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
	$nextMonthDay = 1;
	$day = 0;
	$week = null;
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
			$sql2 = " INSERT INTO temptable
				SELECT RAND()*10000 as calendar_id,
                {$_SESSION['personal_id']} as personal_id,
				year(d_dueday) as year, month(d_dueday) as month, day(d_dueday) as day,
				homework_name   as content,
				date(d_dueday) as notify,
				2 as notify_num,
				now() as mtime

                FROM homework as t1
                where begin_course_cd in (
                    SELECT begin_course_cd
                    FROM teach_begin_course
                    WHERE teacher_cd = {$_SESSION['personal_id']}
                    )
                and year(d_dueday) ='$selectedYear'
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
                where 
                    begin_course_cd in (
                    SELECT begin_course_cd
                    FROM teach_begin_course
                    WHERE teacher_cd = {$_SESSION['personal_id']}
                    ) 
                and year(d_test_beg) ='$selectedYear'
				and	month(d_test_beg) = '$selectedMonth'
				and day(d_test_beg) = '$adjusted_day' ;";

			db_query($sql3);

				//插入問卷用的部份
				//需要一個 unique id 做為 calendar_id ，在顯示日曆時會用得到這個 id (須為唯一的)
				//考慮了幾種做法，最後決定用亂數產生的較佳
			$sql4 = " INSERT INTO temptable
				SELECT RAND()*10000  as calendar_id,
                {$_SESSION['personal_id']} as personal_id,
				year(d_survey_beg) as year, month(d_survey_beg) as month, day(d_survey_beg) as day,
				survey_name as content,
				date(d_survey_beg) as notify,
				2 as notify_num,
				now() as mtime

				from online_survey_setup as t1
                where survey_target in (
                    SELECT begin_course_cd 
                    FROM teach_begin_course
                    WHERE teacher_cd = {$_SESSION['personal_id']}
                ) 
                and year(d_survey_beg) ='$selectedYear'
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
	$year_bar = '';
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
	$month_bar = '';
	for($i=1; $i <= 12; $i++){
		if($i == $selectedMonth)
			$month_bar .= "<option value=\"$i\" selected>$month_str[$i]</option>";
		else
			$month_bar .= "<option value=\"$i\">$month_str[$i]</option>";
	}
	$tpl->assign("sel_month", $month_bar);



	//-------------
	if(isset($_GET['incourse']) && $_GET['incourse'] == 'yes')
		$tpl->assign("in_course", "inCourse=true;");
	else
		$tpl->assign("in_course", "");
	//------------------
	//輸出頁面
	assignTemplate($tpl, "/calendar/calendar.tpl");

	//----------------function area ------------------
?>

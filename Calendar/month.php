<?php
/*
 * 這支程式應該是在"課程頁面"的行事曆 (大行事曆)
 *
 */
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	//new smarty
	$tpl = new Smarty;
    
    // modify by Samuel @ 2009/12/27
    // 因為這隻程式有使用 inclass來判斷calender顯示的東西
    // 不過進入課程之後，並沒有更改inclass的值 所以增加了這個if else
    /*
     * if(isset($_SESSION['begin_course_cd']))
        $_SESSION['in_class'] = 1 ;
    else
        $_SESSION['in_class'] = 0 ; 
     */
	//使用者按下年或月的數字切換，如下一個月或上一年
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
	//前往某個日期
	else if(!isset($_GET[action]) && !isset($_GET[target]) && isset($_GET['target_date'])){
		list($selectedYear, $selectedMonth, $selectedDay) = explode("-", $_GET['target_date']);
    }
    elseif(isset($_GET['sel_year']) || isset($_GET['sel_month']) || isset($_GET['sel_day']))
    {
        /*modify by Samuel @ 2009/12/26
         *這邊新增的原因是因為點了小日曆 大行事曆都沒有變動 因為傳過來的GET的變數沒有正確的關係
         * 
         */
        $selectedYear = $_GET['sel_year'];
        $selectedMonth = $_GET['sel_month'];
    }
    //取得今天的日期
	else{	
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
			// make sure 有 drop 掉 temp table
			$sqlDropTempTable = "drop table if exists temptable;";
			db_query($sqlDropTempTable);

			/* 
			 * 以下是在 "課程頁面" (右邊的小行事曆按出來的大行事曆)
			 *
			 */

			//note:在"個人頁面"的行事曆，因為不是在課程中看的行事曆，所以沒有與課程有關的 event
			//利用有沒有 $_SESSION['begin_course_cd'] 來判斷
			//下面則是"在課程中看的行事曆"，需要先查有沒有作業等 event
			if( $_SESSION['in_class']==1 ){ 
			//查出有紀錄的
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

				// 備份一下語法 where begin_course_cd = {$_SESSION['begin_course_cd']}

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
			//	print $sql3;


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


			} else {

			/* 
			 * 以下是在 "個人頁面" (左邊的小行事曆按出來的大行事曆)
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
				$_SESSION[personal_id] as personal_id,
				year(d_dueday) as year, month(d_dueday) as month, day(d_dueday) as day,
				concat('作業:' ,homework_name) as content,
				date(d_dueday) as notify,
				2 as notify_num,
				now() as mtime

				FROM homework as t1
                where begin_course_cd in (
                    SELECT begin_course_cd from teach_begin_course where teacher_cd = {$_SESSION['personal_id']})
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
				concat('測驗:' ,test_name) as content,
				date(d_test_beg) as notify,
				2 as notify_num,
				now() as mtime

				from test_course_setup as t1
                where begin_course_cd in(
                        SELECT begin_course_cd
                        FROM teach_begin_course
                        WHERE
                        teacher_cd = {$_SESSION['personal_id']}
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
				$_SESSION[personal_id] as personal_id,
				year(d_survey_beg) as year, month(d_survey_beg) as month, day(d_survey_beg) as day,
				concat('問卷:' ,survey_name) as content,
				date(d_survey_beg) as notify,
				2 as notify_num,
				now() as mtime

				from online_survey_setup as t1
                where survey_target in(
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

			/*
			//temp 原本的作者的 code 
			//print_r( $_SESSION );
			$sql = "
				SELECT * FROM calendar WHERE personal_id='".$_SESSION[personal_id]."'
				AND year='".$selectedYear."' 
				AND month='".$selectedMonth."' 
				AND day='".$adjusted_day."'";
			 
			$res=db_query($sql);
			 */
			}
		

			/*
			 * end of modification of rja
			 */

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
	/*
	 *
	 *這邊顯示大行事曆的內容，包括 javascript showModifyNote 等
	 */
	$content = "<ul>";
	while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
		//print_r($row[content]);
		//不是作業問卷等開頭的項目，就是留言，留言以黑色字體表示
		if(! preg_match('/^(作業|問卷|測驗):/',$row['content'] )) $content.='<font color="black">';
		$content .= "<li onclick=\"showModifyNote(this,".$year.",".$month.",".$day.", ".$row[calendar_cd].");\"  onmouseOver='showMessage(this, \"".$row[calendar_cd]."\");' onmouseOut='hideMessage(this, \"".$row[calendar_cd]."\");' >";
		$content .= cuttingstr($row[content], 6);
		$content .= "<div id='".$row[calendar_cd]."' style='display:none;position:absolute;width:100%;' class='form' >".$row[content]."</div>";
		$content .= "</li>";
		if(! preg_match('/^(作業|問卷|測驗):/',$row['content'] )) $content.='</font>';
	}
	$content .= "</ul>";
	//print "\nhere:\n";
	//print_r($content);
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

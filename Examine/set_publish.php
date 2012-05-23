<?php
	/*author: lunsrot
	 * date: 2007/06/30 modify
	 */
	require_once("../config.php");
	require_once("../session.php");
    require_once("publ_info.php");		//displayTime, setTime
    require_once($HOME_PATH . 'library/filter.php') ;

    $option = optional_param('option','view',PARAM_TEXT);

	$tmp = gettimeofday();
	$time = getdate($tmp['sec']);
	$begin_course_cd = $_SESSION['begin_course_cd'];	
	call_user_func($option, $_GET['test_no'], $begin_course_cd, $time, $tmp);
	/*template
	 * 功能：顯示公開、開始、結束測驗的時間
	 * 參數：test_no是測驗編號；time是一個陣列，有mon, mday等member data；tmp是紀錄距1970年過了多少時間
	 * 回傳值：Null
	 */
	function view($test_no, $begin_course_cd, $time, $tmp){
		$sql = "select * from `test_course_setup` where begin_course_cd=$begin_course_cd and test_no=$test_no;";
		$result = db_query($sql);
        $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
        global $HOME_PATH;
        require_once($HOME_PATH . 'library/smarty_init.php');
		//$tpl = new Smarty;

		$tpl->assign('name', $row['test_name']);
		$tpl->assign('test_no', $test_no);
		if(empty($row['d_test_beg'])){
            displayTime($tpl, $time, "pub", "p");
            displayTime($tpl, $time, "start", "s");
            $time['hours']=23;
            $time['minutes']=59;
			displayTime($tpl, $time, "stop", "d");
		}else{
			displayTime($tpl, str_to_time($row['d_test_public']), "pub", "p");
			displayTime($tpl, str_to_time($row['d_test_beg']), "start", "s");
			displayTime($tpl, str_to_time($row['d_test_end']), "stop", "d");
		}
		$time = $tmp['sec'];
		if($row[d_test_public] == NULL)
			$row['state'] = "未設定";
		else if( timecmp( $time, strtotime($row[d_test_end]) ) == 1 ){
			$row['state'] = "測驗結束";
		}else if( timecmp( $time, strtotime($row[d_test_beg]) ) == 1 ){
			$row['state'] = "測驗中";
		}else if( timecmp( $time, strtotime($row[d_test_public]) ) == 1 ){	
			$row['state'] = "已發佈";
		}else if( timecmp( $time, strtotime($row[d_test_public]) ) == -1 ){
			$row['state'] = "未發佈";
		}
		$tpl->assign('state', $row['state']);
		$tpl->assign("time", "發佈時間：".$row[d_test_public]."<br/>"."測驗開始：".$row[d_test_beg]."<br/>"."測驗結束：".$row[d_test_end]);

		assignTemplate($tpl, "/examine/set_publish.tpl");
	}
	
	/*function
	 * 功能：修改公開、開始、結束測驗的時間
	 * 參數：test_no是測驗編號；time是一個陣列，有mon, mday等member data；tmp是紀錄距1970年過了多少時間
	 * 回傳值：Null
	 */
	function modify($test_no, $begin_course_cd, $time, $tmp){
 
      
      $str1 = required_param("pub_date");//$_GET['pub_date'];
      $str2 = required_param('start_date');
      $str3 = required_param('stop_date');

      if($str1=="undefined"||$str2=="undefined"||$str3=="undefined")
      {
          $sql = "select * from `test_course_setup` where begin_course_cd=$begin_course_cd and test_no=$test_no;";
          $result = db_query($sql);
          $row = $result->fetchRow(DB_FETCHMODE_ASSOC);

          if(empty($row['d_test_beg'])){
              if($str1=="undefined")
                  $str1=$time[year]."-".$time[mon]."-".$time[mday];
              if($str2=="undefined")
                  $str2=$time[year]."-".$time[mon]."-".$time[mday];
              if($str3=="undefined")
                  $str3=$time[year]."-".$time[mon]."-".$time[mday];
          }else{
              if($str1=="undefined")
              {
                  $out=str_to_time($row['d_test_public']);
                  $str1=$out['year']."-".$out['mon']."-".$out['mday'];
              }
              if($str2=="undefined")
              {
                  $out=str_to_time($row['d_test_beg']);
                  $str2=$out['year']."-".$out['mon']."-".$out['mday'];
              }
              if($str3=="undefined")
              {
                  $out=str_to_time($row['d_test_end']);
                  $str3=$out['year']."-".$out['mon']."-".$out['mday'];
              }
          }
      }

      $pubyear = strtok($str1,"-");
      $pubmonth = strtok("-");
      $pubday = strtok("-");
      $pubhour = required_param("pub_hour");
      $pubminute = required_param("pub_minute");

      $startyear = strtok($str2,"-");
      $startmonth = strtok("-");
      $startday = strtok("-");
      $starthour = required_param("start_hour");
      $startminute = required_param("start_minute");

      $stopyear = strtok($str3,"-");
      $stopmonth = strtok("-");
      $stopday = strtok("-");
      $stophour = required_param('stop_hour');
      $stopminute = required_param('stop_minute');

      if((($pubyear>$startyear||
          ($pubyear==$startyear&&$pubmonth>$startmonth)||
          ($pubyear==$startyear&&$pubmonth==$startmonth&&$pubday>$startday)||
          ($pubyear==$startyear&&$pubmonth==$startmonth&&$pubday==$startday&&$pubhour>$starthour)||
          ($pubyear==$startyear&&$pubmonth==$startmonth&&$pubday==$startday&&$pubhour==$starthour&&$pubminute>$startminute)
      )))
      {
          echo "測驗開始時間不得早於測驗發佈時間<br>";
          echo "<span onclick=\"history.back();\" style=\"cursor:pointer;\">按此回上一頁</span>";
          exit(0);
      }
      else if((($startyear>$stopyear||
          ($startyear==$stopyear&&$startmonth>$stopmonth)||
          ($startyear==$stopyear&&$startmonth==$stopmonth&&$startday>$stopday)||
          ($startyear==$stopyear&&$startmonth==$stopmonth&&$startday==$stopday&&$starthour>$stophour)||
          ($startyear==$stopyear&&$startmonth==$stopmonth&&$startday==$stopday&&$starthour==$stophour&&$startminute>=$stopminute)
      )))
      {
          echo "測驗結束時間不得早於測驗開始時間<br>";
          echo "<span onclick=\"history.back();\" style=\"cursor:pointer;\">按此回上一頁</span>";
          exit(0);
      }
      else
      {
          $str = $pubyear."-".$pubmonth."-".$pubday." ".$pubhour.":".$pubminute;
          $sql = "update test_course_setup set d_test_public='$str' where begin_course_cd=$begin_course_cd and test_no=$test_no;";
          $result = db_query($sql);
          $str = $startyear."-".$startmonth."-".$startday." ".$starthour.":".$startminute;
          $sql = "update test_course_setup set d_test_beg='$str' where begin_course_cd=$begin_course_cd and test_no=$test_no;";
          $result = db_query($sql);
          $str = $stopyear."-".$stopmonth."-".$stopday." ".$stophour.":".$stopminute;
          $sql = "update test_course_setup set d_test_end='$str' where begin_course_cd=$begin_course_cd and test_no=$test_no;";
          $result = db_query($sql);
          header("location:../Examine/tea_view.php");
      }
    }

    /*library
     * 功能：將表示時間的字串轉為陣列
     * 參數：str是格式為1970-01-01 00:00:00的字串
     * 回傳值：陣列，member data為year, mon, mday, hours
     */
    function str_to_time($str){
        $output = array();
        $output['year'] = substr($str, 0, 4);
        $output['mon'] = substr($str, 5, 2);
        $output['mday'] = substr($str, 8, 2);
        $output['hours'] = substr($str, 11, 2);
        $output['minutes'] = substr($str,14,2);
        return $output;
    }
?>

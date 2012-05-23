<?php
/*
   author: rja
   用來印出呼叫 my_reservation_list會用到的 lib ，畫出表格等
   後來加上了也要讓 my_gotomeeting.php 也可以用，在老師進入辦公室時，若還沒到預約會議開始的時間，
   可以印出今日全部的會議，以及是否進入準備模式

 */
?>
<?PHP

function editTableContent($reservation_meeting = null){
if ($reservation_meeting == null )return;

	$listTable = array();
	foreach($reservation_meeting as $key => $value){
		$listTable[$key] = array();
		$listTable[$key][] =  $value['courseName'];
		$listTable[$key][] =  $value['teacherName'];

		$listTable[$key][] =  $value['title'];
		$listTable[$key][] =  date('Y-m-d h:i a', $value['startTime']);

		if($value['isOnline']) $listTable[$key][] =  '是';
		else $listTable[$key][] =  '否';

		$listTable[$key][] =  $value['maxNumAttendee'];

		if($value['recording']) $listTable[$key][] =  '是';
		else $listTable[$key][] =  '否';

		$encodeCourseName = urlencode($value['courseName']);
		global $user_id;
		if(isTeacher($user_id)){
			$prepareUrl = "<a href='./my_gotojoinnet.php?action=gotoPrepareModeMeeting&meetingId={$value['meetingId']}&courseName=$encodeCourseName'>進入準備課程模式</a>";
			$listTable[$key][] =  $prepareUrl;

    $prepareUrl = "<a href='./my_gotojoinnet.php?action=delReservation&meetingId={$value['meetingId']}' onClick=\"return confirm('警告：這個動作將會一併刪除關聯的附件。\\n\\n請確認是否刪除此會議？');\">解除預約會議</a>";
                        $listTable[$key][] =  $prepareUrl;


		}

	}
	return $listTable;

}

function printTable($listTable){
global $user_id;

#var_dump($listTable);
	echo '<table border="1">';
	$tableHeader = array( '課程名稱', '授課教師', '標題', '預約日期時間', '線上', '會議最大人數',  '錄影');
		if(isTeacher($user_id)){
			$tableHeader[]='準備模式';
			$tableHeader[]='取消預約';
		}
		print putTr(putTh($tableHeader));

		if ($listTable == null ){
			echo '</table>' ;
			return;
		}

		foreach ($listTable as $value){
			print putTr(putTd($value));
		}
		echo '</table>';

	}
	function putTh ($arr) {
		$ret='';
		foreach( $arr as $key => $value )
			$ret .="\n<th>\n\t$value\n</th>";
		return $ret;
	}

	function putTr ($arr) {
		//  foreach( $arr as $key => $value )
		return  "\n<tr>\t$arr\n</tr>\n";
	}

	function putTd ($arr) {
		$ret='';
		foreach( $arr as $key => $value )
			$ret .= "\n<td>$value</td>";
		return $ret;
	}

	?>

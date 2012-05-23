<?php
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	
	$target = $_POST['target'];
	if($target == "note"){
		if($_POST[content] == ""){  //do nothing	
		
		}
		else{
			//算出要寫入的時間點
			$notify = date('Y-m-d',mktime( 0, 0, 0, $month, $day - $_POST['day'], $year));
			$sql = "INSERT INTO calendar (personal_id, year, month, day, content, notify, notify_num) VALUES ('".$_SESSION[personal_id]."','".$_POST[year]."','".$_POST[month]."','".$_POST[day]."','".$_POST[content]."','".$notify."','".$_POST[notify_num]."' );";
			$res = $DB_CONN->query($sql);
			if(PEAR::isError($res))	die($res->getMessage());		
		}
		
		
		
	}
	else if($target == "modifynote"){	
		if($_POST[content] == ""){  //delete
			$sql = "DELETE FROM calendar WHERE calendar_cd='".$_POST[id]."' ";
			$res = $DB_CONN->query($sql);
			if(PEAR::isError($res))	die($res->getMessage());			
		}
		else{		
			//算出要寫入的時間點
			$notify = date('Y-m-d',mktime( 0, 0, 0, $month, $day - $_POST['day'], $year));
			$sql = "UPDATE calendar SET content='".$_POST[content]."', notify='".$notify."', notify_num='".$_POST[notify_num]."' WHERE calendar_cd='".$_POST[id]."' ";
			$res = $DB_CONN->query($sql);
			if(PEAR::isError($res))	die($res->getMessage());		
		}
		
		
	}

	//查出紀錄
	$sql = "SELECT * FROM calendar WHERE personal_id='".$_SESSION[personal_id]."' and year='".$_POST[year]."' and month='".$_POST[month]."' and day='".$_POST[day]."'";
	$res = $DB_CONN->query($sql);
	if(PEAR::isError($res))	die($res->getMessage());
	//$isHave = $res->numRows();
	$content = getAllContent($res ,$_POST[year], $_POST[month], $_POST[day]);	
	echo $content;
	
	
//----------------------function-----------------------	
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
?>

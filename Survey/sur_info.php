<?php
require_once("../config.php");
require_once("../session.php");

function create_html_1($row){
	$description = "<tr><td>題目描述</td>";
	for($i = 1 ; $i <= $row['selection_no'] ; $i++)
		$description .= "<td>" . $row["selection$i"] . "&nbsp;</td>";
	$description .= "</tr>";
	return $description;
}

function create_html_2($row, $num, $type, $is_multiple){
	$question = "<tr><td>" . $row['question'] . "</td>";
	if($type == 2){
		$question .= "</tr><td><textarea name=\"survey_" . $row['survey_cd'] . "\"></textarea></td>";
	}else if($is_multiple == 0){
		for($i = 1 ; $i <= $num ; $i++)
			$question .= "<td><input type=\"radio\" name=\"survey_" . $row['survey_cd'] . "\" value=\"$i\"/></td>";
	}else{
		for($i = 1 ; $i <= $num ; $i++)
			$question .= "<td><input type=\"checkbox\" name=\"survey_" . $row['survey_cd'] . "[]\" value=\"$i\"/></td>";
	}
	$question .= "</tr>";
	return $question;
}

function all_questions($survey_no){
	$result = db_query("select * from `online_survey_content` where survey_no=$survey_no and block_id=0 order by sequence;");
	$i = 0;
	while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
		$res2 = db_query("select question, survey_cd from `online_survey_content` where survey_no=$survey_no and block_id=$row[survey_cd] order by sequence;");
		$j = 0;
		$questions = "";
		while(($row2 = $res2->fetchRow(DB_FETCHMODE_ASSOC)) != false)
			$questions[$j++] = create_html_2($row2, $row['selection_no'], $row['survey_type'], $row['is_multiple']);
		$groups[$i] = $row;
		$groups[$i]['num'] = $row['selection_no'] + 1;
		if($row['survey_type'] == 1)
			$groups[$i]['description'] = create_html_1($row);
		$groups[$i]['questions'] = $questions;
		$i++;
	}

	return $groups;
}

function displayTime($tpl, $time, $str){
	$month = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
	$month_list = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
	$date = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31);
	$date_list = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31");

	$tpl->assign($str . "_year_value", array($time['year'] - 1, $time['year'], $time['year']+1));
	$tpl->assign($str . "_year_list", array($time['year'] - 1, $time['year'], $time['year']+1));
	$tpl->assign($str . "_year_select", $time['year']);

	$tpl->assign($str . "_month_value", $month);
	$tpl->assign($str . "_month_list", $month_list);
	$tpl->assign($str . "_month_select", $time['mon']);

	$tpl->assign($str . "_day_value", $date);
	$tpl->assign($str . "_day_list", $date_list);
	$tpl->assign($str . "_day_select", $time['mday']);
}

function getDay($str){
	$tmp = $_GET[$str . "_year"] . "-" . $_GET[$str . "_month"] . "-" . $_GET[$str . "_day"];
	return $tmp;
}
?>

<?php
/*author: lunsrot
 * date: 2007/04/12
 */
require_once("../config.php");
require_once("../session.php");

$option = $_GET['option'];

switch($option){
	case "insert": insert(); break;
	case "delete": _delete(); break;
	case "connect": connect(); break;
	case "grade": grade(); break;
	default: view(); break;
}

function insert(){
	global $DB_CONN;
	$survey_cd = $_GET['survey_cd'];
	$block_id = $_GET['block_id'];
	$survey_no = $_GET['survey_no'];
	$continue = $_GET['continue_add'];

	$bankno = $_SESSION['bank_no'];

	$date = getCurTime();
	$num = count($survey_cd);
	if($num > 0){
		$result = db_query("select * from `online_survey_content` where survey_no=$survey_no and survey_cd=$block_id and block_id=0;");
		if($result->numRows() == 0){
			$row = $DB_CONN->getRow("select * from `survey_bank_question` where survey_bankno=$bankno and survey_cd=$block_id and block_id=0;", DB_FETCHMODE_ASSOC);
			db_query("insert into `online_survey_content` (survey_no, survey_bankno, survey_cd, block_id, survey_type, question, selection_no, selection1, selection2, selection3, selection4, selection5, selection6, is_multiple, mtime) values ($survey_no, $bankno, $row[survey_cd], 0, $row[survey_type], '$row[question]', $row[selection_no], '$row[selection1]', '$row[selection2]', '$row[selection3]', '$row[selection4]', '$row[selection5]', '$row[selection6]', $row[is_multiple], '$date');");
		}
	}
	for($i = 0 ; $i < $num ; $i++){
		$result = $DB_CONN->getRow("select * from `survey_bank_question` where survey_bankno=$bankno and survey_cd=$survey_cd[$i];", DB_FETCHMODE_ASSOC);
		db_query("insert into `online_survey_content` (survey_no, survey_bankno, survey_cd, block_id, question, mtime) values ($survey_no, $bankno, $result[survey_cd], $block_id, '$result[question]', '$date');");
	}

	if($continue == 0)
		header("location: ./edit_survey.php?option=connect&survey_no=$survey_no");
	else
		header("location: ./edit_survey.php?survey_no=$survey_no");
}

function view(){
	global $DB_CONN;
	$survey_no = $_GET['survey_no'];
	$block_id = $_GET['block_id'];

	$pid = getTeacherId();
	$_SESSION['bank_no'] = $bankno = $DB_CONN->getOne("select survey_bankno from `survey_bank` where personal_id=$pid;");

	$tpl = new Smarty;
	$tpl->assign("survey_no", $survey_no);
	//左邊的tree
	$block_id = tree($bankno, $block_id, $tpl);
	//右邊的已選及未選題目
	isChecked($bankno, $block_id, $survey_no, $tpl);

	assignTemplate($tpl, "/survey/edit_survey.tpl");
}

function tree($bankno, $block_id, $tpl){
	$result = db_query("select survey_cd, question from `survey_bank_question` where survey_bankno=$bankno and block_id=0 order by survey_cd;");
	$node_id = 2;
	while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
		if(empty($block_id))
			$block_id = $row['survey_cd'];
		$row['index'] = $node_id++;
		$tpl->append("question_data", $row);
	}
	$tpl->assign("block_id", $block_id);

	return $block_id;
}

function isChecked($bankno, $block_id, $survey_no, $tpl){
	global $DB_CONN;
	$result = db_query("select survey_cd, question from `survey_bank_question` where survey_bankno=$bankno and block_id=$block_id order by survey_cd;");
	$index = 1;
	$index2 = 1;
	while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
		$tmp = db_query("select sequence from `online_survey_content` where survey_no=$survey_no and survey_cd=$row[survey_cd] and block_id=$block_id;");
		if($tmp->numRows() == 0){
			$row['index'] = $index;
			$unchecked[$index-1] = $row;
			$index++;
		}else{
			$row['index'] = $index2;
			$checked[$index2-1] = $row;
			$index2++;
		}
	}
	$tpl->assign("num", count($unchecked));
	$tpl->assign("unchecked", $unchecked);
	$tpl->assign("num2", count($checked));
	$tpl->assign("checked", $checked);
}

function _delete(){
	$survey_cd = $_GET['survey_cd'];
	$block_id = $_GET['block_id'];
	$survey_no = $_GET['survey_no'];
	$continue = $_GET['continue_del'];

	$num = count($survey_cd);
	for($i = 0 ; $i < $num ; $i++){
  	  db_query("delete from `online_survey_content` where survey_no=$survey_no and survey_cd=$survey_cd[$i] and block_id=$block_id;");
	}   
	//check if no question in a survey_cd
	$result = db_query("select count(*) from `online_survey_content` where block_id=$block_id;"); 
        $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	if($row['count(*)'] == 0){	
	   db_query("delete from `online_survey_content` where survey_cd=$block_id;");
	}
	
	if($continue == 0)
		header("location: ./edit_survey.php?option=connect&survey_no=$survey_no");
	else
		header("location: ./edit_survey.php?survey_no=$survey_no");
  	 }

function connect(){
	$survey_no = $_GET['survey_no'];

	$tpl = new Smarty;

	$tpl->assign("survey_no", $survey_no);
	$tpl->assign("block_id", $_GET['block_id']);
	$result = db_query("select * from `online_survey_content` where survey_no=$survey_no and block_id=0 order by sequence;");
	$i = 0;
	while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
		if($row['survey_type'] == 1)
			$row['description'] = create_html_1($row);
		$res2 = db_query("select sequence, question from `online_survey_content` where survey_no=$survey_no and block_id=$row[survey_cd] order by sequence;");
		$j = 0;
		while(($row2 = $res2->fetchRow(DB_FETCHMODE_ASSOC)) != false)
			$row['quest'][$j++] = create_html_2($row2, $row['selection_no'], $row['survey_type']);
		$row['num'] = $row['selection_no'] + 1;
		$datas[$i++] = $row;
	}
	$tpl->assign("datas", $datas);

	assignTemplate($tpl, "/survey/connect.tpl");
}

function create_html_1($row){
	//單選題
	if($row['is_multiple'] == 0){
		$description = "<tr><td rowspan=\"2\">題目描述<input type=\"button\" class=\"btn\" value=\"自定配分\" onClick=\"calReadOnly($row[survey_cd]);\"/></td>";
		for($k = 1 ; $k <= $row['selection_no'] ; $k++)
			$description = $description . "<td>" . $row["selection$k"] . "&nbsp;</td>";
		$description .= "</tr><tr>";
		for($k = 1 ; $k <= $row['selection_no'] ; $k++){
			$description = $description . "<td><input type=\"text\" maxlength=\"2\" size=\"2\" name=\"survey_" . $row['survey_cd'] . "[]\" value=\"" . $row['selection_grade'][($k - 1)*2] . $row['selection_grade'][($k - 1)*2+1] . "\" readonly/></td>";
		}
	}
	//多選題
	else{
		$description = "<tr><td rowspan=\"2\">題目描述<input type=\"button\" class=\"btn\" value=\"自定配分\" onClick=\"calReadOnly($row[survey_cd]);\"/></td>";
		for($k = 1 ; $k <= $row['selection_no'] ; $k++)
			$description = $description . "<td>" . $row["selection$k"] . "&nbsp;</td>";
		$description .= "</tr><tr>";
		for($k = 1 ; $k <= $row['selection_no'] ; $k++){
			$description = $description . "<td><input type=\"text\" maxlength=\"2\" size=\"2\"  name=\"survey_" . $row['survey_cd'] . "[]\" value=\"" . $row['selection_grade'][($k - 1)*2] . $row['selection_grade'][($k - 1)*2+1] . "\" readonly/></td>";
		}
	}
	$description .= "</tr>";

	return $description;
}

function create_html_2($row, $num, $survey_type){
	$quest = "<tr><td>" . $row['question'] . "</td>";
	if($survey_type == 1){
		for($k = 1 ; $k <= $num ; $k++)
			$quest = $quest . "<td>&nbsp;</td>";
	}
	$quest .= "</tr>";
	return $quest;
}

function grade(){
	global $DB_CONN;
	$survey_no = $_GET['survey_no']; 

	$result = db_query("select survey_cd from `online_survey_content` where survey_no=$survey_no and block_id=0 and survey_type=1;");
	while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
		$tmp = $_GET[ "survey_$row[survey_cd]" ];
		for($i = 0 ; $i < count($tmp) ; $i++){
			if(!is_numeric($tmp[$i]) && empty($tmp[$i]))
				$tmp[$i] = count($tmp) - $i;
		}
		$grade = "";
		//此處先假設使用者只會輸入0~99，不會有三位數的出現
		for($i = 0 ; $i < 6 ; $i++){
			if($i >= count($tmp))
				$grade .= "00";
			else if($tmp[$i] >= 10)
				$grade .= $tmp[$i];
			else{
				$tmp[$i] += 0;
				$grade .= "0" . $tmp[$i];
			}
		}
		db_query("update `online_survey_content` set selection_grade='$grade' where survey_no=$survey_no and survey_cd=$row[survey_cd];");
	}
	header("location: ./edit_survey.php?option=connect&survey_no=$survey_no");
}
?>

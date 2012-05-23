<?php
/*author: lunsrot
 * date: 2007/05/15
 */
require_once("../config.php");
require_once("../session.php");
require_once("sur_info.php");

echo str_pad('', 1024);
$survey_no = $_GET['survey_no'];

$is_register = $DB_CONN->getOne("select is_register from `online_survey_setup` where survey_no=$survey_no;");
//不記名
if($is_register == 0){
	analysisAllData($survey_no);
}
//記名
else{
	$pid = $_GET['personal_id'];
	if(empty($pid))
		viewTable($survey_no);
	else
		analysisOneData($survey_no, $pid);
}

ob_flush(); 
flush(); //both needed to flush the buffer 
sleep(1); 

function analysisAllData($survey_no){
	global $DB_CONN;
	$tpl = new Smarty;
	$survey_name = $DB_CONN->getOne("select survey_name from `online_survey_setup` where survey_no=$survey_no;");
	$tpl->assign("survey_name", $survey_name);

	$res = db_query("select * from `survey_student` where survey_no=$survey_no;");
	$res1 = db_query("select * from `survey_student` where survey_no=$survey_no and survey_flag=1;");
	$num = $res->numRows();
	$num1 = $res1->numRows();
	$num2 = $num - $num1;
	$tpl->assign("survey_num1", $num1);
	$tpl->assign("survey_num2", $num2);

	$result = db_query("select * from `online_survey_content` where survey_no=$survey_no and block_id=0 order by sequence;");
	$i = 0;
	while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
	  	if($row['survey_type'] == 1)
	  	{
	  	  	$row['description'] = create_html_1($row);
			$row['description'] = substr($row['description'],0,-5);	//為了把</tr>刪掉，好把分數外掛進去
			$row['description'] .= "<td>平均分數</td></tr>";
	  	}
		$res2 = db_query("select survey_no, survey_cd, sequence, question from `online_survey_content` where survey_no=$survey_no and block_id=$row[survey_cd] order by sequence;");
		$j = 0;
		while(($row2 = $res2->fetchRow(DB_FETCHMODE_ASSOC)) != false)
		{
			$row['questions'][$j++] = create_html_3($row2, $row['selection_no'], $row['survey_type'], $row['is_multiple']);
		}
		$row['num'] = $row['selection_no'] + 1 + 1;  //後面的加1是為了把分數放上去
		$groups[$i++] = $row;
	}
	$tpl->assign("groups", $groups);
	assignTemplate($tpl, "/survey/analysisAllData.tpl");
	//assignTemplate($tpl, "/survey/analysisOneData.tpl");
}

function analysisOneData($survey_no, $pid){
	global $DB_CONN;
	$tpl = new Smarty;

	$survey_name = $DB_CONN->getOne("select survey_name from `online_survey_setup` where survey_no=$survey_no;");
	$tpl->assign("survey_name", $survey_name);

	$result = db_query("select * from `online_survey_content` where survey_no=$survey_no and block_id=0 order by sequence;");
	$i = 0;
	while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
		if($row['survey_type'] == 1)
			$row['description'] = create_html_1($row);
		$res2 = db_query("select survey_no, survey_cd, sequence, question from `online_survey_content` where survey_no=$survey_no and block_id=$row[survey_cd] order by sequence;");
		$j = 0;
		while(($row2 = $res2->fetchRow(DB_FETCHMODE_ASSOC)) != false)
			$row['questions'][$j++] = createHTML_person($row2, $row['selection_no'], $row['survey_type'], $row['is_multiple'], $pid);
		$row['num'] = $row['selection_no'] + 1;
		$groups[$i++] = $row;
	}
	$tpl->assign("groups", $groups);

	assignTemplate($tpl, "/survey/analysisOneData.tpl");
}

function viewTable($survey_no){
	global $DB_CONN;
	$tpl = new Smarty;

	$result = db_query("select personal_id from `survey_student` where survey_no=$survey_no;");
	while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
		$tmp =  $DB_CONN->getRow("select A.personal_name, A.personal_id, B.login_id, C.survey_flag from `personal_basic` A, `register_basic` B, `survey_student` C where A.personal_id=$row[personal_id] and B.personal_id=$row[personal_id] and C.personal_id=$row[personal_id] and C.survey_no=$survey_no;", DB_FETCHMODE_ASSOC);
		$tpl->append("people", $tmp);
	}
	$tpl->assign("survey_no", $survey_no);

	assignTemplate($tpl, "/survey/viewtable.tpl");
}

function create_html_3($row, $num, $survey_type, $is_mulitple){
	$quest = "<tr><td>" . $row['question'];
	//簡答題
	if($survey_type != 1){
		$quest .= "<br/><ul>" . returnComments($row) . "</ul></td>";
	}
	//單選題
	else if($is_mulitple != 1){
		$quest .= "</td>";
		$quest .= returnPercent1($row, $num);
	}
	//多選題
	else{
		$quest .= "</td>";
		$quest .= returnPercent2($row, $num);
	}
	$quest .= "</tr>";
	return $quest;
}

function createHTML_person($row, $num, $survey_type, $is_multiple, $pid){
	global $DB_CONN;

	$res_no = $DB_CONN->getOne("select response_no from `online_survey` where survey_no=$row[survey_no] and personal_id=$pid;");
	$quest = "<tr><td>" . $row['question'];
	if($survey_type != 1)
		$quest .= "<br/><ul><li>" . returnComment($res_no, $row['survey_cd']) . "</li></ul></td>"; 
	else if($is_multiple != 1){
		$quest .= "</td>";
		$quest .= returnSingle($res_no, $row['survey_cd'], $num);
	}else{
		$quest .= "</td>";
		$quest .= returnMulti($res_no, $row['survey_cd'], $num);
	}
	$quest .= "</tr>";
	return $quest;
}

function returnComment($res_no, $survey_cd){
	global $DB_CONN;
	$res = $DB_CONN->getOne("select response from `online_survey_response` where response_no=$res_no and survey_cd=$survey_cd;");
	return $res;
}

function returnComments($row){
	global $DB_CONN;
	$quest = "";
	$responses = db_query("select response_no from `online_survey` where survey_no=$row[survey_no];"); 
	while(($row1 = $responses->fetchRow(DB_FETCHMODE_ASSOC)) != false){
		$response = $DB_CONN->getOne("select response from `online_survey_response` where response_no=$row1[response_no] and survey_cd=$row[survey_cd];");
		$quest .= "<li>$response</li>";
	}
	return $quest;
}

function returnPercent1($row, $num){
  	$quest = "";
	//順便算一下得分
	$score = 0;
	$tmp = db_query("select response from `online_survey_response` A, `online_survey` B where B.survey_no=$row[survey_no] and A.response_no=B.response_no and A.survey_cd=$row[survey_cd];"); 
	$sum = $tmp->numRows();
	$selection_grade = db_getOne("select selection_grade from online_survey_content where survey_no = $row[survey_no]");
	for($i = 1 ; $i <= $num ; $i++){
		$tmp = 0;
		$res = db_query("select response from `online_survey_response` A, `online_survey` B where B.survey_no=$row[survey_no] and A.response_no=B.response_no and A.survey_cd=$row[survey_cd] and A.response='$i';"); 
		if($sum != 0)
		  $tmp = ($res->numRows()/$sum)*100;
		  $tmp =  round($tmp,2);
		$quest .= "<td>$tmp%</td>";
		$score += ((int)substr($selection_grade,2*$i,2))*$res->numRows();
	}
	//把分數外掛在最後面XD
	$score = $score / $sum;
	$quest .= "<td>$score</td>";
	return $quest;
}

function returnPercent2($row, $num){
	$quest = "";
	//順便算一下得分
	$score = 0;
	$tmp = db_query("select response from `online_survey_response` A, `online_survey` B where B.survey_no=$row[survey_no] and A.response_no=B.response_no and A.survey_cd=$row[survey_cd];"); 
	$sum = $tmp->numRows();
	$selection_grade = db_getOne("select selection_grade from online_survey_content where survey_no = $row[survey_no]");
	for($i = 1 ; $i <= $num ; $i++){
		$tmp = 0;
		$res = db_query("select response from `online_survey_response` A, `online_survey` B where B.survey_no=$row[survey_no] and A.response_no=B.response_no and A.survey_cd=$row[survey_cd] and A.response like '%$i;%';"); 
		if($sum != 0)
			$tmp = ($res->numRows()/$sum)*100;
		$quest .= "<td>$tmp%</td>";
		$score += ((int)substr($selection_grade,2*$i,2))*$res->numRows();
	}
	//把分數外掛在最後面XD
	$score = $score / $sum;
	$quest .= "<td>$score</td>";
	return $quest;
}

function returnSingle($res_no, $survey_cd, $num){
	global $DB_CONN;
	$quest = "";
	$res = $DB_CONN->getOne("select response from `online_survey_response` where response_no=$res_no and survey_cd=$survey_cd;");
	for($i = 1 ; $i <= $num ; $i++){
		$quest .= "<td>";
		if($i == $res)
			$quest .= "<input type=\"radio\" readonly checked/>";
		$quest .= "</td>";
	}
	return $quest;
}

function returnMulti($res_no, $survey_cd, $num){
	global $DB_CONN;
	$quest = "";
	$tmp = "";
	$res = $DB_CONN->getOne("select response from `online_survey_response` where response_no=$res_no and survey_cd=$survey_cd;");
	for($i = 0 ; $i <= $num ; $i++)
		$tmp[$i] = 0;
	for($i = 0 ; $i < strlen($res) ; $i++)
		$tmp[ $res[$i * 2] ] = 1;
	for($i = 1 ; $i <= $num ; $i++){
		$quest .= "<td>";
		if($tmp[$i] == 1)
			$quest .= "<input type=\"checkbox\" readonly checked/>";
		$quest .= "</td>";
	}
	return $quest;
}
?>

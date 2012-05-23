<?php
/*author: tkraha
 * date: 2007/11/18
 */
	require_once("../config.php");
	require_once("../session.php");	
	checkAdmin();
	$tpl = new Smarty();
	
	$input = $_GET;
	if(empty($input['action']))
	{
		$tpl->assign("show",0);
	        assignTemplate($tpl, "/learner_profile/list_teacher.tpl");
	}
	else
		call_user_func($input['action'], $input);

//function area======================================================================================================

function search($input){

	global $DB_CONN, $tpl;	

	switch($_POST[search]){
		case 'all':
			$sql = "SELECT * FROM register_basic r inner join personal_basic p using(personal_id) WHERE r.role_cd=1 order by p.personal_name";
			break;
		case 'login_id':
			$sql = "SELECT * FROM register_basic r inner join personal_basic p using(personal_id) WHERE r.role_cd=1 and r.login_id like '%".$_POST[login_id]."%' order by p.personal_name";
			break;
		case 'personal_name':
			$sql = "SELECT * FROM register_basic r inner join personal_basic p using(personal_id) WHERE r.role_cd=1 and p.personal_name like '%".$_POST[personal_name]."%' order by p.personal_name";
			break;
		case 'state':
			$sql = "SELECT * FROM register_basic r inner join personal_basic p using(personal_id) WHERE r.role_cd=1 and r.login_state='".$_POST[state]."' order by p.personal_name";
			break;
		case 'validate':
			$sql = "SELECT * FROM register_basic r inner join personal_basic p using(personal_id) WHERE r.role_cd=1 and r.validated='".$_POST[validate]."' order by p.personal_name";
			break;
		default:
			$sql = "SELECT * FROM register_basic r inner join personal_basic p using(personal_id) WHERE r.role_cd=1 order by p.personal_name";
			break;	
	}	
	//echo $sql;
	$res = $DB_CONN->query($sql);
	while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
		if($row[login_state] == NULL)$row[login_state] = 0;
		if($row[validated] == NULL)$row[validated] = 0;
		$row[state]	=  getLoginState($row[login_state]);
		$row[vali]	=  getValidated($row[validated]);
		$row[login_id]  =  "<a href=\"user_profile.php?id=".$row[personal_id]."\" target=\"_blank\">".$row[login_id]."</a>";
		$tpl->append("data_list", $row);
	}
	$tpl->assign("show",1);
	
	assignTemplate($tpl, "/learner_profile/list_teacher.tpl");	
}

function getLoginState($input){
	
	$output = array('不使用','使用');
	return $output[$input];
}

function getValidated($input){
	
	$output = array('不核准','核准');
	return $output[$input];
}
?>

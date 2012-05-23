<?php
include "../config.php";
require_once("../session.php");

checkAdminAcademic();
session_start();
	
$tpl = new Smarty;
//require_once($HOME_PATH . 'library/smarty_init.php');

    $sql = "SELECT A1.content_cd, A1.id, A4.content_name AS name, A2.caption AS caption, A3.login_id AS checker, A1.page AS page , A1.content AS content, A1.reportdate AS reportdate
        FROM error_content_report A1, class_content A2, register_basic A3 , course_content A4
        WHERE A1.enable = 0
        AND A1.menu_id = A2.menu_id
        AND A1.personal_id = A3.personal_id
        AND A2.content_cd = A4.content_cd
        ORDER BY A1.reportdate ASC";


$result = db_query($sql);
$cnt = 0;


while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
{
    $sql="SELECT A2.login_id AS te_name FROM course_content A1, register_basic A2
            WHERE A1.content_cd=". $row['content_cd']. "
                AND A1.teacher_cd=A2.personal_id";
    
     $row['te_name']=db_getOne($sql);
    $data_list[]=$row;
		$cnt++;

}

$tpl->assign("cnt",$cnt);
$tpl->assign("content2", $data_list);

assignTemplate($tpl, '/teaching_material/textbook_error_check.tpl');
?>

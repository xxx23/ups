<?php
include "../config.php";
require_once("../session.php");

$Content_cd = $_GET['content_cd'];

$sql = "select content_name from course_content where content_cd = ".$Content_cd ;
$Caption = db_getOne($sql);

$tpl = new Smarty;
$tpl->assign("Content_cd",$Content_cd);	//assign "課程科目教材編號"
$tpl->assign("Caption",$Caption);	//assign "課程科目教材名稱"

//$sql = "select * from class_content_error where content_cd = '$Content_cd' order by menu_id asc";

$sql = "SELECT A2.caption AS caption , A1.personal_id AS personal_id , A1.page AS page , A1.content AS content 
	FROM class_content_error A1, class_content A2 
	WHERE A1.content_cd = ".$Content_cd."  
		AND A1.menu_id = A2.menu_id 
	ORDER BY A1.menu_id ASC 
    ";

$result = db_query($sql);
$cnt = 0;
while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
{

	$sql="SELECT personal_name
			FROM personal_basic
			WHERE personal_id =". $row['personal_id'];
		
		$checkerName = db_getOne($sql);
		$row['checkerName'] = $checkerName ;
			
		$tpl->append("content2",$row);
		$cnt++;
}
$tpl->assign("cnt",$cnt);	//錯誤筆數

assignTemplate( $tpl,"/teaching_material/textbook_error_content.tpl");


?>

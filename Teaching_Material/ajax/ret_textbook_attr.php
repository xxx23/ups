<?php
/*id: ret_textbook_attr.php v1.0 hushpuppy 2007/3/27 v1.0 Exp.*/
/*function: 在教材修改頁面中，根據使用者選擇的教材編號，動態取回教材屬性回傳*/
include "../../config.php";
require_once("../../session.php");

$Content_cd = $_GET['content_cd'];
$sql = "select * from course_content where content_cd = '$Content_cd';";
$result = db_query($sql);

$row = $result->fetchRow(DB_FETCHMODE_ASSOC);


// it is better to use json to popout as js variable 
$msg=	'content_name:' . $row['content_name'] . ';degree:' . $row['difficulty'].
 	';content_type:' . $row['content_type'] . ';is_public:' . $row['is_public'];

echo $msg;

file_put_contents("debug.txt",$msg);
?>

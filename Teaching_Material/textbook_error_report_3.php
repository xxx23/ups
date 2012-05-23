<?php
include "../config.php";
require_once("../session.php");

$Content_cd=$_GET['content_cd'];
$menu_id=$_GET['menu_id'];

$reporter=$_POST['reporter'];
$chapter=$_POST['chapter'];
$page=$_POST['page'];
$content=$_POST['content'];

$sql="insert into error_content_report (content_cd, menu_id, personal_id, page, content, reportdate) 
    VALUES ('".$Content_cd."', '".$menu_id."', '".$_SESSION['personal_id']."', '".$page."','".$content."',now())";
db_query($sql);

$tpl=new Smarty;
$tpl->assign("content_cd", $Content_cd);
$tpl->assign("menu_id", $menu_id);
$tpl->assign("reporter", $reporter);
$tpl->assign("chapter", $chapter);
$tpl->assign("page" ,$page);
$tpl->assign("content", $content);
assignTemplate( $tpl,"/teaching_material/textbook_error_report_3.tpl");
?>

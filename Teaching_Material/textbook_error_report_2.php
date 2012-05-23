<?php
include "../config.php";
require_once("../session.php");
//include("./lib/error_textbook_tree.inc");
$Content_cd = $_GET['content_cd'];
$menu_id=$_GET['menu_id'];

//$reporter=$_POST['reporter'];
//$chapter=$_POST['chapter'];
//$page=$_POST['page'];
//$content=$_POST['content'];


//$sql="insert into error_content_report (content_cd, menu_id, personal_id, page, content) VALUES ('".$Content_cd."', '".$chapter."', '".$_SESSION['personal_id']."', '".$page."','".$content."');";
//db_query($sql);

//$sql = "select content_name from course_content where content_cd = ".$Content_cd ;
//$Caption = db_getOne($sql);
//$sql= "select * from class_content where content_cd = $Content_cd order by cast(menu_parentid as unsigned) asc, seq asc;";
//$AddNode = buildTreeStructure($sql, $Content_cd,0);
//$AddNode = str_replace("tea_","stu_",$AddNode);
//$Script_path = $WEBROOT . $JAVASCRIPT_PATH ;
if(!isset($menu_id))
    $menu_id=-1;
$sql="select caption from class_content where menu_id=".$menu_id;
$chapter_name=db_getOne($sql);

$Personal_id=$_SESSION['personal_id'];
$sql="SELECT personal_name
      FROM personal_basic
      WHERE personal_id = $Personal_id";
$checkerName = db_getOne($sql);

$tpl= new Smarty;
$tpl->assign("menu_id", $menu_id);
$tpl->assign("reporter", $checkerName);
$tpl->assign("chapter", $chapter_name);
//$tpl->assign("script_path",$Script_path);
//$tpl->assign("WEBROOT",$WEBROOT);
//$tpl->assign("addNode", $AddNode);
$tpl->assign("Caption", $Caption);
$tpl->assign("Content_cd", $Content_cd);

assignTemplate( $tpl,"/teaching_material/textbook_error_report_2.tpl");
?>

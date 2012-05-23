<?php
include "../config.php";
require_once("../session.php");
//checkMenu("/Teaching_Material/textbook_manage.php");

global $Begin_course_cd ;	//開課編號
global $DB_CONN;
//global $WEBROOT;
//if($_SERVER['REMOTE_ADDR']=='140.123.105.196')
  //  var_dump($WEBROOT);
$Content_cd = $_GET['content_cd'];
$sql = "select * from class_content where content_cd = $Content_cd order by menu_parentid,seq asc;";

$AddNode = buildTreeStructure($sql,$Content_cd);

$template = $HOME_PATH."themes/".$_SESSION['template'];
$tpl = new Smarty;

//print $AddNode;
$tpl->assign("addNode",$AddNode); //build tree
$tpl->assign("Content_cd",$Content_cd);	//assign "課程科目教材編號" for inserting node
assignTemplate($tpl, "/teaching_material/error_report_func.tpl");

function buildTreeStructure($sql,$Content_cd) {
        global $Begin_course_cd, $DB_CONN, $JAVASCRIPT_PATH ,$WEBROOT;

        $Personal_id = $_SESSION['personal_id'];
        $result = $DB_CONN->query($sql);
        if(PEAR::isError($result))      die($result->userinfo);

        $t = "";
        $r = "";
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
        if($row['menu_parentid'] == 0){
	  $icon_path = $row['icon'];
	  $new_url = str_replace("tea_start.php","textbook_error_report_2.php",$row['url']);
	  $new_url = $new_url."&menu_id=".$row['menu_id'];
        }
	else{
	  $new_url = str_replace("tea_textbook_content.php","textbook_error_report_2.php",$row['url']);
          if(is_viewed($Content_cd, $Personal_id, $row['menu_id']) == 1){
            //$icon_path = "/script/nlstree/img/icon_open.gif";
            $icon_path = $WEBROOT . "/script/nlstree/img/mydocopen.gif";
          }
          else
            $icon_path = $WEBROOT . $row['icon'];

        }
	

        $t .= "tree.add(\"" . $row['menu_id'] . "\", " .
          "\"" . $row['menu_parentid'] . "\", " .
      "\"" . $row['caption'] . "\", " .
      "\"" . $new_url . "\", " .
      "\"" . $icon_path . "\", " .
      $row['exp'] . ", " .
          "false " .
      ");\n";
    }

        return $t.$r;
}

function is_viewed($Content_cd, $Personal_id, $Menu_id){
  global $DB_CONN;
  $Begin_course_cd = $_SESSION['begin_course_cd'];
  $sql = "select * from student_learning where
    begin_course_cd = '$Begin_course_cd' and
    content_cd = '$Content_cd' and
    personal_id = '$Personal_id' and
    menu_id = '$Menu_id'";
  $result = $DB_CONN->query($sql);
  if(PEAR::isError($result))      die($result->userinfo);
  if($result->numRows() == 0)
    return 0;
  else
    return 1;
}

?>

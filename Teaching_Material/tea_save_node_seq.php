<?php
/* id: tea_loadTreeFromDB.php 2007/2/8 by hushpuppy Exp. */
/* function: 由資料庫中取出資料建課程樹狀結構,教師身分使用 */

include "../config.php";
require_once("../session.php");

checkMenu("/Teaching_Material/textbook_manage.php");

global $Begin_course_cd ;	//開課編號
global $DB_CONN;

$Content_cd = $_GET['content_cd'];
$sql = "select * from class_content where content_cd = $Content_cd order by menu_parentid,seq asc;";

$AddNode = buildTreeStructure($sql,$Content_cd);

$template = $HOME_PATH."themes/".$_SESSION['template'];
$smtpl = new Smarty;

//print $AddNode;
$smtpl->assign("addNode",$AddNode); //build tree
$smtpl->assign("Content_cd",$Content_cd);	//assign "課程科目教材編號" for inserting node
assignTemplate($smtpl, "/teaching_material/tea_save_node_seq.tpl");

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
	  $new_url = str_replace("tea_start.php","tea_node_seq_content.php",$row['url']);
	  $new_url = $new_url."&menu_id=".$row['menu_id'];
        }
	else{
	  $new_url = str_replace("tea_textbook_content.php","tea_node_seq_content.php",$row['url']);
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

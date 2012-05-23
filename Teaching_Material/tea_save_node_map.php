<?php
/* 教材節點名稱與目錄名稱之對應
 * edit by tgbsa
 * 06/20/09
 * */
include "../config.php";
require_once("../session.php");

$Content_cd = $_GET['content_cd'];
$Action = $_GET['action'];

$tpl = new Smarty;

//編輯節點與實際資料夾名稱之對應
if($Action == "edit"){
$sql = "select *  from class_content where content_cd='$Content_cd' order BY cast(menu_parentid as unsigned) , seq asc";	
$result =  $DB_CONN->query($sql);

$root_menu_id = -1;
//資料庫中讀取該教材底下tree node的資訊
while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
    $i = $row['menu_id'];
    if($root_menu_id == -1){
       $root_menu_id = $i;
    }
    $Tree_node_list[$i]['caption'] = $row['caption'];
    $Tree_node_list[$i]['file_name'] = $row['file_name'];
    $Tree_node_list[$i]['menu_id'] = $row['menu_id'];
    $Tree_node_list[$i]['menu_parentid'] = $row['menu_parentid']; 
    $Tree_node_list[$i]['seq'] = $row['seq'];
}
    $root="<input type='text' id='rootCaption' name='rootCaption'  value='{$Tree_node_list[$root_menu_id]['caption']}'>&lt;=&gt;\n"; 
    $root.="<input type='text' id='rootFileName' name='rootFileName'  value='{$Tree_node_list[$root_menu_id]['file_name']}'>\n";
    $root.="<input type='hidden' id='rootMenuId' name='rootMenuId' value='{$Tree_node_list[$root_menu_id]['menu_id']}'>\n";
    $tpl->assign("root",$root);

//well_print($Tree_node_list);
foreach ($Tree_node_list as $pid=>$p) {

        if (!$p['menu_parentid']) {
            continue;
        }
        if (!isset($Tree_node_list[$p['menu_parentid']]['children'])){
            $Tree_node_list[$p['menu_parentid']]['children'] = array();
        }
        $Tree_node_list[$p['menu_parentid']]['children'][$p['menu_id']] =& $Tree_node_list[$pid];
    }


//index of array	
$i = 0;
ob_start();
print_message_begin_nest($Tree_node_list);
$mapping_Buff = ob_get_contents();
ob_end_clean();


$tpl->assign("action",$Action);
$tpl->assign("mapping_Buff",$mapping_Buff);
assignTemplate( $tpl,"/teaching_material/tea_save_node_map.tpl");

}

//儲存節點與實際資料夾名稱之對應
else if($Action == "save"){

$Teacher_cd = $_SESSION['personal_id'];

  //更改root資訊   
  $sql = "update class_content set caption='{$_POST['rootCaption']}',file_name='{$_POST['rootFileName']}' where menu_id='{$_POST['rootMenuId']}'";	
  $r = $DB_CONN->query($sql);

  //取得menu的數量
  $num = sizeof($_POST['caption']);
  for($j = 0 ; $j < $num ; $j++){
      $sql = "update class_content set caption='{$_POST['caption'][$j]}',file_name='{$_POST['file_name'][$j]}' where menu_id='{$_POST['menu_id'][$j]}'";	
      $r = $DB_CONN->query($sql);
  } 
 $tpl->assign("action",$Action);
 assignTemplate( $tpl,"/teaching_material/tea_save_node_map.tpl");
}




function print_message_begin_nest($posts) 
{
	global  $new_tree_node_list,$i;	
	foreach($posts as $pid => $post) {
		if(!$post['menu_parentid']) {
			print_message_post_nest($posts, $post);
		}
	}
}

function print_message_post_nest($posts, $parent) 
{
	global  $new_tree_node_list , $i;
	if( !empty( $posts[$parent['menu_id']]['children'] )){
		  	echo "<div style='margin-left:2em'>\n";  
		foreach($posts[$parent['menu_id']]['children'] as $pid => $post) {
		  	echo "<div>\n";
			echo "<input type='text' id='caption[]' name='caption[]'  value='{$post['caption']}'>&lt;=&gt;\n";
		        echo "<input type='text'id='file_name[]' name='file_name[]' value='{$post['file_name']}'>\n";
			echo "<input type='hidden' id='menu_id[]' name='menu_id[]' value='{$post['menu_id']}'>\n";				  
			echo "</div>\n";
			print_message_post_nest($posts, $post); 
		}
			echo "</div>\n\n";
	}
}


?>

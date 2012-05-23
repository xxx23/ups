<?php
/********************************************************/
/* id: export_xml.php v1.0 2007/5/15 by hushpuppy Exp.  */
/* function: 產生imsmanifest.xml	相關的function			*/
/********************************************************/

require_once("../session.php");

//在imamanifest.xml中產生樹狀目錄結構的branch nodes
function generate_branch_nodes($doc, $root, $Content_cd){
	global $DB_CONN;
	
	$content_file_name = str_replace(" ","_",$content_name);
	
	$sql = "select * from class_content where content_cd = '$Content_cd' order by menu_parentid ,seq;";
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->userinfo);
	
	$seq_num = 1;
	//先將dom object create好，存入hash table以便後續存取
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
	  if($row['menu_parentid'] == 0)
			continue;
		//well_print($row);
		$identifier = "ITEM-".$row['menu_id'];
	  	$identifierref = "RES-".$row['menu_parentid']."-".$seq_num;
		$isvisible = "true";
		$new_node = $doc->createElement("item");
		$new_node->setAttribute("identifier", $identifier);
		$new_node->setAttribute("identifierref", $identifierref);
		$new_node->setAttribute("isvisible", $isvisible);
		
		$hash_table[$identifier] = $new_node;
	        $seq_num++;
	}
	

	//先找出root的menu_id
	$sql_get_root_id = "select menu_id from class_content where content_cd = '$Content_cd' and menu_parentid = '0'";
	$root_id = $DB_CONN->getOne($sql_get_root_id);
	if(PEAR::isError($root_id))	die($root_id->userinfo);
	
	//從root開始將每個node append child
	$result = $DB_CONN->query($sql);
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
		if($row['menu_parentid'] == 0)
			continue;
		//當為第一層node時
		if($row['menu_parentid'] == $root_id){
			$parent_node = $root;
		}
		else{//找出這一個node的parent node
			$id = "ITEM-".$row['menu_parentid'];
			$parent_node = $hash_table[$id];
		}
		//從hash table中取出這一個node
		$this_node_id = "ITEM-".$row['menu_id'];
		$this_node = $hash_table[$this_node_id];

		
		//加在parent底下
		$parent_node->appendChild($this_node);
		
		//這個node的title
		$this_node_title = $this_node->appendChild($doc->createElement("title"));
		
		//加入這個node的title caption
		$this_node_title->appendChild($doc->createTextNode($row['caption'])); //匯出資料目前caption != file_name

		//由子node串接file_name到root	
		$relative_path = get_path($Content_cd, $row['menu_id'], $root_id);
		
		append_resources($doc, $this_node, $row['menu_id'], $relative_path , $row['file_name']);
	}
}

//由本身的menu_id取得教材目錄下檔案相對路徑
function get_path($content_cd, $menu_id, $root_id){
	global $DB_CONN, $store_path;
	
	$this_id = $menu_id;
	$i = 0;
	while($this_id != $root_id){
		$sql = "select * from class_content where content_cd = '$content_cd' and menu_id = '$this_id';";
		$result = $DB_CONN->query($sql);
		if(PEAR::isError($result))	die($result->userinfo);
		
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$array[$i] = $row['file_name'];
		$this_id = $row['menu_parentid'];
		
		$i++;
	}
	for($j = $i-1 ; $j >= 0 ; $j--)
		$path .= $array[$j] ."/";
	return $path;
}

//將每個資料夾底下的檔案當作resource對映上父節點
function append_resources($doc, $this_node, $parent_id, $relative_path , $file_name){
	global $DB_CONN, $store_path;
	//$curr_path = $store_path."/".$relative_path;
	$curr_path = $store_path;
	
	//取得resource節點
	$resource_node = $doc->getElementsByTagName('resources');
	$resource_node = $resource_node->item(0);
	
//	$seq_num = 1;
//	$d = dir($curr_path);
    /*while (($file_name = $d->read()) != false) {
		//若為資料夾，則skip
		if (strcmp($file_name,".") == 0 || strcmp($file_name,"..") == 0 || is_dir($curr_path.$file_name) == true)
			continue;
     */			
/*		$identifier = "ITEM-".$parent_id."-RES-".$seq_num;
		$resource_id = "RES-".$parent_id."-".$seq_num;
		$isvisible = "true";
 */
		//------------------------------加上item節點---------------------------------------------------
/*		
		$new_node = $doc->createElement("item");
		$new_node->setAttribute("identifier", $identifier);
		$new_node->setAttribute("isvisible", $isvisible);
		$new_node->setAttribute("identifierref", $resource_id);
		$new_node_title = $new_node->appendChild($doc->createElement("title"));
		$new_node_title->appendChild($doc->createTextNode($file_name));
		
		$this_node->appendChild($new_node); //加上item
 */		
		//------------------------------加上resource節點----------------------------------------------
		$new_res_node = $doc->createElement("resource");
		$new_res_node->setAttribute("identifier", $this_node->getAttribute("identifierref"));
		$new_res_node->setAttribute("adlcp:scormType", "asset");
		$new_res_node->setAttribute("type", "webcontent");
		$new_res_node->setAttribute("href", $file_name);
		
		$new_res_node_title = $new_res_node->appendChild($doc->createElement("file"));
		$new_res_node_title->setAttribute("href",$file_name);
		
		$resource_node->appendChild($new_res_node);	//加上resource
		
		//$seq_num++;
//	}
}
?>

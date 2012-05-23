<?php
/**********************************************************/
/* id: textbook_func.inc 2007/10/3 v2.0 by hushpuppy Exp. */
/* function: 與筆記本顯示相關的function整理 		  */
/* function: 由資料庫中取出資料並連成javaxcript字串       */
/**********************************************************/
function buildTreeStructure($sql,$Content_cd) {
	global $Begin_course_cd, $DB_CONN, $WEBROOT;

	//print $sql;
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->userinfo);
 	$t = "";
	$r = "";
  	while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
	if($row['menu_parentid'] == 0)
		$r .= "tree.setNodeCtxMenu(".$row['menu_id'].",ctx2);\n";  //設定根節點disable menu，檔名取ctx2才不會有問題...@@

	if(trim($row['icon']) == "")
		$tmp = "";
	else
		$tmp = substr($WEBROOT, 0, -1) . trim($row['icon']);
   	$t .= "tree.add(\"" . $row['menu_id'] . "\", " .
   	  "\"" . $row['menu_parentid'] . "\", " .
      "\"" . $row['caption'] . "\", " .
      "\"" . $row['url'] . "\", " .
      "\"" . $tmp . "\", " .
      $row['exp'] . ", " .
   	  "false " .
      ");\n";
    }
	/*if(empty($t))
		$t = "tree.add(1, 0, \"目前沒有任何資料\", \"\", \"\", true);";
	*/
	return $t.$r;
}

//function: 傳入menu_id，將目前路徑存入session
function assign_path($tmp_id, $smtpl)
{
  global $DB_CONN, $current_dir, $path;
  $i = 0;
  $tmp_id = $_SESSION['menu_id']; //當上傳檔案時，menu_id為空，所以跟session取得
	while($tmp_id != 0)
	{
		$sql = "select * from notebook_content where menu_id = $tmp_id;";
		$result = $DB_CONN->query($sql);
		if(PEAR::isError($result))	die($result->getMessage());
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$array[$i] = $row['caption'];
	
		$tmp_id = $row['menu_parentid'];
		$i++;
	}
	for($j = $i-1 ; $j >= 0 ; $j--)
		$path .= $array[$j] ."/";
	//$path = str_replace(" ","\ ",$path);
	//$smtpl->assign("test",$path);
	for($j = $i ; $j >= 0 ; $j--){
		if($i == $j || $j == 0)
			$smtpl->append('content',$array[$j]);
		else
			$smtpl->append('content',$array[$j]." >>");
	}
	$smtpl->assign(dir_name,$array[0]);
	$_SESSION['current_nb_path'] = $path;	//restore current path into session
}	

/*function: 上傳檔案*/
function multiupload($name, $FILE_PATH){
  	$FILE_PATH = $_SESSION['current_nb_path'];
	$c = count($_FILES[$name]['name']);
	$tmp_name = $_FILES[$name]['name'];
	
    for( $i = 0 ; $i < $c ; $i++){
		$type = $_FILES[$name]['type'][$i];
		if( $type == "application/x-php" || $type == "application/x-js"){
			header("Location: ../alert.html");
			return;
		}
    	$q_file = $_FILES[$name]['name'][$i];
        if($q_file == "")
        	continue;
		//insertData($q_file);
        FILE_upload($_FILES[$name]['tmp_name'][$i], $FILE_PATH, $q_file);
    }
}

/*function: 顯示當前目錄下所有檔案*/
function show_files($smtpl, $current_path)
{
	global $DB_CONN, $path, $smtpl;
	//$smtpl->assign("test",$path);
	$Notebook_cd = $_SESSION['notebook_cd'];
	$d = dir($path);
	while( ($file_name = $d->read()) != false){
		if (strcmp($file_name,".") == 0 || strcmp($file_name,"..") == 0)
		  continue;

		if(is_dir($current_path.$file_name))
		  $row['dir'] = 1;
		else
		  $row['dir'] = 0;
		$file_path = $path.$file_name;
		$row['content_name'] = $file_name;
		$row['file_name_encode'] = urlencode($file_name);
		$row['file_size'] = filesize($file_path);
		$row['file_time'] = date("F d Y H:i:s.", fileatime($file_path));

		$smtpl->append("content2",$row);
	}
	$file_path1 = $path."index.html";
	$file_path2 = $path."index.htm";
	$index_exist1 = false;
	$index_exist2 = false;

	if(file_exists($file_path1))
	  $index_exist1 = true;
	if(file_exists($file_path2))
	  $index_exist2 = true;
	if($index_exist1 == false && $index_exist2 == false)
		$smtpl->assign("index_show",0);	//預覽時顯示檔案list
	else{
	  if($index_exist1 == true){
	    $handle = fopen($file_path1, "r");	//開啟index.html並將內容塞回textarea
	    $smtpl->assign("index_show",1);	//預覽時顯示index.html
	  }
	  else if($index_exist2 == true){
	    $handle = fopen($file_path2, "r");
	    $smtpl->assign("index_show",2);	//預覽時顯示index.htm
	  }
	  $index_content = fread($handle, 2096);
	  $smtpl->assign("index_content",$index_content);
	}
}

function edit_index()
{
	global $smtpl, $path, $DB_CONN;
	$Content = $_POST['index_content'];
	$Notebook_cd = $_SESSION['notebook_cd'];
	$Menu_id = $_SESSION['menu_id'];
	$Personal_id = $_SESSION['personal_id'];
	//$content = stripslashes($content);

	//檢查是否已經有內容
	$sql = "select * from notebook_node_content where notebook_cd = '$Notebook_cd' and menu_id = '$Menu_id' and personal_id = '$Personal_id'";
	$result = $DB_CONN->query($sql);
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	if(empty($row)){	  
	  $sql = "insert into notebook_node_content (notebook_cd, personal_id, menu_id, notebook_content)
	    values ('$Notebook_cd', '$Personal_id', '$Menu_id', '$Content')";
	}
	else
	  $sql = "update notebook_node_content set notebook_content = '$Content' where notebook_cd = '$Notebook_cd' and personal_id = '$Personal_id' and menu_id = '$Menu_id'";

	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result)) die($result->userinfo);
}

function show_content($smtpl, $Notebook_cd, $Menu_id)
{
  $Notebook_cd = $_SESSION['notebook_cd'];
  $Menu_id = $_SESSION['menu_id'];
  $Personal_id = $_SESSION['personal_id'];
  global $DB_CONN;
  $sql = "select notebook_content from notebook_node_content where notebook_cd = '$Notebook_cd' and personal_id = '$Personal_id' and menu_id = '$Menu_id'";
  $content = $DB_CONN->getOne($sql);
  if(PEAR::isError($result)) die($result->userinfo);

  $smtpl->assign("Notebook_Content", $content);
}

function delete_file($file_name)
{
	global $DB_CONN, $smtpl, $path;
	
	//刪除實體檔案
	
	$file_path = $path.$file_name;
	
	$file_path = str_replace(" ","\ ",$file_path);
	//print $file_path;
	
    $cmd = "rm ".$file_path;
    system_log($cmd);
	//print $cmd;
	exec($cmd);
}

//根據begin_course_cd取出本課程所用教材的教師編號
function textbook($Begin_course_cd)
{
  global $DB_CONN;
  $sql = "select content_cd from class_content_current where begin_course_cd = '$Begin_course_cd'";
  $content_cd = $DB_CONN->getOne($sql);
  if(PEAR::isError($content_cd))  die($content_cd->userinfo);

  $sql = "select teacher_cd from course_content where content_cd = '$content_cd'";
  $teacher_cd = $DB_CONN->getOne($sql);
  if(PEAR::isError($teacher_cd))  die($teacher_cd->userinfo);

  return $teacher_cd;
}

//丟入人員編號，傳回人員名稱
function returnName($personal_id)
{
  global $DB_CONN;
  $sql = "select personal_name from personal_basic where personal_id = '$personal_id'";
  $personal_name = $DB_CONN->getOne($sql);
  if(PEAR::isError($personal_name))  die($personal_name->userinfo);
  return $personal_name;
}

//根據content_cd，傳回教材名稱
function returnContentName($content_cd)
{
  global $DB_CONN;
  $sql = "select content_name from course_content where content_cd = '$content_cd'";
  $content_name = $DB_CONN->getOne($sql);
  if(PEAR::isError($content_name))  die($content_name->userinfo);
  return $content_name;
}
?>

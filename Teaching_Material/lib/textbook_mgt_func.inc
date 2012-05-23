<?php
/* id: textbook_mgt_func.inc v2.0 2007/5/8 by hushpuppy Exp. */
/* function: 與教師管理教材相關的function整理 */

//新增教材
function create_textbook()
{
	global $Teacher_cd, $Begin_course_cd, $Course_cd, $Textbook_name, $Difficulty, $Attributes, $IsPublic;
    global $IsDownload,$DownloadRole,$License,$Announce,$Rule;
    global $smtpl; // for test
	global $DB_CONN, $DATA_FILE_PATH;
   
	//教材名稱相同的錯誤偵測,	
	$check_sql = "select * from course_content where content_name = '$Textbook_name' and teacher_cd = '$Teacher_cd';";
	$result = $DB_CONN->query($check_sql);
    
    if($result->numRows() > 0)	//表示名稱重複
		return 0;
    
   // if($_SERVER['REMOTE_ADDR']=='140.123.105.190')
     //   die($Attributes);

    //教材屬性
	if($Attributes == "Myscorm 1.2")
		$attr = 0;
	else if($Attributes == "Myscorm 2004")
		$attr = 1;
	else
		$attr = 2; //其它
    
    //教材是否公開
	if($IsPublic == "是")
		$pub = 1;
	else
		$pub = 0;
	//course_cd新增時為null，教師選擇教材

//modify by joyce 20110510==========
    $max_cd = get_max_content_cd();
    $sql = "insert into course_content (content_cd, content_name, teacher_cd, datetime , difficulty, content_type, is_public)
         values ('$max_cd', '$Textbook_name','$Teacher_cd', NOW() ,'$Difficulty', '$attr', '$pub');";
    db_query($sql);
    
    $sql = "insert into content_download (content_cd, is_download, download_role, packet_type, license, announce, rule, memo)
        values ('$max_cd', '$IsDownload','$DownloadRole','0','$License','$Announce','$Rule',NULL);";
    db_query($sql);
    //===================================

	//拿回目前的content_cd 要當傳回值，新增並進入編輯時，才可以用此content_cd當loadTreeFromDB.php的參數
	$sql = "select content_cd from course_content where teacher_cd = '$Teacher_cd' and content_name = '$Textbook_name'";
	$cur_content_id = $DB_CONN->getOne($sql);
	if(PEAR::isError($new_content_cd))	die($new_content_cd->userinfo);
	
	//get max sort point.
   	$id = get_max_menu_id();

	if($id == 0)
		$id = 1;
    //$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
    //$id = $row["max_id"];
	$str = "tea_start.php?content_cd=".$cur_content_id;	
	$insert_root = "insert into class_content (content_cd, menu_id, menu_parentid, caption, file_name, url, exp, icon, seq) 
	  values('$cur_content_id', '$id', 0, '$Textbook_name', '$Textbook_name', '$str' ,1 ,'' ,'');";
	$result = $DB_CONN->query($insert_root);
    if(PEAR::isError($result))	die($result->getMessage());
	
	//以教材編號建立系統中教材實體資料夾
	$path = $DATA_FILE_PATH.$Teacher_cd."/textbook/".$Textbook_name;
	//$smtpl->assign("test",$path);
	$old_umask = umask(0);
	createPath($path);
	umask($old_umask);
	return $cur_content_id;
}

//修改教材名稱屬性
function modify_textbook()
{
    global $Teacher_cd, $M_Content_cd, $Textbook_name, $Difficulty, $Attributes, $IsPublic, $DB_CONN;
    global $IsDownload,$DownloadRole,$License,$Announce,$Rule;
	global $smtpl; // for test
	global $DATA_FILE_PATH;
	
	//先取得舊的教材名稱
	$sql = "select content_name from course_content where content_cd = '$M_Content_cd';";
	$old_name = $DB_CONN->getOne($sql);
	if(PEAR::isError($old_name))	die($old_name->getMessage());
	
	if($old_name == $Textbook_name);
	else{
		//教材名稱相同的錯誤偵測 	
		$check_sql = "select * from course_content where content_name = '$Textbook_name' and teacher_cd = '$Teacher_cd';";
		$result = $DB_CONN->query($check_sql);
		if($result->numRows() > 0)	//表示名稱重複
			return 0;
	}
	
	//教材屬性
	if($Attributes == "Myscorm 1.2")
		$attr = 0;
	else if($Attributes == "Myscorm 2004")
        $attr = 1;
	else if($Attributes == "SCORM_1.2")
        $attr = 3;
    else if($Attributes == "SCORM_2004")
        $attr = 4;
    else
		$attr = 2; //其它
		
	//教材是否公開
	if($IsPublic == "是")
		$pub = 1;
	else
		$pub = 0;

	//把資料夾目錄改掉  , 更改教材名稱不更改目錄
	//$o_path = $DATA_FILE_PATH.$Teacher_cd."/textbook/".$old_name;
	//$n_path = $DATA_FILE_PATH.$Teacher_cd."/textbook/".$Textbook_name;
	//$cmd = "mv '$o_path' '$n_path'";
	//$tpl->assign("test",$cmd);
	//exec($cmd);
	
	//modify by joyce 20110510==========
	$sql = "update course_content set content_name = '$Textbook_name',difficulty = '$Difficulty',content_type = '$attr',is_public = '$pub' where content_cd = '$M_Content_cd';";
    db_query($sql);
    $sql = "update content_download set is_download = '$IsDownload', download_role = '$DownloadRole',license = '$License', announce = '$Announce', rule = '$Rule' where content_cd = '$M_Content_cd';";
    db_query($sql);
    //==========
    
    //更新class_content  不更新教材root node資訊
	//$sql = "update class_content set caption = '$Textbook_name' , file_name = '$Textbook_name' where content_cd = '$M_Content_cd' and menu_parentid ='0';";
	//$result = $DB_CONN->query($sql);
	//if(PEAR::isError($result))	die($result->getMessage());

	return 1;
}

//刪除整份教材
function delete_textbook()
{
	global $Content_cd, $DATA_FILE_PATH,$MEDIA_FILE_PATH, $Teacher_cd;
	
	
	if($Content_cd == 0 or $Teacher_cd == 0) 
	  return ;

    //從content_cd查scorm_id
      $sql = "select id,course from mdl_scorm  where content_cd ='$Content_cd'";
        $result = db_getRow($sql);
    $scormID = $result['id'];
    $courseID = $result['course'];

	/*查詢是否有scormID如果有則代表此教材為scrom教材,否則為myscorm教材
	$sql = "select id from mdl_scorm where content_cd = '$Content_cd';";
    $scormID = db_getOne($sql);*/

	//如是myscorm,查出教材目錄root的file_name
	if(!isset($scormID)){
	  $sql = "select file_name from class_content where content_cd = '$Content_cd' and menu_parentid ='0';";
	  $name = db_getOne($sql);
	}
	//刪除教材以及多媒體資料 , $name產生的方式依照是不是myscorm教材有所不同
    $name = trim($name);
	if(!empty($name)){
	   $DATA_path = $DATA_FILE_PATH.$Teacher_cd."/textbook/".$name;
	   $Media_path = $MEDIA_FILE_PATH . $Teacher_cd . '/' . $Content_cd ;
       $cmd = "rm -rf ".$DATA_path . ' ' .$Media_path;
       if(!strstr($DATA_path,"../"))
       {
           system_log($cmd);
           exec($cmd);
       }

	}
	else//是scorm    add by joyce 20110511
	{
		$sql = "select content_name from course_content where content_cd = '$Content_cd';";
		$name = db_getOne($sql);
	}

	
	//刪除class_content_current與begin_course_cd的對應
        $sql = "delete from class_content_current where content_cd = '$Content_cd';";
	$result = db_query($sql);

		
	//刪除class_content中教材編號為$Content_cd的所有資料
	$sql = "delete from class_content where content_cd = '$Content_cd';";
	$result = db_query($sql);
		
	//刪除course_content中這筆教材
	$sql = "delete from course_content where content_cd = '$Content_cd';";
    $result = db_query($sql);

    //刪除content_download中這筆教材
    $sql = "delete from content_download where content_cd = '$Content_cd';";
    db_query($sql);

	/*	modify by joyce 20110510 除了刪除原本的教材外，刪除 scorm 教材 */
    
   /* $scorm_path = str_replace("Data_File","Teaching_Material",$DATA_FILE_PATH);
    $scorm_path = $scorm_path."scorm/nccudata/" .$courseID."/moddata/scorm/".$scormID;
    */
     $scorm_path = str_replace("Data_File","Teaching_Material",$DATA_FILE_PATH)."scorm/nccudata/" .$courseID."/";
        $scorm_path_l = $scorm_path."moddata/scorm/".$scormID;

    $scormID = trim($scormID);
	if (!empty($scormID))
	{
        $cmd = "rm -rf ". $scorm_path_l;
        if(!strstr($scorm_path_l,"../"))
        {
            system_log($cmd);
            exec($cmd);
        }

        $scorm_packet = $scorm_path . $scormID .".zip";
        //var_dump($scorm_packet);
        if(file_exists($scorm_packet)){
            $cmd = "rm ". $scorm_packet;
            system_log($cmd);
            exec($cmd);
        }
         $scorm_packet = $scorm_path_l . ".rar";
         if(file_exists($scorm_packet)){
            $cmd = "rm ". $scorm_packet;
            system_log($cmd);
            exec($cmd);
         }
		 
		/*
		 *刪除mdl_scorm中這筆教材
		 */
		$sql = "delete from mdl_scorm where content_cd = '$Content_cd';";
		$result = db_query($sql);
		/*
		 *刪除mdl_scorm_scoes中這筆教材
		 */
		$sql = "delete from mdl_scorm_scoes where scorm = '$scormId';";
        $result = db_query($sql);
		
	}
	return $name; //傳回刪除成功的那個教材名稱
}

//選擇教材
function choose_textbook()
{
	global $Teacher_cd, $Begin_course_cd, $Content_cd, $DB_CONN, $smtpl;
	
	$sql = "select * from class_content_current where begin_course_cd = $Begin_course_cd;";
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->getMessage());
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	if(count($row) == 0){
		$sql = "insert into class_content_current(begin_course_cd,content_cd) values($Begin_course_cd, $Content_cd)";
	}
	else{
		$sql = "update class_content_current set content_cd=$Content_cd where begin_course_cd = $Begin_course_cd;";
	}
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->getMessage());
	
}

//判斷身分是否為本課程的主要開課教師,否則無法指定本課程教材
function check_tea_master(){
	global $Teacher_cd, $Begin_course_cd, $Content_cd, $DB_CONN, $smtpl;
	
	$sql = "select course_master from teach_begin_course where teacher_cd = '$Teacher_cd' and begin_course_cd = '$Begin_course_cd';";
	$is_course_master = $DB_CONN->getOne($sql);
	if(PEAR::isError($is_course_master))	die($is_course_master->userinfo);
	
	if($is_course_master == 'n')
		return 0;
	else
		return 1;
}

function encodePATH($Path)
{
    $tok = strtok($Path, "/");
      $string = "/";
      while ($tok !== false) {
	$str = URLENCODE($tok);
	if(strstr($tok," ") != false)
	    $str = $tok;
	else
	    $tok = strtok("/");
	$string = $string.$str."/";
      }
        return $string;
}

//新增教材時，取出table中目前最大值menu_id (因為varchar 所以強制cast)
function get_max_menu_id(){
	return db_getOne("select max(cast(menu_id as unsigned)) from `class_content` where 1;")+1;
}

//新增教材時，取出table中目前最大值content_cd
function get_max_content_cd(){
        return db_getOne("select max(content_cd) from `course_content` where 1;")+1;
}



//新增教材時，取出同一個父節點下，seq最大者+1傳回，做為新結點的順序性
function ret_new_textbook_seq($p_id,$content_cd){
  global $DB_CONN;
  $sql = "select max(cast(seq as unsigned))+1 from  class_content where menu_parentid = '$p_id'
    and content_cd = '$content_cd'";
  $new_seq = $DB_CONN->getOne($sql);
  if(PEAR::isError($new_seq))    die($new_seq->userinfo);

  if(!isset($new_seq) || $new_seq == 0)
    $new_seq = 1;
  return $new_seq;
}
?>

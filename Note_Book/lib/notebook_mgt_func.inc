<?php
/* id: textbook_mgt_func.inc v2.0 2007/5/8 by hushpuppy Exp. */
/* function: 與教師管理教材相關的function整理 */

//新增教材
function create_notebook($Personal_id, $Notebook_name, $IsPublic)
{
	global $DB_CONN, $PERSONAL_PATH;

	//教材名稱相同的錯誤偵測 	
	$check_sql = "select count(*) from personal_notebook where personal_id=$Personal_id and notebook_name='$Notebook_name';";
	$result = db_getOne($check_sql);
	if($result > 0)	//表示名稱重複
		return 0;


	//教材是否公開
	if($IsPublic == "是")
		$pub = 1;
	else
		$pub = 0;

	//course_cd新增時為null，教師選擇教材
	$sql = "insert into personal_notebook (personal_id, notebook_name, d_notebook_beg, is_public) " 
		  ." values ('$Personal_id', '$Notebook_name', '$date', '$pub');";
	
	$result = db_query($sql);

	
	//插入tree的第一層資料(title), 先取得剛剛插入的notebook_cd
    $sql = "select max(notebook_cd) max_id from personal_notebook;";
    $cur_notebook_id = $DB_CONN->getOne($sql);
    if(PEAR::isError($cur_notebook_id))	die($cur_notebook_id->getMessage());
	
	//get max sort point.
    $sql = "select max(menu_id+1) max_id from notebook_content";
    $id = db_getOne($sql);
    
    
	if($id == 0)
		$id = 1;
    //$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
    //$id = $row["max_id"];
	
	$insert_root = "insert into notebook_content (notebook_cd, menu_id, menu_parentid, caption, url, exp, icon, seq) 
	  values('$cur_notebook_id', '$id', 0, '$Notebook_name', \"\",1 ,'' ,'');";
	$result = db_query($insert_root);
   
	
	//以教材編號建立系統中教材實體資料夾

	/*沒分層前的寫法
        $path = $PERSONAL_PATH.$Personal_id."/notebook/".$Notebook_name;
    */

    //2011.09.25 joyce
	$path = getPersonalPath($Personal_id) . "/notebook/".$Notebook_name;
	createPath($path);
	return 1;
}

//修改教材名稱屬性
function modify_notebook()
{
	global $Personal_id, $M_Notebook_cd, $Notebook_name, $Difficulty, $Attributes, $IsPublic, $DB_CONN;
	global $smtpl; // for test
	global $PERSONAL_PATH;
	
	//先取得舊的教材名稱
	$sql = "select notebook_name from personal_notebook where notebook_cd = '$M_Notebook_cd';";
	$old_name = db_getOne($sql);
	
	
	if($old_name == $Notebook_name);
	else{
		//教材名稱相同的錯誤偵測 	
		$check_sql = "select count(*) from personal_notebook where personal_id=$Personal_id and notebook_name = '$Notebook_name';";
		$result = db_getOne($check_sql);
		if($result > 0)	//表示名稱重複
			return 0;
	}
	
		
	//教材是否公開
	if($IsPublic == "是")
		$pub = 1;
	else
		$pub = 0;

	//把資料夾目錄改掉

/*沒分層前的寫法
	$o_path = $PERSONAL_PATH.$Personal_id."/notebook/".$old_name;
	$n_path = $PERSONAL_PATH.$Personal_id."/notebook/".$Notebook_name;
*/
    //2011.09.25 joyce
    $o_path = getPersonalPath($Personal_id)."/notebook/".$old_name;
    $n_path = getPersonalPath($Personal_id)."/notebook/".$Notebook_name;

	rename($o_path, $n_path);
	
	
	//更新personal_notebook
	$update_notebook = "update personal_notebook set notebook_name = '$Notebook_name', is_public = '$pub' where notebook_cd = '$M_Notebook_cd';";
	db_query($update_notebook);
	
	$update_notebook_content = "update notebook_content set caption = '$Notebook_name' where notebook_cd = '$M_Notebook_cd';";
	db_query($update_notebook_content);
	return 1;	
}

//刪除整份教材
function delete_notebook($Notebook_cd, $Personal_id)
{
	global $PERSONAL_PATH;

    /*沒分層前的寫法
	    $path = $PERSONAL_PATH.$Personal_id."/notebook/".$name;
    */

	
	$sql = "select notebook_name from personal_notebook where notebook_cd = '$Notebook_cd';";
	$name = db_getOne($sql);

        //2011.09.25 joyce
        $path = getPersonalPath($Personal_id)."/notebook/".$name;

    $cmd = "rm -rf ".$path;
    if(!strstr($path,"../"))
    {
        system_log($cmd);
        exec($cmd);
    }
	

	//刪除personal_notebook中教材編號為$Notebook_cd的所有資料
	$sql = "delete from personal_notebook where notebook_cd = '$Notebook_cd';";
	$result = db_query($sql);
	
	//刪除notebook_content中這筆教材
	$sql = "delete from notebook_content where notebook_cd = '$Notebook_cd';";
	$result = db_query($sql);
	
	
	//刪除notebook_node_content中所有檔案項目
	$sql = "delete from notebook_node_content where notebook_cd = '$Notebook_cd';";
	$result = db_query($sql);
		
	return $name; //傳回刪除成功的那個教材名稱
}

?>

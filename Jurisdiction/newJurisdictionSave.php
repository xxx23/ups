<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");
	require_once("library.php");


	$parent_menu_id = $_POST["parent_menu_id"];
	$menu_level = $_POST["menu_level"];
	$menu_name = $_POST["menu_name"];
	$menu_link = $_POST["menu_link"];
	$menu_state = $_POST["menu_state"];
	
	//取得$menu_id
	//搜尋這個節點的所有子節點
	if($menu_level == 0)
	{
		$sql = "SELECT * FROM lrtmenu_ WHERE menu_level=$menu_level";
	}
	else if($menu_level > 0)
	{
		$sql_parent_menu_id = "#" . $parent_menu_id;
		
		$sql = "SELECT * FROM lrtmenu_ WHERE menu_level=$menu_level AND menu_id LIKE '$sql_parent_menu_id%'";
	}
		
	$res = db_query($sql);
		
	$newsNum = $res->numRows();

	if($newsNum > 0)
	{
		//這個節點有子節點
			
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$menu_id_tmp = substr($row[menu_id], 1 + 2*$menu_level, 2);
			//echo substr($row[menu_id], 1 + 2*$menu_level, 2) . "<br>";	//for test			
			
			if($menu_id_tmp > $menu_id)	$menu_id = $menu_id_tmp;
		}	
		
		$menu_id += 1;
		if($menu_id < 10)	$menu_id = "0" . $menu_id;
		$menu_id = $parent_menu_id . $menu_id;
	}
	else
	{
		//這個節點沒有子節點
			
		$menu_id = $parent_menu_id . "00";
	}
	$sql_menu_id = "#" . $menu_id;
		
	
	//上傳資料到Table lrtmenu_
	$sth = $DB_CONN->prepare('INSERT INTO lrtmenu_ (menu_id, menu_level, menu_name, menu_link, menu_state) VALUES (?, ?, ?, ?, ?)');
	$data = array($sql_menu_id, $menu_level, $menu_name, $menu_link, $menu_state);
	$res = $DB_CONN->execute($sth, $data);
	if (PEAR::isError($res))	die($res->getMessage());

	$count = get_count_menu_level($menu_level, $sql_menu_id);
	db_query("update `lrtmenu_` set sort_id=$count where menu_id='$sql_menu_id' and menu_level='$menu_level';");
	
	//導向到finishPage
	header("location: jurisdictionManagement.php");
?>

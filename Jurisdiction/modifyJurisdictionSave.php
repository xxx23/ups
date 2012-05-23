<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");


	$menu_id = $_POST["menu_id"];
	$menu_level = $_POST["menu_level"];
	$menu_name = $_POST["menu_name"];
	$menu_link = $_POST["menu_link"];
	$menu_state = $_POST["menu_state"];

//	echo "|$menu_link|";

	$sql_menu_id = "#" . $menu_id;
	
	//更新資料到Table lrtmenu_
	$sql = "UPDATE 
				lrtmenu_ 
			SET 
				menu_name='$menu_name', 
				menu_link='$menu_link', 
				menu_state='$menu_state' 
			WHERE 
				menu_id='$sql_menu_id'
			";
	db_query($sql);

	//如果系統選單功能被關閉，更新相關的menu_rule
	if($menu_state == "n")
	{
		$sql = "UPDATE
		  			menu_role
				SET
					is_used='n'
				WHERE
					menu_id='$sql_menu_id'
				";
		db_query($sql);
	}

	//導向到finishPage
	header("location: jurisdictionManagement.php");
?>

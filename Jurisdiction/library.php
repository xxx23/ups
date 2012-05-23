<?php
	require_once("../config.php");
	function get_count_menu_level($menu_level, $sql_menu_id){
		$tmp = "";
		if($menu_level != 0){
			if($sql_menu_id[0] == '#')
				$sql_menu_id = substr($sql_menu_id, 1);
			$tmp = " and menu_id like '#" . substr($sql_menu_id, 0, strlen($sql_menu_id) - 2) . "%'";
		}
		return db_getOne("select count(*) from `lrtmenu_` where menu_level='$menu_level'$tmp;");
	}
?>

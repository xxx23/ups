<?php
	require_once("../config.php");
	require_once("../session.php");
	require_once("library.php");

	$input = $_GET;
	if(empty($input['option']))
		return 0;
	call_user_func($input['option'], $input);

	function move_up($input){
		$s_id = db_getOne("select sort_id from `lrtmenu_` where menu_id='#$input[menu_id]';");
		if($s_id == 1){
			redirection_html($input['menu_level'], $input['menu_id']);
			exit(0);
		}
		$tmp = "";
		if($input['menu_level'] != 0)
			$tmp = "and menu_id like '#" . substr($input['menu_id'], 0, strlen($input['menu_id']) - 2) . "%'";
		$add = db_getOne("select menu_id from `lrtmenu_` where menu_level='$input[menu_level]' and sort_id=$s_id-1 $tmp;");
		jur_swap($add, "#".$input['menu_id']);
		redirection_html($input['menu_level'], $input['menu_id']);
	}

	function move_down($input){
		$s_id = db_getOne("select sort_id from `lrtmenu_` where menu_id='#$input[menu_id]';");
		$max = get_count_menu_level($input['menu_level'], $input['menu_id']);
		if($s_id == $max){
			redirection_html($input['menu_level'], $input['menu_id']);
			exit(0);
		}
		$tmp = "";
		if($input['menu_level'] != 0)
			$tmp = "and menu_id like '#" . substr($input['menu_id'], 0, strlen($input['menu_id']) - 2) . "%'";
		$sub = db_getOne("select menu_id from `lrtmenu_` where menu_level='$input[menu_level]' and sort_id=$s_id+1 $tmp;");
		jur_swap("#".$input['menu_id'], $sub);
		redirection_html($input['menu_level'], $input['menu_id']);
	}

	function jur_swap($add, $sub){
		db_query("update `lrtmenu_` set sort_id=sort_id+1 where menu_id='$add';");
		db_query("update `lrtmenu_` set sort_id=sort_id-1 where menu_id='$sub';");
	}

	function redirection_html($level, $menu_id){
		$tmp = "";
		if($level != 0)
			$tmp = "&menu_id=" . substr($menu_id, 0, strlen($menu_id) - 2);
		header("location:./jurisdictionManagement.php?menu_level=$level". $tmp);
	}
?>

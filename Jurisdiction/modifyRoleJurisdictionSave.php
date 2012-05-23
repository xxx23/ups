<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");

	$role_cd = $_POST["role_cd"];	
	$jurisdictionNum = $_POST["jurisdictionNum"];
	
	//取得所有的傳入值
	$counter = 0;
	for($counter; $counter<$jurisdictionNum; $counter++)
	{
		$menu_id = $_POST["menu_id_" . $counter];
		$is_used_tmp = $_POST["is_used_" . $counter];
		
		if($is_used_tmp == "on")	$is_used = 'y';
		else				$is_used = 'n';
		
		$roleJurisdictionList[$counter] = 
					array(	"menu_id" => $menu_id, 
							"is_used" => $is_used
						);
	}
	
	//從Table menu_role刪除這個角色的所有權限
	$sql = "DELETE FROM menu_role WHERE role_cd = (?)";
	$data = array($role_cd);
	$sth = $DB_CONN->prepare($sql);		
	$res = $DB_CONN->execute($sth, $data);
	if (PEAR::isError($res))	die($res->getMessage());
	
	//新增角色權限
	$begin_course_cd = -1;
	$counter = 0;
	for($counter; $counter<$jurisdictionNum; $counter++)
	{
		$sql_menu_id = "#" . $roleJurisdictionList[$counter]['menu_id'];
		$is_used = $roleJurisdictionList[$counter]['is_used'];
		
		//上傳資料到Table menu_role
		$sql = "INSERT INTO menu_role 
								(
									menu_id, 
									role_cd, 
									begin_course_cd, 
									is_used
								) VALUES 
								(
									'$sql_menu_id', 
									$role_cd, 
									$begin_course_cd, 
									'$is_used'
								)";
		//echo $sql . "<br>";	//for test
		$sth = $DB_CONN->prepare($sql);
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());
	}

	//導向到finishPage
	header("location: roleManagement.php");
?>

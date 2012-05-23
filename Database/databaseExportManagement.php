<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Database/";


	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	/*
	$data = $DB_CONN->getListOf("tables");
	echo count($data) . "<br>";
	echo current($data) . "<br>";
	echo str_replace("\n", "<br>", implode("\n", $data));
	*/
	$sqlTables = $DB_CONN->getListOf("tables");
	$tableNumber = count($sqlTables);
	for($tableCounter=0; $tableCounter<$tableNumber; $tableCounter++)
	{
		$tableName = current($sqlTables); 
		
		//將資料填入tableList中
		$tableList[$tableCounter] = 
				array(
						"counter" => $tableCounter, 
						"tableName" => $tableName 
						);

		next($sqlTables); 
	}
	$tpl->assign("tableNumber", $tableNumber);
	$tpl->assign("tableList", $tableList);
	
	
	//目前的頁面
	$tpl->assign("currentPage", "databaseExportManagement.php");
	
	assignTemplate($tpl, "/database/databaseExportManagement.tpl");
?>
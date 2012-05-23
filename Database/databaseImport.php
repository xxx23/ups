<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Database/";

	
	$allSql = $_POST['sql'];
	
	str_replace("\n", "", $allSql);
	$nextsql = strtok($allSql, ";");
	
	while($nextsql != false)
	{
		$sql = $nextsql;
		$nextsql = strtok(";");
		
		$sql = str_replace("\\", "", $sql);
		//echo "|" . $sql . "|";	//for test

		$sth = $DB_CONN->prepare($sql);
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	continue;
		
	}

	echo "<center><font color=\"red\">匯入完成</font></center>";
?>

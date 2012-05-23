<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Database/";
	
	$sql_create = $_POST['sql_create'];
	$sql_insert = $_POST['sql_insert'];	
	
	if(($sql_create == 0) && ($sql_insert == 0))
	{
		die("<center><font color=\"red\">錯誤的操作!!!</font></center>");
	}
	
	$tableNumber = $_POST['tableNumber'];

	//產生一個MySqlDump物件
	//MySqlDump($DB_CONN, $showResult, $crlf, $create, $drop, $insert, $cmdEnd)
	$mySQLDump = new MySqlDump($DB_CONN, 1, "\n", $sql_create, 0, $sql_insert, ";");
	
	//開始output buffering
	ob_start();
	
	//匯出每個勾選的Table
	for($tableCounter=0; $tableCounter<$tableNumber; $tableCounter++)
	{
		$tableNameTemp = "table_$tableCounter";
		$tableName = $_POST[$tableNameTemp];
		
		if(isset($tableName) == true)
		{
			//echo $tableCounter . ":" . $tableName . "<br>";	//for test
		
		
			$mySQLDump->dumptable($tableName);
		}
	}
	
	//取得output buffer的資料
	$outputBuffer = ob_get_contents();
	
	//結束並清除output buffer
	ob_end_clean();
	
	//將資料寫入硬碟
	$fileName = "data.txt";
	$filePtr = fopen($fileName, "w");
	fwrite($filePtr, $outputBuffer);
	fclose($filePtr);
	
	
	//將檔案傳給使用者下載
	// set the content as sql
	header("Content-type: text/sql; charset=UTF-8"); 
	
	// tell the thing the filesize
	header("Content-Length: " . filesize($fileName));
	
	// set it as an attachment and give a file name
	header("Content-Disposition: attachment; filename=\"" . $fileName . "\"");

	header("Content-Transfer-Encoding: UTF-8\n");
	
	// read into the buffer
	readfile($fileName);

	//刪除檔案
	unlink($fileName);
?>

<?
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");

	$system_name = $_POST["system_name"];
	$system_state = $_POST["system_state"];
	
	//���o�@�ӷs���t�νs��
	$sql = "SELECT * FROM tracking_system_menu ORDER BY system_id DESC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	
	$resultNum = $res->numRows();
	if($resultNum < 1)
	{
		$system_id = 1;
	}
	else
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		$system_id = $row[system_id] + 1;
	}	
	
	//�s�W��ƨ�Table tracking_system_menu 
	$sql = "INSERT INTO tracking_system_menu (
						system_id, 
						system_name, 
						system_state 
					) VALUES ( 
						$system_id, 
						'$system_name', 
						'$system_state' 
					)";
	$sth = $DB_CONN->prepare($sql);
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	//�ɦV��finishPage
	header("location: learningTrackingManagement.php");
	
?>
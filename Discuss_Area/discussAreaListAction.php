<?
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");

	$behavior = $_POST['behavior'];				//取得行為

	$action = $_POST['submit'];					//取得動作
	$discussAreaNum = $_POST['discussAreaNum'];	//取得參數的個數
	
	//取得所有的參數
	$hasArgument = 0;
	$argument = "";
	for($discussAreaCounter=0; $discussAreaCounter<$discussAreaNum; $discussAreaCounter++)
	{
		$nameTmp = "discuss_cd_" . ($discussAreaCounter+1);
		
		$discussArea[$discussAreaCounter] = $_POST[$nameTmp];	//取得參數
		
		//有被勾選的資料就加到argument中
		if(isset($discussArea[$discussAreaCounter]) == true)
		{
			if($hasArgument == 0)
			{
				$argument = "argument=" . $discussArea[$discussAreaCounter];
				
				$hasArgument = 1;
			}
			else
			{
				$argument = $argument . "_" . $discussArea[$discussAreaCounter];
			}
		}
	}

	
	if($action == "刪除討論區")
	{
		header("Location: deleteDiscussArea.php?behavior=$behavior&$argument");
	}
	else if($action == "訂閱")
	{
		header("Location: subscribeDiscussArea.php?behavior=$behavior&$argument");
	}
	else if($action == "停訂")
	{
		header("Location: deleteSubscribeDiscussArea.php?behavior=$behavior&$argument&finishPage=showDiscussAreaList.php");
	}
	else if($action == "輸出備份")
	{	  
		header("Location: backupDiscussArea.php?behavior=$behavior&$argument");
	}
	
?>

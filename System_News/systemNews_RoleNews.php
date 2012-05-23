<?
	session_start();

	$role_cd = $_SESSION['role_cd'];


	if($role_cd == 0)//系統管理員
	{	
		$redirectPage = "systemNews_adminShowList.php";
	}
	else if($role_cd == 1)//老師
	{	
		$redirectPage = "systemNews_homeShowList.php";
	}
	else if($role_cd == 3)//學生
	{
		$redirectPage = "systemNews_homeShowList.php";
	}
	else if($role_cd == 4)//公務員
	{	
		$redirectPage = "systemNews_homeShowList.php";
	}
	else//錯誤的情形
	{
		$redirectPage = "systemNews_homeShowList.php";
	}
	
	
	//導向到systemNews_ShowList
	header("location: " . $redirectPage);
?>


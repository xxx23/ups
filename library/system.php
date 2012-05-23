<?
	function isLogin()
	{
		session_start();
		if( isset($_SESSION['personal_id']) == true)	return true;
		else											return false;
	}
	
	function checkIsLogin()
	{
		global $HOMEURL;
	
		if(isLogin() == false)
		{
			//使用者尚未登入
			
			//導向回首頁
			header("Location: $HOMEURL");
		}
	}
	
?>

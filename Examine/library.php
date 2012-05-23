<?php
	/*author: lunsrot
	 * date: 2007/08/20
	 */
	function errorMsg($id){
		call_user_func($id);
		echo "<script type=\"text/javascript\">history.back();</script>";
		exit(0);
	}

	function empty_name(){		alert("請輸入測驗名稱！");}
	function duplicate_name(){	alert("輸入測驗名稱重複，請重新確認！");}
	function empty_percentage(){	alert("請輸入測驗配分！");}
	function error_percentage(){	alert("請重新檢查配分！");}

	function alert($str){	echo "<script type=\"text/javascript\">alert('$str');</script>";}
?>

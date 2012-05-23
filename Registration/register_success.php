<?php
/***
FILE:   register_success.php
DATE:   2006/11/26
AUTHOR: zqq
MODIFIER:tgbsa
填寫個人基本資料的頁面
**/
require_once("../config.php");
require_once('../library/mail.php');
require_once($HOME_PATH . 'library/smarty_init.php');

	//開啟session
	session_start();
	if(!isset($_SESSION['register']['login_id'])){
	  echo "請依正確流程瀏覽網頁";
	  exit;
	}
    

	//去除重複的斜線
	$WEBROOT = substr($WEBROOT,1,strlen($WEBROOT));
    //set sender
	$from= 'ups_moe@mail.moe.gov.tw';
	//set message title and content
	$fromName= '教育部數位學習服務平台';
    //$subject = "帳號開通確認";
    if($_SESSION['role_type'] == 1){
        $tpl->assign("role",1);
        $subject = "教師帳號申請開通確認";
        $message = "
            教師帳號申請：

	        使用者 {$_SESSION['values']['txtName']}
	  
	        已經在教育部數位學習服務平台註冊了新的教師帳號，帳號為 {$_SESSION['register']['login_id']}

	        這是系統自動發出的信件，請勿回覆。";

	    $message = nl2br($message);
	    
        //$mailresult = mailto($from , $fromName, $_SESSION['values']['txtEmail'], $subject, $message);
        $mailresult = mailto($from , $fromName, 'ups_admin@exodus.cs.ccu.edu.tw', $subject, $message);

        $message2 = "
            教師帳號申請：

            您已經在教育部數位學習平台註冊了新的教師帳號，帳號為 {$_SESSION['register']['login_id']}

            這是系統自動發出的信件，請勿回覆。";

        $message2 = nl2br($message2);
        $mailresult2 = mailto($from , $fromName, $_SESSION['values']['txtEmail'], $subject, $message2);

    }
    else if($_SESSION['role_type'] == 3){
        $tpl->assign("role",3);
        $subject = "學員帳號申請開通確認";
        $message ="
            學員帳號申請：

            {$_SESSION['values']['txtName']}同學您好

            您已經在教育部數位學習服務平台註冊了新的學員帳號，帳號為{$_SESSION['register']['login_id']}

            如您沒在此平台註冊帳號，您不必理會本信的內容。

            開通帳號請點選以下的連結以來正式啟用帳號。

            URL:<a href={$HOMEURL}{$WEBROOT}Registration/validateUser.php?id={$_SESSION['personal_id']}&r={$_SESSION['randvalue']}>{$HOMEURL}{$WEBROOT}Registration/validateUser.p

            這是系統自動發出的信件，請勿回覆。";

            $message = nl2br($message);

            $mailresult = mailto($from , $fromName, $_SESSION['values']['txtEmail'], $subject, $message);

    }
    else{
       echo '請依正確流程進行';
    }
/*	
	if($mailresult)
	  echo "mail success.\n";
	else
          echo "mail failed.\n";
 */	
	//new smarty	

	//$tpl = new Smarty();
	//------註冊狀態的圖---------
	$IMAGE_PATH = "../" . $IMAGE_PATH;
	$tpl->assign("registerState", $IMAGE_PATH . "register_3.PNG");
	
	//輸出頁面
	$tpl->display("register_success.tpl");

?>

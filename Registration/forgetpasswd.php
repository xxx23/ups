<?php 
/*
 * arnan 2008/01/28
 * functions: password reset 
 */
	require_once("../config.php");

	// refresh time : 5 second ;
	define(REFRESH_TIME, 5 );
	define(PASSWD_RESET_PAGE, "passwdreset.php");

	$tpl = new Smarty();

	$hint ="" ;
	$id = $_POST['id'] ; 
	$email = $_POST['email'];
    $code_state = $_POST['code_state'];
	if(isset( $id )and !empty($id) and isset( $email ) and $code_state == -1){
        $check_code = validate_id_email($id, $email);       
		//ok = 0, id error = 1, email empty or error = 2 , 
		//id-email not match = 3 , nothing = -1
		switch( $check_code ) {
		case 0:
	    	//$tpl->assign("refresh_time", REFRESH_TIME );
			$tpl->assign("id", $id);
			$tpl->assign("hint", $hint);
			$tpl->assign("email", $email);
            $tpl->assign("id_readonly", "readonly");
            $tpl->assign("email_check",1);
			$tpl->assign("code_state", 0);
			$tpl->assign("confirm",1);
			$tpl->assign("thisaction", PASSWD_RESET_PAGE);
			$tpl->assign("prompt", "查詢ok! 帳號、E-Mail符合 ");
	    	$tpl->display("forgetpasswd.tpl");
			
	    	return;
			
		case 1:
			$tpl->assign("id", "");
			$tpl->assign("email", "");	
            $tpl->assign("id_errmsg", "帳號 $id 不存在，請重新填寫帳號");
			$tpl->assign("thisaction", "");
			$tpl->assign("code_state", -1);
	    	$tpl->display("forgetpasswd.tpl");
	    	return;
	
            /* 這段的功能不合理，與老師討論過後拿掉 by tkraha   2008/09/10 
 * 		case 2:
			$tpl->assign("id", $id);
			$tpl->assign("id_readonly", "readonly");
			$tpl->assign("hint", $hint);
			$tpl->assign("email", $email);
			$tpl->assign("email_errmsg", "系統中您的E-mail尚未填寫，送出後將會使用這個E-mail");
			$tpl->assign("thisaction", PASSWD_RESET_PAGE);
			$tpl->assign("confirm",1);
			$tpl->assign("prompt", "請填寫正確的E-mail，");
			$tpl->assign("code_state", 2);
	    	$tpl->display("forgetpasswd.tpl");
			return;
             */			
            /* 2011/12/15 將未填寫email修改為 case 2 */
        case 2:
            $tpl->assign("id", "$id");
            $tpl->assign("email", "");
            $tpl->assign("email_errmsg","請填寫信箱");
            $tpl->assign("thisaction", "");
            $tpl->assign("code_state", -1);
            $tpl->display("forgetpasswd.tpl");
            return;

        case 3:
            
			$tpl->assign("id", $id);
			$tpl->assign("id_readonly", "readonly");
			$tpl->assign("hint", $hint);
            $tpl->assign("email", $email);
            $tpl->assign("email_errmsg", "此E-mail與註冊時所填不符，請填寫正確信箱。");
            $tpl->assign("thisaction", PASSWD_RESET_PAGE);
			$tpl->assign("prompt", "密碼將會直接寄送至註冊所填的E-mail，");
            $tpl->assign("code_state", 3);
            $tpl->assign("confirm",1);
            $tpl->display("forgetpasswd.tpl");
			return;
		
		default:
			$tpl->assign("code_state", -1);
			$tpl->display("forgetpasswd.tpl");
			return ;
		}
		
	}// end  first post 
	$tpl->assign("code_state", -1);
	$tpl->assign("thisaction", "");
	$tpl->display("forgetpasswd.tpl");
	
	return ;

	
	
	// functions 
	function validate_id_email($id, $email) {
	//check id,email pair
	//return code:
	//ok = 0, id error = 1, email empty or error = 2 , 
	//id-email not match = 3 , nothing = -1
		global $DB_CONN ;
		global $hint;
		// get email from id
		$get_personal_id = "SELECT personal_id,password_hint FROM register_basic "
		." WHERE login_id='". $id ."'" ;
		
		$res = $DB_CONN->query($get_personal_id);
		
		if(PEAR::isError($res)) die($res->getMessage());	
		
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		$personal_id = $row['personal_id'];
		$hint		 = $row['password_hint'];
		
		
		if(PEAR::isError($personal_id) or empty($personal_id) )	{
		//id not find ,error 
			return 1;
			//die($result->getMessage());
		}else{
		
			$get_email = "SELECT email FROM personal_basic "
			." WHERE personal_id='". $personal_id ."'" ;
			
			$email_inDB = $DB_CONN->getOne($get_email);
		
			if(PEAR::isError($email_inDB) or empty($email_inDB) )	{
			//email not find ,error 
				return -1;
				//die($result->getMessage());
			}
        }
        if (empty($email))
        {
            return 2;
        }
		if( $email == $email_inDB) {
			return 0; // find id-email; 
		}else{
			return 3; // email is not same;
		}
		return -1; // not run
	}
	
	function resetpasswd($id, $check_code) {
	// reset passwd and set email
	
	
	}
?>	

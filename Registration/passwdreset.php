<?php 

	require_once("../config.php");
	require_once('../library/passwd.php');	
	require_once( '../library/mail.php');


	$id = $_POST['id'] ; 
	$email = $_POST['email'];
	$code_state = $_POST['code_state'];
    $hint = $_POST['hint'];
	
	$tpl = new Smarty();
	
	if(isset( $id ) and isset( $email ) ){
	
	
		//ok = 0, id error = 1, email empty or error = 2 , 
		//id-email not match = 3 , nothing = -1
		switch ( $code_state )
		{
			case 0:
				//reset passwd
				$new_passwd = genPasswd();
				resetpasswd($id, $new_passwd); 
				//send mail
				sendInfoMail(get_mail($id), $new_passwd) ; 
                $tpl->assign("msg", 0);
                $tpl->assign("check",1);
				$tpl->display("resetpassok.tpl");
				return;
            case 2:
                /*
				//reset passwd
				$new_passwd = genPasswd();
				resetpasswd($id, $new_passwd); 
				//reset email
				update_email(getPersonal_id($id), $email);
				//send info main
                sendInfoMail($email, $new_passwd); 
                $tpl->assign("check",1);
                $tpl->display("resetpassok.tpl");
                 */
				return;
            case 3:
                if(check_again($id,$email))
                {
				    //reset passwd
				    $new_passwd = genPasswd();
				    resetpasswd($id, $new_passwd); 
				    //send info mail
                    sendInfoMail( get_mail($id), $new_passwd); 
                    $tpl->assign("check",1);
                    $tpl->display("resetpassok.tpl");
                    return;
                }
                else
                {
                    //header("Location: forgetpasswd.php");
                    //exit;
                    $tpl->assign("check",0);
                    $tpl->display("resetpassok.tpl");
                    return;
                    
                }
		}//switch
    }//if
    $tpl->assign("confirm",0);
    $tpl->assign("code_state",-1);
    header("Location: forgetpasswd.php");
	return ;
	
    function check_again($id, $email){
        global $DB_CONN;
        $id_db = getPersonal_id($id);
        $email_db = get_mail($id);
        if(!empty($id_db) && !empty($email_db)) {
            if($email == $email_db)
                return 1;
            else
                return 0;
        }
        else
            return 0;
    }

	function get_mail($id){
		global $DB_CONN;
		$personal_id = getPersonal_id($id);
		
		if( !empty($personal_id ) ) {
			$get_email ="select email from personal_basic where personal_id=".$personal_id;
			$original_mail = $DB_CONN->getOne($get_email);
			
			if(PEAR::isError($original_mail))
				die($result->getMessage());
				
			return  $original_mail;	
		}
		return "";
		
	}
	function getPersonal_id($login_id) {
		global $DB_CONN;
		
		$get_personal_id ="select personal_id from register_basic where login_id='".$login_id."'";
		$personal_id = $DB_CONN->getOne($get_personal_id);
		return $personal_id ;
	}

	function update_email($personal_id, $new_email){
		
		$update_email = "update personal_basic set email='$new_email' where personal_id=$personal_id";
		$res = db_query($update_email); 
	}
	
	function resetpasswd($id, $newpasswd) {
		$newencrypt_passwd = passwd_encrypt($newpasswd);
		$update_passwd = "update register_basic set pass='" .$newencrypt_passwd ."' where login_id='$id'";
		db_query($update_passwd);
		$update_users_password = "update users set password=md5('$newpasswd') where user='$id'";
		db_query($update_users_password);

	}
	
	function genPasswd() {
		$seed = "1234567890abcdefghijklmnopqrstuvwxyz";
		$new_passwd_t ="";
		for($i=0; $i<8 ;$i++) {
			$pos = rand(0,35);
			 $new_passwd_t .= $seed[$pos];
		}
		return $new_passwd_t;
	}
	
	function sendInfoMail($mailto, $newpasswd) {
		
		$message = "您的密碼已經被重設成:" .$newpasswd ."\n" ;
		$subject = "教學平台重新設定密碼";
		$from ="elearning@hsng.cs.ccu.edu.tw";
		$fromName = "平台管理員";
		mailto($from , $fromName, $mailto, $subject, $message );
	}
?>

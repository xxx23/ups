<?php
/***
FILE:   validate.class.php
DATE:   2006/11/26
AUTHOR: zqq

驗證的物件
**/

require_once('../config.php');
require_once("../library/account.php");
require_once("../library/filter.php");

class Validate
{
	//DataBase
	private $pearDB;
	private $errorMsg; //for AJAX
	private $personal_path;
	function __construct($DB_CONN,$PERSONAL_PATH)
	{
		$this->pearDB = $DB_CONN;
		$this->errorMsg ="";
		$this->personal_path = $PERSONAL_PATH;
	}
	
	function __destruct()
	{
		//$this->pearDB->disconnect();
		//$_SESSION['errors'] = '';
		//$_SESSION['values'] = '';
	}
	
	public function ValidateAJAX ( $inputValue, $fieldID)
	{	
		switch( $fieldID )
		{
			case	'txtUsername':
				return $this->validateUserName($inputValue);
				break;
			case	'txtPassword':
				return $this->validatePassword($inputValue);
				break;			
			case	'txtCkPassword':
				return $this->validateCkPassword($inputValue);
				break;	
			case	'txtPasswordInfo':
				return $this->validatePasswordInfo($inputValue);
				break;
		}
	}
	
	public function ValidateAJAX2 ( $inputValue, $inputValue2, $fieldID)
	{	
		switch( $fieldID )
		{
			case	'txtCkPassword':
				return $this->validateCkPassword($inputValue,$inputValue2);
				break;	
		}
	}
	public function ValidatePHP()
	{
		$errorsExist = 0;
		
		if (isset ($_SESSION['errors']))
			unset ($_SESSION['errors']);

		$_SESSION['errors']['txtUsername'] = 'hidden';
		$_SESSION['errors']['txtPassword'] = 'hidden';
		$_SESSION['errors']['txtCkPassword'] = 'hidden';
		$_SESSION['errors']['txtPasswordInfo'] = 'hidden';		

		//驗證username
		if( !$this->validateUserName(optional_param('txtUsername',"",PARAM_TEXT)))
		{
			$_SESSION['errors']['txtUsername'] = 'error';
			$errorsExist = 1;
		}
		//驗證Password
		if( !$this->validatePassword(optional_param('txtPassword',"",PARAM_ALPHANUM)))
		{
			$_SESSION['errors']['txtPassword'] = 'error';
			$errorsExist = 1;
		}
		
		//驗證CkPassword
		//if( !$this->validateCkPassword($_POST['txtCkPassword']."@".$_POST['txtPassword']))
		if( !$this->validateCkPassword(optional_param('txtCkPassword',"",PARAM_ALPHANUM),optional_param('txtPassword',"",PARAM_ALPHANUM)))
		{
			$_SESSION['errors']['txtCkPassword'] = 'error';
			$errorsExist = 1;
		}
		//驗證Password info.
		if( !$this->validatePasswordInfo(optional_param('txtPasswordInfo',"",PARAM_TEXT)))
		{
			$_SESSION['errors']['txtPasswordInfo'] = 'error';
			$errorsExist = 1;
		}							
		
		//驗證通過
		if ( $errorsExist == 0){
			$_SESSION['register']['login_id'] = optional_param('txtUsername',"",PARAM_ALPHANUM);
			$_SESSION['register']['pass'] = optional_param('txtPassword',"",PARAM_TEXT);
			$_SESSION['register']['passhint'] = optional_param('txtPasswordInfo',"",PARAM_TEXT);
 			return "profile.php";
		}
		//驗證有錯誤
		else{
			foreach( $_POST as $key => $value){
				$_SESSION['values'][$key] = $_POST[$key];
			}
            $_SESSION['errors']['checked'] = true;
			return "register.php";
        }		
	}
	
	private function validateUserName($value)
	{
		$value = trim($value);
		if ($value == null){
			$this->setErrorMsg("帳號尚未填！");
			return 0;
		}

		if(!validate_login_id($value))
		{
			$this->setErrorMsg("帳號中不可以含有特殊字元");
			return 0;
		}
		$sql = "SELECT * FROM register_basic WHERE login_id='".$value."';";
		$res = $this->pearDB->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());		
		$user = $res->numRows();
		if($user){
			$this->setErrorMsg("帳號已經存在");
			return 0;			
		}
		else{
			return 1;	//valid
		}
	}
	
	private function validatePassword($value)
	{
		$value = trim($value);
		$valueLen = strlen($value); 
		if($valueLen == 0){
			$this->setErrorMsg("密碼尚未填");
			return 0;		
		}
		elseif($valueLen < 8){
			$this->setErrorMsg("密碼請輸入超過 8 碼");
			return 0;
		}	
        elseif($valueLen >= 8){

            if(preg_match('/[^0-9a-zA-z@#\-_&=]/',$value))
            {
                $this->setErrorMsg("密碼只允許輸入英文字大小寫、數字、符號(@,#,-,_)。");
                return 0;
            }

			return 1; //ok	
		}
	}
		
	private function validateCkPassword($pass1,$pass2)
	{
		//$value = trim($value);
		//$pass = explode ("@", $value);
		$pass = array($pass1,$pass2);
		if( !strlen($pass[0])){
			$this->setErrorMsg("再次確認密碼尚未填入");
			return 0;		
		}
		if( (sizeof($pass) == 2) && ($pass[0] != $pass[1]) ){
			$this->setErrorMsg("再次確認密碼與密碼不同");
			return 0; 
		}
		elseif( (sizeof($pass) == 2) && $pass[0] == $pass[1]){
			return 1; 
		}
	}
	private function validatePasswordInfo($value)
	{
		$value = trim($value);
		if($value){
			return 1; //valid
		}	
		else{
		  $this->setErrorMsg("密碼提示尚未填入");
			return 0; //not valid	
		}	
	}	
			
	private function setErrorMsg($msg)
	{
		$this->errorMsg = $msg;
	}
	
	public function getErrorMsg()
	{
		return $this->errorMsg;
	}

	public function createDIR($path){
	        if( $path[strlen($path)-1] == '/');
		else
			$path = $path.'/';
		$old_umask = umask(0);
		mkdir($path, 0775);
		umask($old_umask);
	}
}

?>

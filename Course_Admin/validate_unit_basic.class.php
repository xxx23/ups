<?php
/***
FILE:   
DATE:   
AUTHOR: zqq

驗證開課的物件
**/

require_once ('../config.php');
require_once("../library/common.php");

session_start();
class ValidateUnitBasic
{
	//DataBase
	private $pearDB;
	private $errorMsg; //for AJAX
	function __construct($DB_CONN)
	{
		$this->pearDB = $DB_CONN;
		$this->errorMsg ='';
	}
	
	function __destruct()
	{
		//$this->pearDB->disconnect();
	}
	
	public function ValidateAJAX ( $inputValue, $fieldID )
	{	
		switch( $fieldID )
		{
			case	'unit_cd':
				return $this->ValidateUnitCd($inputValue);
				break;					
			case	'unit_name':
				return $this->ValidateUnitName($inputValue);
				break;																														
		}
	}	
		
	public function ValidatePHP()
	{
		$errorsExist = 0;				
		$_SESSION['errors']['unit_cd'] = 'hidden';
		$_SESSION['errors']['unit_name'] = 'hidden';


		//驗證cd
		/*
		if( !$this->ValidateUnitCd($_POST['unit_cd']))
		{
			$_SESSION['errors']['unit_cd'] = 'error';
			$errorsExist = 1;
		}
		 */		
		//驗證name
		if( !$this->ValidateUnitName($_POST['unit_name']))
		{
			$_SESSION['errors']['unit_name'] = 'error';
			$errorsExist = 1;
		}
		
		//驗證通過
		if ( $errorsExist == 0){
		  	//寫入資料庫
		  
		  	// modify by Samuel @ 2009/08/01
			// 直接給定一個 unit_cd 的最大值 然後 把名稱輸入即可
		  	$sql = "SELECT max(unit_cd) FROM lrtunit_basic_";
			$next_unit_cd = db_getOne($sql)+1;
			
			$sql  = "INSERT INTO lrtunit_basic_ (unit_cd, unit_name, unit_abbrev, unit_e_name, unit_e_abbrev, department)";
			$sql .= "VALUES ( '{$next_unit_cd}', '".$_POST[unit_name]."','".$_POST[unit_abbrev]."','".$_POST[unit_e_name]."',
			  '".$_POST[unit_e_abbrev]."','".$_POST[department]."')";		
			$res = $this->pearDB->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			unset($_SESSION[values]);
			unset($_SESSION[errors]);
			return "unit_basic.php";
		}		
		//驗證有錯誤
		else{
			foreach( $_POST as $key => $value){
				$_SESSION['values'][$key] = $_POST[$key];
			}
			return 'unit_basic.php';
		}		
	}
		
	private function ValidateUnitCd($value)
	{
		$value = trim($value);
		if($value){
			//查看是否重複	
			$sql = "SELECT unit_cd FROM lrtunit_basic_ WHERE unit_cd='".$value."'";
			$res = $this->pearDB->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
			if($res->numRows()){
				$this->setErrorMsg("單位編號已經存在");
				return 0;
			}
			else{
				return 1;
			}
		}	
		else{
			$this->setErrorMsg("單位編號尚未填入");
			return 0; //not valid	
		}	
	}

	private function ValidateUnitName($value)
	{
		$value = trim($value);
		if($value){
			return 1; //valid
		}	
		else{
			$this->setErrorMsg("單位名稱尚未填入");
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

}

?>

<?php
/***
FILE:   validateProfile.class.php
DATE:   2006/11/26
AUTHOR: zqq

驗證的物件
**/

require_once ('../config.php');
require_once ('../library/account.php');
class ValidateProfile
{
	//DataBase
	private $pearDB;
	private $errorMsg; //for AJAX
	function __construct($DB_CONN)
	{
		$this->pearDB = $DB_CONN;
		$this->errorMsg ="";

	}

	function __destruct()
	{
		//$this->pearDB->disconnect();
	}

//AJAX驗證欄位資料
	public function ValidateAJAX ( $inputValue, $fieldID)
	{
		switch( $fieldID )
		{
			case	'txtName':
				return $this->validateName($inputValue);
				break;

			//身分證與護照	
			case	'txtID':
				return $this->validateID($inputValue);
                break;

			case	'txtpassport':
				return $this->validatepassport($inputValue);
				break;

			case	'selBirthYear':
				 return $this->validatebornDate($inputValue);
				 break;
			case	'selGender':
				return $this->validateGender($inputValue);
				break;
		 	case	'txtTel':
				return $this->validateTel($inputValue);
				break;
		/* 
			case	'txtcellTel':
				return $this->validatecellTel($inputValue);
				break;
		 */
			case	'txtTeachDoc':
				return $this->validatetechDoc($inputValue);
				break;
		/*	case	'txtfaxTel':
				return $this->validatefaxTel($inputValue);
				break;
		*/
			case	'txtEmail':
				return $this->validateEmail($inputValue);
				break;
			case	'txtOthersch':
				return $this->validateOthersch($inputValue);
				break;
		/*	case	'txtZoneCd':
				return $this->validateZoneCd($inputValue);
				break;
			case	'txtAddr':
				return $this->validateAddr($inputValue);
				break;
			case	'txtOrganization':
				return $this->validateOrganization($inputValue);
				break;
			case	'txtJob':
				return $this->validateJob($inputValue);
				break;
		*/
		}
	}

	public function findSimAddr( $prefix )
	{
		$result = array();
		$query_county = FALSE;
		//開啟 zip.csv檔
		$fp = fopen("data/zip.csv", "r");
		if(!$fp){
			echo "Cannot open file";
			return FALSE;
		}

		$prefix_len = mb_strlen($prefix, "utf-8");
		if($prefix_len < 3) {
			$query_county = TRUE;
		}

		while(!feof($fp)){
			$line = fgets($fp);
			$data_ = explode(",",$line);
			$zip = $data_[0];   //zip
			$county = $data_[1];
			$seg = $data_[2];
			$road = $data_[3];
			if($query_county){ //如果長度小於三
				if( (!in_array($county, $result)) && strpos($county, $prefix) === 0 ){
					array_push($result, $county);
				}
			}
			else
			{
				$addr1 = $county . $seg;
				$alen = mb_strlen($addr1, "utf-8");
				if($prefix_len < $alen){
					if(!in_array($addr1, $result) && strpos($addr1, $result) === 0){
						array_push($result, $addr1);
					}
				}
				else
				{
					$addr2 = $addr1 . $road;
					if(strpos($addr2, $prefix) === 0){
						array_push($result, $addr2 . "(" . $zip . ")");
					}
				}
			}
		}
		fclose($fp);
		return $result;
	}

	public function ValidatePHP()
	{
		$errorsExist = 0;

		if (isset ($_SESSION['errors']))
			unset ($_SESSION['errors']);

		$_SESSION['errors']['txtName']			= 'hidden';
		//身分證與護照
		$_SESSION['errors']['txtID']			= 'hidden';
		$_SESSION['errors']['txtpassport']		= 'hidden';
		$_SESSION['errors']['selBirthYear']		= 'hidden';
		$_SESSION['errors']['txtTel']			= 'hidden';
		$_SESSION['errors']['txttechCode']		= 'hidden';
		$_SESSION['errors']['txtcellTel']		= 'hidden';
		$_SESSION['errors']['txtfaxTel']		= 'hidden';
		$_SESSION['errors']['txtEmail']			= 'hidden';
		$_SESSION['errors']['txtTeachDoc']		= 'hidden';
		$_SESSION['errors']['txtOthersch']		= 'hidden';
		$_SESSION['errors']['txtAddr']			= 'hidden';
		$_SESSION['errors']['txtZoneCd']		= 'hidden';
		$_SESSION['errors']['txtOrganization']		= 'hidden';
		$_SESSION['errors']['txtJob']			= 'hidden';
		$_SESSION['errors']['txtJobLevel']		= 'hidden';

		//驗證name
		if( !$this->validateName($_POST['txtName']))
		{
			$_SESSION['errors']['txtName'] = 'error';
			$errorsExist = 1;
		}

		//驗證身份
	        if($_POST['selRole'] == -1)//未做選擇
	        {
	          $_SESSION['errors']['selRole'] = 'error';
                  $errorsExist = 1;
		}

		//驗證職稱
		if($_POST['selRole'] == 1 || $_POST['selRole'] == 2){
		    if($_POST['title'] == -1){
		      $errorsExist = 1;
		    }
		}

		//驗證身份證及護照號碼
		if($_POST['idorpas'] == 0){
		      //驗證ID
		      if( !$this->validateID($_POST['txtID']))
		      {
			      $_SESSION['errors']['txtID'] = 'error';
			      $errorsExist = 1;
		      }
		}else{
		      //驗證護照
		      if( !$this->validatepassport($_POST['txtpassport']))
		      {
			      $_SESSION['errors']['txtpassport'] = 'error';
			      $errorsExist = 1;
		      }
        }


		//驗證教師證號
		//只有國民中小學教師,高中職教師需認證
		if($_POST['selRole'] == 1 || $_POST['selRole'] == 2){
			if( !$this->validatetechDoc($_POST['txtTeachDoc']))
			{
				$_SESSION['errors']['txtTeachDoc'] = 'error';
				$errorsExist = 1;
			}
		}

		//性別預設會選定
		//與身份證一起驗證！





		//身份別
		if($_POST['selRole'] == 0){
		  if($_POST['familysite'] == 5){
		  	if(trim($_POST['txtfamilysite']) == "")
			  $errorsExist = 1;
		  }
		}

		//驗證bornDate
		if($_POST['selRole'] == 0){
		    if($_POST['selBirthYear'] == 0)
		    {
			    $_SESSION['errors']['selBirthYear'] = 'error';
			    $errorsExist = 1;
		    }
		}		

		//驗證Tel
		if( !$this->validateTel($_POST['txtTel']))
		{
			$_SESSION['errors']['txtTel'] = 'error';
			$errorsExist = 1;
		}


		//驗證mail
		if( !$this->validateEmail($_POST['txtEmail']))
		{
			$_SESSION['errors']['txtEmail'] = 'error';
			$errorsExist = 1;
		}


		//是否選擇所在縣市
		if($_POST['selCity'] == 0){
	    	   $errorsExist = 1;
		}


		//驗證其它學校名稱
		if($_POST['selRole'] != 0 && $_POST['selSchname'] == -2){
		    if( !$this->validateOthersch($_POST['txtOthersch']))
		    {
			    $_SESSION['errors']['txtOthersch'] = 'error';
			    $errorsExist = 1;
		    }
		}

		//驗證是否已經選擇學校
		if($_POST['selRole'] != 0 && $_POST['selSchname'] != -2 && $_POST['selSchname'] == -1){
		   $errorsExist = 1;
		}

		//驗證是否選擇數位機會中心
		if($_POST['selRole'] == 0 && $_POST['selDoc'] == -1){
		  $errorsExist = 1;
		}	


		//職業預設會選定
		
			
		
		//有興趣選讀的課程
		if($_POST['interest']['5'] == 1 && trim($_POST['txtInterest']) == ""){
		   $errorsExist = 1;
		}



		
		//驗證通過
		if ( $errorsExist == 0){

			foreach( $_POST as $key => $value){
					$_SESSION['values'][$key] = $_POST[$key];
			}
			//inset into DB
			$personal_id = create_account($_SESSION['register']['login_id'],$_SESSION['register']['pass'],3);
			if($personal_id == -1) {
				echo '帳號已存在';
				exit(0);
			}
			update_account(array("password_hint" => $_SESSION['register']['passhint'], "login_state" => 1, "validated" => 0), $personal_id);

			//for email validate user
			srand((double)microtime()*1000000);
			$randval = rand();

			$_SESSION['personal_id'] = $personal_id;
			$_SESSION['randvalue']   = $randval;
			
			//建立interst sring
			$interest = "";
			for($i = 0 ; $i < sizeof($_POST['interest']) ; $i++){
			  if($_POST['interest'][$i] == 1){
			     if($i == 5)
			        $interest =  $interest . $i . "," . trim($_POST['txtInterest']);
			     else
				 $interest = $interest . $i . ",";
			  }
			}
				
			//echo $interest;
			//echo $sql;
			if( $personal_id != ''){
				$sql = "
					Update personal_basic SET
						personal_name = '$_POST[txtName]',
						dist_cd = '$_POST[selRole]',
						title   = '$_POST[title]',
						nickname='$_POST[txtNickname]',	
						idorpas = '$_POST[idorpas]',
						teach_doc ='$_POST[txtTeachDoc]',
						sex='$_POST[selGender]',
						familysite = '$_POST[familysite]',
						familysiteo = '$_POST[txtfamilysite]',
						d_birthday='{$_POST['selBirthYear']}-00-00',
						tel='$_POST[txtTel]',
						email='$_POST[txtEmail]',
						zone_cd='$_POST[txtZoneCd]',
						addr='$_POST[txtAddr]',
						city_cd='$_POST[selCity]',
						doc_cd = '$_POST[selDoc]',
						school_type='$_POST[selSchlevel]',
						school_cd='$_POST[selSchname]',
						othersch='$_POST[txtOthersch]',
						job = '$_POST[job]',
						organization  = '$_POST[txtOrganization]',
						degree='$_POST[degree]',
						interest='$interest',
						recnews='$_POST[recnews]',	
						note='$_SESSION[randvalue]',
						personal_style=''
						WHERE personal_id=$personal_id";
				
				$res = $this->pearDB->query($sql);
				if (PEAR::isError($res))
					die($res->getMessage());
				return 'user_profile.php?ok=true';
			}else{
				echo "error";
			}
		}
		//驗證有錯誤
		else{
			foreach( $_POST as $key => $value){
				$_SESSION['values'][$key] = $_POST[$key];
			}
			return "user_profile.php?s=true";
		}
	}

	private function getPersonal_idByUsername($username)
	{
		$sql = "SELECT personal_id FROM register_basic WHERE login_id='".$username."'";
		$res = $this->pearDB->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());

		if($res->numRows() == 0)
		{
			return 0;
		}
		else
		{
			$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
			return $row[personal_id];
		}
	}


	private function validateName($value)
	{
		$value = trim($value);
		if($value){
			return 1; //valid
		}
		else{
			$this->setErrorMsg("姓名尚未填入");
			return 0; //not valid
		}
	}

	private function validateID($value)
	{
		$value = strtoupper($value);
		//建立字母分數陣列
		$headPoint = array(
			'A'=>1,'I'=>39,'O'=>48,'B'=>10,'C'=>19,'D'=>28,
			'E'=>37,'F'=>46,'G'=>55,'H'=>64,'J'=>73,'K'=>82,
			'L'=>2,'M'=>11,'N'=>20,'P'=>29,'Q'=>38,'R'=>47,
			'S'=>56,'T'=>65,'U'=>74,'V'=>83,'W'=>21,'X'=>3,
			'Y'=>12,'Z'=>30
		);
		//建立加權基數陣列
		$multiply = array(8,7,6,5,4,3,2,1);
		//檢查身份字格式是否正確
		if (ereg("^[a-zA-Z][1-2][0-9]+$",$value) AND strlen($value) == 10){
			//切開字串
			$len = strlen($value);
			for($i=0; $i<$len; $i++){
				$stringArray[$i] = substr($value,$i,1);
			}
			//取得字母分數
			$total = $headPoint[array_shift($stringArray)];
			//取得比對碼
			$point = array_pop($stringArray);
			//取得數字分數
			$len = count($stringArray);
			for($j=0; $j<$len; $j++){
				$total += $stringArray[$j]*$multiply[$j];
			}
			//計算餘數碼並比對
			$last = (($total%10) == 0 )?0:(10-($total%10));
			if ($last != $point) {	
				$this->setErrorMsg("身分證字號有誤");
				return 0;
			}
		}else {
			$this->setErrorMsg("身分證字號有誤");
			return 0;
		}

		global $DB_CONN;
		$sql = "SELECT *
			FROM personal_basic AS pb, register_basic AS rb
			WHERE pb.personal_id = rb.personal_id AND pb.identify_id = '{$value}'AND rb.role_cd = 3";
		$res = $DB_CONN->query($sql);
		if(PEAR::isError($res)) die($res->getMessage());
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		if(isset($row['personal_id'])){
			$this->setErrorMsg('此身份證字號已經被註冊過了');
			return 0;
		}else
			return 1;
	}


	private function validatepassport($value){	
	    $value = trim($value);
	    if($value){
		global $DB_CONN;
		$sql = "SELECT *
			FROM personal_basic AS pb, register_basic AS rb
			WHERE pb.personal_id = rb.personal_id AND pb.passport = '{$value}' AND rb.role_cd = 3";
		$res = $DB_CONN->query($sql);
		if(PEAR::isError($res)) die($res->getMessage());
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		    if(isset($row['personal_id'])){
			    $this->setErrorMsg('此護照號碼已經被註冊過了');
			    return 0;
		    }else
			    return 1;
		    }
	    else{
			$this->setErrorMsg("未填入護照號碼");
			return 0; //not valid
	    }
	
	
	
	}
	private function validatebornDate($value)
	{
		$value = trim($value);
		if($value){
			return 1; //valid
		}
		else{
			$this->setErrorMsg("未填入出生日期");
			return 0; //not valid
		}
	}


	private function validateTel($value)
	{
		$value = trim($value);
		if($value){
			return 1; //valid
		}
		else{
			$this->setErrorMsg("電話尚未填入");
			return 0; //not valid
		}
	}

	private function validatetechDoc($value)
	{
		$value = trim($value);
		if($value){
			return 1; //valid
		}
		else{
			$this->setErrorMsg("教師證號未填入");
			return 0; //not valid
		}

	}

	private function validatecellTel($value)
	{
		$value = trim($value);
		if($value){
			return 1; //valid
		}
		else{
			$this->setErrorMsg("行動電話尚未填入");
			return 0; //not valid
		}
	}


	private function validatefaxTel($value)
	{
		$value = trim($value);
		if($value){
			return 1; //valid
		}
		else{
			$this->setErrorMsg("傳真電話尚未填入");
			return 0; //not valid
		}
	}

	private function validateEmail($value)
	{
		$value = trim($value);
		if (eregi("^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}$",$value)) 
			return 1; //valid
		else{
			$this->setErrorMsg("電子信箱尚未填入或者錯誤");
			return 0; //not valid	
		}
	}

	private function validateZoneCd($value)
	{
		$value = trim($value);
		if($value){
			return 1; //valid
		}
		else{
			$this->setErrorMsg("郵遞區號尚未填入");
			return 0; //not valid
		}
	}

	private function validateAddr($value)
	{
		$value = trim($value);
		if($value){
			return 1; //valid
		}
		else{
			$this->setErrorMsg("住址尚未填入");
			return 0; //not valid
		}
	}

	private function validateOrganization($value)
	{
		$value = trim($value);
		if($value){
			return 1; //valid
		}
		else{
			$this->setErrorMsg("服務單位尚未填入");
			return 0; //not valid
		}
	}

	private function validateinsCode($value)
	{
		$value = trim($value);
		if($value){
			return 1; //valid
		}
		else{
			$this->setErrorMsg("尚未填入機關代碼");
			return 0; //not valid
		}
	}
	private function validateOthersch($value)
	{
		$value = trim($value);
		if($value){
			return 1; //valid
		}
		else{
			$this->setErrorMsg("尚未填入其它學校名稱");
			return 0; //not valid
		}
	}
	private function validateJobLevel($value)
	{
		$value = trim($value);
		if($value){
			return 1; //valid
		}
		else{
			$this->setErrorMsg("尚未填入職等");
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

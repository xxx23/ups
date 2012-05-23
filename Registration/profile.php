<?php
/***
FILE:   profile.php
DATE:   2006/11/26
AUTHOR: zqq

填寫個人基本資料的頁面
**/

    require_once("../config.php");
    require_once($HOME_PATH . 'library/smarty_init.php');
	//開啟session
	session_start();
	if (!isset ($_SESSION['register']['login_id']) || $_SESSION['register']['login_id'] == '')
	{
	  //非正常流程
	  	echo '請依正確流程瀏覽網頁';
		exit(0);
	}

	if (isset ($_SESSION['values']['txtUsername'])){
		unset($_SESSION['values']);
		unset($_SESSION['errors']);
	}

	//session變數
	if(!isset ($_SESSION['values']) ){
	        $_SESSION['values']['selRole'] = '-1';
		$_SESSION['values']['selRolelevel'] = '-1';
		//姓名
		$_SESSION['values']['txtName'] = '';
		$_SESSION['values']['txtNickname'] = '';
		//護照與身分證
		$_SESSION['values']['txtID'] = '';
		$_SESSION['values']['txtpassport'] = '';

		$_SESSION['values']['selBirthYear'] = '';
		$_SESSION['values']['selGender'] = '';
		$_SESSION['values']['txttechCode'] = '';
		$_SESSION['values']['txtTel'] = '';
		$_SESSION['values']['txtcellTel'] = '';
		$_SESSION['values']['txtfaxTel'] = '';
		$_SESSION['values']['txtEmail'] = '';
		$_SESSION['values']['txtZoneCd'] = '';
		$_SESSION['values']['txtAddr'] = '';
		$_SESSION['values']['selDegree'] = '';
		$_SESSION['values']['selDist_cd'] = '';
		$_SESSION['values']['txtTeachDoc'] = '';
		$_SESSION['values']['txtOthersch'] = '';
		$_SESSION['values']['txtOrganization'] = '';
		$_SESSION['values']['txtJob'] = '';
		$_SESSION['values']['txtIntroduction'] = '';
		$_SESSION['values']['txtInterest'] = '';
		$_SESSION['values']['recnews'] = '';
		$_SESSION['values']['txtSkill'] = '';
		$_SESSION['values']['txtExperience'] = '';
		$_SESSION['values']['txtNote'] = '';
		$_SESSION['values']['txtinsCode'] = '';
		$_SESSION['values']['txtJob'] = '';
		$_SESSION['values']['txtJobLevel'] = '';
	}
	if (!isset ($_SESSION['errors'] ) ){
	  	//姓名
		$_SESSION['errors']['txtName'] = 'hidden';
		$_SESSION['errors']['txttechDoc'] = 'hidden';
		//護照身分證
		$_SESSION['errors']['txtID'] = 'hidden';
		$_SESSION['errors']['txtpassport'] = 'hidden';

		$_SESSION['errors']['selBirthYear'] = 'hidden';
		$_SESSION['errors']['selGender'] = 'hidden';
		$_SESSION['errors']['txtTel'] = 'hidden';
		$_SESSION['errors']['txtcellTel'] = 'hidden';
		$_SESSION['errors']['txtfaxTel'] = 'hidden';
		$_SESSION['errors']['txtEmail'] = 'hidden';
		$_SESSION['errors']['txtZoneCd'] = 'hidden';
		$_SESSION['errors']['txtAddr'] = 'hidden';
		$_SESSION['errors']['txtTeachDoc'] = 'hidden';
		$_SESSION['errors']['txtOrganization'] = 'hidden';
		$_SESSION['errors']['txtOthersch'] = 'hidden';
		$_SESSION['errors']['txtJob'] = 'hidden';
		$_SESSION['errors']['txtJobLevel'] = 'hidden';
		$_SESSION['errors']['txtinsCode'] = 'hidden';
	}
	//reassign時將欄位值存入session	
	if(!isset($_GET['s'])){
	  	//姓名
		$_SESSION['values']['txtName'] = $_POST['txtName'];
		$_SESSION['values']['selRole'] = $_POST['selRole'];
		$_SESSION['values']['txtNickname'] = $_POST['txtNickname'];

		//身分證與護照號碼
		$_SESSION['values']['idorpas'] = $_POST['idorpas'];
		$_SESSION['values']['txtID'] = $_POST['txtID'];	
        $_SESSION['values']['txtpassport'] = $_POST['txtpassport'];
		//職稱
		$_SESSION['values']['title'] = $_POST['title'];	
		//職業
		$_SESSION['values']['job'] = $_POST['job'];	
		//您的籍貫
		$_SESSION['values']['radiofamilysite'] = $_POST['familysite'];
		$_SESSION['values']['txtfamilysite'] = $_POST['txtfamilysite'];
		//個人學歷
		$_SESSION['values']['degree'] = $_POST['degree'];
		//有興趣課程類別
		$_SESSION['values']['interest'] = $_POST['interest'];
		$_SESSION['values']['txtInterest']   = $_POST['txtInterest'];
		//是否接收最新消息通知
		$_SESSION['values']['recnews'] = $_POST['recnews'];
		
		
		$_SESSION['values']['selBirthYear'] = $_POST['selBirthYear'];
		$_SESSION['values']['selGender'] = $_POST['selGender'];
		$_SESSION['values']['txttechCode'] = $_POST['txttechCode'];
		$_SESSION['values']['txtTel'] = $_POST['txtTel'];
		
		$_SESSION['values']['txtEmail'] = $_POST['txtEmail'];
		$_SESSION['values']['txtZoneCd'] = $_POST['txtZoneCd'];
		$_SESSION['values']['txtAddr'] = $_POST['txtAddr'];
		$_SESSION['values']['selDegree'] = $_POST['selDegree'];
		$_SESSION['values']['selDist_cd'] = $_POST['selDist_cd'];
		$_SESSION['values']['selCity'] = $_POST['selCity'];
		$_SESSION['values']['selDoc'] = $_POST['selDoc'];
		$_SESSION['values']['selSchlevel'] = $_POST['selSchlevel'];
		$_SESSION['values']['selSchname'] = $_POST['selSchname'];
		$_SESSION['values']['txtTeachDoc'] = $_POST['txtTeachDoc'];
		$_SESSION['values']['txtOthersch'] = $_POST['txtOthersch'];
		$_SESSION['values']['txtOrganization'] = $_POST['txtOrganization'];
		$_SESSION['values']['txtNote'] = $_POST['txtNote'];
		$_SESSION['values']['txtJob'] = $_POST['txtJob'];
	}

	//new smarty
	//$tpl = new Smarty();
	//------註冊狀態的圖---------
	$IMAGE_PATH = "../" . $IMAGE_PATH;
	$tpl->assign("registerState", $IMAGE_PATH . "register_2.PNG");
	$tpl->assign("loadingGif", $IMAGE_PATH . "progress_loading.gif");
	
	//-------------1.姓名--------------------
	$tpl->assign("valueOfName",$_SESSION['values']['txtName']);
	$tpl->assign("txtNameFailed",$_SESSION['errors']['txtName']?$_SESSION['errors']['txtName']:'hidden');
	//------------ 2.身份--------------------
	if(isset($_SESSION['values']['selRole']))	
	   $tpl->assign("selRole",$_SESSION['values']['selRole']);
	else
	   $tpl->assign("selRole",-1);
	//-------------3.暱稱--------------------
	$tpl->assign("valueOfNickname",$_SESSION['values']['txtNickname']);
	$tpl->assign("txtNicknameFailed",$_SESSION['errors']['txtNickname']);
	//-------------4.身分證或護照--------------------
	$tpl->assign("idorpas",$_SESSION['values']['idorpas']);
	$tpl->assign("valueOfID",$_SESSION['values']['txtID']);
	$tpl->assign("txtIDFailed",$_SESSION['errors']['txtID']);
	
	$tpl->assign("valueOfpassport",$_SESSION['values']['txtpassport']);
	$tpl->assign("txtpassportFailed",$_SESSION['errors']['txtpassport']);
	$tpl->assign("txtbornDateFailed",$_SESSION['errors']['txtbornDate']);

	//-------------性別--------------------
	$tpl->assign("valueOfGender",$_SESSION['values']['selGender']);
	$tpl->assign("selGenderFailed",$_SESSION['errors']['selGender']);

	//------------您的籍貫-----------------
	$tpl->assign("familysite",$_SESSION['values']['radiofamilysite']);
	$tpl->assign("txtfamilysite",$_SESSION['values']['txtfamilysite']);
	//-------------生日--------------------	
	$selBthYear_ids = setIds(1912, date('Y'));
	$selBthYear_names = setNames(1912,date('Y'));
	for($i = 1 ; $i < sizeof($selBthYear_names) ;  $i++){
		$selBthYear_names[$i] = $selBthYear_names[$i] . "(民國" . ($selBthYear_names[$i]-1911) ."年)";
	}
	//selected 預設為第一欄
	if(!isset($_SESSION['values']['selBirthYear']))
	  $selBthYear = "-1";
	else
	  $selBthYear = $_SESSION['values']['selBirthYear'];
	//--year
	$tpl->assign("selBirthYear_ids", $selBthYear_ids);
	$tpl->assign("selBirthYear_names", $selBthYear_names);
	$tpl->assign("selBirthYear", $selBthYear);
	//-------------學歷--------------------
	$selDegree_ids = array(0, 1, 2, 3, 4, 5, 6);
	$selDegree_names = array("請選擇", "高中以下" , "高中" , "專科" ,"大學" , "碩士", "博士");
	if(!isset($_SESSION['values']['selGender'])){
	   $selDegree = "0";
	}
	else
	  $selDegree = $_SESSION['values']['selDegree'];
	$tpl->assign("selDegree_ids", $selDegree_ids);
	$tpl->assign("selDegree_names", $selDegree_names);
	$tpl->assign("selDegree", $selDegree);
	//---------------職稱-----------------------
	$tpl->assign("title",$_SESSION['values']['title']);
	//-------------教師證號--------------------
	$tpl->assign("valueOftechDoc",$_SESSION['values']['txttechDoc']);
	$tpl->assign("txttechDocFailed",$_SESSION['errors']['txttechDoc']);

	//-------------電話--------------------
	$tpl->assign("valueOfTel",$_SESSION['values']['txtTel']);
	$tpl->assign("txtTelFailed",$_SESSION['errors']['txtTel']);

	//-------------Email--------------------
	$tpl->assign("valueOfEmail",$_SESSION['values']['txtEmail']);
	$tpl->assign("txtEmailFailed",$_SESSION['errors']['txtEmail']);

	//-------------住址--------------------
	$tpl->assign("valueOfAddr",$_SESSION['values']['txtAddr']);
	$tpl->assign("txtAddrFailed",$_SESSION['errors']['txtAddr']);

	//-------------郵遞區號--------------------
	$tpl->assign("valueOfZoneCd",$_SESSION['values']['txtZoneCd']);
	$tpl->assign("txtZoneCdFailed",$_SESSION['errors']['txtZoneCd']);

	//-------------教師證號--------------------
	$tpl->assign("valueOfTeachDoc",$_SESSION['values']['txtTeachDoc']);
	$tpl->assign("txtTeachDocFailed",$_SESSION['errors']['txtTeachDoc']);

	//-------------服務單位--------------------
	$tpl->assign("valueOfOrganization",$_SESSION['values']['txtOrganization']);
	$tpl->assign("txtOrganizationFailed",$_SESSION['errors']['txtOrganization']);

	//-------------職位--------------------
	$tpl->assign("job",$_SESSION['values']['job']);
 
	//-------------學位--------------------
	$tpl->assign("degree",$_SESSION['values']['degree']);

	//-------------興趣--------------------
	$tpl->assign("valueOfInterest0",$_SESSION['values']['interest'][0]);
	$tpl->assign("valueOfInterest1",$_SESSION['values']['interest'][1]);
	$tpl->assign("valueOfInterest2",$_SESSION['values']['interest'][2]);
	$tpl->assign("valueOfInterest3",$_SESSION['values']['interest'][3]);
	$tpl->assign("valueOfInterest4",$_SESSION['values']['interest'][4]);
	$tpl->assign("valueOfInterest5",$_SESSION['values']['interest'][5]);
	
	$tpl->assign("valueOftxtinterest",$_SESSION['values']['txtInterest']);
	//-------------是否接收新的訊息--------------------
	if(isset($_SESSION['values']['recnews'])){	
	   $tpl->assign("recnews",$_SESSION['values']['recnews']);
	}else{
	   $tpl->assign("recnews",1);
	}
	
	//-------------所在縣市-----------------------	
	//*****所在縣市的select'請選擇'value為0
	$sql="select city_cd , city from location group by city_cd ";
	$res=$DB_CONN->query($sql);
	if (PEAR::isError($res))        die($res->getMessage());

	$index = 0;
	$selCity_ids[$index] = "-1";
	$selCity_names[$index++] = "請選擇";
	while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
	   $selCity_ids[$index] = $row['city_cd']; 
	   $selCity_names[$index] = $row['city']; 
	   $index++;
	}
	if(!isset($_SESSION['values']['selCity']))
	   $selCity = "-1";
	else
	   $selCity = $_SESSION['values']['selCity'];
	$tpl->assign("selCity_ids", $selCity_ids);
	$tpl->assign("selCity_names", $selCity_names);
	$tpl->assign("selCity", $selCity);

	
	//-------------機會學習中心-----------------------
	//當已經選擇所在縣市以及role為一般民眾	
	if($_SESSION['values']['selCity'] != 0 && ($_SESSION['values']['selRole'] == 0 || $_SESSION['values']['selRole'] == 5 ) ){
	$sql="select doc_cd , doc from docs where city_cd = {$_SESSION['values']['selCity']}";
	$res=$DB_CONN->query($sql);
	if (PEAR::isError($res))        die($res->getMessage());

	$index = 0;
	$selDoc_ids[$index] = "-1";
	$selDoc_names[$index++] = "請選擇";
	//機會學習中心select '請選擇'value = -1 , 不請楚:-2 .未設置:-3
	if($res->numRows() == 0){
	   $noDOC = true;
	   $selDoc_ids[0] = -1;
	   $selDoc_names[0] = "請選擇";
	   $selDoc_ids[1] = -3;
	   $selDoc_names[1] = "未設置DOC";
	}
	else
	{
	   $noDOC = false;
	   $selDoc_ids[$index] = '-2';
	   $selDoc_names[$index++] = '不清楚';
	while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
	     $selDoc_ids[$index] = $row['doc_cd']; 
	     $selDoc_names[$index] = $row['doc']; 
	     $index++;
	   }
	}

	if(!isset($_SESSION['values']['selDoc']))
	  $selDoc = "-1";
	else
	  $selDoc = $_SESSION['values']['selDoc'];

	}

	
	$tpl->assign("noDOC",$noDOC);
	$tpl->assign("selDoc_ids", $selDoc_ids);
	$tpl->assign("selDoc_names", $selDoc_names);
	$tpl->assign("selDoc", $selDoc);


	//-------------各級學校-----------------------
	//*****所在縣市的select'請選擇'value為0
	if($_SESSION['values']['selRole'] == 1){
	  //國民中小學教師
	  $selSchlevel_ids = array(-1, 1, 2);
	  $selSchlevel_names = array("請選擇","國小","國中");
	}
	else if($_SESSION['values']['selRole'] == 2){
	  //高中職教師
	  $selSchlevel_ids = array(-1, 3, 4);
     	  $selSchlevel_names = array("請選擇","高中","高職");

	}
	else if($_SESSION['values']['selRole'] == 3 || $_SESSION['values']['selRole'] == 4){
	  $selSchlevel_ids = array(-1,5);
	  $selSchlevel_names = array("請選擇","大專院校");
	}
	if(!isset($_SESSION['values']['selSchlevel'])) 
	  $selSchlevel = "0";
	else
	  $selSchlevel = $_SESSION['values']['selSchlevel'];
	$tpl->assign("selSchlevel_ids", $selSchlevel_ids);
	$tpl->assign("selSchlevel_names", $selSchlevel_names);
	$tpl->assign("selSchlevel", $selSchlevel);


	//-------------學校名稱-----------------------	
	//*****學校名稱的select'請選擇'value為-1
	//當以選擇所在縣市以及各級學校
	if($_SESSION['values']['selCity'] != 0 && $_SESSION['values']['selSchlevel'] != 0){
	$sql="select school_cd , school from location where city_cd = {$_SESSION['values']['selCity']} and type = {$_SESSION['values']['selSchlevel']}";
	$res=$DB_CONN->query($sql);
	if (PEAR::isError($res))        die($res->getMessage());

	//學校名稱select '請選擇'value = -1 ,其它學校 value = -2
	$index = 0;
	$selSchname_ids[$index] = "-1";
	$selSchname_names[$index++] = "請選擇";
	while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
	   $selSchname_ids[$index] = $row['school_cd']; 
	   $selSchname_names[$index] = $row['school']; 
	   $index++;
	 }
	}
	$selSchname_ids[$index] = '-2';
	$selSchname_names[$index] = '其它學校';


	if(!isset($_SESSION['values']['selSchname']))
	  $selSchname = "-1";
	else
	  $selSchname = $_SESSION['values']['selSchname'];
	  
	$tpl->assign("role_type", $_SESSION['role_type'] ) ; //申請者在平台身分
	$tpl->assign("selSchname_ids", $selSchname_ids);
	$tpl->assign("selSchname_names", $selSchname_names);
	$tpl->assign("selSchname", $selSchname);

	//-------------其它學校--------------------
	$tpl->assign("valueOfOthersch",$_SESSION['values']['txtOthersch']);
	$tpl->assign("txtOtherschFailed",$_SESSION['errors']['txtOthersch']);
	//-------------------------------------------------//
	$tpl->display("profile.tpl");

function setIds($begin, $end){
	$array[0] = 0;
	for($i = 1; $i <= $end-$begin+1 ; $i++){
		$array[$i] = $begin + $i-1;
	}
	return $array;
}

function setNames($begin, $end){
	$array[0] = "請選擇";
	for($i = 1; $i <= $end-$begin+1 ; $i++){
		$array[$i] = ''.$begin + $i -1;
	}
	return $array;
}
?>

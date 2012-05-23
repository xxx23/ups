<?php
//File: test_user_profile.php
//Modify: 20090828
//Modify by:q110185
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
    require_once($RELEATED_PATH . "library/filter.php");
	require_once($HOME_PATH . 'library/smarty_init.php');

	update_status("修改個人資料");

    //to save the status whether image is uploaded or not
    $img_upload_status=false;

	//get data form login create session
    if($_SESSION['role_cd'] == 0)
    {
		if(isset($_GET['id'])){		//這裡若成立表示是管理者去修改其他人員的資料，
			$personal_id = $_GET['id'];
			$tpl->assign("personal_id_tag1","?id=".$personal_id);
			$tpl->assign("personal_id_tag2","&id=".$personal_id);
		}else
			$personal_id = $_SESSION['personal_id'];
	}
	else
		$personal_id = $_SESSION['personal_id'];

	$role_cd = $_SESSION['role_cd'];         //角色編號
	$dist_cd = getDistCd($personal_id);    //身分編號
	$schowSchool =1;
	$sel=0;

    if(array_key_exists('action', $_GET) && $_GET['action'] == "modifyDone")
        $tpl->assign("modify_message", "更新完畢");

    if(array_key_exists('action', $_GET) && $_GET['action'] == "modifyProfile")
    {
		$interestTxt = "";
        for($i = 0 ; $i < 6 ; $i++)
        {
            if($_POST['interest'][$i] == 1)
            {
                if($i == 5)
                    $interestTxt =  $interestTxt . $i . "," . trim(str_replace(',','&',optional_param('interestTxt','',PARAM_TEXT)));
                else
                    $interestTxt = $interestTxt . $i . ",";
		  }
        }
        //TODO:varify data
        $identify_id = optional_param('identify_id','',PARAM_TEXT);
        if($identify_id != NULL && !validate_identify($identify_id))
        {
            echo "修改未成功";
            $tpl->assign("modify_message","身分證格式錯誤");
        }
        else
        {
            //echo "STORE:".$interestTxt."<br/>";
            //echo optional_param('d_birthday', PARAM_TEXT)."<br/>";

            $sql = "UPDATE
                    personal_basic
                    SET"."
                    idorpas = '".optional_param('idorpas',PARAM_INT)."',
                    identify_id = '".optional_param('identify_id','',PARAM_TEXT)."',
                    passport  = '".optional_param('passport','',PARAM_TEXT)."',
                    personal_name = '".optional_param('personal_name','',PARAM_TEXT)."',
                    nickname	='".optional_param('nickname','',PARAM_TEXT)."',
                    sex		='".optional_param('sex','',PARAM_TEXT)."',
					d_birthday='".optional_param('d_birthday','',PARAM_TEXT)."-00-00',
                    tel		='".optional_param('tel','',PARAM_TEXT)."',
                    zone_cd		='".optional_param('zone_cd','',PARAM_TEXT)."',
                    addr		='".optional_param('addr','',PARAM_TEXT)."',
                    familysite = '".optional_param('familysite','',PARAM_TEXT)."',
                    familysiteo = '".optional_param('familysiteo','',PARAM_TEXT)."',
                    email		='".optional_param('email','',PARAM_TEXT)."', 
                    job		='".optional_param('job','',PARAM_TEXT)."',
                    title ='".optional_param('title','',PARAM_TEXT)."',
                    degree		='".optional_param('degree','',PARAM_TEXT)."', 
                    teach_doc  = '".optional_param('teach_doc','',PARAM_TEXT)."',
                    city_cd     ='".optional_param('city_cd','',PARAM_TEXT)."',
                    doc_cd     ='".optional_param('doc_cd','',PARAM_TEXT)."',
                    school_type    ='".optional_param('school_type','',PARAM_TEXT)."',
                    school_cd    ='".optional_param('school_cd','',PARAM_TEXT)."',
                    organization ='".optional_param('organization','',PARAM_TEXT)."',                     
                    interest	='".$interestTxt."',
                    dist_cd ='".optional_param('dist_cd','',PARAM_TEXT)."', 
                    recnews		='".optional_param('recnews','',PARAM_TEXT)."'
                WHERE personal_id='".$personal_id."'";
            $res = db_query($sql);
//            $tpl->assign("modify_message", "更新完畢");
            header("location:user_profile.php?id=".$_GET['id']."&action=modifyDone");
        }
	}
    else if(array_key_exists('action', $_GET) && $_GET['action'] == "uploadPhoto")
    {
		// 確認使用者已上傳檔案
		if ( $_FILES['photo']['tmp_name'] != "none" &&
				 $_FILES['photo']['tmp_name'] != "" &&
				 $_FILES['photo']['size'] > 0 )
		{
		  	$ext = strtolower(substr(strrchr($_FILES['photo']['name'], '.'), 1));
			if($ext != "jpg" && $ext != "bmp" && $ext != "png" && $ext != "gif" && $ext != "jpeg")
			{
			  	$tpl->assign("photo_err","副檔名不符合");
			}
			else
			{
                $UploadPath = getPersonalPath($personal_id) . "/";
				$tmp_name = $_FILES['photo']['name'];
				$oldName = explode(".", $tmp_name);
				$newName = "personal_photo." . $oldName[1] ;
				//刪除舊的檔案
				if(is_file($UploadPath . $newName))
					unlink($UploadPath . $newName);

				createPath($UploadPath);
				copy($_FILES['photo']['tmp_name'], $UploadPath . $newName);

                $personal_photo = $newName;
				$sql = "UPDATE personal_basic SET photo='". $personal_photo ."' WHERE personal_id='". $personal_id ."'";
				$res = db_query($sql);
				$img_upload_status=true;
			}
		}

    }
    else if(array_key_exists('action', $_GET) && $_GET['action'] == "sel") //選擇選項 更新頁面
    {
		$sel=1;
	}

	//取得使用者個人資料
	$sql="SELECT r.login_id, r.d_loging, o.role_name, r.login_state, r.validated
			FROM register_basic r, lrtrole_ o
			WHERE personal_id ='".$personal_id."'
			AND r.role_cd = o.role_cd";
	$result = db_query($sql);
	$userLogin = $result->fetchRow(DB_FETCHMODE_ASSOC);
	$sql = "SELECT personal_id, personal_name, nickname, dist_cd, idorpas,
				    identify_id,passport, teach_doc, sex, familysite, familysiteo,
				   d_birthday, title,tel, email, zone_cd, addr, city_cd, doc_cd,
				   school_type, school_cd, othersch, job, organization,
				   degree, interest, recnews, photo
			FROM personal_basic 
			WHERE personal_id='".$personal_id."'";

	$result = db_query($sql);
	$userProfile = $result->fetchRow(DB_FETCHMODE_ASSOC);
	$changeCity=0;
    $changeSchType =0;

    if($sel==1) //選擇某些選項後會更新頁面
    {
		$interestTxt = "";
        for($i = 0 ; $i < 6 ; $i++)
        {
            if($_POST['interest'][$i] == 1){
                if($i == 5)
                    $interestTxt =  $interestTxt . $i . "," . trim(str_replace(',','&',optional_param('interestTxt','',PARAM_TEXT)));
                else
                    $interestTxt = $interestTxt . $i . ",";
            }
		}
        $userProfile['title'] =optional_param('title','',PARAM_TEXT); 
        
        $userProfile['idorpas'] =optional_param('idorpas',0,PARAM_INT); 
        $userProfile['identify_id'] =optional_param('identify_id','',PARAM_TEXT); 
        $userProfile['passport'] =optional_param('passport','',PARAM_TEXT); 
        
        $userProfile['teach_doc'] =optional_param('teach_doc','',PARAM_TEXT); 
        $userProfile['nickname']        =optional_param('nickname','',PARAM_TEXT); 
        $userProfile['sex']             =optional_param('sex','',PARAM_TEXT); 
        $userProfile['familysite'] = optional_param('familysite','',PARAM_TEXT); 
        $userProfile['familysiteo'] = optional_param('familysiteo','',PARAM_TEXT); 
        $userProfile['degree']          =optional_param('degree','',PARAM_TEXT); 
        $userProfile['d_birthday']      =optional_param('d_birthday','',PARAM_TEXT); 
        $userProfile['tel']             =optional_param('tel'); 
        $userProfile['email']   =optional_param('email','',PARAM_TEXT); 
        $userProfile['zone_cd']         =optional_param('zone_cd','',PARAM_TEXT); 
        $userProfile['addr']            =optional_param('addr','',PARAM_TEXT); 
        $userProfile['city_cd']     =optional_param('city_cd','',PARAM_TEXT); 
        $userProfile['doc_cd']     =optional_param('doc_cd','',PARAM_TEXT); 
        $userProfile['school_type']    =optional_param('school_type','',PARAM_TEXT); 
        $userProfile['school_cd']    =optional_param('school_cd','',PARAM_TEXT); 
        $userProfile['organization']  =optional_param('organization','',PARAM_TEXT); 
        $userProfile['job']             = optional_param('job','',PARAM_TEXT); 
        $userProfile['interest']        =$interestTxt; 
        $userProfile['recnews']         = optional_param('recnews','',PARAM_TEXT); 
	}

	$userProfile['interest0'] = 0; 
	$userProfile['interest1'] = 0;
	$userProfile['interest2'] = 0;
	$userProfile['interest3'] = 0;
	$userProfile['interest4'] = 0;
	$userProfile['interest5'] = 0;
	$userProfile['interestTxt'] = '';
	//echo "AfterParse:".$userProfile['interest'].'<br/>';
	$arr = split(',',$userProfile['interest']);
	$str='interest';
	$c=0;
	for($i=0; $i<6 ;$i++)
	{
        if($arr[$c]==""){}
        elseif($arr[$c]== $i)
        {
			$index = $str.$i;
			$userProfile[$index]=1;
			if($i==5)
				$userProfile['interestTxt']= $arr[$c+1]?$arr[$c+1]:'';
			$c++;
		}
	}
	
    //-----test start-----
    //echo "<pre>";
    //var_dump($userProfile);
    //echo "</per>";
    //-----test end	-----
    
    $userProfile['photo'] = 'Personal_File/' . getPersonalLevel($personal_id) . '/' . $personal_id . '/' . $userProfile['photo'];

	//出生年
	$birthday =split('-',$userProfile['d_birthday']);
    $userProfile['d_birthday'] = $birthday[0];
    
    $selBthYear_ids = setIds(1912, date('Y'));
    $selBthYear_names = setNames(1912,date('Y'));
    for($i = 1 ; $i < sizeof($selBthYear_names) ;  $i++)
    {
        $selBthYear_names[$i] = $selBthYear_names[$i] . "(民國" . ($selBthYear_names[$i]-1911) ."年)";
    }

    $userProfile['d_birthday'] = $birthday[0];
	/*$userProfile['d_birthday_ids'] = $selBthYear_ids;
    $userProfile['d_birthday_names'] = $selBthYear_names;*/
    $tpl->assign('d_birthday_ids', $selBthYear_ids);
    $tpl->assign('d_birthday_names', $selBthYear_names);

	//身分
    if($_SESSION['role_cd'] == 1){
	  $tpl->assign("dist_cds",array(0,1,2,3,4,5,6,7));
	  $tpl->assign("dist_names",array("一般民眾","國民中小學教師","高中職教師","大專院校學生","大專院校教師","數位機會中心輔導團隊講師","縣市政府研習課程老師","其他"));
    }
    else{
	  $tpl->assign("dist_cds",array(0,1,2,3,4));
	  $tpl->assign("dist_names",array("一般民眾","國民中小學教師","高中職教師","大專院校學生","大專院校教師"));
    
    }
    $tpl->assign("idorpas_ids",array(0=>'身分證',1=>'護照'));
	//現職
	$tpl->assign("job_ids",array(0,1,2,3,4,5,6,7,8,9,10,11));
	$tpl->assign("job_names",array("工","商","農","林","魚","牧","教育","軍人","公職","管家","服務","其他"));

	//學歷	
	$tpl->assign("degree_ids"	, array(0, 1, 2, 3, 4, 5));
	$tpl->assign("degree_names"	, array("自修", "國中小學" , "高中職" , "專科學校" ,"大學" , "研究所以上",));
	
	//所在縣市
	$sql="select city_cd, city from location group by city_cd ";
	$res = db_query($sql);
	
	while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
	   $selCity_ids[] = $row['city_cd']; 
	   $selCity_names[] = $row['city']; 
	}

	$tpl->assign("selCity_ids", $selCity_ids);
	$tpl->assign("selCity_names", $selCity_names);

	//機會學習中心
	if($userProfile['dist_cd']==0 || $userProfile['dist_cd'] == 5){
        $sql = "select doc_cd , doc from docs where city_cd = '".$userProfile['city_cd']."'";
        $res = db_query($sql);
		if($res->numRows()==0){
			$selDoc_ids[] = '-2';
			$selDoc_names[] = '不清楚';
		}else{
			$selDoc_ids[] = '-2';
			$selDoc_names[] = '不清楚';
			while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
				$selDoc_ids[] = $row['doc_cd'];
				$selDoc_names[] = $row['doc'];
			}
		}
		$tpl->assign("selDoc_ids",$selDoc_ids);
		$tpl->assign("selDoc_names",$selDoc_names);
	}else{
	//各級學校
	
		if($userProfile['dist_cd']==1){
			$selSchLevel_ids = array(1,2);
			$selSchLevel_names = array("國小","國中");
		}
		else if($userProfile['dist_cd']==2){
			$selSchLevel_ids = array(3,4);
			$selSchLevel_names = array("高中","高職");
		}
		else if($userProfile['dist_cd']==3 || $userProfile['dist_cd']==4){
			$selSchLevel_ids = array(5);
			$selSchLevel_names = array("大專院校");
		}
		$tpl->assign("selSchLevel_ids", $selSchLevel_ids);
		$tpl->assign("selSchLevel_names", $selSchLevel_names);
		$tpl->assign("selSchLevel", $userProfile['school_type']);



		//學校名稱
		$sql="select school_cd , school from location where city_cd = '{$userProfile['city_cd']}' and type = '{$userProfile['school_type']}'";
		$res = db_query($sql);
		$selSchName_ids[] = '-2';
		$selSchName_names[] = '其他學校';
		while($row = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
			$selSchName_ids[] = $row['school_cd'];
			$selSchName_names[] = $row['school'];
		}
		$tpl->assign("selSchName_ids", $selSchName_ids);
		$tpl->assign("selSchName_names", $selSchName_names); 
		$tpl->assign("showSchool",$schowSchool);
	}
	// assign variable to Smarty template
	$tpl->assign("role_cd",$role_cd);
	$tpl->assign("webroot",$WEBROOT);
	$tpl->assign("userProfile",$userProfile);
	$tpl->assign("userLogin",$userLogin);
    if ($img_upload_status==true){
	    $tpl->assign("top_page_reload",'1');
    }
    else{
	    $tpl->assign("top_page_reload",'0');
    }

    // 上傳圖片加個rand, 預防cache
    $img_rand = rand();
    $tpl->assign('img_rand', $img_rand);

	//show template
	assignTemplate($tpl,"/learner_profile/user_profile.tpl");
	
	//取得角色編號r
	//身分: 0一般民眾,1國民中小學教師,2高中職教師,3大專院校學生,4大專院校教師
	//require config.php
	function getDistCd($personal_ID)
	{
		$sql = "SELECT dist_cd FROM personal_basic WHERE personal_id ='".$personal_ID."';";
		$dist_cd = db_getOne($sql);
		return $dist_cd;
	}
    function validate_identify($id)
    {
        if($_SESSION['role_cd'] == 2){ //加入如果是助教就不用檢查身份證
            return true;}
        else{
         $flag = false;
         $id = strtoupper($id); //將英文字母全部轉成大寫
         $id_len = strlen($id); //取得字元長度

      
         if($id_len <= 0) {
            return false;   
         }
         if ($id_len > 10) {
            return false;
         }
         if ($id_len < 10 && $id_len > 0) {
            return false;  
         }
      
         //檢查 第一個字母是否為英文字
         $id_sub1 = substr($id,0,1); // 從第一個字元開始 取得字串
         $id_sub1 = ord($id_sub1); // 回傳字串的acsii 碼
         if ($id_sub1 > 90 || $id_sub1 < 65) {
            return false; 
         }

         //檢查 身份證字號的 第二個字元 男生或女生
         $id_sub2 = substr($id,1,1);
      
         if($id_sub2 !="1" && $id_sub2 != "2") {
            return false;
         }

         for ($i=1;$i<10;$i++) {
            $id_sub3 = substr($id,$i,1);
            $id_sub3 = ord($id_sub3);
            if ($id_sub3 > 57 || $id_sub3 < 48) {
               $n=$i+1;
               return false;
            }
         }
      
         $num=array("A" => "10","B" => "11","C" => "12","D" => "13","E" => "14",
         "F" => "15","G" => "16","H" => "17","J" => "18","K" => "19","L" => "20",
         "M" => "21","N" => "22","P" => "23","Q" => "24","R" => "25","S" => "26",
         "T" => "27","U" => "28","V" => "29","X" => "30","Y" => "31","W" => "32",
         "Z" => "33","I" => "34","O" => "35");

         $d1 = substr($id,0,1); // 從第一個字元開始 取得字串
         $n1=substr($num[$d1],0,1)+(substr($num[$d1],1,1)*9);
         $n2=0; //初使化
         for ($j=1;$j<9;$j++) {
            $d4=substr($id,$j,1);
            $n2=$n2+$d4*(9-$j);
         }
         $n3=$n1+$n2+substr($id,9,1);
         if(($n3 % 10)!= 0) {
            return false;  
         }
         return true;  
      }
    }
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

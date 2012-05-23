<?php
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");

	require_once("../library/account.php");

	global $COURSE_FILE_PATH;
	//new smarty
	$tpl = new Smarty();
    if("doupload" == $_GET[action]){
		// 確認使用者已上傳檔案
		if ( $_FILES['upload_file']['tmp_name'] != "none" &&
				 $_FILES['upload_file']['tmp_name'] != "" &&
				 $_FILES['upload_file']['size'] > 0 ) 
		{
		// 其「tmp_name」元素代表該檔在伺服器中的暫存路徑與檔名
		//echo "暫存檔名：" . $_FILES['upload_file']['tmp_name'] . "<br>";		
		// 其「name」元素代表該檔案的原始檔名
		//echo "原始檔名：" . $_FILES['upload_file']['name'] . "<br>";	
		// 其「size」元素代表該檔案之大小
		//echo "檔案大小：" . $_FILES['upload_file']['size'] . "<br>";		
		// 其「type」元素表示該檔案之 MIME type
		//echo "檔案型態：" . $_FILES['upload_file']['type'] . "<br>";			  
		  	$UploadPath = $COURSE_FILE_PATH.$_SESSION[begin_course_cd] . "/"; 
            $newName = "upload_student_file_" . $_SESSION[begin_course_cd] ;				
			//刪除舊的檔案
			if(is_file($UploadPath . $newName))
				unlink($UploadPath . $newName);
			copy($_FILES['upload_file']['tmp_name'], $UploadPath . $newName);
			//開檔 讀檔
			if ( !($fp = fopen( $UploadPath . $newName, "r")) ) {
				echo "無法開啟檔案";
			}
			else{
				$buffer = fread($fp, filesize($UploadPath . $newName));
				//先用 # 符號切成很多行
				$line = explode("#", $buffer);
				for($i=0; $i < sizeof($line); $i++){
					//用 , 切開 帳號,姓名
					$student = explode(",", $line[$i]);
					$student['id'] = iconv("big5", "utf-8", trim($student[0]) );
                    $student['name'] = iconv("big5", "utf-8", trim($student[1]) );
                    $student['dist_cd'] = iconv("big5", "utf-8", trim($student[2]) );
					if( "" == $student['id'] ) break;
				    
					//判斷帳號存不存在
					$sql = "SELECT personal_id FROM register_basic WHERE login_id='".$student[id]."'";
                    $isHave = $DB_CONN->getOne($sql);
					if($isHave){ // 帳號存在
						//查詢是否已經修課
						$personal_id = $DB_CONN->getOne($sql);			
						$sql = "SELECT * FROM take_course WHERE begin_course_cd='".$_SESSION[begin_course_cd]."' and personal_id='$personal_id'";
						$res = $DB_CONN->query($sql);
						$isTake = $res->numRows();
						if($isTake){
							$student['reason'] = "此學生已經有修課，如果想改變修課身分，請到查詢學生頁面";
							$exit_user[] = $student;							
						}else{
							//加入 take_course
							$sql = "INSERT INTO take_course ( begin_course_cd, personal_id, allow_course, status_student) VALUES ('".$_SESSION[begin_course_cd]."','$personal_id', '1', '".$_POST[status_student]."')";
							$res = $DB_CONN->query($sql);
							sync_stu_course_data($_SESSION['begin_course_cd'],$personal_id);
							$insert_ok_user[] = $student;					
						}																		
					}
                    else{
                        
                        //這個區域是帳號不存在的時候 會新增帳號
                        //新增帳號時，要能夠更改身份別！

					  	if(!validate_login_id($student['id']))
						{
							$student['reason'] = "帳號中不可含有特殊字元";
							$exit_user[] = $student;
							continue;
                        }
                        $personal_id = create_account($student['id'], $student['id'], 3);
						if($personal_id == -1)
						{
						  	$student['reason'] = "建立學生帳號失敗";
							$exit_user[] = $student;
						  	continue;
						}
						update_account(array("password_hint" => "same as your account", "login_state" => 1, "validated" => 1), $personal_id);
                        
                        if($student['dist_cd'] != NULL)
                            $dist_cd = $student['dist_cd'];
                        elseif($_POST['student_dist'] != -1) // 表示沒選擇身份別
                            $dist_cd = $_POST['student_dist'];
                        else
                            $dist_cd = 0 ;//如果什麼都沒選擇就設定default值為一般民眾
                        
                        //加入 personal_basic
						$sql = "UPDATE `personal_basic` SET identify_id='0', personal_name='$student[name]', personal_style='IE2', dist_cd = '{$dist_cd}' WHERE personal_id=$personal_id;"; 
						$res = $DB_CONN->query($sql);
						//加入 take_course
						$sql = "INSERT INTO take_course ( begin_course_cd, personal_id, allow_course, status_student) VALUES ('".$_SESSION[begin_course_cd]."','$personal_id', '1', '".$_POST[status_student]."')";
						$res = $DB_CONN->query($sql);
						sync_stu_course_data($_SESSION['begin_course_cd'],$personal_id);
						$insert_ok_user[] = $student;
					}
				}
			} 				
		}		
		//輸出頁面
		$tpl->assign("style_display_A", "style='display:;'");
		$tpl->assign("style_display_B", "style='display:none;'");
		$tpl->assign("body_tab", "tabA");
		$tpl->assign("success", $insert_ok_user);
		$tpl->assign("failed", $exit_user);	
	}
	else if( "insertOne" == $_GET[action]){
		$sql = "SELECT personal_id FROM register_basic WHERE login_id='". $_POST[login_id] ."' ";	
		$res = $DB_CONN->query($sql);
		$isHave = $res->numRows();
		
		if($isHave != 0){ // 帳號存在
			//查詢是否已經修課
			$personal_id = $DB_CONN->getOne($sql);			
			$sql = "SELECT * FROM take_course WHERE begin_course_cd='".$_SESSION[begin_course_cd]."' and personal_id='$personal_id'";
			$res = $DB_CONN->query($sql);
			$isTake = $res->numRows();
			if($isTake){
				$tpl->assign("message", $_POST[login_id] . "此學生已經有修課，如果想改變修課身分，請到查詢學生頁面" );
			}else{
				//加入 take_course
				$sql = "INSERT INTO take_course ( begin_course_cd, personal_id, allow_course, status_student) VALUES ('".$_SESSION[begin_course_cd]."','$personal_id', '1', '".$_POST[status_student]."')";
				$res = $DB_CONN->query($sql);					
				sync_stu_course_data($_SESSION['begin_course_cd'],$personal_id);	
				$tpl->assign("message", $_POST[login_id] . "新增成功" );						
			}
									
		}else{ //不存在
		  	if(!validate_login_id(trim($_POST['login_id'])))
			{
				$tpl->assign("message","帳號中不可含有特殊字元");
			}
			else
			{
                $personal_id = create_account(trim($_POST['login_id']), trim($_POST['login_id']), 3);
                //新增帳號時 會設定身份別，如果身份別沒有選擇 將會預設為 一般民眾
                if($_POST['student_dist'] != -1)
                    $dist_cd = $_POST['student_dist'];
                else
                    $dist_cd = 0 ;
                
                db_query("update `personal_basic` set personal_name='$_POST[personal_name]', identify_id='0', personal_style='IE2', dist_cd = '{$dist_cd}' where personal_id=$personal_id;");
				db_query("update `register_basic` set password_hint='same as your account', login_state='1', validated='1' where personal_id=$personal_id;");
				//加入 take_course
                $sql = "INSERT INTO take_course ( begin_course_cd, personal_id, allow_course, status_student) VALUES ('".$_SESSION[begin_course_cd]."','$personal_id', '1', '".$_POST[status_student]."')";
				$res = $DB_CONN->query($sql);				
				sync_stu_course_data($_SESSION['begin_course_cd'],$personal_id);	
				$tpl->assign("message", $_POST[login_id] . "新增成功" );
			}
		}

		$tpl->assign("style_display_A", "style='display:none;'");
		$tpl->assign("style_display_B", "style='display:;'");		
		$tpl->assign("body_tab", "tabB");
	}
	else{
		$tpl->assign("style_display_A", "style='display:;'");
		$tpl->assign("style_display_B", "style='display:none;'");
		$tpl->assign("body_tab", "tabA");	
	}
	assignTemplate($tpl, "/learner_profile/tea_insert_student.tpl");
?>

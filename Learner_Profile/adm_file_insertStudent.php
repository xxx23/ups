<?php
	//匯入時，學生的密碼等於他的帳號
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");

	require_once("../library/account.php");
	checkAdminAcademic();
	//new smarty
	global $PERSONAL_PATH;
	$tpl = new Smarty();
	$insert_ok_user = Array();
	$exit_user = Array();
	if(array_key_exists('action', $_GET) && 'doupload' == $_GET['action']){
		// 確認使用者已上傳檔案
		if( $_FILES['upload_file']['tmp_name'] != "none" &&
			 $_FILES['upload_file']['tmp_name'] != "" &&
			 $_FILES['upload_file']['size'] > 0 )
		{
		  	$path = $PERSONAL_PATH.$_SESSION['personal_id'] . "/";
			$newName = "adm_insert_student_tmp.txt";
			//刪除舊的檔案
			if(is_file($path . $newName))
				unlink($path . $newName);
			copy($_FILES['upload_file']['tmp_name'], $path . $newName);
            
			//開檔 讀檔
			if ( !($fp = fopen( $path . $newName, "r")) ) {
				unlink($path . $newName);
				die("無法開啟檔案");
			}
			else{
				$buffer = fread($fp, filesize($path . $newName));
				//先用 # 符號切成很多行
				$line = explode("#", $buffer);
				//新增帳號
				for($i=0; $i < sizeof($line); $i++){
					//用 , 切開 帳號,姓名
					$student = explode(",", $line[$i]);
					$student['id'] = iconv("big5", "utf-8", trim($student['0']) );
                    $student['name'] = iconv("big5", "utf-8", trim($student['1']) );
                    $student['dist_cd'] = iconv("big5","utf-8", trim($student['2']));
					if( "" == $student['id'] ) break;

					if(!validate_login_id($student['id']))
					{
						$student['reason'] = "帳號不可以含有特殊字元";
						$exit_user[] = $student;
					}
					else
                    {

                        //student[id] 是學生的帳號 並不是personal_id
						//判斷帳號存不存在
						$sql = "SELECT count(*) FROM register_basic WHERE login_id='".$student['id']."'";
						$isHave = $DB_CONN->getOne($sql);
						if($isHave){ // 帳號存在
							$student['reason'] = "此帳號已經存在";
							$exit_user[] = $student;
						}
                        else{
                            // modify by Samuel @ 2010/03/31 
                            // 修改 匯入學生時 增加身份別的欄位
                            // 帳號不存在的時候
							$pid = create_account($student['id'], $student['id'], 3);
							if($pid == -1)
								exit(0);
							update_account(array("password_hint" => "same as your account", "login_state" => 1, "validated" => 1), $pid);
                            //加入 personal_basic
                            if($student['dist_cd'] != NULL) // 表示在file裡面即有資料，如果有資料就以file裡面的資料為主
                            {
                                if($student['dist_cd'] < 0 || $student['dist_cd'] > 7) // 範圍不同
                                {
                                    $student['reason'] = "身份別編號錯誤";
                                    $exit_user[] = $student;
                                    continue;
                                }
                                $dist_cd = $student['dist_cd'];
                            }
                            elseif($_POST['student_dist'] != -1) // 如果沒有資料就以下拉式選單的資料為主
                                $dist_cd = $_POST['student_dist'];
                            else // 最後如果都沒有的話 就設定為一般民眾
                                $dist_cd = 0 ;
                            
							$sql = "UPDATE `personal_basic` SET identify_id='0', personal_name='$student[name]', personal_style='IE2' , dist_cd = '{$dist_cd}' WHERE personal_id=$pid;";
							$res = $DB_CONN->query($sql);
							$insert_ok_user[] = $student;
						}
					}
				}
				fclose($fp);
				//一完成匯入後，立刻刪除檔案，避免http-error
				unlink($path . $newName);
			}
		}
	}


	// 顯示 匯入的結果
	$tpl->assign("success", $insert_ok_user);
	$tpl->assign("failed", $exit_user);
	//輸出頁面
    assignTemplate($tpl, "/learner_profile/adm_file_insertStudent.tpl");

    function my_print($var)
    {
            echo "<pre>";
            print_r($var);
            echo "</pre>";
    }
?>

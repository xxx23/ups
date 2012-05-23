<?php
/***
FILE:
DATE:
AUTHOR: zqq
**/

	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
    require_once($RELEATED_PATH . "library/ftp_func.php");
    require_once($RELEATED_PATH . "library/passwd.php");

    //aeil
	require_once($RELEATED_PATH . "library/Pager.class.php");
	require_once($RELEATED_PATH . 'library/filter.php') ;
	require_once($HOME_PATH . 'library/smarty_init.php');
    //end

	//update_status ( "確認開課中" );
	checkAdmin();	
	//new smarty
	//$tpl = new Smarty();

	if(array_key_exists('action', $_GET) && $_GET['action'] == 'search'){
		switch($_POST['search']){
			case 'all':
				$sql = "SELECT * FROM register_basic r, personal_basic p, lrtrole_ o
						WHERE r.personal_id=p.personal_id and r.role_cd=o.role_cd and r.role_cd != 0";
				break;
			case 'role':
				$sql = "SELECT * FROM register_basic r, personal_basic p, lrtrole_ o
						WHERE r.personal_id=p.personal_id and r.role_cd=o.role_cd and o.role_cd='".$_POST['role']."' and r.role_cd != 0";
				break;
			case 'login_id':
				$sql = "SELECT * FROM register_basic r, personal_basic p, lrtrole_ o
						WHERE r.personal_id=p.personal_id and r.role_cd=o.role_cd and r.login_id like '%".$_POST['login_id']."%' and r.role_cd != 0";
				break;
			case 'personal_name':
				$sql = "SELECT * FROM register_basic r, personal_basic p, lrtrole_ o
						WHERE r.personal_id=p.personal_id and r.role_cd=o.role_cd and p.personal_name like '%".$_POST['personal_name']."%' and r.role_cd != 0";
				break;
		}

        //add by aeil
        $page = optional_param("page",1,PARAM_INT);
		$total = db_getOne(str_ireplace("*","COUNT(*)",$sql));
		$meta = array("page"=>$page,"per_page"=>10,"data_cnt"=>$total);
		$pager = new Pager($meta);
		$pagerOpt = $pager->getSmartyHtmlOptions();
        //print_r($pagerOpt);
		$tpl->assign("page_ids",$pagerOpt['page_ids']);
		$tpl->assign("page_names",$pagerOpt['page_names']);
		$tpl->assign("page_sel",$pagerOpt['page_sel']);
		$tpl->assign("page_cnt",$pager->getPageCnt());
		$tpl->assign("previous_page",$pager->previousPage());
		$tpl->assign("next_page",$pager->nextPage());
		$tpl->assign("search",$_POST['search']);
        $sql .= $pager->getSqlLimit();
        //end
        //
		$res = db_query($sql);
		$tpl->assign("show", 1);
		while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
			$tpl->append("data_list", $row);
		}
	}
	else if(array_key_exists('action', $_GET) && $_GET['action'] == 'modify'){
		$tpl->assign("update", 1);
		$data = $_POST;
		for($i=0; $i < sizeof($data['list']); $i++){
			$sql = "UPDATE register_basic SET role_cd='".$data['data_role'][ $data['list'][$i] ]."' WHERE personal_id='".$data['list'][$i]."'";
			$res = db_query($sql);

			$sql = "SELECT role_name FROM lrtrole_ WHERE role_cd='". $data['data_role'][ $data['list'][$i] ]."'";
			$role_name = db_getOne($sql);
			$update['login_id'] = $data['login_id'][$data['list'][$i]];
			$update['personal_name'] = $data['personal_name'][$data['list'][$i]];
			if($data['role_cd'][$data['list'][$i]] == 1 && $data['data_role'][ $data['list'][$i]] != 1){
				//刪除FTP帳號
				delete_ftp_account( $data['login_id'][$data['list'][$i]] );
				$update['message'] = "由" . $data['role'][$data['list'][$i]] . "更新為" . $role_name . "並且刪除FTP帳號";
			}
			else if( $data['role_cd'][$data['list'][$i]] != 1 && $data['data_role'][ $data['list'][$i]] == 1){
			  	//新增
				$sql = "SELECT pass FROM register_basic WHERE login_id='". $data['login_id'][$data['list'][$i]] ."'";
                $pass = db_getOne($sql);
                $pass = passwd_decrypt($pass); //要將密碼解回來 建立ftp user 密碼才會正確

                //==============================抓id 沒目錄就建目錄 by carlcarl============================
                $login_id = $data['login_id'][$data['list'][$i]];
                $sql = "select personal_id from register_basic where role_cd = '1' and login_id = '$login_id'";
                $personal_id = db_getOne($sql);
                if(PEAR::isError($personal_id))  die($personal_id->userinfo);
                if(empty($personal_id)){
                    echo "<script>alert(\"此帳號: '$login_id'不存在!\");</script>";
                    return 0;
                }

                $home_dir = $DATA_FILE_PATH . $personal_id ."/";
                if(!file_exists($home_dir)){
                    $oldUmask = umask(0);
                    if(mkdir($home_dir, 0775) == FALSE)
                        echo "<script>alert(\"此路徑: '$home_dir'新增失敗!\");</script>";
                    else 
                        echo "<script>alert(\"此路徑: '$home_dir'新增完畢!\");</script>";
                    umask($oldUmask);
                }
                //=======================================================================================

				if(new_ftp_account( $data['login_id'][$data['list'][$i]], $pass, '' ) == 1) //1代表成功
                    $update['message'] = "由" . $data['role'][$data['list'][$i]] . "更新為" . $role_name . "並且新增FTP帳號";
                else $update['message'] = '新增失敗';
			}
			else{
				$update['message'] = "由" . $data['role'][$data['list'][$i]] . "更新為" . $role_name;
			}

			$tpl->append("update_list", $update);
		}
	}

	//搜尋
	$sql = "SELECT * FROM lrtrole_";
	$res = db_query($sql);
	while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
		$role['ids'][] = $row['role_cd'];
		$role['names'][] = $row['role_name'];
	}
	//搜尋結果

	$tpl->assign("role_ids", $role['ids']);
    //aeil
	//$tpl->assign("role_id", $role['ids'][0]);
	$tpl->assign("role_id", $_POST['role']);
    //end
	$tpl->assign("role_names",$role['names']);

	//輸出頁面
	assignTemplate($tpl, "/learner_profile/user_role.tpl");
?>

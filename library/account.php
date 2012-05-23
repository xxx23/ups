<?php
    /** 
     *
     * @file library/account.php
     *
     * @author lunsrot
	 * @date 2007/11/29
     */

	//require_once("../config.php");
    require_once("passwd.php");

    /**
     * @brief 建立帳號
     * 
     * 新增一個帳號，會更新personal_basic和register_basic，僅處理personal_id, login_id, password, role_cd
     * 傳入的password為明碼，需加密後再存入資料庫，回傳personal_id
     * 此外還會建立使用者的資料夾
     *
     * @param id 帳號(login_id)
     * @param pass 密碼
     * @param cd 角色代碼 參考資料庫中的lrtrole_, 0是管理者, 1是開課教師, 2是助教, 3是研習學員, 4是訪客, 以此類推
     *
     * @return 傳回建完帳號所產生的personal_id
     */
    function create_account($id, $pass, $cd)
    {
		global $PERSONAL_PATH;	
		$pass = passwd_encrypt($pass);
		if(check_login_id($id) != 0)
			return -1;
		db_query("insert into `register_basic` (login_id, pass, role_cd) values ('$id', '$pass', $cd);");
		$pid = db_getOne("select personal_id from `register_basic` where login_id='$id';");
		db_query("insert into `personal_basic` (personal_id) values ('$pid');");
        //createPath($PERSONAL_PATH . $pid);
        $path = getPersonalPath($pid);
        createPath($path);
		return $pid;
	}

    /** 
     * @brief 檢查該帳號是否已存在
     * 
     * 檢查該帳號是否已存在，若已存在回傳1
     *
     * @param id 帳號(login_id)
     *
     * @retval 1 如果有這個帳號的話 
     * @retval 0 沒有這個帳號的話
     */
    function check_login_id($id)
    {
		$tmp = db_getOne("select count(*) from `register_basic` where login_id='$id';");
		return ($tmp >= 1)? 1 : 0;
	}

    /**
     * @brief 取得角色代碼
     *
     * 取得角色代碼
     *
     * @param pid personal_id 個人編號
     *
     * @return 角色代碼
     *
     */
    function get_user_role($pid) 
    {
        return db_getOne("select role_cd from register_basic where personal_id=$pid");
    }

    /**
     * @brief 刪除帳號，暫時用
     *
     * 根據personal_id來刪帳號
     *
     * @param pid personal_id 個人編號
     *
     * @return NULL
     *
     */
	function remove_account($pid)
    {
        global $PERSONAL_PATH;
        if(!is_numeric($pid))
        {
            die('Personal id is not digit');
        }
        $role = get_user_role($pid); 
		db_query("delete from `register_basic` where personal_id=$pid;");
        db_query("delete from `personal_basic` where personal_id=$pid;");
        db_query("delete from `take_course` where personal_id='{$pid}'");
        
        //$tmp = $PERSONAL_PATH . $pid;
        $tmp = getPersonalPath($pid);
        if(!is_null($tmp))
        {
            system_log("rm -rf $tmp");
            exec("rm -rf $tmp");

            //處理額外要刪除的東西
            switch($role) 
            {
                // Teacher 角色
            case 1: delete_teacher($pid); return ;
            default: return ;
            }
        }
        else
        {
            die('Get personal path error!');
        }
            
    }
    
    /**
     * @brief 刪除帳號
     *
     * 根據帳號來刪除帳號
     *
     * @param login_id 帳號
     *
     * @return NULL
     *
     */
    function remove_account_by_login_id($login_id)
    {
        $pid = db_getOne("select personal_id from register_basic where login_id like'$login_id'");
        if(is_numeric($pid))
        {
            remove_account($pid) ; 
        }
        else
            die('Can not find the account\'s personal id (Maybe you already deleted the account...)');
    }

    /**
     * @brief 建立教師資料夾
     *
     * 根據personal_id來建立幾個老師要用的資料夾
     * 首先先建立老師的資料夾, 接著在底下建立子資料夾, 分別為export_data, test_bank, textbook
     *
     * @param teacher_cd 老師的personal_id(個人編號)
     *
     * @return NULL
     *
     */
	function createTeacherDIR($teacher_cd)
    {
		global $DATA_FILE_PATH;
	  	$teacher_dir = $DATA_FILE_PATH . $teacher_cd . "/";
	  	$export_data_dir= $DATA_FILE_PATH . $teacher_cd . "/export_data/";
	  	$test_bank_dir  = $DATA_FILE_PATH . $teacher_cd . "/test_bank/";
		$textbook_dir   = $DATA_FILE_PATH . $teacher_cd . "/textbook/";
		createPath($teacher_dir);
		createPath($export_data_dir);
		createPath($test_bank_dir);
		createPath($textbook_dir);
	}	

    /**
     * @brief 建立教務管理者資料夾 目前不需要
     *
     * 建立教務管理者資料夾
     * 首先先建立教務管理者的資料夾, 接著在底下建立子資料夾, 分別為export_data, test_bank, textbook
     *
     * @param academic_admin_cd 教務管理者的個人編號
     *
     * @return NULL
     *
     */
    function createAcademic_adminDIR($academic_admin_cd)
    {
		global $DATA_FILE_PATH;
	  	$academic_admin_dir = $DATA_FILE_PATH . $academic_admin_cd . "/";
	  	$export_data_dir= $DATA_FILE_PATH . $academic_admin_cd . "/export_data/";
	  	$test_bank_dir  = $DATA_FILE_PATH . $academic_admin_cd . "/test_bank/";
		$textbook_dir   = $DATA_FILE_PATH . $academic_admin_cd . "/textbook/";
		createPath($academic_admin_dir);
		createPath($export_data_dir);
		createPath($test_bank_dir);
		createPath($textbook_dir);
	}

    /**
     * @brief 用來更新帳號註冊資料
     *
     * 根據personal_id和一個array參數來更新帳號的資訊
     *
     * @param parameter 為一個array, 需為a['role_cd']=3這樣的對應方式,不可用數字作array的index
     * @param pid personal_id(個人編號)
     *
     * @return NULL
     *
     */
	function update_account($parameter, $pid)
    {
		$sql = "UPDATE `register_basic` SET ";
		foreach($parameter as $k => $v)
			$sql .= "$k='$v', ";
		$sql = substr($sql, 0, strlen($sql) - strlen(", "));
		$sql .= " WHERE personal_id=$pid;";
		db_query($sql);
	}

    /**
     * @brief 驗證帳號格式
     *
     * 驗證帳號格式, 只允許英文字母和數字
     *
     * @param id 帳號(login_id)
     *
     * @retval true  格式對的話 
     * @retval false 格式錯的話
     *
     */
	function validate_login_id($id)
	{
	  	if(preg_match("/[^a-zA-Z0-9]+/",$id) == 0)
			return true; 
		else
		  	return false;
	}

	/** @author lunsrot
     * 
     * @date 2008/04/27
     * 
     * @brief 檢查該使用者的style是否合法，若不是則任意指定一個
     *
     * 有點看不懂作者當初怎麼寫的, 不建議使用
     * 用資料夾來看使用的style有點怪怪的...
     *
     * @param pid personal_id(個人編號)
     * @param type 我看不懂他想幹麼, 好像沒有用?
     * 
     * @return 回傳網頁的style
     *
     */
    function get_style($pid, $type)
    {
		global $HOME_PATH, $IMAGE_PATH;
		$ori_type = db_getOne("SELECT $type FROM `personal_basic` WHERE personal_id=$pid;");
		if(!$dh = @opendir($HOME_PATH . $IMAGE_PATH . "themes/"))	exit;
		$tmp = "";
        while($obj = readdir($dh))
        {
		  	if($obj == "." || $obj == "..")	continue;
			if(is_dir($HOME_PATH . $IMAGE_PATH . "themes/" . $obj)) continue;
			$code = explode(".", $obj);
			if(empty($code[0]))	continue;
			$tmp = $code[0];
		}
		return $tmp;
    }

    /**
     * @brief 刪除老師的資料夾
     * 
     * 刪除老師的資料夾, 被remove_account所使用
     *
     * @param pid personal_id(個人編號)
     *
     * @return NULL
     *
     */
    function delete_teacher($pid) 
    {
        global $DATA_FILE_PATH ; 
        if(!is_numeric($pid))
        {
            die('Personal id is not digit!');
        }
        $teacher_data = $DATA_FILE_PATH . $pid . "/";
        system_log("rm -rf $teacher_data");
        exec ("rm -rf $teacher_data") ;         
    }
?>

<?
	require_once("../config.php");	
	require_once("../session.php");
    require_once("../library/filter.php");
	require_once("../library/account.php");

    $guest = optional_param('guest', 0, PARAM_INT);
    $begin_course_cd = required_param("begin_course_cd",PARAM_INT);    

	global $USE_MYSQL, $USE_MONGODB, $db;

    //使用訪客進入相關成果課程
    if($guest == 1)
    {
        //檢查課程是否允許訪客進入
        $sql = "SELECT guest_allowed FROM begin_course WHERE begin_course_cd = $begin_course_cd";
        $allowed = db_getOne($sql);
        if($allowed != 1)
        {
            die('本課程不開放訪客進入');
        }
        $login_id = 'guest'; 

        $isExist = db_getOne("select count(*) from `register_basic` where login_id='$login_id' and login_state='1';");

        if($isExist != 1)
            loginFail(0);
        $sql = "SELECT personal_id, role_cd FROM register_basic WHERE login_id = '$login_id' AND validated='1'";
        $res = db_query($sql);
        if( ($res->numRows()) == 0)//帳號不核准使用
        {
            //導向回首頁
            loginFail(2);
        }
        else{

            $res->fetchInto($row, DB_FETCHMODE_ASSOC);
            $personal_id = $row['personal_id'];
            $role_cd = $row['role_cd'];
        }	

        //註冊session
        session_start();
        $_SESSION['personal_id'] = $personal_id;
        $_SESSION['role_cd'] = $role_cd;
        $_SESSION['template_path'] = $HOME_PATH . "themes/";
        $_SESSION['template'] = "IE2";

        //echo $personal_id . ' ' . $role_cd;
        setMenu($personal_id, $role_cd);

        //查出IP
        $ip = getenv ( "REMOTE_ADDR" );
        if ( $ip == "" )
            $ip = $HTTP_X_FORWARDED_FOR;
        if ( $ip == "" )
            $ip = $REMOTE_ADDR;		
        //-------------------------------------------------------
        /** 登入後會將這個user 記在 online_number **/
		if($USE_MYSQL)
		{
			if( isset($_SESSION['online_cd ']) )
			{ //同一個來源
				$sql = "UPDATE online_number SET status='重新登入中', idle='".date('U')."' WHERE online_cd='".$_SESSION['online_cd ']."'";
				$res = db_query($sql);
			}
			else
			{ 
				$sql = "INSERT INTO online_number (personal_id, host, time, idle, status) VALUES ('".$personal_id."','".$ip."','".date("U")."','".date("U")."','登入系統中')";
				$res = db_query($sql);
				$sql = "SELECT online_cd FROM online_number WHERE personal_id='".$personal_id."' and host='".$ip."'";
				$online_cd = db_getOne($sql);
				$_SESSION['online_cd'] = $online_cd;						
			}
		}
		else if($USE_MONGODB)
		{
			$online_number = $db->online_number;
			if( isset($_SESSION['online_cd ']) )
			{ //同一個來源
				$online_number->update(array('_id' => new MongoId($_SESSION['online_cd'])), array('$set' => array('status' => '重新登入中', 'idle' => new MongoDate())));
			}
			else
			{ 
				$mid = new MongoId();
				$online_number->insert(array('_id' => $mid, 'pid' => $personal_id, 'h' => $ip, 't' => new MongoDate(), 'idle' => new MongoDate(), 'status' => '登入系統'));
				$_SESSION['online_cd'] = $mid;
			}
		}
        //--------------------------------------------------------
        $_SESSION['personal_ip'] = $ip;	


        //學習追蹤-登入系統
        LEARNING_TRACKING_start(1, 1, -1, $_SESSION['personal_id']);

    }
    if(!isset($_SESSION['personal_id']))
    {
        if(!isset($_SESSION['lang']) ||  $_SESSION['lang'] == 'zh_tw')
            die("<h1>權限錯誤</h1>");
        else
            die("<h1>Permission error</h1>");

    }
	//註冊begin_course_cd到SESSION
	$_SESSION['begin_course_cd'] = $begin_course_cd;
	$result = db_query("select course_cd , attribute from `begin_course` where begin_course_cd=$begin_course_cd;");
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	$_SESSION['course_cd'] = $row['course_cd'];
	$_SESSION['attribute'] = $row['attribute'];
	$_SESSION['template'] = setCourseStyle();	
	//學習追蹤-登入課程
	LEARNING_TRACKING_start(1, 2, $_SESSION['begin_course_cd'], $_SESSION['personal_id']);

	if($_SESSION['attribute'] == 1){
  	  header("Location: ../Course/course.php");
	}
	else if($_SESSION['attrbute'] == 0 && $_SESSION['role_cd'] != 1)
	{
	  header("Location: ../Course/s_course.php");
	}
	else if($_SESSION['attribute'] == 0 && $_SESSION['role_cd'] == 1)
	{
  	  header("Location: ../Course/course.php");
	}

	function setCourseStyle(){
		$pid = $_SESSION['personal_id'];

		$style = db_getOne("select course_style from `personal_basic` where personal_id=$pid;");
		if(empty($style)){
			$style = get_style($pid, "course_style");
			db_query("update `personal_basic` set course_style='$style' where personal_id=$pid;");
		}
    //不管如何只有使用IE2
        $style = 'IE2';
		return $style;
    }
    function setMenu($pid, $role)
    {
		global $DB_CONN;
		$_SESSION['menu'] = array();
        $sql = "SELECT menu_link from `lrtmenu_` a, `menu_role` b 
            WHERE a.menu_id = b.menu_id
            AND a.menu_level > 0
            AND a.menu_link LIKE '%php%'
            AND b.role_cd = $role
            AND b.is_used = 'y';";

		$result = db_query($sql);
		while($row = $result->fetchRow())
			array_push($_SESSION['menu'], $row[0]);
	}

    function loginFail($type)
    {
		$remind = array(
			"登入失敗，您的帳號不存在，請重新確認",
			"登入失敗，您的帳號密碼不符合，請重新確認",
			"登入失敗，您的帳號尚未被核准使用，請洽管理員");

		echo "<script type=\"text/javascript\">alert('$remind[$type]')</script>";
		if($type == 0)
			echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\"/>";
		else
			echo "<script type=\"text/javascript\">history.back()</script>";
		exit(0);
	}

?>

<?
//  以時間 作為判斷此使用者是否在線上的依據
//  每分鐘此php會reload一次, 此時會將超過一分半未回應的使用者消掉
//  檔案格式為   $user_id, date("U") ,$course_id
//  會使用到session中的$time.

	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
    require_once($RELEATED_PATH . "library/date.php");
	//開啟session
	session_start();	
	//new smarty
	$template = $_SESSION['template_path'] . 'IE2';
	$tpl_path = "../themes/" . 'IE2';				
	$tpl = new Smarty();
    //add by aeil at 100803 for add search
    //print_r(getonline());
    if($_GET['action'] == "removefriend")
    {
        removefriend();
        header("Location: {$_SERVER['PHP_SELF']}");
    }
    if($_GET['action'] == "addfriend")
    {
      //print_r($_POST);
        addfriend();
        header("Location: {$_SERVER['PHP_SELF']}");
    }
    if($_GET['action'] == "getlist")
    {
        getlist();
        exit;
    }
    //end

	if(isset($_SESSION['begin_course_cd']))
		$begin_course_cd = $_SESSION['begin_course_cd'];
	//先查詢是否在 onlin_number
	$sql = "SELECT * FROM online_number WHERE online_cd='".$_SESSION[online_cd]."'";
	//echo $sql;	
	$res = $DB_CONN->query($sql);
	if(PEAR::isError($res))	die($res->getMessage());
	$isHave = $res->numRows();

	if($isHave){
		$sql = "UPDATE online_number SET begin_course_cd='".$_SESSION[begin_course_cd]."', status='觀看公告' WHERE online_cd='".$_SESSION[online_cd]."'";
		$res = $DB_CONN->query($sql);
		if(PEAR::isError($res))	die($res->getMessage());	
	}
	else{

		$sql = "INSERT INTO online_number (personal_id, host, time, idle, status, begin_course_cd) 
				VALUES ('".$_SESSION[personal_id]."','".$_SESSION[personal_ip]."','".date('U')."','".date('U')."','觀看公告','".$_SESSION[begin_course_cd]."')";
        //add by aeil
        if(!is_null($_SESSION['personal_id']) || 
          !empty($_SESSION['personal_id']))
          $res = $DB_CONN->query($sql);

		if(PEAR::isError($res))	die($res->getMessage());
		$sql = "SELECT online_cd FROM online_number WHERE personal_id='".$_SESSION[personal_id]."' and host='".$_SESSION[personal_ip]."'";
		$online_cd = $DB_CONN->getOne($sql);
		$_SESSION[online_cd] = 	$online_cd;			
	}	
	//刪除 idle過久的
	$refreshmin = 10; //
	$sql = "DELETE from online_number WHERE (".date("U")." - time) > ($refreshmin * 60)";
	$res = $DB_CONN->query($sql);
	if(PEAR::isError($res))	die($res->getMessage());	

	//查出是否有訊息進入
	$sql = "SELECT * FROM transaction WHERE receive='".$_SESSION[personal_id]."'";
	$res = $DB_CONN->query($sql);
	$have = $res->numRows();
    //for add dom body to append by facebox
    echo "<br />";
    //for validate invitation
    $sql = "select * from transaction_friend where"
      ." friend =" . $_SESSION[personal_id] 
      ." and validated =0 "
      ;
	$res = $DB_CONN->query($sql);
		if(PEAR::isError($res))	die($res->getMessage());
	$have_validated = $res->numRows();

    
    $sql = "select * from transaction_friend where"
      ." owner =" . $_SESSION['personal_id'] 
      ." and validated =2 "
      ;
	$res1 = $DB_CONN->query($sql);
		if(PEAR::isError($res1))	die($res1->getMessage());
    
	while($alert= $res1->fetchRow(DB_FETCHMODE_ASSOC) ){	
      $sql = "SELECT personal_name FROM "
        ." personal_basic WHERE "
        ." personal_id='".$alert['friend']."'";
      $validated_name = $DB_CONN->getOne($sql);
      $tpl->append('alertf',$validated_name); 
      $sql = "DELETE from transaction_friend WHERE"
        . " owner = " . $_SESSION['personal_id']
        . " and friend = " . $alert['friend']
        . " and validated = 2 "
        ;
      //echo $sql;
      //print_r($alert);
      $res2 = $DB_CONN->query($sql);		
		if(PEAR::isError($res2))	die($res2->getMessage());
    }
    
    $tpl->assign("HAVE_validated",$have_validated!=0?"":"//");
    $tpl->assign("HAVE_validated_ldelim",$have_validated==0?"":"/*");
    $tpl->assign("HAVE_validated_rdelim",$have_validated==0?"":"*/");
    $validated_name = Array();
    $num = 0;
    while($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
    {
      $validated_name[$num]['id'] = $row['owner'];
      $sql = "SELECT personal_name FROM personal_basic WHERE personal_id='".$row['owner']."'";
      $validated_name[$num++]['name'] = $DB_CONN->getOne($sql);
    }
    $tpl->assign("validated_name",$validated_name);
    //end
	if($have){	//有訊息
		$tpl->assign("HAVE", "");
	}
	else{ //無訊息
		$tpl->assign("HAVE", "//");
	}

//------------- display	---------------------
	//查出系統上的人數 與 姓名 狀態
	//查出這堂課的人數 與 姓名 狀態
	$system_num = 0;
	$course_num = 0;			
	$friend_num = 0;			
	$sql = "SELECT * FROM online_number";
	$res = $DB_CONN->query($sql);
	if(PEAR::isError($res))	die($res->getMessage());	
	while($system = $res->fetchRow(DB_FETCHMODE_ASSOC) ){	
		$system_num++;
		if($system[personal_id] != $_SESSION[personal_id]){
            //add by aeil at 100803
              $sql = "SELECT friend from transaction_friend where "
                . "(owner = " . $_SESSION[personal_id]
                . " or friend = " . $_SESSION[personal_id] . ")"
                . " and validated = 1 "
                ;
              $res1 = $DB_CONN->query($sql);
              if(PEAR::isError($res))	die($res->getMessage());	
              while($f= $res1->fetchRow(DB_FETCHMODE_ASSOC) )	
                  $friends[] = $f['friend'];
              if(in_array($system[personal_id],$friends))
              {
                $friend_num++;
				$friend= $system;			
                $friend['index'] = $friend_num; 
                $friend['personal_id'] =  $system[personal_id] ;
                $friend['personal_name'] = (getPersonalNameByPersonalId( $DB_CONN, $system[personal_id] ));
                $friend['personal_name_encode'] = urlencode(getPersonalNameByPersonalId( $DB_CONN, $system[personal_id] ));
                $friend['personal_login_id'] = getPersonalLoginIdByPersonalId( $DB_CONN, $system[personal_id] );
                $tpl->append('friend_people', $friend);
              }
            //
							
			$system['index'] = $system_num; 
			$system['personal_name'] = (getPersonalNameByPersonalId( $DB_CONN, $system[personal_id] ));
			$system['personal_name_encode'] = urlencode(getPersonalNameByPersonalId( $DB_CONN, $system[personal_id] ));
			$system['personal_login_id'] = getPersonalLoginIdByPersonalId( $DB_CONN, $system[personal_id] );
			$tpl->append('system_people', $system);
			
			if($system['begin_course_cd'] == $_SESSION['begin_course_cd']){
			
				$course_num++;			
				$course = $system;			
				$course['index'] = $course_num ;
				$course['personal_name'] = (getPersonalNameByPersonalId( $DB_CONN, $system[personal_id] ));
				$course['personal_name_encode'] = urlencode(getPersonalNameByPersonalId( $DB_CONN, $system[personal_id] ));
				$course['personal_login_id'] = getPersonalLoginIdByPersonalId( $DB_CONN, $system[personal_id] );
				$tpl->append('course_people', $course);
			}
		
		}
		else{ //自己
			$system_num--;
			//if($system['begin_course_cd'] == $_SESSION['begin_course_cd'])
			//	$course_num--;
			
			$sql = "SELECT personal_name, nickname FROM personal_basic WHERE personal_id='".$_SESSION[personal_id]."'";
			$res_tmp = $DB_CONN->query($sql);
			if(PEAR::isError($res_tmp))	die($res_tmp->getMessage());	
			$self = $res_tmp->fetchRow(DB_FETCHMODE_ASSOC);
			$tpl->assign("personal_name",($self['personal_name'] ));
			$tpl->assign("personal_name_encode",urlencode($self['personal_name'] ));
			$tpl->assign("nickname",$self['nickname'] );
			$tpl->assign("status",$system['status'] );
		}		
	}
    //--update add by q110185
        update_course_tracking();
    //--update end
    
    //輸出頁面
	//系統人數
	$tpl->assign("system_num", $system_num);
	//課程人數
	//($course_num==0)?$course_num=0:$course_num-1;//扣除自己
	$tpl->assign("course_num", $course_num ); 
	$tpl->assign("friend_num", $friend_num); 

  	$tpl->assign("tpl_path", $tpl_path);
	$tpl->display($template . "/online/online.tpl");	
				
	
//----------------function area ------------------

function getPersonalNameByPersonalId( $DB, $personal_id ){
	$sql = "SELECT personal_name FROM personal_basic WHERE personal_id='".$personal_id."'";
	return $DB->getOne($sql);
} 

function getPersonalLoginIdByPersonalId( $DB, $personal_id ){
	$sql = "SELECT login_id FROM register_basic WHERE personal_id='".$personal_id."'";
	return $DB->getOne($sql);
} 

function update_course_tracking($action='update')
{
    global $DB_CONN;
   
    $begin_course_cd = $_SESSION['begin_course_cd'];
    $personal_id = $_SESSION['personal_id'];
    //echo "update bc:{$begin_course_cd} pi:{$personal_id}";
    if($action =='update')
    {
        //echo "update";
        if(!empty($personal_id) && !empty($begin_course_cd))
        ;//    LEARNING_TRACKING_update_event_statistics($DB_CONN, 1, 2, $begin_course_cd, $personal_id);
        //echo "update complite";
    }
    if($action== 'stop')
    {
        if(!empty($personal_id) && !empty($begin_course_cd)){
            LEARNING_TRACKING_update_event_statistics($DB_CONN, 1, 2, $begin_course_cd, $personal_id);
            LEARNING_TRACKING_stop(1, 2, $begin_course_cd, $personal_id);
        }
    }
}
//add by aeil at 100803
function removefriend()
{
    global $DB_CONN;
    $sql = "DELETE from transaction_friend WHERE"
          . " owner = " . $_SESSION['personal_id']
          . " and friend = " . $_GET['id'];
    $res = $DB_CONN->query($sql);		
    //並且把它的朋友也刪除，先提醒她:
    
    $sql = "UPDATE transaction_friend set"
          . " validated = 2 " 
          . " where friend = " . $_SESSION['personal_id']
          . " and owner = " . $_GET['id'];
    $res = $DB_CONN->query($sql);		
          
}
function addfriend()
{
    global $DB_CONN;
    if(isset($_POST['test3'])) 
    {
      $personal_id = explode(",",$_POST['test3']);
      foreach($personal_id as $key => $value) {
          //echo (int)$value."<br />";
          //你也加個int轉換吧...by carlcarl
        if(is_numeric((int)$value))
        {
            $sql = "SELECT friend from transaction_friend where "
              . "owner = " . $_SESSION['personal_id']
              . " and friend = " . $value;
            $friend = $DB_CONN->getOne($sql);
            if(empty($friend))
            {
              $sql = "INSERT INTO transaction_friend 
                (owner, friend,  time) 
                VALUES 
                ('". $_SESSION['personal_id'] ."','".
                (int)$value."','".
                get_now_time_str() ."')";
              $res = $DB_CONN->query($sql);		
            }
        }
      }
    }

}
function getonline()
{
    global $DB_CONN;
    $online = Array();
	$system_num = 0;
	$course_num = 0;			
	$sql = "SELECT * FROM online_number";
	$res = $DB_CONN->query($sql);
	if(PEAR::isError($res))	die($res->getMessage());	
	while($system = $res->fetchRow(DB_FETCHMODE_ASSOC) ){	
		$system_num++;
		if($system[personal_id] != $_SESSION[personal_id]){
							
			$system['index'] = $system_num; 
			$system['personal_name'] = (getPersonalNameByPersonalId( $DB_CONN, $system[personal_id] ));
			$system['personal_name_encode'] = urlencode(getPersonalNameByPersonalId( $DB_CONN, $system[personal_id] ));
			$system['personal_login_id'] = getPersonalLoginIdByPersonalId( $DB_CONN, $system[personal_id] );
			//$tpl->append('system_people', $system);
            $online['system'][] = $system;
			
			if($system['begin_course_cd'] == $_SESSION['begin_course_cd']){
			
				$course_num++;			
				$course = $system;			
				$course['index'] = $course_num ;
				$course['personal_name'] = (getPersonalNameByPersonalId( $DB_CONN, $system[personal_id] ));
				$course['personal_name_encode'] = urlencode(getPersonalNameByPersonalId( $DB_CONN, $system[personal_id] ));
				$course['personal_login_id'] = getPersonalLoginIdByPersonalId( $DB_CONN, $system[personal_id] );
				//$tpl->append('course_people', $course);
                $online['course'][] = $course;
			}
		
		}
		else{ //自己
			$system_num--;
			//if($system['begin_course_cd'] == $_SESSION['begin_course_cd'])
			//	$course_num--;
			
			$sql = "SELECT personal_name, nickname FROM personal_basic WHERE personal_id='".$_SESSION[personal_id]."'";
			$res_tmp = $DB_CONN->query($sql);
			if(PEAR::isError($res_tmp))	die($res_tmp->getMessage());	
			$self = $res_tmp->fetchRow(DB_FETCHMODE_ASSOC);
			//$tpl->assign("personal_name",($self['personal_name'] ));
			//$tpl->assign("personal_name_encode",urlencode($self['personal_name'] ));
			//$tpl->assign("nickname",$self['nickname'] );
			//$tpl->assign("status",$system['status'] );
            $self['status'] = $system['status'];
            $online['self'][] = $self;
		}		
	}
    return $online;

}
function getlist()
{
    $response = array();
    
    $getonline= getonline();
    foreach($getonline['system'] as $k=>$v)
    {
        $names[] = $v['personal_name_encode'];
        $personal_id[] = $v['personal_id'];
    }

    // make sure they're sorted alphabetically, for binary search tests
    sort($names);

    foreach ($names as $i => $name)
    {
        $filename = str_replace(' ', '', strtolower($name));
        //$response[] = array($personal_id[$i], $name, null, '<img src="images/'. $filename . (file_exists('images/' . $filename . '.jpg') ? '.jpg' : '.png') .'" /> ' . $name);
        $response[] = array($personal_id[$i], $name, null,  $name);
    }

    header('Content-type: application/json');
    echo json_encode($response);
}

?>

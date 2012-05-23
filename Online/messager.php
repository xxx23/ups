<?
//  以時間 作為判斷此使用者是否在線上的依據
//  每分鐘此php會reload一次, 此時會將超過一分半未回應的使用者消掉
//  檔案格式為   $user_id, date("U") ,$course_id
//  會使用到session中的$time.

    ini_set('display_errors',1);
    error_reporting(E_ALL);
    $RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
    require_once($RELEATED_PATH . "library/date.php");
    require_once($HOME_PATH . 'library/filter.php') ;
	//update_states("即時訊息");
	//開啟session
	//ssession_start();	
	//new smarty
        
	$template = $_SESSION['template_path'] . $_SESSION['template'];
	$tpl_path = "../themes/" . $_SESSION['template'];				
	$tpl = new Smarty();

	if($_GET['action'] == "send"){
		$tpl->assign("HAVE","//");
		$tpl->assign("CLOSE","//");	
        if(isset($_GET['multi']))
        {
          $receiver_pid = $receiver_name = "";
          foreach($_GET['multi'] as $key => $value) {
            list($id,$name) = explode("|",$value);
            $receiver_pid .= $id . "|";
            $receiver_name .= '發送給: '. $name . "<br / >";
            $_GET['multi'][$key] = $id;
          }
          $tpl->assign("multi", $_GET['multi']);
          $tpl->assign("receiver_pid",$receiver_pid); 
          $tpl->assign("receiver_name",$receiver_name);
        }
        else
        {
          $tpl->assign("receiver_pid", required_param('receiver',PARAM_INT));
          $tpl->assign("receiver_name", '發送給: '. required_param('receiver_name',PARAM_CLEAN));
        }
		
	}
	else if($_GET['action'] == "doSend"){
		$tpl->assign("HAVE","//");
		$tpl->assign("CLOSE","");

        //add by aeil
        if(isset($_POST['multi'])) 
        {
          foreach($_POST['multi'] as $key => $value) {
            //echo "{$value}<br />";
            $sql = "INSERT INTO transaction 
				(send, receive, message, time) 
				VALUES 
                ('". $_SESSION['personal_id'] ."','".
                //required_param("multi['".$key."']",PARAM_INT)."','".
                $value."','".
                urlencode(required_param('message',PARAM_CLEAN)) ."','". get_now_time_str() ."')";
            $res = $DB_CONN->query($sql);		
          }
        }
        else
        {
          //end
		$sql = "INSERT INTO transaction 
				(send, receive, message, time) 
				VALUES 
				('". $_SESSION['personal_id'] ."','".required_param('receiver_pid',PARAM_INT) ."','". required_param('message',PARAM_CLEAN) ."','". get_now_time_str() ."')";
        $res = $DB_CONN->query($sql);
        }        
	}
    else if($_GET['action'] == "validated_id")
    {
      if($_GET['isconfirm'] == 1)
      {
            $sql = "SELECT friend from transaction_friend where "
              . "owner = " . $_SESSION['personal_id']
              . " and friend = " . $_GET['id'];
            $friend = $DB_CONN->getOne($sql);
            if(empty($friend))
            {
              $sql = "INSERT INTO transaction_friend 
                (owner, friend,  time, validated) 
                VALUES 
                ('". $_SESSION['personal_id'] ."','".
                (int)$_GET['id']."','".
                get_now_time_str() 
                ."'," . 1 . ")";
              $res = $DB_CONN->query($sql);		
            }
          $sql = "update transaction_friend "
            . " set validated = 1"
            . " where "
            . " friend = " . $_SESSION['personal_id']
            . " and owner= " . $_GET['id']
            ;
      }
      else
      {
          $sql = "DELETE from transaction_friend WHERE"
            . " friend = " . $_SESSION['personal_id']
            . " and owner= " . $_GET['id'];
          //$res = $DB_CONN->query($sql);

          //$sql = "update transaction_friend "
          //  . " set validated =2"
          //  . " where "
          //  . " owner= " . $_SESSION['personal_id']
          //  . " and friend= " . $_GET['id']
          //  ;
          //echo $sql;

      }
		$res = $DB_CONN->query($sql);
        exit;
    }
    else if($_GET['action'] == "validated")
    {
      $sql = "SELECT * from transaction_friend where "
        . "owner = " . $_SESSION['personal_id']
        . " and validated = 0"
        ;
		$res = $DB_CONN->query($sql);
        $validated_name = Array();
        $num = 0;
        while($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
        {
          $validated_name[$num]['id'] = $row['friend'];
          $sql = "SELECT personal_name FROM personal_basic WHERE personal_id='".$row['friend']."'";
          $validated_name[$num++]['name'] = $DB_CONN->getOne($sql);
        }
		$tpl->assign("validated_name",$validated_name);
//print_r($validated_name);
/*foreach($validated_name as $v)
{
echo 
'您確定要加'.$v['name'].'為好友嗎？
<a href="#" id="id1_'.$v['id'].'">是</a>
<a href="#" id="id0_'.$v['id'].'">否</a>';
}*/
    }
	else if($_GET['action'] == "receive"){
		$tpl->assign("HAVE","");
		$tpl->assign("CLOSE","//");
		//查出訊息
		$sql = "SELECT * FROM transaction WHERE receive='".$_SESSION['personal_id']."'";
		$res = $DB_CONN->query($sql);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		//查出login_id
		//modify by rja, 應該是要查出 personal name 才對
		$sql = "SELECT personal_name FROM personal_basic WHERE personal_id='".$row['send']."'";
		//echo $sql;
		$sender_login_name = $DB_CONN->getOne($sql);
		
		$tpl->assign("receiver_pid",$row['send']);
		$tpl->assign("receiver_name","</b>從<b>". $sender_login_name ."</b>送訊息給你: <br/>" .urldecode ($row['message']) . "<br/>發送時間(".$row['time'].")");
					 
		//刪除訊息
		$sql = "DELETE FROM transaction WHERE online_trans='". $row['online_trans']."'";
		$res = $DB_CONN->query($sql);		 			
	}
	else{
		$tpl->assign("HAVE","//");
		$tpl->assign("CLOSE","//");	
	}
  	$tpl->assign("action", $_GET['action']);
  	$tpl->assign("tpl_path", $tpl_path);
	$tpl->display($template . "/online/messager.tpl");
	
//----------------function area ------------------

?>

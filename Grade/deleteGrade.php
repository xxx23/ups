<?
/*
DATE:   2007/05/15
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$absoluteURL = $HOMEURL . "Grade/";

	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼

	$id = $_GET['id'];									//取得number_id
	if( isset($id) == false)	$id = $_POST['id'];
	//從Table course_percentage取得成績類型
	$sql = "SELECT
				A.percentage_type, 
				A.percentage_num 
			FROM 
				course_percentage A 
			WHERE 
				A.begin_course_cd = $begin_course_cd AND 
				A.number_id = $id 
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();	
	if($resultNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		
		$percentage_type = $row[percentage_type];
		$percentage_num = $row[percentage_num];	
		
		
		switch($percentage_type)
		{
		case 1:	//線上測驗
		
				//從Table test_course_setup中刪除線上測驗資料
				$sql = "DELETE 
						FROM 
							test_course_setup 
						WHERE 
							begin_course_cd=$begin_course_cd AND 
							test_no=$percentage_num
						";
				$sth = $DB_CONN->prepare($sql);	
				$res = $DB_CONN->execute($sth);
				if (PEAR::isError($res))	die($res->getMessage());
				
				//從Table test_course中刪除線上測驗資料
				$sql = "DELETE 
						FROM 
							test_course 
						WHERE 
							begin_course_cd=$begin_course_cd AND 
							test_no=$percentage_num
						";
				$sth = $DB_CONN->prepare($sql);	
				$res = $DB_CONN->execute($sth);
				if (PEAR::isError($res))	die($res->getMessage());
				
				break;
				
		case 2:	//線上作業
				
				//從Table homework中刪除線上作業資料
				$sql = "DELETE 
						FROM 
							homework 
						WHERE 
							begin_course_cd=$begin_course_cd AND 
							homework_no=$percentage_num
						";
				$sth = $DB_CONN->prepare($sql);	
				$res = $DB_CONN->execute($sth);
				if (PEAR::isError($res))	die($res->getMessage());
				
				//從Table handin_homework中刪除線上作業資料
				$sql = "DELETE 
						FROM 
							handin_homework 
						WHERE 
							begin_course_cd=$begin_course_cd AND 
							homework_no=$percentage_num
						";
				$sth = $DB_CONN->prepare($sql);	
				$res = $DB_CONN->execute($sth);
				if (PEAR::isError($res))	die($res->getMessage());
				
				break;
				
		case 3:	//點名
				
				//從Table roll_book中刪除點名資料
				$sql = "DELETE 
						FROM 
							roll_book 
						WHERE 
							begin_course_cd=$begin_course_cd AND 
							roll_id=$percentage_num
						";
				$sth = $DB_CONN->prepare($sql);	
				$res = $DB_CONN->execute($sth);
				if (PEAR::isError($res))	die($res->getMessage());
				
				break;
				
	case 4:	//一般測驗

		  $where = -1;
		  $sql = "select * from course_percentage where begin_course_cd = $begin_course_cd AND  percentage_type = 4 ORDER BY number_id ASC ";
                  $result = $DB_CONN->getAll($sql, null, DB_FETCHMODE_ASSOC) ;
		  for($i = 0 ; $i < count($result) ; $i++){
		    if($result[$i]['number_id'] ==  $id){
		      $where = $i;
		      break;	
		    }
		  }
	  	  //echo "==$where==\n";		                                         
		  $sql = "select * from test_course_setup where begin_course_cd = $begin_course_cd AND  test_type = 4  ORDER BY test_no ASC";	  
                  $result = $DB_CONN->getAll($sql, null, DB_FETCHMODE_ASSOC) ; 
 		  $need_to_del = $result[$where]['test_no'];
		  
		  $sql = "delete from test_course_setup where test_no  = $need_to_del";
		  $r = $DB_CONN->query($sql);
		  if(PEAR::isError($r))   die($_SERVER['PHP_SELF'] . ': '.$r->getDebugInfo());

		  /*	

				$sql = "DELETE 
						FROM 
							test_course_setup 
						WHERE 
							begin_course_cd=$begin_course_cd AND 
							test_no=    AND
							test_type=4
						";
				$sth = $DB_CONN->prepare($sql);	
				$res = $DB_CONN->execute($sth);
				if (PEAR::isError($res))	die($res->getMessage());
		   */
				break;
				
	        case 5:	//一般作業
		
		  $where = -1;
		  $sql = "select * from course_percentage where begin_course_cd = $begin_course_cd AND  percentage_type = 5 ORDER BY number_id ASC ";
                  $result = $DB_CONN->getAll($sql, null, DB_FETCHMODE_ASSOC) ;
		  for($i = 0 ; $i < count($result) ; $i++){
		    if($result[$i]['number_id'] ==  $id){
		      $where = $i;
		      break;	
		    }
		  }
	  	  //echo "==$where==\n";		                                         
		  $sql = "select * from test_course_setup where begin_course_cd = $begin_course_cd AND test_type = 5  ORDER BY test_no ASC";	  
                  $result = $DB_CONN->getAll($sql, null, DB_FETCHMODE_ASSOC) ; 
 		  $need_to_del = $result[$where]['test_no'];


		  $sql = "delete from test_course_setup where test_no  = $need_to_del";
		  $r = $DB_CONN->query($sql);
		  if(PEAR::isError($r))   die($_SERVER['PHP_SELF'] . ': '.$r->getDebugInfo());

		/*	
				$sql = "DELETE 
						FROM 
							test_course_setup 
						WHERE 
							begin_course_cd=$begin_course_cd AND 
							test_no=$id AND
							test_type=5
						";
				$sth = $DB_CONN->prepare($sql);	
				$res = $DB_CONN->execute($sth);
				if (PEAR::isError($res))	die($res->getMessage());
		*/
				break;
				
		case 9:	//其它

		  $where = -1;
		  $sql = "select * from course_percentage where begin_course_cd = $begin_course_cd AND  percentage_type = 9 ORDER BY number_id ASC ";
                  $result = $DB_CONN->getAll($sql, null, DB_FETCHMODE_ASSOC) ;
		  for($i = 0 ; $i < count($result) ; $i++){
		    if($result[$i]['number_id'] ==  $id){
		      $where = $i;
		      break;	
		    }
		  }
	  	  //echo "==$where==\n";		                                         
		  $sql = "select * from test_course_setup where begin_course_cd = $begin_course_cd AND test_type = 9  ORDER BY test_no ASC";	  
                  $result = $DB_CONN->getAll($sql, null, DB_FETCHMODE_ASSOC) ; 
 		  $need_to_del = $result[$where]['test_no'];


		  $sql = "delete from test_course_setup where test_no  = $need_to_del";
		  $r = $DB_CONN->query($sql);
		  if(PEAR::isError($r))   die($_SERVER['PHP_SELF'] . ': '.$r->getDebugInfo());
		/*
				$sql = "DELETE 
						FROM 
							test_course_setup 
						WHERE 
							begin_course_cd=$begin_course_cd AND 
							test_no=$id AND
							test_type=9
						";
				$sth = $DB_CONN->prepare($sql);	
				$res = $DB_CONN->execute($sth);
				if (PEAR::isError($res))	die($res->getMessage());
		 */		
				break;
				
		default:break;		
		}
	}
		

	//從Table course_concent_grade中刪除學員成績資料
	$sql = "DELETE 
			FROM 
				course_concent_grade 
			WHERE 
				begin_course_cd=$begin_course_cd AND 
				number_id=$id
			";
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	//從Table course_percentage中刪除成績資料
	$sql = "DELETE 
			FROM 
				course_percentage 
			WHERE 
				begin_course_cd=$begin_course_cd AND 
				number_id=$id
			";
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());

	header("location: showGradeList.php");
?>

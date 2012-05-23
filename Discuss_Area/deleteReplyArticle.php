<?php
        $RELEATED_PATH = "../";

        require_once($RELEATED_PATH . "config.php");
        require_once($RELEATED_PATH . "session.php");
        $absoluteURL = $HOMEURL . "Discuss_Area/";

	session_start();
        $personal_id = $_SESSION['personal_id'];                       	       //取得個人編號
        $role_cd = $_SESSION['role_cd'];                                       //取得角色
        $begin_course_cd = $_SESSION['begin_course_cd'];      		       //取得課程代碼
        $discuss_cd = $_SESSION['discuss_cd'];                         	       //取得討論區編號
	$discuss_content_cd = $_SESSION['discuss_content_cd'];
	
	/*
 	$discuss_content_cd = $_GET['discuss_content_cd']; 		       //取得文章編號
        if( isset($discuss_content_cd) == false)        $discuss_content_cd = $_POST['discuss_content_cd'];
	 */
	//$discuss_content_cd = 1 ; 
	
	
	$behavior = $_GET['behavior'];                                         //取得行為
	if( isset($behavior) == false)  
	  $behavior = $_POST['behavior'];
	
	//想要刪除的文章回覆編號
	$reply_content_cd = $_GET['reply_content_cd'];
	if( isset($reply_content_cd) == false)  
	  $reply_content_cd = $_POST['reply_content_cd'];

	$FILE_PATH = $COURSE_FILE_PATH . $begin_course_cd . "/Discuss_Area/";
		
	// 去資料庫下 找該討論串
	$sql = "SELECT * FROM discuss_content 
	  WHERE begin_course_cd=$begin_course_cd 
	  AND discuss_cd=$discuss_cd 
	  AND discuss_content_cd=$discuss_content_cd"; 
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))        die($res->getMessage());
	
	$resultNum = $res->numRows();

	//如果有找到資料的話
	if($resultNum > 0)
	{
	  	while($res->fetchInto($row, DB_FETCHMODE_ASSOC))
		{
			// 把reply_content_parentcd指回root
          	        if($row['reply_conten_parentcd']==$reply_content_cd)
			{
			 //	$reply_content_cd_modify = $row['reply_content_cd'];
				set_parent($DB_CONN,$begin_course_cd,$discuss_cd,$discuss_content_cd,$row['reply_content_cd']);	
			//	$sql1 = "UPDATE discuss_content SET reply_content_parentcd=1"
			}
		    	
		}
	}
	//刪除 discuss_content 裡面的資料
	$sql = "DELETE FROM discuss_content 
	  WHERE begin_course_cd=$begin_course_cd 
	  AND discuss_cd=$discuss_cd 
	  AND discuss_content_cd=$discuss_content_cd 
	  AND reply_content_cd=$reply_content_cd";

	$sth = $DB_CONN->prepare($sql);
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))        die($res->getMessage());
	
	//刪除 discuss_content_viewed裡面的資料
	$sql = "DELETE FROM discuss_content_viewed
	  WHERE begin_course_cd = $begin_course_cd
	  AND discuss_cd = $discuss_cd
	  AND discuss_content_cd = $discuss_content_cd
	  AND reply_content_cd = $reply_content_cd";
	
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))        die($res->getMessage());

	header("Location: showArticle.php?behavior=$behavior&discuss_cd=$discuss_cd&discuss_content_cd=$discuss_content_cd");

	/*===================================================================================================*/

	function set_parent($DB_CONN,$begin_course_cd,$discuss_cd,$discuss_content_cd,$reply_content_cd_tmp){
	  
	  // 更新被刪除的回覆的下一筆資料 parentcd改成root = 1;
	  $root_parent = 1 ;

	  $sql = "UPDATE discuss_content SET reply_conten_parentcd='$root_parent' 
	    WHERE begin_course_cd=$begin_course_cd 
	    AND discuss_cd=$discuss_cd 
	    AND discuss_content_cd=$discuss_content_cd 
	    AND reply_content_cd=$reply_content_cd_tmp";

	  $sth = $DB_CONN->prepare($sql);
	  $res = $DB_CONN->execute($sth);
	  if (PEAR::isError($res))        die($res->getMessage());
	  
	}

?>

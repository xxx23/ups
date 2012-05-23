<?php
	require_once('../config.php');
	require_once('../session.php');
	require_once('../library/common.php');

	//new smarty
	//$tpl = new Smarty();
	require_once($HOME_PATH . 'library/smarty_init.php');

   /* 
	$list_tea_And_TA = "select p.personal_id, p.personal_name,p.photo, p.email, p.tel, r.login_id, r.role_cd from personal_basic p, register_basic r where r.personal_id in (select teacher_cd from teach_begin_course where begin_course_cd={$_SESSION['begin_course_cd']}) and p.personal_id=r.personal_id";
	$result_TA = db_query($list_tea_And_TA);
	while($row = $result_TA->fetchRow(DB_FETCHMODE_ASSOC)) {
	  if(trim($row['photo']) != "")
	    	$row['photo'] = $WEBROOT.ltrim($row['photo'],'/');
      if($row['role_cd'] == 1 ) // teacher
	      $tpl->append('tea', $row);
	  if($row['role_cd'] == 2 ) // TA 
	      $tpl->append('TA', $row);
	  
	  unset($row);
	}					                         
    */

    $list_tea = "select p.personal_id, p.personal_name,p.photo, p.email, p.tel, r.login_id, r.role_cd from personal_basic p, register_basic r, teach_begin_course t where t.begin_course_cd={$_SESSION['begin_course_cd']} and r.personal_id=t.teacher_cd and p.personal_id=r.personal_id and r.role_cd=1 order by t.course_master desc";
	$result_tea = db_query($list_tea);
    while($row = $result_tea->fetchRow(DB_FETCHMODE_ASSOC)) 
    {
        //if(trim($row['photo']) != "")
        //    $row['photo'] = $WEBROOT.ltrim($row['photo'],'/');
        if($row['photo'] != NULL)
        {
            $row['photo'] = '../Personal_File/' . getPersonalLevel($row['personal_id']) . '/' . $row['personal_id'] . '/' . $row['photo'];
        }
	    $tpl->append('tea', $row);	  
	    unset($row);
	}					                         
    
    $list_ta = "select p.personal_id, p.personal_name,p.photo, p.email, p.tel, r.login_id, r.role_cd from personal_basic p, register_basic r where r.personal_id in (select teacher_cd from teach_begin_course where begin_course_cd={$_SESSION['begin_course_cd']}) and p.personal_id=r.personal_id and r.role_cd=2";
	$result_TA = db_query($list_ta);
    while($row = $result_TA->fetchRow(DB_FETCHMODE_ASSOC)) 
    {
        if($row['photo'] != NULL)
        {
            $row['photo'] = '../Personal_File/' . getPersonalLevel($row['personal_id']) . '/' . $row['personal_id'] . '/' . $row['photo'];
        }
	    $tpl->append('TA', $row);	  
	    unset($row);
	}	


	//get all student 
	$list_student = "SELECT * FROM register_basic r, personal_basic p, take_course t WHERE t.begin_course_cd='".$_SESSION['begin_course_cd']."' and  t.personal_id=r.personal_id  and r.personal_id = p.personal_id and r.role_cd='3'";
	$result_stu = db_query($list_student);
	while( $row = $result_stu->fetchRow(DB_FETCHMODE_ASSOC) ){
		$stu[] = $row;
		unset($row);
	}	
	$tpl->assign("stu", $stu);
	
	//輸出頁面
	assignTemplate($tpl, "/course/stu_query_student.tpl");
		
?>

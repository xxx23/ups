<?php
//新增組員
function insert_member($Homework_no, $Group_no, $id)
{
  global $DB_CONN;
  $Begin_course_cd = $_SESSION['begin_course_cd'];
  //print "id:".$id;
  //錯誤偵測
  $sql = "SELECT * FROM register_basic r, personal_basic p, take_course t 
    WHERE t.begin_course_cd = '$Begin_course_cd' 
    and t.personal_id = r.personal_id 
    and r.personal_id = p.personal_id 
    and r.role_cd = '3'";
  $res = $DB_CONN->query($sql);
  if(PEAR::isError($res))	die($res->getMessage());

  $flag = false;
  while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
    $p_id = $row['personal_id'];
    $sql = "select login_id from register_basic where personal_id = '$p_id';";
    $login_id = $DB_CONN->getOne($sql);
    //print $sql." ";
    if(PEAR::isError($login_id))	die($login_id->userinfo);
    if($id == $login_id){
      $flag = true;
      break;
    }
  }
  if($flag == false){
    echo "<script>alert(\"錯誤!本課程不存在此學生\")</script>";
    return 0;
  }

  //print $Group_no.":".$id;
  $sql = "insert into groups_member (begin_course_cd, homework_no, group_no, student_id, assign_work)
    values ('$Begin_course_cd', '$Homework_no', '$Group_no', '$p_id','')";
  $res = $DB_CONN->query($sql);
  if(PEAR::isError($res))	die($res->userinfo);

  //新增學生進入小組討論區
  DiscussArea_addUser($DB_CONN, $Begin_course_cd, $Homework_no, $Group_no, $p_id);
  return 1;
}

//刪除某個學生
function delete_student($Homework_no, $Student_array, $Group_no){
  global $DB_CONN;
  $Begin_course_cd = $_SESSION['begin_course_cd'];

  if(empty($Student_array))
    return 0;

  $sql = "select * from project_data where begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no'";
  $res = $DB_CONN->query($sql);
  if(PEAR::isError($res))	die($res->userinfo);
  $row = $res->fetchRow(DB_FETCHMODE_ASSOC);	
  $Group_member = $row['group_member'];	//分組人數

  //當刪除人數等於組員數, 刪除組別，並刪除整個討論區
  //print_r($Student_array);
  if($Group_member == sizeof($Student_array)){
    //print "qq:".sizeof($Student_array);
    delete_group($Homework_no, $Group_no);
    DiscussArea_deleteDiscussArea($DB_CONN, $Begin_course_cd, $Homework_no, $Group_no);
  }

  for($i = 0 ; $i < sizeof($Student_array) ; $i++){
    $s_id = $Student_array[$i];
    //刪除討論區組員
    DiscussArea_deleteUser($DB_CONN, $Begin_course_cd, $Homework_no, $Group_no, $s_id);
    $sql = "delete from groups_member where student_id = '$s_id'";
    $res = $DB_CONN->query($sql);
    if(PEAR::isError($res))	die($res->userinfo);
    //print $Student_array[$i];
  }

  //檢查 如果組員為0則 刪除本組
  $sql = "select * from groups_member where homework_no = '$Homework_no' and group_no = '$Group_no'";
  $res = $DB_CONN->query($sql);
  if(PEAR::isError($res))	die($res->userinfo);
  //print $sql;
  if($res->numRows() == 0){	
    delete_group($Homework_no, $Group_no);
    DiscussArea_deleteDiscussArea($DB_CONN, $Begin_course_cd, $Homework_no, $Group_no);
  }
}

//刪除這個組別
function delete_group($Homework_no, $Group_no){
  global $DB_CONN;
  //info_groups
  $sql = "delete from info_groups where homework_no = '$Homework_no' and group_no = '$Group_no'";
  //print $sql;
  $res = $DB_CONN->query($sql);
  if(PEAR::isError($res))	die($res->userinfo);

  //groups_member
  $sql = "delete from groups_member where homework_no = '$Homework_no' and group_no = '$Group_no'";
  $res = $DB_CONN->query($sql);
  if(PEAR::isError($res))	die($res->userinfo);

  //刪除組別成績
  $sql = "delete from take_groups_score where homework_no = '$Homework_no' and take_group_no = '$Group_no'";
  $res = $DB_CONN->query($sql);
  if(PEAR::isError($res))	die($res->userinfo);
}

//顯示分組資訊
function show_group_infos($Homework_no, $Begin_course_cd){
  global $DB_CONN, $smtpl;

  //查詢組別
  $sql = "select * from info_groups where 
    begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no' order by group_no";
  $res = $DB_CONN->query($sql);
  if(PEAR::isError($res))	die($res->getMessage());
  //print $sql;
  while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
    $Group_no = $row['group_no'];

    //取得本組學生名單
    $sql_stu = "SELECT * FROM personal_basic pb, groups_member gm, register_basic rb
      WHERE gm.begin_course_cd = '$Begin_course_cd' 
      and gm.group_no = '$Group_no'
      and pb.personal_id = rb.personal_id
      and gm.homework_no = '$Homework_no'
      and pb.personal_id = gm.student_id;
    ";
    //print $sql_stu;
    $result = $DB_CONN->query($sql_stu);
    if(PEAR::isError($result))	die($result->userinfo);
    $row['stu_array'] = array();
    while( $stu_row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
      array_push($row['stu_array'], $stu_row);
    }

    //取出專案題目內容
    $Project_no = $row['project_no'];
    $project_sql = "select * from projectwork where project_no = '$Project_no' and homework_no = '$Homework_no'";
    $Project_result = $DB_CONN->query($project_sql);
    if(PEAR::isError($Project_result))	die($Project_result->userinfo);

    $Project_row = $Project_result->fetchRow(DB_FETCHMODE_ASSOC);

    if($Project_row['self_appointed'] == 0) 		//確定本題目為老師給的還是學生自訂的
      $row['self_appointed'] = "";
    else
      $row['self_appointed'] = "(此題為學生自訂題目)";

    $row['project_content'] = $Project_row['project_content'];

    $smtpl->append("group_list",$row);
  }
}


//自動分組功能
function auto_grouping($Homework_no, $Group_member, $Group_number){
  global $DB_CONN, $smtpl;
  $Begin_course_cd = $_SESSION['begin_course_cd'];
  $sql = "SELECT * FROM register_basic r, personal_basic p, take_course t 
    WHERE t.begin_course_cd = '$Begin_course_cd' 
    and t.personal_id = r.personal_id 
    and r.personal_id = p.personal_id 
    and r.role_cd = '3'";
  $res = $DB_CONN->query($sql);
  if(PEAR::isError($res))	die($res->getMessage());
  //print $sql;
  $i = 0;
  while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC) ){
    //旁聽生不加入分組
    if($row['allow_course'] )
      $row['allow'] = "核准";
    else
      continue;
    //$row['allow'] = "不核准";

    if($row['status_student'] == 0)
      //$row['status'] = "旁聽生";
      continue;
    else
      $row['status'] = "正修生";

    $id = $row['personal_id'];
    //	print $row['personal_name'];
    $sql = "select student_id from groups_member 
      where begin_course_cd = '$Begin_course_cd' 
      and homework_no = '$Homework_no' and student_id = '$id';";
    $stu_id = $DB_CONN->getOne($sql);
    if(PEAR::isError($res))	die($res->userinfo);

    if(!empty($stu_id));
    else{
      $hash_table[$i] = $id;
      $i++;
    }
  }
  if(empty($hash_table))
    return 0;

  //將array弄亂
  shuffle($hash_table);
  //print_r($hash_table);
  //print_r($hash_table);
  $Total_number = sizeof($hash_table);	//總人數
  $index = 0;
  $j = 0;
  for($i = 0, $count = 1 ; $i < $Total_number ; $i++, $count++){
    //print $i;
    $tmp[$j] = $hash_table[$i];
    $j++;
    if($count % $Group_member == 0){
      $insert_array[$index] = $tmp;
      $index++;
      $j = 0;
      $tmp = "";
    }
  }
  //把餘下的人分成一組
  $insert_array[$index] = $tmp;
  //print_r($tmp);
  //print_r($insert_array);
  insert2DB($insert_array, $Group_member, $Group_number, $Homework_no, $Project_no, $Group_name);

  return 1;
}

//將學生資訊插入DB, insert_array是壆生id陣列
function insert2DB($insert_array, $Group_member, $Group_number, $Homework_no, $Project_no, $Group_name){	
  global $DB_CONN;
  $Begin_course_cd = $_SESSION['begin_course_cd'];

  //print sizeof($insert_array);

  for($i = 0 ; $i < sizeof($insert_array) ; $i++){
    if(empty($insert_array[$i]))
      continue;
    //取得目前本作業info_groups最大的group_no, +1
    $sql = "select max(group_no+1) max_group_no from info_groups 
      where begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no'";
    $res = $DB_CONN->query($sql);
    if(PEAR::isError($res))	die($res->userinfo);
    $row = $res->fetchRow(DB_FETCHMODE_ASSOC);

    if(empty($row['max_group_no']))
      $Max_group_no = 1;
    else
      $Max_group_no = $row['max_group_no'];

    //insert info_groups
    $sql = "insert into info_groups 
      (begin_course_cd, homework_no, group_no, group_name, project_no, if_grouptype, result_work, upload, if_true)
      values
      ('$Begin_course_cd', '$Homework_no', '$Max_group_no', '$Group_name', '$Project_no', '', '', 'false', 'true')";
    $res = $DB_CONN->query($sql);

    //新增組別討論區
    DiscussArea_newDiscussArea($DB_CONN, $Begin_course_cd, $Homework_no, $Max_group_no);

    if(PEAR::isError($res))	die($res->userinfo);
    for($j = 0 ; $j < $Group_member ; $j++){
      if(empty($insert_array[$i][$j]))
	continue;
      $Personal_id = $insert_array[$i][$j];

      //新增學生入組別討論區
      DiscussArea_addUser($DB_CONN, $Begin_course_cd, $Homework_no, $Max_group_no, $Personal_id);

      //insert into groups_member
      $sql = "insert into groups_member (begin_course_cd, homework_no, group_no, student_id, assign_work)
	values('$Begin_course_cd', '$Homework_no', '$Max_group_no', '$Personal_id','');";
      //print $sql;
      $res = $DB_CONN->query($sql);
      if(PEAR::isError($res))	die($res->userinfo);
    }
  }
}

//刪除所有報名與組別資料
function delete_all_group($Homework_no){
  global $DB_CONN;
  $Begin_course_cd = $_SESSION['begin_course_cd'];

  //delete info_groups data
  $sql = "delete from info_groups where begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no'";
  $res = $DB_CONN->query($sql);
  if(PEAR::isError($res))	die($res->userinfo);

  //delete groups_member data
  $sql = "delete from groups_member where begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no'";
  $res = $DB_CONN->query($sql);
  if(PEAR::isError($res))	die($res->userinfo);

  //刪除組別自訂題目
  $sql = "delete from projectwork where begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no'
    and groupno_topic != '0'";
  $res = $DB_CONN->query($sql);
  if(PEAR::isError($res)) die($res->userinfo);

  //刪除組別成績	
  $sql = "delete from take_groups_score where begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no'";
  $res = $DB_CONN->query($sql);
  if(PEAR::isError($res)) die($res->userinfo);

  $sql = "delete from take_student_score where begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no'";
  $res = $DB_CONN->query($sql);
  if(PEAR::isError($res)) die($res->userinfo);

  //刪除學生分組討論區
  DiscussArea_deleteUser($DB_CONN, $Begin_course_cd, $Homework_no, "-1", "-1");	
  DiscussArea_deleteDiscussArea($DB_CONN, $Begin_course_cd, $Homework_no, "-1");
}

//新增學生時的錯誤偵測，檢查學生id是否存在，及是否已分組，若不存在則傳回錯誤
function check_if_exists($stu_array, $Begin_course_cd, $Homework_no)
{
  global $DB_CONN;

  for($a = 0 ; $a < count($stu_array) ; $a++){

    $sql = "SELECT * FROM register_basic r, personal_basic p, take_course t 
      WHERE t.begin_course_cd = '$Begin_course_cd' 
      and t.personal_id = r.personal_id 
      and r.personal_id = p.personal_id 
      and r.role_cd = '3' and t.personal_id=$stu_array[$a]";

    $res = $DB_CONN->query($sql);
    if(PEAR::isError($res))	die($res->getMessage());

    $i = 0;

    $row = $res->fetchRow(DB_FETCHMODE_ASSOC);

    //旁聽生不加入分組
    if($row['allow_course'] == "1")
      $row['allow'] = "核准";
    else{
      echo "<script>alert(\"錯誤，未核准的學生不能加入分組\");</script>";
      return 0;
      //continue;
    }
    //$row['allow'] = "不核准";

    if($row['status_student'] == 0){
      //$row['status'] = "旁聽生";
      //continue;
      echo "<script>alert(\"錯誤，旁聽生不能加入分組\");</script>";
      return 0;
    }
    else
      $row['status'] = "正修生";

    $id = $row['personal_id'];
    
    
   return true;
  }//end for

}

//將personal_id的array轉成login_id的array
function to_login_id_array($p_array)
{
  global $DB_CONN;
  $l_array = array();
  for($i = 0 ; $i < sizeof($p_array) ; $i++){
    if(empty($p_array[$i]))
      continue;
    $sql = "select login_id from register_basic where personal_id = '$p_array[$i]'";
    $login_id = $DB_CONN->getOne($sql);
    if(PEAR::isError($login_id))	die($login_id->userinfo);
    array_push($l_array,$login_id);
  }
  return $l_array;
}

//將login_id的array轉成personal_id的array
function to_personal_id_array($l_array)
{
  global $DB_CONN;
  $p_array = array();
  for($i = 0 ; $i < sizeof($l_array) ; $i++){
    if(empty($l_array[$i]))
      continue;
    $sql = "select personal_id from register_basic where login_id = '$l_array[$i]'";
    $personal_id = $DB_CONN->getOne($sql);
    if(PEAR::isError($personal_id))	die($personal_id->userinfo);
    array_push($p_array,$personal_id);
  }
  return $p_array;
}
?>

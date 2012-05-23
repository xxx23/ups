<?php 
require_once("../config.php");
require_once('session.php');
require_once('lib.php') ; 

check_access("verify_course_list"); 


//僅列出部內哪些組該審之課程 , 透過開課單位no去看
$list_category_sql = genGroupingSqlWhere( $category4grouping[ $_SESSION['category'] ] ) ; 

//列出審核已通過
//看begin_coursestate , char(1), 'p': 正在審核中 , 'n': 審核不通過, '1': 審核通過, '0': 還沒審核

$sql = "SELECT 
		bc.begin_course_cd, bc.begin_course_name, u.unit_name, bc.inner_course_cd, p.personal_name ,bc.begin_coursestate, bc.attribute 
	FROM 
		begin_course bc, lrtunit_basic_ u, teach_begin_course tbc, personal_basic p
	WHERE
		bc.begin_course_cd=tbc.begin_course_cd 
	AND	tbc.teacher_cd = p.personal_id
	AND	bc.begin_unit_cd=u.unit_cd
	AND bc.begin_coursestate ='p' 
	AND $list_category_sql
	ORDER BY bc.begin_course_cd ASC ";
	



$result = db_query($sql);

$tpl = new Smarty();

while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){

	//列出該課程之教材名稱
	//教師送審課程之前介面會指定一個教材才可送審，因此正常情況到這裡一定會有教材
	$sql_get_course_content = " SELECT B.content_name 
		FROM class_content_current A, course_content  B
		WHERE begin_course_cd=" . $row['begin_course_cd'] . ' AND A.content_cd=B.content_cd';
	
	$row['content_name'] = db_getOne($sql_get_course_content);

	$tpl->append('verify_course_data', $row);
}

assignTemplate($tpl, '/apply_course/verify_course_list.tpl');



function genGroupingSqlWhere( $category , $db_prefix='')
{
	if($db_prefix != '') 
		$db_prefix .= '.' ; 
		
	return $db_prefix."applycourse_no in ( SELECT no FROM register_applycourse WHERE category='$category')";
}

?>

<?php
/****************************************************/
/* id: notebook_mgt.php v1.0 2007/9/29 by hushpuppy */
/* func: 個人筆記本管理介面 							*/
/****************************************************/
include('../config.php');
include('../session.php');
include('./lib/notebook_mgt_func.inc');
include('./lib/notebook_func.inc');

if(!isset($_SESSION['role_cd'])){
    session_destroy();
    identification_error();
}

global $Teacher_cd, $Begin_course_cd, $Course_cd, $Notebook_name, $Difficulty, $Attributes, $IsPublic;
global $DATA_FILE_PATH, $MEDIA_FILE_PATH, $COURSE_FILE_PATH;

$Personal_id = $_SESSION['personal_id'];
$Notebook_name = htmlspecialchars($_POST['notebook_name'], ENT_QUOTES);

$IsPublic = $_POST['isPublic'];
$M_Notebook_cd = $_POST['modify_notebook_cd']; //modify時，擷取的notebook_cd
$C_Notebook_cd = $_POST['create_notebook_cd'];
$E_Notebook_cd = $_POST['edit_notebook_cd'];


$smtpl = new Smarty;

//筆記本新增
if( isset($_POST['submit_create']) ){

	if( is_numeric(strpos($Notebook_name, "/")) || is_numeric(strpos($Notebook_name, "\\")) ){
		echo "<script>alert(\"警告!你所輸入筆記本名稱包含不合法字元!\");</script>";
	}else {
		$t = create_notebook($Personal_id, $Notebook_name, $IsPublic);
		
		if($t == 0){
			$smtpl->assign("status","筆記本名稱重複! 請重新輸入!");
		}else {
			$smtpl->assign("status","\"".$Notebook_name."\" 筆記本新增成功!");
		}
	}

	//header("Location: notebook_mgt.php");
	//return ;

}//修改筆記本名稱屬性  
else if(isset($_POST['submit_modify'])) {

	$t = modify_notebook();
	if($t == 0) {
		$smtpl->assign("status","筆記本名稱重複! 請重新修改!");
	}else {
		$smtpl->assign("status","\"".$Notebook_name."\"筆記本屬性修改成功!");
	}
} //修改並進入編輯筆記本內容
else if(isset($_POST['modify_and_edit'])) {
	$t = modify_notebook();
	if($t == 0){
		$smtpl->assign("status","筆記本名稱重複! 請重新修改!");
	}else {
		header("Location: nb_loadTreeFromDB.php?notebook_cd=$M_Notebook_cd");
	}
}//刪除整份筆記本
else if(isset($_POST['del_notebook'])) {	
	$Notebook_cd = $_POST['del_notebook_this'];
	$t = delete_notebook($Notebook_cd, $Personal_id);
	$smtpl->assign("status","\"".$t."\"筆記本刪除成功!");
}


	//找出這位人員的所有筆記本
	$sql = "select * from personal_notebook where personal_id=$Personal_id order by notebook_cd";
	$result = db_query($sql);

	$notes = array();
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$notes[ $row['notebook_cd'] ] = $row['notebook_name'];
	}
	$smtpl->assign("notebooks",$notes);
	assignTemplate($smtpl, '/note_book/notebook_mgt.tpl');
?>

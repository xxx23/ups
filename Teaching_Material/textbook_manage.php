<?php
/* id: textbook_manage.php 2007/3/12 v1.0 by hushpuppy Exp. */
/* function: 教師教材管理頁面 */
include('../config.php');
include('../session.php');
checkMenu("/Teaching_Material/textbook_manage.php");
include('./lib/textbook_mgt_func.inc');
include('./lib/textbook_func.inc');
include('../library/content.php');


global $Teacher_cd, $Begin_course_cd, $Course_cd, $Textbook_name, $Difficulty, $Attributes, $IsPublic;
global $IsDownload,$DownloadRole,$License,$Announce,$Rule;
global $smtpl;// for test
global $DATA_FILE_PATH, $MEDIA_FILE_PATH, $COURSE_FILE_PATH;

//$Teacher_cd = $_SESSION['personal_id'];
$Teacher_cd = getTeacherId();
$Begin_course_cd = $_SESSION['begin_course_cd'];
$Course_cd = $_SESSION['course_cd'];
$Textbook_name = $_POST['textbook_name'];
$Difficulty = $_POST['difficulty'];

$Attributes = $_POST['attributes'];
$Attributes_T = $_POST['attributes_T'];//如果有值是scorm教材
if(strlen($Attributes_T)>5)
    $Attributes = $Attributes_T;

$IsPublic = $_POST['isPublic'];
$IsDownload = $_POST['select4'];
$DownloadRole = $_POST['downloadRole'];
    $DownloadRole = implode (",", $DownloadRole);
    if($IsDownload == 0 )
         $DownloadRole = 0;

$License = $_POST['license'];
$Announce = $_POST['announce'];
$Rule = $_POST['rule'];

$Person = $_POST['person'];//判斷是個人化頁面or課程頁面 
  if(!isset($Person)) 
      $Person = $_GET['person'];//GET的語法是來自[教材匯入] 

$M_Content_cd = $_POST['modify_content_cd']; //modify時，擷取的contnet_cd
//不管在個人化頁面或課程頁面中，進入授課教材管理時，僅會編輯到屬於"自己"的教材，因此記在session變數中
//在課程頁面時，有可能要存取"本課程"(不一定屬於個人)所用的教材，路徑中的personal_id將不同，以此變數區隔。
//因此，在進入：textbook_manage_personal.php、textbook_manage.php時，註冊為1
//在進入edit_textbook_current.php、textbook_preview.php時，註冊為0
$_SESSION['self_textbook'] = '1';

$smtpl = new Smarty;
/* modify by zoe
 * 暫時把 teacher_cd 以及 begin_course_cd 傳給教材上傳用的php 
 * 也許有一天會改掉
 */
$smtpl->assign("teacher_cd",$Teacher_cd);
$smtpl->assign("begin_course_cd",$_SESSION['begin_course_cd']);

// rk87 2009/10/5
// 先檢查不合法字元     
if( is_numeric(strpos($Textbook_name, "/")) || 
    is_numeric(strpos($Textbook_name, "\\")) ||
    is_numeric(strpos($Textbook_name, " ")) ||    // 不使用空白
    is_numeric(strpos($Textbook_name, "<")) ||    // 避免XSS攻擊
    is_numeric(strpos($Textbook_name, ">"))       // by rk87
){
    echo "<script>alert(\"警告!你所輸入教材名稱包含不合法字元!\");</script>";
    $err=1;
}

//教材新增
if(isset($_POST['submit_create']) && !$err){
  $tmp = strpos($Textbook_name, "/");
    $status_str = "教材新增成功!";
    //檢查DB內是否已有相同名稱之教材
    $t = create_textbook();
    if($t == 0)
        $smtpl->assign("status","教材名稱重複! 請重新輸入!");
    else{
        $smtpl->assign("status","\"".$Textbook_name."\"".$status_str);
      sync_content_mediaStreaming_link($Teacher_cd);
    }

}//新增並進入編輯教材
else if(isset($_POST['create_and_edit'])&& !$err){
  $tmp = strpos($Textbook_name, "/");
    $t = create_textbook();
    
    if($t == 0){
        $smtpl->assign("status","教材名稱重複! 請重新輸入!");
    }
    else{
      header("Location: ./tea_loadTreeFromDB.php?content_cd=$t");
      sync_content_mediaStreaming_link($Teacher_cd);
    }
  
}//修改教材名稱屬性
else if(isset($_POST['submit_modify'])&& !$err){
    $status_str = "教材屬性修改成功!";
    $t = modify_textbook();
    sync_content_mediaStreaming_link($Teacher_cd);
    if($t == 0)
        $smtpl->assign("status","教材名稱重複! 請重新修改!");
    else
        $smtpl->assign("status","\"".$Textbook_name."\"".$status_str);

}//修改並進入編輯教材內容
else if(isset($_POST['modify_and_edit'])&& !$err){
    $t = modify_textbook();
    sync_content_mediaStreaming_link($Teacher_cd);
    if($t == 0)
        $smtpl->assign("status","教材名稱重複! 請重新修改!");
    else
    {    
        //joyce 0508
        //檢查是不是scorm.zip $M_Content_cd 有沒有在 class_content
        $sql = "select COUNT('content_cd') from class_content where content_cd = '$M_Content_cd;'";
        $result = db_getOne($sql);
        if($result == 0)
        {
            $smtpl->assign("status","Scorm教材包 不提供詳細內容修改!");
        }
        else   
            header("Location: ./tea_loadTreeFromDB.php?content_cd=$M_Content_cd");
    }

}//選擇更新教材
else if(isset($_GET['choose_textbook_this'])&& !$err){  
    $Content_cd = $_GET['choose_textbook_this'];
    $Person = $_GET['person'];
    choose_textbook();

} //刪除整份教材
else if(isset($_POST['del_textbook_this'])&& !$err){    
    $status_str = "教材刪除成功!";
    $Content_cd = $_POST['del_textbook_this'];
    $Person = $_POST['person'];

    $t = delete_textbook();
    
    sync_content_mediaStreaming_link($Teacher_cd);
    delete_content_mediaStreaming($Content_cd);
    $smtpl->assign("status","\"".$t."\"".$status_str);
}

//找出這門課的對應教材
$sql = "select * from class_content_current where begin_course_cd = '$Begin_course_cd';";

$result = db_query($sql);
$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
if(count($row) == 0 || $row['content_cd'] == 0) //目前這門課尚未選擇對應的教材
    $textbook_str = "尚未選擇!";
else{
    $Content_cd = $row['content_cd'];
    $this_class_textbook = $Content_cd;
    $sql = "select * from course_content where content_cd = '$Content_cd;'";
    $result = db_query($sql);
    $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
    $textbook_str = $row['content_name'];
}

$textbook_master = textbook($Begin_course_cd);
$textbook_master_name = returnName($textbook_master);
$smtpl->assign("TEXTBOOK",$textbook_str);
$smtpl->assign("textbook_master",$textbook_master_name);


$sql = "select * from course_content where teacher_cd = '$Teacher_cd;'";
$result = db_query($sql);

$array = array();
while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
    $array[ $row['content_cd'] ] = array($row['content_name'], 0 , $row['datetime']);
    
    if( $row['content_cd'] == $this_class_textbook ){
        $array[ $row['content_cd'] ] = array($row['content_name'], 1 , $row['datetime']); // mean can't delete , lock button 
    }
}
$smtpl->assign("all_textbook",$array);


if($_SESSION['role_cd'] == 2){ 
   $sql = "select login_id from register_basic where personal_id = '{$_SESSION['personal_id']}'"; 
   $login_id = db_getOne($sql); 
   $row = $result->fetchRow(DB_FETCHMODE_ASSOC); 
   $smtpl->assign("msg","您可以替老師使用助教的帳號透過FTP上傳教材"); 
 }else{ 
   $sql = "select login_id from register_basic where personal_id = '$Teacher_cd'"; 
   $login_id = db_getOne($sql); 
 } 

$ftp_path = "ftp://".$login_id."@".$FTP_IP.":".$FTP_PORT."/textbook/";

$smtpl->assign("role_cd",$_SESSION['role_cd']); 
$smtpl->assign("ftp_ip",$FTP_IP);
$smtpl->assign("ftp_port",$FTP_PORT);
$smtpl->assign("ftp_path",$ftp_path);
$smtpl->assign("time",$time);


if($Person == 1)
    assignTemplate($smtpl, "/teaching_material/textbook_manage_personal.tpl");
else
    assignTemplate($smtpl, "/teaching_material/textbook_manage.tpl");

function delete_content_mediaStreaming($content_cd) {
    //取得教材相關lib ex: 從conetent_cd 拿到teacher_id
    global $MEDIA_FILE_PATH;
    db_query('delete from on_line where content_cd='.$content_cd);

    $teacher_id =  get_Teacher_id($content_cd);
    $target_dir = $MEDIA_FILE_PATH.$teacher_id.'/'.$content_cd.'/' ;
    SureRemoveDir($target_dir, false);
}
  
?>


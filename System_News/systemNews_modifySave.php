<?php
/*
修改公告後儲存
DATE:   2006/12/13
AUTHOR: 14_不太想玩
*/
$RELEATED_PATH = "../";

require_once($RELEATED_PATH . "config.php");
require_once($RELEATED_PATH . "session.php");	
require_once($HOME_PATH . 'library/filter.php');
require_once('library.php') ;



$role_cd = $_SESSION['role_cd'];				//取得role_cd		
$personal_id = $_SESSION["personal_id"];		//人員編號			
$begin_course_cd = $_SESSION["begin_course_cd"];	//課程編號

if($role_cd == 0)
{	
	//系統公告
	//設定檔案儲存路徑
	$FILE_PATH = gen_system_news_path($personal_id) ; 
}
elseif($role_cd == 1 || $role_cd == 2)
{
	//課程公告
	//設定檔案儲存路徑
	$FILE_PATH = gen_course_news_path($begin_course_cd) ; 
}
else
{
	echo "Error !!!";
	exit(0);
}

//news_cd
$news_cd = required_param('news_cd', PARAM_INT);
$course_type = required_param('news_type', PARAM_INT);

//判斷公告的類型(1.ㄧ般性 2.時限性 3.週期性)
$formType = $_POST["formType"];

//重要等級 //要移除。改用預設
//$important = $_POST["important"];	
$important = 1;	

//起始日期
$startYear = $_POST["startYear"];
$startMonth = $_POST["startMonth"];
$startDay = $_POST["startDay"];
$d_news_begin = $startYear . $startMonth . $startDay . "000000";

//結束日期
$endYear = $_POST["endYear"];
$endMonth = $_POST["endMonth"];
$endDay = $_POST["endDay"];
$d_news_end = $endYear . $endMonth . $endDay . "000000";

//週期設定
$cycleYear = $_POST["cycleYear"];
$cycleMonth = $_POST["cycleMonth"];
$cycleDay = $_POST["cycleDay"];
$d_cycle = $cycleYear . $cycleMonth . $cycleDay;

$cycleWeek = $_POST["cycleWeek"];

//過期處理方式
$handle = $_POST["handle"];
if(isset($handle) == false)	$handle = 1;

//公告課程類型
$news_type = $_POST['news_type'] ;

//公告標題
$subject = $_POST["subject"];
$subject = substr($subject,0,99);
//$subject = stripslashes($subject);

//公告內容
$content = $_POST["content"];
//$content = stripslashes($content);

//網址
$url = $_POST["url"];
//$url = stripslashes($url);
if (substr($url,0,7) != "http://"){
        $url = "http://".$url;
}

//finishPage
$finishPage = $_POST["finishPage"];	


//更新資料到Table news
$sql = "UPDATE 
			news 
		SET 				
			subject = '$subject', 
			d_news_begin = '$d_news_begin', 
			d_news_end = '$d_news_end', 
			content = '$content', 
			important = $important, 
			d_cycle = '$d_cycle', 
			week_cycle = '$cycleWeek', 
			handle = '$handle', 
			if_news = '$formType' 
		WHERE 
			news_cd = $news_cd";
db_query($sql);


$sql_update_newsTarget = ' UPDATE news_target set course_type='.$course_type.' where news_cd='.$news_cd;
db_query($sql_update_newsTarget) ;
/*
//上傳資料到news_target
$sth = $DB_CONN->prepare('INSERT INTO news_target (news_cd, role_cd, begin_course_cd) VALUES (?, ?, ?)');
$data = array($news_cd, $role_cd, $begin_course_cd);
$res = $DB_CONN->execute($sth, $data);
if (PEAR::isError($res))	die($res->getMessage());
*/

/*
echo "暫存檔：" . $_FILES['file']['tmp_name'] . "<br>";
echo "檔案名稱：" . $_FILES['file']['name'] . "<br>";  //上傳檔案名稱
echo "檔案大小：" . $_FILES['file']['size'] . "<br>";   //上傳檔案大小(Bytes)
echo "檔案類型：" . $_FILES['file']['type'] . "<br>";   //上傳檔案MIME類型
*/

//有檔案要上傳
if(!empty($_FILES['file']['tmp_name']) )
{	
				
	foreach($_FILES['file']['name'] as $file_index => $value) { // inspect looping 
		if($_FILES['file']['tmp_name'][$file_index] == '') 
			continue;
			
		//設定要上傳的資料
		$fileName = $_FILES['file']['name'][$file_index];		//檔案名稱
		$ext = strrchr( $fileName, '.' );			//副檔名
		$file_type = FILE_fileType($ext);			//檔案類型
		//$newFileName = $news_cd . "_" . $file_cd . $ext;	//新檔案名稱: 公告編號+ 檔案編號
		$newFileName = $news_cd .'_'.md5($_FILES['file']['name'][$file_index].time().$file_index) .$ext;				//新檔案名稱: 公告編號
		$fileUrl = $FILE_PATH . $newFileName;	//檔案的連結
		
		
		//上傳檔案到Server
		if( FILE_upload($_FILES['file']['tmp_name'][$file_index], $HOME_PATH.$FILE_PATH, $newFileName) == false) {	
			echo "FILE_upload fail";
			die();
		}
		
		//上傳資料到Table news_upload
		$sth = $DB_CONN->prepare('INSERT INTO news_upload (news_cd, file_name, file_type, news_file, file_url, if_url) VALUES (?, ?, ?, ?, ?, ?)');
		$data = array($news_cd, $fileName, $file_type, $newFileName, $fileUrl, 0);
		$DB_CONN->execute($sth, $data);
	}
}


//有網址要上傳
if($url != "")
{	
    $has_url = "select count(*) from news_upload where news_cd=$news_cd and if_url=1";
    $flag = db_getOne($has_url) ;

    if( $flag == 1 ) {  
        $sql_url = "update news_upload set file_url='$url' where news_cd=$news_cd and if_url=1 " ;   	
    }else {
	    $sql_url = "insert into news_upload(news_cd, file_url, if_url) VALUES ($news_cd, '$url', '1')";
    }
	db_query($sql_url);
}else {
    $has_url = "select count(*) from news_upload where news_cd=$news_cd and if_url=1"; 
    $flag = db_getOne($has_url) ; 
    
    $delete_url = "delete from news_upload where news_cd=$news_cd and if_url=1 " ; 
    db_query($delete_url);  

}

//導向到finishPage
header("location: " . $finishPage);
?>

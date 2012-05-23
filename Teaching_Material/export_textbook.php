<?php
/***********************************************************/
/* id: export_textbook.php v1.0 2007/5/1 by hushpuppy Exp. */
/* function: 將教材匯出的功能			 	   */
/* required : rar壓縮程式 version: rar-3.70b1_2,1	   */
/***********************************************************/
include "../config.php";
require_once("../session.php");
require_once("./scorm/export_xml.inc");
require_once("./scorm/export_SCORM12.inc");
require_once("./scorm/export_SCORM2004.inc");
require_once("./scorm/export_dump.inc");
checkMenu("/Teaching_Material/textbook_manage.php");
global $DATA_FILE_PATH, $smtpl, $tpl_path, $Content_cd;

//DATA_FILE_PATH 是 =/home/xxxid/WWW/Data_File/

$Teacher_cd = $_SESSION['personal_id'];
$Content_cd = $_GET['content_cd'];
//取得教材編號
if(isset($Content_cd))
	$_SESSION['content_cd'] = $Content_cd;
else
	$Content_cd = $_SESSION['content_cd'];

//匯出的種類
$Export_option = $_POST['export_option'];
$smtpl = new Smarty;

//由教材編號取得教材名稱
	$sql = "select file_name from class_content where content_cd = '$Content_cd' and menu_parentid='0'";
$Content_name = db_getOne($sql);

if(!isset($Content_name))	
{
  $sql="select content_name from course_content where content_cd='$Content_cd'";
  $Content_name=db_getOne($sql);
  
 /* Modified by joyce  如果是.zip的scorm教材 資料路徑與DATA_FILE_PATH不同! */

  //從content_cd查scorm_id
  $sql = "select id,course from mdl_scorm  where content_cd ='$Content_cd'";
  $result = db_getRow($sql);
  
  $scorm_path = str_replace("Data_File","Teaching_Material",$DATA_FILE_PATH);
  $scorm_path = $scorm_path."scorm/nccudata/" .$result['course']."/";
    
  $file_name = $result['id'].".zip";
  $scorm_file = $scorm_path.$file_name;
  //var_dump($scorm_file);
  
  if(!file_exists($scorm_file)){
	$scorm_path .= "moddata/scorm/";
	$file_name = $result['id'].".rar";
	
      $cmd = "cd ".$scorm_path."; rar a ".$result['id'].".rar ".$result['id'];
      //echo "壓縮 $cmd";                                                                   
      exec($cmd);
  } 
  $_SESSION['current_path'] = $scorm_path;
  $smtpl->assign("content_name",$Content_name);
  $smtpl->assign("export_file_size",filesize($scorm_file));
  $smtpl->assign("export_file_time",date("F d Y H:i:s.", fileatime($scorm_file)));
  

  $smtpl->assign("export_file_path","redirect_file.php?file_name=".$file_name);
  $smtpl->assign("export_download_name",
              $file_name."&nbsp;<img src=\"".createTPLPath()."/images/icon/download.gif\">");
  assignTemplate( $smtpl,"/teaching_material/scorm_textbook_export.tpl");
}


else //非scorm.zip的教材處理
{
    $smtpl->assign("content_name",$Content_name);

    if($Export_option == 1){	//匯出一般教材
        //export_textbook($Content_name, $Teacher_cd, ".rar");  
        //一般教材格式暫時與SCORM1.2一樣,主要必須有imsmenifast.xml
        export_general($Content_cd, $Content_name, $Teacher_cd);
    }
    else if($Export_option == 2){	//匯出scorm 1.2
        export_SCORM12(0,$Content_cd, $Content_name, $Teacher_cd);
    }
    else if($Export_option == 3){	//匯出scorm 2004
	    export_SCORM2004(0,$Content_cd, $Content_name, $Teacher_cd);
    }

    //顯示一般教材匯出狀況
    $file_name = str_replace(" ","_",$Content_name).".rar";
    show_status("1_", $file_name, $Teacher_cd);
    //顯示scorm 1.2匯出狀況
    $file_name = str_replace(" ","_",$Content_name)."_scorm_12.rar";
    show_status("2_", $file_name, $Teacher_cd);
    //顯示scorm 2004匯出狀況
    $file_name = str_replace(" ","_",$Content_name)."_scorm_2004.rar";
    show_status("3_", $file_name, $Teacher_cd);
    $smtpl->assign("content_cd",$Content_cd);
    assignTemplate( $smtpl,"/teaching_material/export_textbook.tpl");

}//else 非scorm.zip的教材處理

function show_status($prefix, $file_name, $teacher_cd)
{
	global $DATA_FILE_PATH, $smtpl, $tpl_path;
	$path = $DATA_FILE_PATH.$teacher_cd."/export_data/";

    $_SESSION['current_path'] = $path;	//要使用redirect_file.php傳回檔案前，要先將檔案路徑存入session中的surrent_path變數
	$file_path = $path.$file_name;
	//$smtpl->assign("test",$file_path);
    //$file_name = encodePATH($file_name);
    //echo "file_path = " .$file_path ."<br>";;
	if(file_exists($file_path)){

		$smtpl->assign($prefix."export_exist",1);	//判斷要顯示"匯出"，還是"重新匯出"
		$smtpl->assign($prefix."export_file_size",filesize($file_path));
		$smtpl->assign($prefix."export_file_time",date("F d Y H:i:s.", fileatime($file_path)));
		$smtpl->assign($prefix."export_file_path","redirect_file.php?file_name=".urlencode($file_name));
		$smtpl->assign($prefix."export_download_name",
		$file_name."&nbsp;<img src=\"".createTPLPath()."/images/icon/download.gif\">");
	}
	else{
		$smtpl->assign($prefix."export_exist",0);
		$smtpl->assign($prefix."export_file_size","尚未匯出");
		$smtpl->assign($prefix."export_file_time","尚未匯出");
		$smtpl->assign($prefix."export_file_path","尚未匯出");
		//$smtpl->assign("export_download_name","尚未匯出");
	}
}


function export_general($content_cd, $content_name, $teacher_cd)
{
  global $DATA_FILE_PATH, $store_path;
  $store_path = $DATA_FILE_PATH.$teacher_cd."/textbook/".$content_name."/";
  
  $doc = new DOMDocument('1.0','UTF-8');

  $root_element = generate_basic_elements_SCORM12($doc, $content_name);
  
  $new_node = $doc->appendChild($root_element);
  //取得organization那個node
  $organization_node = $doc->getElementsByTagName('organization');
  //根節點設為organizations
  generate_branch_nodes($doc, $organization_node->item(0), $content_cd);
  $store_path_xml = $store_path."/imsmanifest.xml";
  $doc->save($store_path_xml);

  export_textbook(0 , $content_cd, $content_name, $teacher_cd, ".rar");
}
?>

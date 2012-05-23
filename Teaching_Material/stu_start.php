<?php
/***********************************************************/
/* id: stu_start.php 2007/8/23 by hushpuppy Exp.		   */
/* function: 教材導覽 學生頁面							   */
/***********************************************************/

include "../config.php";
require_once("../session.php");
require_once("./lib/textbook_func.inc");
require_once("./lib/learning_record.php");
require_once('../library/content.php');
require_once('../Learning_Tracking/time_output_format.php');

//checkMenu("/Teaching_Material/textbook_.php");
$Content_cd = $_GET['content_cd'];
$Begin_course_cd = $_SESSION['begin_course_cd'];
$Frame = $_GET['frame'];

$smtpl = new Smarty;
//取得這一門課所使用的教材它的老師的id
$Teacher_cd = textbook($Begin_course_cd);
$path = $DATA_FILE_PATH.$Teacher_cd."/textbook/";
$Personal_id = $_SESSION['personal_id'] ; 

$Menu_id = returnContent_cdRootMenuId($Content_cd);  
$content_name = returnContentName($Content_cd);
if(isset($Content_cd) && isset($Menu_id)){  //按下樹狀結構時，以得到的值向session註冊
    learning_status($Content_cd, $Menu_id, $Personal_id);
    $_SESSION['content_cd'] = $Content_cd;
    $_SESSION['menu_id'] = $Menu_id;
}

$content_file_name = returnContentFileName($Content_cd);
$path .= $content_file_name."/";
show($smtpl, $path);

$new_path = str_replace($HOME_PATH, "/", $path);
//print $new_path;
$new_path = encodePATH($new_path);

$new_path = ltrim($new_path,'/');	//必免跟WEBROOT結合產生  '//'

//echo "root current_path: $path <br>";
$smtpl->assign("current_path",rtrim($WEBROOT.$new_path,'/'));
$smtpl->assign("content_cd",$Content_cd);
$smtpl->assign("Menu_id", $Menu_id); 
$smtpl->assign("Begin_course_cd", $Begin_course_cd);
$smtpl->assign("Personal_id", $Personal_id);
$smtpl->assign("Frame",$Frame);

//--------0308 joyce edit-------
$sql = "SELECT
         sum(TIME_TO_SEC(A.event_hold_time)) as event_hold_time
        FROM
         student_learning A
        WHERE
         A.begin_course_cd = '$Begin_course_cd' AND
         A.content_cd = '".get_Content_cd($Begin_course_cd)."' AND
         A.personal_id = '$Personal_id'
         ";

$res = db_query($sql);
$resultNum = $res->numRows();

if($resultNum > 0)
{
    $res->fetchInto($row, DB_FETCHMODE_ASSOC);
    $ReadTextTime = time_output_format($row['event_hold_time']);
    $smtpl->assign("ReadTextTime", $ReadTextTime);
}
//-------------------------------

assignTemplate( $smtpl,"/teaching_material/stu_start.tpl");


function show($smtpl, $path)
{
     $file_path1 = $path."index.html";
     $file_path2 = $path."index.htm";
     $file_path3 = $path."index.swf";

     $index_exist1 = false;
     $index_exist2 = false;
     $index_exist3 = false;

     if(file_exists($file_path1))
            $index_exist1 = true;
     if(file_exists($file_path2))
	    $index_exist2 = true;
     if(file_exists($file_path3))
	    $index_exist3 = true;
     
     if($index_exist1 == false && $index_exist2 == false && $index_exist3 == false)
        $smtpl->assign("index_show",0); //預覽時顯示檔案list
     else{
        if($index_exist1 == true){
            $handle = fopen($file_path1, "r");  //開啟index.html並將內容塞回textarea
            $smtpl->assign("index_show",1);     //預覽時顯示index.html
        }
        else if($index_exist2 == true){
            $handle = fopen($file_path2, "r");
            $smtpl->assign("index_show",2);     //預覽時顯示index.htm
        }
	else if($index_exist3 == true){	
            $handle = fopen($file_path3, "r");
            $smtpl->assign("index_show",3);     //預覽時顯示index.swf
	}
        $index_content = fread($handle, 65535);
        $smtpl->assign("index_content",$index_content);
	}
}

function encodePATH($Path)
{
    $tok = strtok($Path, "/");
      $string = "/";
      while ($tok !== false) {
		if(strstr($tok," ") != false)
			$str = $tok;
		else
            $str = URLENCODE($tok);
                $tok = strtok("/");
                $string = $string.$str."/";
      }
        return $string;
}

?>

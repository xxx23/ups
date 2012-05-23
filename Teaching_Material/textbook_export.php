<?php
include('../config.php');
include('../session.php');
require_once("./scorm/export_xml.inc");
require_once("./scorm/export_SCORM12.inc");
require_once("./scorm/export_SCORM2004.inc");
require_once("./scorm/export_dump.inc");
require_once($HOME_PATH . 'library/filter.php') ;
$smtpl = new Smarty;

$personal_id=$_SESSION["personal_id"];
$Content_cd=$_SESSION["content_cd"];

$organization =  optional_param("organization", '',PARAM_CLEAN );
$download_reason =  optional_param("download_reason", '',PARAM_CLEAN );

$share = $_GET['share'];
$time = date('Y-m-d H:i:s');

    $sql="select content_cd,personal_id from download_reason where content_cd='$Content_cd' and personal_id='$personal_id'";
    $result=db_getRow($sql);
    if(isset($result))
    {
        $sql = "update download_reason set organization = '$organization', download_reason = '$download_reason', time = '$time'
        where content_cd='$Content_cd' and personal_id='$personal_id'";
    }
    else
    {
        $sql = "insert into download_reason (content_cd, personal_id,organization, download_reason,time)
        values ('$Content_cd', '$personal_id' ,'$organization','$download_reason','$time');";
    }
    db_query($sql);


if($share == 1) // 教材分享
	header("Location: textbook_share.php");

else if($share == 0) // 學生教材下載
	header("Location: textbook_export_general.php");

?>

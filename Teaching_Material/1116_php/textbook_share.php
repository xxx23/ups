<?php
include('../config.php');
include('../session.php');
//require_once($HOME_PATH. 'library/smarty_init.php');
$tpl = new Smarty;

$Content_cd=$_SESSION["content_cd"];
$D_type=$_SESSION["d_type"];//1108增，判斷下載格式

if(!isset($_SESSION["lang"]))
    $_SESSION["lang"] = "zh_tw";

    $lang = $_SESSION["lang"];

$sql="select license,announce,rule from content_download where content_cd='$Content_cd'";
$result=db_getRow($sql);

$license=$result['license'];
$announce=$result['announce'];
$rule=$result['rule'];

//===========================================
$zh_tw_licenseName[0] = "未取得授權";
$zh_tw_licenseName[1] = "開放自由使用";
$zh_tw_licenseName[3] = "創用CC授權條款[姓名標示]";
$zh_tw_licenseName[4] = "創用CC授權條款[姓名標示─非商業性]";
$zh_tw_licenseName[5] = "創用CC授權條款[姓名標示─非商業性─相同方式分享]";
$zh_tw_licenseName[6] = "創用CC授權條款[姓名標示─禁止改作]";
$zh_tw_licenseName[7] = "創用CC授權條款[姓名標示─非商業性─禁止改作]";
$zh_tw_licenseName[8] = "創用CC授權條款[姓名標示─相同方式分享]";
$zh_tw_licenseName[9] = "教育部聲明格式";

$en_licenseName[0] = "without a license";
$en_licenseName[1] = "open free to use";
$en_licenseName[3] = "Creative Commons[Attribution]";
$en_licenseName[4] = "Creative Commons[Attribution-NonCommercial]";
$en_licenseName[5] = "Creative Commons[Attribution-NonCommercial-ShareAlike]";
$en_licenseName[6] = "Creative Commons[Attribution-NoDerivs]";
$en_licenseName[7] = "Creative Commons[Attribution-NonCommercial-NoDerivs]";
$en_licenseName[8] = "Creative Commons[Attribution-ShareAlike]";
$en_licenseName[9] = "other license";
//===========================================
$zh_tw_licenseLink[0] = "";
$zh_tw_licenseLink[1] = "";
$zh_tw_licenseLink[3] = "<a href='http://creativecommons.org/licenses/by/3.0/tw' target=_blank><img src='../images/download_cc/cc1.png' border='0' /></a>";
$zh_tw_licenseLink[4] = "<a href='http://creativecommons.org/licenses/by-nc/3.0/tw/' target=_blank><img src='../images/download_cc/cc2.png' border='0' />";
$zh_tw_licenseLink[5] = "<a href='http://creativecommons.org/licenses/by-nc-sa/3.0/tw' target=_blank><img src='../images/download_cc/cc3.png' border='0' />";
$zh_tw_licenseLink[6] = "<a href='http://creativecommons.org/licenses/by-nd/3.0/tw' target=_blank><img src='../images/download_cc/cc4.png' border='0' />";
$zh_tw_licenseLink[7] = "<a href='http://creativecommons.org/licenses/by-nc-nd/3.0/tw' target=_blank><img src='../images/download_cc/cc5.png' border='0' />";
$zh_tw_licenseLink[8] = "<a href='http://creativecommons.org/licenses/by-sa/3.0/tw' target=_blank><img src='../images/download_cc/cc6.png' border='0' />";
$zh_tw_licenseLink[9] = "";

$en_licenseLink[0] = "";
$en_licenseLink[1] = "";
$en_licenseLink[3] = "<a href='http://creativecommons.org/licenses/by/3.0/' target=_blank><img src='../images/download_cc/cc1.png' border='0' /></a>";
$en_licenseLink[4] = "<a href='http://creativecommons.org/licenses/by-nc/3.0/' target=_blank><img src='../images/download_cc/cc2.png' border='0' />";
$en_licenseLink[5] = "<a href='http://creativecommons.org/licenses/by-nc-sa/3.0/' target=_blank><img src='../images/download_cc/cc3.png' border='0' />";
$en_licenseLink[6] = "<a href='http://creativecommons.org/licenses/by-nd/3.0/' target=_blank><img src='../images/download_cc/cc4.png' border='0' />";
$en_licenseLink[7] = "<a href='http://creativecommons.org/licenses/by-nc-nd/3.0/' target=_blank><img src='../images/download_cc/cc5.png'  border='0' />";
$en_licenseLink[8] = "<a href='http://creativecommons.org/licenses/by-sa/3.0/' target=_blank><img src='../images/download_cc/cc6.png' border='0' />";
$en_licenseLink[9] = "";
//===========================================
	if($lang =="zh_tw")
	{ 
		$licenseName = $zh_tw_licenseName[$license];
		$licenseLink = $zh_tw_licenseLink[$license];
    }
    else
	{
		$licenseName = $en_licenseName[$license];
		$licenseLink = $en_licenseLink[$license];   
	}

$sql="select content_name from course_content where content_cd='$Content_cd'";
$contentName = db_getOne($sql);

$tpl->assign("content_cd",$Content_cd);
$tpl->assign("contentName",$contentName);
$tpl->assign("licenseName",$licenseName); 
$tpl->assign("licenseLink",$licenseLink);
$tpl->assign("license",$license); 
$tpl->assign("announce",$announce); 
$tpl->assign("rule",$rule);	
$tpl->assign("d_type",$D_type);	//1108增，判斷下載格式

assignTemplate($tpl, "/teaching_material/textbook_share.tpl");
?>

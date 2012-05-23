<?php
include('../config.php');
include('../session.php');

if(!isset($_SESSION["lang"]))
                $_SESSION["lang"] = "zh_tw";

    $lang = $_SESSION["lang"];

$smtpl = new Smarty;

$begin_course_cd=$_SESSION["begin_course_cd"];
$personal_id=$_SESSION["personal_id"];
    $sql="select content_cd from class_content_current where begin_course_cd='$begin_course_cd'";
    $content_cd=db_getOne($sql);
$_SESSION["content_cd"]=$content_cd;

//根據教材編號，查看是否提供下載
$sql="select is_download,download_role,license,announce,rule from content_download where content_cd='$content_cd'";
$result=db_getRow($sql);
$is_download=$result["is_download"];
$download_role=$result["download_role"];
$license=$result['license'];
$announce=$result["announce"];
$rule=$result["rule"];

$download_role_OK = 0;
if(strstr($download_role,'1')||strstr($download_role,'5'))
    $download_role_OK = 1;

if($is_download == 1 && $download_role_OK == 1)
{
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

        $sql="select content_name from course_content where content_cd='$content_cd'";
        $contentName = db_getOne($sql);

        $smtpl->assign("content_cd",$Content_cd);
        $smtpl->assign("contentName",$contentName);
        $smtpl->assign("licenseName",$licenseName); 
        $smtpl->assign("licenseLink",$licenseLink);
        $smtpl->assign("license",$license); 
        $smtpl->assign("announce",$announce); 
        $smtpl->assign("rule",$rule); 
}
else
{
    echo "此門課不提供教材下載";
    exit();
}
assignTemplate($smtpl, "/teaching_material/textbook_download.tpl");
?>

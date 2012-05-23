<?php
    require_once('../config.php');
    
    // create smarty object
    $tpl = new Smarty();

    //assign image link and title 
    $images[0]['title']='IE瀏覽器版本升級';
    $images[0]['file']='../images/download_ie.jpg';
    $images[0]['link']='http://www.microsoft.com/downloads/details.aspx?FamilyID=341c2ad5-8c3d-4347-8c03-08cdecd8852b&DisplayLang=zh-tw';
	
	$images[1]['title']='WMP撥放器版本升級';
    $images[1]['file']='../images/download_wmp.jpg';
    $images[1]['link']='http://www.microsoft.com/downloads/details.aspx?FamilyID=1d224714-e238-4e45-8668-5166114010ca&DisplayLang=zh-tw';
	
	$images[2]['title']='安裝FileZilla';
    $images[2]['file']='../images/download_filezilla.jpg';
    $images[2]['link']='http://filezilla-project.org/download.php?type=client';
    
    $images[3]['title']='安裝Java';
    $images[3]['file']='../images/download_java.jpg';
    $images[3]['link']='http://www.java.com/zh_TW/download/index.jsp';
	
	$images[4]['title']='安裝Adobe Flash Player';
    $images[4]['file']='../images/download_flash.jpg';
    $images[4]['link']='http://get.adobe.com/flashplayer/';
	
	$images[5]['title']='安裝Adobe Acrobat Reader';
    $images[5]['file']='../images/download_pdf.jpg';
    $images[5]['link']='http://get.adobe.com/tw/reader/';



	
    //display
    $tpl->assign('images',$images);
    assignTemplate($tpl,'/other/software_download.tpl');
?>

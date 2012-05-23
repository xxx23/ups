<?php
	require_once('../config.php');
    $linkSet= array();
        
	$links[0]['title'] = '故宮e學園';
	$links[0]['link'] = 'http://elearning.npm.gov.tw/index.htm';
	
	$links[1]['title'] = '社教博識網';
	$links[1]['link'] = 'http://wise.edu.tw/2008_new/';
	
	$links[2]['title'] = '數位內容學院';
	$links[2]['link'] = 'http://www.dci.org.tw/';
	
	$links[3]['title'] = '國家圖書館遠距學園';
	$links[3]['link'] = 'http://cu.ncl.edu.tw/';
	
	$links[4]['title'] = '台灣e（醫）學院';
	$links[4]['link'] = 'http://fms.cto.doh.gov.tw/';
	
	$links[5]['title'] = '藝學網';
	$links[5]['link'] = 'http://learning.cca.gov.tw/';
	
	$links[6]['title'] = '臺北e大';
	$links[6]['link'] = 'http://elearning.taipei.gov.tw/';
	
	$links[7]['title'] = '府城e學院';
	$links[7]['link'] = 'http://school.tncg.gov.tw/';
	
	$links[8]['title'] = '港都e學苑';
	$links[8]['link'] = 'http://elearning.kcg.gov.tw/';
	
	$links[9]['title'] = 'e觸即發學習網';
	$links[9]['link'] = 'http://bhrd.kcg.gov.tw/elearning/';
	
	$links[10]['title'] = '台灣原住民族網路學院';
	$links[10]['link'] = 'http://e-learning.apc.gov.tw/';
	
	$links[11]['title'] = '哈客網路學院';
	$links[11]['link'] = 'http://elearning.hakka.gov.tw/';
	
	$links[12]['title'] = '文官e學苑';
	$links[12]['link'] = 'http://ecollege.ncsi.gov.tw/';
	
	$links[13]['title'] = '電子化政府網路文官學院';
	$links[13]['link'] = 'http://elearning.nat.gov.tw/';
	
	$links[14]['title'] = 'e等公務園';
	$links[14]['link'] = 'http://elearning.hrd.gov.tw/ehrd2005/';
	
	$links[15]['title'] ='公務員資訊學習網';
	$links[15]['link'] = 'http://itschool.dgbas.gov.tw/';
    
    $linkSet[0]['class'] = '一般民眾';
    $linkSet[0]['items'] = $links;

    $links1[0]['title'] = '教育部六大學習網';
	$links1[0]['link'] = 'http://learning.edu.tw/sixnet/index.php';
	
	$links1[1]['title'] = '教育部教學資源網';
	$links1[1]['link'] = 'http://etoe.edu.tw/';
	
	$links1[2]['title'] = '教育部數位內容交換分享平台';
	$links1[2]['link'] = 'http://edshare.edu.tw/';
	
	$links1[3]['title'] = '數位典藏融入教學資源網';
	$links1[3]['link'] = 'http://edu.brightideas.com.tw/share/index.aspx';
	
	$links1[4]['title'] = '教育部中小學網路素養與認知';
	$links1[4]['link'] = 'http://eteacher.edu.tw/';
	
	$links1[5]['title'] = '嗨！高中心課程資訊網';
	$links1[5]['link'] = 'http://hischool.moe.edu.tw/main/home/entity_list.php';
	
	$links1[6]['title'] = '教育部學習加油站';
	$links1[6]['link'] = 'http://content.edu.tw/';
	
	$links1[7]['title'] = '教材知識學習網';
	$links1[7]['link'] = 'http://bhrd.kcg.gov.tw/tm/';

    $linkSet[1]['class'] = '中小學教師';
    $linkSet[1]['items'] = $links1;   
	
    $links2[0]['title'] = '全國通識網';
	$links2[0]['link'] = 'http://get.nccu.edu.tw/main/';
	
	$links2[1]['title'] = '大學院校課程上網';
	$links2[1]['link'] = 'http://ucourse.tvc.ntnu.edu.tw/';
	
	$links2[2]['title'] = '台灣開放式課程聯盟';
	$links2[2]['link'] = 'http://tocwc.nctu.edu.tw/';
	
	$links2[3]['title'] = '開放式課程計畫';
	$links2[3]['link'] = 'http://www.myoops.org/twocw/';
	
	$links2[4]['title'] = '環境變遷與永續發展教育部數位學習示範課程';
	$links2[4]['link'] = 'http://environment.edu.tw/';
	
    $linkSet[2]['class'] = '大專院校';
    $linkSet[2]['items'] = $links2;

    $links3[0]['title'] = '教育部遠距交流暨認證網';
	$links3[0]['link'] = 'http://ace.moe.edu.tw/';
	
	$links3[1]['title'] = '品質認證中心';
	$links3[1]['link'] = 'http://www.elq.org.tw/';

	$links3[2]['title'] = '臺灣產業經濟檔案-塑膠工廠';
    $links3[2]['link'] = 'http://theme.archives.gov.tw/rsp/00home/home.asp';

	$links3[3]['title'] = '中興紙業';
    $links3[3]['link'] = 'http://theme.archives.gov.tw/chunghsing/01start/01_main.asp';
    
	$links3[4]['title'] = '高雄硫酸錏';
    $links3[4]['link'] = 'http://theme.archives.gov.tw/kaolau/00_home/main.asp';

	$links3[5]['title'] = '榮民製藥廠';
    $links3[5]['link'] = 'http://theme.archives.gov.tw/zonmin/00home/home.asp';

	$links3[6]['title'] = '中華電信';
    $links3[6]['link'] = 'http://theme.archives.gov.tw/tel/';

	$links3[7]['title'] = '臺鹽';
    $links3[7]['link'] = 'http://theme.archives.gov.tw/salt/00home/index.asp';

    $linkSet[3]['class'] = '其他';
    $linkSet[3]['items'] = $links3;    


	

    $tpl = new Smarty();
    
	$tpl->assign('linkSet',$linkSet);
	//well_print($linkSet);
	assignTemplate($tpl,'/other/links.tpl');
?>

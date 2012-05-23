<?
/*
DATE:   2007/04/03
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$CSS_PATH = $CSS_PATH;
	$absoluteURL = $HOMEURL . "EPaper/";
	


	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	//取得樣板編號
	$templateNumber = $_GET["templateNumber"];
	
	//本期主題
	$topic = "近年來隨著電腦科技與網際網路的應用蓬勃，數位學習的發展也日受重視。數位學習具有不受時間、空間限制的好處，必然成為現代快速變遷社會中的重要學習趨勢。為了讓大家瞭解學校在數位學習的發展現況及相關措施，並介紹一些好用的工具資源、課程實例，電算中心將不定期發行此電子報，希望有更多的老師一起來體會數位學習的樂趣！";

	//新聞數量
	$contentNumber = 2;
	
	//每個新聞的標題跟內容
	$titleList[0] = "The Passion of The Christ";
	$contentList[0] = "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Proin non mi in urna hendrerit tincidunt. Maecenas eleifend erat et lacus. Sed tempor. Sed venenatis consequat neque. Sed massa. Donec quis orci sed lacus ullamcorper venenatis. Nam et sapien. Sed id dolor in tortor eleifend aliquam. Mauris vulputate. Nulla nec diam et pede faucibus ornare.";
	
	$titleList[1] = "Finding Nemo";
	$contentList[1] = "Sed nec erat sed sem molestie congue. Cras lacus sapien, ultrices ac, mattis quis, lobortis eu, turpis. Aliquam egestas arcu a massa. In hendrerit odio eget lectus. Nullam iaculis ultricies ipsum. Nullam id felis. Phasellus at metus sed velit luctus semper.";
	
	//相關連結數量
	$releatedLinkNumber = 2;

	//相關聯結
	$releatedLinkNameList[0] = "連結1";
	$releatedLinkList[0] = "";
	
	$releatedLinkNameList[1] = "連結2";
	$releatedLinkList[1] = "";

	//設定電子報內容
	$tpl->assign("begin_course_name", "XXX課程");
	$tpl->assign("periodical_cd", "X");
	$tpl->assign("topic", $topic);
	$tpl->assign("titleList", $titleList);
	$tpl->assign("contentList", $contentList);
	$tpl->assign("releatedLinkNameList", $releatedLinkNameList);
	$tpl->assign("releatedLinkList", $releatedLinkList);

	//設定電子報圖片檔案位置
	$tpl->assign("imagePath", "");

	//設定電子報樣板
	switch($templateNumber)
	{
	case 1:	$web = assignTemplate($tpl, "/epaper/epaperSample1.tpl");	break;
	case 2:	$web = assignTemplate($tpl, "/epaper/epaperSample2.tpl");	break;
	default:$web = assignTemplate($tpl, "/epaper/epaperSample1.tpl");	break;
	}
	
?>

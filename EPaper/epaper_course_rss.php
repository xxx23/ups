<?
/*
DATE:   2007/04/04
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	$absoluteURL = $HOMEURL . "EPaper/";

	$personal_id = $_GET['personal_id'];
	$begin_course_cd = $_GET['begin_course_cd'];
	
	$isShowAll = 0;	//是否顯示所有電子報
	
	//設定檔案路徑
	$FILE_PATH = $COURSE_FILE_PATH . $begin_course_cd . "/EPaper/";
	
	
	
	//從Table e_paper搜尋這堂課的所有電子報
	$sql = "SELECT * FROM e_paper 
					WHERE 
						begin_course_no = $begin_course_cd 
					ORDER BY periodical_cd DESC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();
	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{			
			if($isShowAll==0 && $row[if_auto]=='N')	continue;
			else if($isShowAll==0 && (TIME_date(1) < substr($row[d_public_day], 0, 8)) )	continue;
			
			//設定檔案路徑
			$epaper_file_url = $FILE_PATH . $row[epaper_file_url];
			$tmp_epaper_file_url = $epaper_file_url;	
			$tmp_epaper_file_url = substr($tmp_epaper_file_url, 0, strrpos($tmp_epaper_file_url, "/"));
			$tmp_epaper_file_url = substr($tmp_epaper_file_url, 0, strrpos($tmp_epaper_file_url, "/"));
			$tmp_epaper_file_url = substr($tmp_epaper_file_url, 0, strrpos($tmp_epaper_file_url, "/"));
			$epaper_file_url = $RELEATED_PATH . substr($epaper_file_url, strrpos($tmp_epaper_file_url, "/")+1, strlen($epaper_file_url));	
		
			$epaperList[$rowCounter] = 
					array(
							"epaper_cd" => $row[epaper_cd], 
							"periodical_cd" => $row[periodical_cd], 
							"begin_course_no" => $row[begin_course_no],
							"d_public_day" => substr($row[d_public_day], 0, 10),
							"if_auto" => $row[if_auto],
							"topic" => $row[topic], 
							"d_create_day" => $row[d_create_day], 
							"epaper_file_url" => $epaper_file_url
							);
							
			$title = $row[topic];
			
			$link = $row[epaper_file_url];
			
			$description = "";
			
			$author = "";
			
			//$pubDate = "Tue, 03 Jun 2003 09:39:21 GMT";
			$pubDate = 	Time_format($row[d_public_day]);
			
			//$category = $courseName;
			$category = "";		
			
			$rssNewsList[$rowCounter] = 
						array(	
								"title" => $title, 
								"link" => $link,
								"description" => $description,
								"author" => $author,
								"pubDate" => $pubDate,
								"category" => $category 
								);
			
			$lastPubDate = $pubDate;
			
			$rowCounter++;
		}
	}
	
	$rss = new rss_generator("E-Learning Course Electronic Paper");
	$rss->__set("encoding", "UTF-8");
	$rss->__set("title", "E-Learning Course Electronic Paper");
	$rss->__set("language", "zh");
	$rss->__set("description", "E-Learning Course Electronic Paper");
	$rss->__set("pubDate", $lastPubDate);
	$rss->__set("link", $HOMEURL);
	$xml = $rss->get($rssNewsList);
	echo $xml;
	
/*
	$fileName = "rss.xml";
	$filePtr = fopen($fileName, "w");
	fwrite($filePtr, $xml);
	fclose($filePtr);
	
	//將檔案傳給使用者下載
	// set the content as sql
	header("Content-type: text/xml; charset=UTF-8"); 
	
	// tell the thing the filesize
	header("Content-Length: " . filesize($fileName));
	
	// set it as an attachment and give a file name
	header("Content-Disposition: attachment; filename=\"" . $fileName . "\"");

	header("Content-Transfer-Encoding: UTF-8\n");
	
	// read into the buffer
	readfile($fileName);

	//刪除檔案
	unlink($fileName);
*/
?>

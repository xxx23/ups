<?
/*
DATE:   2007/03/27
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	$absoluteURL = $HOMEURL . "System_News/";

	$personal_id = $_GET['personal_id'];
	$student_cd = $personal_id;
	
	$isShowCourse = 1;	//是否顯示課程

	//搜尋所有課堂的公告
	$sql = "SELECT A.*, D.begin_course_name FROM news A, news_target B, take_course C, begin_course D WHERE C.personal_id = (?) AND C.begin_course_cd = B.begin_course_cd AND B.role_cd = 01 AND A.news_cd = B.news_cd AND C.begin_course_cd = D.begin_course_cd ORDER BY A.d_news_begin DESC, A.news_cd DESC";
	$data = array($personal_id);
	$res = $DB_CONN->query($sql, $data);
	if (PEAR::isError($res))	die($res->getMessage());
	
	$newsNum = $res->numRows();
	
	if($newsNum > 0){
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			//公告編號
			$news_cd = $row[news_cd];
			
			//公告標題
			$subject = $row[subject];
			
			//公告內容
			$content = $row[content];
			if($row[content] != "")	$showContent = 1;
			else					$showContent = 0;
			
			//課程名稱
			$courseName = $row[begin_course_name];
			
			$type = $row[if_news];
			if($type == 2 || $type ==3)//時限性跟週期性公告
			{
				//判斷公告是否過期
				$endDate = str_replace('-', '', $row[d_news_end]); 
				$endDate = substr($endDate, 0, 8);

				//公告已經過期
				if(TIME_date(1) > $endDate)	continue;
			}
			if($type == 3)//週期性公告
			{
				//year
				$cycleYear = substr($row[d_cycle], 0, 4);
				if($cycleYear != '0000' && $cycleYear != TIME_year())	continue;
				
				//month
				$cycleMonth = substr($row[d_cycle], 4, 2);
				if($cycleMonth != '00' && $cycleMonth != TIME_month())	continue;

				//day
				$cycleDay = substr($row[d_cycle], 6, 2);
				if($cycleDay != '00' && $cycleDay != TIME_day())	continue;

				//week
				$cycleWeek = $row[week_cycle];
				if($cycleWeek != '00' && $cycleWeek != TIME_week())	continue;
			}
			
			//處理date
			$d_news_begin = $row[d_news_begin];
			$date = str_replace('-', '', $row[d_news_begin]); 
			$date = substr($date, 0, 8);
			
			//判斷是否開始公告
			if(TIME_date(1) < $date)	continue;	//還未到公告日期
			
			//3天內為最新公告
			if(TIME_date(1) <= ($date + 2))	$new = 1;
			else	$new = 0;
			
			//處理important
			if($row[important] == 0)	$level = "最低";
			else if($row[important] == 1)	$level = "中等";
			else if($row[important] == 2)	$level = "最高";
			else	$level = "其它等級";

			//觀看次數
			$viewNum = $row[frequency];
			
			
			//從Table news_upload取出資料
			$resContent = $DB_CONN->query("SELECT * FROM news_upload WHERE news_cd = $news_cd ORDER BY file_cd ASC");
			if (PEAR::isError($resContent))	die($resContent->getMessage());

			$newsContentNum = $resContent->numRows();
			if($newsContentNum > 0)
			{
				while($resContent->fetchInto($rowContent, DB_FETCHMODE_ASSOC))
				{
					if($rowContent[if_url] == 0)//檔案
					{
						$showFile = 1;
						$fileName = $rowContent[file_name];
						
						//設定檔案路徑
						$fileUrl = $rowContent[file_url];
						$tmp_fileUrl = $fileUrl;	
						$tmp_fileUrl = substr($tmp_fileUrl, 0, strrpos($tmp_fileUrl, "/"));
						$tmp_fileUrl = substr($tmp_fileUrl, 0, strrpos($tmp_fileUrl, "/"));
						$tmp_fileUrl = substr($tmp_fileUrl, 0, strrpos($tmp_fileUrl, "/"));
						$fileUrl = $RELEATED_PATH . substr($fileUrl, strrpos($tmp_fileUrl, "/")+1, strlen($fileUrl));
					
					}
					else if($rowContent[if_url] == 1)//網址
					{
						$showUrl = 1;
						$url = $rowContent[file_url];
					}
				}
			}

			$title = $subject;
			
			//IE7在處理link時,如果後面有兩個以上的參數(使用到符號&),會出錯,所以將所有參數變成一個字串參數就不會有問題
			$link = "systemNews_show_rss.php?argument=" . $news_cd . "_" . $personal_id . "_" . $isShowCourse . "_";
			
			$description = $content;
			
			$author = "";
			
			//$pubDate = "Tue, 03 Jun 2003 09:39:21 GMT";
			$pubDate = 	Time_format($d_news_begin);
			
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

	$rss = new rss_generator("E-Learning Student Announcement");
	$rss->__set("encoding", "UTF-8");
	$rss->__set("title", "E-Learning Student Announcement");
	$rss->__set("language", "zh");
	$rss->__set("description", "E-Learning Student Announcement");
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

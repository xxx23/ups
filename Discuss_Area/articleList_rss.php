<?
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");	
	$absoluteURL = $HOMEURL . "Discuss_Area/";

	session_start();
	$personal_id = $_GET['personal_id'];			//取得個人編號
	$begin_course_cd = $_GET['begin_course_cd'];	//取得課程代碼
	$discuss_cd = $_GET['discuss_cd'];				//取得討論區編號	


	//從Table discuss_subject搜尋所有的文章, 並依照discuss_content_cd做排序
	$sql = "SELECT * FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd ORDER BY discuss_content_cd DESC";

	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	
	$articleNum = $res->numRows();	
	
	if($articleNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$articleData[$rowCounter] = $row;
			
			$rowCounter++;
		}
		$articleDataNumber = $rowCounter;
		
		
		$articleListCounter = 0;
		$articleListNumber = 0;
		for($articleDataCounter = 0; $articleDataCounter<$articleDataNumber; $articleDataCounter++)
		{
		
			$author_personal_id_tmp = $articleData[$articleDataCounter][discuss_author];
			
			//從Table personal_basic尋找作者的名子或是暱稱
			$sql = "SELECT * FROM personal_basic WHERE personal_id=$author_personal_id_tmp";
			$res = $DB_CONN->query($sql);
			if(PEAR::isError($res))	die($res->getMessage());
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			if($row[nickname] != "")
			{
				$author = $row[nickname];
			}
			else
			{
				$author = $row[student_name];
			}
			
			//將資料填入articleList中
			$articleList[$articleListCounter++] = 
					array(
							"discuss_content_cd" => $articleData[$articleDataCounter][discuss_content_cd], 
							"discuss_title" => $articleData[$articleDataCounter][discuss_title], 
							"discuss_author" => $author, 
							"viewed" => $articleData[$articleDataCounter][viewed], 
							"reply_count" => $articleData[$articleDataCounter][reply_count],
							"d_created" => $articleData[$articleDataCounter][d_created], 
							"d_replied" => $articleData[$articleDataCounter][d_replied]
							);

							
			$title = $articleData[$articleDataCounter][discuss_title];

			
			//IE7在處理link時,如果後面有兩個以上的參數(使用到符號&),會出錯,所以將所有參數變成一個字串參數就不會有問題
			$discuss_content_cd = $articleData[$articleDataCounter][discuss_content_cd];
			$reply_content_cd = 1;
			$link = "showArticle_rss.php?argument=$personal_id_" . $begin_course_cd . "_" . $discuss_cd . "_" . $discuss_content_cd . "_" . $reply_content_cd . "_";


			
			$description = "";
			
			$author = "";
			
			//$pubDate = "Tue, 03 Jun 2003 09:39:21 GMT";
			$pubDate = 	Time_format($articleData[$articleDataCounter][d_created]);
			
			//$category = $courseName;
			$category = "";		
			
			$rssNewsList[$articleDataCounter] = 
						array(	
								"title" => $title, 
								"link" => $link,
								"description" => $description,
								"author" => $author,
								"pubDate" => $pubDate,
								"category" => $category 
								);
			
			$lastPubDate = $pubDate;
		}
		$articleListNumber = $articleListCounter;

	}

	$rss = new rss_generator("E-Learning Course Disscuss Area Article List");
	$rss->__set("encoding", "UTF-8");
	$rss->__set("title", "E-Learning Course Disscuss Area Article List");
	$rss->__set("language", "zh");
	$rss->__set("description", "E-Learning Course Disscuss Area Article List");
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

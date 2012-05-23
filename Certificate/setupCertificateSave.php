<?
/*
DATE:   2007/10/19
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "Certificate/";
	
	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_POST['begin_course_cd'];		//取得課程編號

	$credential_type_cd = 1;							//證書形式編號

	$outerType = $_POST['outerType'];					//取得外框類型
	$outerTemplateNumber = $_POST['outerTemplateNumber'];//取得外框樣式編號
	$outerFile = $_POST['outerFile'];					//取得外框檔案
	
	$backgroundType = $_POST['backgroundType'];			//取得浮水印類型
	$backgroundFile = $_POST['backgroundFile'];			//取得浮水印檔案
	
	$content1 = $_POST['content1'];						//取得證書內容
	$content2 = $_POST['content2'];						//取得證書內容
	$content3 = $_POST['content3'];						//取得證書內容
	
	//設定檔案儲存路徑
	$FILE_PATH = $COURSE_FILE_PATH . $begin_course_cd . "/Certificate/";
	if(is_dir($FILE_PATH) == FALSE){	mkdir($FILE_PATH);	chmod($FILE_PATH, 0755);	}
	
	//儲存外框的圖片
	$newOuterFileName = $begin_course_cd . "_outer.jpg";	//檔案名稱:課程編號_outer
	$newOuterFilePath = $FILE_PATH . $newOuterFileName;
	switch($outerType)
	{
	case -1://使用原樣式
			break;
			
	case 1:	//使用內建樣式
	
			//將外框圖片從資料夾images複製一份到資料夾file
			$oldOuterFilePath = "images/simple" . $outerTemplateNumber . ".jpg";
			
			copy($oldOuterFilePath, $newOuterFilePath);

			break;
			
	case 2:	//自行上傳樣式
			
			if($_FILES['outerFile']['tmp_name'] != "")
			{
				//上傳檔案到Server
				if( FILE_upload($_FILES['outerFile']['tmp_name'], $FILE_PATH, $newOuterFileName) == false)
				{	
					echo "FILE_upload fail";
				}
			}
		
			break;
			
	default:break;
	}
	
	
	//儲存浮水印的圖片
	$newBackgroundFileFileName = $begin_course_cd . "_background.jpg";	//檔案名稱:課程編號__background
	$newBackgroundFilePath = $FILE_PATH . $newBackgroundFileFileName;
	switch($backgroundType)
	{
	case -1://使用原樣式
			break;
			
	case 0:	//不使用浮水印
			break;
			
	case 1:	//使用浮水印
	
			if($_FILES['backgroundFile']['tmp_name'] != "")
			{
				//上傳檔案到Server
				if( FILE_upload($_FILES['backgroundFile']['tmp_name'], $FILE_PATH, $newBackgroundFileFileName) == false)
				{	
					echo "FILE_upload fail";
				}
			}
			
			break;
			
	default:break;
	}
	
		
	//將證書內容變成ㄧ行一行存起來
	for($contextCounter = 1; $contextCounter<=3; $contextCounter++)
	{
		$contextName = "content" . $contextCounter;
		$contentListCounter = 0;
		
		$tok = strtok($$contextName, "\n");
		while ($tok !== false) {
			$contentList[$contextCounter][$contentListCounter++] = $tok;
			$tok = strtok("\n");
		}
		
		$contentListNum[$contextCounter] = $contentListCounter;
	}	

//將資料庫的資料刪除
//********************************************************************************
//********************************************************************************
//********************************************************************************
//********************************************************************************	
//********************************************************************************

	//Table credential_type
	$sql = "DELETE FROM credential_type WHERE credential_type_cd=$credential_type_cd AND begin_course_no=$begin_course_cd";	
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	//Table credential_content
	$sql = "DELETE FROM credential_content WHERE credential_type_cd=$credential_type_cd AND begin_course_no=$begin_course_cd";	
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());

//將資料儲存到資料庫
//********************************************************************************
//********************************************************************************
//********************************************************************************
//********************************************************************************	
//********************************************************************************

	//取得目前時間
	$currentTime = TIME_date(1) . TIME_time(1);
	
	$d_create_day = $currentTime;
	$sash_template_no = $newOuterFilePath;
	if($backgroundType == 0)	$emboss_no2 = "";
	else						$emboss_no2 = $newBackgroundFilePath;
	
	//新增資料到Table credential_type 
	$sql = "INSERT INTO credential_type 
				( 
					credential_type_cd, 
					begin_course_no, 
					d_create_day, 
					sash_template_no, 
					emboss_no2
				) VALUES (
					$credential_type_cd, 
					$begin_course_cd, 
					'$currentTime', 
					'$sash_template_no', 
					'$emboss_no2'
				)";
	db_query($sql);
	
	
	for($i=1; $i<=3; $i++)
	{
		$credential_id = $i;
		$seq_no = $credential_id;
		
		
		$tempName = "content" . $i;
		$content = $$tempName;
				
		
		//新增資料到Table credential_content 
		$sql = "INSERT INTO credential_content 
					( 
						credential_type_cd, 
						begin_course_no, 
						credential_id, 
						content, 
						seq_no
					) VALUES (
						$credential_type_cd, 
						$begin_course_cd, 
						$credential_id, 
						'$content', 
						$seq_no
					)";
		db_query($sql);
	}
	
//產生PDF
//********************************************************************************
//********************************************************************************
//********************************************************************************
//********************************************************************************	
//********************************************************************************

	//到資料庫抓取本課程的課程名稱
	$sql = "SELECT 
				* 
			FROM 
				begin_course 
			WHERE 
				begin_course_cd=$begin_course_cd
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	
	if($res->numRows() > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		
		$courseName = $row[begin_course_name];
	}
	else
	{
		$courseName = "";
	}

	$pdf = new PDF_Chinese();
	$pdf->AddBig5Font();
	
	$oneStringWidth = 3.1;
	$cellHigh = 10;
	
	$pdf->AddPage();
	
	//印出外框
	$pdf->Image($newOuterFilePath, 0, 0, 200, 300);
	
	//印出浮水印
	if($backgroundType != 0)	$pdf->Image($newBackgroundFilePath, 25, 70, 150, 180);
	
	$pdf->SetFillColor(180, 180, 180); 
	$pdf->SetFont('Big5','',25);
	
	//內容左邊縮排
	$leftIndent = 20;
	
	//目前在第幾行
	$pdfCurrentLine = 1;
	
	//填補空行在上面
	while($pdfCurrentLine < 7){	$pdf->Cell(1, $cellHigh);	$pdf->LN();	$pdfCurrentLine++;	}
	
	//印出內容
	for($contextCounter = 1; $contextCounter<=3; $contextCounter++)
	{
		$contextNumber = 1;
		for($contentListCounter=0; $contentListCounter<$contentListNum[$contextCounter]; $contentListCounter++)
		{
			//先填補空白在左邊
			$pdf->Cell($leftIndent);
			
			$word = $contentList[$contextCounter][$contentListCounter];
			
			//修改動態資料
			$word = str_replace("%NAME", "學員名稱", $word);
			$word = str_replace("%COURSE", $courseName, $word);
			
			//印出某一行的文字
			//一個中文字, strlen = 3
			if( ($contentListCounter+1) < $contentListNum[$contextCounter])
			{
				$cellWidth = (strlen($word)-1) * $oneStringWidth;
				//echoData(strlen($word)-1);	//for test
			}
			else
			{
				$cellWidth = strlen($word) * $oneStringWidth;
				//echoData(strlen($word));	//for test
			}
			
			$pdf->Cell($cellWidth, $cellHigh, iconv("UTF-8", "big5", $word), "", 0, 'C');	//TBL:Top, Buttom, Left
			
			//換行
			$pdf->LN();	$pdfCurrentLine++;
		}	
		
		//跳到某一行
		switch($contextCounter)
		{
		case 1:
				while($pdfCurrentLine < 12){	$pdf->Cell(1, $cellHigh);	$pdf->LN();	$pdfCurrentLine++;	}
				break;
		case 2:
				while($pdfCurrentLine < 17){	$pdf->Cell(1, $cellHigh);	$pdf->LN();	$pdfCurrentLine++;	}
				break;
		default:
				break;
		}
	}


	//自動帶出今天日期
	while($pdfCurrentLine < 26){	$pdf->Cell(1, $cellHigh);	$pdf->LN();	$pdfCurrentLine++;	}	
	$pdf->Cell(73, $cellHigh, iconv("UTF-8", "big5", " "), "", 0, 'C');
	$word = TIME_year();
	$pdf->Cell(15, $cellHigh, iconv("UTF-8", "big5", $word), "", 0, 'C');	//TBL:Top, Buttom, Left
	$pdf->Cell(9, $cellHigh, iconv("UTF-8", "big5", " "), "", 0, 'C');
	$word = TIME_month();
	$pdf->Cell(15, $cellHigh, iconv("UTF-8", "big5", $word), "", 0, 'C');	//TBL:Top, Buttom, Left
	$pdf->Cell(9, $cellHigh, iconv("UTF-8", "big5", " "), "", 0, 'C');
	$word = TIME_day();
	$pdf->Cell(15, $cellHigh, iconv("UTF-8", "big5", $word), "", 0, 'C');	//TBL:Top, Buttom, Left
	
	
	//輸出PDF
	$pdf->Output();	
?>

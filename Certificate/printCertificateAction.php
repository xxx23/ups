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
	
	$studentNum = $_POST['studentNum'];					//取得學生數目
	
	
	//取得要列印的學生
	$studentListCounter = 0;
	for($studentCounter=0; $studentCounter<=$studentNum; $studentCounter++)
	{
		$nameTmp = "print_" . ($studentCounter+1);		
		$print = $_POST[$nameTmp];						//取得參數
		
		//判斷是否有要列印
		if(isset($print) == true)
		{
			$nameTmp = "id_" . ($studentCounter+1);		
			$id = $_POST[$nameTmp];						//取得參數
			
			$studentList[$studentListCounter++] = $id;
		}
	}
	$studentListNum = $studentListCounter;
	
	

//到資料庫抓取相關資料
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


	//到資料庫抓取證書資料
	$credential_type_cd = 1;
	
	$sql = "SELECT 
				* 
			FROM 
				credential_type 
			WHERE 
				credential_type_cd=$credential_type_cd AND 
				begin_course_no=$begin_course_cd
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	
	if($res->numRows() > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		
		$newOuterFilePath = $row[sash_template_no];
		$newBackgroundFilePath = $row[emboss_no2];
		if($newBackgroundFilePath == "")	$backgroundType = 0;	
		else								$backgroundType = 1;
	}
	else
	{
		echo "Error !!!";
		exit();
	}



	//從Table credential_content取得證書內容
	$sql = "SELECT 
				* 
			FROM 
				credential_content 
			WHERE 
				credential_type_cd=$credential_type_cd AND 
				begin_course_no=$begin_course_cd 
			ORDER BY 
				seq_no
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();
	
	if($resultNum >=3)
	{
		$rowCounter = 0;
		
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		$content1 = $row[content];							//取得證書內容
		
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		$content2 = $row[content];							//取得證書內容
		
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		$content3 = $row[content];							//取得證書內容
	}
	else
	{
		echo "Error !!!";
		exit();
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

//產生PDF
//********************************************************************************
//********************************************************************************
//********************************************************************************
//********************************************************************************	
//********************************************************************************

	$pdf = new PDF_Chinese();
	$pdf->AddBig5Font();
	
	$tableWidthListCounter = 0;
	
	$oneStringWidth = 3.1;
	$cellHigh = 10;	
	
	//產生每個學員的證書
	for($studentListCounter=0; $studentListCounter<$studentListNum; $studentListCounter++)
	{
		$student_id = $studentList[$studentListCounter];
		
		//到資料庫抓取學生名稱
		$sql = "SELECT 
					* 
				FROM 
					personal_basic 
				WHERE 
					personal_id=$student_id
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		$resultNum = $res->numRows();

		if($resultNum > 0)
		{
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			
			$studentName = $row[personal_name];
		}
		else
		{
			$studentName = "";
		}
		
		//產生一頁
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
				$word = str_replace("%NAME", $studentName, $word);
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
				
				$pdf->Cell($cellWidth, $cellHigh, iconv("UTF-8", "big5", $word), "", 0, 'C');	//TBLR:Top, Buttom, Left, Right
				
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
		$pdf->LN();	$pdfCurrentLine++;
		
	}
	
	//輸出PDF
	$pdf->Output();	

?>

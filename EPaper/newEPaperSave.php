<?
/*
DATE:   2007/03/31
AUTHOR: 14_���ӷQ��
*/
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
    require_once($RELEATED_PATH . "session.php");
    require_once($RELEATED_PATH . "library/filter.php"); // by carl
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$CSS_PATH = $CSS_PATH;
	$absoluteURL = $HOMEURL . "EPaper/";	
	
	session_start();
	$personal_id = $_SESSION['personal_id'];			//���o�ӤH�s��
	$role_cd = $_SESSION['role_cd'];					//���o����
	$begin_course_cd = $_SESSION['begin_course_cd'];	//���o�ҵ{�N�X
	
	if($role_cd == 0)//�t�κ޲z��
	{
		$begin_course_cd = -1;
	}
	
    $FILE_PATH = $COURSE_FILE_PATH . $begin_course_cd;
    if(is_dir($FILE_PATH) == FALSE){	createPath($FILE_PATH);}
    $FILE_PATH = $FILE_PATH . "/EPaper/";
	if(is_dir($FILE_PATH) == FALSE){	createPath($FILE_PATH);}

	
	
	//���o�O�_�۰ʵo�e�q�l��
	$if_auto = $_POST["if_auto"];
	
	if($if_auto == 'Y')
	{
		//���o�۰ʵo�e���
		$startYear = $_POST["startYear"];
		$startMonth = $_POST["startMonth"];
		$startDay = $_POST["startDay"];
		$d_public_day = $startYear . $startMonth . $startDay;
	}
	else
	{
		$d_public_day = "00000000";
	}
	
	//���o�ҵ{�W��
	$sql = "SELECT * FROM begin_course WHERE begin_course_cd=$begin_course_cd";
	$res = db_query($sql);
	$res->fetchInto($row, DB_FETCHMODE_ASSOC);
	$begin_course_name = $row[begin_course_name];
	

	//�qTable e_paper���o�s��periodical_cd���Z�s��
	$sql = "SELECT * FROM e_paper WHERE begin_course_no=$begin_course_cd ORDER BY periodical_cd DESC";
	$res = db_query($sql);

	$periodicalNum = $res->numRows();
	if($periodicalNum == 0)
	{
		$periodical_cd = 1;
	}
	else
	{	
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
	
		$periodical_cd = $row[periodical_cd] + 1;
	}
	//echo $periodical_cd;//for test
	

	
	//���o��J����
	$inputType = $_POST["inputType"];

	if($inputType == 1)
	{
		//���o�q�l���˦��s��
		$templateNumber = $_POST["templateNumber"];
	
		//���o�����D�D
		$topic = $_POST["topic"];
	
		//���o�s�D�ƶq
		$contentNumber = $_POST["contentNumber"];
		
		//���o�C�ӷs�D�����D�򤺮e
		for($contentCounter=0; $contentCounter<$contentNumber; $contentCounter++)
		{
			$titleList[$contentCounter] = $_POST["title" . ($contentCounter+1)];
			$contentList[$contentCounter] = nl2br( $_POST["content" . ($contentCounter+1)] );
		}
		
		//���o�����s���ƶq
        $releatedLinkNumber = $_POST["releatedLinkNumber"];
        //$releatedLinkNumber = required_param("releatedLinkNumber", PARAM_INT);

		//���o�����p��
        $releated_link = "";
        //$releatedLinkNameList = Array();
        //$releatedLinkList = Array();
		for($releatedCounter=0; $releatedCounter<$releatedLinkNumber; $releatedCounter++)
		{
            $releatedLinkNameList[$releatedCounter] = $_POST["releatedLinkName" . ($releatedCounter+1)];
			$releatedLinkList[$releatedCounter] = $_POST["releatedLink" . ($releatedCounter+1)];
			$releated_link = $releated_link . $releatedLinkNameList[$releatedCounter] . ";" . $releatedLinkList[$releatedCounter] . ";";
		}
		//$tpl = new Smarty;
        require_once($HOME_PATH . 'library/smarty_init.php');
        $tpl->assign("imagePath", $IMAGE_PATH);
		$tpl->assign("cssPath", $CSS_PATH);
		$tpl->assign("absoluteURL", $absoluteURL);
	
		//�]�w�q�l�����e
		$tpl->assign("begin_course_name", $begin_course_name);
		$tpl->assign("periodical_cd", $periodical_cd);
		$tpl->assign("topic", $topic);
		$tpl->assign("titleList", $titleList);
		$tpl->assign("contentList", $contentList);
		$tpl->assign("releatedLinkNameList", $releatedLinkNameList);
		$tpl->assign("releatedLinkList", $releatedLinkList);
        
        //carl
        //$tpl->assign("releatedLinkNumber", $releatedLinkNumber);
	    //$tpl->assign("releated_link", $releated_link);

		//�]�w�q�l���Ϥ��ɮצ�m
		$tpl->assign("imagePath", $HOMEURL . "/EPaper/");
	
		//�]�w�q�l���˪O
		switch($templateNumber)
		{
		case 1:	$web = fetchTemplate($tpl, "/epaper/epaperSample1.tpl");	break;
		case 2:	$web = fetchTemplate($tpl, "/epaper/epaperSample2.tpl");	break;
		default:$web = fetchTemplate($tpl, "/epaper/epaperSample1.tpl");	break;
		}
	}
	else if($inputType == 2)
	{		
		//���o�q�l�����e
		$web = $_POST["web"];
	}
	else if($inputType == 3)
	{

	}


	
	
	//�qTable e_paper���o�s��epaper_cd�q�l���s��
	$sql = "SELECT * FROM e_paper ORDER BY epaper_cd DESC";
	$res = db_query($sql);

	$epaperNum = $res->numRows();
	if($epaperNum == 0)
	{
		$epaper_cd = 1;
	}
	else
	{	
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
	
		$epaper_cd = $row[epaper_cd] + 1;
	}
	//echo $epaper_cd;//for test
	
	
	
	if(($inputType == 1) || ($inputType == 2))
	{
		//�N�q�l���s���ɮ�
		$fileName = $epaper_cd . ".html";
		$filePtr = fopen($FILE_PATH . $fileName, "w");
		fwrite($filePtr, $web);
		fclose($filePtr);
		
		//�]�w�q�l�����}
		$epaper_file_url = $fileName;
	}
	else if($inputType == 3)
	{
		//���ɮ׭n�W��
		if($_FILES['file']['tmp_name'] != "")
		{
			$fileName = $epaper_cd . ".html";
			
			//�W���ɮר�Server
			if( FILE_upload($_FILES['file']['tmp_name'], $FILE_PATH, $fileName) == false)
			{	
				echo "FILE_upload fail";
			}
		}
		
		//�]�w�q�l�����}
		$epaper_file_url = $fileName;
	}
	

	//�s�W��ƨ�Table e_paper	
	$d_create_day = TIME_date(1) . TIME_time(1);	
	$sql = "INSERT INTO e_paper 
						(
							epaper_cd, 
							periodical_cd, 
							begin_course_no, 
							d_public_day, 
							if_auto, 
							topic, 
							releated_link, 
							d_create_day, 
							epaper_file_url
						) VALUES (
							$epaper_cd, 
							$periodical_cd,
							$begin_course_cd, 
							$d_public_day, 
							'$if_auto', 
							'$topic', 
							'$releated_link', 
							$d_create_day, 
							'$epaper_file_url'
						)";
	$sth = $DB_CONN->prepare($sql);
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	

	if($inputType == 1)
	{
		for($contentCounter=0; $contentCounter<$contentNumber; $contentCounter++)
		{
			$titleList[$contentCounter] = $_POST["title" . ($contentCounter+1)];
			$contentList[$contentCounter] = nl2br( $_POST["content" . ($contentCounter+1)] );
			
			//�s�W��ƨ�Table course_epaper
			$sql = "INSERT INTO course_epaper 
								(
									epaper_cd, 
									epaper_id, 
									title, 
									content
								) VALUES (
									$epaper_cd, 
									" . ($contentCounter+1) . ",
									'$titleList[$contentCounter]', 
									'$contentList[$contentCounter]'
								)";
			$sth = $DB_CONN->prepare($sql);
			$res = $DB_CONN->execute($sth);
			if (PEAR::isError($res))	die($res->getMessage());
		}
	}

	//�]�w�ɮ׸��|
	$url = $COURSE_FILE_PATH . $begin_course_cd . "/EPaper/";
	$url_FILE_PATH = $url;	
	$url_FILE_PATH = substr($url_FILE_PATH, 0, strrpos($url_FILE_PATH, "/"));
	$url_FILE_PATH = substr($url_FILE_PATH, 0, strrpos($url_FILE_PATH, "/"));
	$url_FILE_PATH = substr($url_FILE_PATH, 0, strrpos($url_FILE_PATH, "/"));
	$url = $RELEATED_PATH . substr($url, strrpos($url_FILE_PATH, "/")+1, strlen($url));

	header("location: " . $url . $epaper_file_url);
?>

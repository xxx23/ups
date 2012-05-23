<?php
/*
DATE:   2007/01/17
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");

	
	$news_cd = $_POST['news_cd'];
    if($news_cd == '')
        return ;    
	//從Table news取出資料
	$res = $DB_CONN->query("SELECT * FROM news WHERE news_cd = $news_cd");
	if (PEAR::isError($res))	die($res->getMessage());
	
	$newsNum = $res->numRows();
	if($newsNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);

		$viewNum = $row[frequency];
		
		//增加瀏覽的次數
		$viewNum++;
		$sth = $DB_CONN->prepare("UPDATE news SET frequency = (?) WHERE news_cd = (?)");
		$data = array($viewNum, $news_cd);
		$DB_CONN->execute($sth, $data);
	}
    $return_array = array('news_cd'=>$news_cd, 'viewNum'=>$viewNum ) ; 

	//產生AJAX Reponse , 改傳json
    /*
    $response = 
			"<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>
			<response>
				<news_cd>$news_cd</news_cd>
				<viewNum>$viewNum</viewNum>
			</response>";
	
	header('Content-Type: text/xml');
    
    echo $response;	*/
	header('Content-Type: text/html');
    $return_data = json_encode($return_array);
    echo $return_data; 
    //file_put_contents("test", $return_data) ;
?>

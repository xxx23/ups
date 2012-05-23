<?php
	/*author: lunsrot
	 * date: 2007/06/18
	 */
	require_once("../config.php");
	require_once("../session.php");

	global $COURSE_FILE_PATH, $HOME_PATH, $WEBROOT;
	$input = $_GET;
	$course_cd = $_SESSION['course_cd'];
	//無論存在與否都會產生需要的路徑
	file_path($course_cd);
	//開啓檔案，寫入資料
	$path = $COURSE_FILE_PATH . $course_cd . "/survey/" . $input['survey_no'] . ".xls";
	$file = fopen($path, "w");
	exec("chmod 664 " . $path);
	write_data($file, $input['survey_no']);
	fclose($file);
	//下載檔案
	$path = substr($WEBROOT, 0, -1) . substr($path, (strlen($path) - strlen($HOME_PATH) + 1) * -1);
	header("location:" . $path);

	function write_data($file, $no){
		global $DB_CONN;
		//問卷名稱
		$sur_name = $DB_CONN->getOne("select survey_name from `online_survey_setup` where survey_no=$no;");
		fputs($file, iconv("UTF-8", "Big5", $sur_name."\n\n"));
		$result = db_query("select * from `online_survey_content` where survey_no=$no and block_id=0 order by sequence;");
		while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
			fputs($file, iconv("UTF-8", "Big5", $row['question']."\n"));
			if($row['survey_type'] == 2)
			  comments($file, $no, $row['survey_cd']);
			else if($row['is_multiple'] == 1)
			  multiple($file, $no, $row['survey_cd'], $row);
			else
			  single($file, $no, $row['survey_cd'], $row);
			fputs($file, iconv("UTF-8", "Big5", "\n"));
		}

		detail($file,$no);
	}

	//add by q10185 2010/01/28
	function detail($file, $no)
	{
	  	$result = db_query("SELECT * FROM online_survey_content WHERE survey_no=$no ORDER BY sequence");

		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
		  $questions[]=$row;
		}

		$result = db_query("SELECT OS.personal_id, OS.response_no, OSR.survey_cd, OSR.response, OSR.grade
		  		    FROM online_survey OS,online_survey_response OSR 
				    WHERE OS.survey_no = '$no' 
				    AND OS.response_no = OSR.response_no");
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
		  $surveys[$row['response_no']][$row['survey_cd']] = $row;
		  $surveys[$row['response_no']]['personal_id'] = $row['personal_id'];
		 
		}
		foreach($surveys as $survey)
		{
		  	if($survey['personal_id']!=-1)
			{
			  $personal_name = db_getPersonalName($survey['personal_id']);
			  fputs($file, iconv("UTF-8","Big5","受測者\t".$personal_name."\n"));
			}else
			  fputs($file, iconv("UTF-8","Big5","受測者\t不記名\n"));

			foreach($questions as $question)
			{
			  	fputs($file,iconv("UTF-8","Big5",$question['question']));
				$index = (int)$question['block_id']-1;
				if($question['block_id']==0){
				  fputs($file,iconv("UTF-8","Big5","\n"));
				  if($question['survey_type']==1){
				  	for($i=1; $i <= $question["selection_no"]; $i++)
				  	{
				   	fputs($file,iconv("UTF-8","Big5","\t".$question["selection".$i]));
					}
				  	fputs($file,iconv("UTF-8","Big5","\n"));
				  }
				}
				else if($questions[$index]['survey_type'] == 2)
				{
				  fputs($file,iconv("UTF-8","Big5","\n"));
				  fputs($file,iconv("UTF-8","Big5","\t".$survey[ $question['survey_cd'] ]['response']."\n"));				  
				}
				else if($questions[$index]['is_multiple']==1)
				{
				  
				  $selections = split(";",$survey[$question['survey_cd']]['response']);
				  $responses = array();
				  $response = null;
			 	  for($i=0; $i < $questions[$index]["selection_no"]; $i++)
				  {
				    	$responses[$i] = 0;
				  }

				  foreach($selections as $selection)
				  {
				    if(!empty($selection)){
				    	$selection = (int)$selection;
				    	$responses[$selection-1]=1;
				    }
				  }
				  //well_print($responses);
				  fputs($file,iconv("UTF-8","Big5","\t".implode("\t",$responses)."\n"));
				}
				else 
				{
				  $responses=array();
				  $response = null;
				  for($i=0; $i < $questions[$index]["selection_no"]; $i++)
				  {
				    	$responses[$i] = 0;
				  }
				  $selection = (int)$survey[$question['survey_cd']]['response'];
				  $responses[$selection-1] = 1;
				  fputs($file,iconv("UTF-8","Big5","\t".implode("\t",$responses)."\n"));
				  //well_print($responses);
				
				}
			}
			fputs($file,iconv("UTF-8","Big5","\n"));
		}
	}
	function comments($file, $no, $cd){
		$result = db_query("select question, survey_cd from `online_survey_content` where survey_no=$no and block_id=$cd order by sequence;");
		while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
			fputs($file, iconv("UTF-8", "Big5", $row['question']."\n"));
			$res = db_query("select response from `online_survey_response` A, `online_survey` B where B.survey_no=$no and A.response_no=B.response_no and A.survey_cd=$row[survey_cd];");
			while(($row2 = $res->fetchRow(DB_FETCHMODE_ASSOC)) != false)
			  fputs($file, iconv("UTF-8", "Big5", "\t" . $row2['response'] . "\n"));
		}
	}

	function multiple($file, $no, $cd, $data){
		$result = db_query("select question, survey_cd from `online_survey_content` where survey_no=$no and block_id=$cd order by sequence;");
		fputs($file, iconv("UTF-8", "Big5", "\t"));
		for($i = 1 ; $i <= $data['selection_no'] ; $i++)
		  	fputs($file, iconv("UTF-8", "Big5", $data['selection'.$i]."\t"));
		fputs($file, iconv("UTF-8", "Big5", "\n"));
		while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
		  	$num = "";
		  	fputs($file, iconv("UTF-8", "Big5", $row['question']."\t"));
			$res = db_query("select response from `online_survey_response` A, `online_survey` B where B.survey_no=$no and A.response_no=B.response_no and A.survey_cd=$row[survey_cd];");
			while(($row2 = $res->fetchRow(DB_FETCHMODE_ASSOC)) != false){
				$num = calMulti($row2['response'], $data['selection_no'], $num);
			}
			for($i = 1 ; $i <= $data['selection_no'] ; $i++){
			  	if($num[$i] == "")
				  $num[$i] = 0;
			 	 fputs($file, iconv("UTF-8", "Big5", $num[$i]."\t"));
			}
			fputs($file, iconv("UTF-8", "Big5", "\n"));
		}
	}

	function single($file, $no, $cd, $data){
		$result = db_query("select question, survey_cd from `online_survey_content` where survey_no=$no and block_id=$cd order by sequence;");
		fputs($file, iconv("UTF-8", "Big5", "\t"));
		for($i = 1 ; $i <= $data['selection_no'] ; $i++)
			fputs($file, iconv("UTF-8", "Big5", $data['selection'.$i]."\t"));
		fputs($file, iconv("UTF-8", "Big5", "\n"));
		while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
			fputs($file, iconv("UTF-8", "Big5", $row['question']."\t"));
			for($i = 1 ; $i <= $data['selection_no'] ; $i++){
				$res = db_query("select response from `online_survey_response` A, `online_survey` B where B.survey_no=$no and A.response_no=B.response_no and A.survey_cd=$row[survey_cd] and A.response='$i';");
				fputs($file, iconv("UTF-8", "Big5", $res->numRows()."\t"));
			}
			fputs($file, iconv("UTF-8", "Big5", "\n"));
		}
	}

	function calMulti($data, $sum, $num){
/*		for($i = 1 ; $i <= $sum ; $i++)
  $num[$i] = 0;*/
		for($i = 0 ; $i < strlen($data) ; $i += 2)
  			$num[ $data[$i] ]++;
		return $num;
	}

	function file_path($cd){
		global $COURSE_FILE_PATH;
		createPath($COURSE_FILE_PATH . $cd . "/survey/");
/*		$old_mask = umask(0);
		if(is_dir("../file/" . $cd) != true)
			mkdir("../file/" . $cd, 0775);
		if(is_dir("../file/" . $cd . "/survey") != true)
			mkdir("../file/" . $cd . "/survey", 0775);
		umask($old_mask);*/
	}
?>

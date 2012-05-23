<?php
/*******
FILE:   insert_data.php
DATE:   2007/1/25
AUTHOR: zqq

將高師大的資料匯入
**/

	require_once("../config.php");
	require_once("./class_level.php");	//四種課程性質
	
	$DB = $DB_CONN;
	$tpl = new Smarty();
			
	//新增level one
	$level = "1";  //設定level為1
	for($i = 0; $i < count($level_one); $i++){
		$sql = "INSERT INTO lrtcourse_classify_ (course_classify_name, course_classify_parent, course_classify_level, inner_cd) values('".$level_one[$i][1]."','0','".$level."','".$level_one[$i][0]."')";
		//echo $sql."<br>";
		$res = $DB->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
	}

	//新增level two
	//先抓出level one的資料
	$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_level='1' ORDER BY inner_cd ASC";
	$res_ = $DB->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$level = "2";  //設定level為2
	while($row = $res_->fetchRow(DB_FETCHMODE_ASSOC) ){
		for($i = 0; $i < count($level_two); $i++){
			$sql = "INSERT INTO lrtcourse_classify_ (course_classify_name, course_classify_parent, course_classify_level, inner_cd) values('".$level_two[$i][1]."','".$row['course_classify_cd']."','".$level."','".$level_two[$i][0]."')";
			//echo $sql."<br>";
			$res = $DB->query($sql);
			if (PEAR::isError($res))	die($res->getMessage());
		}		
	}
	/*
	level 1 的 10~60 ,level 2 的 1  ,level 3 有 1~6
    leve1 1 的 10~75 ,level 2 的 2  ,level 3 有 7~17
    level 1 的  ,level 2 的 999,level 3 有 18
	*/
	//新增level
    $level = "3";
	$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_level=1 and ( inner_cd BETWEEN '10' AND '60' ) ORDER BY inner_cd ASC";
	$res_level_one = $DB->query($sql);
	if (PEAR::isError($res_level_one))	die($res_level_one->getMessage());
	for($i=1; $i <=6 ; $i++) {
		$row_level_one = $res_level_one->fetchRow(DB_FETCHMODE_ASSOC);
		$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_level=2  and  inner_cd='1' and course_classify_parent=".$row_level_one['course_classify_cd']." ORDER BY inner_cd ASC";
		$res_level_two = $DB->query($sql);		
		
		$row_level_two = $res_level_two->fetchRow(DB_FETCHMODE_ASSOC) ;
		//加入level three
		$level_three = "level_three_".$i;
		//echo $level_three.",";
		$level_three = $$level_three;
		//echo "<pre>".print_r($level_three,true)."</pre>";
		for($j=0; $j < count($level_three); $j++){ //加入level 3　
			$sql = "INSERT INTO lrtcourse_classify_ (course_classify_name, course_classify_parent, course_classify_level, inner_cd) values('".$level_three[$j][1]."','".$row_level_two['course_classify_cd']."','".$level."','".$level_three[$j][0]."')";
			//echo $sql."<br>";
			$res_level_three = $DB->query($sql);
			if (PEAR::isError($res_level_three))	die($res_level_three->getMessage());
		}
	}

    $level = "3";
	$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_level=1 and ( inner_cd BETWEEN '10' AND '75' ) ORDER BY inner_cd ASC";
	$res_level_one = $DB->query($sql);
	if (PEAR::isError($res_level_one))	die($res_level_one->getMessage());
	for($i=7; $i <=17 ; $i++){
		$row_level_one = $res_level_one->fetchRow(DB_FETCHMODE_ASSOC);
		$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_level=2 and inner_cd='2' and course_classify_parent=".$row_level_one['course_classify_cd']." ORDER BY inner_cd ASC";
		$res_level_two = $DB->query($sql);	
		
		$row_level_two = $res_level_two->fetchRow(DB_FETCHMODE_ASSOC) ;
		//加入level three
		$level_three = "level_three_".$i;
		//echo $level_three.",";
		$level_three = $$level_three;
		//echo "<pre>".print_r($level_three,true)."</pre>";
		for($j=0; $j < count($level_three); $j++){ //加入level 3　
			$sql = "INSERT INTO lrtcourse_classify_ (course_classify_name, course_classify_parent, course_classify_level, inner_cd) values('".$level_three[$j][1]."','".$row_level_two['course_classify_cd']."','".$level."','".$level_three[$j][0]."')";
			//echo $sql."<br>";
			$res_level_three = $DB->query($sql);
			if (PEAR::isError($res_level_three))	die($res_level_three->getMessage());
		}
	}
	
	//新增level 4
	/*
	level 1 - 10,20,30,40,60;	level 2 - 1;	level 3	- 1~4,7;	level4 - 1~4,6
	level 1 - 10,20;			level 2 - 1;	level 3 -	5;		level4 - 5
	level 1 - 50;				level 2 - 1;	level 3 - 3,6;		level4 - 7,8		
	-----------------------------------------------------------------------------------
	level 1 - 10;				level 2 - 2;	level 3 - (7)		level4 - 10~19
	level 1	- 20;				level 2 - 2;	level 3 - (8)		level4 - 20~28
	level 1 - 30;				level 2 - 2;	level 3 - (9)		level4 - 29~42
	level 1 - 40;				level 2 - 2;	level 3 - (10)		level4 - 43~56
	level 1	- 50;				level 2 - 2;	level 3 - (11)		level4 - 57~67
	level 1 - 60;				level 2 - 2;	level 3 - (12)		level4 - 68~70

	*/

    $level = "4";
	$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_level=1 and  (inner_cd = '10' or inner_cd = '20' or inner_cd = '30' or inner_cd = '40' or inner_cd = '60' ) ORDER BY inner_cd ASC";
	$res_level_one = $DB->query($sql);
	if (PEAR::isError($res_level_one))	die($res_level_one->getMessage());
	while($row_level_one = $res_level_one->fetchRow(DB_FETCHMODE_ASSOC)){ //levle one
		$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_parent='".$row_level_one['course_classify_cd']."'  and  course_classify_level='2' and  inner_cd = '1' ";
		echo $sql."<br>";
		$res_level_two = $DB->query($sql);
		if($row_level_two = $res_level_two->fetchRow(DB_FETCHMODE_ASSOC)){ //levle 2
			$sql = "SELECT * FROM lrtcourse_classify_ WHERE  course_classify_parent='".$row_level_two['course_classify_cd']."'  and  course_classify_level=3 and  (inner_cd = '1' or inner_cd = '2' or inner_cd = '3' or inner_cd = '4' or inner_cd = '7' ) ORDER BY inner_cd ASC";
			echo $sql."<br>";
			$res_level_three = $DB->query($sql);
			if (PEAR::isError($res_level_three))	die($res_level_three->getMessage());
			
			while($row_level_three = $res_level_three->fetchRow(DB_FETCHMODE_ASSOC)){	//level 3
				switch($row_level_three['inner_cd']){
				case '1':
						$level_four = "level_four_1";
						$level_four = $$level_four;
						break;					
				case '2':
						$level_four = "level_four_2";
						$level_four = $$level_four;
						break;					
				case '3':
						$level_four = "level_four_3";
						$level_four = $$level_four;
						break;					
				case '4':
						$level_four = "level_four_4";
						$level_four = $$level_four;
						break;					
				case '7':
						$level_four = "level_four_6";
						$level_four = $$level_four;
						break;					
				}
				for($j=0; $j < count($level_four); $j++){ //加入level 4				
					$sql = "INSERT INTO lrtcourse_classify_ (course_classify_name, course_classify_parent, course_classify_level, inner_cd) values('".$level_four[$j][1]."','".$row_level_three['course_classify_cd']."','".$level."','".$level_four[$j][0]."')";
					echo $sql."<br>";
					$res_level_four = $DB->query($sql);
					if (PEAR::isError($res_level_four))	die($res_level_four->getMessage());						
				}				
			}
		}		
	}
	
    $level = "4";
	$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_level=1 and  (inner_cd = '10' or inner_cd = '20') ORDER BY inner_cd ASC";
	$res_level_one = $DB->query($sql);
	if (PEAR::isError($res_level_one))	die($res_level_one->getMessage());
	while($row_level_one = $res_level_one->fetchRow(DB_FETCHMODE_ASSOC)){ //levle one
		$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_parent='".$row_level_one['course_classify_cd']."'  and  course_classify_level='2' and  inner_cd = '1' ";
		$res_level_two = $DB->query($sql);
		if($row_level_two = $res_level_two->fetchRow(DB_FETCHMODE_ASSOC)){ //levle 2
			$sql = "SELECT * FROM lrtcourse_classify_ WHERE  course_classify_parent='".$row_level_two['course_classify_cd']."'  and  course_classify_level=3 and  inner_cd = '5' ORDER BY inner_cd ASC";
			$res_level_three = $DB->query($sql);
			if (PEAR::isError($res_level_three))	die($res_level_three->getMessage());
			
			if($row_level_three = $res_level_three->fetchRow(DB_FETCHMODE_ASSOC)){	//level 3
				$level_four = "level_four_5";
				$level_four = $$level_four;
				for($j=0; $j < count($level_four); $j++){ //加入level 4				
					$sql = "INSERT INTO lrtcourse_classify_ (course_classify_name, course_classify_parent, course_classify_level, inner_cd) values('".$level_four[$j][1]."','".$row_level_three['course_classify_cd']."','".$level."','".$level_four[$j][0]."')";
					echo $sql."<br>";
					$res_level_four = $DB->query($sql);
					if (PEAR::isError($res_level_four))	die($res_level_four->getMessage());						
				}
			}
		}		
	}

    $level = "4";
	$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_level=1 and  inner_cd = '50' ";
	$res_level_one = $DB->query($sql);
	if (PEAR::isError($res_level_one))	die($res_level_one->getMessage());
	while($row_level_one = $res_level_one->fetchRow(DB_FETCHMODE_ASSOC)){ //levle one
		$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_parent='".$row_level_one['course_classify_cd']."'  and  course_classify_level='2' and  inner_cd = '1' ";
		$res_level_two = $DB->query($sql);
		if($row_level_two = $res_level_two->fetchRow(DB_FETCHMODE_ASSOC)){ //levle 2
			$sql = "SELECT * FROM lrtcourse_classify_ WHERE  course_classify_parent='".$row_level_two['course_classify_cd']."'  and  course_classify_level=3 and  (inner_cd = '3' or inner_cd = '6') ORDER BY inner_cd ASC";
			$res_level_three = $DB->query($sql);
			if (PEAR::isError($res_level_three))	die($res_level_three->getMessage());		
			while($row_level_three = $res_level_three->fetchRow(DB_FETCHMODE_ASSOC)){	//level 3
				switch($row_level_three['inner_cd']){
				case '3':
					$level_four = "level_four_7";
					$level_four = $$level_four;	
					break;			
				case '6':
					$level_four = "level_four_8";
					$level_four = $$level_four;	
					break;					
				}
				for($j=0; $j < count($level_four); $j++){ //加入level 4				
					$sql = "INSERT INTO lrtcourse_classify_ (course_classify_name, course_classify_parent, course_classify_level, inner_cd) values('".$level_four[$j][1]."','".$row_level_three['course_classify_cd']."','".$level."','".$level_four[$j][0]."')";
					echo $sql."<br>";
					$res_level_four = $DB->query($sql);
					if (PEAR::isError($res_level_four))	die($res_level_four->getMessage());						
				}
			}
		}		
	}

//---------------------------------------------------------------------
echo "----------------------------------------------<br>";
    $level = "4";
	$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_level=1 and  inner_cd = '10' ";
	$res_level_one = $DB->query($sql);
	if (PEAR::isError($res_level_one))	die($res_level_one->getMessage());
	if($row_level_one = $res_level_one->fetchRow(DB_FETCHMODE_ASSOC)){ //levle one
		$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_parent='".$row_level_one['course_classify_cd']."'  and  course_classify_level='2' and  inner_cd = '2' ";
		$res_level_two = $DB->query($sql);
		if($row_level_two = $res_level_two->fetchRow(DB_FETCHMODE_ASSOC)){ //levle 2
			//get level3_7 						
			for($m=0; $m < count($level_three_7); $m++){
				if($m==0)
					$inner_cd_str = "inner_cd = '".$level_three_7[$m][0]."' ";
				else
					$inner_cd_str .= "or inner_cd = '".$level_three_7[$m][0]."' ";
			}						
			$sql = "SELECT * FROM lrtcourse_classify_ WHERE  course_classify_parent='".$row_level_two['course_classify_cd']."'  and  course_classify_level=3 and  (".$inner_cd_str.") ORDER BY inner_cd ASC";
			echo $sql."<br>";
			$res_level_three = $DB->query($sql);
			if (PEAR::isError($res_level_three))	die($res_level_three->getMessage());
			$count=10;
			while($row_level_three = $res_level_three->fetchRow(DB_FETCHMODE_ASSOC)){	//level 3
				$level_four = "level_four_".$count;
				$level_four = $$level_four;					
				for($j=0 ; $j < count($level_four); $j++){
					$sql = "INSERT INTO lrtcourse_classify_ (course_classify_name, course_classify_parent, course_classify_level, inner_cd) values('".$level_four[$j][1]."','".$row_level_three['course_classify_cd']."','".$level."','".$level_four[$j][0]."')";
					echo $sql."<br>";
					$res_level_four = $DB->query($sql);
					if (PEAR::isError($res_level_four))	die($res_level_four->getMessage());							
				}
				$count++;
			}
			
			
		}		
	}

    $level = "4";
	$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_level=1 and  inner_cd = '20' ";
	$res_level_one = $DB->query($sql);
	if (PEAR::isError($res_level_one))	die($res_level_one->getMessage());
	if($row_level_one = $res_level_one->fetchRow(DB_FETCHMODE_ASSOC)){ //levle one
		$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_parent='".$row_level_one['course_classify_cd']."'  and  course_classify_level='2' and  inner_cd = '2' ";
		$res_level_two = $DB->query($sql);
		if($row_level_two = $res_level_two->fetchRow(DB_FETCHMODE_ASSOC)){ //levle 2
			//get level3_8 
			for($m=0; $m < count($level_three_8); $m++){
				if($m==0)
					$inner_cd_str = "inner_cd = '".$level_three_8[$m][0]."' ";
				else
					$inner_cd_str .= "or inner_cd = '".$level_three_8[$m][0]."' ";
			}						
			$sql = "SELECT * FROM lrtcourse_classify_ WHERE  course_classify_parent='".$row_level_two['course_classify_cd']."'  and  course_classify_level=3 and  (".$inner_cd_str.") ORDER BY inner_cd ASC";
			echo $sql."<br>";
			$res_level_three = $DB->query($sql);
			if (PEAR::isError($res_level_three))	die($res_level_three->getMessage());
			$count=20;
			while($row_level_three = $res_level_three->fetchRow(DB_FETCHMODE_ASSOC)){	//level 3
				$level_four = "level_four_".$count;
				$level_four = $$level_four;					
				for($j=0 ; $j < count($level_four); $j++){
					$sql = "INSERT INTO lrtcourse_classify_ (course_classify_name, course_classify_parent, course_classify_level, inner_cd) values('".$level_four[$j][1]."','".$row_level_three['course_classify_cd']."','".$level."','".$level_four[$j][0]."')";
					echo $sql."<br>";
					$res_level_four = $DB->query($sql);
					if (PEAR::isError($res_level_four))	die($res_level_four->getMessage());							
				}
				$count++;
			}
		}		
	}

    $level = "4";
	$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_level=1 and  inner_cd = '30' ";
	$res_level_one = $DB->query($sql);
	if (PEAR::isError($res_level_one))	die($res_level_one->getMessage());
	if($row_level_one = $res_level_one->fetchRow(DB_FETCHMODE_ASSOC)){ //levle one
		$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_parent='".$row_level_one['course_classify_cd']."'  and  course_classify_level='2' and  inner_cd = '2' ";
		$res_level_two = $DB->query($sql);
		if($row_level_two = $res_level_two->fetchRow(DB_FETCHMODE_ASSOC)){ //levle 2
			//get level3_9 
			for($m=0; $m < count($level_three_9); $m++){
				if($m==0)
					$inner_cd_str = "inner_cd = '".$level_three_9[$m][0]."' ";
				else
					$inner_cd_str .= "or inner_cd = '".$level_three_9[$m][0]."' ";
			}						
			$sql = "SELECT * FROM lrtcourse_classify_ WHERE  course_classify_parent='".$row_level_two['course_classify_cd']."'  and  course_classify_level=3 and  (".$inner_cd_str.") ORDER BY inner_cd ASC";
			echo $sql."<br>";			
			$res_level_three = $DB->query($sql);
			if (PEAR::isError($res_level_three))	die($res_level_three->getMessage());
			$count=29;
			while($row_level_three = $res_level_three->fetchRow(DB_FETCHMODE_ASSOC)){	//level 3
				$level_four = "level_four_".$count;
				$level_four = $$level_four;					
				for($j=0 ; $j < count($level_four); $j++){
					$sql = "INSERT INTO lrtcourse_classify_ (course_classify_name, course_classify_parent, course_classify_level, inner_cd) values('".$level_four[$j][1]."','".$row_level_three['course_classify_cd']."','".$level."','".$level_four[$j][0]."')";
					echo $sql."<br>";
					$res_level_four = $DB->query($sql);
					if (PEAR::isError($res_level_four))	die($res_level_four->getMessage());							
				}
				$count++;
			}
		}		
	}

    $level = "4";
	$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_level=1 and  inner_cd = '40' ";
	$res_level_one = $DB->query($sql);
	if (PEAR::isError($res_level_one))	die($res_level_one->getMessage());
	if($row_level_one = $res_level_one->fetchRow(DB_FETCHMODE_ASSOC)){ //levle one
		$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_parent='".$row_level_one['course_classify_cd']."'  and  course_classify_level='2' and  inner_cd = '2' ";
		$res_level_two = $DB->query($sql);
		if($row_level_two = $res_level_two->fetchRow(DB_FETCHMODE_ASSOC)){ //levle 2
			//get level3_10 
			for($m=0; $m < count($level_three_10); $m++){
				if($m==0)
					$inner_cd_str = "inner_cd = '".$level_three_10[$m][0]."' ";
				else
					$inner_cd_str .= "or inner_cd = '".$level_three_10[$m][0]."' ";
			}						
			$sql = "SELECT * FROM lrtcourse_classify_ WHERE  course_classify_parent='".$row_level_two['course_classify_cd']."'  and  course_classify_level=3 and  (".$inner_cd_str.") ORDER BY inner_cd ASC";
			echo $sql."<br>";			
			$res_level_three = $DB->query($sql);
			if (PEAR::isError($res_level_three))	die($res_level_three->getMessage());
			$count=43;
			while($row_level_three = $res_level_three->fetchRow(DB_FETCHMODE_ASSOC)){	//level 3
				$level_four = "level_four_".$count;
				$level_four = $$level_four;					
				for($j=0 ; $j < count($level_four); $j++){
					$sql = "INSERT INTO lrtcourse_classify_ (course_classify_name, course_classify_parent, course_classify_level, inner_cd) values('".$level_four[$j][1]."','".$row_level_three['course_classify_cd']."','".$level."','".$level_four[$j][0]."')";
					echo $sql."<br>";
					$res_level_four = $DB->query($sql);
					if (PEAR::isError($res_level_four))	die($res_level_four->getMessage());							
				}
				$count++;
			}
		}		
	}

    $level = "4";
	$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_level=1 and  inner_cd = '50' ";
	$res_level_one = $DB->query($sql);
	if (PEAR::isError($res_level_one))	die($res_level_one->getMessage());
	if($row_level_one = $res_level_one->fetchRow(DB_FETCHMODE_ASSOC)){ //levle one
		$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_parent='".$row_level_one['course_classify_cd']."'  and  course_classify_level='2' and  inner_cd = '2' ";
		$res_level_two = $DB->query($sql);
		if($row_level_two = $res_level_two->fetchRow(DB_FETCHMODE_ASSOC)){ //levle 2
			//get level3_11 
			for($m=0; $m < count($level_three_11); $m++){
				if($m==0)
					$inner_cd_str = "inner_cd = '".$level_three_11[$m][0]."' ";
				else
					$inner_cd_str .= "or inner_cd = '".$level_three_11[$m][0]."' ";
			}						
			$sql = "SELECT * FROM lrtcourse_classify_ WHERE  course_classify_parent='".$row_level_two['course_classify_cd']."'  and  course_classify_level=3 and  (".$inner_cd_str.") ORDER BY inner_cd ASC";
			echo $sql."<br>";			
			$res_level_three = $DB->query($sql);
			if (PEAR::isError($res_level_three))	die($res_level_three->getMessage());
			$count=57;
			while($row_level_three = $res_level_three->fetchRow(DB_FETCHMODE_ASSOC)){	//level 3
				$level_four = "level_four_".$count;
				$level_four = $$level_four;					
				for($j=0 ; $j < count($level_four); $j++){
					$sql = "INSERT INTO lrtcourse_classify_ (course_classify_name, course_classify_parent, course_classify_level, inner_cd) values('".$level_four[$j][1]."','".$row_level_three['course_classify_cd']."','".$level."','".$level_four[$j][0]."')";
					echo $sql."<br>";
					$res_level_four = $DB->query($sql);
					if (PEAR::isError($res_level_four))	die($res_level_four->getMessage());							
				}
				$count++;
			}
		}		
	}	
	
    $level = "4";
	$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_level=1 and  inner_cd = '60' ";
	$res_level_one = $DB->query($sql);
	if (PEAR::isError($res_level_one))	die($res_level_one->getMessage());
	if($row_level_one = $res_level_one->fetchRow(DB_FETCHMODE_ASSOC)){ //levle one
		$sql = "SELECT * FROM lrtcourse_classify_ WHERE course_classify_parent='".$row_level_one['course_classify_cd']."'  and  course_classify_level='2' and  inner_cd = '2' ";
		$res_level_two = $DB->query($sql);
		if($row_level_two = $res_level_two->fetchRow(DB_FETCHMODE_ASSOC)){ //levle 2
			//get level3_12 
			for($m=0; $m < count($level_three_12); $m++){
				if($m==0)
					$inner_cd_str = "inner_cd = '".$level_three_12[$m][0]."' ";
				else
					$inner_cd_str .= "or inner_cd = '".$level_three_12[$m][0]."' ";
			}						
			$sql = "SELECT * FROM lrtcourse_classify_ WHERE  course_classify_parent='".$row_level_two['course_classify_cd']."'  and  course_classify_level=3 and  (".$inner_cd_str.") ORDER BY inner_cd ASC";
			echo $sql."<br>";			
			$res_level_three = $DB->query($sql);
			if (PEAR::isError($res_level_three))	die($res_level_three->getMessage());
			$count=68;
			while($row_level_three = $res_level_three->fetchRow(DB_FETCHMODE_ASSOC)){	//level 3
				$level_four = "level_four_".$count;
				$level_four = $$level_four;					
				for($j=0 ; $j < count($level_four); $j++){
					$sql = "INSERT INTO lrtcourse_classify_ (course_classify_name, course_classify_parent, course_classify_level, inner_cd) values('".$level_four[$j][1]."','".$row_level_three['course_classify_cd']."','".$level."','".$level_four[$j][0]."')";
					echo $sql."<br>";
					$res_level_four = $DB->query($sql);
					if (PEAR::isError($res_level_four))	die($res_level_four->getMessage());							
				}
				$count++;
			}
		}		
	}		
																																				
	//輸出頁面
	$tpl->display("insert_data.tpl");	


?>
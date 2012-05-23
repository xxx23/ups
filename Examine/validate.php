<?php
	/*author: lunsrot
	 * date: 2007/07/05 modify
	 */
	require_once("exam_info.php");
	$option = $_POST['option'];
	$begin_course_id = $_SESSION['begin_course_id'];

	if( strcmp($option, "name") == 0 ){
		$name = $_POST[$option];
		$sql = "select * from test_course_setup where begin_course_cd=$begin_course_id and test_name='$name';";
		$result = $DB_CONN->query($sql);
		$num = $result->numRows();
		echo $num;
	}else if( strcmp($option, "score") == 0 ){
		$score = $_POST[$option];
		if( is_numeric($score) == 1 ){
			if( $score < 0 || $score > 100 ){
				echo "-1";
			}else{
			/*	if( session_is_registered(score) == 0 )
					session_register(score);*/
				$_SESSION['score'] = $score;
				echo "0";
			}
		}else{
			echo "-1";
		}
	}else if( strcmp($option, "checkbox") == 0 ){
		$num = $_POST['value'];
		$checked = $_POST['checked'];
		if( session_is_registered(checkbox) == 0){
			$_SESSION['checkbox'] = array(0);
		}
		if( strcmp($checked, "true") == 0)
			$_SESSION['checkbox'][$num] = $num;
		else
			unset($_SESSION['checkbox'][$num]);
	}else if( strcmp($option, "auto") == 0){
		$checkbox = $_SESSION['checkbox'];
		$score = $_POST[$option];
		$sum = count($checkbox) - 1;
		if( $sum == 0 ){
		}else{
			$rem = $score % $sum;
			$quo = (int)($score / $sum);
			$i = 0;
			foreach($checkbox as $key){
				if( $key == 0)
					continue;
				$num = ($i < $rem ) ? $quo+1 : $quo;
				$str[$i++] = $key.".".$num;
			}
			for( $j = 0 ; $j < $i-1 ; $j++ ){
				$output = $output.$str[$j]."/";
			}
			$output = $output.$str[$j];
			echo $output;
		}
	}else{
		echo "error";
	}
?>

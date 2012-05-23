<?php
	/*author: lunsrot
	 * date: 2007/08/17
	 */
	function timecmp($time1, $time2){
		if($time1 > $time2)
			return 1;
		else if ($time1 < $time2)
			return -1;
		return 0;
	}

	/*author: lunsrot
	 * date: 2007/09/21
	 */
	function get_survey_bankno(){
		global $DB_CONN;
		$cd = getTeacherId();
		return $DB_CONN->getOne("select survey_bankno from `survey_bank` where personal_id=$cd");
	}

	/*author: lunsrot
	 * date:2007/09/22
	 */
	function error_msg($str){
		echo "<script type=\"text/javascript\">alert('$str');history.back();</script>";
		exit(0);
	}
?>

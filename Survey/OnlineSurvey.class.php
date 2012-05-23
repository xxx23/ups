<?php
/*author: lunsrot
 * date: 2007/04/17
 */
require_once("../config.php");
require_once("../session.php");

class OnlineSurvey{
	private $role, $course_cd, $list;

	public function __construct(){
		$this->role = $_SESSION['role_cd'];
		$this->course_cd = $_SESSION['begin_course_cd'];
	}

	public function list_all(){
		$i = 0;
		$result = db_query("select * from `online_survey_setup` where survey_target=$this->course_cd order by d_survey_end;");
		while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
			$this->list[$i++] = $row;
		}
		return $this->list;
	}
}
?>

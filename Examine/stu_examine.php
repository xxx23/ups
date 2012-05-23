<?php
	/*author: lusnrot
	 * date: 2007/07/01
	 */
    require_once("exam_info.php");
    require_once("../library/lib_course_pass.php");
    require_once("../library/course.php");

	
    $option = $_GET['option'];
    $begin_course_cd = $_SESSION['begin_course_cd'];

    if(get_course_attribute($begin_course_cd) == 0 
        && !isReadTimeEnough($begin_course_cd, $_SESSION['personal_id']))
    {
        die('閱讀時間未過');
    }

	if($option == "view"){
		$input = $_GET;
		examineOperator($begin_course_cd, $input['test_no'], $_SESSION['personal_id'], true, false, array());
	}else{
		$input = $_POST;
		examineOperator($begin_course_cd, $input['test_no'], $_SESSION['personal_id'], false, true, $input);
	}
?>

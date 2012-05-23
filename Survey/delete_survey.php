<?php
/*author: lunsrot
 * date: 2007/05/04
 */
require_once("../config.php");
require_once("../session.php");

include "../library/delete_data.php";

$survey_no = $_GET['survey_no'];

$num = count($survey_no);
for($i = 0 ; $i < $num ; $i++){
	delete_survey($survey_no[$i]);
}

header("location: ./tea_view.php");
?>

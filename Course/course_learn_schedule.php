<?php
$RELEATED_PATH = "../";
require_once($RELEATED_PATH . "config.php");
require_once($RELEATED_PATH . "session.php");
$tpl = new Smarty();
$tpl->assign("calendar", '../Calendar/calendar_incourse.php');
$tpl->assign("learn", '../Course/remind.php');
assignTemplate($tpl, "/course/course_learn_schedule.tpl");
?>

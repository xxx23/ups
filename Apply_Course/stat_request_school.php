<?php
define('ROOT', '../');
require_once(ROOT.'config.php');
require_once('session.php');

header("Location: {$HOMEURL}{$WEBROOT}Web_Service/webapp.php?controller=LearningDataStat&action=schoolView");
exit();
/*
 * 這隻php單純只是要拿來顯示登入後的頁面而已
 * 因此用 header 跳到要顯示的頁面
 *
*/
?>

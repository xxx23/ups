<?php
define('ROOT', '../');
require_once(ROOT.'config.php');
require_once(ROOT.'session.php');
global $DB_CONN;

//$role_cd = $_SESSION['role_cd'];
$tpl = new Smarty;
if (!array_key_exists('id', $_GET)) {
    die('argument missing!');
}
$type = Array();
$id = (int) $_GET['id'];
$tpl->assign('id', $id);



$location_list = Array();
$sql = 'SELECT city_cd,city FROM location GROUP BY city_cd';
$result = $DB_CONN->query($sql);
if (PEAR::isError($result)) die($result->getMessage() . '<br/>' . $sql);
while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
    $location_list[$row['city_cd']] = $row['city'];
}
$tpl->assign('location_list', $location_list);
/*
$course_property = Array();
$course_property['-1'] = "不限";
$sql = 'SELECT property_cd,property_name FROM course_property ORDER BY property_cd ASC';
$result = $DB_CONN->query($sql);
while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
    $course_property[$row['property_cd']] = $row['property_name'];
}
$tpl->assign('course_property', $course_property);
*/

assignTemplate($tpl, '/statistics/course_graph.tpl');
?>

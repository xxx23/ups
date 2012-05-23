<?php
if (!isset($_GET['type_location']))
    die('error');

define('ROOT', '../');
require_once(ROOT.'config.php');
require_once(ROOT.'session.php');

global $DB_CONN;

$type_location = $DB_CONN->escapeSimple($_GET['type_location']);
$sql = "SELECT doc_cd,doc FROM docs WHERE city_cd = $type_location";

$result = $DB_CONN->query($sql);

if (PEAR::isError($result)) {
    die($result->getMessage() . '<br/>' . $sql);
}

$ret = Array();
while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
    $ret[$row['doc_cd']] =  $row['doc'];
}

echo json_encode($ret);
?>

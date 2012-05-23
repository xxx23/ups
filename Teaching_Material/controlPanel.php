<?php
include "../config.php";
require_once("../session.php");

$smtpl = new Smarty;

assignTemplate($smtpl,"/teaching_material/controlPanel.tpl");
?>

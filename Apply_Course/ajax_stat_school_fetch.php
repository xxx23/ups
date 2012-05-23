<?php
//ini_set('display_errors',1);
//error_reporting(E_ALL);
require_once('../config.php');
require_once('stat_lib.php');
$city_cd = (!empty($_GET['city_cd'])) ? (int)$_GET['city_cd'] : -1;
$type = (!empty($_GET['type'])) ? (int)$_GET['type'] : 0;
echo json_encode(get_school_list($city_cd,$type));
//end of ajax_stat_school_fetch.php

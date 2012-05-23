<?php
chdir('/mnt/raid/elearning/Routine');
require_once '../config.php';

$timestamp = time();
$onlineUserCount = db_getOne("SELECT count(*)
                              FROM online_number
                              WHERE 1;");
echo "$timestamp $onlineUserCount\n";

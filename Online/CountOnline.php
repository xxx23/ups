<?php

chdir(dirname($_SERVER['PHP_SELF']));
require_once '../config.php';


$count  = db_getOne('SELECT COUNT(*) FROM online_number');


echo date('Y-m-d H:i:s');
echo "\t".$count."\n";




//END of CountOnline.php

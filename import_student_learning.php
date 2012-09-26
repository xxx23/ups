<?php

require_once('config.php');

global $db;

if(($handle = fopen('/home/carlcarl/student_learning.csv', 'r')) != FALSE)
{
	$student_learning = $db->student_learning;
	while(($data = fgetcsv($handle, 1000, ',')) != FALSE)
	{
	// $data = fgetcsv($handle, 1000, ',');
		$tmp = explode(':', $data[5]);
		$h = (isset($tmp[0])) ? intval($tmp[0]) : 0;
		$m = (isset($tmp[1])) ? intval($tmp[1]) : 0;
		$s = (isset($tmp[2])) ? intval($tmp[2]) : 0;
		$total = intval(($h * 3600) + ($m * 60) + $s);
		$student_learning->insert(array('bcd' => intval($data[0]), 'ccd' => intval($data[1]), 'pid' => intval($data[2]), 'mid' => intval($data[3]), 'ehn' => intval($data[4]), 'eht' => $total, 'eot' => new MongoDate(strtotime($data[6])), 'elt' => new MongoDate(strtotime($data[7]))));
	}
}


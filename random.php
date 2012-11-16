<?php
/*
 * 90萬數據分成三等份數據分給三台client
 *
 */

$list = array();
$_list = array(); // Store first random select result
$limit = 900000;
$index = $limit;

for($i = 1; $i <= $limit; $i++)
{
	$list[$i] = $i;
}
for($i = 0; $i < $limit; $i++)
{
	$tmp = intval(mt_rand(1,$index));
	$_list[$i] = $list[$tmp];
	$list[$tmp] = $list[$index];
	$index--;
}

$fd = fopen("randomData1", "w");
$limit1 = $limit / 3;
for($i = 0; $i < $limit1; $i++)
{
	fwrite($fd, $_list[$i] . "\n");
}
fclose($fd);

$fd = fopen("randomData2", "w");
$limit2 = $limit / 3 * 2;
for($i = $limit1; $i < $limit2; $i++)
{
	fwrite($fd, $_list[$i] . "\n");
}
fclose($fd);

$fd = fopen("randomData3", "w");
$limit3 = $limit;
for($i = $limit2; $i < $limit3; $i++)
{
	fwrite($fd, $_list[$i] . "\n");
}
fclose($fd);


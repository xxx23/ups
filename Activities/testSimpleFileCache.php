<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
require_once('./lib/SimpleFileCache.php');

$cache = new SimpleFileCache(array('cacheDir'=>'/tmp','lifetime'=>10));

$test =0;

var_dump($cache->load('test'));
if(($test = $cache->load('test'))==false)
{
    echo "refresh cache ";
    $test=time();
    $cache->save('test',$test);
}

echo $test;
?>


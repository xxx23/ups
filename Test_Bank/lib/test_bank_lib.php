<?php

require_once("../../session.php");

//get後檢察是否有被更改，產生key
//$num: $homework_no, $id:身分為tea或是stu
function check_get_produce_key($num, $id){
	$seed = "hsng@puppy";
	$str = $num.$seed;
	$key = substr(md5($str),5,8);
	return $key;
}

//get後檢察是否有被更改，反解key
//$num: $homework_no, $key:要反解的key,$id:身分為tea或是stu
function check_get_reverse_key($num, $key, $id){
	$seed = "hsng@puppy";
	$str = $num.$seed;
	$my_key = substr(md5($str),5,8);
	
	if($my_key != $key){
		//print "key:".$key;
		//print "mykey:".$my_key;
		header("Location: ./alert.html");
		exit(0);
	}
}

?>
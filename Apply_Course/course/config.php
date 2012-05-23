<?php
/* 連接資料庫 */
//mysql_connect("localhost","root","1234") or die("連接失敗");
mysql_connect("localhost","root","1234") or die("連接失敗");

mysql_query("SET NAMES utf-8;"); 
mysql_query("SET CHARACTER_SET_CLIENT=utf-8;"); 
mysql_query("SET CHARACTER_SET_RESULTS=utf-8;");
mysql_select_db("elearning");
?>
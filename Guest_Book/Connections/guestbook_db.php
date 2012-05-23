<?php

require_once('../config.php');

global $DB_HOST, $DB_NAME, $DB_USERNAME, $DB_USERPASSWORD;

$hostname_guestbook_db = $DB_HOST;
$database_guestbook_db = $DB_NAME;
$username_guestbook_db = $DB_USERNAME;
$password_guestbook_db = $DB_USERPASSWORD;
$guestbook_db = mysql_pconnect($hostname_guestbook_db, $username_guestbook_db, $password_guestbook_db) or trigger_error(mysql_error(),E_USER_ERROR);
 
?>

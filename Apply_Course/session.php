<?php 
//½T»{µn¤Jª¬ªp
require_once('lib.php') ; // for redirect function 
session_start();


check_login(); 


function check_login(){
	if( !isset($_SESSION['no']) || empty($_SESSION['no']) ) {
		identification_error();
		die("you are not login");
	}
}

function check_access($page_pass_id) {
	if( !in_array($page_pass_id, $_SESSION['menu_role']) ){
		identification_error();
	}
}

function identification_error(){
	redirect("identification_error.html");
}

?>
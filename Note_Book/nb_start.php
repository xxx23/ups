<?php 
	include('../config.php');
	include('../session.php');
	$smtpl = new Smarty;
	
	$smtpl->assign('WEBROOT',$WEBROOT);
	
	assignTemplate($smtpl, '/note_book/nb_start.tpl');
?>
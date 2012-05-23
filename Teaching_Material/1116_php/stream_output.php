<?php
/***************************************************************/
/* id: stream_output.php v1.0 2007/5/29 by hushpuppy Exp. 	   */
/* function: 影音串流output檔案的介面							   */
/***************************************************************/
include "../config.php";
//require_once("../session.php");

$smtpl = new Smarty;

$smtpl->display("stream_output.tpl");

?>
<?php
include "../../config.php";
require_once("../../session.php");

    $error_id = $_GET['id'];
    $action =  $_GET['action'];

    if($action == 3)
    {
        $sql = "DELETE FROM error_content_report WHERE id= ".$error_id.";";
        db_query($sql);
    }


    else
    {
        $time = date('Y-m-d H:i:s');

        $sql = "UPDATE error_content_report SET confirmdate = '".$time."',enable = ".$action." WHERE id = ".$error_id.";";

        db_query($sql);
    }


//echo $sql;

?>

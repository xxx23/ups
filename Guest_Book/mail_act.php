<?php

    require_once('../config.php');
    require_once('Connections/guestbook_db.php');
    
    $act = $_GET['action'];
    $mid = $_GET['mid'];

    if($act == "delete")
    {
        $sql = "delete from `message` where `id` = $mid"; 
    }
    else if($act == "release")
    {
        $sql = "update `message` set `release` = '1' where `id` = $mid";
    }
    else
    {
        echo "資訊錯誤！";
        die();
    }
    mysql_select_db($database_guestbook_db, $guestbook_db);
    $result = mysql_query($sql, $guestbook_db) or die(mysql_error());
    $html = "https://".$HOST.$WEBROOT;
    if($act == "delete")
        echo "留言刪除成功！";
    else if($act == "release")
        echo "留言公開成功！";
    header(sprintf("Location: %s", $html));
?>

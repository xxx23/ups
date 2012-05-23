<?php



if($_SERVER['REMOTE_ADDR']=='140.123.105.191')
{
    require_once('config.php');

    //        $server = '140.127.49.137';
    $server = 'NKNU_DB';
    //$server = '140.127.49.234';

    $link = mssql_connect($server, 'Hsngccu', 'Cyber3elearning');

    if(!$link)
    {
        die('Something went wrong while connecting to MSSQL');

    }
    if(!mssql_select_db('course_Hsngccu', $link))
    {
        die('Select database error');
    }

    //$list = mssql_query("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE'");
    //$list = mssql_query("SELECT count(*) FROM course");
    $list = mssql_query("SELECT Import_ID FROM course");

    while(($row = mssql_fetch_array($list)) && $row != NULL)
    {
        var_dump($row);
        echo "<br />";
    }

    //$row = mssql_fetch_array($list);
    //var_dump($row);

    mssql_free_result($list);

}

?>

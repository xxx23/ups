<?php
putenv('FREETDSCONF=/etc/freetds/freetds.conf');
class MSSQLWrapper
{
    private $_db_link;
    private $_result;

    function __construct($host,$user,$passwd,$database)
    {
        $this->_db_link = mssql_connect($host,$user,$passwd)or die(mssql_get_last_message());
        mssql_select_db($database) or die(mssql_get_last_message());
    }

    function query($sql)
    {
        $this->_result = mssql_query($sql);// or die(mssql_get_last_message());
        if($this->_result == true)
        {
        }
        else
        {
            $log = '/tmp/ups_nknu.log';
            $handle = fopen($log, 'a');
            $date = date('Y-m-d H:i:s');
            $content = $date . ' ' . $_SERVER['PHP_SELF'] . ' ' . mssql_get_last_message(). "\n";
            fwrite($handle, $content);
            die(mssql_get_last_message());
        }
        return $this->_result;
    }

    function getAll($sql)
    {
        
        $this->query($sql);
        if(!mssql_num_rows($this->_result))
            return null;
        $datas = array();
        while($row = mssql_fetch_assoc($this->_result))
        {
            $datas[] = $row;
        }
        mssql_free_result($this->_result);
        return $datas;
    }

    function getOne($sql)
    {
        $this->query($sql);
        if(!mssql_num_rows($this->_result))
            return null;
        
        $row = mssql_fetch_row($this->_result);
        mssql_free_result($this->_result);
        return $row[0];

    }

    function __destruct()
    {
        mssql_close($this->_db_link);
    }
}



//end of MSSQLWrapper.class.php


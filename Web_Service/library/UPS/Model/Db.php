<?php


/**
 * Description of Model_Db
 * Database 的基本操作 包含insert update delete目前使用UPS上的 db function
 * 目前只針對mysq
 * l有心人士可以換成可替換的
 * @author wewe0901
 */
class UPS_Model_Db
{
    /**
     * 操作的table名稱
     * @var string
     */
    protected $_tableName;

    /**
     * 根據輸入array的key value組合成insert database的query
     * @param array $data
     * @return mixed
     */
    public function insert($data)
    {
        if(!is_array($data))
            throw new Exception('insert param type error: must be array');

        $fields = array();
        $values = array();
        foreach($data as $key=>$value)
        {
            $fileds[] = "`{$key}`";
            if(is_int($value))
                $values [] = $value;
            else {
                $values[] = "'{$value}'";
            }
        }
        $fieldPart = implode(',', $fileds);
        $valuePart = implode(',', $values);
        $queryStr = "INSERT INTO {$this->_tableName}({$fieldPart}) VALUES($valuePart);";

        return db_query($queryStr);

    }

    /**
     *根據輸入的條件與array的key value組合成update database的query
     * @param array $data
     * @param string $where
     * @return mixed
     */
   public function update( $data,$where)
   {
       if(!is_array($data))
          die('update param type error: must be array');

        if(empty($where))
            $where = 1;
        $updates =array();
        foreach($data as $key=>$value)
        {
           $uKey = "`{$key}`";
           if(is_int($value))
                $uValue =$value;
            else {
                 $uValue  = "'{$value}'";
            }
           $updates[] = "{$uKey}={$uValue}";
        }

        $updatePart = implode(',', $updates);

        $queryStr = "UPDATE  `{$this->_tableName}` SET {$updatePart} WHERE {$where};";
        return db_query($queryStr);
   }
   /**
    * 根據輸入的條件 刪除資料
    * @param string $where
    * @return mixed
    */
   public function delete($where)
   {
       $queryStr = "DELETE FROM {$this->_tableName} WHERE {$where} ";

       return db_query($queryStr);
   }

   /**
    *  過濾並跳脫
    * @param string $string
    * @return string
    */
   public function escape($string)
   {
        return mysql_real_escape_string($string);
    }
}

//END OF Db.php
//

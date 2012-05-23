<?php 
require_once('../config.php');
class NKNUSyncLogger
{
    private $_messageList = array();
    private $_logTypes = array('LOG_ADD','LOG_UPDATE','LOG_ERROR');
    private $_begin_course_cd = 0;
    
    public function __construct()
    {
        ;
    }
    
    public function logging($begin_course_cd,$type,$message)
    {
        if(in_array($type,$this->_logTypes))
            $this->_messageList[$begin_course_cd][$type][] = $message;
    }
    
    public function addCourse($begin_course_cd,$message)
    {
        $this->logging($begin_course_cd,"LOG_ADD",$message);
    }
    
    public function updateCourse($begin_course_cd,$message)
    {
        $this->logging($begin_course_cd,"LOG_UPDATE",$message);
    }
    
    public function error($begin_course_cd,$message)
    {
        $this->logging($begin_course_cd,"LOG_ERROR",$message);
    }
    public function _getCourseName($begin_course_cd)
    {
        return db_getOne("SELECT begin_course_name
                          FROM begin_course
                          WHERE begin_course_cd = {$begin_course_cd}");
    }
    public function save()
    {
        foreach($this->_messageList as $begin_course_cd => $messages)
        {
            foreach($messages as $type => $messageList)
            {
                if(!in_array($type,$this->_logTypes))
                    continue;
                $sql = 'INSERT INTO `nknu_transfer_log`(`log_id`,`begin_course_cd`,`course_name`,`log_type`,`log_info`,`log_time`)
                               VALUES(\'\',\''.$begin_course_cd.'\',\''.$this->_getCourseName($begin_course_cd).'\',\''.$type.'\',\''.implode('<br/>\n',$messageList).'\',NOW()); ';
                db_query($sql);
            }
        }
        $this->_messageList =array();
    }
}

//END OF NKNUSyncLogger.class.php

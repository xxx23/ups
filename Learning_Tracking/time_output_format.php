<?php
    //輸出時間格式化
    //輸入: 秒數
    //輸出: x.x h or x.x min or x.x sec
    function time_output_format($sec)
    {
        if($sec >= 3600){
            return round($sec/3600,2)."小時";
        }else if($sec >= 60){
           return round($sec/60,2)."分鐘";
        }else if($sec >= 0 ){
            return $sec."秒";
        }
        return 0;
    }
    //轉換 yyyy-mm-dd hh:MM:ss
    //成 秒數
    
    function convert_datetime($str) {
        
        list($date, $time) = explode(' ', $str);
        list($year, $month, $day) = explode('-', $date);
        list($hour, $minute, $second) = explode(':', $time);
         
        $timestamp = $hour*3600 + $minute*60+ $second + $month*31*86400+ $day*86400+ $year*12*31*86400;
       
        return $timestamp;
    }
?>

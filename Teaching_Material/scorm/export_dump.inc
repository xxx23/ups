<?php

//將教材檔案目錄內容打包,使用rar (其它壓縮程式中文會出錯!)
function export_textbook($asyn,$content_cd,$content_name, $teacher_cd, $type_name)
{
  global $DATA_FILE_PATH,$RAR_PATH,  $smtpl;
  //if($_SERVER['REMOTE_ADDR']=='140.123.105.190')
    //  die($asyn."<br>".$content_cd."<br>".$content_name."<br>". $teacher_cd."<br>". $type_name);
  $content_file_name = str_replace(" ","_",$content_name);
  $export_path = $DATA_FILE_PATH.$teacher_cd."/export_data/".$content_file_name.$type_name;
  $content_name = str_replace(" ","\ ",$content_name);
  $textbook_path = $DATA_FILE_PATH.$teacher_cd."/textbook/";
  
  //$cmd = "cd ".$textbook_path.";zip ".$store_path." ./";
  //刪除之前create的sql檔案
  $d = dir($textbook_path."/".$content_name);
  while( ($f_name = $d->read()) != false){
    if(strcmp($f_name, ".") == 0 || strcmp($f_name, "..") == 0)
    continue;
    //print $f_name;
    $pos = strstr($f_name, ".sql");
    if($pos != false){
      //print "rm ".$f_name;
      unlink($textbook_path.$content_name."/".$f_name);
      //echo "刪除之前的sql unlink path : {$textbook_path}{$content_name}/{$f_name}<br>";
      //exec("rm -rf ".$f_name);
      //echo "rm -rf {$f_name}<br>";
    }
  }

  //進入export_data資料夾中，若之前有匯出過，刪除之前匯出的rar版本
  $d = dir($DATA_FILE_PATH.$teacher_cd."/export_data/");
  while(($f_name = $d->read()) != false){
    if(strcmp($f_name, ".") == 0 || strcmp($f_name, "..") == 0)
    continue;
    if(strcmp($f_name, $content_file_name.$type_name) == 0)
    unlink($export_path);
    //echo "刪除之前匯出的rar unlink $export_path<br>";
  }

  //無用先拿掉暫時
  //dumpSchema($textbook_path.$content_name);

  rename($textbook_path.$content_name,$textbook_path.$content_cd);

  putenv("LANG=zh_TW.UTF-8");
    $cmd = "cd ".$textbook_path.";$RAR_PATH a '".$export_path."' '".$content_cd. "' ; mv ".$content_cd."  ".$content_name ;
  if($asyn == 1)
    $cmd = "cd ".$textbook_path.";$RAR_PATH a '".$export_path."' '".$content_cd. "' ; mv ".$content_cd."  ".$content_name." > /dev/null &";

  exec($cmd); 
}

/*匯出時處理schema dump*/
function dumpSchema($dump_path)
{
  global $DB_CONN, $Content_cd;

  $db_name = $DB_NAME;

  ob_start();
  $mysqldump = new MySqlDump($DB_CONN, 1, "\n", 0, 0, 1, ";");
  $mysqldump->dumptablespecificdata("class_content", "\$filterResult = (\$row[0] == $Content_cd);");
  $outputBuffer = ob_get_contents();
  $result = $outputBuffer;

  $mysqldump->dumptablespecificdata("course_content", "\$filterResult = (\$row[0] == $Content_cd);");
  $outputBuffer = ob_get_contents();
  $result .= $outputBuffer;
  //結束並清除output buffer
  ob_end_clean();

  $today = date("Y-m-d-H-i-s");
  $handle = fopen($dump_path."/".$today.".sql","w");
  fwrite($handle,$outputBuffer);
  $old_umask = umask(0);
  chmod($dump_path."/".$today.".sql", 0664);
  umask($old_umask);
}
?>

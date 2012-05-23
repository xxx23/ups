<?
        $RELEATED_PATH = "../";
        
        require_once($RELEATED_PATH . "config.php");    
        require_once($RELEATED_PATH . "session.php");
        
        session_start();
        $personal_id = $_SESSION['personal_id'];                        //取得個人編號
        $role_cd = $_SESSION['role_cd'];                                        //取得角色
        $begin_course_cd = $_SESSION['begin_course_cd'];        //取得課程代碼
        
        $behavior = $_GET['behavior'];                                          //取得行為
        $argument = $_GET['argument'];                                          //取得參數

        //將參數分解成討論區編號discuss_cd
        $discuss_cd_Counter = 0;
        
        $token = strtok($argument, "_");
        while ($token !== false) 
        {
                $discuss_cd_list[$discuss_cd_Counter++] = $token;

                $token = strtok("_");
        }
        $discuss_cd_Number = $discuss_cd_Counter;
        
        //設定檔案路徑
        $FILE_PATH = $COURSE_FILE_PATH . $begin_course_cd . "/Discuss_Area/";
        $tmp_FILE_PATH = $FILE_PATH;    
        $tmp_FILE_PATH = substr($tmp_FILE_PATH, 0, strrpos($tmp_FILE_PATH, "/"));
        $tmp_FILE_PATH = substr($tmp_FILE_PATH, 0, strrpos($tmp_FILE_PATH, "/"));
        $tmp_FILE_PATH = substr($tmp_FILE_PATH, 0, strrpos($tmp_FILE_PATH, "/"));
        $FILE_PATH = $RELEATED_PATH . substr($FILE_PATH, strrpos($tmp_FILE_PATH, "/")+1, strlen($FILE_PATH));

        
        //備份這些討論區
        for($discuss_cd_Counter=0; $discuss_cd_Counter<$discuss_cd_Number; $discuss_cd_Counter++)
        {
                $discuss_cd = $discuss_cd_list[$discuss_cd_Counter];

                //備份ㄧ個討論區
                backupOneDiscussArea(
                                                $DB_CONN, 
                                                $begin_course_cd, 
                                                $discuss_cd,
                                                $RELEATED_PATH,
                                                $IMAGE_PATH,
                                                $CSS_PATH,
                                                $JAVASCRIPT_PATH,
                                                $FILE_PATH
                                                );
                
                //壓縮ㄧ個討論區
                $zip = new zip_file("$discuss_cd.zip");
                $zip->set_options
                                (
                                        array
                                        (
                                                'basedir' => $FILE_PATH,
                                                'inmemory' => 0, //不在內存壓縮.而是直接存放到磁盤.如果要壓縮下載,則可以選擇為1
                                                'recurse' => 1,  //是否壓縮子目錄，resurse，遞歸的意思？
                                                'storepaths' => 0, //是否存儲目錄結構，我選是。
                                                'overwrite' => 0, //是否覆蓋
                                                'level' => 5 ,//壓縮比
                                                //'name' => $zipFileName, //壓縮最後生成的文件名，無需再次設瞞。這裡是為瞭解說方便才放上來的。
                                                'prepend' => "", //未知
                                                'followlinks' => 0, //未知
                                                'method' => 1, //未知
                                                'sfx' => "", //自解壓
                                                //'type' => "zip", //是zip還是tar...,無需設瞞，這裡為了方便解說。放上來。
                                                'comment' => ""
                                        )
                                );
                $zip->add_files($discuss_cd);   //增加ㄧ個檔案或資料夾
                $zip->create_archive();                 //將資料存到硬碟
                
                //刪除暫存檔
                recursiveRemoveDirectory($FILE_PATH . $discuss_cd);
        }//end for($discuss_cd_Counter=0; $discuss_cd_Counter<$discuss_cd_Number; $discuss_cd_Counter++)
        
        //將所有的討論區壓縮檔 壓在一起
        $zip = new zip_file("DisscussArea.zip");
        $zip->set_options
                        (
                                array
                                (
                                        'basedir' => $FILE_PATH,
                                        'inmemory' => 1, //不在內存壓縮.而是直接存放到磁盤.如果要壓縮下載,則可以選擇為1
                                        'recurse' => 0,  //是否壓縮子目錄，resurse，遞歸的意思？
                                        'storepaths' => 0, //是否存儲目錄結構，我選是。
                                        'overwrite' => 0, //是否覆蓋
                                        'level' => 5 ,//壓縮比
                                        //'name' => $zipFileName, //壓縮最後生成的文件名，無需再次設瞞。這裡是為瞭解說方便才放上來的。
                                        'prepend' => "", //未知
                                        'followlinks' => 0, //未知
                                        'method' => 1, //未知
                                        'sfx' => "", //自解壓
                                        //'type' => "zip", //是zip還是tar...,無需設瞞，這裡為了方便解說。放上來。
                                        'comment' => ""
                                )
                        );
        for($discuss_cd_Counter=0; $discuss_cd_Counter<$discuss_cd_Number; $discuss_cd_Counter++)
        {
                $discuss_cd = $discuss_cd_list[$discuss_cd_Counter];
                
                $zip->add_files("$discuss_cd.zip");
        }
        $zip->create_archive();         // Create archive in memory
        $zip->download_file();          // Send archive to user for download
        
        
        //刪除所有的壓縮檔
        for($discuss_cd_Counter=0; $discuss_cd_Counter<$discuss_cd_Number; $discuss_cd_Counter++)
        {
                $discuss_cd = $discuss_cd_list[$discuss_cd_Counter];
                        
                unlink($FILE_PATH . "$discuss_cd.zip");
        }
        
        
/**********************************************************************************/

   function recursiveRemoveDirectory($path)
   {    
       $dir = new RecursiveDirectoryIterator($path);

       //Remove all files
       foreach(new RecursiveIteratorIterator($dir) as $file)
       {
           unlink($file);
       }

       //Remove all subdirectories
       foreach($dir as $subDir)
       {
           //If a subdirectory can't be removed, it's because it has subdirectories, so recursiveRemoveDirectory is called again passing the subdirectory as path
           if(!@rmdir($subDir)) //@ suppress the warning message
           {
               recursiveRemoveDirectory($subDir);
           }
       }

       //Remove main directory
       rmdir($path);
   }
        
/**********************************************************************************/
        function backupOneDiscussArea
                        (       $DB_CONN, 
                                $begin_course_cd, 
                                $discuss_cd,
                                $RELEATED_PATH,
                                $IMAGE_PATH,
                                $CSS_PATH,
                                $JAVASCRIPT_PATH,
                                $FILE_PATH
                        )
        {       

                $GLOBAL_RELEATED_PATH = $RELEATED_PATH;
                $GLOBAL_IMAGE_PATH = $IMAGE_PATH;
                $GLOBAL_CSS_PATH = $CSS_PATH . "v2/";
                $GLOBAL_JAVASCRIPT_PATH = $JAVASCRIPT_PATH;
                $GLOBAL_FILE_PATH = $FILE_PATH;

                $LOCAL_RELEATED_PATH = $RELEATED_PATH;
                $LOCAL_IMAGE_PATH = $IMAGE_PATH;
                $LOCAL_CSS_PATH = $CSS_PATH;
                $LOCAL_JAVASCRIPT_PATH = $JAVASCRIPT_PATH;
                $LOCAL_FILE_PATH = $FILE_PATH;
                
                $absoluteURL = "";
                
                session_start();
                $personal_id = $_SESSION['personal_id'];                        //取得個人編號
                $role_cd = $_SESSION['role_cd'];                                        //取得角色
                
                if(!is_dir($LOCAL_FILE_PATH))                                   //當討論區都沒人使用過時匯出會出錯，所以加了這個
                        @mkdir($LOCAL_FILE_PATH);
                @mkdir($LOCAL_FILE_PATH . "$discuss_cd/");

/******************************************************************************************/
//備份資料庫的資料
        
                $SQL_TEMP_FILE_PATH =  $LOCAL_FILE_PATH . "$discuss_cd/";
        
                //開始output buffering
                ob_start();
                
                //產生一個MySqlDump物件
                //MySqlDump($DB_CONN, $showResult, $crlf, $create, $drop, $insert, $cmdEnd)
                $mysqldump = new MySqlDump($DB_CONN, 1, "\n", 0, 0, 1, ";");
                
                //dump要的資料
                $mysqldump->dumptablespecificdata("discuss_info", "\$filterResult = ((\$row[0] == $begin_course_cd) && (\$row[1] == $discuss_cd));");
                $mysqldump->dumptablespecificdata("discuss_subject", "\$filterResult = ((\$row[0] == $begin_course_cd) && (\$row[1] == $discuss_cd));");
                $mysqldump->dumptablespecificdata("discuss_content", "\$filterResult = ((\$row[0] == $begin_course_cd) && (\$row[1] == $discuss_cd));");
                
                //取得output buffer的資料
                $outputBuffer = ob_get_contents();
                
                //結束並清除output buffer
                ob_end_clean();
                
                $filePtr = fopen($SQL_TEMP_FILE_PATH . "data.sql", "w");
                fwrite($filePtr, $outputBuffer);
                fclose($filePtr);

/*****************************************************************************************/





/*****************************************************************************************
BEGIN:產生showArticleList.php的畫面
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
/*****************************************************************************************/

                $RELEATED_PATH = "";
                $IMAGE_PATH = "";
                $CSS_PATH = "";
                $JAVASCRIPT_PATH = "";
                $FILE_PATH = "";

                $ARTICLELIST_TEMP_FILE_PATH =  $LOCAL_FILE_PATH . "$discuss_cd/";
                

                //設定showArticleListTemplateNumber的值
                if( isset($showArticleListTemplateNumber) == false)
                {       
                        if( isset($_SESSION['showArticleListTemplateNumber']) == false)
                        {
                        
                                //註冊樣板編號到SESSION
                                $showArticleListTemplateNumber = 1;
                                $_SESSION['showArticleListTemplateNumber'] = $showArticleListTemplateNumber;
                        }
                        else
                        {
                                $showArticleListTemplateNumber = $_SESSION['showArticleListTemplateNumber'];
                        }
                }
                
                //取得頁碼
                $currentPageNumber = $_GET['currentPageNumber'];
                if( isset($currentPageNumber) == false) $currentPageNumber = 1;
                
                //取得排序的方式
                $sortby = $_GET['sortby'];
                if( isset($sortby) == false)    $sortby = 1;
                
                $tpl = new Smarty;
                $tpl->assign("imagePath", $IMAGE_PATH);
                $tpl->assign("cssPath", $CSS_PATH);
                $tpl->assign("javascriptPath", $JAVASCRIPT_PATH);
                $tpl->assign("absoluteURL", $absoluteURL);
        
                $tpl->assign("isDeleteOn", 0);  //是否允許刪除
                $tpl->assign("isCollectOn", 0); //是否允許收藏文章
        
                //輸出樣板編號
                $tpl->assign("showArticleListTemplateNumber", $showArticleListTemplateNumber);
        
                //輸出頁碼
                $tpl->assign("currentPageNumber", $currentPageNumber);
                
                //每頁顯示的文章數
                $pageArticleNumber = 10000;
        
                //輸出排序方式
                $tpl->assign("sortby", $sortby);
        
                $templateNumber = $showArticleListTemplateNumber;
                $templateNumber = 1;
                if($templateNumber == 1)
                {
                        //第一種樣板
        
                        //從Table discuss_subject搜尋所有的文章, 並做排序
                        switch($sortby)
                        {
                        case 1: //依照discuss_content_cd做排序
                                        $sql = "SELECT * FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd ORDER BY discuss_content_cd DESC";
                                        break;
                        case 2: //依照標題discuss_title做排序
                                        $sql = "SELECT * FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd ORDER BY discuss_title DESC";
                                        break;
                        case 3: //依照作者discuss_author做排序
                                        $sql = "SELECT * FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd ORDER BY discuss_author DESC";
                                        break;
                        case 4: //依照d_created做排序
                                        $sql = "SELECT * FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd ORDER BY d_created DESC";
                                        break;
                        case 5: //依照最後回覆d_replied做排序
                                        $sql = "SELECT * FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd ORDER BY d_replied DESC";
                                        break;
                        case 6: //依照觀看次數viewed做排序
                                        $sql = "SELECT * FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd ORDER BY viewed DESC";
                                        break;
                        case 7: //依照觀看次數reply_count做排序
                                        $sql = "SELECT * FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd ORDER BY reply_count DESC";
                                        break;
                        default://依照discuss_content_cd做排序
                                        $sql = "SELECT * FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd ORDER BY discuss_content_cd DESC";
                                        break;
                        }
                
                        $res = $DB_CONN->query($sql);
                        if (PEAR::isError($res))        die($res->getMessage());
                        
                        $articleNum = $res->numRows();
                        $tpl->assign("articleNum", $articleNum);
                        
                        
                        if($articleNum > 0)
                        {
                                $rowCounter = 0;
                                
                                while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
                                {       
                                        $articleData[$rowCounter] = $row;
                                        
                                        $rowCounter++;
                                }
                                $articleDataNumber = $rowCounter;
                                
                                
                                $articleListCounter = 0;
                                $articleListNumber = 0;
                                for($articleDataCounter = 0; $articleDataCounter<$articleDataNumber; $articleDataCounter++)
                                {
                                        //依照頁碼顯示資料, 過濾掉不顯示的資料
                                        if( $articleDataCounter < ($currentPageNumber-1)*$pageArticleNumber )   continue;
                                        if( $articleDataCounter >= ($currentPageNumber)*$pageArticleNumber )    continue;
                                
                                
                                        $author_personal_id_tmp = $articleData[$articleDataCounter][discuss_author];
                                        
                                        //從Table personal_basic尋找作者的名子或是暱稱
                                        $sql = "SELECT * FROM personal_basic WHERE personal_id=$author_personal_id_tmp";
                    $res = db_query($sql);
                                        $res->fetchInto($row, DB_FETCHMODE_ASSOC);
                                        if($row[nickname] != "")
                                        {
                                                $author = $row[nickname];
                                        }
                                        else
                                        {
                                                $author = $row[personal_name];
                                        }
                                        
                                        //將資料填入articleList中
                                        $articleList[$articleListCounter++] = 
                                                        array(
                                                                        "discuss_content_cd" => $articleData[$articleDataCounter][discuss_content_cd], 
                                                                        "discuss_title" => $articleData[$articleDataCounter][discuss_title], 
                                                                        "discuss_author" => $author, 
                                                                        "viewed" => $articleData[$articleDataCounter][viewed], 
                                                                        "reply_count" => $articleData[$articleDataCounter][reply_count],
                                                                        "d_created" => $articleData[$articleDataCounter][d_created], 
                                                                        "d_replied" => $articleData[$articleDataCounter][d_replied]
                                                                        );
                                }
                                $articleListNumber = $articleListCounter;
                                
                                //輸出文章標題列表
                                $tpl->assign("articleList", $articleList);
                
                
                
                                //從Table discuss_content搜尋回覆的文章資訊
                                $rowShowNumber = 5;     //最多顯示5筆
                                for($articleListCounter = 0; $articleListCounter<$articleListNumber; $articleListCounter++)
                                {
                                        //從Table discuss_content搜尋所有的文章, 依照回覆的日期做排序
                                        $sql = "SELECT * FROM discuss_content WHERE 
                                                                begin_course_cd=$begin_course_cd AND 
                                                                discuss_cd=$discuss_cd AND 
                                                                discuss_content_cd=" . $articleList[$articleListCounter][discuss_content_cd] . "
                                                                ORDER BY d_reply DESC"; 
                    $res = db_query($sql);
                                        
                                        $replyNum = $res->numRows();
                                        
                                        if($replyNum > 0)
                                        {
                                                $rowCounter = 0;                                
                        
                                                while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
                                                {       
                                                        $replyData[$rowCounter] = $row;
                                                        
                                                        $rowCounter++;
                                                        
                                                        if($rowCounter == $rowShowNumber)       break;
                                                }
                                                $replyDataNumber = $rowCounter;
                                                
                                                
                                                $replyListCounter = 0;
                                                for($replyDataCounter = 0; $replyDataCounter<$replyDataNumber; $replyDataCounter++)
                                                {                                               
                                                        $author_personal_id_tmp = $replyData[$replyDataCounter][reply_person];
                                                                
                                                        //從Table personal_basic尋找作者的名子或是暱稱以及個人資料
                                                        $sql = "SELECT * FROM personal_basic WHERE personal_id=$author_personal_id_tmp";
                            $res = db_query($sql);
                                                        
                                                        $res->fetchInto($row, DB_FETCHMODE_ASSOC);
                                                        if($row[nickname] != "")
                                                        {
                                                                $author = $row[nickname];
                                                        }
                                                        else
                                                        {
                                                                $author = $row[student_name];
                                                        }
                                                        
                                                        //放入文章資料以及個人資料
                                                        $replyList[$articleListCounter][$replyListCounter++] = 
                                                                                array(                                                                                  
                                                                                                "reply_content_cd" => $replyData[$replyDataCounter][reply_content_cd], 
                                                                                                "d_reply" => $replyData[$replyDataCounter][d_reply], 
                                                                                                "discuss_title" => $replyData[$replyDataCounter][discuss_title], 
                                                                                                "reply_person" => $author, 
                                                                                                "personal_home" => $personal_home
                                                                                                );
                                                }//end for($replyDataCounter = 0; $replyDataCounter<$replyDataNumber; $replyDataCounter++)
                                                
                                                //輸出回覆文章列表
                                                $tpl->assign("replyList", $replyList);
                                        }//end if($replyNum > 0)
                                }//end for($articleListCounter = 0; $articleListCounter<$articleListNumber; $articleListCounter++)
                
                        }
                }//end if($templateNumber == 1) //第一種樣板
                else if($templateNumber == 2)
                {
                        //第二種樣板
                        
                        //從Table discuss_content搜尋所有的文章, 依照回覆的日期做遞減排序
                        $sql = "SELECT * FROM discuss_content WHERE 
                                                        begin_course_cd=$begin_course_cd AND 
                                                        discuss_cd=$discuss_cd
                                                        ORDER BY d_reply DESC"; 
            $res = db_query($sql);
                        
                        $replyNum = $res->numRows();
                        $tpl->assign("replyNum", $replyNum);            //輸出回覆文章數
                        
                        
                        if($replyNum > 0)
                        {
                                $rowCounter = 0;                                
                        
                                while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
                                {       
                                        $replyData[$rowCounter] = $row;
                                                        
                                        $rowCounter++;
                                }
                                $replyDataNumber = $rowCounter;
                                
                                
                                $replyListCounter = 0;
                                for($replyDataCounter = 0; $replyDataCounter<$replyDataNumber; $replyDataCounter++)
                                {                                               
                                        $author_personal_id_tmp = $replyData[$replyDataCounter][reply_person];

                                        $file_picture_name_size = "";   
                                        if($replyData[$replyDataCounter][file_picture_name] != "")
                                        {         
                                                $file_picture_name_size = @filesize($FILE_PATH . $replyData[$replyDataCounter][file_picture_name]);
                                                $replyData[$replyDataCounter]['file_picture_name_size'] = $file_picture_name_size; 
                                        }
                                        //從Table personal_basic尋找作者的名子或是暱稱以及個人資料
                                        $sql = "SELECT * FROM personal_basic WHERE personal_id=$author_personal_id_tmp";
                    $res = db_query($sql);
                                        
                                        $res->fetchInto($row, DB_FETCHMODE_ASSOC);
                                        if($row[nickname] != "")
                                        {
                                                $author = $row[nickname];
                                        }
                                        else
                                        {
                                                $author = $row[student_name];
                                        }
                                        
                                        //放入文章資料以及個人資料
                                        $replyList[$replyListCounter++] = 
                                                                array(
                                                                                "replyListCounter" => $replyListCounter, 
                                                                                "discuss_content_cd" => $replyData[$replyDataCounter][discuss_content_cd],                                                                      
                                                                                "reply_content_cd" => $replyData[$replyDataCounter][reply_content_cd], 
                                                                                "d_reply" => $replyData[$replyDataCounter][d_reply], 
                                                                                "discuss_title" => $replyData[$replyDataCounter][discuss_title], 
                                                                                "reply_person" => $author, 
                                                                                "content_body" => nl2br($replyData[$replyDataCounter][content_body]), 
                                                                                "viewed" => $replyData[$replyDataCounter][viewed], 
                                                                                "file_picture_name" => $replyData[$replyDataCounter][file_picture_name],
                                                                                "file_picture_name_url" => $FILE_PATH . "" . $replyData[$replyDataCounter][file_picture_name],
                                                                                "file_picture_name_size" => $file_picture_name_size,
                                                                                "file_av_name" => $replyData[$replyDataCounter][file_av_name],
                                                                                "student_name" => $student_name,
                                                                                "nickname" => $nickname,
                                                                                "personal_home" => $personal_home,
                                                                                "photo" => $photo,
                                                                                "feedback" => $feedback
                                                                                );
                                }//end for($replyDataCounter = 0; $replyDataCounter<$replyDataNumber; $replyDataCounter++)
                                
                                //輸出回覆文章列表
                                $tpl->assign("replyList", $replyList);
                        }//end if($replyNum > 0)
                                
                                
                }//end if($templateNumber == 2) //第二種樣板
        
                //總共有幾頁
                $totalPageNumber = ceil($articleNum/$pageArticleNumber);        //無條件進位
                if($totalPageNumber == 0)       $totalPageNumber = 1;
                $tpl->assign("totalPageNumber",  $totalPageNumber);
        
                for($counter=0; $counter<$totalPageNumber; $counter++)
                {
                        $pageLinkList[$counter] = $counter+1;
                }
                $tpl->assign("pageLinkList", $pageLinkList);
        
                //目前的頁面
                $tpl->assign("currentPage", "showArticleList.php");
                
                if(isset($isShowSmartyTemplate) == 0)   $isShowSmartyTemplate = 1;
                if($isShowSmartyTemplate == 1)
                {
                        switch($templateNumber)
                        {
                                case 1:         $tplName = "/discuss_area/articleListBackup.tpl";       break;
                                //case 2:               $tplName = $template . "/discuss_area/articleList_bbs.tpl";     break;
                                default:        $tplName = "/discuss_area/articleListBackup.tpl";       break;
                        }
                }
                
                $web = fetchTemplate($tpl, $tplName);
                //echo $web;    //for test

                $filePtr = fopen($ARTICLELIST_TEMP_FILE_PATH . "showArticleList.html", "w");
                fwrite($filePtr, $web);
                fclose($filePtr);
                
                global $HOME_PATH;
                $tpl_path = $HOME_PATH . createTPLPath();       //php copy的指令 絕對路徑是依據作業系統
                //複製相關的檔案               
                @copy($tpl_path . "/css/tabs.css", $ARTICLELIST_TEMP_FILE_PATH . "tabs.css");
                @copy($tpl_path . "/css/content.css", $ARTICLELIST_TEMP_FILE_PATH . "content.css");
                @copy($tpl_path . "/css/table.css", $ARTICLELIST_TEMP_FILE_PATH . "table.css");
                @copy($tpl_path . "/css/form.css", $ARTICLELIST_TEMP_FILE_PATH . "form.css");

/*****************************************************************************************
END:產生showArticleList.php的畫面
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
/*****************************************************************************************/


/*****************************************************************************************
BEGIN:產生showArticle.php的畫面
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
/*****************************************************************************************/     
                $ARTICLE_TEMP_FILE_PATH = $ARTICLELIST_TEMP_FILE_PATH;
                @mkdir($ARTICLE_TEMP_FILE_PATH);
                
                for($articleListCounter = 0; $articleListCounter<$articleListNumber; $articleListCounter++)
                {
                        
                        $RELEATED_PATH = "../";
                        $IMAGE_PATH = "";
                        $CSS_PATH = "";
                        $FILE_PATH = "";
                        $absoluteURL = "";

                        $discuss_content_cd = $articleList[$articleListCounter][discuss_content_cd];
                        $reply_content_cd = $articleList[$articleListCounter][reply_content_cd];

                        $tpl = new Smarty;
                        $tpl->assign("imagePath", $IMAGE_PATH);
                        $tpl->assign("cssPath", $CSS_PATH);
                        $tpl->assign("absoluteURL", $absoluteURL);
                        
                        $tpl->assign("current_reply_content_cd", $reply_content_cd);
                        
                        //從Table discuss_content搜尋所有的文章, 依照parent的回覆文章編號做遞增排序(reply_conten_parentcd), 然後依照回覆文張編號做遞減排序(reply_content_cd)
                        $sql = "SELECT * FROM discuss_content WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd AND discuss_content_cd=$discuss_content_cd ORDER BY reply_conten_parentcd ASC, reply_content_cd DESC";  
            $res = db_query($sql);
                        
                        $replyNum = $res->numRows();
                        $tpl->assign("replyNum", $replyNum);
                        
                        if($replyNum > 0)
                        {
                                $rowCounter = 0;
                        
                                while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
                                {       
                                        $replyData[$rowCounter] = $row;
                                        
                                        $rowCounter++;
                                }
                                $replyDataNumber = $rowCounter;
                                
                                
                                $replyListTreeArrayNumber = 0;  //樹狀結構大小的初始值
                                for($replyDataCounter = 0; $replyDataCounter<$replyDataNumber; $replyDataCounter++)
                                {               
                                
                                        $author_personal_id_tmp = $replyData[$replyDataCounter][reply_person];
                                                
                                        //從Table personal_basic尋找作者的名子或是暱稱以及個人資料
                                        $sql = "SELECT * FROM personal_basic WHERE personal_id=$author_personal_id_tmp";
                    $res = db_query($sql);
                                        
                                        $res->fetchInto($row, DB_FETCHMODE_ASSOC);
                                        if($row[nickname] != "")
                                        {
                                                $author = $row[nickname];
                                        }
                                        else
                                        {
                                                $author = $row[personal_name];
                                        }
                                        $student_name = $row[student_name];
                                        $nickname = $row[nickname];
                                        $personal_home = $row[personal_home];
                                        $photo = $row[photo];
                                        $feedback = $row[feedback];
                                        
                                        //計算檔案的大小
                                        $file_picture_name_size = "";
                                        if($replyData[$replyDataCounter][file_picture_name] != "")
                                        {         
                                                $file_picture_name_size = @filesize($FILE_PATH . $replyData[$replyDataCounter][file_picture_name]);
                                                $replyData[$replyDataCounter]['file_picture_name_size'] = $file_picture_name_size; 
                                        }
                                        //產生一個ReplyListTreeArray的Entry
                                        $newReplyListTreeArrayEntry =
                                                                array(
                                                                        "level" => 0, 
                                                                        "reply_content_cd" => $replyData[$replyDataCounter][reply_content_cd], 
                                                                        "replyDataCounter" => $replyDataCounter, 
                                                                        "author" => $author, 
                                                                        "student_name" => $student_name, 
                                                                        "nickname" => $nickname, 
                                                                        "personal_home" => $personal_home, 
                                                                        "photo" => $photo, 
                                                                        "feedback" => $feedback
                                                                        );
                                        
                                        //儲存成樹狀的資料結構
                                        if($replyListTreeArrayNumber == 0)
                                        {
                                                $replyListTreeArray[0] = $newReplyListTreeArrayEntry;
                                        }
                                        else
                                        {
                                                //蒐尋父節點在replyListTreeArray的位置
                                                for(    $replyListTreeArrayCounter=0;
                                                                $replyListTreeArrayCounter<$replyListTreeArrayNumber; 
                                                                $replyListTreeArrayCounter++
                                                         )
                                                {
                                                        if($replyListTreeArray[$replyListTreeArrayCounter][reply_content_cd] == $replyData[$replyDataCounter][reply_conten_parentcd])
                                                        {
                                                                //設定資料的level
                                                                $newReplyListTreeArrayEntry[level] = $replyListTreeArray[$replyListTreeArrayCounter][level]+1;
                                                                
                                                                //將資料位置做調整
                                                                for($replyListTreeArrayMoveEntryCounter=$replyListTreeArrayNumber-1; 
                                                                        $replyListTreeArrayMoveEntryCounter>$replyListTreeArrayCounter; 
                                                                        $replyListTreeArrayMoveEntryCounter--
                                                                        )
                                                                {
                                                                        $replyListTreeArray[$replyListTreeArrayMoveEntryCounter+1] = $replyListTreeArray[$replyListTreeArrayMoveEntryCounter];
                                                                }
                                                                //將資料放到replyListTreeArray裡面
                                                                $replyListTreeArray[$replyListTreeArrayCounter+1] = $newReplyListTreeArrayEntry;
                                                                
                                                                break;
                                                        }
                                                }
                                        }
                                        $replyListTreeArrayNumber++;
                                }
                                
                                
                                //依照replyListTreeArray將資料放置到replyList
                                $currentReplyArrayNumber = 0;   //預設為顯示第一篇回覆的文章
                                $replyListCounter = 0;
                                $replyList = NULL;
                                for($replyListTreeArrayCounter=0; 
                                        $replyListTreeArrayCounter<$replyListTreeArrayNumber; 
                                        $replyListTreeArrayCounter++)
                                {
                
                                        //取得要顯示的回覆文章在replyList的位置
                                        if($reply_content_cd == $replyListTreeArray[$replyListTreeArrayCounter][reply_content_cd])      $currentReplyArrayNumber = $replyListCounter;
                        
                                        //echo $replyListTreeArray[$replyListTreeArrayCounter][level] . "<br>"; //for test
                                        
                                        //放入文章資料以及個人資料
                                        $replyList[$replyListCounter++] = 
                                                                array(
                                                                        "level" => $replyListTreeArray[$replyListTreeArrayCounter][level], 
                                                                        "reply_content_cd" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][reply_content_cd], 
                                                                        "d_reply" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][d_reply], 
                                                                        "discuss_title" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][discuss_title], 
                                                                        "reply_person" => $replyListTreeArray[$replyListTreeArrayCounter][author], 
                                                                        "content_body" => nl2br($replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][content_body]), 
                                                                        "viewed" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][viewed], 
                                                                        "file_picture_name" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][file_picture_name],
                                                                        "file_picture_name_url" => $FILE_PATH . "" . $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][file_picture_name],
                                                                        "file_picture_name_size" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][file_picture_name_size],
                                                                        "file_av_name" => $replyData[ $replyListTreeArray[$replyListTreeArrayCounter][replyDataCounter] ][file_av_name],
                                                                        "student_name" => $replyListTreeArray[$replyListTreeArrayCounter][student_name],
                                                                        "nickname" => $replyListTreeArray[$replyListTreeArrayCounter][nickname],
                                                                        "personal_home" => $replyListTreeArray[$replyListTreeArrayCounter][personal_home],
                                                                        "photo" => $replyListTreeArray[$replyListTreeArrayCounter][photo],
                                                                        "feedback" => $replyListTreeArray[$replyListTreeArrayCounter][feedback]
                                                                        );
                                }
                                $tpl->assign("replyList", $replyList);
                                
                                $tpl->assign("currentReplyArrayNumber", $currentReplyArrayNumber);
                                
                        }
                        
                        //目前的頁面
                        $tpl->assign("currentPage", "showArticle.php");
                        
                        $web = fetchTemplate($tpl, "/discuss_area/showArticleBackup.tpl");
                        //echo $web;    //for test
                        $filePtr = fopen($ARTICLE_TEMP_FILE_PATH . "showArticle" . $articleList[$articleListCounter][discuss_content_cd] . ".html", "w");
                        fwrite($filePtr, $web);
                        fclose($filePtr);
                }//end for($articleListCounter = 0; $articleListCounter<$articleListNumber; $articleListCounter++)
                
                //複製相關的檔案


                
/*****************************************************************************************
END:產生showArticle.php的畫面
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
******************************************************************************************
/*****************************************************************************************/
        }

?>

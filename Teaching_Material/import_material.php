<?php
/*author: lunsrot
 *date: 2007/11/29
 modify by:tgbsa
 */
require_once("../config.php");
require_once("../session.php");
checkMenu("/Teaching_Material/textbook_manage.php");
include "lib/textbook_mgt_func.inc";
include('../library/content.php');


if(!isset($_SESSION["lang"]))
    $_SESSION["lang"] = "zh_tw";

$lang = $_SESSION["lang"];

//well_print($_REQUEST);
//在import 進去後會新增
global $content_cd, $tid, $res_mapping,$Person,$lang; 

//老師id 
$tid = getTeacherId(); 

$Person = $_POST['person'];

$input = $_POST;
$content_type = $input['content_type'];


//判斷是http或者是ftp上傳
$upload_type = $input['upload_type'];

//ftp上傳,因為會先手動建立一份空的新教材這與跟http上傳不同
if($upload_type == 1){
    //取得教材名稱
    $materialName = db_getOne("select file_name from class_content where content_cd='{$_POST['content_cd']}' and menu_parentid = '0'");
}
import($input);

//template
//匯入的介面
function view($input)
{
    echo "hello";
/*		$tpl = new Smarty;
assignTemplate($tpl, "/teaching_material/import_material.tpl");*/
}

//function//匯入
function import($input)
{
    global $res_mapping ,$Person,$upload_type,$lang;

    $path = unrar_file() . "/";
    $f_name = "imsmanifest.xml";
    $n = $path . $f_name;

    if(!file_exists($n))
    {
        if($lang=="zh_tw")
            die("檔案有誤!<br>請檢查教材包是否含有imsmanifest.xml檔案<br>以及資料夾名稱不含特殊字元後再重新上傳教材!");
        else
            die("The file has error!<br>Please check material whether includes imsmanifest.xml file<br>and folder name can't include special characters, then upload material again!");
    }

    $dom = new DOMDocument();
    $dom->load($n);
    $org = $dom->getElementsByTagName("organization")->item(0);
    $res = $dom->getElementsByTagName("resources")->item(0);

    mapping_recourse($res);
    recursive_material($org, 0);


    sync_content_mediaStreaming_link( getTeacherId() ); 

    if($upload_type != 1)//http上傳 
        header("location: ./textbook_manage.php?person=".$Person);
    else
    {
        if($lang=="zh_tw")
            echo "目錄建立成功!";
        else
            echo "Directory created successfully!";
    }
    return;
}

//upload .rar file and 解壓縮至對應的資料夾
//return 資料夾路徑
function unrar_file()
{
    global $RAR_PATH, $PERSONAL_PATH, $DATA_FILE_PATH, $content_type , $upload_type, $tid , $materialName ,$the_content_name,$UNRAR_PATH;

    $pid = $tid ;
    //path : /home/???/WWW/Personal_File/$pid/
    //$path = $PERSONAL_PATH . $pid . "/";
    $path = getPersonalPath($pid) . '/';
    //確保目錄存在 如不存在則建立
    createPath($path);

    //new_path : /home/???/WWW/Data_File/$pid/textbook/
    $new_path = $DATA_FILE_PATH . $pid . "/textbook/";

    if($upload_type != 1){ //http上傳
        $fname = "material.rar";
        $name = $_FILES['material']['name'];
        //在Data_File/$pid/textbook/內已經存在則刪去
        if(file_exists($path . $fname))
            unlink($path . $fname);

        //確保Data_File/$pid/textbook/存在 
        createPath($new_path);

        //複製檔案到Personal_File/$pid/中
        if(!FILE_upload($_FILES['material']['tmp_name'], $path, $fname))
        {
            exit;
        }

        //產生justAtemp資料夾
        $old_umask = umask(0);
        mkdir("$DATA_FILE_PATH$pid/textbook/justAtemp",0775);
        umask($old_umask);

        //mkdir("$DATA_FILE_PATH$pid/textbook/justAtemp");
        $temp_target = "$DATA_FILE_PATH$pid/textbook/justAtemp/";

        //解壓縮到justAtemp資料夾	
        //joyce 0914 改解壓縮 語法
        $execstring = "$UNRAR_PATH x -o+ '$path$fname' '$temp_target'"; //ups所接受的解壓縮與法
        //$execstring = "$RAR_PATH x -o+ '$path$fname' '$temp_target'"; //16所接受的解壓縮與法
        exec($execstring);

        //取得rar內資料夾的名稱
        if (is_dir($temp_target)) {
            if ($dh = opendir($temp_target)) {
                while( ($file = readdir($dh)) !== false )  {
                    if( is_dir($temp_target."/".$file) && $file !="." &&  $file !=".."){
                        $the_content_name = $file ; 
                        break;
                    }
                }
            }
            closedir($dh);
        }
        //轉換編碼
        $new_content_name = iconv('big5','utf-8',$the_content_name);

        //將justAtemp內的教材移動到上一層目錄中
        //joyce 0726 改mv 語法 
        // $execstring = "mv '$temp_target$the_content_name' '$temp_target../{$new_content_name}'";
        $execstring = "cd $temp_target ;mv $the_content_name ../{$new_content_name}";
        $the_content_name = $new_content_name;
        exec($execstring);

        //移除掉justAtemp目錄
        $execstring = "rm -rf '$temp_target'";
        if(!strstr($execstring,"../"))
        {
            system_log($execstring);
            exec($execstring);
        }

        //刪除上傳之檔案
        unlink($path . $fname);
            /*

            else if($content_type == 2)
                return $new_path . substr($name, 0, strlen($name) - strlen("_scorm_2004.rar"));
            else
                return $new_path . substr($name, 0, strlen($name) - strlen(".rar"));
             */
        //回傳實際教材的路徑資訊

         $execstring = "chmod -R 775 ".$new_path.$the_content_name;
         exec($execstring);

        return $new_path.$the_content_name;

    }
    else //ftp 上傳==============================================================================================================
    { 
        $fname = $_POST['selMaterial'];
        //查看textbook下是否有相同名稱的檔案,如果有則刪去

        createPath($new_path);

        mkdir("$DATA_FILE_PATH$pid/textbook/justAtemp",0775);
        $temp_target = "$DATA_FILE_PATH$pid/textbook/justAtemp/";

        //joyce 0914 改解壓縮 語法
        $execstring = "$UNRAR_PATH x -o+  '$new_path$fname' '$temp_target'"; //ups所接受的解壓縮與法
        //$execstring="$RAR_PATH x -o+ '$new_path$fname' '$temp_target'"; //16所接受的解壓縮與法
        exec($execstring);

        //取得rar內資料夾的名稱(教材目錄名稱)
        if (is_dir($temp_target)) {
            if ($dh = opendir($temp_target)) {
                while( ($file = readdir($dh)) !== false )  {
                    if( is_dir($temp_target."/".$file) && $file !="." &&  $file !=".."){
                        $the_content_name = $file ; 
                        break;
                    }
                }
            }
            closedir($dh);
        }

        if(trim($the_content_name) != "")
        {
            $execstring="rm -rf '{$DATA_FILE_PATH}{$_SESSION['personal_id']}/textbook/{$the_content_name}'";
            if(!strstr($execstring,"../"))
            {
                system_log($execstring);
                exec($execstring);
            }

            //刪除因為手動新增教材而建立的目錄
            if(trim($materialName) != "")
            {
                $execstring="rm -rf '{$DATA_FILE_PATH}{$_SESSION['personal_id']}/textbook/{$materialName}'";
                if(!strstr($execstring,"../"))
                {
                    system_log($execstring);
                    exec($execstring);
                }

            }

            //轉換編碼
            $new_content_name = iconv('big5','utf-8',$the_content_name);

            //將justAtemp內的教材移動到上一層目錄中
            //joyce 0914 改mv 語法 
            // $execstring = "mv '$temp_target$the_content_name' '$temp_target../{$new_content_name}'";
            $execstring = "cd $temp_target ;mv $the_content_name ../{$new_content_name}";
            $the_content_name = $new_content_name;
            exec($execstring);

            //$test_str .=  $execstring."<br>";

            //移除掉justAtemp目錄
            $execstring="rm -rf '$temp_target'";
            if(!strstr($execstring,"../"))
            {
                system_log($execstring);
                exec($execstring);
            }

            //$test_str .=  $execstring."<br>";

        }
        //rmdir($temp_target);
        unlink($new_path . $fname);

        //die($test_str."<br>".$new_path.$the_content_name);
        
         $execstring = "chmod -R 775 ".$new_path.$the_content_name;
         exec($execstring);

        return $new_path.$the_content_name;
    }

}

function mapping_recourse($element)
{
    global $res_mapping ; 

    for($i = 0 ; $i < $element->childNodes->length ; $i++) {
        $item_it = $element->childNodes->item($i);

        if( $item_it->nodeName == "resource" ){
            $res_id = $item_it->getAttribute('identifier');
            $res_path = $item_it->getAttribute('href');
            $res_mapping[ $res_id ] = $res_path ; 

        }
    }
}

//library
//遞迴將樹狀教材結構印出
function recursive_material($node, $parent){
    global $content_type, $content_cd,  $tid , $upload_type , $the_content_name;


    //echo "Num Nodes :" .$node->childNodes->length ; 
    for($i = 0 ; $i < $node->childNodes->length ; $i++)
    {
        $item_it = $node->childNodes->item($i);


        if( $item_it->nodeName == 'title') 
        {
            $the_nodeName = $item_it->nodeValue;
            $node_res_id = $node->getAttribute('identifierref');


            if( $parent == 0 ) { //樹狀節點的教材名稱(那個電腦圖示)

                //http
                if($upload_type != 1){	
                    //db_query("insert into `course_content` (content_name, teacher_cd, difficulty, content_type, is_public) values ('$nodeName', $tid, '0', '0', '0');");
                    db_query("insert into `course_content` (content_name, teacher_cd, datetime ,difficulty, content_type, is_public) values ('$the_content_name','$tid', NOW(), '0', '0', '0');");


                    $content_cd = db_getOne("select content_cd from `course_content` where content_name='$the_content_name' and teacher_cd='$tid' ORDER BY `content_cd` DESC LIMIT 0,1;");			

                    //add by joyce 20110511
                    $sql = "insert into content_download (content_cd, is_download, download_role, packet_type, license, announce, rule, memo) 
                        value('$content_cd','0','0',0,'','','',NULL);";
                    db_query($sql);

                    //ftp 上傳不重新產生一個content_cd
                }else{ 
                    $content_cd = $_POST['content_cd'];
                }

            }
            $parent_next = insert_class_content($parent, $the_nodeName, $node_res_id );		
        }
        if($item_it->nodeName == "item" ){ // 如果是<item>則recurseive 
            recursive_material($item_it, $parent_next);
        }
    }
}

//library
//將資料加入class_content
function insert_class_content($parent, $node_caption, $node_res_id ){
    global $content_cd, $res_mapping , $upload_type  , $the_content_name; 

    $menu_id = get_max_menu_id();
    $seq = ret_new_textbook_seq($parent,$content_cd);
    if($parent == 0){	
        if($upload_type == 1){//ftp

            $node_caption  = $the_content_name;
            $res_mapping[ $node_res_id ] = $the_content_name;
            //ftp上傳刪除所有關於本教材的內容
            $sql = "delete from class_content where content_cd='{$_POST['content_cd']}'";
            db_query($sql);
        }
        else{//http
            $node_caption  = $the_content_name;
            $res_mapping[ $node_res_id ] = $the_content_name;
        }
    }
    $sql = "insert into `class_content` (content_cd, menu_id, menu_parentid, caption, file_name, seq) values ('$content_cd', '$menu_id', '$parent', '$node_caption', '{$res_mapping[ $node_res_id ]}', '$seq');";
    //echo "$sql.<br>";
    db_query($sql);

    if($parent == 0 ){
        db_query("update `class_content` set url='tea_start.php?content_cd=$content_cd', exp='1', icon='' where menu_id='$menu_id';");
    }else{
        db_query("update `class_content` set url='tea_textbook_content.php?content_cd=$content_cd&menu_id=$menu_id', exp='0', icon='/script/nlstree/img/folder.gif' where menu_id='$menu_id';");
    }
    return $menu_id; 
}

?>

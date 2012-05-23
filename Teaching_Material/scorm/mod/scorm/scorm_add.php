<?php 

//ini_set(display_errors, 1);
//error_reporting(E_ALL);    
//This should be scorm's config.php
include_once('../../config.php'); 
include_once('locallib.php');
include_once('lib.php'); 


$s_name=$_REQUEST['scorm_name'];//name
$f_file=$_FILES['import_file4']['name'];//reference
$temp_file= $_FILES['import_file4']['tmp_name'];
$teacher_cd = $_REQUEST['teacher_cd'];
$begin_course_cd = $_REQUEST['begin_course_cd'];
$data ["MAX_FILE_SIZE"]=$_FILES['import_file4']['size']."";//有錯
$data["name"]=$s_name;
$data["summary"]=$s_name."summary";
$data["reference"]=$f_file;
$data["grademethod"]="1";
$data["maxgrade"]="100";
$data["maxattempt"]="0";
$data["whatgrade"]="0";
$data["mform_showadvanced_last"]="";
$data["width"]="100"; 
$data["height"]="500"; 
$data["popup"]="0"; 
$data["skipview"]="0";
$data["hidebrowse"]="0";
$data["hidetoc"]="0";
$data["hidenav"]="0";
$data["auto"]="0";
$data["updatefreq"]="0";
$data["datadir"]="";
$data["pkgtype"]=""; 
$data["launch"]=""; 
//$data["redirect"]="yes";
//$data["redirecturl"]="../course/view.php?id=8";
$data["visible"]= "1";
$data["cmidnumber"]="";
$data["gradecat"]=$begin_course_cd;
$data["course"]= $begin_course_cd;
$data["coursemodule"]="0";
$data["section"]= "0";
$data["module"]= "15";
$data["modulename"]="scorm";
$data["instance"]= "0";
$data["add"]="scorm";
$data["update"]="0";
$data["return"]="0";
$data["submitbutton2"]= "Save and return to course";
//$data["sesskey"]="vXV0WaZ2A9";
//$data ["_qf__mod_scorm_mod_form"]="1";
/*判斷mdl_course這個table有沒有這個begin_course_cd
 *有，代表這門課曾匯過moodle可以吃的scorm
 *沒有，代表從未匯過，需要新增
 */
$sql = "select id  from  mdl_course  where id = '$begin_course_cd'";
$mdl_course_id= db_getOne($sql);
if(!isset($mdl_course_id))
{
    $sql = "select max(sortorder)  from  mdl_course ";
    $max_sortorder=db_getOne($sql);
    if(empty($max_sortorder))
    {
        $sortorder=2000;//照moodle的值setting
    }
    else
    {
        $sortorder=$max_sortorder-1;
    }
    //新增一筆至mdl_course
   $summary=$data["summary"];
   $sql ="insert into mdl_course (id,category,sortorder,summary,format)
         values ($begin_course_cd,1,$sortorder,'$summary','scorm')";
    db_query($sql);
}
/*
 *下面的為scorm_validate($data)這個函式 
 * 功能為檢查上傳的scorm教材包是否正確
 */

    global $CFG;
    $validation = new stdClass();
    $validation->errors = array();

    if (!isset($data['course']) || empty($data['course'])) {
        $validation->errors['reference'] = get_string('missingparam','scorm');
        $validation->result = false;
        return $validation;
    }
    $courseid = $data['course'];                  // Course Module ID

    if (!isset($data['reference']) || empty($data['reference'])) {
        $validation->errors['reference'] = get_string('packagefile','scorm');
        $validation->result = false;
        return $validation;
    }
    $reference = $data['reference'];              // Package/manifest path/location

    $scormid = $data['instance'];                 // scorm ID
    $scorm = new stdClass();
    if (!empty($scormid)) {
        if (!$scorm = get_record('scorm','id',$scormid)) {
            $validation->errors['reference'] = get_string('missingparam','scorm');
            $validation->result = false;
            return $validation;
        }
    }
    //¤W¶Çªºscorm¥]ÀÉ¦Wªº²Ä¤@­Ó¦r
    if ($reference[0] == '#') {
        if (isset($CFG->repositoryactivate) && $CFG->repositoryactivate) {
            $reference = $CFG->repository.substr($reference,1).'/imsmanifest.xml';
        } else {
            $validation->errors['reference'] = get_string('badpackage','scorm');
            $validation->result = false;
            return $validation;
        }
    } else if (!scorm_external_link($reference)) {
        $reference = $CFG->dataroot.'/'.$courseid.'/'.$reference;
    }
    
    // Create a temporary directory to unzip package or copy manifest and validate package
    $tempdir = '';
    $scormdir = '';
    if ($scormdir = make_upload_directory("$courseid/$CFG->moddata/scorm")) {
        if ($tempdir = scorm_tempdir($scormdir)) {
            //
            $scorm->datadir= substr ($tempdir,strlen($scormdir));
            $localreference = $tempdir.'/'.basename($reference);
            /*
            ex:
            $reference=$CFG->dataroot/$courseid/上傳檔名
            $localreference=$CFG->dataroot/$courseid/$tempdir/上傳檔名
            */
            copy("$temp_file","$reference");
            copy ("$reference", $localreference);

            if (!is_file($localreference)) {
                $validation->errors['reference'] = get_string('badpackage','scorm');
                $validation->result = false;
            } else{
                $ext = strtolower(substr(basename($localreference),strrpos(basename($localreference),'.')));
                switch ($ext) {
                    case '.pif':
                    case '.zip':
                        if (!unzip_file($localreference, $tempdir, false)) {
                            $validation->errors['reference'] = get_string('unziperror','scorm');
                            $validation->result = false;
                        } else {
                            //delete $localreference
                            unlink ($localreference);
                            if (is_file($tempdir.'/imsmanifest.xml')) {
                                $validation = scorm_validate_manifest($tempdir.'/imsmanifest.xml');
                                $validation->pkgtype = 'SCORM';
                            } else {
                                $validation = scorm_validate_aicc($tempdir);
                                if (($validation->result == 'regular') || ($validation->result == 'found')) {
                                    $validation->pkgtype = 'AICC';
                                } else {
                                    $validation->errors['reference'] = get_string('nomanifest','scorm');
                                    $validation->result = false;
                                }
                            }
                        }
                    break;
                    case '.xml':
                        if (basename($localreference) == 'imsmanifest.xml') {
                            $validation = scorm_validate_manifest($localreference);
                        } else {
                            $validation->errors['reference'] = get_string('nomanifest','scorm');
                            $validation->result = false;
                        }
                    break;
                    default:
                        $validation->errors['reference'] = get_string('badpackage','scorm');
                        $validation->result = false;
                    break;
                }
            }
            if (is_dir($tempdir)) {
            // Delete files and temporary directory
                //scorm_delete_files($tempdir);
             
            }
        } else {
            $validation->errors['reference'] = get_string('packagedir','scorm');
            $validation->result = false;
        }
    } else {
        $validation->errors['reference'] = get_string('datadir','scorm');
        $validation->result = false;
    }
    /*
    ex:$validation
    object(stdClass)#325 (2) { ["result"]=> bool(true) ["pkgtype"]=> string(5) "SCORM" } 
    */
if($validation->result==false){
  echo "檔案格式有誤，上傳失敗";
  exit();
}
/*****scorm_validate($data) end*******************************************************************/
/*再呼叫lib裡的scorm_add_instance;*/

        $scorm->pkgtype = $validation->pkgtype;
       //tmp mark:有問題，launch先設0,parse先設1
        $scorm->launch = 0;
        $scorm->parse = 1;
        $scorm->timemodified = time();
     
        $scorm->course=$data["course"];
        $scorm->name=$data["name"];
        $scorm->reference=$data["reference"];
        $scorm->summary=$data["summary"];
        $scorm->maxgrade=$data["maxgrade"];
        $scorm->grademethod=$data["grademethod"];
        $scorm->whatgrade=$data["whatgrade"];
        $scorm->maxattempt=$data["maxattempt"];
        $scorm->updatefreq=$data["updatefreq"];
        $scorm->width=$data["width"];
        $scorm->height=$data["height"];
        // tmp mark:moodle裡面走if
        /*有問題*/
       /*if (!scorm_external_link($scorm->reference)) {
           $scorm->md5hash = md5_file($scorm->datadir.'/'.$scorm->reference);
      
       } else {
            $scorm->dir = $CFG->dataroot.'/'.$scorm->course.'/moddata/scorm';
            $scorm->md5hash = md5_file($scorm->dir.$scorm->datadir.'/'.basename($scorm->reference));
       }*/
        $scorm = scorm_option2text($scorm);
        $scorm->width = str_replace('%','',$scorm->width);
        $scorm->height = str_replace('%','',$scorm->height);

        //sanitize submitted values a bit
        $scorm->width = clean_param($scorm->width, PARAM_INT);
        $scorm->height = clean_param($scorm->height, PARAM_INT);
        if (!isset($scorm->whatgrade)) {
            $scorm->whatgrade = 0;
        }
        $scorm->grademethod = ($scorm->whatgrade * 10) + $scorm->grademethod;

        $id = insert_record('scorm', $scorm);
        if (scorm_external_link($scorm->reference) || ((basename($scorm->reference) != 'imsmanifest.xml') && ($scorm->reference[0] != '#'))) {
            // Rename temp scorm dir to scorm id
            $scorm->dir = $CFG->dataroot.'/'.$scorm->course.'/moddata/scorm';
            if (file_exists($scorm->dir.'/'.$id)) {
                //delete directory as it shouldn't exist! - most likely there from an old moodle install with old files in dataroot
                scorm_delete_files($scorm->dir.'/'.$id);
            }
            $str_p = $id.".zip";
            $file_name = str_replace($f_file,$str_p,$reference);
            //var_dump($file_name);
            // rename (string oldname, string newname)
            rename($scorm->dir.$scorm->datadir,$scorm->dir.'/'.$id);
             if(file_exists($reference))
                rename($reference,$file_name);//把原來.zip名稱改成id.zip
        
        }

        // Parse scorm manifest
        if ($scorm->parse == 1) {
            $scorm->id = $id;
            $scorm->launch = scorm_parse($scorm);
            set_field('scorm','launch',$scorm->launch,'id',$scorm->id);
        }
        //grade table
       //scorm_grade_item_update(stripslashes_recursive($scorm));
/*============================================================================*/
/*
 *複製SCORM教材到Data_File/teacher_cd
 */
//smartCopy($scorm->dir . '/' .  $scorm->id , '../../../../Data_File/' . $teacher_cd.'/textbook/');
//echo"上傳成功&nbsp;&nbsp;<img src='../../../../themes/IE2/images/icon/return.gif' /><a href='../../../textbook_manage.php'>返回教材管理工具</>";
echo"上傳成功";        
/*============================================================================*/
/* 
 * 在上傳教材成功之後，把一些cyberccu2中的有關教材用的table，
 */
//pub 及 difficulty 參考原本的table，預設都是 0 
$pub=0;
$difficulty=0;

$sql = "select version from  mdl_scorm where id = $id";
$temp_scorm_version = db_getOne($sql);
switch($temp_scorm_version){
case 'SCORM_1.2':
  $scorm_version = 3 ; 
  break;
case 'SCORM_1.3':
    $scorm_version = 4 ; 
  break;
  //case AICC 應該用不到，暫時給他值為 5 
case 'AICC':
  $scorm_version = 5 ; 
  break;
  // default是其它類，給值為 2
default:
  $scorm_version = 2 ; 
}
/*
 * 暫時將course_content 中的 content_name的儲存格式定為scorm+scorm_name+scorm_id
 */
$tmp_s_name = 'scorm_'.$s_name . '_' .  $id ;
$sql = "insert into course_content 
  (content_cd, content_name, teacher_cd,datetime,difficulty, content_type, is_public)
  values ('', '$tmp_s_name','$teacher_cd',now(),'$difficulty', '$scorm_version', '$pub');";
db_query($sql);

// add by joyce 20110511
    $content_cd = db_getOne("select content_cd from `course_content` where content_name='$tmp_s_name' and teacher_cd='$teacher_cd';"); 
    $sql = "insert into content_download (content_cd, is_download, download_role , packet_type, license, announce, rule, memo)
        value('$content_cd','0','0','$scorm_version','','','',NULL);";  
    db_query($sql);
 
    
/*
 *將最新上傳的scorm檔指定為教材
 */
$this_content_cd= mysql_insert_id();
$sql ="delete from class_content_current where begin_course_cd = $begin_course_cd";
db_query($sql);
$sql ="insert into class_content_current 
  (begin_course_cd, content_cd)
  values ($begin_course_cd, $this_content_cd)";
db_query($sql);
/*
 *將content_cd寫入mdl_scorm (利用content_cd將mdl_scorm和course_content做關聯)
 */
$sql ="update mdl_scorm set content_cd = $this_content_cd where id=$id;"; 
db_query($sql);
/*============================================================================*/
/*因為player.php會用到mdl_course和mdl_course_module
 *所以需寫記錄給mdl_course_module和mdl_course
 */
//mdl_course_module
$sql ="insert into mdl_course_modules 
  (course,module,instance,section)
  values ($begin_course_cd,15,$id,0)";
db_query($sql);
?>              


